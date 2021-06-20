<?php
  require_once('util.php');
  
  if(isLogin()) { // 已登入
    $username = getUsername();
  // if(false) { // debug
    echo <<<BLOCK
    <form method="POST" action="cmd_add_comment.php" class="add-comment-form">
      <div class="input-block">
        <strong>{$username}</strong> 想說：
      </div>
      <textarea name="content" id="" rows="5"></textarea><br>
      <input class="board-submit-btn" type="submit" value="留言">
    </form>
BLOCK;
  } else { // 未登入
    echo <<<BLOCK
    <form method="POST" action="cmd_add_comment.php" class="add-comment-form">
      <h3>請登入發布留言</h3>
    </form>
BLOCK;
  }
?>