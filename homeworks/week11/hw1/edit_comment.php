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
<?php require('get_login_block.php'); ?>
    <h1 class="board-title">Edit Comments</h1>
<?php require('get_edit_comment_form.php'); ?>
  </main>
</body>
</html>