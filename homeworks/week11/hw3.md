## 請說明雜湊跟加密的差別在哪裡，為什麼密碼要雜湊過後才存入資料庫

雜湊是不可逆的資料運算，加密是可逆的。

先回憶一下國中化學的可逆反應，例如：氫氣和氧氣可以燃燒合成水，水也可以電解成氫氣和氧氣。不可逆的化學反應則像是紙張燃燒變成灰燼、蛋白質變性，反應完的東西沒辦法變成原本的東西就是不可逆反應。

回到加密和解密，概念上蠻接近化學的可逆反應，因為加密解密、編碼解碼都是在處理資料，大部分情況不希望資料在處理過程中有失真的狀況，所以理論上都是可逆的運算。

雜湊的特別之處在於它是不可逆的數學函數，舉個簡單例子如 y = f(x) = x % 10 這就是不可逆函數。
f(11) = f(101) = 1，我們沒辦法從 y = 1 去逆推原始的 x 是 11 還是 101。
當然雜湊函數並沒有那麼簡單只有 mod 運算，它還有包含其他一系列的複雜的運算，為的是把資料打散，有點像是在煮一鍋蛋花湯，資料就是被攪散的蛋花。

為什麼密碼需要雜湊過才存入資料庫呢？因為假如壞人偷到權限進入資料庫的時候，他會發現裡面的密碼資訊已經被打散，沒辦法逆向重組回原本的密碼。這樣就算壞人拿到密碼資訊也沒辦法登入使用者的帳號，可以有效的降低資安風險。

額外補充：後來有聰明的壞人想到，如果把大家常用的密碼都先雜湊然後做成一張表，那只要知道資料庫用什麼雜湊函數就可以逆推回去了，這就叫做彩虹表攻擊。後來為了防禦彩虹表攻擊，又產生了"加鹽"的防禦方式，就是再雜湊的時候額外加入一些不相關的字串去擾亂雜湊的結果。可是如果連加鹽的方式也被知道的話也是沒救，所以再進階一點的加鹽是"隨機鹽"，這樣可以阻止壞人用"固定鹽"去生產攻擊用的彩虹表。

## `include`、`require`、`include_once`、`require_once` 的差別

- require: 發生引入錯誤的時候會跳 error，程式會掛掉。不能在迴圈內引用，適合靜態引入，效能比較好。
- include: 發生引入錯誤的時候會跳 warning，程式還會執行下去。可以在迴圈內引用，適合動態引入，效能比較差。
- require_once, include_once: 跟原本的效果一樣，但會額外檢查是否重複引用，可以避免重複引用的錯誤

## 請說明 SQL Injection 的攻擊原理以及防範方法

一般沒特別處理的 SQL 語句是用字串拼接的方式組成，而且沒有特別檢查使用者的輸入。有心人士可以透過一些特殊符號改變原本 SQL 語句的意思，進而執行原本非預期的 SQL 語句效果。

舉一個 wiki [條目](https://zh.wikipedia.org/wiki/SQL%E6%B3%A8%E5%85%A5)中有介紹，也是很經典的案例
strSQL = "SELECT * FROM users WHERE (name = '" + userName + "') and (pwd = '"+ passWord +"');"
上面是一段檢查使用者登入的 SQL 語句，userName 和 passWord 分別是使用者名稱和密碼。如果有心人士在 userName 和 passWord 都填入 "1' OR '1'='1"。就可以在沒有密碼的情況下登入網站

因為拼接完的 SQL 語句會是 "SELECT * FROM users WHERE (name = '1' OR '1'='1') and (pw = '1' OR '1'='1');"，等於是 "SELECT * FROM users"

目前防止 SQL Injection 最有效的方式是參數化查詢，通常現在程式語言的資料庫函式庫都有提供這功能了，像是 php 連 mysql 資料庫就有 prepare() 函式，使用方法可以參考[官方文件](https://www.php.net/manual/en/mysqli.prepare.php "PHP: mysqli::prepare - Manual")說明。

##  請說明 XSS 的攻擊原理以及防範方法

XSS 是 cross-site script (跨站指令碼) 的縮寫，因為 CSS 已經被使用了，所以 cross 以 x 表示。

常見攻擊手法有以下幾種：
- Stored XSS / Persistent Attack: 將惡意指令碼寫入目標網頁中，在使用者瀏覽目標網頁的時候會執行惡意指令碼達到攻擊的效果。
- Reflected XSS: 在網址的 querystring 參數嵌入惡意指令碼，誘騙使用者點下連結達成攻擊效果。

防範方式是將使用者輸入的字串做轉義 (escape) 處理，細節是把敏感的符號如 &<>"'/ 代換掉，這樣網頁就不會把那些符號轉換成指令碼，而只會當成正常一般字串印出。

參考: [【網頁安全】給網頁開發新人的 XSS 攻擊 介紹與防範 @程式設計板 哈啦板 - 巴哈姆特](https://forum.gamer.com.tw/Co.php?bsn=60292&sn=11267)

## 請說明 CSRF 的攻擊原理以及防範方法

CSRF 是 Cross-site request forgery (跨站請求偽造) 利用的是瀏覽器在跟伺服器聯絡時會自動帶上 cookie 識別資訊的機制，攻擊者在攻擊頁面中放入連向 A 網站的連結，不知情的使用者點開頁面的同時也發出連向 A 網站的請求，而 A 網站的主機沒辦法區分這個請求是使用者自己主動發出還是偽造的請求，於是達成攻擊的效果。

防範方式是瀏覽器在 cookie 增加 SameSite 屬性，如果使用者在 B 網站要連向 A 網站，這時候就會因為不符合 SameSite 而被判定為跨站請求，這時候瀏覽器就不會把 A 網站的 cookie 送出去。這是目前瀏覽器主要的防範手段

如果要在主機上做防範的話，常見會用 CSRF token 的方式，其實就跟 session, cookie 的機制有點像，一樣也是發號碼牌的感覺，只是攻擊者不知道使用者的 CSRF token 的時候，就沒辦法順利攻擊成功。

