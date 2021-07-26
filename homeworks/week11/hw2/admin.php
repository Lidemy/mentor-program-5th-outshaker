<?php
  session_start();
  require_once('util.php');
  if (!is_login()) {
    header("Location: index.php?errCode=403");
    die();
  }
  $posts = get_posts(); // 取得全部文章
  if(!$posts) {
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
          <li><a href="new_post.php">新增文章</a></li>
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
    <div class="container">
      <div class="admin-posts">
<?php foreach($posts as $post) {?>
        <div class="admin-post">
          <div class="admin-post__title">
            <?php echo escape($post['title']); ?>
          </div>
          <div class="admin-post__info">
            <div class="admin-post__created-at">
              <?php echo escape($post['posted_at']); ?>
            </div>
            <a class="admin-post__btn" href="edit_post.php?id=<?php echo escape($post['id']); ?>">
              編輯
            </a>
            <a class="admin-post__btn" href="cmd_del_post.php?id=<?php echo escape($post['id']); ?>">
              刪除
            </a>
          </div>
        </div>
<?php }?>
      </div>
    </div>
  </div>
  <footer>Copyright © 2020 Who's Blog All Rights Reserved.</footer>
</body>
</html>
<?php session_commit(); ?>