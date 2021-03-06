<?php
  session_start();
  require_once('util.php');
  if (!is_login()) {
    header("Location: login.php");
    die();
  }
  session_commit();
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
          <li><a href="cmd_logout.php">登出</a></li>
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
      <div class="edit-post">
        <form id="newPostForm" action="cmd_new_post.php" method="POST">
          <div class="edit-post__title">
            新增文章：
          </div>
          <div class="edit-post__input-wrapper">
            <input class="edit-post__input" placeholder="請輸入文章標題" name="title"/>
          </div>
          <div class="edit-post__input-wrapper">
            <textarea rows="20" class="edit-post__content" name="content"></textarea>
          </div>
          <div class="edit-post__btn-wrapper">
              <div class="edit-post__btn">送出</div>
          </div>
          <input type="hidden" name="status" value="publish"/>
        </form>
      </div>
    </div>
  </div>
  <footer>Copyright © 2020 Who's Blog All Rights Reserved.</footer>
</body>
<script>
  const btn = document.querySelector('.edit-post__btn');
  btn.addEventListener('click', () => {
    const title = document.querySelector(".edit-post__input");
    const content = document.querySelector(".edit-post__content");
    if (title.value === '' || content.value === '') {
      alert('請輸入內容');
      return;
    }
    document.querySelector("#newPostForm").submit();
  });
</script>
</html>