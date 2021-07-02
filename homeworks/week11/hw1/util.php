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
      header("Location: login.php?errCode=2"); // 查無帳號
      die();
    }
    $row = $result->fetch_assoc();
    if (!password_verify($pass, $row['pass'])) {
      header("Location: login.php?errCode=2"); // 密碼錯誤
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
      SELECT U.username, U.nickname, C.content, C.created_at
      FROM `sixwings-comments` AS C LEFT JOIN `sixwings-users` AS U
      ON C.user_id = U.id
      ORDER BY C.id DESC
    BLOCK;
    $result = $conn->query($sql);
    if (!$result) {
      die($conn->error);
    }
    return $result;
  }

  // 轉義文字: 防止 XSS
  function escape($str) {
    return htmlspecialchars($str, ENT_QUOTES);
  }
?>
