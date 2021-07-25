<?php
  function is_login() {
    return session_status() === PHP_SESSION_ACTIVE &&
           isset($_SESSION) && !empty($_SESSION['is_login']);
  }
?>