<?php
require_once("funcs.php"); // funcs.phpを読み込んで関数を使えるようにする
$pdo = db_conn();

function h($stg){
  return htmlspecialchars($stg, ENT_QUOTES);
}


//２．データ取得SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table;");
$status = $stmt->execute(); //True or false 

//３．データ表示
$view="";
if ($status===false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php 抽出方法は様々　適宜調べる
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ //While 文で配列で格納されているIDを一行づつ取る
    $view .="<p>"; //1行づつhtml Pタグに入れる
    $view .= $result["date"] . "/タイトル：". h($result["bookname"]) . "/リンク：". h($result["url"]) . "/書評：". h($result ["comment"]) . "/お気に入り：" .h($result ["favorite"]); 
    // ドットは追記。ID1のデータがID2で消えないようにViewに追記
    // h は上段で定義した関数の適用　date はユーザから与えられるデータではないので、h関数を適用しない

// echo '<pre>';
// print_r($result);
// echo '</pre>';

    $view .="</p>";
  }

}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>フリーアンケート表示</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">データ登録</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <div class="container jumbotron"><?= $view ?></div>
</div>
<!-- Main[End] -->

</body>
</html>
