## 請以自己的話解釋 API 是什麼
API 是高等巫師發明的法術，這些法術記載於法典之中。這些法術有非常嚴謹的咒語格式和定義，所以巫師們通常需要一手捧著法典 (API 文件) 才有辦法成功施放法術。剛好小弟弟我跟隔壁村的雜貨商人那買了法典的手抄卷，我們一起來看看吧！

### Web API
#### request 格式
[method] [URL] [query_string]
[header]
[body]

* method 方法
	- GET 取得資源
	- POST 提交資源
	- DELETE 刪除資源
	- PATCH 修改資源
* URL 資源路徑
* query string 查詢字串，傳送資料 & 設定選項
* header 標頭，可以放資料參數
* body 內容，使用 POST, PATCH 方法時把要傳送的資料放在這裡

#### response 格式
[statusCode][statusMessage]
[header]
[body]

* statusCode 狀態碼 2xx - 5xx，API 執行狀況
	- 2xx 正常
	- 3xx 資源轉向
	- 4xx 使用者端錯誤
	- 5xx 伺服器端錯誤
* statusMessage 狀態碼文字，API 執行狀況
* header 標頭，可以放資料參數
* body 內容，主機回傳的結果，格式為 json, xml, text 等

---

## 請找出三個課程沒教的 HTTP status code 並簡單介紹
* 101 Switching Protocols：伺服器通知客服端切換協定，伺服器會在 response 的封包標頭 Upgrade 項目中指示用戶端要切換的協定，例如： HTTP/2、WebSocket。
* 400 Bad Request：通常在 API 呼叫格式錯誤時回傳。
* 451  Unavailable For Legal Reasons：因法律問題而無法使用，通常是因為政治敏感因素導致伺服器無法提供該內容。451 典故出自反烏托邦小說《華氏451度》，而華氏451度為紙的燃點。

參照 [HTTP 451 - 維基百科，自由的百科全書](https://zh.wikipedia.org/wiki/HTTP_451)

---

## 假設你現在是個餐廳平台，需要提供 API 給別人串接並提供基本的 CRUD 功能，包括：回傳所有餐廳資料、回傳單一餐廳資料、刪除餐廳、新增餐廳、更改餐廳，你的 API 會長什麼樣子？請提供一份 API 文件。

因為純 markdown 語法實在不容易撰寫文件和拉表格，所以後來去找了一樣也是 markdown 風格但是比較好寫的 API blueprint 語法，然後以 npm aglio 套件將 API blueprint 內容生成 html 文件。

文件清單：
- week4/foodmap.apib 文件本體，類似 markdown 語法
- week4/foodmap.html 生成文件
- https://foodmap2.docs.apiary.io/ 線上版本

### 摘要說明
餐廳資訊：店家編號、店家名稱、店家圖片網址、料理類型、營業時間、店家地址、店家粉絲專頁連結、店家電話、五星評等、評論數、用餐價位

#### 基本 CRUD 功能：
* 回傳所有餐廳資料：透過 limit, offset 取得一部分餐廳資料
	- 200 找到資料
* 回傳單一餐廳資料：透過 id 取得餐廳資料
	- 200 找到資料
	- 404 找不到
* 新增餐廳：提供店家基本資料，不用五星評等、評論數、用餐價位資訊
	- 201 新增成功
	- 400 缺少必要參數或參數格式不符時回傳參數錯誤
* 更改餐廳
	- 200 修改成功
	- 400 缺少必要參數或參數格式不符時回傳參數錯誤
	- 403 權限不足
	- 404 找不到
* 刪除餐廳
	- 204 刪除成功
	- 403 權限不足
	- 404 找不到

#### 探索
這部分主要開放給使用者方便查詢，以地區、料理類型作為主要分類。排序依據可以選擇**最近新增、評等、人氣**。另外也可以篩選出**營業中**的餐廳。

#### 狀態碼
參考其他 API 文件，根據常見的使用情境補充

### 參考對象
https://ifoodie.tw/
主要參考他們的網址結構、搜尋參數

