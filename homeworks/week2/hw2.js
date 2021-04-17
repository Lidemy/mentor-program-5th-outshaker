function capitalize(str){
  if(typeof(str) == "string"){
    let first = str[0].toLowerCase();
    if(first >= 'a'&& first <= 'z')
      return first.toUpperCase() + str.slice(1);
    else
      return str;
  }else{
    console.error("It is not string");
  }
}

console.log(capitalize('hello'));
