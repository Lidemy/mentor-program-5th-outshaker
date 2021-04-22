// hw5 [LIOJ1004 - 聯誼順序比大小](https://oj.lidemy.com/problem/1004)
const readline = require('readline')

const rl = readline.createInterface({
  input: process.stdin
})

const lines = []

// 讀取到一行，先把這一行加進去 lines 陣列，最後再一起處理
rl.on('line', (line) => { lines.push(line) })

// 輸入結束，開始針對 lines 做處理
rl.on('close', () => { solve(lines) })

// 上面都不用管，只需要完成這個 function 就好，可以透過 lines[i] 拿取內容
// x > y: true
function comp (x, y) {
  if (x.length > y.length) {
    return 1
  } else if (x.length === y.length) {
    if (x === y) {
      return 0
    } else if (x > y) {
      return 1
    } else {
      return -1
    }
  } else {
    return -1
  }
}

function solve (lines) {
  const m = Number(lines[0])
  for (let i = 1; i <= m; i++) {
    const [a, b, k] = lines[i].split(' ')
    // console.log(a,b,k)
    const compResult = comp(a, b)
    if (k === '1' && compResult === 1) {
      console.log('A')
    } else if (k === '-1' && compResult === -1) {
      console.log('A')
    } else if (k === '1' && compResult === -1) {
      console.log('B')
    } else if (k === '-1' && compResult === 1) {
      console.log('B')
    } else {
      console.log('DRAW')
    }
  }
}
