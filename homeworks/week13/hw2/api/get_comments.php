<?php
  require_once('../conn.php');
  header('Content-type:application/json;charset=utf-8');
  header('Access-Control-Allow-Origin: *');

  if (empty($_GET['board_name'])) {
    echo json_encode(array(
      'ok' => false,
      'massage' => 'require board_name'
    ));
    die();
  }

  $board_name = $_GET['board_name'];
  
  if (empty($_GET['before'])) {
    $sql = 'SELECT * FROM `sixwings-boards` WHERE `board_name` = ? ORDER BY id DESC LIMIT 5';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $board_name);
  } else {
    $before = intval($_GET['before']);
    $sql = 'SELECT * FROM `sixwings-boards` WHERE `board_name` = ? AND `id` < ? ORDER BY id DESC LIMIT 5';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $board_name, $before);
  }
  $result = $stmt->execute();
  if(!$result) {
    echo json_encode(array(
      'ok' => false,
      'massage' => "can't get comments"
    ));
    die();
  }

  $comments = array();
  $result = $stmt->get_result();
  while($row = $result->fetch_assoc()) {
    array_push($comments, array(
      'id' => $row['id'],
      'nickname' => $row['nickname'],
      'content' => $row['content'],
      'created_at' => $row['created_at']
    ));
  }

  echo json_encode(array(
      'ok' => true,
      'comments' => $comments
  ));
?>