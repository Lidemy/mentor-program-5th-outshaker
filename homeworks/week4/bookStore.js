// https://lidemy-book-store.herokuapp.com API 封裝
const request = require('request')

const BASE = 'https://lidemy-book-store.herokuapp.com'
// 基本處理常式，將 body 打包
function _basicHandler(err, res, body) {
  try {
    return JSON.parse(body)
  } catch (e) {
    console.error(e)
  }
  return {} // 回傳空的 object 避免後續操作問題
}

const bookStoreAPI = {
  // 列出所有書本。limit 為限制大小
  printBooks(limit = 20) {
    request.get({ url: `${BASE}/books?_limit=${limit}` }, (err, res, body) => {
      if (res.statusCode >= 200 && res.statusCode < 300) {
        const books = _basicHandler(err, res, body)
        books.forEach((book) => { console.log(book.id, book.name) })
      }
    })
  },
  getBook(id) {
    request.get({ url: `${BASE}/books/${id}` }, (err, res, body) => {
      if (res.statusCode >= 200 && res.statusCode < 300) {
        const book = _basicHandler(err, res, body)
        console.log(book.name)
      } else {
        console.log('沒有這本書')
      }
    })
  },
  delBook(id) {
    request.delete({ url: `${BASE}/books/${id}` }, (err, res, body) => {
      if (res.statusCode >= 200 && res.statusCode < 300) {
        console.log('已移除書本')
      } else {
        console.log('該書本不存在')
      }
    })
  },
  addBook(name) {
    request.post({
      url: `${BASE}/books`,
      form: { name }
    }, (err, res, body) => {
      if (res.statusCode >= 200 && res.statusCode < 300) {
        const book = _basicHandler(err, res, body)
        console.log(`已新增書本：${res.headers.location}\n${book}`)
      } else {
        console.log('書本穿越到時空的狹縫中消失不見了')
      }
    })
  },
  editBookName(id, newBookName) {
    request.patch({
      url: `${BASE}/books/${id}`,
      form: { name: newBookName }
    }, (err, res, body) => {
      if (res.statusCode >= 200 && res.statusCode < 300) {
        const book = _basicHandler(err, res, body)
        console.log(`已更新的書名：${book.name}`)
      } else {
        console.log('該書本不存在')
      }
    })
  }
}
module.exports = bookStoreAPI
