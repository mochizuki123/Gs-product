<?php
session_start();
require_once 'funcs.php';
loginCheck();

// $_GET['id']が設定されているかどうかを確認し、設定されていない場合や空の場合にはエラーメッセージを表示してスクリプトを終了
if (!isset($_GET['id']) || empty($_GET['id'])) {
    exit('Error: ID is not set or empty');
}

$id = $_GET['id']; //?id~**を受け取る
$pdo = db_conn();


//２．つぶやき登録SQL作成
$stmt = $pdo->prepare('SELECT * FROM speech_text_prompt WHERE id=:id;');
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

//３．つぶやき表示
if (!$status) {
    sql_error($stmt);
} else {
    $row = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>即興スピーチ</title>
    <link rel="stylesheet" href="css/common.css" />
    <link rel="stylesheet" href="css/detail.css" />
</head>

<body>

    <!-- Head[Start] -->
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header"><a class="navbar-brand" href="select2.php">スピーチ原稿一覧</a></div>
                <div class="navbar-header"><a class="navbar-brand" href="logout.php">ログアウト</a></div>
                <!-- <div class="navbar-header user-name"><p><?= $_SESSION['user_name'] ?></p></div> -->
            </div>
        </nav>
    </header>
    <!-- Head[End] -->
    <form method="POST" action="update1_comment.php" enctype="multipart/form-data">
        <div class="jumbotron">
            <fieldset>
                <legend>[編集用]</legend>
               
                <div>
                    <input class="reserve" type="submit" value="更新">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <!-- <input class="comment" type="text" style="width: 60%;"> -->
                </div>
                
                <div>
                    <label for="content"></label>
                    <textarea id="content" name="content" rows="60" cols="100"><?= h($row['text_prompt']) ?></textarea>
                </div>
   
            </fieldset>
        </div>
    </form>
</body>
</html>

<style>
.reserve{
    margin-bottom:10px;
}

</style>