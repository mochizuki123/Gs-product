<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>スピーチ原稿作成</title>
</head>
<body>
<style>
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
    border-left: 1px solid #ccc; /* 縦線を追加 */
}
</style>

<nav class="navbar navbar-default">
<div class="container-fluid">
    <div class="navbar-header">
        <a class="navbar-brand" >
            <img src="img/logo.png" alt="Logo" style="width:40px;">
        </a>
    </div>
    <ul class="nav navbar-nav">
        <li><a href="index.php">Menu</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="logout.php">Log out</a></li>       
    </ul>
</div>
</nav>
      
<h1>スピーチ原稿の生成</h1>
<div class="container">
    <div class="form-container">

    <form action="upload2.php" method="post">
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

        <label for="language">言語を選択</label>
        <select id=language name="language" >
            <option value="ja">日本語</option>
            <option value="en">英語</option>
        </select>

        <input type="submit" value="スピーチ原稿を生成">
        <input type="reset" value="リセット" onclick="resetSpeech()">

    </form>

    <form action="insert2.php" method="POST">
        <input type="hidden" name="text_ready" value="<?php echo isset($_GET['response']) ? htmlspecialchars($_GET['response']) : ''; ?>">
        <input type="submit" value="原稿を保存">

    </form>

</div>
 <!-- GET パラメータの response の値を表示 htmlspecialchars($_GET['response']) は、HTML特殊文字をエスケープして、XSS（クロスサイトスクリプティング）攻撃を防ぎ-->
 <!-- response パラメータは、upload.php からリダイレクトされた際に設定 -->
 <div class= "response-container"> 
    <?php if (isset($_GET['response'])): ?>
        <h2> スピーチ原稿</h2>
        <p><?php echo htmlspecialchars($_GET['response']); ?></p>
</div>

<?php endif; ?>
<!-- セットボタンがクリックされたときに、スピーチ原稿の内容を表示している<p>タグの中身をクリア -->
<script>
    function resetSpeech() {
        document.querySelector('.response-container p').innerHTML = '';
    }
</script>



</body>
</html>