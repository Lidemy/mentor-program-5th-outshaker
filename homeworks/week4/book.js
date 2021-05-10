/*
  hw2：最後的考驗
  用 node.js 寫出一個程式並接受參數，輸出相對應的結果，範例如下：
  node hw2.js list // 印出前二十本書的 id 與書名
  node hw2.js read 1 // 輸出 id 為 1 的書籍
  node hw2.js delete 1 // 刪除 id 為 1 的書籍
  node hw2.js create "I love coding" // 新增一本名為 I love coding 的書
  node hw2.js update 1 "new name" // 更新 id 為 1 的書名為 new name

  Base URL: https://lidemy-book-store.herokuapp.com

  | 說明         | Method | path       | 參數                    | 範例            |
  | ------------ | ------ | ---------- | ----------------------- | --------------- |
  | 獲取所有書籍 | GET    | /books     | _limit:限制回傳資料數量 | /books?_limit=5 |
  | 獲取單一書籍 | GET    | /books/:id | 無                      | /books/10       |
  | 新增書籍     | POST   | /books     | name: 書名              | 無              |
  | 刪除書籍     | DELETE | /books/:id | 無                      | 無              |
  | 更改書籍資訊 | PATCH  | /books/:id | name: 書名              | 無              |

  2021-05-10 採用 https 完成簡單的 request 功能封裝
             功能：命令列沒輸入參數時進入 REPL 互動模式
             功能：只顯示一次指令建議，避免重複顯示
*/
const process = require('process')
// const bookstore = require('./bookStore') // use package: request
const bookstore = require('./bookStore-v2') // use native lib: https

const helpStr = `node hw2.js list                       印出前二十本書的 id 與書名
node hw2.js read <id>                  輸出第 <id> 本的書
node hw2.js delete <id>                刪除第 <id> 本的書
node hw2.js create <book name>         新增書本，書名為 <book name>
node hw2.js update 1 <new name>        更新第 <id> 本的書，書名為 <new name>
`
let isNotified = false

const [,, cmd, arg1, arg2] = process.argv
// console.log(cmd, arg1, arg2)

// 執行一次指令
function tick(cmd, arg1, arg2) {
  // 確認參數符合
  switch (cmd) {
    case 'read':
    case 'delete':
    case 'create':
      if (typeof arg1 === 'undefined') {
        console.error('require arg1')
        return
      }
      break
    case 'update':
      if (typeof arg1 === 'undefined' || typeof arg2 === 'undefined') {
        console.error('require arg1 & arg2')
        return
      }
      break
  }

  // 根據指令執行對應動作
  // TODO 執行 request 時暫停，輸入文字
  switch (cmd) {
    case 'list':
      console.log('list')
      bookstore.printBooks()
      break
    case 'read':
      console.log('read', arg1)
      bookstore.getBook(arg1)
      break
    case 'delete':
      console.log('delete', arg1)
      bookstore.delBook(arg1)
      break
    case 'create':
      console.log('create', arg1)
      bookstore.addBook(arg1)
      break
    case 'update':
      console.log('update', arg1, arg2)
      bookstore.editBookName(arg1, arg2)
      break
    default:
      if (!isNotified) { // 只提醒一次，避免重複顯示影響版面
        console.log('不支援的指令，請參照範例：')
        console.log(helpStr)
        isNotified = true
      }
      break
  }
}

function main() {
  if (!cmd) { // enter REPL mode
    const readline = require('readline')
    const rl = readline.createInterface({
      input: process.stdin
    }).on('line', (line) => {
      const [cmd, arg1, arg2] = line.split(' ')
      if (cmd === 'exit') {
        rl.close()
      } else {
        tick(cmd, arg1, arg2)
      }
    }).on('close', () => {
      console.log('bye bye! have a nice day :)')
    })
  } else { // command line
    tick(cmd, arg1, arg2)
  }
}
main()
