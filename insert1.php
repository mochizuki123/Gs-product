<?php
// エラーを出力する
ini_set('display_errors', '1');
error_reporting(E_ALL);

session_start();
require_once 'funcs.php';
// echo "funcs.php included<br>";

loginCheck();
// echo "loginCheck passed<br>";

// 1. menu1 から振り返りコメント取得
if (isset($_POST['text_prompt'])) {
    $text_prompt = $_POST['text_prompt'];
    echo "text_prompt: $text_prompt<br>";
} else {
    exit('Error: text_prompt is not set.');
}

if (isset($_POST['response_prompt'])) {
    $response_prompt = $_POST['response_prompt'];
    echo "response_prompt: $response_prompt<br>";
} else {
    exit('Error: respnose_prompt is not set.');
}


$user_id = $_SESSION['user_id'];  //セッションの中のuser_id抜き出し
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];  //セッションの中のuser_id抜き出し
    echo "user_id: $user_id<br>";
} else {
    exit('Error: user_id is not set in session.');
}

//1. menu2 からスピーチ原稿取得
// if (isset($_POST['text_ready'])) {
//     $text_ready = $_POST['text_ready'];
//     echo "text_ready: $text_ready<br>";
// } else {
//     exit('Error: text_ready is not set.');
// }

//2. DB接続します
try{
$pdo = db_conn();
} catch (PDOException $e) {
    exit('DB Connection Error: ' . $e->getMessage());
}

// var_dump($user_id);

//３．データベースの speech_text テーブルに新しいレコードを挿入するための準備を行っています。
//NOW() 関数は、現在の日時を created_at カラムに挿入
$stmt = $pdo->prepare('INSERT INTO speech_text_prompt(user_id, text_prompt, response_prompt, created_at) VALUES(:user_id, :text_prompt, :response_prompt, NOW());');

$stmt->bindValue(':text_prompt', $text_prompt, PDO::PARAM_STR);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);  // bindValue追加
$stmt->bindValue(':response_prompt', $response_prompt, PDO::PARAM_STR);  // bindValue追加
// $stmt->bindValue(':image', $image, PDO::PARAM_STR);  // bindValue追加
$status = $stmt->execute(); //実行

//４．つぶやき登録処理後
if (!$status) {
    sql_error($stmt);
} else {
    redirect('select1.php');
}
?>
