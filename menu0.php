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
    }

    .navbar-nav li a {
        text-decoration: none;
        padding: 5px 15px;
        color: white;
    }

    .navbar-nav li a:hover {
        background-color: #ddd;
    }

    .navbar-header {
                display: flex;
                align-items: center; /* ロゴを中央揃え */
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
      max-width: 40%;
    }
    #imagePreview img {
      max-width: 100%;
      max-height: 100%;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header">
        <a class="navbar-brand" >
            <img src="img/logo.png" alt="Logo" style="width:40px;">
        </a>
    </div>
    <ul class="nav navbar-nav">
        <li><a href="index.php">Menu</a></li>
        <li><a href="menu3.php">Theme finding</a></li>
        <li><a href="select2.php">Scripts</a></li>
        <li><a href="logout.php">Log out</a></li>       
    </ul>
    </div>
</nav>


  <!-- 日付と時間を表示する部分（初期値を例として表示） -->
  <div id="dateTimeDisplay">2025/03/15 09:30 土曜日</div>

  <!-- ボタン類 -->
  <div class="button-container">
    <button id="calendarBtn">カレンダーから日付選択</button>
    <button id="uploadBtn">画像アップロード</button>
    <button id="saveBtn">保存</button>
  </div>

  <!-- 非表示の date入力（カレンダー表示用） -->
  <input type="date" id="calendarInput" style="visibility: hidden; position: absolute;">
  
  <!-- 非表示の file入力（画像アップロード用） -->
  <input type="file" id="imageInput" accept="image/*" style="display: none;">

  <!-- テキスト入力欄 -->
  <textarea id="diaryText" placeholder="テキスト入力"></textarea>

  <!-- 画像プレビュー表示欄 -->
  <div id="imagePreview">アップロード画像を表示</div>

  <script>
    // ========== カレンダーから日付を選択し、上段に表示する部分 ==========

    // ボタンと隠し date入力を取得
    const calendarBtn = document.getElementById('calendarBtn');
    const calendarInput = document.getElementById('calendarInput');

    // ボタンクリック時に非表示の date入力をクリック → カレンダー表示
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

    // ========== 保存ボタン（実際のセッション保存・DB保存はサーバ側処理が必要） ==========

    const saveBtn = document.getElementById('saveBtn');
    saveBtn.addEventListener('click', () => {
      const diaryText = document.getElementById('diaryText').value;
      const dateTime = document.getElementById('dateTimeDisplay').textContent;
      // SESSIONやDBに保存する処理をここで行う（Ajaxやフォーム送信など）
      // 例としてアラートで表示
      alert("以下の内容を保存します\n" + "日付: " + dateTime + "\n本文: " + diaryText);
    });
  </script>
</body>
</html>
