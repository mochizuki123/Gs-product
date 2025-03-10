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
//speech_text_prompt テーブルの response_prompt 列の情報をPOSTされた$content で更新
$stmt = $pdo->prepare('UPDATE speech_text_prompt SET response_prompt=:content, updated_at=:updated_at WHERE id=:id;');
$stmt->bindValue(':updated_at', date('Y-m-d H:i'), PDO::PARAM_STR);
$stmt->bindValue(':content', $content, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute(); //実行

//４．つぶやき登録処理後
if ($status === false) {
    sql_error($stmt);
} else {
    redirect('select1.php');
}
