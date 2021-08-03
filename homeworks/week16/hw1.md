# hw1：Event Loop

在 JavaScript 裡面，一個很重要的概念就是 Event Loop，是 JavaScript 底層在執行程式碼時的運作方式。請你說明以下程式碼會輸出什麼，以及盡可能詳細地解釋原因。

```js
console.log(1)
setTimeout(() => {
  console.log(2)
}, 0)
console.log(3)
setTimeout(() => {
  console.log(4)
}, 0)
console.log(5)
```

結果會是
```
1
3
5
2
4
```

執行到第一行，JS runtime 會把 console.log(1) 函式呼叫丟到 call stack 中，然後被 pop 出來立即執行
執行到第二行，JS runtime 把 setTimeout(...) 這段程式碼呼叫丟到由 browser 控制的 WebAPI 區塊 ，然後經過 0ms 之後把 console.log(2) 函式呼叫送往 task queue 等待執行
執行到第三行，JS runtime 會把 console.log(3) 函式呼叫丟到 call stack 中，然後被 pop 出來立即執行
執行到第四行，JS runtime 把 setTimeout(...) 這段程式碼呼叫丟到由 browser 控制的 WebAPI 區塊 ，然後經過 0ms 之後把 console.log(4) 函式呼叫送往 task queue 等待執行
執行到第五行，JS runtime 會把 console.log(5) 函式呼叫丟到 call stack 中，然後被 pop 出來立即執行
然後等到 call stack 被清空，這時候 task queue 裡面的東西就會被移到 call stack 被執行，因為 queue 是屬於先進先出的資料結構，所以會先執行 console.log(2) 再執行 console.log(4)

可以參考這個[網站](https://www.jsv9000.app/) ，它可以把以上程式碼轉換成可以看見的執行動畫