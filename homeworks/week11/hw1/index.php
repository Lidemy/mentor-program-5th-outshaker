<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>留言板</title>
  <link rel="stylesheet" href="main.css">
</head>
<body>
  <header class="warning">
    <strong>注意！本站為練習用網站，因教學用途刻意忽略資安的實作，註冊時請勿使用任何真實的帳號或密碼。</strong>
  </header>
  <main class="board">
    <?php
      if(isset($_GET['errCode'])){
        switch($_GET['errCode']){
          case '0':
            echo '    <h1 class="error">錯誤：未登入的操作</h1>';break;
          case '1':
            echo '    <h1 class="error">錯誤：未輸入暱稱或內容。</h1>';break;
          case '10':
            echo '    <h1 class="error">錯誤：帳號資訊錯誤</h1>';break;
          case '2':
            echo '    <h1 class="error">錯誤：你沒有修改留言的權限。</h1>';break;
          case '3':
            echo '    <h1 class="error">錯誤：你沒有刪除留言的權限。</h1>';break;
          case '4':
            echo '    <h1 class="error">錯誤：此留言並不存在。</h1>';break;
          case '5':
            echo '    <h1 class="error">錯誤：未輸入參數。</h1>';break;
        }
      }
    ?>
<?php require('get_login_block.php'); ?>
    <h1 class="board-title">Comments</h1>
<?php require('get_comment_form.php'); ?>
    <div class="hr"></div>
    <div class="comments">
<?php require('get_comment_blocks.php'); ?>
      <!-- <div class="comment">
        <div class="comment-avatar">
          <img src="" alt="">
        </div>
        <div class="comment-body">
          <div class="comment-info">
            <span class="comment-username">six</span>
            <span class="comment-time">2021-06-17 11:00:00</span>
          </div>
          <div class="comment-content">Today is a good day to code!</div>
        </div>
      </div> -->
    </div>
<?php
  require_once('util.php');
  $info = get_page_info();
  $count = $info['count'];
  $num_pages = intval($info['num_pages']);
  $page = (!empty($_GET['page'])) ? intval($_GET['page']) : 1;
  if ($page > $num_pages) $page = $num_pages;
  if ($page < 1) $page = 1;
  $pre_page = $page - 1;
  $next_page = $page + 1;

  if ($page !== 1) {
    $go_back_block = <<<BLOCK

      <a href="index.php?page=1">|&lt;</a>
      <a href="index.php?page={$pre_page}">&lt;</a>
BLOCK;
  } else {
    $go_back_block = "";
  }
  if ($page !== $num_pages) {
    $go_next_block = <<<BLOCK

      <a href="index.php?page={$next_page}">&gt;</a>
      <a href="index.php?page={$num_pages}">&gt;|</a>
BLOCK;
  } else {
    $go_next_block = "";
  }

  echo <<<BLOCK
    <div class="page-info">
      總共 {$count} 筆留言，這是第 {$page} / {$num_pages} 頁
    </div>

BLOCK;
  if ($num_pages > 1) {
    echo <<<BLOCK
    <div class="paginator">{$go_back_block}{$go_next_block}
    </div>
    
BLOCK;
  }
?>
  </main>
  <script>
    const del_btns = [...document.querySelectorAll('.del_btn')]
    del_btns.forEach((ele) => {
      ele.addEventListener("click", (ev) => {
        if (!confirm("確定要刪除嗎？")) {
          ev.preventDefault()
        }
        return
      })
    })
  </script>
</body>
</html>