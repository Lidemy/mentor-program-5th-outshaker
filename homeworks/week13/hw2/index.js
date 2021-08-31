import 'jquery'
import 'bootstrap/dist/css/bootstrap.min.css'
import './site.css'

const API_BASE_URL = 'http://mentor-program.co/mtr04group5/sixwings/w13/hw2/api'

const boardTemplate = `
<div class="card">
  <div class="card-body">
    <h5 class="card-title">新增留言</h5>
    <form>
      <div class="input-group mb-3">
        <span class="input-group-text" id="inputGroup-sizing-default">暱稱</span>
        <input name="nickname" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" maxlength="20">
      </div>
      <div class="input-group mb-3">
        <textarea name="content" class="form-control" aria-label="留言" placeholder="想說點什麼呢？" rows=5></textarea>
      </div>
      <div class="input-group mb-3 add-comment-btn">
        <button type="submit" class="btn btn-primary">送出</button>
      </div>
    </form>
  </div>
</div>
<div class="comments"></div>
<div class="bottom mb-3">
  <button class="btn btn-primary load-more-btn">載入更多</button>
</div>`

function escape(string) {
  const map = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#x27;',
    '/': '&#x2F;'
  }
  const reg = /[&<>"'/]/ig
  return string.replace(reg, (match) => (map[match]))
}

function init(options) {
  const { boardName, boardID } = options
  const boardSelector = `#${boardID}`

  let oldestId = null

  function loadComments(before = null) {
    $.ajax(`${API_BASE_URL}/get_comments.php`, {
      method: 'GET',
      dataTypeL: 'text',
      data: {
        board_name: boardName,
        before
      }
    })
      .done(({ comments }) => {
        appendComments(comments)
        if (comments.length) {
          oldestId = comments[comments.length - 1].id // update state
        }
        if (comments.length < 5) { // fetch to end
          $(`${boardSelector} .load-more-btn`).hide()
        }
      })
      .fail((err) => {
        console.error(err)
      })
  }

  function addComment() {
    $.ajax({
      type: 'POST',
      url: `${API_BASE_URL}/add_comment.php`,
      data: {
        board_name: boardName,
        nickname: $(`${boardSelector} input[name=nickname]`).val(),
        content: $(`${boardSelector} textarea[name=content]`).val()
      }
    }).done((result) => {
      if (!result.ok) {
        console.error(result.message)
      }
      appendComment(result.comment, true)
      $(`${boardSelector} input[name=nickname]`).val('')
      $(`${boardSelector} textarea[name=content]`).val('')
    })
  }

  function appendComment(comment, reversed = false) {
    const commentTemplate = `<div class="card">
      <div class="card-body">
        <h5 class="card-title">${escape(comment.nickname)}</h5>
        <h6 class="card-subtitle mb-2 text-muted">#${comment.id} ${escape(comment.created_at)}</h6>
        <p class="card-text">${escape(comment.content)}</p>
      </div>
    </div>`
    if (reversed) {
      $(`${boardSelector} .comments`).prepend(commentTemplate)
      return
    }
    $(`${boardSelector} .comments`).append(commentTemplate)
  }

  function appendComments(comments, reversed = false) {
    if (!Array.isArray(comments)) {
      console.error('comments is not array')
      return
    }
    for (const i in comments) {
      appendComment(comments[i], reversed)
    }
  }

  const sendComment = (e) => {
    e.preventDefault()
    addComment()
  }
  const loadMore = () => { loadComments(oldestId) }

  $(boardSelector).append(boardTemplate)
  loadComments()
  $(`${boardSelector} .add-comment-btn>button`).on('click', sendComment)
  $(`${boardSelector} .load-more-btn`).on('click', loadMore)
}

$(document).ready(() => {
  const loaded = {}
  for (const options of window.boards) {
    console.log(options)
    if (!loaded[options.boardID]) {
      init(options)
      loaded[options.boardID] = true
    } else {
      console.error(`${options.boardID} has been used, can't render board ${options.boardName}`)
    }
  }
})
