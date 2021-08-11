// 題目說明請參考：
// https://github.com/Lidemy/mentor-program-4th/issues/16

class Robot {
  constructor(x, y) {
    this.x = x
    this.y = y
  }

  getCurrentPosition() {
    /* eslint-disable-next-line object-property-newline */
    return { x: this.x, y: this.y }
  }

  go(dir) {
    switch (dir) {
      case 'W':
        this.x--
        break
      case 'E':
        this.x++
        break
      case 'N':
        this.y++
        break
      case 'S':
        this.y--
        break
      default:
    }
  }
}

function debounce(fn, delay) {
  let isLoading = false
  let timerId
  const f = function(...args) {
    console.log('fn start')
    console.log(...args)
    fn(...args)
    isLoading = false
    console.log('fn end')
  }
  return (...args) => {
    console.log(args)
    if (isLoading) {
      console.log('reflash')
      clearTimeout(timerId)
    } else {
      console.log('start loading')
      isLoading = true
    }
    timerId = setTimeout(f, delay, ...args) // 刷新計時器
  }
}

function memoize(fn) {
  const cache = {}
  return (x) => {
    if (cache[x] === undefined) {
      console.log('x not in cache')
      cache[x] = fn(x)
    } else {
      console.log('x in cache')
    }
    return cache[x]
  }
}

// const fn = () => {}
// const debouncedFn = debounce(fn, 250)
// debouncedFn(10)

/* eslint-disable-next-line object-property-newline */
module.exports = { Robot, debounce, memoize }
