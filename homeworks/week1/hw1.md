## 交作業流程

1. 連線到 [GitHub classroom] (https://classroom.github.com/a/yNNrtNyW)

2. 用自己的 GitHub 帳號，建立屬於自己的 Repo，成功後會看見網頁出現自己的 Repo 網址 (遠端 Repo)

3. 開啟 git-bash 進入黑色視窗輸入指令

4. 切換到預定放置課程資料夾的檔案路徑 `cd e/Lidemy/`

5. `git clone https://github.com/Lidemy/mentor-program-5th-outshaker.git`
   將已經建立好的 Repo 下載到自己的電腦上

6. `git branch <week1>`
   `git checkout <week1>`
   先建立分支，切換到該分枝，開始寫作業
   切記不要直接在 Master 分支上進行修改

7. `git add .`
   `git commit -m "<這邊打你的作業摘要說明>"`
   `git push origin <week1>`
   寫完一部分作業，新增更動過的檔案、發送更動、推送到遠端 Repo

8. 到網址那確認是否推送成功？
   
9. 等到全部作業都順利推送後，到網址上點選 **Compare & pull request**
   送出後會有一個 PR 的網址，將它貼到學習系統上的 [繳交作業/更新作業] 內
   如果這時候還要更新作業也不用重新發 PR ，因為分支的狀態會自己更新

10. 改完的作業助教會留下評語建議，然後這個分支會合併到 Master 主分支

## 助教改完作業後要做的動作

1. `git pull origin master`
   將遠端 Repo 的資料再拉回自己的 Master 分支

2. `git branch -b <week1>`
   刪除沒使用的分支
   
3. 繼續回到一開始的交作業流程，從步驟 6 開始

