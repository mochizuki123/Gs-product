<?php
session_start();
// セッションデータの取得
ini_set('display_errors', '1');
error_reporting(E_ALL);

if (isset($_POST['reset'])){
    unset($_SESSION['experience']);
    unset($_SESSION['interest']);
unset($_SESSION['theme']);
unset($_SESSION['text_theme']);
header("Location:menu3.php");
exit();
}

$experience = isset($_SESSION['experience']) ? $_SESSION['experience'] : '';
$interest = isset($_SESSION['interest']) ? $_SESSION['interest'] : '';
$theme = isset($_SESSION['theme']) ? $_SESSION['theme'] : '';
$text_theme = isset($_SESSION['text_theme']) ? $_SESSION['text_theme'] : '';


// セッションをクリア（必要なら）

?>
<!-- スピーチテーマ設定 -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

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
            <li><a href="menu2.php">Prepared speech</a></li>
            <li><a href="logout.php">Log out</a></li>       
        </ul>
    </div>
    </nav>

    <h2 class='header'>スピーチテーマの生成 </h2>
    <div class="container">
    <div class="form-container">
    <!-- 入力フォームの value 属性に SESSION の値を反映し、以前の値が表示される -->
        <form action="upload3.php" method="post">
        <div class='button-container'> 
            <input class="theme" type="submit" value="テーマ生成"> 
            <input class='save' type="submit" value="原稿を保存" form='saveForm'> <br>
            <input  class="reset" type="button" value="リセット" onclick="resetSpeech()"> <br>
        </div>
        <label for="theme">テーマ</label> <br>
            <input type="text" name="theme" id="theme" placeholder="テーマを記載" style="width: 500px;" value="<?php echo htmlspecialchars($theme); ?>"><br>
        <label for="experience">自分が経験したこと</label> <br>   
            <input type="text" name="experience" id="experience" placeholder="経験を記載" style="width: 500px;" value="<?php echo htmlspecialchars($experience); ?>"><br>
        <label for="interest">関心事</label> <br>   
            <input type="text" name="interest" id="interest" placeholder="関心事を記載" style="width: 500px;" value="<?php echo htmlspecialchars($interest); ?>"><br>            
        </form>   
    
        <form action="insert3.php" method="POST" id="saveForm">    
                <!-- <input type="hidden" name="theme" id="hiddenTheme" value="<?php echo isset($_SESSION['theme']) ? htmlspecialchars($_SESSION['theme']) : ''; ?>">      -->
            <input type="hidden" name="text_theme" id="hiddenTextTheme" value="<?php echo isset($_SESSION['text_theme']) ? htmlspecialchars($_SESSION['text_theme']) : ''; ?>">    
            <!-- <input class="save" type="submit" value="原稿を保存">          -->
        </form>
    </div>

    <div class="button-container"> 
        <form id="resetForm" method="post" style="display:none;">
            <input type="hidden" name="reset" value="1">
        </form>

    </div>

    <div class= "response-container"> 
        <!-- ここから、menu2.php のフォームに自動転送するためのフォーム -->
        <div class="transfer-container">
        <h2> スピーチテーマ案</h2>
            <form id="transferForm" action="menu2.php" method="post">
                <!-- 各項目を格納する hidden フィールド -->
                <input type="hidden" name="title" id="transferTitle">
                <input type="hidden" name="message" id="transferMessage">
                <input type="hidden" name="outline1" id="transferOutline1">
                <input type="hidden" name="outline2" id="transferOutline2">
                <input type="hidden" name="outline3" id="transferOutline3">
                <input type="hidden" name="outline4" id="transferOutline4">
                <button class='transfer' type="button" onclick="transferToMenu2()">準備スピーチへ転送</button>
            </form>
        </div>

     <?php if (isset($_SESSION['text_theme'])): ?>
        
        <ul id="themeList">
            <!-- <p id='response'> -->
            <?php
            $text_theme = preg_split('/\r\n|\r|\n/', $_SESSION['text_theme']);
            foreach ($text_theme as $line): 
            // <!-- 不要な表示を削除 -->
            $line = preg_replace('/\*\*.*?\*\*/', '', $line);
            $line = trim($line);
            if ($line !== ''): ?>   
                <li><?php echo $line; ?> </li>
        
                <?php endif; endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>

</div>
    <script>
        // コロン以降の文字列を取得する関数
        function extractAfterColon(text) {
             var idx = text.indexOf(':');
                if (idx === -1) {
                    idx = text.indexOf('：');
                }
                if (idx !== -1) {
                    return text.substring(idx + 1).trim();
                }
            return text;
        }
        // 送信時に text_theme の各行を隠しフィールドへセットし、menu2.php に POST 送信
        function transferToMenu2() {
            // ※ここでは、表示された <ul> 内の <li> 順に
            // [0]：スピーチタイトル
            // [1]：伝えたいメッセージ
            // [2]：スピーチの骨子①
            // [3]：スピーチの骨子②
            // [4]：スピーチの骨子③
            // [5]：スピーチの骨子④
            // として扱います。
            var listItems = document.querySelectorAll('#themeList li');
            if(listItems.length < 6) {
                alert("必要な情報が不足しています。生成結果を確認してください。");
                return;
            }
            document.getElementById('transferTitle').value   = extractAfterColon(listItems[0].innerText);
            document.getElementById('transferMessage').value = extractAfterColon(listItems[1].innerText);
            document.getElementById('transferOutline1').value = extractAfterColon(listItems[2].innerText);
            document.getElementById('transferOutline2').value = extractAfterColon(listItems[3].innerText);
            document.getElementById('transferOutline3').value = extractAfterColon(listItems[4].innerText);
            document.getElementById('transferOutline4').value = extractAfterColon(listItems[5].innerText);
            
            // フォームを送信（menu2.php に転送）
            document.getElementById('transferForm').submit();
            header("Location: menu2.php");
            exit();
        }

        
     </script>   
    </body>
    <footer>
            <p>© 2025 xxx Website</p> <!-- ← 任意のフッターコンテンツ -->
    </footer>


    </html>


<script>
    // フォーム送信時に title の値を隠しフィールドに設定
    document.getElementById('saveForm').addEventListener('submit', function(e) {
    var themeValue = document.getElementById('theme').value;
    var textThemeValue = document.getElementById('response').innerText; // 生成されたtext_readyの値を取得
    document.getElementById('hiddenTheme').value = themeValue;
    document.getElementById('hiddenTextTheme').value = textThemeValue;
    });

    
    function resetSpeech() {
        document.getElementById('theme').value = '';
        document.getElementById('experience').value = '';
        document.getElementById('interest').value = '';
        var responseList = document.querySelector('.response-container ul');
        if(responseList) {
            responseList.innerHTML = '';
        }
            // document.getElementById('resetForm').submit(); // リセット用のフォームを送信
    }
        
</script>

<style>
.navbar {
    background-color:rgb(21, 96, 130) ;
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

.navbar-brand img {
    vertical-align: middle; /* ロゴを中央揃え */
}

.container {
    display: flex;
    /* align-items: flex-start; 上部揃え */
    margin-left: 10px;
    margin-top: 10px;
}

.form-container {
    display: flex;
    flex: 1;
    padding-right: 10px; /* 境界線のための余白を追加  */
    
}


.response-container {
       flex: 1;
    margin-top: -80px;
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
}

/* .button-container {
    display: flex;
    gap: 10px;
    margin-bottom: 10px;
} */

ol {
list-style-type: decimal; /* 数字の箇条書き */
padding-left: 20px; /* 左側の余白を追加 */
}

ol li {
list-style-type: none; /* 黒い点を省略 */
}

/* .theme, .save, .reset, .transfer { 
    height: 30px;
    width: 100px;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
    border-radius: 5px;
    margin-top: 5px; */

 */
.transfer {
    height: 30px;
    width: 150px;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
    border-radius: 5px;
    margin-top: 5px;
    margin-left: 10px;
    
}

.theme:hover, .save:hover, .reset:hover, .transfer:hover {
background-color:rgb(209, 229, 243);
}

/* .theme:active, .save:active, .reset:active, .transfer:active {
    -webkit-transform: translateY(4px);
    transform: translateY(4px);
    border-bottom: none;
} */
 
/* .arrow{
    display: inline-flex;
    font-size: 40px;
    color: black;
    /* margin-top: 10px; */
    /* margin-left: 320px;*/ 

.header {
    align-items: flex-start; /* 上部揃え */

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

body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    margin: 0;
}

.container {
    flex: 1;
}

footer {
    position: relative; /* ← 親要素を相対位置に */
    height: 30px; /* ← フッターの高さ（調整可） */
    background-color: #f8f8f8; /* フッターの背景色（適宜変更） */
    /* text-align: center; テキストを中央揃え */
    padding: 20px 0; /* 上下のパディングを追加 */
    margin-top: auto; /* フッターをページの下部に配置 */
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

 