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
 <form action="upload2.php" method="post">
    <label for="purpose">スピーチの目的</label>
    <select name="purpose" id="purpose">
    <option value="inform">情報提供</option>
    <option value="entertain">楽しませる</option>
    <option value="motivate">動機付ける</option>
    </select> <br><br>

    <label for="char_limit">字数の上限</label>
    <input type="text" id="char_limit" name="char_limit" placeholder="文字数上限を記載"><br><br>

    <label for="message">伝えたいメッセージ</label>
    <input type="text" name="message" id="message" placeholder="メッセージを記載" style="width: 500px;"><br><br>
    
    <label for="outline">スピーチの骨子</label>
    <input type="text" name="outline" id="outline" placeholder="骨子を記載" style="width: 500px;"><br><br>
    
    <input type="submit" value="スピーチ原稿を生成">
    <input type="reset" value="リセット" onclick="resetSpeech()">

 </form>
 <!-- GET パラメータの response の値を表示 htmlspecialchars($_GET['response']) は、HTML特殊文字をエスケープして、XSS（クロスサイトスクリプティング）攻撃を防ぎ-->
 <!-- response パラメータは、upload.php からリダイレクトされた際に設定 -->
 <?php if (isset($_GET['response'])): ?>
    <h2> スピーチ原稿（案）</h2>
    <p><?php echo htmlspecialchars($_GET['response']); ?></p>

<?php endif; ?>
<!-- セットボタンがクリックされたときに、スピーチ原稿の内容を表示している<p>タグの中身をクリア -->
<script>
    function resetSpeech() {
        document.querySelector('p').innerHTML = '';
    }
</script>



</body>
</html>