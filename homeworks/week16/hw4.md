# hw4：What is this?

請說明以下程式碼會輸出什麼，以及盡可能詳細地解釋原因。

``` js
const obj = {
  value: 1,
  hello: function() {
    console.log(this.value)
  },
  inner: {
    value: 2,
    hello: function() {
      console.log(this.value)
    }
  }
}
  
const obj2 = obj.inner
const hello = obj.inner.hello
obj.inner.hello() // ??
obj2.hello() // ??
hello() // ??
```

結果會是
```
2
2
undefined
```

呼叫 obj.inner.hello() 的時候，發起呼叫的物件是 obj.inner，所以 this 會指向它。
然後因為 obj.inner.value 是 2 所以印出來是 2

呼叫 obj2.hello() 的時候，發起呼叫的物件是 obj2，所以 this 會指向它。
然後因為 obj2 其實就是 obj.inner，所以結果會跟上面是一樣的

最後呼叫 hello()，前面沒有物件的時候，發起呼叫的就會是 [[global]] 但是在 global 下面沒有 value 這個變數，所以印出 undefined

