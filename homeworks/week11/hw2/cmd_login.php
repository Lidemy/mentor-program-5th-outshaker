<?php
  session_start();
  require_once('conn.php');
  
  function login() {
    // 檢查是否有輸入資料
    if ( empty($_POST['id']) || empty($_POST['pass'])) {
      header("Location: login.php?errCode=1");
      die();
    }
    global $conn;
    $id = $_POST['id'];
    $pass = $_POST['pass'];
    $sql = "SELECT `id`, `pass` FROM `sixwings-blog-users` WHERE `id` = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $id);
    $is_ok = $stmt->execute();
    $result = ($is_ok) ? $stmt->get_result() : false;
    if (!$result || $result->num_rows === 0) { // 把 $result == false 的情況也過濾掉
      header("Location: login.php?errCode=10"); // 查無帳號
      die();
    }
    $row = $result->fetch_assoc();
    if (!password_verify($pass, $row['pass'])) {
      header("Location: login.php?errCode=11"); // 密碼錯誤
      die();
    }
    $_SESSION['is_login'] = true;
    header("Location: admin.php");
  }

  login();
  session_commit();
?>