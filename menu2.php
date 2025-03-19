<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>スピーチ原稿作成</title>
</head>
<body>
<!-- ローディングオーバーレイ -->
<div id="loadingOverlay" style="display: none;">
  <div class="spinner"></div>
  <div class="loading-text">スピーチ生成中…</div>
</div>

<!-- <div class="overlay"></div>
  <nav class="nav">
    <div class="toggle">
      <span id="deleteconpo" class="toggler"></span>
    </div>
    <div class="logo">
      <a href="#">TIPS</a>
    </div>
    <ul>
      <li><a href="#">スピーチの作り方TIPS</a></li>
      <li><a href="#">スピーチの作り方TIPS</a></li>
      <li><a href="#">スピーチの作り方TIPS</a></li>
      <li><a href="#">スピーチの作り方TIPS</a></li>
      <li><a href="#">スピーチの作り方TIPS</a></li>
    </ul>
  </nav> -->

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


<?php
session_start(); // セッション開始
ini_set('display_errors', '1');
error_reporting(E_ALL);

// menu3.php （テーマ生成）からPOSTされたセッションデータの取得
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'])) {
    $_SESSION['speech_data'] = [
        'title'    => $_POST['title'] ?? '',
        'message'  => $_POST['message'] ?? '',
        'outline1' => $_POST['outline1'] ?? '',
        'outline2' => $_POST['outline2'] ?? '',
        'outline3' => $_POST['outline3'] ?? '',
        'outline4' => $_POST['outline4'] ?? '',
    ];
}

// uload3.php からセッションデータの取得
$speech_data = $_SESSION['speech_data'] ?? [];
$title = $speech_data['title'] ?? '';
$purpose = $speech_data['purpose'] ?? '';
$char_limit = $speech_data['char_limit'] ?? '';
$message = $speech_data['message'] ?? '';
$outline1 = $speech_data['outline1'] ?? '';
$outline2 = $speech_data['outline2'] ?? '';
$outline3 = $speech_data['outline3'] ?? '';
$outline4 = $speech_data['outline4'] ?? '';
$response_text = $speech_data['response'] ?? '';

// セッションをクリア（必要なら）
unset($_SESSION['speech_data']);
?>

<h2 class='header'>スピーチ骨子入力 <span class='arrow'> </span></h2>
<div class="container">
    <div class="form-container">
        <form action="upload2.php" method="post">
            <div class='button-container'>
                <input class='create' type="submit" value="原稿を生成"> <br>
                <input class='save' type="submit" value="原稿を保存" form='saveForm'> <br><br>
                <input class='reset' type="reset" value="リセット" onclick="resetSpeech()">
            </div> <br>
            <label for="purpose">スピーチの目的</label>
            <select name="purpose" id="purpose">
                <option value="inform" <?php echo ($purpose == 'inform') ? 'selected' : ''; ?>>情報提供</option>
                <option value="entertain" <?php echo ($purpose == 'entertain') ? 'selected' : ''; ?>>楽しませる</option>
                <option value="motivate" <?php echo ($purpose == 'motivate') ? 'selected' : ''; ?>>動機付ける</option>
                <option value="persuade" <?php echo ($purpose == 'persuade') ? 'selected' : ''; ?>>説得する</option>
            </select> <br>

            <label for="char_limit">スピーチ時間</label>
            <select name="char_limit" id="char_limit">
                <?php
                $limits = [0.2, 0.5, 1, 3, 5, 7];
                foreach ($limits as $limit) {
                    $selected = ($char_limit == $limit) ? 'selected' : '';
                    echo "<option value=\"$limit\" $selected>{$limit}分</option>";
                }
                ?>
            </select> <br><br>

            <label for="title">スピーチタイトル</label> <br>
            <input type="text" name="title" id="title" placeholder="スピーチタイトルを記載" style="width: 500px;"
                value="<?php echo htmlspecialchars($title); ?>">  <br> 

            
            <label for="message">伝えたいメッセージ</label>
            <input type="text" name="message" id="message" placeholder="メッセージを記載" style="width: 500px;"
                value="<?php echo htmlspecialchars($message); ?>"><br>

            <label for="outline1">スピーチの骨子①</label>
            <input type="text" name="outline1" id="outline1" placeholder="骨子を記載" style="width: 500px;"
                value="<?php echo htmlspecialchars($outline1); ?>"><br>
            <label for="outline2">スピーチの骨子②</label>
            <input type="text" name="outline2" id="outline2" placeholder="骨子を記載" style="width: 500px;"
                value="<?php echo htmlspecialchars($outline2); ?>"><br>
            <label for="outline3">スピーチの骨子③</label>
            <input type="text" name="outline3" id="outline3" placeholder="骨子を記載" style="width: 500px;"
                value="<?php echo htmlspecialchars($outline3); ?>"><br>
            <label for="outline4">スピーチの骨子④</label>
            <input type="text" name="outline4" id="outline4" placeholder="骨子を記載" style="width: 500px;"
                value="<?php echo htmlspecialchars($outline4); ?>"><br><br> 

        </form>
    
    <div class="button-container"> 
        <form action="insert2.php" method="POST" id="saveForm">    
        <!-- <form action="insert2.php" method="POST"> -->
        <input type="hidden" name="title" id="hiddenTitle" value="<?php echo htmlspecialchars($title); ?>">     
        <input type="hidden" name="text_ready" id="hiddenTextReady" value="<?php echo htmlspecialchars($response_text); ?>">           
    
        </form>
                <!-- <input type="hidden" name="title" id="hiddenTitle">      -->
                <!-- <input type="hidden" name="text_ready" id="hiddenTextReady">      -->
                <!-- URLのクエリパラメータからGET -->
                
        </form>    
    </div>

    </div>    
    
    <div class= "response-container"> 
        <h2>スピーチ原稿案</h2>
        <?php if (!empty($response_text)): ?>
    
        <p id='response'>
        <?php echo nl2br(htmlspecialchars($response_text)); ?></p>
        <p id="charCount"></p> <!-- 文字数を表示する要素を追加 -->
        <?php endif; ?>
    </div>


</div>

    <script>
    // フォーム送信時に title の値を隠しフィールドに設定
    document.getElementById('saveForm').addEventListener('submit', function() {
    var title = document.getElementById('title').value;
    var textReady = document.getElementById('response').innerText; // 生成されたtext_readyの値を取得
      document.getElementById('hiddenTitle').value = title;
    document.getElementById('hiddenTextReady').value = textReady;
    });

    
    // // ナビゲーションメニューのトグル
    // const toggler = document.querySelector(".toggle");
    // window.addEventListener("click", event => {
    // if(event.target.className == "toggle" || event.target.className == "toggle") {
    //     document.body.classList.toggle("show-nav");
    //     document.getElementById("deleteconpo").classList.toggle("deleteclass")
    // } else if (event.target.className == "overlay") {
    //     document.body.classList.remove("show-nav");
    // document.getElementById("deleteconpo").classList.toggle("deleteclass")
    // }

 
   // 文字数をカウントして表示する関数
    function updateCharCount() {
        var responseText = document.getElementById('response').innerText;
        var charCount = responseText.length;
        document.getElementById('charCount').innerText = '['charCount + '文字]';

    }

    // ページ読み込み時に文字数を更新
    window.onload = updateCharCount;
   
   </script>

<style>

.navbar {
    background-color: rgb(21, 96, 130) ;
    color: white;
    padding: 10px 0;
    height: 50px;
    position: relative; /* ナビゲーションバーを固定 */
    overflow: hidden; /* オーバーフローを隠す */
}

/* 背景にスピーチ関連のアイコンを配置 */
/* .navbar::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="white"><circle cx="20" cy="20" r="8"/><rect x="50" y="10" width="10" height="30"/><path d="M70 40 L90 60 L70 80 Z"/></svg>');
    background-size: 120px;
    background-repeat: repeat;
    opacity: 0.2; /* 模様を薄くする */
    z-index: 0;
} */

/* 他の要素の上に配置 */
.nav.navbar-nav, .navbar-header {
    position: relative;
    z-index: 1;
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

        .navbar-brand img {
            vertical-align: middle; /* ロゴを中央揃え */
        }

.container {
    display: flex;
    margin-left: 20px;
}

/* フレックスアイテムが利用可能なスペースを均等に分割することを指定します。 
form-container クラスが適用された要素は、親の container 要素内で他のフレックスアイテムと同じ割合でスペースを占有 */

.form-container {
    display: flex;
    flex: 1;
    padding-right: 10px; /* 境界線のための余白を追加  */
}

.response-container {
    
    flex: 1;
    margin-top: -75px;
    /* align-items: flex-start; 上部揃え */
    padding-left: 30px;
    padding-right: 20px;
    border-left: 1px solid #ccc; /* 縦線を追加 */
}

.button-container {
    display: flex;
    gap: 10px;
    margin-right: 10px;
    height: 30px;
    /* width: 100px; */
    padding: 8px 12px;
    cursor: pointer;
    /* align-items: center; ボタンを垂直方向に中央揃え */
}

.create:hover, .save:hover, .reset:hover {
background-color:rgb(209, 229, 243);
}

footer {
    position: relative; /* ← 親要素を相対位置に */
    height: 60px; /* ← フッターの高さ（調整可） */
    background-color: #f8f8f8; /* フッターの背景色（適宜変更） */
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
 
/* .arrow{
    display: inline-flex;
    font-size: 40px;
    color: black;
    /* margin-top: 10px; */
    margin-left: 340px;
} */

/* Drawer */
/* .overlay {
  width: 100%;
  height: 100vh;
  position: fixed;
  left: 0;
  top: 0;
  background-color: rgba(0,0,0,.3);
  z-index: 190;
  opacity: 0;
  visibility: hidden;
  transition: all 200ms ease-in;
}
nav.nav {
  width: 270px;
  height: 100vh;
  background-color: #FFF;
  left: -270px;
  top: 0;
  position: fixed;
  padding: 20px 0;
  transition: all 200ms ease-in-out;
  z-index: 199;
}
nav.nav ul {
    border: none;
    padding: 0;
}
.toggle {
  position: relative;
  left: 100%;
  width: 50px;
  height: 50px;
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  cursor: pointer;
}

span.toggler,
span.toggler:before,
span.toggler:after {
    content: '';
    display: block;
    height: 3px;
    width: 25px;
    border-radius: 3px;
    background-color: #ffffff;
    position: absolute;
    pointer-events: none;
}

span.toggler:before{
    bottom: 9px;
}
span.toggler:after {
    top: 9px;
}
span.deleteclass {
    background-color: transparent;
}
span.deleteclass::before {
    bottom: 0;
    transform: rotate(45deg);
}
span.deleteclass::after {
    top: 0;
    transform: rotate(-45deg);
} */

.logo {
  text-align: center;
  margin-bottom: 30px;
}
.logo  a{
  text-decoration: none;
  color: #888;
  font-size: 2rem;
}
.nav ul li {
  display: block;
  list-style: none;
  margin: 0;
  padding: 0;
}
.nav ul li a {
  padding: 10px 20px;
  display: block;
  color: #313131;
  font-size: 1rem;
  text-decoration: none;
  transition: all 200ms ease;
}
.nav ul li a:hover {
  background-color: #f1f1f1;
}

/* Show Nav */
.show-nav .nav {
  left: 0;
  box-shadow: 0 2px 4px rgba(0,0,0,.6);
}
.show-nav .overlay {
  opacity: 1;
  visibility: visible;
}

/* .header, .response-container h2 {
    font-family: Arial, sans-serif; /* フォントファミリーを統一 */
    font-size: 24px; /* フォントサイズを統一 */
    font-weight: bold; /* フォントウェイトを統一 */
    color: #333; /* フォントカラーを統一 */
    margin-bottom: 20px; /* 下部の余白を追加 */

.header{
    align-items: flex-start; /* 上部揃え */
}


.header {
    margin-top: -10px;  

    position: relative;  /* 縦線用 */
    font-size: 20px;
    padding: 10px 20px 5px; /* 上左右下の余白 */
    border-bottom: 1px solid rgba(0, 0, 0, 0.2); /* 薄い横線 */
}

.header::before {
    content: "";
    position: absolute;
    left: -10px; /* 文字の左側に配置 縦線位置は数字で調整*/
    top: 0;
    width: 1px;
    /* height: calc(100vh + 50px); ← 画面の高さより50px長くする */
    height: 120%;
    background-color: rgba(0, 0, 0, 0.2); /* 縦線を薄く */
}

/* オーバーレイ全体 */
  #loadingOverlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.8); /* 半透明の背景 */
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    z-index: 1000;
  }
  /* スピナーのスタイル */
  .spinner {
    border: 16px solid #f3f3f3; /* 薄いグレー */
    border-top: 16px solid #3498db; /* 青 */
    border-radius: 50%;
    width: 120px;
    height: 120px;
    animation: spin 2s linear infinite;
  }
  /* アニメーション定義 */
  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
  /* ローディングテキストのスタイル */
  .loading-text {
    font-size: 20px;
    margin-top: 20px;
  }
</style>

<script>
    function resetSpeech() {
        document.querySelector('.response-container p').innerHTML = '';
        document.querySelector('charCount').innerHTML = '';
    }

      // スピナー用。　upload2.phpへ送信するフォームを取得
    const speechForm = document.querySelector("form[action='upload2.php']");
    if (speechForm) {
        speechForm.addEventListener("submit", function() {

        // 送信時にローディングオーバーレイを表示
      document.getElementById("loadingOverlay").style.display = "flex";
    });
  }


</script>

</body>

<footer>
        <p>© 2025 xxx Website</p> <!-- ← 任意のフッターコンテンツ -->
</footer>


</html>