/*
  hw3：反轉字串
  給定一個字串，請「印出」反轉之後的樣子（不能使用內建的 reverse 函式）

  reverse('yoyoyo')
  正確輸出：oyoyoy

  reverse('1abc2')
  正確輸出：2cba1

  reverse('1,2,3,2,1')
  正確輸出：1,2,3,2,1
*/

function reverse(str) {
  if(typeof(str) === "string"){
    let list = [];
    let size = str.length;
    for(var i = 0; i < size; i++){
      list[size-1-i] = str[i];
    }
    return list.join('');
  }else{
    console.error("It is not string");
  }
}

reverse('hello');
