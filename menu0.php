
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
    #dateTimeDisplay {
      font-size: 1.2rem;
      margin-bottom: 10px;
    }

    /* ボタン類 */
    .button-container {
      margin-bottom: 10px;
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
      width: 100px;
      height: 40px;
 
    } 

    /* テキスト入力欄 */
    #diaryText {
      width: 100%;
      height: 200px;
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
        <li><a href="menu3.php">Theme finding</a></li>
        <li><a href="select0.php">Diary log</a></li>
        <li><a href="logout.php">Log out</a></li>       
    </ul>
    </div>
</nav>

<?php
session_start(); // セッション開始
ini_set('display_errors', '1');
error_reporting(E_ALL);
?>

  <!-- 日付と時間を表示する部分（初期値を例として表示） -->
  <div id="dateTimeDisplay">2025/03/15 09:30 土曜日</div>

  <!-- ボタン類 -->
  <div class="button-container">
    <button id="calendarBtn">カレンダーから日付選択</button>
    <button id="uploadBtn">画像アップロード</button>
    </div>

  <!-- 非表示の date入力（カレンダー表示用） -->
  <input type="date" id="calendarInput" name='date'>
  
  <form action="insert0.php" method="post">
  <!-- <form action="insert0.php" method="post" enctype="multipart/form-data"> -->
  <label for="title">タイトル：</label>
  <input type="text" id="title" name='title' placeholder="タイトルを入力" style="width: 500px; height: 40px;"> <br>
  <!-- テキスト入力欄 -->
  <label for="text_diary">日記</label><br>
  <textarea id="diaryText" name='text_diary' placeholder="テキスト入力" style="width: 600px";></textarea>
  
  <!-- 非表示の file入力（画像アップロード用） -->
  <!-- <input type="file" id="imageInput" name='photo_diary'  accept="image/*" style="display: none;"> -->
  
  <!-- 画像プレビュー表示欄 -->
  <div id="imagePreview">アップロード画像を表示</div>
  
  <button class='saveBtn' type='submit' id='saveBtn'>保存</button>
  
  
</form>

  <script>
    // ========== カレンダーから日付を選択し、上段に表示する部分 ==========

    // ボタンと隠し date入力を取得
    const calendarBtn = document.getElementById('calendarBtn');
    const calendarInput = document.getElementById('calendarInput');
    const dateTimeDisplay = document.getElementById('dateTimeDisplay');
    
    // ボタンクリック時にdate入力をクリック → カレンダー表示
    calendarBtn.addEventListener('click', () => {
      calendarInput.click();
    });

    // 日付を選択したら、上段の表示領域を更新
    calendarInput.addEventListener('change', (e) => {
      const selectedDate = e.target.value; // "YYYY-MM-DD"
      if (selectedDate) {
        const dateObj = new Date(selectedDate);
        const year = dateObj.getFullYear();
        const month = String(dateObj.getMonth() + 1).padStart(2, '0');
        const day = String(dateObj.getDate()).padStart(2, '0');

        // 曜日を求める
        const weekdays = ["日曜日","月曜日","火曜日","水曜日","木曜日","金曜日","土曜日"];
        const weekday = weekdays[dateObj.getDay()];

        // ここでは時刻を仮で 09:30 に固定
        const displayText = `${year}/${month}/${day} 09:30 ${weekday}`;

        // 上段に表示
        document.getElementById('dateTimeDisplay').textContent = displayText;
      }
    });

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
</body>
</html>
