# 留言版簡易說明文件

## 程式架構
- index.php 留言版主頁面
  - get_login_block.php 登入區塊
    - cmd_logout.php 登出指令
  - get_comment_form.php 新增留言表單區塊
    - cmd_add_comment.php 新增留言指令
  - get_comment_blocks.php 留言區塊
    - cmd_del_comment.php 刪除留言指令
- login.php 登入頁面
  - cmd_login.php 登入指令
- register.php 註冊頁面
  - cmd_add_user.php 註冊指令
- edit_comment.php 編輯留言頁面
  - get_edit_comment_form.php 編輯表單區塊
  - cmd_edit_comment.php 編輯留言指令
- user_management.php 用戶管理後台
  - get_user_role_table.php 用戶角色表區塊
  - cmd_set_user_role.php 修改用戶身分指令
- util.php 功能函數集合
- conn.php 資料庫連線
- main.css 全站樣式

## 實作課程項目
- [x] 密碼加密
- [x] 防 XSS 攻擊
- [x] 防 SQL injection
- [x] 基礎身分權限管理
- [x] 留言分頁

## 一些額外加入的設計
- 未登入使用者代入 user_id=1 訪客帳號，配合 role 管理機制
- 刪除留言跳提示框確認 #UX
- 資料表結構導入版本控制 #專案開發
- 使用 VIEW，但因為線上 server 配置的 table cache 不足無法正常運作，所以又改回原本的寫法 #database
- 分頁資訊 (留言數、總頁數) 透過 SQL 查詢完成
- 分頁只有一頁時不顯示分頁按紐 #UI
- 頁數在第二頁、倒數第二頁時合併相同頁碼的按鈕 #UI
- get_page_info() 可以自訂分頁內顯示多少筆留言，增加擴充性
- 安全考量，禁止在用戶管理後台對預設的 admin 帳號更動身分

## More
- 統一錯誤處理的方式。die() 裡面不放訊息
- 再規劃 errCode
- 每個功能寫測試流程，至少知道更新之後有那些東西要確認有沒有壞掉？
- 降低對 util.php 的依賴，把部分函數轉移到 api lib
- 尋找更適合的頁面結構寫法
