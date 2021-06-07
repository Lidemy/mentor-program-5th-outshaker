function draw() {
  key = ''
  const req = new XMLHttpRequest()
  req.onload = function(e) {
    if (req.status >= 200 && req.status < 400) {
      console.log(req.responseType, req.responseText)
      try {
        const s = JSON.parse(req.responseText)
        if (s.prize) {
          key = s.prize
          console.log(`get prize: ${key}`)
        } else {
          console.error('error: ', s.error) // 顯示包含錯誤的 json
        }
      } catch (err) {
        console.error(err) // 顯示 json parse error
      }
    } else {
      console.error('status code: ', req.status) // 顯示 500 錯誤
      alert('系統不穩定，請再試一次')
      return
    }
    if (key) {
      go(key)
    } else {
      alert('系統不穩定，請再試一次')
    }
  }
  req.open('GET', 'https://dvwhnbka7d.execute-api.us-east-1.amazonaws.com/default/lottery')
  req.send()
}

function go(key) {
  console.log(`go to ${key}`)
  if (!['FIRST', 'SECOND', 'THIRD', 'NONE'].includes(key)) {
    console.error(key, 'no exist')
    return
  }
  document.querySelector('.lottery').classList.remove('init')
  document.querySelector('.lottery').setAttribute('key', key)
  document.querySelector('.cheers-text').innerText = prizeStrings[key]

  /* if (key === 'NONE') {
    document.querySelector('.cheers-text').classList.add('prize-none')
    document.querySelector('.lottery').classList.add('prize-none')
  } else {
    document.querySelector('.lottery').style.backgroundImage = `url(${prizeImage[key]})`
  } */
}

function back() {
  console.log('back')
  document.querySelector('.cheers-text').innerText = ''
  document.querySelector('.lottery').classList.add('init')
  document.querySelector('.lottery').removeAttribute('key')
}

function init() {
  document.querySelector('.lottery-dialog-btn-draw').addEventListener('click', draw)
  document.querySelector('.btn-back').addEventListener('click', back)
}

let key

const prizeStrings = {
  FIRST: '恭喜你中頭獎了！日本東京來回雙人遊！',
  SECOND: '二獎！90 吋電視一台！',
  THIRD: '恭喜你抽中三獎：知名 YouTuber 簽名握手會入場券一張，bang！',
  NONE: '銘謝惠顧'
}

document.addEventListener('DOMContentLoaded', init)
