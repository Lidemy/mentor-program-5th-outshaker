## 什麼是 Ajax？

Ajax 是 Asynchronous JavaScript and XML 的縮寫，意思是非同步的 JavaScript 和 XML。

早期的網頁主要以網頁表單和網站溝通，但表單送出後，需要等待伺服器返回新的頁面才能繼續瀏覽。
在瀏覽體驗上不是很理想，同時這樣的運作方式對伺服器也是一種效能上的負擔。

Ajax 這項技術最主要的好處是讓瀏覽器可以在不用刷新頁面的情況下動態地接受網站送回的資料，也促成了一個串聯不同網站服務的機會，算是 web2.0 當時的代表技術。

XMLHttprequest() 是目前瀏覽器 Ajax 技術實現的共同標準，於 2005 年公布。在 2014 年發布的 HTML5 標準提供了 Fetch API，被認為是比 XMLHttprequest() 更好的選擇，除了更簡易的使用方式，也支援 Promise。

總之，Ajax 是一組技術組合的總稱，它為瀏覽器和網站提供了更彈性的互動方式。

## 用 Ajax 與我們用表單送出資料的差別在哪？

Ajax 跟表單最大的差異是一個非同步一個同步（雖然嚴格來說，XMLHttprequest() 也有同步的選項，但大部分應用場景還是以非同步為主)
Form 的 method 只能選擇 GET, POST。而 XMLHttprequest() 則是全部的 http method 都可以使用。
Form 通常會搭配 input 做簡易的資料驗證，同時在瀏覽器層級支援自動完成，例如帳號密碼、手機、地址等。XMLHttprequest() 相對來說在這部分比較薄弱。
Form 是把資料組合送到另一個網址處理，會有頁面跳轉的狀況。而 XMLHttprequest() 是在原本的頁面接收送回的結果。
整理來說 XMLHttprequest() 比較通用，Form 則是有它主要的應用場景

## JSONP 是什麼？

JSONP 是 JSON with Padding 的意思。

以下一個簡單範例：
```html
 <script type="text/javascript"
         src="http://server2.example.com/RetrieveUser?UserId=1823&jsonp=parseResponse">
 </script>
```

假設我告訴 server2.example.com 這網站要把回傳的資料給 parseResponse() 執行，於是它回傳下面的**程式碼** 回來
`parseResponse({"Name": "小明", "Id" : 1823, "Rank": 7})`

然後網頁拿到這段程式碼之後執行它要的函式

JSONP 的特殊性在於它是 script 標籤沒有被瀏覽器的同源政策限制才得以實現的技術。
同源政策是瀏覽器為了資料的安全性 (不讓網頁能夠隨意拿到它不該拿的資料)，所以限制網頁能讀取的資料範圍。
但因為這樣網頁什麼東西都拿不到也不行，所以 img, link, script, iframe 這些內嵌形式的標籤還是允許的。

查相關資料的時候有看到這技術的安全隱憂，另外我也必須承認我自己沒有實際使用過這項技術，所以我覺得我自己在理解上應該還是有很大的落差。

## 要如何存取跨網域的 API？

一般的跨網域 API 呼叫會發送預檢請求 (Preflight Request) 給 API 伺服器，API 伺服器回應之後才會發送真正的 API request。
發送預檢請求的目的是希望瀏覽器在送出一些敏感資訊之前可以先確認和檢查，但如果是屬於「簡單呼叫」類型的話，瀏覽器就不會發送預檢請求。
Preflight Request 的形式是瀏覽器以 OPTIONS 發送之後會發送的 origin, method, header, max-age，如果 API 伺服器許可的話就會送回包含以下標頭名稱的 response

回傳標頭：
- Access-Control-Allow-Origin
  允許的來源，如果是 * 代表任何來源網域都接受
- Access-Control-Expose-Headers
  表示伺服器允許瀏覽器存取回應標頭的名稱，預期瀏覽器呼叫 getResponseHeader() 的時候可以拿到
- Access-Control-Allow-Headers
  告訴瀏覽器有哪些可用的標頭名稱
- Access-Control-Max-Age
  表示預檢請求的快取保留時間
- Access-Control-Allow-Credentials
  帶有 cookie 的身分認證的呼叫需要有 true，不然瀏覽器會無視
- Access-Control-Allow-Methods
  告訴瀏覽器可以接受的方法

自己在實作 ajax 串接的時候一直以為是要自己發送預檢請求，但後來才知道這部分是瀏覽器自己完成的，通常只要注意自己有沒有漏掉該送出的標頭就可以了

## 為什麼我們在第四週時沒碰到跨網域的問題，這週卻碰到了？

跨域問題是瀏覽器設下的~~網羅~~安全機制，它主要是防堵引入的程式碼讀取它自身以外的資源。
第一個約束是同源政策 (Same Origin Policy)，所有不同域的資源沒辦法讀取，確保程式碼不會拿到不該拿的東西。
可是程式碼拿不到東西也沒辦法做事情，所以第二個安全機制是跨來源存取 (Cross-Origin HTTP request) ，這個機制的精神是拿別人東西之前要先問別人可不可以拿

然後為什麼 nodejs HTTP request 沒有這個問題呢？
我在想應該是因為 nodejs 跟外部網域的溝通都是端點對端點，並不像網頁內是多個來源的程式碼共存且互動的情況

