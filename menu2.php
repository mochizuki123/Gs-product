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
        <li><a href="select2.php">Scripts</a></li>
        <li><a href="logout.php">Log out</a></li>       
    </ul>
</div>
</nav>
      
<h2>スピーチ原稿の生成</h2>
<div class="container">
    <div class="form-container">

    <form action="upload2.php" method="post">
        <label for="title">スピーチタイトル</label>    
        <input type="text" name="title" id="title" placeholder="スピーチタイトルを記載" style="width: 300px;"><br>    
            
        <label for="purpose">スピーチの目的</label>
        <select name="purpose" id="purpose">
        <option value="inform">情報提供</option>
        <option value="entertain">楽しませる</option>
        <option value="motivate">動機付ける</option>
        </select> <br><br>

        <label for="char_limit">字数の上限</label>
        <select name="char_limit" id="char_limit">
        <option value="20">20字</option>
        <option value="50">50字</option>
        <option value="100">100字</option>
        <option value="300">300字</option>
        <option value="500">500字</option>
        <option value="1000">1000字</option>
        <option value="1500">1500字</option>
        <option value="2000">2000字</option>
        </select> <br><br>
        <!-- <input type="text" id="char_limit" name="char_limit" placeholder="文字数上限を記載"><br><br> -->

        <label for="message">伝えたいメッセージ</label>
        <input type="text" name="message" id="message" placeholder="メッセージを記載" style="width: 500px;"><br><br>
        
        <label for="outline">スピーチの骨子①</label>
        <input type="text" name="outline1" id="outline" placeholder="骨子を記載" style="width: 500px;"><br>
        <label for="outline">スピーチの骨子②</label>
        <input type="text" name="outline2" id="outline" placeholder="骨子を記載" style="width: 500px;"><br>
        <label for="outline">スピーチの骨子③</label>
        <input type="text" name="outline3" id="outline" placeholder="骨子を記載" style="width: 500px;"><br>
        <label for="outline">スピーチの骨子④</label>
        <input type="text" name="outline4" id="outline" placeholder="骨子を記載" style="width: 500px;"><br><br>
        
        <input type="submit" value="スピーチ原稿を生成">
        
    </form>

        <!-- <label for="language">言語を選択</label>
            <select id=language name="language" >
                <option value="ja">日本語</option>
                <option value="en">英語</option>
            </select> -->

    <!--  フォーム送信時にJavaScriptでtitleの値を隠しフィールドに設定しています。-->

    <div class="button-container"> 
    <form action="insert2.php" method="POST" id="saveForm">    
    <!-- <form action="insert2.php" method="POST"> -->
            <!-- <input type="hidden" name="title" value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>">      -->
            <input type="hidden" name="title" id="hiddenTitle">          
            <input type="hidden" name="text_ready" value="<?php echo isset($_GET['response']) ? htmlspecialchars($_GET['response']) : ''; ?>">     
            <input type="submit" value="原稿を保存">
        </form>
    
    </div>

    <form>
        <input type="reset" value="リセット" onclick="resetSpeech()">
    </form>


</div>
 <!-- GET パラメータの response の値を表示 htmlspecialchars($_GET['response']) は、HTML特殊文字をエスケープして、XSS（クロスサイトスクリプティング）攻撃を防ぎ-->
 <!-- response パラメータは、upload.php からリダイレクトされた際に設定 -->

    <script>
    // フォーム送信時に title の値を隠しフィールドに設定
    document.getElementById('saveForm').addEventListener('submit', function() {
        var title = document.getElementById('title').value;
        console.log('Title:', title); // 追加
        document.getElementById('hiddenTitle').value = title;
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


 <div class= "response-container"> 
    <?php if (isset($_GET['response'])): ?>
        <h2> スピーチ原稿</h2>
        <p><?php echo htmlspecialchars($_GET['response']); ?></p>
</div>

<?php endif; ?>


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