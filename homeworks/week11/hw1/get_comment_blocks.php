<?php
  require_once('util.php');
  $page = (isset($_GET['page'])) ? intval($_GET['page']) : 1;
  $result = get_comments($page);
  $role = get_role();
echo "    <div class=\"comments\">\n";
  while ($row = $result->fetch_assoc()) { // 逐行讀取資料
    $nickname = escape($row['nickname']);
    $username = escape($row['username']);
    $created_at = escape($row['created_at']);
    $content = escape($row['content']);
    $can_edit = ($role['viewer_id'] === $row['owner_id'] && $role['edit_range'] === 'OWN') || ($role['edit_range'] === 'ALL');
    $can_del = ($role['viewer_id'] === $row['owner_id'] && $role['del_range'] === 'OWN') || ($role['del_range'] === 'ALL');
    $edit_link = ($can_edit) ? "\n            <a href='edit_comment.php?id={$row['id']}'>編輯</a>" : "";
    $del_link = ($can_del) ? "\n            <a class='del_btn' href='cmd_del_comment.php?id={$row['id']}'>刪除</a>" : "";
    echo <<<BLOCK
      <div class="comment">
        <div class="comment-avatar">
        </div>
        <div class="comment-body">
          <div class="comment-info">
            <span class="comment-username">{$nickname} ({$username})</span>{$edit_link}{$del_link}
            <span class="comment-time">{$created_at}</span>
          </div>
          <div class="comment-content">{$content}</div>
        </div>
      </div>

BLOCK;
  }
  echo "    </div>\n";
?>