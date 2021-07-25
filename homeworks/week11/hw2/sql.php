<?php
  // 先以 MySQL workbench 測試過沒問題後在此測試
  require_once('conn.php');
  $sql = 
<<<BLOCK
select title, content, posted_at from `sixwings-blog-posts` where status = 'publish';
BLOCK;
  $stmt = $conn->prepare($sql);
  // $stmt->bind_param('ii', $user_id, $user_id);
  $isOK = $stmt->execute();
  // var_dump($isOK);
  $result = ($isOK) ? $stmt->get_result() : false;
  // var_dump($result);
  $row = $result->fetch_assoc();
  // var_dump($row);
  echo "title: ".$row['title']."\n";
  echo "posted_at: ".substr($row['posted_at'],0,10)."\n";
  echo "content: ".$row['content']."\n";
?>