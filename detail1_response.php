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
    // title を SESSION に保存
    // $_SESSION['title'] = $row['title'];
    $_SESSION['text_prompt'] = $row['text_prompt'];
    $_SESSION['response_prompt'] = $row['response_prompt'];
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>即興スピーチ</title>
    <!-- <link rel="stylesheet" href="css/common.css" />
    <link rel="stylesheet" href="css/detail.css" /> -->
</head>

<body>

    <!-- Head[Start] -->
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">                
                <div class="navbar-header">
                    <a class="navbar-brand" >
                    <img src="img/company-logo2.png" alt="Logo" style="width:200px;"></a>
                </div>    
                <div> <ul class="nav navbar-nav">
                        <li><a href="index.php">Menu</a></li>
                        <li><a href="select1.php">即興スピーチ一覧</a></li>
                        <li><a href="logout.php">Log out</a></li>       
                      </ul>    
                </div>
            </div>                
        </nav>
    
    </header>
    <!-- Head[End] -->
    <form method="POST" action="update1_response.php" enctype="multipart/form-data">
        <div class="jumbotron">
            <fieldset>
                <legend>[編集用]</legend>
               
                <div>
                    <input class="reserve" type="submit" value="更新">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <!-- <input class="comment" type="text" style="width: 60%;"> -->
                </div>
                  <div>
                    <label for="title">タイトル：</label><p class='title' id="title" style="display: inline;"><?= h($_SESSION['title']) ?></p></div>
                <div>
                    <label for="content"></label>
                    <textarea class='content' name="content" rows="60" cols="100"><?= h($row['response_prompt']) ?></textarea>
                </div>
   
            </fieldset>
        </div>
    </form>
</body>
</html>

<style>
.container-fluid{
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

.navbar {
    background-color: rgb(21, 96, 130) ;
    color: white;
    padding: 10px 0;
    height: 50px;
    position: relative; /* ナビゲーションバーを固定 */
    overflow: hidden; /* オーバーフローを隠す */
}


/* 他の要素の上に配置 */
.nav.navbar-nav, .navbar-header {
    position: relative;
    z-index: 1;
}

.nav.navbar-nav {
    display: flex;
    flex-direction: row;
    justify-content: right;
    /* align-items: center;  */
}

.navbar-nav li {
    display: inline-block;
    margin-right: 15px;
    position: relative; /* 縦線用に相対位置を設定 */
}

.navbar-nav li a {
    /* display: flex; */
    text-decoration: none;
    padding: 5px 15px;
    color: white;
}

.navbar-nav li:not(:last-child)::after {
    content: "";
    position: absolute;
    right: -8px; /* 縦線の位置を調整 */
    top: 50%;
    transform: translateY(-50%);
    width: 1px;
    height: 20px; /* 縦線の高さを設定 */
    background-color: white; /* 縦線の色を設定 */
}

.navbar-nav li a:hover {
    background-color: #ddd;
}

.navbar-header {
            display: flex;
            align-items: center; /* ロゴを中央揃え */
        }

 .navbar-brand img {
            vertical-align: middle; /* ロゴを中央揃え */
        }

.reserve{
    margin-bottom:10px;
}

.title{
    font-size: 20px;
    font-weight: bold;
    /* margin-bottom: 10px; */
}

.content{
    font-family: "Noto Sans JP", sans-serif;
    font-size: 16px;
    line-height: 1.6;
    background-color:rgb(239, 244, 247);
}



</style>