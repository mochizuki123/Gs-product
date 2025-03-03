<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>スピーチ原稿作成</title>
</head>
<body>

<div class="overlay"></div>
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
  </nav>

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

// セッションデータの取得
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

<h2>スピーチ原稿の生成</h2>
<div class="container">
    <div class="form-container">
        <form action="upload2.php" method="post">
            <label for="title">スピーチタイトル</label>
            <input type="text" name="title" id="title" placeholder="スピーチタイトルを記載" style="width: 300px;"
                value="<?php echo htmlspecialchars($title); ?>">  <br> 

            <label for="purpose">スピーチの目的</label>
            <select name="purpose" id="purpose">
                <option value="inform" <?php echo ($purpose == 'inform') ? 'selected' : ''; ?>>情報提供</option>
                <option value="entertain" <?php echo ($purpose == 'entertain') ? 'selected' : ''; ?>>楽しませる</option>
                <option value="motivate" <?php echo ($purpose == 'motivate') ? 'selected' : ''; ?>>動機付ける</option>
                <option value="persuade" <?php echo ($purpose == 'persuade') ? 'selected' : ''; ?>>説得する</option>
            </select> <br><br>

            <label for="char_limit">字数の上限</label>
            <select name="char_limit" id="char_limit">
                <?php
                $limits = [0.2, 0.5, 1, 3, 5, 7];
                foreach ($limits as $limit) {
                    $selected = ($char_limit == $limit) ? 'selected' : '';
                    echo "<option value=\"$limit\" $selected>{$limit}分</option>";
                }
                ?>
            </select> <br><br>

            <label for="message">伝えたいメッセージ</label>
            <input type="text" name="message" id="message" placeholder="メッセージを記載" style="width: 500px;"
                value="<?php echo htmlspecialchars($message); ?>"><br><br>

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

            <input type="submit" value="スピーチ原稿を生成">
        </form>
    
    <div class="button-container"> 
        <form action="insert2.php" method="POST" id="saveForm">    
        <!-- <form action="insert2.php" method="POST"> -->
        <input type="hidden" name="title" id="hiddenTitle" value="<?php echo htmlspecialchars($title); ?>">     
        <input type="hidden" name="text_ready" id="hiddenTextReady" value="<?php echo htmlspecialchars($response_text); ?>">           
        <!-- <input type="hidden" name="title" id="hiddenTitle" value="<?php echo isset($_GET['title']) ? htmlspecialchars($_GET['title']) : ''; ?>">     
        <input type="hidden" name="text_ready" id="hiddenTextReady" value="<?php echo isset($_GET['response']) ? htmlspecialchars($_GET['response']) : ''; ?>">     -->
                <input type="submit" value="原稿を保存">

                
        </form>
                <!-- <input type="hidden" name="title" id="hiddenTitle">      -->
                <!-- <input type="hidden" name="text_ready" id="hiddenTextReady">      -->
                <!-- URLのクエリパラメータからGET -->
                
        </form>    
    </div>

        <form>
            <input type="reset" value="リセット" onclick="resetSpeech()">
        </form>
    </div>    
    
    <div class= "response-container"> 
        <?php if (!empty($response_text)): ?>
        <h3>スピーチ原稿案</h3>
        <p id='response'><?php echo nl2br(htmlspecialchars($response_text)); ?></p>
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

    
    // ナビゲーションメニューのトグル
    const toggler = document.querySelector(".toggle");
    window.addEventListener("click", event => {
    if(event.target.className == "toggle" || event.target.className == "toggle") {
        document.body.classList.toggle("show-nav");
        document.getElementById("deleteconpo").classList.toggle("deleteclass")
    } else if (event.target.className == "overlay") {
        document.body.classList.remove("show-nav");
    document.getElementById("deleteconpo").classList.toggle("deleteclass")
    }

    });

   
   </script>

<script>

function resetSpeech() {
        document.querySelector('.response-container p').innerHTML = '';
    }
</script>

</body>
<style>
/* Drawer */
.overlay {
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
}

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

/* ここから上はサイドバーのCSS */
.navbar {
    background-color: grey ;
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

        .navbar-brand img {
            vertical-align: middle; /* ロゴを中央揃え */
        }

.container {
    display: flex;
}

/* フレックスアイテムが利用可能なスペースを均等に分割することを指定します。 
form-container クラスが適用された要素は、親の container 要素内で他のフレックスアイテムと同じ割合でスペースを占有 */

.form-container {
    flex: 1;
    padding-right: 10px; /* 境界線のための余白を追加  */
}

.response-container {
    flex: 1;
    padding-left: 30px;
    padding-right: 20px;
    border-left: 1px solid #ccc; /* 縦線を追加 */
}

.button-container {
    display: flex;
    gap: 10px;
}
</style>


</html>