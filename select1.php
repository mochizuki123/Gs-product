<?php
// エラーを出力する
ini_set('display_errors', '1');
error_reporting(E_ALL);

session_start();
require_once 'funcs.php';
loginCheck();

//２．つぶやき登録SQL作成
$pdo = db_conn();
//contents table + user table 結合
// php myadmin で実行するSQL文

//speech_textテーブルとusersテーブルを結合（JOIN）これにより、speech_textテーブルのデータとusersテーブルのデータを組み合わせて取得

// 即興SP：SQL クエリを準備  speech_text_prompt テーブルの id カラムを選択し、それを id というエイリアス名で取得
$stmt = $pdo->prepare('
SELECT 
    speech_text_prompt.id as id,
    speech_text_prompt.text_prompt as text_prompt, 
    users.user_name as user_name,
    speech_text_prompt.created_at as created_at
FROM 
    speech_text_prompt
JOIN 
    users ON speech_text_prompt.user_id = users.user_id');  //利用方法？
// $status = $stmt->execute();//クエリを実行

// $stmt_ready = $pdo->prepare('
// SELECT 
//     speech_text_ready.id as id,
//     speech_text_ready.text_ready as text_ready, 
//     users.user_name as user_name,
//     speech_text_ready.created_at as created_at
// FROM 
//     speech_text_ready
// JOIN 
//     users ON speech_text_ready.user_id = users.user_id');  //利用方法？
$status_ready = $stmt_ready->execute();//クエリを実行


//３．登録するspeech 情報の表示
$view = '';
if (!$status) {
    sql_error($stmt);
} else {
    while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $view .= '<div class="record"><p>';
        $view .= '<a href="detail.php?id=' . $r["id"] . '">';
        $view .= $r["id"] . "." . "　" . h($r['text_prompt']) . " @ " . $r['user_name']; 
        
        $view .= '</a>';
        $view .= "　";
        $view .= '<span class="created_at">' . h($r['created_at']) . '</span>';
        

        if ($_SESSION['kanri_flg'] === 1) {
            $view .= '<a class="btn btn-danger" href="delete.php?id=' . $r['id'] . '">';
            $view .= '削除';
            $view .= '</a>';
        }
        // $view .= '<img src="' . h($r['image']) . '" class="image-class">';
        // $view .= '</p></div>';
    }
}

// if (!$status_ready) {
//     sql_error($stmt_ready);
// } else {
//     while ($r = $stmt_ready->fetch(PDO::FETCH_ASSOC)) {
//         $view .= '<div class="record"><p>';
//         $view .= '<a href="detail.php?id=' . $r["id"] . '">';
//         $view .= $r["id"] . "." . "　" . h($r['text_ready']) . " @ " . $r['user_name']; 
        
//         $view .= '</a>';
//         $view .= "　";
//         $view .= '<span class="created_at">' . h($r['created_at']) . '</span>';
        
//         if ($_SESSION['kanri_flg'] === 1) {
//             $view .= '<a class="btn btn-danger" href="delete.php?id=' . $r['id'] . '">';
//             $view .= '削除';
//             $view .= '</a>';
//         }
//         $view .= '</p></div>';
//     }
// }


?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>フリーアンケート表示</title>
    <!-- <link rel="stylesheet" href="css/login.css" /> -->
    <link rel="stylesheet" href="css/common.css" />
    <link rel="stylesheet" href="css/select.css" />

</head>

<body id="main">
    <!-- Head[Start] -->
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header"><a class="navbar-brand" href="menu1.php">即興スピーチ</a></div>
                <div class="navbar-header"><a class="navbar-brand" href="menu2.php">準備スピーチ</a></div>
                <div class="navbar-header"><a class="navbar-brand" href="logout.php">ログアウト</a></div>
                
            </div>
        </nav>
    </header>
    <!-- Head[End] -->

    <!-- Main[Start] -->
    <div>
        <div class="container jumbotron"><?= $view ?></div>
    </div>
    <!-- Main[End] -->

</body>

</html>
