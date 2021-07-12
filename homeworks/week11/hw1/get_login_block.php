<?php
  require_once('util.php');
  // 管理員身分且不在後台時，顯示後台連結
  if (is_admin() && basename($_SERVER['PHP_SELF']) !== "user_management.php") {
    $backstage_link = "\n      <a href=\"user_management.php\" class=\"btn\">帳號管理後台</a>";
  } else {
    $backstage_link = "";
  }

  // 離開首頁時，顯示回首頁
  if (basename($_SERVER['PHP_SELF']) !== "index.php") {
    $home_link = "\n      <a href=\"index.php\" class=\"btn\">回首頁</a>";
  } else {
    $home_link = "";
  }
  if (is_login()) { // 登入
    echo <<<BLOCK
    <div class="login-block">
      <a href="cmd_logout.php" class="btn">登出</a>{$backstage_link}{$home_link}
    </div>
BLOCK;
  } else { // 未登入
    echo <<<BLOCK
    <div class="login-block">
      <a href="register.php" class="btn">註冊</a>
      <a href="login.php" class="btn">登入</a>{$home_link}
    </div>
BLOCK;
  }
?>