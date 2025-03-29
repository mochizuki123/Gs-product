<style>


.navbar {
    background-color: rgb(21, 96, 130) ;
    color: white;
    padding: 10px 0;
    height: 50px;
    position: relative; /* ナビゲーションバーを固定 */
    /* overflow: hidden; オーバーフローを隠す */
}


.nav.navbar-nav {
    display: flex;
    /* flex-direction: row; */
    justify-content: flex-end;
    align-items: center; /* 縦方向の中央揃え */
    margin-top: 0; /* 不要な余白を削除 */
    padding-right: 20px; /* 右側に余白を追加（必要に応じて調整） */
    /* align-items: center;  */
}

.navbar-nav li {
    margin-top: 10px;
    display: inline-block;
    margin-right: 15px;
    position: relative; /* 縦線用に相対位置を設定 */
}


.navbar-nav li a {
    text-decoration: none;
    padding: 5px 15px;
    color: white;
}

.navbar-nav li a:hover {
    background-color: #ddd;
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

.navbar-header {
            display: flex;
            align-items: center; /* ロゴを中央揃え */
        }

        .navbar-brand img {
            vertical-align: middle; /* ロゴを中央揃え */
        }

.container-fluid{
    display: flex;
    justify-content: space-between;
    align-items: center;
  }


/* 以下はスピーチテーブルのCSS */
.table th, .table td{
    padding: 10px;
    text-align: left;
}

.promptSpeech table {
    width: 80%;
    border-collapse: collapse; /* セルの境界線を重ねる */
    margin-top: 20px; /* 表の上部に余白を追加 */
    /* margin-left: 40px; 表の上部に余白を追加 */
    
}

.promptSpeech {
    margin-left: 60px; /* 表の上部に余白を追加 */

}

.promptSpeech th, .promptSpeech td {
    border: 1px solid #ddd; /* セルの境界線を追加 */
    padding: 8px; /* セル内のパディングを追加 */
    text-align: left; /* テキストを左揃え */
}

.promptSpeech th {
    background-color: #f2f2f2; /* ヘッダーの背景色を設定 */
    font-weight: bold; /* ヘッダーのフォントを太字に */
}

.promptSpeech tr:nth-child(even) {
    background-color: #f9f9f9; /* 偶数行の背景色を設定 */
}

.promptSpeech tr:hover {
    background-color: #ddd; /* ホバー時の背景色を設定 */
}


</style>

<?php
// エラーを出力する
ini_set('display_errors', '1');
error_reporting(E_ALL);

session_start();
require_once 'funcs.php';
loginCheck();

//２．つぶやき登録SQL作成
$pdo = db_conn();

//speech_textテーブルとusersテーブルを結合（JOIN）これにより、speech_textテーブルのデータとusersテーブルのデータを組み合わせて取得

// 即興SP：SQL クエリを準備  speech_text_prompt テーブルの id カラムを選択し、それを id というエイリアス名で取得
$stmt = $pdo->prepare('
SELECT 
    speech_text_prompt.id as id,
    speech_text_prompt.text_prompt as text_prompt, 
    speech_text_prompt.response_prompt as response_prompt, 
    users.user_name as user_name,
    speech_text_prompt.created_at as created_at
FROM 
    speech_text_prompt
JOIN 
    users ON speech_text_prompt.user_id = users.user_id');  //利用方法？

    $status = $stmt->execute();//クエリを実行
    // $status_ready = $stmt_ready->execute();//クエリを実行

//３．登録するspeech 情報の表示
$view = '';
if (!$status) {
    sql_error($stmt);
} else {
    while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $view .= '<table class="table">';
    $view .= '<thead><tr><th>ID</th><th>コメント</th><th>即興スピーチ</th><th>ユーザー名</th><th>作成日時</th><th>操作</th></tr></thead>';
    $view .= '<tbody>';
    while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $view .= '<tr>';
        $view .= '<td>' . $r["id"] . '</td>';
        // $view .= '<td><a href="detail1_text.php?id=' . $r["id"] . '">' . h($r['text_prompt']) . '</a></td>';
        $view .= '<td><a href="detail1_text.php?id=' . $r["id"] . '">' . '振返りコメント' . '</a></td>';
        $view .= '<td><a href="detail1_response.php?id=' . $r["id"] . '">' . 'スピーチテキスト' . '</a></td>';
        $view .= '<td>' . h($r['user_name']) . '</td>';
        $view .= '<td>' . date('Y-m-d H:i', strtotime($r['created_at'])) . '</td>';
        // $view .= '<td>' . h($r['created_at']) . '</td>';
        
        $view .= '<td>';
        if ($_SESSION['kanri_flg'] === 1) {
            $view .= '<a class="btn btn-danger" href="delete1.php?id=' . $r['id'] . '">削除</a>';
        }
        $view .= '</td>';
        $view .= '</tr>';
    }
    
    }
}

?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>フリーアンケート表示</title>
    <!-- <link rel="stylesheet" href="css/login.css" /> -->
    <!-- <link rel="stylesheet" href="css/common.css" />
    <link rel="stylesheet" href="css/select.css" /> -->

</head>

<body id="main">
    <!-- Head[Start] -->
        <!-- <nav class="nav navbar-nav"> -->
            <!-- <ul class="nav navbar-nav">
            <li><a href="index.php">Menu</a></li>
            <li><a href="menu2.php">Prepared speech</a></li>
            <li><a href="logout.php">Log out</a></li>       
            </ul>         -->
        <!-- </nav> -->
    <div>
        <!-- <div class="container jumbotron"><?= $view ?></div> -->

<nav class="navbar navbar-default">
<div class="container-fluid">
    <div class="navbar-header">
                <a class="navbar-brand" >
                <img src="img/company-logo2.png" alt="Logo" style="width:200px;"></a>
    </div>
    <ul class="nav navbar-nav">
        <li><a href="index.php">Menu</a></li>
        <!-- <li><a href="menu3.php">テーマ生成</a></li> -->
        <li><a href="menu1.php">即興スピーチ練習</a></li>
        <li><a href="logout.php">Log out</a></li>       
    </ul>
</div>
</nav>


    </div>
    <!-- Main[End] -->


<div class= 'promptSpeech'>
        <h3 class=title> 即興スピーチ </h3>
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

</body>

</html>
