<?php

session_start();
require_once 'funcs.php';
loginCheck();

//1. POSTつぶやき取得
if (isset($_POST['content'])) {
    $content = $_POST['content'];
} else {
    exit('Error: content is not set.');
}
$user_id = $_SESSION['user_id'];  //セッションの中のuser_id抜き出し

// 画像アップロードの処理
$image = ''; //画像名を格納する変数　extension=拡張子　pathinfo_extension=拡張子を取得して変数extensionに格納   

if (isset($_FILES["image"])) {
    $upload_file = $_FILES["image"]["tmp_name"]; //一時保存の場所
    $extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION); //拡張子を取得
    $new_name = uniqid() . "." . $extension; //ユニークな名前を作成

    $image_path = "img/" . $new_name;
    if (move_uploaded_file($upload_file, $image_path)) {
        $image = $image_path;  // true なら画像のパスを格納
    }
}

//2. DB接続します
$pdo = db_conn();

//３．つぶやき登録SQL作成　データベースの contents テーブルに新しいレコードを挿入するための準備を行っています。
//NOW() 関数は、現在の日時を created_at カラムに挿入
$stmt = $pdo->prepare('INSERT INTO contents(user_id, content, image, created_at) VALUES(:user_id, :content, :image, NOW());');
$stmt->bindValue(':content', $content, PDO::PARAM_STR);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);  // bindValue追加
$stmt->bindValue(':image', $image, PDO::PARAM_STR);  // bindValue追加
$status = $stmt->execute(); //実行

//４．つぶやき登録処理後
if (!$status) {
    sql_error($stmt);
} else {
    redirect('select.php');
}
?>
