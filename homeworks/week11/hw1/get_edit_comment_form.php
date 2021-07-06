<?php
  require_once('util.php');
  if(!is_login()) {
    header("Location: index.php?errCode=0");
    die();
  }
  if(empty($_GET['id'])) {
    header("Location: index.php?errCode=5");
    die();
  }

  $role = get_role();
  $comment = get_comment(intval($_GET['id']));
  if (!$comment) {
      header("Location: index.php?errCode=4");
      die();
    }
  if (($role['viewer_id'] !== $comment['owner_id'] && $role['edit_range'] === 'OWN') || ($role['edit_range'] === 'NONE')) {
      header("Location: index.php?errCode=2");
      die();
  }
  $id = $comment['id'];
  $nickname = escape($comment['nickname']);
  $username = escape($comment['username']);
  $content = escape($comment['content']);
  echo <<<BLOCK
  <form method="POST" action="cmd_edit.php" class="add-comment-form">
    <input type="hidden" name="id" value={$id}>
    <div class="input-block">
      <strong>{$nickname} ({$username})</strong> 想說：
    </div>
    <textarea name="content" id="" rows="5">{$content}</textarea><br>
    <input class="board-submit-btn" type="submit" value="修改">
  </form>
BLOCK;
?>