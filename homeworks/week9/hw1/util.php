<?php
  function isLogin() { return !empty($_COOKIE['token']); }

  function generateToken() {
    $s = '';
    for($i=1; $i<=16; $i++) {
      $s .= chr(rand(65,90));
    }
    return $s;
  }
  
  function setToken($conn, $username) {
    $token = generateToken();
    $sql = "insert into sixwings-tokens(token,username) values('{$token}', '{$username}')";
    $result = $conn->query($sql);
    if (!$result) {
      die($conn->error);
    }
    $expire = time() + 3600 * 24 * 14; // 14 days
    setcookie('token', $token, $expire);
  }

  function _queryRow($conn, $sql_fmt, $key) {
    $sql = sprintf($sql_fmt, $key);
    $result = $conn->query($sql);
    return ($result) ? $result->fetch_assoc() : false;
  }
  
  function getUserFromUsername($conn, $username) {
    $sql_fmt = "select * from sixwings-users where username = '%s' limit 1;";
    return _queryRow($conn, $sql_fmt, $username);
  }

  function getUsernameFromToken($conn, $token) {
    $sql_fmt = "select username from sixwings-tokens where token = '%s' limit 1;";
    $row = _queryRow($conn, $sql_fmt, $token);
    return ($row) ? $row['username'] : false;
  }

  function getUserFromToken($conn, $token) {
    $username = getUsernameFromToken($conn, $token);
    return ($username) ? getUserFromUsername($conn, $username) : false;
  }
  
?>
