## 請找出三個課程裡面沒提到的 HTML 標籤並一一說明作用。

前面三個介紹冷門的，後面兩個是目前標準比較新的標籤

1. [keygen](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/keygen): 最初設計的目的是希望能夠產生一份證書請求，預期處理的結果是一份經過簽署的證書。私鑰會留在本地端，公鑰會送到伺服器。
使用方式是放在 form 標籤內， keytype 指定產出金鑰的演算法，challenge 是跟著公鑰一起送出的字串，keyparams 填入金鑰演算法需要的參數。

```html
<form action="demo_keygen.php" method="get">
  Username: <input type="text" name="usr_name">
  Encryption: <keygen name="security" keytype="RSA">
  <input type="submit">
</form>
```

2. [dir](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/dir): 看名字就知道這標籤是為了呈現目錄結構，因為這標籤在瀏覽器並沒有被廣泛使用，所以 HTML5 已經不推薦使用了。建議改用 ul 標籤
```html
<dir>
    <li>examples</li>
    <li>tutorials</li>
</dir>
```

3. [menu](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/menu): 這個標籤是為了建立工具列選項或是建立自訂的右鍵選單。這個標籤在 HTML4 標準被棄用，但是在 HTML5 目前標準又重新被提出來了！
模擬 google 地圖的右鍵選單
```html
<menu type="context" id="popup-menu">
  <menuitem>25.18612, 121.55437</menuitem>
  <menuitem>從這裡出發的路線</menuitem>
  <menuitem>到達此處的路線</menuitem>
  <menuitem>這裡是哪裡？</menuitem>
  <menuitem>搜尋附近的地區</menuitem>
  <hr>
  <menuitem>列印</menuitem>
  <menuitem>新增遺漏的地點</menuitem>
  <menuitem>加入你的商家</menuitem>
  <menuitem>回報資料問題</menuitem>
  <menuitem>測量距離</menuitem>
</menu>
```

4. [dialog](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/dialog): 用來建立可以互動的對話框，目前屬於 [HTML Living Standard](https://html.spec.whatwg.org/multipage/forms.html#the-dialog-element)
```
<dialog id="favDialog">
  <form method="dialog">
    <p><label>Favorite animal:
      <select>
        <option></option>
        <option>Brine shrimp</option>
        <option>Red panda</option>
        <option>Spider monkey</option>
      </select>
    </label></p>
    <menu>
      <button value="cancel">Cancel</button>
      <button id="confirmBtn" value="default">Confirm</button>
    </menu>
  </form>
</dialog>
```
open 屬性可以決定對話框是否要顯示？

5. [summary](https://developer.mozilla.org/zh-TW/docs/Web/HTML/Element/summary), [details](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/details): 用來建立可折疊的內容，作業的 README 文件就是用這個來把提示摺疊起來的
```html
<details>
  <summary>提示 #1</summary>
  這題可以暴力解，試著舉出每一種可能的組合
</details>
```
open 屬性可以控制內容要不要顯示出來

參考：[HTML 元素 - HTML：超文本標記語言 | MDN](https://developer.mozilla.org/zh-TW/docs/Web/HTML/Element)

## 請問什麼是盒模型（box modal）

盒子模型是 CSS 用來排版的依據，主要有兩種盒子
- block box
- inline box

大部分元素可以分成 block, inline 兩大類，這兩種類型的 box 在排版上的規則不太一樣。

但先談一下 box 模型中存在的幾個屬性
- margin 外邊距。box 跟其他 box 的距離
- border 邊框。box 的邊界標準。
- padding 內邊距。box 內部元素向內縮的距離
- width, height box 的長寬。預設是 content 的長寬，但也可以改成對應到 border 的長寬
- position 位置屬性。通常在非 position: static 的狀況才會使用

## 請問 display: inline, block 跟 inline-block 的差別是什麼？

- block 可以設定長寬，但會占用一整列空間。特性是排列由上而下
- inline 不能設定長寬，只能靠自身的內容撐開。特性是排列有左至右
- inline-block 具備 inline 和 block 的特質的。排列方向是由左至右

我覺得目前懂這些就很足夠了 XDD

## 請問 position: static, relative, absolute 跟 fixed 的差別是什麼？

- static, relative: 都在 normal flow 排版流裡面
  - relative 可以讓元素離開原本的位置，讓元素有位移的效果，參考點是母元素。
    也可以讓自身變成後續 position: absolute 元素的參考對象

- absolute, fixed: 離開 normal flow 排版流，對後續的元素來說是這些特性的元素是不存在的
  - absolute 往前找非 static 的元素當參考對象
  - fixed 是直接以瀏覽器螢幕作為定位，卷軸不管怎麼捲，元素都會固定在同樣的位置上

absolute 和 relative 的感覺很像，但是差別就在於有沒有在 normal flow 之內。
absolute 很像浮在空中的感覺
relative 很像放風箏，底下還是會占用元素的空間

absolute 和 fixed 名字很容易搞混，所以我自己會用火箭和同步衛星來比擬
absolute 像是發射火箭
fixed 像是升空之後停留在固定位置的衛星，或者像是月亮或太陽在遠方的感覺，可以自己想像 :)

