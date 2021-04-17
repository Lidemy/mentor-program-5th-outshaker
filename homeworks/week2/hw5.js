
function join(arr, concatStr){
  if(Array.isArray(arr) && typeof(concatStr) == "string"){
    let s = "";
    for(var i=0;i<arr.length;i++){
      s += arr[i].toString();
      if(i != arr.length-1){
        s += concatStr;
      }
    }
    return s;
  }else{
    console.error("arr is not array or concatStr is not string")
  }
}

function repeat(str, times){
  if(typeof(str) == "string" && Number.isInteger(times)){
    let s = "";
    for(var i=0;i<times;i++){
      s += str;
    }
    return s;
  }else{
    console.error("str is not string or times is not number")
  }
}

console.log(join(['a'], '!'));
console.log(repeat('a', 5));
