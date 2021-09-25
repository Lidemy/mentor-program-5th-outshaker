// 使用 fetch (promise) 重構

// ajax games/top
function queryTopGame() {
  console.log('queryTopGame')
  return fetch('https://api.twitch.tv/kraken/games/top?limit=5', {
    headers: {
      Accept: 'application/vnd.twitchtv.v5+json',
      'Client-ID': 'it0f8c9ly6exspcpzp4chgtniiyoay'
    },
    method: 'GET'
  }).then((response) => {
    console.log('get TopGame data')
    if (response.status >= 200 && response.status < 400) {
      return response.json()
    } else {
      throw new Error(`${response.status}: ${response.statusText}`)
    }
  }).catch((err) => {
    console.error(err)
  }).finally(() => {
    console.log('queryTopGame end')
  })
}

// load json and append li.game to ul.games
function loadTopGames(topGames) {
  console.log('loadTopGames')
  const gamesElem = document.querySelector('.games')
  for (const i in topGames.top) {
    const liElem = document.createElement('li')
    liElem.classList.add('game')
    liElem.innerText = topGames.top[i].game.name // gameName
    gamesElem.appendChild(liElem)

    // 設定已選取的遊戲元素
    if (i === '0') {
      activedGameElem = liElem
      liElem.classList.add('active')
    }
  }
  gamesElem.style.visibility = 'visible' // show list after loading
  thisGameName = topGames.top[0].game.name // 設定起始的遊戲名稱
  console.log('loadTopGames end')
}

function renderTopGames() {
  console.log('renderTopGames')
  setLoadingStatus(true)
  return queryTopGame()
    .then((topGameData) => {
      loadTopGames(topGameData)
    }).finally(() => {
      setLoadingStatus(false)
      console.log('renderTopGames end')
    })
}

// ajax streams/game
function queryTopStreams(gameName, offset = 0) {
  console.log('queryTopStreams')
  return fetch(`https://api.twitch.tv/kraken/streams/?game=${encodeURI(gameName)}&language=zh&limit=20&offset=${offset}`, {
    headers: {
      Accept: 'application/vnd.twitchtv.v5+json',
      'Client-ID': 'it0f8c9ly6exspcpzp4chgtniiyoay'
    },
    method: 'GET'
  }).then((response) => {
    console.log('get TopStreams data')
    if (response.status >= 200 && response.status < 400) {
      return response.json()
    } else {
      throw new Error(`${response.status}: ${response.statusText}`)
    }
  }).finally(() => {
    setLoadingStatus(false)
    console.log('queryTopStreams end')
  })
}

function loadTopStreams(topStreams) {
  console.log('loadTopStreams', topStreams)
  const { streams } = topStreams
  const streamsElem = document.querySelector('.streams')
  console.groupCollapsed('實況列表')
  for (const i in streams) {
    console.groupCollapsed(streams[i].channel.name)
    console.log(streams[i].preview.medium)
    console.log(streams[i].channel.status)
    console.log(streams[i].channel.logo)
    console.log(streams[i].channel.display_name)
    console.log(streams[i].channel.name)
    console.groupEnd()
    streamsElem.appendChild(newStreamElem(streams[i]))
  }
  console.groupEnd()
  checkNoMoreStream(streams.length)
  console.log('loadTopStreams end')
}

function renderTopStreams(gameName, offset = 0) {
  console.log('renderTopStreams')
  setLoadingStatus(true)
  return queryTopStreams(gameName, offset)
    .then((topStreams) => {
      loadTopStreams(topStreams)
    }).finally(() => {
      setLoadingStatus(false)
      console.log('renderTopStreams end')
    })
}

// #utility load json, make A div.stream and return it
function newStreamElem(stream) {
  const streamElem = document.createElement('div')
  streamElem.classList.add('stream')
  streamElem.innerHTML =
      `<div class="stream-cover"><a href="${stream.channel.url}" target="_blank" aria-label="${stream.channel.name}"><img src="${stream.preview.medium}" alt=""></a></div>
      <div class="stream-bottom">
        <div class="stream-avater"><a href="${stream.channel.url}" target="_blank" aria-label="${stream.channel.name}"><img src="${stream.channel.logo}" alt=""></a></div>
        <div class="stream-info">
          <div class="stream-title" title="${stream.channel.status}"><a href="${stream.channel.url}" target="_blank" aria-label="${stream.channel.name}">${stream.channel.status}</a></div>
          <div class="stream-host_name"><a href="${stream.channel.url}" target="_blank" aria-label="${stream.channel.name}">${stream.channel.display_name}</a></div>
        </div>
      </div>`
  return streamElem
}

// #utility clear all div.streams elements
function clearAllStreamElems() {
  const streamList = [...document.querySelectorAll('.stream')]
  streamList.forEach((e) => e.remove())
}

// #utility 檢查是否還有剩餘資料？有的話就顯示「載入更多」按鈕
function checkNoMoreStream(streamCount) {
  const btn = document.querySelector('#btn-moreStreams')
  if (streamCount <= 19) {
    btn.style.display = 'none'
  } else {
    btn.style.display = 'block'
  }
}

// #utility  設定頁面 loading 狀態
function setLoadingStatus(isOnload) {
  if (isOnload) {
    document.querySelector('body').setAttribute('loading', '')
  } else {
    document.querySelector('body').removeAttribute('loading')
  }
}

// 初始頁面查詢熱門實況內容，對 queryTopStreams() 的封裝，非事件觸發
function initTopStreams() {
  console.log('initTopStreams')
  console.log('thisGameName: ', thisGameName)
  return renderTopStreams(thisGameName)
}

// 其他遊戲選單查詢熱門實況內容，對 queryTopStreams() 的封裝，由 li.game click 事件觸發
function queryOtherGame(e) {
  console.log('queryOtherGame')
  console.log(e.target)
  console.log(e.target.innerText)
  if (e.target.matches('.game') && thisGameName !== e.target.innerText) { // 必須是不同的遊戲
    clearAllStreamElems() // 清空實況列表
    thisGameName = e.target.innerText // thisGameName 是全域變數，設定目前選取的遊戲名稱
    activedGameElem.classList.remove('active') // 取消遊戲選取的狀態
    e.target.classList.add('active') // 加入選取狀態
    activedGameElem = e.target // 切換目前選取的遊戲元素
    return renderTopStreams(thisGameName)
  }
}

// 「載入更多」 查詢熱門實況內容，對 queryTopStreams() 的封裝，由 div#btn-moreStreams onclick 觸發
function moreStreams(e) {
  console.log('moreStreams')
  const offset = document.querySelector('.streams').childElementCount // 計算目前載入的實況卡片數量
  console.log('thisGameName', thisGameName)
  console.log('offset', offset)
  return renderTopStreams(thisGameName, offset)
}

// 頁面初始化
function init() {
  console.log('init')
  document.querySelector('.games').addEventListener('click', queryOtherGame)
  document.querySelector('#btn-moreStreams').addEventListener('click', moreStreams)
  renderTopGames()
    .then(() => initTopStreams())
    .finally(() => {
      console.log('init end')
    })
}

let activedGameElem // 紀錄目前選取的遊戲元素
let thisGameName // 紀錄目前選取的遊戲名稱
document.addEventListener('DOMContentLoaded', init)
