# 部落格簡要說明

## 檔案架構

### 前台
- index.php 首頁
- post.php 瀏覽文章
- archive.php 所有文章
- login.php 登入頁
- 404.php 遺失頁面

### 後台
- admin.php 後台管理頁
- new_post.php 新增文章/後台
- edit_post.php 編輯文章

### 指令
- cmd_login.php 登入指令
- cmd_logout.php 登出指令
- cmd_new_post.php 新增文章指令
- cmd_edit_post.php 編輯文章指令
- cmd_del_post.php 刪除文章指令
- conn.php 連線指令
- util.php 工具指令

### 其他
- blog-schema.sql 資料表結構
- normalize.css 正規化樣式表
- style.css 網站樣式

## 實作項目
- [x] 1. 要有登入機制，讓管理員能夠登入到管理後台
- [x] 2. 身為一個管理員，要能夠新增文章
- [x] 3. 身為一個管理員，要能夠編輯文章
- [x] 4. 身為一個管理員，要能夠刪除文章
- [x] 5. 身為一個管理員，新增文章時要有標題以及內文
- [x] 6. 身為一個訪客，在首頁要能看到最新的五篇文章
- [x] 7. 身為一個訪客，可以從導覽列點入：文章列表，並看到所有文章

## 延伸挑戰
- [ ] 1. 串接 CKEditor
- [ ] 2. 實作分類功能
- [ ] 3. 實作 view more 功能
- [ ] 4. 實作分頁機制
- [ ] 5. 新增關於我頁面
- [ ] 6. 支援 RWD

## memo
- 串接 markdown 編輯器 [Parsedown](https://parsedown.org/)
- 切換不同的發送文章(草稿/發布)
- 編輯中的文章暫存在 localstoreage
- session 設定 path
- 根據 dev, realease 狀態設定資料庫連線參數
- 設計 404 頁面
- 被導向的登入動作，可以再導回上一次的頁面
- google reCAPTCHA v3

