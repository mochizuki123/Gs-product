<style>
.navbar {
    background-color: grey ;
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
    /* flex-direction: row; */
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
body {
    padding-top: 60px; /* ナビゲーションバーの高さ分の余白を追加 */
}

.table th, .table td{
    padding: 10px;
    text-align: left;
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
    speech_text_ready.title as title,
    speech_text_ready.id as id,
    speech_text_ready.text_ready as text_ready, 
    users.user_name as user_name,
    speech_text_ready.created_at as created_at,
    speech_text_ready.updated_at as updated_at
FROM 
    speech_text_ready
JOIN 
    users ON speech_text_ready.user_id = users.user_id');  //利用方法？
$status_ready = $stmt_ready->execute();//クエリを実行


//３．登録するspeech 情報の表示
$view = '';

if (!$status_ready) {
    sql_error($stmt_ready);
} else {
    while ($r = $stmt_ready->fetch(PDO::FETCH_ASSOC)) {
        
    $view .= '<table class="table">';
    $view .= '<thead><tr><th>ID</th><th>タイトル</th><th>ユーザー名</th><th>作成日時</th><th>更新日時</th><th>操作</th></tr></thead>';
    $view .= '<tbody>';
    while ($r = $stmt_ready->fetch(PDO::FETCH_ASSOC)) {
        $view .= '<tr>';
        $view .= '<td>' . $r["id"] . '</td>';
        $view .= '<td><a href="detail.php?id=' . $r["id"] . '">' . h($r['title']) . '</a></td>';
        $view .= '<td>' . h($r['user_name']) . '</td>';
        $view .= '<td>' . h($r['created_at']) . '</td>';
        $view .= '<td>' . h($r['updated_at']) . '</td>';
        $view .= '<td>';
        if ($_SESSION['kanri_flg'] === 1) {
            $view .= '<a class="btn btn-danger" href="delete2.php?id=' . $r['id'] . '">削除</a>';
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
                <img src="img/logo.png" alt="Logo" style="width:40px;">
            </a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="index.php">Menu</a></li>
            <li><a href="menu2.php">Prepared speech</a></li>
            <li><a href="logout.php">Log out</a></li>       
        </ul>
    </div>


<!-- 
    <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header"><a class="navbar-brand" href="menu1.php">即興スピーチ</a></div>
                <div class="navbar-header"><a class="navbar-brand" href="menu2.php">準備スピーチ</a></div>
                <div class="navbar-header"><a class="navbar-brand" href="logout.php">ログアウト</a></div>
                
            </div>
        </nav> -->
    </header>
    <!-- Head[End] -->

    <!-- Main[Start] -->
    <div>
        <div class="container jumbotron"><?= $view ?></div>
    </div>
    <!-- Main[End] -->

</body>

</html>
