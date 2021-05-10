// use native https implement req(method, url, form, callback), req(method, url, callback)
const https = require('https')

// 封裝 https.request()
function req(method = 'GET', url, form, callback = null) {
  const methods = ['GET', 'POST', 'DELETE', 'PATCH']
  if (!methods.includes(method)) {
    console.error(`unsupported method: ${method}`)
    return
  }
  if (typeof form === 'function' && !callback) { // move arg to correct location
    [callback, form] = [form, callback]
  }
  const options = { method }
  const _req = https.request(url, options, (res) => {
    const buf = []
    res.on('data', (d) => {
      buf.push(d)
    }).on('end', () => {
      try {
        const data = Buffer.concat(buf).toString()
        const body = JSON.parse(data) // parse data to json
        callback(0, res, body)
      } catch (err) {
        callback(err)
      }
    }).on('error', (err) => {
      callback(err)
    })
  }).on('error', (err) => {
    callback(err)
  })
  if (form && typeof form === 'object' && (method === 'POST' || method === 'PATCH')) {
    _req.setHeader('Content-Type', 'application/json')
    _req.write(JSON.stringify(form))
  }
  _req.end()
}

const bookStoreAPI = {
  BASE: 'https://lidemy-book-store.herokuapp.com',
  printBooks(limit = 20) {
    req('GET', `${this.BASE}/books?_limit=${limit}`, (err, res, books) => {
      if (err) {
        console.error(err)
        return
      }
      if (res && res.statusCode >= 200 && res.statusCode < 300) {
        books.forEach((book) => { console.log(book.id, book.name) })
      }
    })
  },
  getBook(id) {
    req('GET', `${this.BASE}/books/${id}`, (err, res, book) => {
      if (err) {
        console.error(err)
        return
      }
      if (res && res.statusCode >= 200 && res.statusCode < 300) {
        console.log(book.name)
      } else {
        console.log('沒有這本書')
      }
    })
  },
  delBook(id) {
    req('DELETE', `${this.BASE}/books/${id}`, (err, res, body) => {
      if (err) {
        console.error(err)
        return
      }
      if (res.statusCode >= 200 && res.statusCode < 300) {
        console.log('已移除書本')
      } else {
        console.log('該書本不存在')
      }
    })
  },
  addBook(name) {
    req('POST', `${this.BASE}/books`, { name }, (err, res, book) => {
      if (err) {
        console.error(err)
        return
      }
      if (res.statusCode >= 200 && res.statusCode < 300) {
        console.log(`已新增書本：${res.headers.location}\n${book.name}`)
      } else {
        console.log('書本穿越到時空的狹縫中消失不見了')
      }
    })
  },
  editBookName(id, newBookName) {
    req('PATCH', `${this.BASE}/books/${id}`, { name: newBookName }, (err, res, book) => {
      if (err) {
        console.error(err)
        return
      }
      if (res.statusCode >= 200 && res.statusCode < 300) {
        console.log(`已更新的書名：${book.name}`)
      } else {
        console.log('該書本不存在')
      }
    })
  }
}
module.exports = bookStoreAPI
// bookStoreAPI.getBook(1)
// bookStoreAPI.delBook(31)
// bookStoreAPI.addBook("說不完的故事")
// bookStoreAPI.editBookName(30, "福爾摩斯全集")
// bookStoreAPI.printBooks(20)
