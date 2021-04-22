// hw2 [LIOJ1025 - 水仙花數](https://oj.lidemy.com/problem/1025)
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
function isNarcNum (n) {
  const str = n.toString()
  const size = str.length
  let nList = str.split('')
  nList = nList.map((c) => Number(c) ** size)
  const sum = nList.reduce((s, v) => s + v)
  return sum === n
}

function solve (lines) {
  const tokens = lines[0].split(' ')
  const n = Number(tokens[0])
  const m = Number(tokens[1])
  for (let i = n; i <= m; i++) {
    if (isNarcNum(i)) {
      console.log(i)
    }
  }
}
