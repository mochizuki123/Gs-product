<style>

.navbar {
    background-color:rgb(21, 96, 130) ;
    color: white;
    padding: 10px 0;
    height: 50px;
    position: fixed; /* ナビゲーションバーを固定 */
    width: 100%; /* 幅を100%に設定 */
    top: 0; /* 上部に固定 */
    z-index: 1000; /* 他の要素より前面に表示 */    
}

.nav.navbar-nav {
    display: flex;
    justify-content: right;
    magin-top: 10px;
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
body {
    padding-top: 60px; /* ナビゲーションバーの高さ分の余白を追加 */
}

.table th, .table td{
    padding: 10px;
    text-align: left;

/* 反映されないので要修正 */
.title {
    margin-left: 60px;
    margin-top: 80px;
}
}
/* 以下はスピーチテーブルのCSS */
.preparedSpeech{
    margin-left: 60px;
    margin-top: 20px;
}
.preparedSpeech table {
    width: 80%;
    border-collapse: collapse; /* セルの境界線を重ねる */
    margin-top: 20px; /* 表の上部に余白を追加 */
    /* margin-left: 40px; 表の上部に余白を追加 */
    
}

.preparedSpeech {
    margin-left: 60px; /* 表の上部に余白を追加 */

}

.preparedSpeech th, .preparedSpeech td {
    border: 1px solid #ddd; /* セルの境界線を追加 */
    padding: 8px; /* セル内のパディングを追加 */
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


</style>

<?php
// エラーを出力する
ini_set('display_errors', '1');
error_reporting(E_ALL);

session_start();
require_once 'funcs.php';
loginCheck();

//２．登録SQL作成
$pdo = db_conn();

//speech_textテーブルとusersテーブルを結合（JOIN）これにより、speech_textテーブルのデータとusersテーブルのデータを組み合わせて取得

// 即興SP：SQL クエリを準備  speech_text_prompt テーブルの id カラムを選択し、それを id というエイリアス名で取得

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
    users ON diary_contents.user_id = users.user_id');  //利用方法？
$status_ready = $stmt_ready->execute();//クエリを実行


//３．登録するspeech 情報の表示
$view = '';

if (!$status_ready) {
    sql_error($stmt_ready);
} else {
    while ($r = $stmt_ready->fetch(PDO::FETCH_ASSOC)) {
        
    $view .= '<table class="table">';
    $view .= '<thead><tr><th>ID</th><th>日付</th><th>タイトル</th><th>ユーザー名</th><th>日記</th><th>更新日時</th><th>操作</th></tr></thead>';
    $view .= '<tbody>';
    while ($r = $stmt_ready->fetch(PDO::FETCH_ASSOC)) {
        $view .= '<tr>';
        $view .= '<td>' . $r["id"] . '</td>';
        $view .= '<td>' . date('Y-m-d H:i', strtotime($r['created_at'])) . '</td>';
        $view .= '<td>' . h($r['title']) . '</td>';
        $view .= '<td>' . h($r['user_name']) . '</td>';
        $view .= '<td><a href="detail0.php?id=' . $r["id"] . '">' .'日記' . '</a></td>';
        // $view .= '<td><a href="detail3.php?id=' . h($r["id"]) . '">' . '生成テーマ' . '</a></td>';
        $view .= '<td>' . date('Y-m-d H:i', strtotime($r['updated_at'])) . '</td>';
        
        $view .= '<td>';
        if ($_SESSION['kanri_flg'] === 1) {
            $view .= '<a class="btn btn-danger" href="delete0.php?id=' . $r['id'] . '">削除</a>';
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
    <header>
    <nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" >
                <!-- <img src="img/logo.png" alt="Logo" style="width:40px;"> -->
            </a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="index.php">Menu</a></li>
            <li><a href="menu0.php">Diary</a></li>
            <li><a href="logout.php">Log out</a></li>       
        </ul>
    </div>

    </header>
    
    <!-- <div>
        <div class="container jumbotron"><?= $view ?></div>
    </div>
     -->
    
    <style>
    </style>
    
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




</body>

</html>
