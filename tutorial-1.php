<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" >
            <img src="img/company-logo2.png" alt="Logo" style="width:200px;">    
                       </a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="index.php">Menu</a></li>
            <!-- <li><a href="menu0.php">スピーチの種</a></li> -->
            <li><a href="logout.php">Log out</a></li>       
        </ul>
    </div>

<style>

.navbar {
    background-color:rgb(21, 96, 130) ;
    color: white;
    padding: 10px 0;
    height: 50px;
    position: fixed; /* ナビゲーションバーを固定 */
    width: 100%; /* 幅を100%に設定 */
    top: 0; /* 上部に固定 */
    z-index: 1000; /* 他の要素より前面に表示 */    
}

.nav.navbar-nav {
    display: flex;
    justify-content: right;
    magin-top: 10px;
}

.navbar-nav li {
    display: inline-block;
    margin-right: 15px;
    position: relative; /* 縦線用に相対位置を設定 */
}


.navbar-nav li a {
    text-decoration: none;
    padding: 5px 15px;
    color: white;
}

.navbar-nav li a:hover {
    background-color: #ddd;
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

.navbar-header {
            display: flex;
            align-items: center; /* ロゴを中央揃え */
        }

        .navbar-brand img {
            vertical-align: middle; /* ロゴを中央揃え */
        }

.container-fluid{
        display: flex;
        justify-content: space-between;
        align-items: center;
}


body {
    padding-top: 60px; /* ナビゲーションバーの高さ分の余白を追加 */
}

</style>
</head>

<body>
 <!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>チュートリアルページ</title>
  <style>
    /* ページ全体のスタイル */
    body {
      font-family: sans-serif;
      margin: 0;
      padding: 0;
    }

    /* チュートリアルコンテンツのラッパ */
    .tutorial-container {
      margin-left: 60px; /* チュートリアルコンテンツを左寄せ */
      margin-top: 20px;
      max-width: 600px;   /* ページ幅を制限 */
      /* margin: 0 auto;     中央寄せ */
      /* padding: 20px; */
      /* text-align: center; 画像やボタンを中央揃え */
    }

    /* チュートリアル用の画像 */
    .tutorial-image {
      /* width: 100%; */
      text-align: center;
      max-width: 1000px;   /* 画像サイズを制限 */
      height: auto;
      border: 1px solid #ccc;
      margin-bottom: 20px;
    }

    /* 次へボタン */
    .next-button {
      background-color: #007bff;
      color: #fff;
      padding: 12px 24px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
    }
    .next-button:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <div class="tutorial-container">
    <!-- 上段に表示したい任意の画像 -->
    <img src= 'tutorial/tutorial-1.png' 
      alt="説明用の画像" 
      class="tutorial-image"
    />

    <!-- 下段に「次へ」ボタン -->
    <button 
      class="next-button" 
      onclick="location.href='tutorial-2.php'">
      次へ
    </button>
  </div>
</body>
</html>
   
    
</body>
</html>