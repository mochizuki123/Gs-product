<?php
// エラーを出力する
ini_set('display_errors', '1');
error_reporting(E_ALL);

session_start();
require_once 'funcs.php';
// echo "funcs.php included<br>";

loginCheck();

$user_id = $_SESSION['user_id'];  //セッションの中のuser_id抜き出し
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];  //セッションの中のuser_id抜き出し
    echo "user_id: $user_id<br>";
} else {
    exit('Error: user_id is not set in session.');
}   


if (isset($_POST['title'])) {
    $title = $_POST['title'];
    echo "title: $title<br>";
} else {
    exit('Error: title is not set.');
}

if (isset($_POST['text_diary'])) {
    $text_diary = $_POST['text_diary'];
    echo "text_diary: $text_diary<br>";
} else {
    exit('Error: text_diary is not set.');
}

// //1. menu0 からdiaryとphoto取得
// if (isset($_POST['date'])) {
//     $date = $_POST['date'];
//     echo "date: $date<br>";
// } else {
//     exit('Error: date is not set.');
// }

// if (isset($_POST['photo_diary'])) {
//     $photo_diary = $_POST['photo_diary'];
//     echo "photo_diary: $photo_diary<br>";
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
$stmt = $pdo->prepare('INSERT INTO diary_contents(user_id, title, text_diary, created_at) VALUES(:user_id, :title, :text_diary, NOW());');

// $stmt->bindValue(':date', $date, PDO::PARAM_STR);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);  // bindValue追加
$stmt->bindValue(':title', $title, PDO::PARAM_STR);
$stmt->bindValue(':text_diary', $text_diary, PDO::PARAM_STR);

// $stmt->bindValue(':image', $image, PDO::PARAM_STR);  // bindValue追加
$status = $stmt->execute(); //実行



//４．つぶやき登録処理後
if (!$status) {
    sql_error($stmt);
} else {
    redirect('select0.php');
}
?>
