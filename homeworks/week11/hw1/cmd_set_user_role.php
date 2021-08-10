<?php
  session_start();
  require_once("util.php");
  set_user_role();
  session_commit();
?>