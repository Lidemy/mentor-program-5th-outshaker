/*
  hw1：印出星星
  給定 n（1<=n<=30），依照規律「印出」正確圖形
  printStars(1)

  正確輸出：
  *
  printStars(3)

  正確輸出：
  *
  *
  *
  printStars(6)

  正確輸出：
  *
  *
  *
  *
  *
  *
  
*/

function printStars(n) {
  if(Number.isInteger(n)){
    for(var i = 0; i < n; i++){
      console.log('*');
    }
  }else{
    console.error("It is not a integer");
  }
}

printStars(5)
