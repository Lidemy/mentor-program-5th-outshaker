/*
  hw5：自己的函式自己寫
  其實仔細思考的話，你會發現那些陣列內建的函式你其實都寫得出來，因此這一題就是要讓你自己動手實作那些函式！

  我們要實作的函式有兩個：join 以及 repeat。（再次強調，這一題要你自己實作這些函式，所以你不會用到內建的join以及repeat）

  join 會接收兩個參數：一個陣列跟一個字串，會在陣列的每個元素中間插入一個字串，最後回傳合起來的字串。

  repeat 的話就是回傳重複 n 次之後的字串。

  join([1, 2, 3], '')，正確回傳值：123
  join(["a", "b", "c"], "!")，正確回傳值：a!b!c
  join(["a", 1, "b", 2, "c", 3], ',')，正確回傳值：a,1,b,2,c,3

  repeat('a', 5)，正確回傳值：aaaaa
  repeat('yoyo', 2)正確回傳值：yoyoyoyo

*/

function join(arr, concatStr) {
  if(Array.isArray(arr) && typeof(concatStr) === "string"){
    let s = "";
    for(var i = 0; i < arr.length; i++){
      s += arr[i].toString();
      if(i != arr.length - 1){
        s += concatStr;
      }
    }
    return s;
  }else{
    console.error("arr is not array or concatStr is not string");
  }
}

function repeat(str, times) {
  if(typeof(str) === "string" && Number.isInteger(times)){
    let s = "";
    for(var i = 0; i < times; i++){
      s += str;
    }
    return s;
  }else{
    console.error("str is not string or times is not number");
  }
}

console.log(join(['a'], '!'));
console.log(repeat('a', 5));
