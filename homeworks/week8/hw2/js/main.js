// ajax games/top
function queryTopGame() {
  console.log('queryTopGame')
  const req = new XMLHttpRequest()
  req.onload = function(e) {
    if (req.status >= 200 && req.status < 400) {
      try {
        const topGames = JSON.parse(req.responseText)
        // 載入遊戲列表。這邊說明沒使用 callback 的考量
        // 目前 callback function 固定一個，所以沒有參數化的需求
        // 採用 callback 以外的命名方式讓程式比較好讀
        // callback function 鏈超過兩層就無法從參數列引入，除非使用類似 function call stack 的結構，但那會讓程式更加複雜。
        loadTopGames(topGames)
      } catch (err) {
        console.error(err)
      }
    } else {
      console.error('status: ', req.status) // 顯示 500 錯誤
    }
  }
  req.addEventListener('loadend', (e) => {
    console.log('queryTopGame loadend')
    toggleLoadingStatus()
  })
  req.open('GET', 'https://api.twitch.tv/kraken/games/top?limit=5')
  req.setRequestHeader('Accept', 'application/vnd.twitchtv.v5+json')
  req.setRequestHeader('Client-ID', 'it0f8c9ly6exspcpzp4chgtniiyoay')
  req.send()
  toggleLoadingStatus()
}

// load json and append li.game to ul.games
function loadTopGames(topGames) {
  console.log('loadTopGames')
  const gamesElem = document.querySelector('.games')
  for (const i in topGames.top) {
    const liElem = document.createElement('li')
    liElem.classList.add('game')
    // liElem.dataset.index = i // 沒使用到，備存
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
  initTopStreams() // 初始化的查詢遊戲熱門實況
}

// ajax streams/game
function queryTopStreams(gameName, offset = 0) {
  console.log('queryTopStreams')
  const req = new XMLHttpRequest()
  req.onload = function(e) {
    if (req.status >= 200 && req.status < 400) {
      try {
        const topStreams = JSON.parse(req.responseText).streams
        loadTopStreams(topStreams)
        checkNoMoreStream(topStreams.length)
      } catch (err) {
        console.error(err) // 顯示 json parse error
      }
    } else {
      console.error('status: ', req.status) // 顯示 500 錯誤
    }
  }
  req.addEventListener('loadend', (e) => {
    console.log('queryTopStreams loadend')
    toggleLoadingStatus()
  })
  req.open('GET', `https://api.twitch.tv/kraken/streams/?game=${encodeURI(gameName)}&language=zh&limit=20&offset=${offset}`)
  req.setRequestHeader('Accept', 'application/vnd.twitchtv.v5+json')
  req.setRequestHeader('Client-ID', 'it0f8c9ly6exspcpzp4chgtniiyoay')
  req.send()
  toggleLoadingStatus()
}

// load json to streamElem, append streamElem to div.streams
function loadTopStreams(topStreams) {
  console.log('loadTopStreams')
  const streamsElem = document.querySelector('.streams')
  console.groupCollapsed('實況列表')
  for (const i in topStreams) {
    console.groupCollapsed(topStreams[i].channel.name)
    console.log(topStreams[i].preview.medium)
    console.log(topStreams[i].channel.status)
    console.log(topStreams[i].channel.logo)
    console.log(topStreams[i].channel.display_name)
    console.log(topStreams[i].channel.name)
    console.groupEnd()
    streamsElem.appendChild(newStreamElem(topStreams[i]))
  }
  console.groupEnd()
}

// #utility load json, make A div.stream and return it
function newStreamElem(stream) {
  const streamElem = document.createElement('div')
  streamElem.classList.add('stream')
  streamElem.innerHTML =
      `<div class='stream-cover'><a href="${stream.channel.url}" target="_blank"><img src='${stream.preview.medium}'></a></div>
      <div class='stream-bottom'>
        <div class='stream-avater'><a href="${stream.channel.url}" target="_blank"><img src='${stream.channel.logo}'></a></div>
        <div class='stream-info'>
          <div class='stream-title' title='${stream.channel.status}'><a href="${stream.channel.url}" target="_blank">${stream.channel.status}</a></div>
          <div class='stream-host_name'><a href="${stream.channel.url}" target="_blank">${stream.channel.display_name}</a></div>
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
  const btn = document.querySelector('#btn-moreGame')
  if (streamCount <= 19) {
    btn.style.display = 'none'
  } else {
    btn.style.display = 'block'
  }
  if (streamCount === 0) {
    alert('下面沒有東西囉')
  }
}

// #utility  切換頁面 loading 狀態
function toggleLoadingStatus() {
  document.querySelector('body').toggleAttribute('loading')
}

// 初始頁面查詢熱門實況內容，對 queryTopStreams() 的封裝，非事件觸發
function initTopStreams() {
  console.log('initTopStreams')
  console.log('thisGameName: ', thisGameName)
  queryTopStreams(thisGameName)
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
    queryTopStreams(thisGameName)
  }
}

// 「載入更多」 查詢熱門實況內容，對 queryTopStreams() 的封裝，由 div#btn-moreGame onclick 觸發
function moreGame(e) {
  console.log('moreGame')
  const offset = document.querySelector('.streams').childElementCount // 計算目前載入的實況卡片數量
  console.log('thisGameName', thisGameName)
  console.log('offset', offset)
  queryTopStreams(thisGameName, offset)
}

// 頁面初始化
function init() {
  document.querySelector('.games').addEventListener('click', queryOtherGame)
  document.querySelector('#btn-moreGame').addEventListener('click', moreGame)
  queryTopGame()
}

let activedGameElem // 紀錄目前選取的遊戲元素
let thisGameName // 紀錄目前選取的遊戲名稱
document.addEventListener('DOMContentLoaded', init)
