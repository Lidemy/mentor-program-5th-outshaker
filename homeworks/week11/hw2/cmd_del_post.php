<?php
  session_start();
  require_once('conn.php');
  require_once('util.php');
  function del_post() {
    if(!is_login()) {
      header("Location: index.php?errCode=403");
      die();
    }
    if (empty($_GET['id'])) { //檢查是否有輸入資料
      header("Location: admin.php?errCode=400");
      die();
    }
    global $conn;
    $id = $_GET['id'];
    $sql = <<<BLOCK
  UPDATE `sixwings-blog-posts` AS C
  SET C.status = 'deleted'
  WHERE C.id = ?;
BLOCK;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $id);
    $isOK = $stmt->execute();
    if (!$isOK) {
      header("Location: admin.php?errCode=500");
      die();
    }
    var_dump($stmt->affected_rows);
    if ($stmt->affected_rows === 0) {
      header("Location: admin.php?errCode=404");
      die();
    }
    header("Location: admin.php");
  }
  del_post();
  session_commit();
?>