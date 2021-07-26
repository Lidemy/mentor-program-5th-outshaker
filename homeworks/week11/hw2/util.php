<?php
  require_once('conn.php');

  function is_login() {
    return session_status() === PHP_SESSION_ACTIVE &&
           isset($_SESSION) && !empty($_SESSION['is_login']);
  }
  
  // 抓取文章，因為多頁面共用所以移到這邊
  function get_posts($page=0, $page_size=5) {
    if ($page === 0) return get_all_posts();
    global $conn;
    $num_pages = intval(get_page_info()['num_pages']);
    $page = ($page > $num_pages) ? $num_pages : (($page < 0) ? 1 : $page);
    $limit = $page_size;
    $offset = ($page - 1) * $page_size;
    $sql = <<<BLOCK
  SELECT *
  FROM `sixwings-blog-posts`
  WHERE status != 'deleted'
  ORDER BY id DESC
  LIMIT ? OFFSET ?;
BLOCK;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $limit, $offset);
    $isOK = $stmt->execute();
    if (!$isOK) {
      error_log("{$stmt->errno}: {$stmt->error}\n", 3, "debug.log");
      return false;
    }
    $result = $stmt->get_result();
    if (!$result) return false;
    $arr = array();
    while($row = $result->fetch_assoc()) {
      $arr[] = $row;
    }
    return $arr;
  }

  // 取得所有文章
  function get_all_posts() {
    global $conn;
    $sql = <<<BLOCK
  SELECT *
  FROM `sixwings-blog-posts`
  WHERE status != 'deleted'
  ORDER BY id DESC
BLOCK;
    $stmt = $conn->prepare($sql);
    $isOK = $stmt->execute();
    if (!$isOK) {
      error_log("{$stmt->errno}: {$stmt->error}\n", 3, "debug.log");
      return false;
    }
    $result = $stmt->get_result();
    if (!$result) return false;
    $arr = array();
    while($row = $result->fetch_assoc()) {
      $arr[] = $row;
    }
    return $arr;
  }

  // 分頁相關 page_size 一頁資料量, count 資料數量, num_pages 資料頁數
  function get_page_info($page_size = 5) {
    global $conn;
    $sql = <<<BLOCK
SELECT
COUNT(id) AS count,
CEIL(COUNT(id) / {$page_size}) AS num_pages
FROM `sixwings-blog-posts` WHERE status != 'deleted';
BLOCK;
    $stmt = $conn->prepare($sql);
    $isOK = $stmt->execute();
    if (!$isOK) {
      error_log("{$stmt->errno}: {$stmt->error}\n", 3, "debug.log");
      return false;
    }
    return $stmt->get_result()->fetch_assoc();
  }

  // 轉義文字: 防止 XSS
  function escape($str) {
    return htmlspecialchars($str, ENT_QUOTES);
  }
?>