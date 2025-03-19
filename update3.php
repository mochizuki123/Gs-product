<?php

session_start();
require_once 'funcs.php';
loginCheck();

//1. POSTつぶやき取得
$content = $_POST['content'];
$id     = $_POST['id'];

//2. DB接続します
$pdo = db_conn();

//３．つぶやき登録SQL作成
$stmt = $pdo->prepare('UPDATE speech_theme SET text_theme=:content, updated_at=:updated_at WHERE id=:id;');
$stmt->bindValue(':content', $content, PDO::PARAM_STR);
$stmt->bindValue(':updated_at', date('Y-m-d H:i'), PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute(); //実行

//４．つぶやき登録処理後
if ($status === false) {
    sql_error($stmt);
} else {
    // redirect('select.php');idパラメータを付加してリダイレクト
    redirect('select3.php?id=' . $id);
}
