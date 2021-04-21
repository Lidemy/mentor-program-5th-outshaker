/*
  hw2：首字母大寫
  給定一字串，把第一個字轉成大寫之後「回傳」，若第一個字不是英文字母則忽略。

  capitalize('nick')
  正確回傳值：Nick

  capitalize('Nick')
  正確回傳值：Nick

  capitalize(',hello')
  正確回傳值：,hello
*/

function capitalize(str) {
  if(typeof(str) === "string"){
    let first = str[0].toLowerCase();
    if(first >= 'a' && first <= 'z')
      return first.toUpperCase() + str.slice(1);
    else
      return str;
  }else{
    console.error("It is not string");
  }
}

console.log(capitalize('hello'));
