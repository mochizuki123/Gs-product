<?php
session_start(); // セッション開始
ini_set('display_errors', '1');
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>日記アプリ</title>
  <style>
    .navbar {
        background-color: rgb(21, 96, 130) ;
        color: white;
        padding: 10px 0;
        height: 50px;
    }

    .nav.navbar-nav {
        display: flex;
        flex-direction: row;
        justify-content: right;
        /* align-items: center;  */
    }

    .navbar-nav li {
        display: inline-block;
        margin-right: 15px;
        position: relative; /* 縦線用に相対位置を設定 */

    }

    .navbar-nav li a {
        text-decoration: none;
        padding: 5px 15px;
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

    .navbar-header {
        display: flex;
        align-items: center; /* ロゴを中央揃え */
            }


    .navbar-brand{
      margin-left: 10px;
    }

    .navbar-brand img {
        display: inline-block;
        vertical-align: middle; /* ロゴを中央揃え */
    }

body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    margin: 0;
} 
        
.container {
    display: flex;
    margin-left: 20px;
}


    #calendarInput {
      position: fixed;
      top: 10px;      /* 画面上部に配置 */
      right: 10px;    /* 画面右側に配置 */
      width: 1px;
      height: 1px;
      opacity: 0;
    }
  
    body {
      font-family: sans-serif;
      margin: 20px;
      /* max-width: 600px; */
    }

    /* 日付時刻表示 */
    .dateTimeDisplay{
      display: flex;
      align-items: center;
      /* margin-top:20px; */
    }
    
    #dateTimeDisplay {
      font-size: 1.2rem;
      margin-bottom: 10px;

    }

    /* ボタン類 */
    .button-container {
      display: flex;
      /* justify-content: flex-end; */
      /* margin-bottom: 10px; */

    }
    .button-container button {
      margin-right: 10px;
      padding: 8px 12px;
      cursor: pointer;
    }

    .saveBtn{
      margin-top: 10px;
      margin-right: 10px;
      /* padding: 8px 12px; */
      cursor: pointer;
      width: 200px;
      height: 40px;
 
    } 

    /* テキスト入力欄 */
    #diaryText {
      width: 100%;
      height: 270px;
      box-sizing: border-box;
      margin-bottom: 20px;
      font-size: 1rem;
      padding: 10px;
    }

    /* 画像プレビュー */
    #imagePreview {
      width: 100%;
      min-height: 150px;
      background-color: #fee;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      width: 600px;
    }
    #imagePreview img {
      max-width: 100%;
      max-height: 100%;
    }

    .container-fluid{
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .container {
        display: flex;
        margin-left: 20px;
        position: relative;
    }

    .input-container {
        flex: 1;
        margin-top:10px;
        
    }

    .calendar-container {
          display: flex;
        flex-direction: column;
        /* min-height: 100vh; */
        margin: 0;  
      position: absolute;
        top: 13%;
        right: 20%;
    }

  .calendar th, .calendar td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        .cal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        button {
            padding: 5px 10px;
            cursor: pointer;
        }

    .calendar-container {
      display: flex;
      justify-content: flex-end;
    }
  /* カーソルを日付に合わせると背景色を変更 */
  .calendar td:hover {
      background-color: #f0f8ff; /* 薄い青 */
      cursor: pointer;
  }

  /* 選択した日付の背景色を強調 */
  .calendar td.selected {
      background-color: #87CEEB; /* スカイブルー */
      color: white;
      font-weight: bold;
  }

footer {
    position: fixed; /* ← 画面の下部に固定 */
    bottom: 0; /* ← 下端に配置 */
    width: 100%; /* ← 幅を100%に設定 */
    height: 60px; /* ← フッターの高さ（調整可） */
    background-color: #f8f8f8; /* フッターの背景色（適宜変更） */
    margin-top: auto; /* ← フッターを下部に固定 */
}

footer::before {
    content: "";
    position: absolute;
    top: 0; /* ← 上端に配置（少し下げたければ 5px など） */
    left: 0;
    width: 100%;
    height: 1px; /* ← 線の太さ */
    background-color: #ccc; /* ← 線の色（調整可） */
    opacity: 0.5; /* ← 線の薄さ（0.3〜0.7 で調整） */
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
        <li><a href="tutorial-2.php">Tutorial</a></li>
        <li><a href="menu3.php">テーマ生成</a></li>
        <li><a href="select0.php">スピーチの種 一覧</a></li>
        <li><a href="logout.php">Log out</a></li>       
    </ul>
    </div>
</nav>

<div class='input-container'>
  <!-- 日付と時間を表示する部分（初期値を例として表示） -->
  <p style='display: inline; font-weight:bold;'>日付：</p><div class='dateTimeDisplay' id="dateTimeDisplay" style="display: inline;"></div>
  <form id='diaryForm' action="insert0.php" method="post">
    <input type='hidden' id='hiddenDateTime' name='date'>
    <label for="title" style='font-weight: bold;'>タイトル：</label>
    <input type="text" id="title" name='title' placeholder="タイトルを入力" style="width: 500px; height: 40px;"> <br>
    <!-- テキスト入力欄 -->
    <label for="text_diary" style="font-weight: bold;">日記</label><br>
    <textarea id="diaryText" name='text_diary' placeholder="テキスト入力" style="width: 600px;"></textarea>
    
    <!-- 非表示の file入力（画像アップロード用） -->
    <input type="file" id="imageInput" name='photo_diary'  accept="image/*" style="display: none;">
    
    <!-- 画像プレビュー表示欄 -->
    <div id="imagePreview">アップロード画像を表示</div>
    
    <div class="button-container">
      <button class='saveBtn' type='submit' id='saveBtn'>保存</button> 
      <button class='saveBtn' type='button' id="uploadBtn">画像アップロード</button>
    </div>
  </form>


  
<script>
  document.getElementById('diaryForm').addEventListener('submit', function(e) {
    // hiddenDateTime の値が空かチェック
    if (document.getElementById('hiddenDateTime').value.trim() === '') {
      // 入力されていない場合、送信をキャンセルしてアラートを表示
      e.preventDefault();
      alert('日付が選択されていません。日付を入力してください。');
    }
  });

const dateTimeDisplay = document.getElementById('dateTimeDisplay');
    const hiddenDateTime = document.getElementById('hiddenDateTime');
    
    
    // ボタンクリック時にdate入力をクリック → カレンダー表示
    calendarBtn.addEventListener('click', () => {
      calendarInput.click();
    });

    function updateDateTimeDisplay(year, month, day) {
    const weekdays = ["日曜日","月曜日","火曜日","水曜日","木曜日","金曜日","土曜日"];
    const selectedDate = new Date(year, month - 1, day);
    const weekday = weekdays[selectedDate.getDay()];

    // 日付の表示フォーマットは例として "YYYY/MM/DD (曜日)" とする
    const displayText = `${year}/${month}/${day} (${weekday})`;
    document.getElementById('dateTimeDisplay').textContent = displayText;
    
    // 隠しフィールドに値をセット（DB用なら "YYYY-MM-DD" 等、適切なフォーマットに変換）
    const dbFormat = `${year}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
    document.getElementById('hiddenDateTime').value = dbFormat;
}

    // // 日付を選択したら、上段の表示領域を更新
    // calendarInput.addEventListener('change', (e) => {
    //   const selectedDate = e.target.value; // "YYYY-MM-DD"
    //   if (selectedDate) {
    //     const dateObj = new Date(selectedDate);
    //     const year = dateObj.getFullYear();
    //     const month = String(dateObj.getMonth() + 1).padStart(2, '0');
    //     const day = String(dateObj.getDate()).padStart(2, '0');

    //     // 曜日を求める
    //     const weekdays = ["日曜日","月曜日","火曜日","水曜日","木曜日","金曜日","土曜日"];
    //     const weekday = weekdays[dateObj.getDay()];

    //     // ここでは時刻を仮で 09:30 に固定
    //     const displayText = `${year}/${month}/${day} 09:30 ${weekday}`;

    //     // 上段に表示
    //     document.getElementById('dateTimeDisplay').textContent = displayText;
    //     hiddenDateTime.value = displayText; // 隠しフィールドに設定
    //   }
    //   }
    // });

    // ========== 画像アップロードとプレビュー表示 ==========

    const uploadBtn = document.getElementById('uploadBtn');
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');

    // 「画像アップロード」ボタン → 非表示の file入力をクリック
    uploadBtn.addEventListener('click', () => {
      imageInput.click();
    });

    // ファイルを選択したらプレビュー表示
    imageInput.addEventListener('change', (e) => {
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
          imagePreview.innerHTML = `<img src="${event.target.result}" alt="アップロード画像">`;
        };
        reader.readAsDataURL(file);
      } else {
        // ファイル未選択やクリアの場合
        imagePreview.textContent = "アップロードした画像を表示";
      }
    });

  </script>
</div>


  <div class='calendar-container'>
    <div class="cal-header">
        <button onclick="prevMonth()">←</button>
        <h2 id="monthYear"></h2>
        <button onclick="nextMonth()">→</button>
    </div>
    <table class="calendar">
        <thead>
            <tr>
                <th>日</th><th>月</th><th>火</th><th>水</th><th>木</th><th>金</th><th>土</th>
            </tr>
        </thead>
        <tbody id="calendar-body"></tbody>
    </table>
    <script>
     
     let currentDate = new Date();
     let selectedTd = null; // 選択した日付を記録

        function renderCalendar() {
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            document.getElementById("monthYear").innerText = `${year}年 ${month + 1}月`;

            const firstDay = new Date(year, month, 1).getDay();
            const lastDate = new Date(year, month + 1, 0).getDate();
            let days = "";
            
            let date = 1;
            for (let i = 0; i < 6; i++) {
                let row = "<tr>";
                for (let j = 0; j < 7; j++) {
                    if (i === 0 && j < firstDay) {
                        row += "<td></td>";
                    } else if (date > lastDate) {
                        break;
                    } else {
                      // --- 日付クリックすると、DateTimeDisplayに反映されるクリックイベントを追加 ---                    
                    row += `<td onclick="updateDateTimeDisplay(${year}, ${month + 1}, ${date}, this)">${date}</td>`;
                    date++;  
                      // row += `<td>${date}</td>`;
                      //   date++;
                    }
                }
                row += "</tr>";
                days += row;
                if (date > lastDate) break;
            }
            document.getElementById("calendar-body").innerHTML = days;
        }
        
        function prevMonth() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        }

        function nextMonth() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        }

  function updateDateTimeDisplay(year, month, day) {
    const weekdays = ["日曜日","月曜日","火曜日","水曜日","木曜日","金曜日","土曜日"];
    const selectedDate = new Date(year, month - 1, day);
    const weekday = weekdays[selectedDate.getDay()];

    // 表示用のテキスト
    const displayText = `${year}/${month}/${day} (${weekday})`;
    document.getElementById('dateTimeDisplay').textContent = displayText;
    
    // DB用フォーマット（YYYY-MM-DD）に変換して隠しフィールドに設定
    const dbFormat = `${year}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
    document.getElementById('hiddenDateTime').value = dbFormat;
}

        renderCalendar();
    </script>

  </div>
</body>

<footer>
        <p>© AI SPEECH. All rights reserved</p> <!-- ← 任意のフッターコンテンツ -->
</footer>

</html>
