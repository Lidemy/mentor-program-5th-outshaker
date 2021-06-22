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
          case '1':
            echo '    <h1 class="error">錯誤：未輸入暱稱或內容。</h1>';break;
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
  </main>
</body>
</html>