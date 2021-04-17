function printFactor(n){
  if(Number.isInteger(n) && n > 0){
    for(var i=1;i<=n;i++){
      if(n%i == 0){
        console.log(i);
      }
    }
  }else{
    console.error("It is not a positive integer");
  }
}

printFactor(10);
