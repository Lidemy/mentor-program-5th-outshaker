<?php
  require_once('conn.php');
  require_once('util.php');

  function get_post($id) {
    global $conn;
    $sql = <<<BLOCK
  SELECT *
  FROM `sixwings-blog-posts`
  WHERE id = ? and status != 'deleted'
  LIMIT 1;
BLOCK;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $isOK = $stmt->execute();
    if (!$isOK) {
      return false;
    }
    $result = $stmt->get_result();
    return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : false;
  }
  if (empty($_GET['id'])) { //檢查是否有輸入資料
    header("Location: index.php?errCode=400");
    die();
  }
  $row = get_post(intval($_GET['id']));
  if(!$row) {
    header("Location: 404.php");
    die();
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>部落格</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="normalize.css" />
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <nav class="navbar">
    <div class="wrapper navbar__wrapper">
      <div class="navbar__site-name">
        <a href='index.php'>Who's Blog</a>
      </div>
      <ul class="navbar__list">
        <div>
          <li><a href="archive.php">文章列表</a></li>
          <li><a href="#">分類專區</a></li>
          <li><a href="#">關於我</a></li>
        </div>
        <div>
          <li><a href="admin.php">管理後台</a></li>
          <li><a href="#">登出</a></li>
        </div>
      </ul>
    </div>
  </nav>
  <section class="banner">
    <div class="banner__wrapper">
      <h1>存放技術之地</h1>
      <div>Welcome to my blog</div>
    </div>
  </section>
  <div class="container-wrapper">
    <div class="posts">
      <article class="post">
        <div class="post__header">
          <div><?php echo escape($row['title']); ?></div>
          <div class="post__actions">
            <a class="post__action" href="edit_post.php?<?php echo escape$row['id']); ?>">編輯</a>
          </div>
        </div>
        <div class="post__info">
          <?php echo escape($row['posted_at']); ?>
        </div>
        <div class="post__content">
          <?php echo escape($row['content']); ?>
        </div>
      </article>
    </div>
  </div>
  <footer>Copyright © 2020 Who's Blog All Rights Reserved.</footer>
</body>
</html>