<?php
session_start();
require_once 'funcs.php';
loginCheck();

$id = $_GET['id']; //?id~**を受け取る
$pdo = db_conn();

//２．つぶやき登録SQL作成
$stmt = $pdo->prepare('SELECT * FROM contents WHERE id=:id;');
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
    <title>つぶやき更新</title>
    <link rel="stylesheet" href="css/common.css" />
    <link rel="stylesheet" href="css/detail.css" />
</head>

<body>

    <!-- Head[Start] -->
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header"><a class="navbar-brand" href="select.php">つぶやき一覧</a></div>
                <div class="navbar-header"><a class="navbar-brand" href="logout.php">ログアウト</a></div>
                <div class="navbar-header user-name"><p><?= $_SESSION['user_name'] ?></p></div>
            </div>
        </nav>
    </header>
    <!-- Head[End] -->
    <form method="POST" action="update.php" enctype="multipart/form-data">
        <div class="jumbotron">
            <fieldset>
                <legend>[編集]</legend>
                <div>
                    <label for="content">内容：</label>
                    <textarea id="content" name="content" rows="4" cols="40"><?= h($row['content']) ?></textarea>
                </div>
                <div>
                    <input type="submit" value="更新">
                    <input type="hidden" name="id" value="<?= $id ?>">
                </div>
            </fieldset>
        </div>
    </form>
</body>
</html>
