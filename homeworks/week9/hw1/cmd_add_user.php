<?php
  require_once('conn.php'); // 連線

  // 檢查是否有輸入資料
  if (
    empty($_POST['nickname']) ||
    empty($_POST['username']) ||
    empty($_POST['pass'])
  ) {
    header("Location: register.php?errCode=1");
    die('some column is empty');
  }

  $nickname = $_POST['nickname'];
  $username = $_POST['username'];
  $pass = $_POST['pass'];
  $sql = "insert into sixwings-users (nickname, username, pass, created_at) values('{$nickname}','{$username}', '{$pass}', now())";
  $result = $conn->query($sql);
  if (!$result) {
    header("Location: register.php?errCode=2");
    die($conn->error);
  }

  header("Location: index.php");
?>
