/*
  hw3：周遊列國
  輸入國家的英文名字，就能夠查詢符合的國家的資訊，會輸出以下幾項：
  1. 國家名稱
  2. 首都
  3. 使用的貨幣名稱
  4. 電話國碼

  node hw3.js tai
  ============
  國家：Taiwan
  首都：Taipei
  貨幣：TWD
  國碼：886
  ============
  國家：United Kingdom of Great Britain and Northern Ireland
  首都：London
  貨幣：GBP
  國碼：44
  ============
  國家：Lao People's Democratic Republic
  首都：Vientiane
  貨幣：LAK
  國碼：856
  另外，如果沒有找到任何符合的國家，請輸出：「找不到國家資訊」。

  ref: https://restcountries.eu/#api-endpoints-name
*/
const request = require('request')
const process = require('process')

const [,, queryWord] = process.argv

function searchCountry(queryWord) {
  request.get({ url: `https://restcountries.eu/rest/v2/name/${queryWord}` }, (err, res, body) => {
    // 發生錯誤提早結束
    if (err) {
      console.error(err)
      return
    }

    // 正常情況
    if (res.statusCode >= 200 && res.statusCode < 300) {
      try {
        const countrys = JSON.parse(body)
        // console.log(countrys)
        if (Array.isArray(countrys)) {
          countrys.forEach((c) => {
            console.log('============')
            console.log(`國家：${c.name}`)
            console.log(`首都：${c.capital}`)
            console.log(`貨幣：${c.callingCodes[0]}`)
            console.log(`國碼：${c.currencies[0].code}`)
          })
        }
      } catch (e) {
        console.error(e)
      }

    // 404 Not Found
    } else if (res.statusCode === 404) {
      console.log('找不到國家資訊')

    // 其他類型錯誤
    } else {
      console.error(JSON.parse(body))
    }
  })
}

if (queryWord) {
  searchCountry(queryWord)
} else {
  console.warn('請輸入國家搜尋詞')
}
