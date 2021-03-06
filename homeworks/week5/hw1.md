# 前四週心得與解題心得

重溫一個月前的自己寫下的紀錄，只能說，自己也沒想到起起伏伏這麼大

## 第一週 4/12 ~ 4/18
帶著小小的興奮感開始刷課程影片寫作業。對於第三、四題的感覺蠻親切的，可能是因為自己有當家教的關係，所以寫教學的時候也蠻希望自己可以用活潑一點的方式讓新手接觸程式這個領域。第一題其實是在邊操作邊寫的情況下完成的，等於是寫一份給自己的文件。在前公司有稍微被磨過 (寫給銀行建置系統的文件)，所以知道文字敘述必須清楚不能造成誤解。第五題申論題其實不太知道要怎麼界定自己要講到多細？那份摸不到邊界的不確定感讓我不太好掌握。

接近週末的時候把第二週的作業完成，其實也蠻順的。挑戰題和超級挑戰題花的時間反而比較多，我印象還很深刻是在迴圈功能的時候卡關，有一個寫法是 bash 不支援的，但偏偏我查到的教學就是用那個。後來還不死心去 stackOverflow 查，還真的有人說明為什麼那個迴圈寫法沒辦法跑出想要的結果。中文教學資料基本上只有鳥哥可以看，但是那麼細微的東西他也沒講到。感想是 bash 是很龐大的軍火庫，傳承了 unix 留下來的很多東西。

## 第二週 4/19 ~ 4/25
基本上這一週算是仗著自己的程式底子在飆進度，但也僅止於基本作業的部分。大概在 D10 的時候意識到自己對解挑戰題沒有很大的動力，可能題目太偏門的關係，所以優先度默默地往後移，但看到其他同學突破挑戰題的時候也會替他們開心就是了。

導入 eslint 的時候其實說實話還好，單純就是有點煩，因為我沒辦法事前知道自己哪裡有錯修正，送出去被打槍的感覺就是不好，但也是跟這樣的感覺相處到了現在。雖然去查 eslint 套件的指令用法或許就可以預先檢查語法錯誤了，但也許這件事情還沒有到我覺得非得要處理的程度吧。

中間還發生不小心刷了之後課程的烏龍，我大概是第一個把 #FE102 看成 #JS102 的眼殘吧。另外 #JS201 看到一半才發現是 week16 的進度囧，想說頭都洗一半了只好直接刷完。

在 D12 的時候已經在安裝 request 了，老實說對廢棄套件這件事還蠻在意的，但課程是以這套件在教的，所以還是以學習 request 為主。

另外這週作業收到 JAS0NHUANG 助教對於程式的建議 (其實也是再次提醒老師在自我檢討內說的東西)，no-else-return 的規則基本上是 eslint 在管，為了成功提交我還是會改，只是我目前還沒辦法感受到 no-else-return 存在的必要性，也許過段時間會慢慢體會到吧。另外一個 ClayGao 助教的建議是盡量避免過深的巢狀判定，這部分我自己也在學習中，但老實說這部分的優化不會只有一種切入角度，就像我當時回應 week3 hw5 的題目一樣，如果你用字串相等的機率去看問題，early return 的 case 可能就不會是直覺想到的那一個。

中後段有點分心去查 fetch, promise, async 之類的東西，但進度還算前面所以影響不大

## 第三週 4/26 ~ 5/2
這一週開始拚第四週作業，大概在 D17 開始卡關，意識到自己對於簡答題有障礙，就是怎麼樣都覺得自己陳述的方式不夠完整，少了一點感覺。D18 - D20 陷入研究 REST 的坑，一方面是我不明白為什麼 API 跟 RESTful 這麼緊密的連結在一起？而且應該是某段時間之後才變成大家口中的主流 API 風格，至少我目前使用的一個 API 就不是 RESTful 風格的，這中間也許有故事。懷抱這樣的疑惑找了各式各樣的資料，最後很無望地，從眾說紛紜之中，只有尋找當年那篇關鍵論文才能明白了。我在這段歷程意識到，如果要真正了解一樣東西，規格書、論文、官方文件是沒辦法迴避的。當然也有一部分也是因為我在 JS 後面的課程看到胡立老師拿出原文 ECMAScript 規格書出來的時候有被震撼到，那麼難啃的規格書老師也有在看。也不算比較，只是覺得想效法這樣的精神吧。看完論文之後有突飛猛進或是內力大增嗎？沒有，我還是一樣要趕我 week4 的作業五題目一和三，我還是需要在作業進度上有所前進。

此時我差不多已經跟前段飆車的同學拉開距離了，但那也是我的選擇，我沒辦法放下我的疑惑繼續前進。

我在作業五花的時間異常地多，那時候心裡想，要讓這些花掉的時間是值得的，那就盡全力讓作業五做到極致吧。 API 文件是受到 zoeaeen13 助教啟發才知道原來有專門寫 API 文件的語法，而且那語法跟 markdown 是相容的。再來是查了蠻多餐廳相關的平台去學習他們的 API 架構，最後在 CRUD 的基本功能之上，自己再額外多設計提供給使用者查詢功能。

Book Store API 的部分，後來又重新再上面測試一些可能觸發錯誤的案例，藉此更了解 CRUD 正常和異常的回傳是什麼。這份收穫直接回饋到 API 文件回傳狀態碼的部分。

其實做這些的時候沒想太多，就只是做到內心覺得「這樣可以了」的那種感覺。而且也許是巧合吧，系統分配的助教剛好也是 zoeaeen13。趁助教回覆的時候感謝她當初留下的作業靈感 (原來 API 文件可以用 API blueprint 這個語法來寫)

## 第四週 5/3 ~ 5/9
這週前半段在拚挑戰題，疑？前面不是說挑戰題的優先度放後面嗎？可能因為對 API 特別有愛吧，所以做完 week4 作業之後順著那個氣勢繼續作挑戰題，不得不說其實寫的過程承受和負擔蠻多的。D22 - D25 這段時間在跟 Twitch API 奮鬥，我中途很作死地換成 New API 來解，原本想說跟之前一樣，單一 API 功能先包起來，然後串起來就好了。但殊不知， callback 之所以地獄的地方是它沒辦法拆分成不會耦合的函數，至少在需要**保證執行順序**的條件下，我目前找不到方法把那些單一 API 功能串起來。

舉例來說，getGameId(clientId, appToken, gameWord) 這個 API 負責把要查詢的遊戲名稱送出，同時它必須在 callback function 內接續著呼叫下一個 fetchStreams(clientId, appToken, gameId, 200)。也就是說，callback function 處理了 getGameId() 後半段接收封包和呼叫下一個函數的工作，這種 callback function 沒辦法拆分。我想過用變數接收 callback function 的回傳值，發現根本沒辦法。意識到這件事情之後，我只能接受我寫出來的程式碼跟義大利麵條一樣這個事實。波動拳程式碼原來就是這樣來的，那一刻我是真的完全明白是怎麼回事。捏著鼻子硬著頭皮先 commit，挑戰題已經弄三天該往下了，超級挑戰題還在等著我。

相比之下超級挑戰題用 http.request 完成 hw2.js 的 API 呼叫還好，查官方文件然後想辦法把它拚成 request() 的樣子。中間需要了解很多 nodejs 原生的底層資料結構，還好官方文件有中文翻譯，至少在消化文字上阻力小了一點。

然後在周末，又一個坑開始在醞釀，等著我掉進去。

## 第五週 5/10 ~ 5/14
//作業要求到第四週，這邊純粹是寫給自己看的回顧

D26 - D29 這段時間我又掉進另外一個坑，研究學習系統上 markdown 呈現跟軟體呈現不一致的原因。為此建置了 React 環境，只是為了想搞明白為什麼它沒有按照同樣規格的 markdown 引擎跑出一樣的結果？我不知道其他同學怎麼看？但當下驅使我探索的原動力帶我到了那理。「React 是 week21 - 24週的進度你衝這麼快幹什麼啦」也許吧，不按照進度有不按照進度的學習方式。換一個方式的說法「我沒想到你居然有毅力花四天時間只為了把 bug 找出來」我自己是把那個 React 研究當作支線任務在解，目前對自己的唯一要求是無論如何不能落後當週進度，至少要學會找到自己拉回來的方法。

week5 http 線上闖關大致上沒問題，因為在第四週進度跟 API 接觸非常頻繁。中間蠻有印象的是其中一個 token 一看就很像 youtube 影片或是某個縮網址的編號，丟去 google 果然找到半島鐵盒，不得不說老師連埋彩蛋都很用心。過了第十關之後難度就不同了，在第十二關有小卡一下，因為 postman 和 request 預設都會自動處理 302 所以一直沒發現。然後第十三關我是真的沒辦法，找菲律賓 proxy 也不確定正確的連線方式，試很久都失敗。加上這禮拜狀況不太好，果斷放手。先轉向處理那三題 LIOJ。

1018一次過，思路是轉換成統計數字出現次數，然後取最大值。
1016四次過，錯到第三次的時候冷靜下來想可能的邊界條件，是全部人都選同一組的時候。
1017一次過，思路是把後面的金飾價值排序，從最大的開始拿，加總。一樣注意邊界條件C = 0即可。

解完 LIOJ 題目的時候已經沒剩多少開心的感覺，只是覺得終於跟上當週的進度了。

## 小結
* 一二三週的進度對我來說還算輕鬆，比較可惜是還沒把挑戰題解完。
* 中途往外延伸的研究很大程度拖慢了我的作業進度，可能要先設定止損點以免影響自己原本的進度。
* 簡答題對目前的我來說是不好掌握的作業類型，準備作答的過程很容易找不到方向，或者再深入問題細結時跳脫不出來。
* 我比較難定義研究 markdown 語言 render 的那段過程在課程中的實際意義，因為正規課程絕對不會排這種進度給學生。我也思考過，在工作中做這種事情蠻危險的，畢竟主要的工作進度還是在那邊要完成，survey 必須要明確辨識出問題核心，並且在現行架構下找出暫時可行解，剩下再討論怎麼去改善。
* 複習週最後的安排，先完成當週進度，week5 hw2 閱讀心得投入蠻多時間，再加上念書專注程度有掉下來。導致原本打算要解的挑戰題也沒完成，然後前面的程式作業也還沒修好

總之目前先這樣子了，week6 - 10 再觀察自己的學習方式有沒有改善？

