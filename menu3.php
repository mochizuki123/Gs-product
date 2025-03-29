<?php
// セッションデータの取得
ini_set('display_errors', '1');
error_reporting(E_ALL);
session_start();
require_once 'funcs.php';
loginCheck();


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

//２．Diary データ取得
$pdo = db_conn();

// select0.php からのコピー
$stmt_ready = $pdo->prepare('
SELECT 
    
    diary_contents.id as id,
    diary_contents.title as title,
    diary_contents.text_diary as text_diary, 
    users.user_name as user_name,
    diary_contents.created_at as created_at,
    diary_contents.updated_at as updated_at
FROM 
    diary_contents
JOIN 
    users ON diary_contents.user_id = users.user_id
    ORDER BY diary_contents.created_at DESC LIMIT 5');   //新しい順に5件表示

$status_ready = $stmt_ready->execute();//クエリを実行



//３．登録するspeech 情報の表示
$view = '';

if (!$status_ready) {
    sql_error($stmt_ready);
} else {
    while ($r = $stmt_ready->fetch(PDO::FETCH_ASSOC)) {
        
    $view .= '<table class="table">';
    $view .= '<thead><tr><th>日付</th><th>タイトル</th></tr></thead>';
    $view .= '<tbody>';
    while ($r = $stmt_ready->fetch(PDO::FETCH_ASSOC)) {
        $view .= '<tr>';
        $view .= '<td>' . date('Y-m-d H:i', strtotime($r['created_at'])) . '</td>';
        $view .= '<td><a href="detail0.php?id=' . $r["id"] . '">'. h($r['title']) . '</td>';
        // $view .= '<td>' . h($r['user_name']) . '</td>';
        // $view .= '<td><a href="detail0.php?id=' . $r["id"] . '">' .'日記' . '</a></td>';
        // $view .= '<td><a href="detail3.php?id=' . h($r["id"]) . '">' . '生成テーマ' . '</a></td>';
        // $view .= '<td>' . date('Y-m-d H:i', strtotime($r['updated_at'])) . '</td>';
        
              }
        $view .= '</td>';
        $view .= '</tr>';
    }
    
    }

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
    <!-- スピナー用　ローディングオーバーレイ -->
    <div id="loadingOverlay" style="display: none;">
    <div class="spinner"></div>
    <div class="loading-text">テーマ生成中…</div>
    </div>

    <nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" >
                <img src="img/company-logo2.png" alt="Logo" style="width:200px;">
            </a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="index.php">Menu</a></li>
            <li><a href="tutorial-3.php">Tutrial</a></li>
            <li><a href="menu2.php">準備スピーチ</a></li>
            <li><a href="logout.php">Log out</a></li>       
        </ul>
    </div>
    </nav>

<h2 class='header'>スピーチテーマの生成 </h2>
<div class="container">
    <div class='left-col'>
        <div class="form-container">
    <!-- 入力フォームの value 属性に SESSION の値を反映し、以前の値が表示される -->
            <form action="upload3.php" method="post">
                <div class='button-container'> 
                    <input class="theme" type="submit" value="テーマ生成"> 
                    <!-- <input class='save' type="submit" value="原稿を保存" form='saveForm'> <br> -->
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

    <div class= 'preparedSpeech'>
            <h3 class=title> 日記帳📚 </h3>
                <table>
                    <thead>
                        <tr>
                            <!-- <th>タイトル</th>
                            <th>ユーザー名</th>
                            <th>作成日時</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?= $view ?>
                    </tbody>
                </table>
        </div>
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
            <p>© 2025 AI SPEECH. All rights reserved</p> <!-- ← 任意のフッターコンテンツ -->
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

// スピナー用。　upload2.phpへ送信するフォームを取得
    const speechForm = document.querySelector("form[action='upload3.php']");
    if (speechForm) {
        speechForm.addEventListener("submit", function() {

        // 送信時にローディングオーバーレイを表示
      document.getElementById("loadingOverlay").style.display = "flex";
    });
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

/* .container {
    display: flex;
    margin-left: 10px;
    margin-top: 10px;
} */

.container {
    display: flex;
    /* justify-content: space-between; */
    /* align-items: flex-end; 子要素を下側に揃える */
    margin: 10px;
    flex:1;
}

.transfer-container{
    margin-left:10px;
    font-size: 15px;
}


/* 左カラム: フォーム + テーブル を縦に並べる */
.left-col {
  margin-left:10px;
  display: flex;
  flex-direction: column;    /* フォームの下にテーブル */
  width: 50%;                /* 全体の半分 */
  /* あるいは flex: 1; などでもOK */
}

.form-container {
    display: flex;
    flex: 1;
    padding-right: 10px; /* 境界線のための余白を追加  */

}



/* .response-container {
    
    width: 45%;
    padding-left: 30px;
    border-left: 1px solid #ccc; 
} */

.response-container {
    width: 50%;
    /* flex: 1; */

    margin-top: -74px;
    /* align-items: flex-start; 上部揃え */ */
    padding-left: 30px;
    /* padding-right: 20px; */
    border-left: 1px solid #ccc; /* 縦線を追加 */
}



.button-container {
    display: flex;
    gap: 10px;
    align-items: center;
    margin-right: 10px;
    height: 30px;
    /* width: 100px; */
    padding: 8px 12px;
    cursor: pointer;
}
.transfer {
    
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    margin-top: 18px;
    margin-right: 10px;
    margin-left: 10px;
    height: 30px;
    padding: 8px 12px;
    cursor: pointer;
}


ol {
list-style-type: decimal; /* 数字の箇条書き */
padding-left: 20px; /* 左側の余白を追加 */
}

ol li {
list-style-type: none; /* 黒い点を省略 */
}

.theme:hover, .save:hover, .reset:hover, .transfer:hover {
background-color:rgb(209, 229, 243);
}

/* .theme:active, .save:active, .reset:active, .transfer:active {
    -webkit-transform: translateY(4px);
    transform: translateY(4px);
    border-bottom: none;
} */
 
.header {
    align-items: flex-start; /* 上部揃え */
    margin-top: -10px;  
    font-size:15px;
    position: relative;  /* 縦線用 */
    font-size: 20px;
    padding: 20px 20px 5px; /* 上左右下の余白 */
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

.container-fluid{
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

/* 以下はスピーチテーブルのCSS */
.preparedSpeech {
    width: 100%;
    align-self: flex-end; コンテナ内で下側に配置
}

.preparedSpeech table {
    width: 80%;
    /* border-collapse: collapse; セルの境界線を重ねる */
    margin-top: 5px; /* 表の上部に余白を追加 */
    /* margin-left: 40px; 表の上部に余白を追加 */
    
}


.preparedSpeech th, .preparedSpeech td {
    border: 1px solid #ddd; /* セルの境界線を追加 */
    padding: 4px; /* セル内のパディングを追加 */
    text-align: left; /* テキストを左揃え */
}

.preparedSpeech th {
    background-color: #f2f2f2; /* ヘッダーの背景色を設定 */
    font-weight: bold; /* ヘッダーのフォントを太字に */
}

.preparedSpeech tr:nth-child(even) {
    background-color: #f9f9f9; /* 偶数行の背景色を設定 */
}

.preparedSpeech tr:hover {
    background-color: #ddd; /* ホバー時の背景色を設定 */
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

 