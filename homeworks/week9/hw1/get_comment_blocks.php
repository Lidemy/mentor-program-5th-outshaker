<?php
  require_once('util.php');
  $result = get_comments();
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

