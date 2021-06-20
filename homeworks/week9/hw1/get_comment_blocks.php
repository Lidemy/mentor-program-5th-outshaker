<?php
  // 登入資料庫，列印全部使用者名單
  require_once("conn.php");
  $sql = "SELECT * FROM sixwings-comments order by created_at desc";
  $result = $conn->query($sql);
  // print_r($result); // 沒辦法印 false
  // var_dump($result); // 可以印 false, 但正常時候資料比較雜
  
  if (!$result) { // 連線錯誤會到這邊
    die($conn->error); // 不會執行下去，然後輸出錯誤訊息
  }

  while ($row = $result->fetch_assoc()) { // 逐行讀取資料
    echo <<<BLOCK
      <div class="comment">
        <div class="comment-avatar">
          <!-- <img src="" alt=""> -->
        </div>
        <div class="comment-body">
          <div class="comment-info">
            <span class="comment-username">{$row['username']}</span>
            <span class="comment-time">{$row['created_at']}</span>
          </div>
          <div class="comment-content">{$row['content']}</div>
        </div>
      </div>
BLOCK;
  }
?>

