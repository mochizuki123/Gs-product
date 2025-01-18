<!DOCTYPE html>
<html>
  <head>
    <title>音声録音とテキスト変換</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="CSS/style.css">
    
    <style>
      
    </style>
  </head>
  
  <body>
  
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
            趣味: ["野球", "釣り", "読書", "ゲーム", "料理"],
            スポーツ: ["サッカー", "バスケットボール", "ランニング", "水泳", "テニス"],
            音楽: ["ロック", "ポップ", "ジャズ", "クラシック", "ヒップホップ"],
            旅行: ["温泉", "ビーチ", "山登り", "海外旅行", "キャンプ"]
        };
        
        const themeSelect = document.getElementById('themeSelect');
        for (const theme in keywordMap) {
            const option = document.createElement('option');
            option.value = theme;
            option.textContent = theme;
            themeSelect.appendChild(option);
        }
        
        
        function getRandomKeyword(theme) {
            const keywords = keywordMap[theme];
            if (!keywords) {
                return "該当するテーマが見つかりませんでした。別のテーマを試してください。";
            }
            const randomIndex = Math.floor(Math.random() * keywords.length);
            return keywords[randomIndex];          
        }
      
        $(document).ready(function() {
            $("#generateButton").click(function () {
                const selectedTheme = $("#themeSelect").val();
                const keyword = getRandomKeyword(selectedTheme);
                $("#result").text(keyword);
        // // ボタンのクリックイベントリスナー
        // document.getElementById("generateButton").addEventListener("click", () => {
        //     const theme = document.getElementById("themeInput").value.trim();
        //     const result = getRandomKeyword(theme);
        //     document.getElementById("result").textContent = result;
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
        テーマに沿って会話を始めてみよう。
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
              url: "upload2.php",  //upload ファイルへ転送
              type: "POST",
              data: formData,
              processData: false,
              contentType: false,
              success: function(response) {
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
        resetTimer(); // タイマーリセット
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

                setTimeout("timerCycle()", 1000);
            }
        }

        function resetTimer() {
            timer.innerHTML = '00:00:00';
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
  </body>
</html>

<style>
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
  font-size: 40px;  
  margin-top: 40px;
    margin-left: 20%;
    font-weight: bold;
}

.rec_control {
    position: fixed;
    bottom: 0;
    width: 70%;
    z-index: 1;
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
        margin-top: 10%;
        left: 30%;
        /* transform: translate(-50%, -50%); */
            /* 中央に配置 */
}

</style>