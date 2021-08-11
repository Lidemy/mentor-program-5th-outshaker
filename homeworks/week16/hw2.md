# hw2：Event Loop + Scope

請說明以下程式碼會輸出什麼，以及盡可能詳細地解釋原因。

``` js
for(var i=0; i<5; i++) {
  console.log('i: ' + i)
  setTimeout(() => {
    console.log(i)
  }, i * 1000)
}
```

結果會是
```
i: 0
i: 1
i: 2
i: 3
i: 4
5
5
5
5
5
```

延續第一題的經驗，我們可以知道 console.log('i: ' + i) 會被送到 call stack 然後 pop 出來被執行。
而 setTimeout(...) 的部份則是會送到 WebAPI 區塊執行， timeout 到的話就會把 console.log(i) 送到 task queue。當 for 迴圈內的 console.log('i: ' + i) 全數執行完之後，call stack 沒有東西，然後 task queue 裡面的 console.log(i) 則依序推到 call stack 被執行。

因為變數 i 是在 for() 裡面用 var 宣告的，它的作用範圍是全域的，所以任何地方都可以讀取。而 i 在迴圈最後一輪經過 i++ 之後變成 5 ，因而造成迴圈結束。所以後面的 console.log(i) 都會印出 5。

---

附帶一提，如果把 var 改成 let 的話，印出來的 i 就會是最初呼叫 setTimeout(...) 時候的 i 值。因為 let 的作用域是 block 層級，它可以讓 i 的內容維持在被呼叫時的狀態。



