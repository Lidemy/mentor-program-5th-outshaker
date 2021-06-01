## 什麼是 DOM？

DOM 是 Document Object Model 的縮寫，中文名稱為文件物件模型。它描述了一個程式操作 HTML 文本的介面，可以動態的讀取、更新 HTML 文本（內容、結構、樣式）。但它本身不依賴平台和實作語言，所以算是規格建議，必須要加上程式語言實作才是完整的 API 。

介紹常見的 DOM 操作 [^1]
- document.querySelector(selector) 選取符合條件的單一元素
- document.querySelectorAll(name) 選取所有符合的元素
- document.createElement(name) 建立元素
- parentNode.appendChild(node) 在上層節點中附加元素
- element.innerHTML 設定元素內的 HTML 內容 (會動態的變成文本內容)
- element.style 查詢/設定元素的樣式
- element.setAttribute() 設定元素的屬性
- element.getAttribute() 查詢元素的屬性
- element.addEventListener() 幫元素增加事件監聽器
- GlobalEventHandlers/onload 全局事件，可以在頁面載入後觸發
- window.scrollTo() 捲動頁面

常見的物件類型
- Document
  主要窗口，幾乎常見的操作都要透過它完成。例如：document.querySelector(), document.createElement()
- Node
  節點，所有文本結構的基礎。一般不會直接操作它
- Element
  元素，所有的標籤都可以視為元素
- NodeList
  節點列表 document.querySelectorAll() 回傳的結果就是 NodeList 類型 [^2]
- Attribute
  屬性。一般是透過 element.setAttribute(), element.getAttribute() 操作
- NamedNodeMap
  用來保存屬性的集合

## 事件傳遞機制的順序是什麼；什麼是冒泡，什麼又是捕獲？

事件[^3][^4] 在 tree 結構中的傳遞順序是從 document, body 一路往下傳到事件要送達的 target (目標元素) 之後，再返還回去一次。
冒泡是指事件從 target 傳遞到 document 的這段過程。此時可以在 event.eventPhase 中確認內容值為 BUBBLING_PHASE (3)
捕獲是指事件從 document 傳遞到 target 的這段過程。此時可以在 event.eventPhase 中確認內容值為 CAPTURING_PHASE (1)
附帶一提，事件傳遞到 target 時，event.eventPhase 為 AT_TARGET(2)

## 什麼是 event delegation，為什麼我們需要它？

按照原本 element.addEventListener() 的作法幫元素增加事件監聽，在 element 數量很多的時候會很難有效管理，也會消耗掉程式資源和拖慢效能。
事件代理 (event delegation) 是利用事件傳遞本身的機制來簡化事件管理的作法，因為事件在傳遞的時候會經過 target 的上層元素，所以只要在上層元素增加事件監聽就可以攔截。

實作上需要注意的地方是，因為事件的 target 不是上層元素，所以需要對 taget 檢查才可以正常運作，不然原本是觸發別人的事件變成自己也會觸發。另外事件代理通常會在冒泡階段進行，避免影響原本的事件表現。

## event.preventDefault() 跟 event.stopPropagation() 差在哪裡，可以舉個範例嗎？

先講結論，preventDefault() 是阻止事件的預設行為，但是事件流仍然會傳下去。
stopPropagation() 則是阻止事件流，但是元件的預設行為仍然會執行。

舉例來說

```
<!doctype html>
<html lang="zh">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
</head>
<body>
  <div id="div1">
   <a id="hyper" href="#test">Harry's Tech World</a>
  </div>
  <div id="test">hihi</div>
  <script type="text/javascript">
    let e = document.querySelector("#hyper")
    let d = document.querySelector("#div1")
    d.addEventListener("click", () => {
      // event.preventDefault();
      event.stopPropagation()
      console.log("div1 click capture");
    },true);
    e.addEventListener("click", () => {
      console.log("hyper click capture");
    }, true);
    e.addEventListener("click", () => {
      console.log("hyper click bubble");
    }, false);
    d.addEventListener("click", () => {
      console.log("div1 click bubble");
    });
  </script>
</body>
</html>
```

在這個例子中
- 使用 event.stopPropagation() 的話，事件流會終止，頁面連結還是會跳轉
- 使用 event.preventDefault() 的話，事件流會繼續，只是連結跳轉的預設行為取消了

[^1]: 參考來源: https://developer.mozilla.org/en-US/docs/Web/API/Document_Object_Model/Introduction
[^2]: https://developer.mozilla.org/en-US/docs/Web/API/NodeList 談到 NodeList 有分 Live 和 Static
[^3]: https://dom.spec.whatwg.org/#introduction-to-dom-events 介紹事件的概念
[^4]: https://dom.spec.whatwg.org/#dispatching-events 介紹事件傳遞的完整過程，非常接近程式實作

