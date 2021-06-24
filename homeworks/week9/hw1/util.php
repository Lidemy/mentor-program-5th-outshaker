<?php
  require_once("conn.php");
  
  function is_session_started() {
    return session_status() === PHP_SESSION_ACTIVE;
  }

  function is_login() {
    return is_session_started() && isset($_SESSION) && !empty($_SESSION['username']);
  }

  function set_session_username($username) {
    if (is_session_started()) {
      $_SESSION['username'] = $username;
    }
  }

  // username => user
  function get_user_from_username($username) {
    global $conn;
    $sql = "SELECT * FROM `sixwings-users` WHERE username = '{$username}' LIMIT 1;";
    $result = $conn->query($sql);
    return ($result) ? $result->fetch_assoc() : false;    
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
    $pass = $_POST['pass'];
    $sql = "INSERT INTO `sixwings-users` (nickname, username, pass, created_at) VALUES ('{$nickname}','{$username}', '{$pass}', now())";
    $result = $conn->query($sql);
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
    $sql = "SELECT * FROM `sixwings-users` WHERE `username` = '{$username}' AND `pass` = '{$pass}' LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows === 0) {
      header("Location: login.php?errCode=2");
      die('無此帳號或密碼錯誤');
    }
    set_session_username($username);
    echo $_SESSION['username'];
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
    $username = get_username();
    $content = $_POST['content'];
    $sql = "INSERT INTO `sixwings-comments` (username, content, created_at) VALUES ('{$username}','{$content}', now())";
    $result = $conn->query($sql);
    if (!$result) {
      die($conn->error);
    }
    header("Location: index.php");
  }

  function get_comments() {
    global $conn;
    $sql = "SELECT * FROM `sixwings-comments` ORDER BY created_at DESC";
    $result = $conn->query($sql);
    
    if (!$result) {
      die($conn->error);
    }
    return $result;
  }
?>
