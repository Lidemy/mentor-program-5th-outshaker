<?php
  session_start();
  require_once('util.php');
  $posts = get_posts(1); // 取得第一頁 (前五篇) 文章
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
<?php if (is_login()) { ?>
          <li><a href="cmd_logout.php">登出</a></li>
<?php } else { ?>
          <li><a href="login.php">登入</a></li>
<?php } ?>
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
<?php foreach($posts as $post) {?>
      <article class="post">
        <div class="post__header">
          <div><?php echo escape($post['title']); ?></div>
          <div class="post__actions">
            <!--<a class="post__action" href="edit.php">編輯</a>-->
          </div>
        </div>
        <div class="post__info">
          <?php echo escape($post['posted_at']); ?>
        </div>
        <div class="post__content">
          <?php echo escape($post['content']); ?>
        </div>
        <a class="btn-read-more" href="post.php?id=<?php echo escape($post['id']); ?>">READ MORE</a>
      </article>
<?php }?>
    </div>
  </div>
  <footer>Copyright © 2020 Who's Blog All Rights Reserved.</footer>
</body>
</html>