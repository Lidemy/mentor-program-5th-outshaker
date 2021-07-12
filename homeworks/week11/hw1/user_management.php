<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>留言板 - 用戶管理</title>
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
          echo '    <h1 class="error">錯誤：遺漏參數。</h1>';break;
        case '2':
          echo '    <h1 class="error">錯誤：初始帳號無法更改身分。</h1>';break;
        case '3':
          echo '    <h1 class="error">提示：指令未造成改變。</h1>';break;
      }
    }
  ?>
<?php require('get_login_block.php'); ?>
    <h1 class="board-title">User Management</h1>
<?php require('get_user_role_table.php'); ?>
  </main>
  <script>
  </script>
</body>
</html>