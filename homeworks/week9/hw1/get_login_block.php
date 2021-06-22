<?php
  require_once('util.php');
  if(is_login()) { // 已登入
  // if(false) { // debug
    echo <<<BLOCK
    <div class="login-block">
      <a href="cmd_logout.php" class="btn">登出</a>
    </div>
BLOCK;
  } else { // 未登入
    echo <<<BLOCK
    <div class="login-block">
      <a href="register.php" class="btn">註冊</a>
      <a href="login.php" class="btn">登入</a>
    </div>
BLOCK;
  }
?>