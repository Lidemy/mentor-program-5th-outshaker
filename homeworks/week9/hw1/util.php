<?php
  require_once("conn.php");
  
  function isLogin() {return !empty($_COOKIE['token']); }

  function generateToken() {
    $s = '';
    for($i=1; $i<=16; $i++) {
      $s .= chr(rand(65,90));
    }
    return $s;
  }
  
  function setToken($username) {
    global $conn;
    $token = generateToken();
    $sql = "insert into `sixwings-tokens` (token,username) values('{$token}', '{$username}')";
    $result = $conn->query($sql);
    if (!$result) {
      die($conn->error);
    }
    $expire = time() + 3600 * 24 * 14; // 14 days
    setcookie('token', $token, $expire);
  }

  function _queryRow($sql_fmt, $key) {
    global $conn;
    $sql = sprintf($sql_fmt, $key);
    $result = $conn->query($sql);
    return ($result) ? $result->fetch_assoc() : false;
  }
  
  // username => user
  function getUserFromUsername($username) {
    global $conn;
    $sql_fmt = "select * from `sixwings-users` where username = '%s' limit 1;";
    return _queryRow($sql_fmt, $username);
  }

  // token => username
  function getUsername() {
    if(!isLogin()) {
      return false;
    }
    global $conn;
    $sql_fmt = "select username from `sixwings-tokens` where token = '%s' limit 1;";
    $token = $_COOKIE['token'];
    $row = _queryRow($sql_fmt, $token);
    return ($row) ? $row['username'] : false;
  }

  function addUser() {
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
    $sql = "insert into `sixwings-users` (nickname, username, pass, created_at) values('{$nickname}','{$username}', '{$pass}', now())";
    $result = $conn->query($sql);
    if (!$result) {
      header("Location: register.php?errCode=2");
      die($conn->error);
    }
    header("Location: index.php");
  }
  
  // token => username => user
  function getUser() {
    $username = getUsername();
    return ($username) ? getUserFromUsername($username) : false;
  }
  
  function login() {
    if (isLogin()) {
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
    $sql = "SELECT * FROM `sixwings-users` WHERE `username` = '{$username}' AND `pass` = '{$pass}'";
    $result = $conn->query($sql);
    if ($result->num_rows === 0) {
      header("Location: login.php?errCode=2");
      die('無此帳號或密碼錯誤');
    }
    setToken($username);
    // header("Location: login.php"); // debug
    header("Location: index.php");
  }
  
  function logout() {
    if(!isLogin()) {
      die('no login');
    }
    $expire = time() - 3600;
    setcookie('token', '', $expire);
    header("Location: index.php");
  }

  function addComment() {
    if(!isLogin()) {
      die('no login');
    }
    if (empty($_POST['content'])) { //檢查是否有輸入資料
      header("Location: index.php?errCode=1");
      die('請輸入 content');
    }
    global $conn;
    $username = getUsername();
    $content = $_POST['content'];
    $sql = "insert into `sixwings-comments` (username, content, created_at) values('{$username}','{$content}', now())";
    $result = $conn->query($sql);
    if (!$result) {
      die($conn->error);
    }
    header("Location: index.php");
  }

  function getComments() {
    global $conn;
    $sql = "SELECT * FROM `sixwings-comments` order by created_at desc";
    $result = $conn->query($sql);
    // print_r($result); // 沒辦法印 false
    // var_dump($result); // 可以印 false, 但正常時候資料比較雜
    
    if (!$result) { // 連線錯誤會到這邊
      die($conn->error); // 不會執行下去，然後輸出錯誤訊息
    }
    return $result;
  }
?>
