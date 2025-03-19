<?php
// エラーを出力する
ini_set('display_errors', '1');
error_reporting(E_ALL);

session_start();
require_once 'funcs.php';
loginCheck();

//２．登録SQL作成
$pdo = db_conn();


$stmt_ready = $pdo->prepare('
SELECT 
    speech_text_ready.id as id,
    speech_text_ready.title as title,
    speech_text_ready.text_ready as text_ready, 
    users.user_name as user_name,
    speech_text_ready.created_at as created_at
    
FROM 
    speech_text_ready
JOIN 
    users ON speech_text_ready.user_id = users.user_id
    ORDER BY speech_text_ready.created_at DESC LIMIT 5');   //新しい順に5件表示
$status_ready = $stmt_ready->execute();//クエリを実行


$view = '';
if ($status_ready) {
    while ($r = $stmt_ready->fetch(PDO::FETCH_ASSOC)) {
        $view .= '<tr>';
        $view .= '<td><a href="detail2.php?id=' . $r["id"] . '">' . h($r['title']) . '</a></td>';
        // $view .= '<td>' . htmlspecialchars($r['title']) . '</td>';
        $view .= '<td>' . htmlspecialchars($r['user_name']) . '</td>';
        $view .= '<td>' . htmlspecialchars($r['created_at']) . '</td>';
        $view .= '</tr>';
// echo($r['title']);
// exit;
    }
} else {
    $view = '<tr><td colspan="3">データの取得に失敗しました。</td></tr>';
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メインメニュー</title>
    <!-- <link rel="stylesheet" href="css/index.css"> -->
</head>

<style>
.navbar {
    background-color:rgb(21, 96, 130) ;
    color: white;
    padding: 10px 0;
    height: 50px;
}

.navbar-nav{
    margin-left: auto;
}

.navbar-nav li a {
    /* text-decoration: none; */
    padding: px 5px;
    color: white;
}

.navbar-nav li {
            display: inline-block;
            margin-right: 15px;
}


.menu-container {
    display: flex;
    justify-content: center;
    gap: 20px;
}


/* .navbar-nav li a:hover {
    background-color: #ddd;
} */


.menu-button1, .menu-button2, .menu-button3, .menu-button4 {
    /* color: rgba(35, 47, 54, 0.8); */
    color: rgb(21, 96, 130);
    font-size: 18px;
    font-weight: bold;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
    padding: 20px 40px;
    cursor: pointer;
    border: 1px solid #ddd;
    border-radius: 5px;
    width: 200px;
    height: 220px; /* 高さを調整 */
    margin: 40px;
    display: flex;
    flex-direction: column; /* 縦方向に配置 */
    align-items: center;
    justify-content: flex-start; /* 上部揃え */
    text-align: center;
    transition: transform 0.3s, box-shadow 0.3s;
    background-position: top; /* 画像を上部に配置 */
}

.menu-button2 span {
    margin-top: auto; /* 文字を下部に配置 */
    white-space: nowrap; /* テキストを折り返さない */
}

.menu-button:hover, .menu-button1:hover, .menu-button2:hover, .menu-button3:hover, .menu-button4:hover {
    background-color:rgb(221, 226, 235);
    transform: translateY(-5px);
    box-shadow: 4px 4px 10px rgba(96, 141, 213, 0.5);
}
.menu-button:active, .menu-button1:active, .menu-button2:active, .menu-button3:active, .menu-button3:active, .menu-button4:active {
    -webkit-transform: translateY(4px);
    transform: translateY(4px);
    border-bottom: none;
}

/* html に直接記入したimg サイズを調整 */
.btn-img {
  width: 150px;       /* お好みで調整 */
  height: auto;
  margin-bottom: 10px;  /* 画像とテキストの間の余白 */
}

/* 以下はスピーチテーブルのCSS */
.recent-preparedSpeech table {
    width: 60%;
    border-collapse: collapse; /* セルの境界線を重ねる */
    margin-top: 20px; /* 表の上部に余白を追加 */
    /* margin-left: 40px; 表の上部に余白を追加 */
    
}

.recent-preparedSpeech {
    margin-left: 60px; /* 表の上部に余白を追加 */

}

.recent-preparedSpeech th, .recent-preparedSpeech td {
    border: 1px solid #ddd; /* セルの境界線を追加 */
    padding: 8px; /* セル内のパディングを追加 */
    text-align: left; /* テキストを左揃え */
}

.recent-preparedSpeech th {
    background-color: #f2f2f2; /* ヘッダーの背景色を設定 */
    font-weight: bold; /* ヘッダーのフォントを太字に */
}

.recent-preparedSpeech tr:nth-child(even) {
    background-color: #f9f9f9; /* 偶数行の背景色を設定 */
}

.recent-preparedSpeech tr:hover {
    background-color: #ddd; /* ホバー時の背景色を設定 */
}

</style>

<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <!-- <a class="navbar-brand" > -->
                <img src="img/logo2.png" alt="Logo" style="width:40px;">
                <!-- </a> -->
            </div>
            <ul class="navbar-nav">
                <li><a href="about.php">About</a></li>
                <li><a href="logout.php">Log out</a></li>
                
            </ul>
        </div>
    </nav>
      

<div class="menu-container">
        
<!-- 絵とテキストが重ならないように切り離す -->
<button class="menu-button1" onclick="location.href='menu0.php'">
  <img src="img/index_theme-creating.png" alt="ダイアリ―" class="btn-img">
  <span>ダイアリ―</span>
</button>

<button class="menu-button2" onclick="location.href='menu3.php'">
<img src="img/index_theme-creating.png" alt="スピーチテーマ" class="btn-img">
  <span>スピーチテーマ</span>
</button>

<button class="menu-button3" onclick="location.href='menu2.php'">
  <img src="img/index_prepared1.png" alt="準備スピーチ" class="btn-img">
  <span>準備スピーチ</span>
</button>

<button class="menu-button4" onclick="location.href='menu1.php'">
  <img src="img/index_prompt.png" alt="即興スピーチ" class="btn-img">
  <span>即興スピーチ</span>
</button>

        
        <!-- <button class="menu-button" onclick="location.href='menu3.php'">メニュー3</button> -->
    </div>

    <div class= 'recent-preparedSpeech'>
        <h3 class=title> 最近の準備スピーチ </h3>
            <table>
                <thead>
                    <tr>
                        <th>タイトル</th>
                        <th>ユーザー名</th>
                        <th>作成日時</th>
                    </tr>
                </thead>
                <tbody>
                    <?= $view ?>
                </tbody>
            </table>
    </div>

</body>
</html>