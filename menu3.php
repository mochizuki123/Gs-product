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

<h2>スピーチテーマの生成</h2>
<div class="container">
    <div class="form-container">
    <!-- 入力フォームの value 属性に SESSION の値を反映し、以前の値が表示される -->
        <form action="upload3.php" method="post">
            <label for="theme">テーマ</label>    
            <input type="text" name="theme" id="theme" placeholder="テーマを記載" style="width: 200px;" value="<?php echo htmlspecialchars($theme); ?>"><br>
            <label for="experience">自分が経験したこと</label>    
            <input type="text" name="experience" id="experience" placeholder="経験を記載" style="width: 200px;" value="<?php echo htmlspecialchars($experience); ?>"><br>
            <label for="interest">関心事</label>    
            <input type="text" name="interest" id="interest" placeholder="関心事を記載" style="width: 200px;" value="<?php echo htmlspecialchars($interest); ?>"><br>
            <input class="theme" type="submit" value="テーマ生成">
            <!-- <input class="reset" type="button" value="リセット" onclick="location.href='reset.php'"> -->
            
            <input  class="reset" type="button" value="リセット" onclick="resetSpeech()">
            
        </form>   
    
        <form action="insert3.php" method="POST" id="saveForm">    
                <!-- <input type="hidden" name="theme" id="hiddenTheme" value="<?php echo isset($_SESSION['theme']) ? htmlspecialchars($_SESSION['theme']) : ''; ?>">      -->
            <input type="hidden" name="text_theme" id="hiddenTextTheme" value="<?php echo isset($_SESSION['text_theme']) ? htmlspecialchars($_SESSION['text_theme']) : ''; ?>">    
            <input class="save" type="submit" value="原稿を保存">         
        </form>
    </div>
    
    <div class="button-container"> 
        <form id="resetForm" method="post" style="display:none;">
            <input type="hidden" name="reset" value="1">
        </form>

    </div>

 <div class= "response-container"> 
    <?php if (isset($_SESSION['text_theme'])): ?>
        <h2> スピーチテーマ案</h2>
        <ul>
            <p id='response'>
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

</body>
</html>


<script>
    // フォーム送信時に title の値を隠しフィールドに設定
    document.getElementById('saveForm').addEventListener('submit', function(e) {
    var themeValue = document.getElementById('theme').value;
    var textThemeValue = document.getElementById('response').innerText; // 生成されたtext_readyの値を取得
      document.getElementById('hiddenTheme').value = themeValue;
    document.getElementById('hiddenTextTheme').value = textThemeValue;
    });

    
    // function resetSpeech() {
    //     var responseList = document.querySelector('.response-container ul');
    //     if(responseList) {
    //         responseList.innerHTML = '';
    //     }
    
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
    

    
        // function resetSpeech() {
    //         document.querySelector('.response-container ul').innerHTML = '';
        
</script>

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

.form-container {
    flex: 1;
    padding-right: 10px; /* 境界線のための余白を追加  */
}

.response-container {
    flex: 1;
    padding-left: 10px;
    padding-right: 20px;
    border-left: 1px solid #ccc; /* 縦線を追加 */
}

.button-container {
    display: flex;
    gap: 10px;
}

ol {
list-style-type: decimal; /* 数字の箇条書き */
padding-left: 20px; /* 左側の余白を追加 */
}

ol li {
list-style-type: none; /* 黒い点を省略 */
}

.reset {
margin-top: 5px;
}

.theme {
margin-top: 5px;
}

.save {
margin-top: 5px;
}
    </style>

 <!-- document.getElementById('saveForm').addEventListener('submit', function(e) {
        var themeValue = document.getElementById('theme').value;
        var speechThemeValue = document.getElementById('response').innerText; // 生成された内容を取得
        document.getElementById('hiddenTheme').value = themeValue;
        document.getElementById('hiddenSpeechTheme').value = speechThemeValue;
    });

    function resetSpeech() {
        var responseList = document.querySelector('.response-container ul');
        if(responseList) {
            responseList.innerHTML = '';
        }
    } -->