<?php
session_start(); // セッション開始
ini_set('display_errors', '1');
error_reporting(E_ALL);

// セッションデータの取得（speech_data 配列から取り出す）
$speech_data = $_SESSION['speech_data'] ?? [];
$text_prompt = isset($speech_data['text_prompt']) ? $speech_data['text_prompt'] : '';
$prompt_response = isset($speech_data['response_data']) ? $speech_data['response_data'] : '';


// セッションをクリア（必要なら）
// unset($_SESSION['speech_data']);
?> 

<!DOCTYPE html>
<html>
  <head>
    <title>音声録音とテキスト変換</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/menu1.css">

 <style>

.navbar {
    background-color: rgb(21, 96, 130) ;
    color: white;
    padding: 10px 0;
    height: 70px;
    position: relative; /* ナビゲーションバーを固定 */
    overflow: hidden; /* オーバーフローを隠す */
}

.nav.navbar-nav {
    display: flex;
    flex-direction: row;
    justify-content: right;
}

.navbar-nav li {
    display: inline-block;
    margin-right: 15px;
    position: relative; /* 縦線用に相対位置を設定 */

}

.navbar-nav li a {
    text-decoration: none;
    padding: 10px 15px;
    color: white;
}

.navbar-nav li:not(:last-child)::after {
    content: "";
    position: absolute;
    right: -8px; /* 縦線の位置を調整 */
    top: 50%;
    transform: translateY(-50%);
    width: 1px;
    height: 20px; /* 縦線の高さを設定 */
    background-color: white; /* 縦線の色を設定 */
}

.navbar-nav li a:hover {
    background-color: #ddd;
}


.selection {
      /* text-align: center; */
      margin-left: 150px;
      font-family: Arial, sans-serif;
      padding: 20px;
  }

  input {
      margin-right: 10px;
  }

  #generateButton:active {
      -webkit-transform: translateY(4px);
      transform: translateY(4px);
      border-bottom: none;
  }

  /* 選択テーマの表示位置 */
  .result {
      font-size: 20px;
      margin-top: 10px;
      margin-left: 20px;
      font-weight: bold;
  }

  .rec_control {
      /* position: fixed; */
      /* bottom: 0; */
      margin-top: 2%;
      width: 70%;
      /* z-index: 1; */
  }

  .main_content {
      width: 70%;
  }

  #response {
      position: fixed;
      right: 0;
      top: 0;
      padding: 4em 2em;
      font-size: 12px;
      width: 30%;
      overflow-y: scroll;
      -webkit-overflow-scrolling: touch;
      height: 100%;
      border-left: 1px solid #eee;
      z-index: 1;
      background: #fdfdfd;
  }

  #myStopwatch {
      /* text-align: center;  */
      font-size: 24px;
      /* 文字サイズを調整 */
      position: absolute;
      margin-top: 5%;
      left: 32%;
      /* transform: translate(-50%, -50%); */
      /* 中央に配置 */
  }

  .comment {
      /* display: flex;
          justify-content: center;
          align-items: center;
          height: 100vh; */

      margin-top: 100px;
      margin-left: 100px;
      font-size: 15px;
  }

  .container-fluid{
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  

  /* レスポンシブデザインの調整 */
@media screen and (max-width: 600px) {
    .navbar-default {
        padding: 10px 5px;
    }

    .rec_control {
        position: static;
        margin-top: 20px;
        width: 100%;
        text-align: center;
    }
    #response {
        position: static;
        width: 100%;
        height: auto;
        border-left: none;
        border-top: 1px solid #eee;
        padding: 1em;
        overflow-y: visible;
    }


    
footer {
    position: relative; /* ← 親要素を相対位置に */
    height: 30px; /* ← フッターの高さ（調整可） */
    background-color: #f8f8f8; /* フッターの背景色（適宜変更） */
    margin-top: auto; /* ← フッターを下部に固定 */
    
}

footer::before {
    content: "";
    position: absolute;
    /* top: 10; ← 上端に配置（少し下げたければ 5px など） */
    left: 0;
    width: 100%;
    height: 1px; /* ← 線の太さ */
    background-color: #ccc; /* ← 線の色（調整可） */
    opacity: 0.5; /* ← 線の薄さ（0.3〜0.7 で調整） */
}
}
</style>   
</head>  

<body>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" >
              <img src="img/company-logo2.png" alt="Logo" style="width:200px;">
            </a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="index.php">Menu</a></li>
            <li><a href="tutorial-5.1.php">Tutorial</a></li>
            <li><a href="select1.php">即興スピーチ記録</a></li>
            <li><a href="logout.php">Log out</a></li>
            
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> ログイン</a></li>
        </ul>
    </div>
    </nav>
  
  <div class="selection">
    <p class="selection">スピーチをしたいテーマを選ぶ</p>
    <select id="themeSelect">
      <option value="">テーマを選択してください</option>
    </select>
    
    <button id="generateButton">お題を生成</button>
    <div class="result" id="result"></div>

    <script>
        // テーマをキーにして、関連キーワードの配列を値として保持
        const keywordMap = {
            ストーリーを語る: [
                "初めて自転車に乗った時のこと",
                "初めて海外に行った時のこと",
                "初めて仕事をした時のこと",
                "初めて大勢の人前で話をした時のこと",
                "初めて給料をもらった時のこと",
                "初めて一人暮らしした時のこと",
                "始めてトーストマスターズの例会を訪問した時のこと",
                "あなたがこれまでの人生で、「やっちまった」という出来事",
                "あなたの思い出の曲と、それにまつわるストーリー",
                "コロナ禍であなたが経験したことや、感じたこと",
                "あなたが限界に挑戦したエピソードと、そこから学んだこと",
                "皆に一度は聞いて欲しいお勧めのスピーチと、その理由"

            ],
            
            論理的に説明する: [
                "美味しいカレーの作り方",
                "テーブルトピックスのメリット",
                "高校球児は坊主頭がよいか、髪型を自由にしてよいか",
                "あなたに必要な健康法について",
                "あなたの故郷の良さを親善大使として、アピールしてください",
                "あなたが日本の学校教育に導入したい施策",
                "あなたが新しいスマホアプリを創るとしたら、どんなものを誰のために作る？",
                "AI が人の仕事を奪うという懸念があります。あなたの意見は？",
                "あなたが一番好きな本を紹介してください",
                "あなたが一番好きな映画を紹介してください",
                "あなたが一番好きな音楽を紹介してください",
                "あなたが一番好きなアーティストを紹介してください",
                "あなたが一番好きな食べ物を紹介してください",
                "あなたが一番好きな場所を紹介してください",
                "あなたが一番好きなスポーツを紹介してください",
                "あなたが一番好きなアニメを紹介してください",
                "あなたが皆に一度は訪れてほしいお店"
            ],

            説得をする:[
                "こどもへ、読書の良さを伝えてください",
                "友人へ、健康的な生活習慣の重要性を説得してください",
                "家族へ、環境保護のための行動を促してください",
                "上司へ、リモートワークの必要性を説得してください",
                "家族へ、ボランティア活動の価値を伝えてください",
                "ご近所さんへ、コミュニティ活動への参加を促してください",
                "消費者へ、新製品の購入を説得してください",
                "学生へ、勉強の重要性を説得してください",
                "親へ、ペットを飼うことの利点を説得してください",
                "同僚へ、チームビルディングの重要性を説得してください",
                "上司へ、新しい技術の導入を説得してください",
                "友人へ、スポーツ活動の利点を説得してください",
                "家族へ、リサイクルの重要性を説得してください",
                "消費者へ、エコ製品の購入を説得してください",
                "こどもへ、時間管理の重要性を説得してください",
                "親へ、留学の利点を説得してください",
                "友人へ、趣味を始めることの利点を説得してください"                
            ],
            
        };
        
        const themeSelect = document.getElementById('themeSelect');
        for (const theme in keywordMap) {
            const option = document.createElement('option');
            option.value = theme;
            option.textContent = theme;
            themeSelect.appendChild(option);
        }
        
        let displayedKeywords = [];
        function getRandomKeyword(theme) {
            const keywords = keywordMap[theme];
            if (!keywords) {
                return "該当するテーマが見つかりませんでした。別のテーマを試してください。";
            }
        
        // すべてのキーワードが表示された場合、リセット
        if (displayedKeywords.length === keywords.length) {
            displayedKeywords = [];
        }
         
        let keyword;
        do {
            const randomIndex = Math.floor(Math.random() * keywords.length);
            keyword = keywords[randomIndex];
        } while (displayedKeywords.includes(keyword));

        displayedKeywords.push(keyword);
        return keyword;   
    }
        //     const randomIndex = Math.floor(Math.random() * keywords.length);
        //     return keywords[randomIndex];          
        // }
      
        $(document).ready(function() {
            $("#generateButton").click(function () {
                const selectedTheme = $("#themeSelect").val();
                const keyword = getRandomKeyword(selectedTheme);
                $("#result").text(keyword);
                $("#generatedTopic").val(keyword); // 選択したお題をhidden inputにセット
            });
        });
    </script>
  
  </div>  
  
  <div class="main_content">
      <!-- <div class="text-center mb-5">
        <img src="img/assistant.png" style="width:260px;border-radius: 100%;">
      </div> -->
      
      <div class="text-center mb-4" id="load_gif" style="display: none;">
        <img src="img/load.gif" width="20px;" class="d-inline-block me-1">
        <span class="small text-secondary">please wait</span>
      </div>
      
      <div id="response_now" class="mb-5 mx-auto fw-bold"></div>
      
      <div class="pt-4 text-center">
        テーマに沿ってお話しください。
      </div>
    </div>
    
    <div class="rec_control text-center py-3 border-top bg-white">
      <button id="startRecord" class="btn btn-danger text-white">録音開始</button>
      <button id="stopRecord" disabled class="btn btn-info text-white" style="display: none;">録音停止</button>
    </div>
    
    <div id="response"></div>
    
    <script>
      let mediaRecorder;
      let audioChunks = [];
      
      $("#startRecord").click(function () {
        $('#startRecord').css('display', 'none'); 
        $('#stopRecord').css('display', 'inline-block'); 
        
        navigator.mediaDevices.getUserMedia({ audio: true })
        .then(stream => {
          mediaRecorder = new MediaRecorder(stream);
          mediaRecorder.ondataavailable = e => {
            audioChunks.push(e.data);
          };
          mediaRecorder.onstop = e => {
            $('#startRecord').css('display', 'inline-block'); 
            $('#stopRecord').css('display', 'none'); 
            
            const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
            const formData = new FormData();
            formData.append("voice", audioBlob, "voice.wav");
            $('#load_gif').css('display', 'block');
            
            $.ajax({
              url: "upload1.php",  //upload ファイルへ転送
              type: "POST",
              data: formData,
              processData: false,
              contentType: false,
              success: function(response) {
                // 重複を防ぐため、表示領域の内容を置き換えます
                // $('#response').html(response);
                // $('#load_gif').css('display', 'none');  
                $('#response').prepend(response);
                $('#load_gif').css('display', 'none'); 
              }
            });
            audioChunks = [];
          };
          mediaRecorder.start();
          $("#stopRecord").prop("disabled", false);
           startTimer(); // タイマーを開始
        });
      });
        
      $("#stopRecord").click(function () {
        mediaRecorder.stop();
        $("#stopRecord").prop("disabled", true);
        $('#load_gif').css('display', 'block'); 
        stopTimer(); // タイマーを停止
        // resetTimer(); // タイマーリセット
      });
    </script>
  
   <!--タイマー機能  -->
  
   <h1 id="time">
        <div id="T1"></div>
    </h1>

    <div id="myStopwatch">
        00:00:00
    </div>

    <!-- <ul id="buttons"　ボタン表示>
        <li><button onclick="startTimer()">Start</button></li>
        <li><button onclick="stopTimer()">Stop</button></li>
        <li><button onclick="resetTimer()">Reset</button></li>
    </ul> -->

    <script>
        const timer = document.getElementById('myStopwatch');

        let hr = 0;
        let min = 0;
        let sec = 0;
        let stoptime = true;

        function startTimer() {
            if (stoptime == true) {
                stoptime = false;
                timerCycle();
            }
        }
        function stopTimer() {
            if (stoptime == false) {
                stoptime = true;
            }
        }

        function timerCycle() {
            if (stoptime == false) {
                sec = parseInt(sec);
                min = parseInt(min);
                hr = parseInt(hr);

                sec += 1;

                if (sec == 60) {
                    min += 1;
                    sec = 0;
                }
                if (min == 60) {
                    hr += 1;
                    min = 0;
                    sec = 0;
                }

                if (sec < 10 || sec == 0) {
                    sec = '0' + sec;
                }
                if (min < 10 || min == 0) {
                    min = '0' + min;
                }
                if (hr < 10 || hr == 0) {
                    hr = '0' + hr;
                }

                timer.innerHTML = hr + ':' + min + ':' + sec;
                // タイマーの進行に応じて背景色を変更
                changeBackgroundColor(hr, min, sec);
                setTimeout("timerCycle()", 1000);
            }
        }

        function resetTimer() {
            hr = 0;
            min = 0;
            sec = 0;
            stoptime = true; // タイマーが走っていない状態にする
            timer.innerHTML = '00:00:00';
            document.body.style.backgroundColor = '#ffffff';
        }

        function changeBackgroundColor(hr, min, sec) {
        // 経過秒数を計算
        const totalSec = parseInt(hr) * 3600 + parseInt(min) * 60 + parseInt(sec);
        
        if (totalSec < 60) {
            document.body.style.backgroundColor = 'white';
        } else if (totalSec < 90) {
            document.body.style.backgroundColor = 'green';
        } else if (totalSec < 120) {
            document.body.style.backgroundColor = 'yellow';
        } else if (totalSec < 150) {
            document.body.style.backgroundColor = 'red';
        } else {
            // 例えば、150秒を超えたらさらに別の色にするなど
            document.body.style.backgroundColor = 'blue';
        }
    }    
    </script>

  <!-- 現在時刻の表示 -->
    <!-- <script>
        window.onload = function () {
            setInterval(function () {
                var dd = new Date();
                document.getElementById("T1").innerHTML = dd.toLocaleString();
            }, 1000);
        }
    </script> -->

    
    <form id="saveForm" method="POST" action="insert1.php" enctype="multipart/form-data">
        <div class="comment">
            <fieldset>
                <legend>振り返りメモ</legend>
                <div>
                    <label for="text_prompt"></label>
                    <textarea name="text_prompt" id="text_prompt" rows="2" cols="80"><?php echo htmlspecialchars($text_prompt); ?></textarea>

                </div>
                    <!-- お題を保持するhidden form -->
                <input type='hidden' name='generated_topic' id='generatedTopic' value='' >
                <p class="response-prompt"><input type="hidden" name="response_prompt" id="hiddenResponsePrompt" value="<?php echo htmlspecialchars($prompt_response); ?>">            


                <div>
                    <input type="submit" value="保存"  style="display: inline-block;">
                    <input type="reset" value="リセット" onclick="resetSpeech()" style="display: inline-block;">
                </div>
            </fieldset>
             <!-- <div class= "response-container">
                    <?php if (!empty($prompt_response)): ?>
                    <h3>スピーチ原稿案</h3>
                    <p id='response'><?php echo nl2br(htmlspecialchars($prompt_response)); ?></p>
                    <?php endif; ?>
                </div>  -->

        </div>
                
    </form>
</div>

<script>
        document.getElementById('saveForm').addEventListener('submit', function() {
            const responseContent = document.getElementById('response').innerHTML;
            // document.getElementById('hiddenTextPrompt').value = textContent;
            document.getElementById('hiddenResponsePrompt').value = responseContent;
        });
       function resetSpeech() {
            resetTimer(); // タイマーリセット
            document.getElementById('response').innerHTML = ''; // レスポンス内容をクリア
    
            // generateButton のリセット
        const generateButton = document.getElementById('generateButton');
        generateButton.disabled = false; // ボタンを有効にする
        generateButton.textContent = 'お題を生成'; // ボタンのテキストをリセット

        // result のリセット
        document.getElementById('result').textContent = ''; // 結果表示をクリア
   
    
    }
</script>


<!-- <footer>
        <p>© 2025 AI SPEECH. All rights reserved</p> 
</footer> -->
    
</body>
</html>
    
    