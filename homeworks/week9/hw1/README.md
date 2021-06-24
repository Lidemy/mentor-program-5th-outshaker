# 留言版簡易說明文件

## 程式架構
- index.php 留言版主頁面
  - get_login_block.php 登入區塊
    - cmd_logout.php 登出指令
  - get_comment_form.php 新增留言表單區塊
    - cmd_add_comment.php 新增留言指令
  - get_comment_blocks.php 留言區塊
- login.php 登入頁面
  - cmd_login.php 登入指令
- register.php 註冊頁面
  - cmd_add_user.php 註冊指令
- util.php 功能函數集合
- conn.php 資料庫連線
- main.css 全站樣式

## 一些額外加入的設計
- 把網頁一部分拆分到別的檔案，增加一點結構性
- php 區塊文字 <<<BLOCK ... BLOCK;
  - 主要是為了避開 php 條件判斷式和 html 交雜的寫法，讓結構好讀一些
- php 字串的變數解析 "... {$var}"
  - 類似 ES6 的樣板字串，差別是 php 只能處理變數，不能加運算式和函數呼叫
- 以函數封裝程式碼
  - 降低全域變數汙染的問題
    - 沒有讓 $username 在全域範圍趴趴走，來自於其他同學的[前車之鑑](https://chat.lidemy.com/lidemy/pl/o3o3xk4nufyubrqrejk31e5jso)
  - 兩個常用的狀態判定
    - is_session_started() 經過[測試](https://gist.github.com/outshaker/eee2a01fb1c4816ccd9e0c44063d5fa9)和參考[網路實作](https://blog.csdn.net/zhezhebie/article/details/102678031)所得到的最終解
    - is_login() 很常用到，所以也包成函數
- 部分程式碼用三元運算子簡化

