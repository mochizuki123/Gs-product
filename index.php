<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メインメニュー</title>
    <link rel="stylesheet" href="css/index.css">
<style>
.navbar {
    background-color: grey ;
    color: white;
    padding: 10px 0;
    height: 50px;
}

/* .nav.navbar-nav {
    display: flex;
    flex-direction: row;
    justify-content: right;
} */

/* .navbar-nav li {
    display: inline-block;
    margin-right: 15px;
} */

.navbar-nav li a {
    /* text-decoration: none; */
    padding: px 5px;
    color: white;
}

.navbar-nav li a:hover {
    background-color: #ddd;
}

/* .menu-container {
    display: flex;
    justify-content: center;
    gap: 20px;
} */

.menu-button:hover {
    background-color: #a7a8aa;
}

.menu-button {
    padding: 20px 40px;
    cursor: pointer;
    border: 1px solid #ddd;
    border-radius: 5px;
    width: 200px;
    height: 60px;
    font-size: 15px;
    margin: 40px;
}
.menu-button:active {
    -webkit-transform: translateY(4px);
    transform: translateY(4px);
    border-bottom: none;
}

    </style>
</head>
<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <!-- <a class="navbar-brand" > -->
                <img src="img/logo2.png" alt="Logo" style="width:40px;">
                <!-- </a> -->
            </div>
            <ul class="nav navbar-nav">
                <li><a href="about.php">About</a></li>
                <li><a href="logout.php">Log out</a></li>
                
            </ul>
        </div>
    </nav>
      

<div class="menu-container">
        <button class="menu-button" onclick="location.href='menu1.php'">即興スピーチ</button>
        <button class="menu-button" onclick="location.href='menu2.php'">準備スピーチ</button>
        <button class="menu-button" onclick="location.href='menu3.php'">テーマ検討</button>
        <!-- <button class="menu-button" onclick="location.href='menu3.php'">メニュー3</button> -->
    </div>
</body>
</html>