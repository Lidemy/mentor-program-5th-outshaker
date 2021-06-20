<?php
  require_once('conn.php');
  require_once('util.php');
  
  // 檢查是否有輸入資料
  if (
    empty($_POST['username']) ||
    empty($_POST['pass'])
  ) {
    header("Location: login.php?errCode=1");
    die('some column is empty');
  }

  $username = $_POST['username'];
  $pass = $_POST['pass'];
  $sql = "SELECT * FROM `sixwings-users` WHERE `username` = '{$username}' AND `pass` = '{$pass}'";
  $result = $conn->query($sql);
  if ($result->num_rows === 0) {
    header("Location: login.php?errCode=2");
    die('無此帳號或密碼錯誤');
  }

  setToken($conn, $username);
  // header("Location: login.php"); // debug
  header("Location: index.php");
?>
