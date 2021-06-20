<?php
  $expire = time() - 3600;
  setcookie('token', '', $expire);
  header("Location: index.php");
?>
