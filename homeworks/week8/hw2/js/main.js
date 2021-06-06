// ul.games ajax
// ajax games/top limit offset
function loadTop5Game() {
  console.log('loadTop5Game')
  const req = new XMLHttpRequest()
  req.onload = function(e) {
    if (req.status >= 200 && req.status < 400) {
      // console.log(req.responseType)
      try {
        // console.log(req.getAllResponseHeaders())
        const g = JSON.parse(req.responseText)
        for (const i in g.top) {
          games.push(g.top[i].game.name)
        }
        console.log(games) // json 版
        const elems = document.querySelectorAll('.game')
        for (const i in games) {
          elems[i].innerText = games[i]
        }
        document.querySelector('.games').style.visibility = 'visible'
        ;[thisGame] = games
        queryTop20stream()
      } catch (err) {
        console.error(err) // 顯示 json parse error
      }
    } else {
      console.error('status: ', req.status) // 顯示 500 錯誤
    }
  }
  req.open('GET', 'https://api.twitch.tv/kraken/games/top?limit=5')
  req.setRequestHeader('Accept', 'application/vnd.twitchtv.v5+json')
  req.setRequestHeader('Client-ID', 'it0f8c9ly6exspcpzp4chgtniiyoay')
  req.send()
}
// load json to games
// load games to ul.games

// ajax streams/game limit offset
// <== clearStreams(), addStream(stream)
function queryTop20stream() {
  console.log('top20stream', thisGame)
  const req = new XMLHttpRequest()
  req.onload = function(e) {
    if (req.status >= 200 && req.status < 400) {
      console.log(req.responseType)
      try {
        clearStreams()
        // console.log(req.getAllResponseHeaders())
        streams = JSON.parse(req.responseText).streams
        for (const i in streams) {
          console.groupCollapsed() // console.group()
          console.log(streams[i].preview.medium)
          console.log(streams[i].channel.status)
          console.log(streams[i].channel.logo)
          console.log(streams[i].channel.display_name)
          console.log(streams[i].channel.name)
          console.groupEnd()
          addStream(streams[i])
          base += streams.length
        }
      } catch (err) {
        console.error(err) // 顯示 json parse error
      }
    } else {
      console.error('status: ', req.status) // 顯示 500 錯誤
    }
  }
  if (base) {
    req.open('GET', `https://api.twitch.tv/kraken/streams/?game=${encodeURI(thisGame)}&language=zh&limit=20&offset=${base}`)
  } else {
    req.open('GET', `https://api.twitch.tv/kraken/streams/?game=${encodeURI(thisGame)}&language=zh&limit=20`)
  }
  req.setRequestHeader('Accept', 'application/vnd.twitchtv.v5+json')
  req.setRequestHeader('Client-ID', 'it0f8c9ly6exspcpzp4chgtniiyoay')
  req.send()
}
// load json to streams
// append streams to div.streams

// append A stream to div.streams
function addStream(stream) {
  const streamsElem = document.querySelector('.streams')
  const streamElem = document.createElement('div')
  streamElem.classList.add('stream')
  streamElem.innerHTML = `        <div class='stream-cover'><img src='${stream.preview.medium}' alt=''></div>
        <div class='stream-bottom'>
          <div class='stream-avater'><img src='${stream.channel.logo}' alt=''></div>
          <div class='stream-info'>
            <div class='stream-title' title='${stream.channel.status}'>${stream.channel.status}</div>
            <div class='stream-host_name'>${stream.channel.display_name}</div>
          </div>
        </div>`
  streamsElem.appendChild(streamElem)
}

// clear elements in div.streams
function clearStreams() {
  const streamList = [...document.querySelectorAll('.stream')]
  streamList.forEach((e) => e.remove())
}

// li.game onclick => data-index => gameName => queryTop20stream(gameName, limit, offset)
// 本身動作ˋ跟 queryTop20stream() 一樣，差別只是需要帶入 index 參數，可以整理包裝成 loadStreams()
function queryGame(e) {
  console.log('queryGame')
  if (e.target.matches('.game')) {
    const gameName = games[e.target.dataset.index]
    console.log('index', e.target.dataset.index)
    console.log(gameName)
    thisGame = gameName
    base = 0
    queryTop20stream()
  }
}

// div.btn-moreGame onclick => thisGame, base => queryTop20stream(gameName, limit, offset)
// 本身動作ˋ跟 queryTop20stream() 一樣，差別是不需要 clearStreams()
function moreGame(e) {
  console.log('moreGame')
  queryTop20stream()
}

function init() {
  loadTop5Game()
  document.querySelector('.games').addEventListener('click', queryGame)
  document.querySelector('#btn-moreGame').addEventListener('click', moreGame)
}

let games = []
let thisGame

let streams
let base = 0

document.addEventListener('DOMContentLoaded', init)
