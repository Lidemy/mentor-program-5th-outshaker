<?php
  require_once('conn.php'); // 連線
  require_once('util.php');

  if (empty($_POST['content'])) { //檢查是否有輸入資料
    header("Location: index.php?errCode=1");
    die('請輸入 content');
  }

  $username = getUsernameFromToken($conn, $_COOKIE['token']);
  $content = $_POST['content'];
  $sql = "insert into sixwings-comments (username, content, created_at) values('{$username}','{$content}', now())";
  $result = $conn->query($sql);
  if (!$result) {
    die($conn->error);
  }

  header("Location: index.php");
?>
