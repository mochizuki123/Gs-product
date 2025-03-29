<?php

session_start();
require_once 'funcs.php';
loginCheck();

//1. POSTつぶやき取得
$text_diary = $_POST['text_diary'];
$id     = $_POST['id'];

//2. DB接続します
$pdo = db_conn();

//３．つぶやき登録SQL作成
$stmt = $pdo->prepare('UPDATE diary_contents SET text_diary=:text_diary, updated_at=:updated_at WHERE id=:id;');
$stmt->bindValue(':text_diary', $text_diary, PDO::PARAM_STR);
$stmt->bindValue(':updated_at', date('Y-m-d H:i'), PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute(); //実行

//４．つぶやき登録処理後
if ($status === false) {
    sql_error($stmt);
} else {
    // redirect('select.php');idパラメータを付加してリダイレクト
    redirect('select0.php?id=' . $id);
}
