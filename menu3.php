<?php
session_start();
$experience = isset($_SESSION['experience']) ? $_SESSION['experience'] : '';
$interest = isset($_SESSION['interest']) ? $_SESSION['interest'] : '';
$speech_theme = isset($_SESSION['speech_theme']) ? $_SESSION['speech_theme'] : '';



?>

<!-- スピーチテーマ設定 -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    padding-left: 30px;
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
            <li><a href="menu2.php">Prepared speech</a></li>
            <li><a href="logout.php">Log out</a></li>       
        </ul>
    </div>
    </nav>

    <h2>スピーチテーマの生成</h2>
    <div class="container">
        <div class="form-container">
        <form action="upload3.php" method="post">
            <label for="experience">自分が経験したこと</label>    
            <input type="text" name="experience" id="experience" placeholder="経験を記載" style="width: 200px;" value="<?php echo htmlspecialchars($experience); ?>"><br>
            <label for="interest">関心事</label>    
            <input type="text" name="interest" id="interest" placeholder="関心事を記載" style="width: 200px;" value="<?php echo htmlspecialchars($interest); ?>"><br>
            <input class="theme" type="submit" value="テーマ生成">
                    <input  class="reset" type="reset" value="リセット" onclick="resetSpeech()">
            
        </form>

    </div>

    <form action="insert3.php" method="post">
                <input type="submit" value="保存">  
    </form>


    <div class= "response-container"> 
        <?php if (isset($_SESSION['speech_theme'])): ?>
            <h2> スピーチテーマ案</h2>
            <ul>
                <?php
                $themes_array = preg_split('/\r\n|\r|\n/', $_SESSION['speech_theme'], -1, PREG_SPLIT_NO_EMPTY);
                // $speech_theme = preg_split('/\r\n|\r|\n/', htmlspecialchars($_SESSION['speech_theme']));
                // $themes_array = preg_split('/\d+\.\s*/', $_SESSION['speech_theme'], -1, PREG_SPLIT_NO_EMPTY);
                foreach ($themes_array as $theme): 
                $theme = trim($theme);
                if($theme !== ''): ?>
                 <li><?php echo $theme; ?> </li>
                <?php endif; endforeach; ?>
            </ul>
            
        <?php endif; ?>
    </div>
       
        <!-- データベース保存用のフォーム -->
        <div class="save-container">
            <?php if (isset($_SESSION['db_message'])): ?>
                <p><?php echo htmlspecialchars($_SESSION['db_message']); ?></p>
                <?php unset($_SESSION['db_message']); ?>
            <?php endif; ?>
       
            
            <!-- セッションをクリア（必要なら）     -->
            <!-- <?php
            unset($_SESSION['speech_theme']);
            ?>                 -->
    
        </div>

    <script>
        function resetSpeech() {
                document.querySelector('.response-container ul').innerHTML = '';
            }
    </script>
</body>
</html>
