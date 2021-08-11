# hw3：Hoisting

請說明以下程式碼會輸出什麼，以及盡可能詳細地解釋原因。

``` js
var a = 1
function fn(){
  console.log(a)
  var a = 5
  console.log(a)
  a++
  var a
  fn2()
  console.log(a)
  function fn2(){
    console.log(a)
    a = 20
    b = 100
  }
}
fn()
console.log(a)
a = 10
console.log(a)
console.log(b)
```

結果會是
```
undefined
5
6
20
1
10
100
```

程式執行到 fn()
第一個 console.log(a) 印出 undefined，這是因為下面那一行的 var a = 5 被 hosting，a 處在已宣告但未賦值的狀態
第二個 console.log(a) 印出 5，這是因為執行過 a = 5 所以內容被更新了
執行 a++，在 fn() 裡面的 a 更新為 6
然後執行到 fn2()，雖然 fn2 的函數宣告在下面，但因為 function fn2(){...} 被 hosting，所以是可以呼叫的狀態
在 fn2() 裡面的 console.log(a) 印出 6，因為沒有參數傳入，所以往上一層 scope 找 a，所以印出 fn() 內的 a 也就是 6
在 fn2() 內執行 a = 20，在 fn() 裡面的 a 更新為 20
在 fn2() 內執行 b = 100，因為一路往上都沒有找到 b，所以在全域 global 建立 b 並設定內容為 200
離開 fn2() 之後執行 console.log(a) 印出 20
離開 fn()，這時候的作用域 a => 1 b => 100
console.log(a) 印出 1
設定 a = 10
console.log(a) 印出 10
console.log(b) 印出 100

