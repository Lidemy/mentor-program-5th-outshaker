## Webpack 是做什麼用的？可以不用它嗎？

webpack 是一個可以幫你管理、打包的工具。

那為什麼需要 webpack 呢？因為 js 開始流行模組化寫法(CommonJS, ESM)之後，大家習慣把檔案拆成很多個小模組，但這些小模組如果放在頁面讀取的話要一個一個載入很麻煩，所有就有人想要那乾脆打包成一個單一檔案就好了。同時還有個問題是這種模組化的 js 語法，在舊版本瀏覽器上面根本跑不起來，需要借助 babel 這個工具協助把很新很潮的 es6 import 語法轉換成舊版瀏覽器看得懂的語法。另外還有做一些優化的動作，。

可以不用它嗎？當然是可以的，但就是維護程式碼的時候比較痛苦而已

## gulp 跟 webpack 有什麼不一樣？

gulp 的面向比較像是任務管理，gulp 把一些常見的操作變成可以自動化完成的任務流。像是做 js 壓縮混淆的 gulp-uglify、壓縮 css 的 gulp-minify-css。
webpack 的面向則是資源管理，webpack 可以把 js, css, 做編譯、打包，最後輸出成一個檔案。
兩者關注的面向不同，大致如此

## CSS Selector 權重的計算方式為何？

CSS Selector 的權重等級分成四個等級：

1. inline-style
2. id selector
3. class selector, attribute selector, Pseudo classes
4. tag, pseudo-elements

`*` 沒有權重，可以忽略不計。

在樣式規則中使用到一次選擇器，它的計數就會 +1。

例如：
h1 .cls1 .cls2 => 0,0,2,1
h1+h1 => 0,0,0,2

比較權重的時候，會先從權重等級高的開始比較，若相等的話就比較後面的權重等級，如果全部都相等的話，則以較後面出現的樣式為主。
另外 !important 如果出現的話就會被當成是權重最高的，但如果兩個樣式都有 !important 的話，還是需要比較後面的權重等級。
inline-style 優先於 !important，沒有任何樣式規則比 inline-style 更高。

