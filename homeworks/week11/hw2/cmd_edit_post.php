<?php
  session_start();
  require_once('conn.php');
  require_once('util.php');
  function edit_post() {
    if(!is_login()) {
      header("Location: index.php?errCode=403");
      die();
    }
    //檢查是否有輸入資料
    if (
      empty($_POST['id']) ||
      empty($_POST['title']) ||
      empty($_POST['content'])
    ) {
      header("Location: new_post.php?errCode=400");
      die();
    }
    global $conn;
    $sql = <<<BLOCK
  UPDATE `sixwings-blog-posts` SET
  `title` = ?,
  `content` = ?
  WHERE `id` = ?;
BLOCK;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $_POST['title'], $_POST['content'], $_POST['id']);
    $isOK = $stmt->execute();
    if (!$isOK) {
      header("Location: admin.php?errCode=456789000");
      die($conn->error);
    }
    header("Location: admin.php");
  }
  edit_post();
  session_commit();
?>