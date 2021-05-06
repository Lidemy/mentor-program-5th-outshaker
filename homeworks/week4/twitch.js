/*
  挑戰題
  寫一個 node.js 的程式並串接 Twitch API，接收一個參數是遊戲名稱，輸出那個遊戲底下最受歡迎的前 200 個實況的名稱與 id。
  callback 版本
*/
const request = require('request')

const MAX_LEN = 100
const clientId = 'it0f8c9ly6exspcpzp4chgtniiyoay'
const clientSecret = '' // Please ask the developer
let appToken = 'qfol8e8bqamh7fw3dep7vt0o96lmhb'

const gameWord = process.argv[2]

function main() {
  // 搜尋遊戲
  if (!gameWord) {
    console.error('require gameWord')
    return
  }
  step1(clientId, appToken)
}

// 取得憑證 getAppToken
function step0(clientId, clientSecret) {
  console.log('step0: getAppToken')
  request.post({
    url: 'https://id.twitch.tv/oauth2/token',
    headers: {
      Accept: 'application/vnd.twitchtv.v5+json',
      'Client-ID': clientId
    },
    qs: {
      client_id: clientId,
      client_secret: clientSecret,
      grant_type: 'client_credentials'
    }
  }, (err, res, body) => {
    console.log('step0-callback')
    if (err) {
      console.error(err)
      return
    }
    if (res.statusCode >= 200 && res.statusCode < 300) {
      appToken = JSON.parse(body).access_token
      step1(clientId, appToken, true) // #goto step1
    } else { // 失敗，在此結束
      console.log(res.statusCode)
      console.error('無法申請憑證，請確認 clientSecret 資訊是否正確')
      const data = JSON.parse(body)
      console.log(data)
    }
  })
}

// 驗證憑證 validateToken
function step1(clientId, appToken, retry = false) {
  console.log('step1: validateToken')
  request.get({
    url: 'https://id.twitch.tv/oauth2/validate',
    headers: {
      Accept: 'application/vnd.twitchtv.v5+json',
      'Client-ID': clientId,
      Authorization: `Bearer ${appToken}`
    }
  }, (err, res, body) => {
    console.log('step1-callback')
    if (err) {
      console.error(err)
      return
    }
    if (res.statusCode >= 200 && res.statusCode < 300) {
      step2(clientId, appToken, gameWord) // gameWord 用全域變數抓 #goto step2
    } else if (res.statusCode === 401 && !retry) { // 驗證失敗且沒有重新申請過，更新憑證
      step0(clientId, clientSecret) // #goto step0
    } else { // 異常狀況
      console.log(res.statusCode)
      const data = JSON.parse(body)
      console.log(data)
    }
  })
}

// 取得遊戲編號 getGameId
function step2(clientId, appToken, gameWord) {
  console.log('step2: getGameId')
  request.get({
    url: 'https://api.twitch.tv/helix/search/categories',
    headers: {
      Accept: 'application/vnd.twitchtv.v5+json',
      // 'Client-ID': clientId, //這應該是舊版 v5 的作法
      'client-id': clientId,
      Authorization: `Bearer ${appToken}`
    },
    qs: {
      query: gameWord
    }
  }, (err, res, body) => {
    console.log('step2-callback')
    if (res.statusCode >= 200 && res.statusCode < 300) {
      const json = JSON.parse(body)
      // console.log(json)
      let isFound = false
      if (json.data && Array.isArray(json.data)) {
        for (const d of json.data) {
          console.log(`${d.id}\t\t${d.name}`)
          if (gameWord === d.name) {
            isFound = true
            console.log(`find ${gameWord} => ${d.id}`)
            step3(clientId, appToken, d.id, 200) // #goto step3
            break
          }
        }
        if (!isFound) { console.log('no this game') }
      }
      console.log('json data is wrong')
    } else {
      console.log(res.statusCode, JSON.parse(body))
    }
  })
}

// 抓取實況清單 fetchStreams
function step3(clientId, appToken, gameId, topN) {
  console.log('step3: fetchStreams')
  let result = []
  function _fetchStreams(clientId, appToken, gameId, topN, now, cursor) {
    console.log('_fetchStreams', topN, now)
    const url = 'https://api.twitch.tv/helix/streams'
    const qs = {}
    qs.game_id = gameId
    qs.first = ((topN - now) <= MAX_LEN) ? topN - now : MAX_LEN // 設定抓取數量
    if (now !== 0 && cursor) { qs.after = cursor } // 設定位置

    request.get({
      url,
      qs,
      headers: {
        Accept: 'application/vnd.twitchtv.v5+json',
        'client-id': clientId,
        Authorization: `Bearer ${appToken}`
      }
    }, (err, res, body) => {
      console.log('_fetchStreams-callback')
      if (res.statusCode >= 200 && res.statusCode < 300) {
        const json = JSON.parse(body)
        // console.log(json)

        // 接收資料，更新狀態
        if (json.data && Array.isArray(json.data)) {
          result = result.concat(json.data)
          now = result.length
          cursor = json.pagination.cursor
          console.log(`add ${json.data.length} (${now}/${topN})`)
          // console.log(cursor)
        }

        // 判斷是否結束？ 結束，往下一層；否則繼續抓
        if (now >= topN || json.data.length === 0 || !cursor) showResult(result)
        else _fetchStreams(clientId, appToken, gameId, topN, now, cursor)
      } else {
        console.log('in _handleFetchStreams error')
        console.log(res.statusCode)
        console.log(JSON.parse(body))
      }
    })
  }
  _fetchStreams(clientId, appToken, gameId, topN, 0, '')
}

// 印出最後結果 showResult
function showResult(result) {
  if (Array.isArray(result)) {
    result.forEach((e) => {
      console.log(`${e.id} ${e.title}`)
    })
  }
}

// getAppToken(clientId, clientSecret)
// validateToken(clientId, appToken)
// gameId = getGameId(clientId, appToken, 'Apex Legends')
// console.log(gameId)
// fetchStreams(clientId, appToken, 511224, 30)
main()
