<?php
// エラーを出力する
ini_set('display_errors', '1');
error_reporting(E_ALL);

session_start();
require_once 'funcs.php';
// echo "funcs.php included<br>";

loginCheck();

if (!isset($_SESSION['user_id'], $_SESSION['theme'],  $_SESSION['experience'], $_SESSION['interest'], $_SESSION['text_theme'])) {
    exit('Error: 必要なセッション変数が設定されていません。');
}

$user_id      = $_SESSION['user_id'];
$theme        = $_SESSION['theme'];         // menu3.php で入力したテーマ
$experience   = $_SESSION['experience'];      // 経験
$interest     = $_SESSION['interest'];  
$text_theme = $_SESSION['text_theme'];    // upload3.php で生成されたスピーチテーマ
$created_at   = date('Y-m-d H:i:s');       // 現在の日時を取得


// echo "text_theme: " . htmlspecialchars($text_theme) . "<br>";
// echo "created_at: " . htmlspecialchars($created_at) . "<br>";
// exit();


//2. DB接続します
try{
$pdo = db_conn();
} catch (PDOException $e) {
    exit('DB Connection Error: ' . $e->getMessage());
}

// var_dump($user_id);

//３．データベースの speech_text テーブルに新しいレコードを挿入するための準備を行っています。
$stmt = $pdo->prepare('INSERT INTO speech_theme(user_id, theme, experience, interest, text_theme, created_at) VALUES(:user_id, :theme, :experience, :interest, :text_theme, :created_at)');

$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':theme', $theme, PDO::PARAM_STR);
$stmt->bindValue(':experience', $experience, PDO::PARAM_STR);
$stmt->bindValue(':interest', $interest, PDO::PARAM_STR);
$stmt->bindValue(':text_theme', $text_theme, PDO::PARAM_STR);
$stmt->bindValue(':created_at', $created_at, PDO::PARAM_STR);

// var_dump($created_at);
// var_dump($theme);
// var_dump($experience);
// var_dump($text_theme);

$status = $stmt->execute(); //実行



// ４．登録処理後
if (!$status) {
    sql_error($stmt);
} else {
    redirect('select3.php');
}
?>
