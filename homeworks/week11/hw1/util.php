<?php
  require_once("conn.php");
  
  function is_session_started() {
    return session_status() === PHP_SESSION_ACTIVE;
  }

  function is_login() {
    return is_session_started() && isset($_SESSION) && !empty($_SESSION['username']);
  }

  function set_user_session($username, $user_id) {
    if (is_session_started()) {
      $_SESSION['username'] = $username;
      $_SESSION['user_id'] = $user_id;
    }
  }
  
  function is_admin() {
    $role = get_role();
    return is_login() && $role["role_name"] === "admin";
  }

  // username => user
  function get_user_from_username($username) {
    global $conn;
    $sql = "SELECT * FROM `sixwings-users` WHERE username = ? LIMIT 1;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $result = $stmt->execute();
    return ($result) ? $stmt->get_result()->fetch_assoc() : false;
  }

  // session => username
  function get_username() {
    return is_login() ? $_SESSION['username'] : '';
  }

  function add_user() {
    if (
      empty($_POST['nickname']) ||
      empty($_POST['username']) ||
      empty($_POST['pass'])
    ) {
      header("Location: register.php?errCode=1");
      die('some column is empty');
    }
    global $conn;
    $nickname = $_POST['nickname'];
    $username = $_POST['username'];
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $sql = "INSERT INTO `sixwings-users` (nickname, username, pass) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $nickname, $username, $pass);
    $result = $stmt->execute();
    if (!$result) {
      header("Location: register.php?errCode=2");
      die($conn->error);
    }
    login();
  }
  
  // session => username => user
  function get_user() {
    $username = get_username();
    return ($username) ? get_user_from_username($username) : false;
  }
  
  function login() {
    if (!is_session_started()) {
      return;
    }
    // 檢查是否有輸入資料
    if ( empty($_POST['username']) || empty($_POST['pass'])) {
      header("Location: login.php?errCode=1");
      die('some column is empty');
    }
    global $conn;
    $username = $_POST['username'];
    $pass = $_POST['pass'];
    $sql = "SELECT `id`, `pass` FROM `sixwings-users` WHERE `username` = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $result = $stmt->execute();
    $result = ($result) ? $stmt->get_result() : false;
    if (!$result || $result->num_rows === 0) { // 把 $result == false 的情況也過濾掉
      header("Location: login.php?errCode=10"); // 查無帳號
      die();
    }
    $row = $result->fetch_assoc();
    if (!password_verify($pass, $row['pass'])) {
      header("Location: login.php?errCode=10"); // 密碼錯誤
      die();
    }
    set_user_session($username, $row['id']);
    header("Location: index.php");
  }

  function logout() {
    if(!is_login()) {
      die('no login');
    }
    session_destroy(); // 清空內容，但 cookie 仍然保留 session_id
    header("Location: index.php");
  }

  function get_role() {
    global $conn;
    $user_id = (is_login()) ? $_SESSION['user_id'] : 1; // 1: guest user
    $sql = <<<BLOCK
      SELECT U.id AS viewer_id, role_name, edit_range, del_range
      FROM `sixwings-roles` AS R
      JOIN `sixwings-users` AS U
      ON U.role = R.role_id
      WHERE U.id = ?;
BLOCK;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $result = $stmt->execute();
    if (!$result) {
      die();
    }
    return $stmt->get_result()->fetch_assoc();
  }

  function add_comment() {
    if(!is_login()) {
      die('no login');
    }
    if (empty($_POST['content'])) { //檢查是否有輸入資料
      header("Location: index.php?errCode=1");
      die('請輸入 content');
    }
    global $conn;
    $username = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
    $content = $_POST['content'];
    $sql = "INSERT INTO `sixwings-comments` (user_id, content) VALUES (?, ?);";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $user_id, $content);
    $result = $stmt->execute();
    if (!$result) {
      header("Location: index.php?errCode=2");
      die($conn->error);
    }
    header("Location: index.php");
  }

  function get_comments() {
    global $conn;
    $sql = <<<BLOCK
      SELECT *
      FROM `sixwings-v_comments` AS C
      ORDER BY C.id DESC
BLOCK;
    $result = $conn->query($sql);
    if (!$result) {
      die('no result');
    }
    return $result;
  }
  
  function get_comment($id) {
    global $conn;
    $sql = <<<BLOCK
      SELECT *
      FROM
        (SELECT
          id,
          owner_id,
          username,
          nickname,
          content,
          created_at
        FROM `sixwings-v_comments`) AS C
      WHERE C.id = ?
BLOCK;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $result = $stmt->execute();
    if (!$result) {
      return false;
    }
    $result = $stmt->get_result();
    return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : false;
  }
  
  function edit_comment() {
    if(!is_login()) {
      header("Location: index.php?errCode=0");
      die();
    }
    if (empty($_POST['id']) || empty($_POST['content'])) { //檢查是否有輸入資料
      header("Location: index.php?errCode=5");
      die();
    }
    global $conn;
    $role = get_role();
    $comment = get_comment($_POST['id']);
    if (!$comment) {
      header("Location: index.php?errCode=4");
      die();
    }
    if (($role['viewer_id'] !== $comment['owner_id'] && $role['edit_range'] === 'OWN') || ($role['edit_range'] === 'NONE')) {
      header("Location: index.php?errCode=2");
      die();
    }

    $id = $_POST['id'];
    $content = $_POST['content'];
    $sql = <<<BLOCK
      UPDATE `sixwings-comments` AS C
      SET C.content = ?
      WHERE C.is_del = 0 AND C.id = ?;
BLOCK;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si',$content, $id);
    $result = $stmt->execute();
    if (!$result) {
      // TODO 一致性的錯誤處理
      die();
    }
    header("Location: index.php");
  }

  function del_comment() {
    if(!is_login()) {
      header("Location: index.php?errCode=0");
      die();
    }
    if (empty($_GET['id'])) { //檢查是否有輸入資料
      header("Location: index.php?errCode=5");
      die();
    }
    global $conn;
    $role = get_role();
    $comment = get_comment($_GET['id']);
    if (!$comment) {
      header("Location: index.php?errCode=4");
      die();
    }
    if (($role['viewer_id'] !== $comment['owner_id'] && $role['del_range'] === 'OWN') || ($role['del_range'] === 'NONE')) {
      header("Location: index.php?errCode=3");
      die();
    }

    $id = $_GET['id'];
    $sql = <<<BLOCK
      UPDATE `sixwings-comments` AS C
      SET C.is_del = 1
      WHERE C.is_del = 0 AND C.id = ?;
BLOCK;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $result = $stmt->execute();
    if (!$result) {
      // TODO 一致性的錯誤處理
      die();
    }
    if ($stmt->affected_rows === 0) {
      header("Location: index.php?errCode=4");
    }
    header("Location: index.php");
  }

  // #later support paging
  function get_user_role_info() {
    if (!is_admin()) {
      header("Location: index.php"); // 直接返回
      die();
    }
    global $conn;
    $sql = <<<BLOCK
      SELECT U.id, U.username, U.nickname, role_id, role_name, `add`, edit_range, del_range
      FROM `sixwings-users` AS U
      LEFT JOIN `sixwings-roles` AS R ON R.role_id = U.role
BLOCK;
    $result = $conn->query($sql);
    if (!$result) {
      die('no result');
    }
    return $result;
  }

  function set_user_role() {
    if (!is_admin()) {
      header("Location: index.php"); // 直接返回
      die();
    }
    if (!isset($_POST['role']) ||
        !isset($_POST['user_id'])) { // 檢查是否有輸入資料
      header("Location: user_management.php?errCode=1");
      die();
    }
    if (($_POST['user_id']) === "0") { // 無法修改 0 號使用者 (管理者) 帳號身分
      header("Location: user_management.php?errCode=2");
      die();
    }
    global $conn;
    $user_id = intval($_POST['user_id']);
    $role = intval($_POST['role']);
    $sql = <<<BLOCK
      UPDATE `sixwings-users` AS U
      SET U.role = ?
      WHERE U.id != 0 AND U.id = ?;
BLOCK;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $role, $user_id);
    $result = $stmt->execute();
    if (!$result) {
      // TODO 一致性的錯誤處理
      die();
    }
    if ($stmt->affected_rows === 0) {
      header("Location: user_management.php?errCode=3");
    }
    header("Location: user_management.php");
  }
  
  function get_page_info() {
    global $conn;
    $sql = <<<BLOCK
SELECT
COUNT(id) AS count,
CEIL(COUNT(id) / 10) AS num_pages
FROM `sixwings-comments` WHERE is_del = 0;
BLOCK;
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute();
    if (!$result) {
      die('no result');
    }
    return $stmt->get_result()->fetch_assoc();
  }

  // 轉義文字: 防止 XSS
  function escape($str) {
    return htmlspecialchars($str, ENT_QUOTES);
  }
?>