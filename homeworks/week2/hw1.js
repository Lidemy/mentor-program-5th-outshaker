function printStars(n){
  if(Number.isInteger(n)){
    for(var i=0;i<n;i++){
      console.log('*');
    }
  }else{
    console.error("It is not a integer");
  }
}

printStars(5)
