<?php
  require_once('../conn.php');
  header('Access-Control-Allow-Origin: *');
  header('Content-type:application/json;charset=utf-8');
  
  if (empty($_POST['board_name']) || empty($_POST['nickname']) || empty($_POST['content'])) {
    echo json_encode(array(
      'ok' => false,
      'massage' => 'please fill the fields'
    ));
    die();
  }
  $board_name = $_POST['board_name'];
  $nickname = $_POST['nickname'];
  $content = $_POST['content'];

  $sql = 'INSERT INTO `sixwings-boards` (`board_name`, `nickname`, `content`) VALUES (?, ?, ?);';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('sss', $board_name, $nickname, $content);
  $result = $stmt->execute();
  if(!$result) {
    echo json_encode(array(
      'ok' => false,
      'massage' => "can't add comment"
    ));
    die();
  }

  $comment = array(
    'id' => $conn->insert_id,
    'nickname' => $nickname,
    'content' => $content,
    'created_at' => 'YYYY-MM-DD HH:MM:SS'
  );

  echo json_encode(array(
    'ok' => true,
    'comment' => $comment
    )
  );
?>