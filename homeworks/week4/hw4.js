/*
  hw4：探索新世界
  寫一個小程式，能夠去撈取 Twitch 上面受歡迎的遊戲，他就能夠參考這個列表來決定要實況哪個遊戲。
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
    if (!err && res.statusCode !== 503) {
      try {
        const topGameList = JSON.parse(body).top
        topGameList.forEach((g) => {
          console.log(g.viewers, g.game.name)
        })
      } catch (e) {
        console.error(e)
      }
    } else {
      console.error(res.statusCode)
      console.error(err)
    }
  })
}

showTopGameList(clientId)
