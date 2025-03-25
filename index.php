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


$view1 = '';
if ($status_ready) {
    while ($r = $stmt_ready->fetch(PDO::FETCH_ASSOC)) {
        $view1 .= '<tr>';
        $view1 .= '<td><a href="detail2.php?id=' . $r["id"] . '">' . h($r['title']) . '</a></td>';
        // $view1 .= '<td>' . htmlspecialchars($r['title']) . '</td>';
        $view1 .= '<td>' . htmlspecialchars($r['user_name']) . '</td>';
        $view1 .= '<td>' . date('Y-m-d H:i', strtotime($r['created_at'])) . '</td>';
        $view1 .= '</tr>';
// echo($r['title']);
// exit;
    }
} else {
    $view1 = '<tr><td colspan="3">データの取得に失敗しました。</td></tr>';
}

// 即興SP：SQL クエリを準備  speech_text_prompt テーブルの id カラムを選択し、それを id というエイリアス名で取得
$stmt_ready = $pdo->prepare('
SELECT 
    speech_text_prompt.id as id,
    speech_text_prompt.text_prompt as text_prompt, 
    speech_text_prompt.response_prompt as response_prompt, 
    users.user_name as user_name,
    speech_text_prompt.created_at as created_at
FROM 
    speech_text_prompt
JOIN 
    users ON speech_text_prompt.user_id = users.user_id
    ORDER BY speech_text_prompt.created_at DESC LIMIT 5');   //新しい順に5件表示

    // $status = $stmt->execute();//クエリを実行
    $status_ready = $stmt_ready->execute();//クエリを実行


$view2 = '';
if ($status_ready) {

    $view2 .= '<table class="table">';
    $view2 .= '<thead><tr><th>コメント</th><th>即興スピーチ</th><th>ユーザー名</th><th>作成日時</th></tr></thead>';
    $view2 .= '<tbody>';
    while ($r = $stmt_ready->fetch(PDO::FETCH_ASSOC)) {
        $view2 .= '<tr>';
        // $view2 .= '<td>' . $r["id"] . '</td>';
        // $view2 .= '<td><a href="detail1_text.php?id=' . $r["id"] . '">' . h($r['text_prompt']) . '</a></td>';
        $view2 .= '<td><a href="detail1_text.php?id=' . $r["id"] . '">' . '振返りコメント' . '</a></td>';
        $view2 .= '<td><a href="detail1_response.php?id=' . $r["id"] . '">' . 'スピーチテキスト' . '</a></td>';
        $view2 .= '<td>' . h($r['user_name']) . '</td>';      
        $view2 .= '<td>' . date('Y-m-d H:i', strtotime($r['created_at'])) . '</td>';
        
        $view2 .= '</td>';
        $view2 .= '</tr>';
    }
    $view2 .= '</tbody></table>';
} else {
    $view2 = '<tr><td colspan="6">データの取得に失敗しました。</td></tr>';
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
    position: fixed; /* ナビゲーションバーを固定 */
    width: 100%; /* 幅を100%に設定 */
    top: 0; /* 上部に固定 */
    z-index: 1000; /* 他の要素より前面に表示 */    

}

.navbar-nav{
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

.menu-container {
    display: flex;
    justify-content: center;
    gap: 20px;
}


/* .navbar-nav li a:hover {
    background-color: #ddd;
} */


.menu-button1, .menu-button2, .menu-button3, .menu-button4 {
    margin-top:90px;
    margin-left:50px;
    margin-bottom: 50px;
    color: rgb(21, 96, 130);
    font-size: 18px;
    font-weight: bold;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
    padding: 20px 40px;
    cursor: pointer;
    border: 1px solid #ddd;
    border-radius: 5px;
    width: 200px;
    height: 240px; /* 高さを調整 */
    /* margin: 100px; */
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

.menu-button1:hover, .menu-button2:hover, .menu-button3:hover, .menu-button4:hover {
    background-color:rgb(221, 226, 235);
    transform: translateY(-5px);
    box-shadow: 4px 4px 10px rgba(96, 141, 213, 0.5);
}
.menu-button1:active, .menu-button2:active, .menu-button3:active, .menu-button4:active {
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

.container-fluid{
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

.recent-speeches {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
    margin-left: 30px;
    margin-right: 30px;
}

.recent-preparedSpeech, .recent-promptSpeech {
    width: 45%; /* 横並びにするために幅を調整 */
}

.recent-preparedSpeech table, .recent-promptSpeech table {
    width: 100%;
    border-collapse: collapse; /* セルの境界線を重ねる */
}

.recent-preparedSpeech th, .recent-preparedSpeech td, .recent-promptSpeech th, .recent-promptSpeech td {
    border: 1px solid #ddd; /* セルの境界線を追加 */
    padding: 4px; /* セル内のパディングを追加 */
    text-align: left; /* テキストを左揃え */
}

.recent-preparedSpeech th, .recent-promptSpeech th {
    background-color: #f2f2f2; /* ヘッダーの背景色を設定 */
    font-weight: bold; /* ヘッダーのフォントを太字に */
}

.recent-preparedSpeech tr:nth-child(even), .recent-promptSpeech tr:nth-child(even) {
    background-color: #f9f9f9; /* 偶数行の背景色を設定 */
}

.recent-preparedSpeech tr:hover, .recent-promptSpeech tr:hover {
    background-color: #ddd; /* ホバー時の背景色を設定 */
}


footer {
    position: fixed; /* ← 画面の下部に固定 */
    bottom: 0; /* ← 下端に配置 */
    width: 100%; /* ← 幅を100%に設定 */
    height: 60px; /* ← フッターの高さ（調整可） */
    background-color: #f8f8f8; /* フッターの背景色（適宜変更） */
    margin-top: auto; /* ← フッターを下部に固定 */
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

<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" > 
                <img src="img/company-logo2.png" alt="Logo" style="width:200px;">
                 </a>
            </div>
            <ul class="navbar-nav">
                <li><a href="about.php">Tutorial</a></li>
                <li><a href="logout.php">Log out</a></li>
                
            </ul>
        </div>
    </nav>
    
    
<div class="menu-container">
        
    <!-- 絵とテキストが重ならないように切り離す -->
    <button class="menu-button1" onclick="location.href='menu0.php'">
    <img src="img/index_diary.png" alt="ダイアリ―" class="btn-img">
    <span>スピーチの種</span>
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
    <span>即興スピーチ（上級編）</span>
    </button>
</div>

<div class='recent-speeches'>
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
                    <?= $view1 ?>
                </tbody>
            </table>
    </div>
    
    <div class= 'recent-promptSpeech'>
        <h3 class=title> 最近の即興スピーチ </h3>
            <table>
                <thead>
                    <tr>
                        <!-- <th>タイトル</th>
                        <th>ユーザー名</th>
                        <th>作成日時</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?= $view2 ?>
                </tbody>
            </table>
    </div>
</div>

</body>

<footer>
        <p>© AI SPEECH. All rights reserved</p> <!-- ← 任意のフッターコンテンツ -->
</footer>


</html>