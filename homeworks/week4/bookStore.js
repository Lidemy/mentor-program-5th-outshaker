// https://lidemy-book-store.herokuapp.com API 封裝
const request = require('request')

const BASE = 'https://lidemy-book-store.herokuapp.com'
const bookStoreAPI = {
  printBooks(limit = 20) {
    request.get({ url: `${BASE}/books?_limit=${limit}` }, (err, res, body) => {
      try {
        const books = JSON.parse(body)
        // console.log(books)
        books.forEach((book) => { console.log(book.id, book.name) })
      } catch (e) {
        console.error(e)
      }
    })
  },
  getBook(id) {
    request.get({ url: `${BASE}/books/${id}` }, (err, res, body) => {
      try {
        const book = JSON.parse(body)
        console.log(book.name)
      } catch (e) {
        console.error(e)
      }
    })
  },
  delBook(id) {
    request.delete({ url: `${BASE}/books/${id}` }, (err, res, body) => {
      console.log(`delete book ${id}`)
    })
  },
  addBook(name) {
    request.post({
      url: `${BASE}/books/`,
      form: { name }
    }, (err, res, body) => {
      try {
        const result = JSON.parse(body)
        console.log(result)
      } catch (e) {
        console.error(e)
      }
    })
  },
  editBookName(id, newBookName) {
    request.patch({
      url: `${BASE}/books/${id}`,
      form: { name: newBookName }
    }, (err, res, body) => {
      try {
        const result = JSON.parse(body)
        console.log(result)
      } catch (e) {
        console.error(e)
      }
    })
  }
}
module.exports = bookStoreAPI
