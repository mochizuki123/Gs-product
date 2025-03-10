<style>
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
        $view .= '<td>' . h($r['created_at']) . '</td>';
        
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
