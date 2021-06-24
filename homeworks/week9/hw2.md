## 資料庫欄位型態 VARCHAR 跟 TEXT 的差別是什麼

大多數情況，VARCHAR 跟 TEXT 看成是相當的資料類型，以下是比較細微的差異：

- VARCHAR[^1] 可以指定最大長度，但 TEXT 沒辦法指定長度
- TEXT[^2] 在索引的時候必須指定 Index Prefixes[^3]，但 VARCHAR 是可以不加。
- TEXT 不能有預設值，但 VARCHAR 可以設定。
- VARCHAR 搜尋時會處理字串大小寫，但 TEXT 不會。[^4]
- VARCHAR 搜尋效率高於 TEXT。

### 設定資料長度
VARCHAR 在資料前端會附加 1-2 byte 表示資料長度
- 1 位元組，0-255長度的字串
- 2 位元組，超過 255 長度的字串

VARCHAR 指定的最大長度是字元長度，不是位元組長度。(在 MySQL5.0.3 之後修改的)

TEXT 在資料前端會固定附加 2 bytes 標示資料長度 (單位是位元組)

### 設定 Index Prefixes

長度限制
- InnoDB 資料引擎
  - REDUNDANT / COMPACT: 767 bytes
  - DYNAMIC / COMPRESSED: 3072 bytes
- MyISAM 資料引擎: 1000 bytes

### 效能

TEXT 的內部建立臨時表查詢會在磁碟上進行的，因此搜尋效能不會比 VARCHAR 來得好，建議只在有真正需要的時候才在 select 內包含 text 類型的資料。[^5]

## Cookie 是什麼？在 HTTP 這一層要怎麼設定 Cookie，瀏覽器又是怎麼把 Cookie 帶去 Server 的？

cookie 是伺服器發送給瀏覽器作為識別的一串資料，瀏覽器在 request 時如果附上 cookie 資料，伺服器就可以從 cookie 內的資料識別出瀏覽器的身分。

在 HTTP 協議的部分，一開始 server 會在 response header 附帶 Set-Cookie 作為 cookie 設定的提示，然後瀏覽器根據 Set-Cookie 的內容在本地端保存一份 cookie.txt，在下一次發送 request 的時候，瀏覽器會在 header 中附上 cookie。

以下提供幾個常見的 Set-Cookie, Cookie 的範例

- Set-Cookie: username=six;
- Set-Cookie: username=six; Expires:Tue, 22 Jun 2021 08:42:52 GMT;
  到這段時間之前有效
- Set-Cookie: username=six; Max-lifetime:1209600;
  有效時間 14 天

- cookie: preferredlocale=zh-TW

Ref:
1. [Set-Cookie - HTTP | MDN](https://developer.mozilla.org/zh-CN/docs/Web/HTTP/Headers/Set-Cookie)
2. [HTTP cookies - HTTP | MDN](https://developer.mozilla.org/zh-TW/docs/Web/HTTP/Cookies)

## 我們本週實作的會員系統，你能夠想到什麼潛在的問題嗎？

- session 沒有設定 HttpOnly, Secure 有可能會受到 XSS 攻擊和被竊聽。
- session 沒有針對來源 IP 、來源裝置做識別，比較不容易發現會員帳號被盜用的事情
- session_id 可以隨意設定，server 沒有檢查這是不是自己建立的 session？
- 會員密碼是明文保存，一旦資料庫被攻破，資料外流會是蠻大的問題
- SQL 的查詢字串沒有防單引號和分號，可能會受到 SQL 注入攻擊。

另外有一些是後端設定問題，不確定算不算是潛在問題？

- php.ini 有一些設定需要特別再調整才會安全
- Mysql 資料庫需要啟用 server_audit 功能，可以針對一些異常的登入或不太尋常的資料庫查詢 (select id, pass from users where 1) 做稽查
- Mysql 登入帳號的權限設置

有些是想到，但未必有立刻解法。自己目前有導入的是 server_audit 跟 php.ini 設定調整。

心得是蠻多都是後端設定、配置的東西，程式碼的問題也有，一半一半的感覺

Ref:
1. [PHP: 和会话安全相关的配置项 - Manual](https://www.php.net/manual/zh/session.security.ini.php)
2. [HTTP Session 攻擊與防護 | DEVCORE 戴夫寇爾](https://devco.re/blog/2014/06/03/http-session-protection/)


[^1]: [MySQL :: MySQL 8.0 Reference Manual :: 11.3.2 The CHAR and VARCHAR Types](https://dev.mysql.com/doc/refman/8.0/en/char.html)

[^2]: [MySQL :: MySQL 8.0 Reference Manual :: 11.3.4 The BLOB and TEXT Types](https://dev.mysql.com/doc/refman/8.0/en/blob.html)

[^3]: Index Prefixes，以資料前 n 個位元組當作索引內容 [Section 8.3.5, “Column Indexes”](https://dev.mysql.com/doc/refman/8.0/en/column-indexes.html)

[^4]: [mysql中text與varchar與char的區別_關於MYSQL數據庫](http://www.aspphp.online/shujuku/mysqlsjk/gymysql/201701/48552.html) 原話：
	> 在TEXT或BLOB列的存儲或檢索過程中，不存在大小寫轉換。

[^5]: 根據官方文件描述，原文如下：
	> Instances of BLOB or TEXT columns in the result of a query that is processed using a temporary table causes the server to use a table on disk rather than in memory because the MEMORY storage engine does not support those data types (see Section 8.4.4, “Internal Temporary Table Use in MySQL”). Use of disk incurs a performance penalty, so include BLOB or TEXT columns in the query result only if they are really needed. For example, avoid using SELECT *, which selects all columns.

