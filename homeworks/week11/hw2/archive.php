<?php
  session_start();
  require_once('util.php');
  $posts = get_posts(); // 取得全部文章
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
          <li>文章列表</li>
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
      <ul>
<?php foreach($posts as $post) {?>
        <li class="post">
          <a href="post.php?id=<?php echo escape($post['id']); ?>"><?php echo escape($post['title']); ?></a> - <?php echo escape($post['posted_at']); ?>
        </li>
<?php }?>
      </ul>
    </div>
  </div>
  <footer>Copyright © 2020 Who's Blog All Rights Reserved.</footer>
</body>
</html>