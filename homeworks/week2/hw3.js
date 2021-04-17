function reverse(str){
  if(typeof(str) == "string"){
    let list = [];
    let size = str.length;
    for(var i=0;i<size;i++){
      list[size-1-i] = str[i];
    }
    return list.join('');
  }else{
    console.error("It is not string");
  }
}

reverse('hello');
