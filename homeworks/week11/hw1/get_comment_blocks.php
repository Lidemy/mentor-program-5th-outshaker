<?php
  require_once('util.php');
  $result = get_comments();
  while ($row = $result->fetch_assoc()) { // 逐行讀取資料
    $username = escape($row['username']);
    $created_at = escape($row['created_at']);
    $content = escape($row['content']);
    echo <<<BLOCK
      <div class="comment">
        <div class="comment-avatar">
          <!-- <img src="" alt=""> -->
        </div>
        <div class="comment-body">
          <div class="comment-info">
            <span class="comment-username">{$username}</span>
            <span class="comment-time">{$created_at}</span>
          </div>
          <div class="comment-content">{$content}</div>
        </div>
      </div>
BLOCK;
  }
?>

