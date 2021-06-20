<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>登入</title>
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
            echo '    <h1 class="error">錯誤：資料未填寫完全。</h1>';break;
          case '2':
            echo '    <h1 class="error">錯誤：帳號或密碼錯誤。</h1>';break;
        }
      }
    ?>
    <div class="login-block">
      <a href="index.php" class="btn">回首頁</a>
      <a href="register.php" class="btn">註冊</a>
    </div>
    <h1 class="board-title">登入帳號</h1>
    <form method="POST" action="cmd_login.php" class="login-form">
      <div class="input-block">
        <span>帳號：</span>
        <input type="text" name="username">
      </div>
      <div class="input-block">
        <span>密碼：</span>
        <input type="password" name="pass">
      </div>
      <input class="board-submit-btn" type="submit">
    </form>
  </main>
</body>
</html>