<?php
  session_start();
  require_once('util.php');
  logout();
  session_commit();
?>
