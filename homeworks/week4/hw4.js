/*
  hw4：探索新世界
  寫一個小程式，能夠去撈取 Twitch 上面受歡迎的遊戲，他就能夠參考這個列表來決定要實況哪個遊戲。

  ref: https://dev.twitch.tv/docs/v5/reference/games
*/
const request = require('request')

const clientId = 'it0f8c9ly6exspcpzp4chgtniiyoay'

function showTopGameList(appID) {
  request.get({
    url: 'https://api.twitch.tv/kraken/games/top',
    headers: {
      Accept: 'application/vnd.twitchtv.v5+json',
      'Client-ID': appID
    }
  }, (err, res, body) => {
    // 發生錯誤提早結束
    if (err) {
      console.error(err)
      return
    }
    // 正常情況
    if (res.statusCode >= 200 && res.statusCode < 300) {
      try {
        const topGameList = JSON.parse(body).top
        topGameList.forEach((g) => {
          console.log(g.viewers, g.game.name)
        })
      } catch (e) {
        console.error(e)
      }
    // 4xx 或 5xx 情況
    } else {
      try {
        const msg = JSON.parse(body)
        console.error(msg)
      } catch (e) {
        console.error(e)
      }
    }
  })
}

showTopGameList(clientId)
