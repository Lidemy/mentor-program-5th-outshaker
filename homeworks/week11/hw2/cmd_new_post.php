<?php
  session_start();
  require_once('conn.php');
  require_once('util.php');
  function new_post() {
    if(!is_login()) {
      header("Location: index.php?errCode=403");
      die();
    }
    //檢查是否有輸入資料
    if (
      empty($_POST['title']) ||
      empty($_POST['content']) ||
      empty($_POST['status'])
    ) {
      header("Location: new_post.php?errCode=400");
      die();
    }
    global $conn;
    $sql = 
<<<BLOCK
  INSERT INTO `sixwings-blog-posts` (`title`, `content`, `status`)
  VALUES (?, ?, ?);
BLOCK;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $_POST['title'], $_POST['content'], $_POST['status']);
    $isOK = $stmt->execute();
    if (!$isOK) {
      header("Location: admin.php?errCode=123156487982134564");
      die($conn->error);
    }
    header("Location: admin.php");
  }
  new_post();
  session_commit();
?>