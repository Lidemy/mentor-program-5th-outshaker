/*
  hw2：最後的考驗
  用 node.js 寫出一個程式並接受參數，輸出相對應的結果，範例如下：
  node hw2.js list // 印出前二十本書的 id 與書名
  node hw2.js read 1 // 輸出 id 為 1 的書籍
  node hw2.js delete 1 // 刪除 id 為 1 的書籍
  node hw2.js create "I love coding" // 新增一本名為 I love coding 的書
  node hw2.js update 1 "new name" // 更新 id 為 1 的書名為 new name
*/
const process = require('process')
const bookstore = require('./bookStore')

const [,, cmd, arg1, arg2] = process.argv
// console.log(cmd, arg1, arg2)

function main() {
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
      console.log('default')
      break
  }
}
main()
