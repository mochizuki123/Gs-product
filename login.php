<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ログイン</title>
  <style>
    /* 全体リセット */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html, body {
      height: 100%;
      font-family: sans-serif;
    }

    /* 画面全体を横並びに2分割 */
    .container {
      display: flex;
      height: 100vh;
    }

    /* 左半分：背景にスピーチを連想させる画像を設定 */
    .left-panel {
      width: 60%;
      background: url('img/login_image_left.png') no-repeat center center;
      background-size: cover; /* 画像を全体にフィットさせる */
    }

    /* 右半分：半透明の背景を重ねて透かし効果を出す */
    .right-panel {
      width: 40%;
      /* background-color: rgba(255, 255, 255, 0.7); 透かし(白の半透明) */
      background: url('img/login_rightside_transparent.png') no-repeat center center;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 40px;
    }

    /* ロゴ画像を配置するエリア */
    .logo {
      margin-bottom: 30px;
    }
    .logo img {
      max-width: 200px; /* ロゴ画像の最大幅を設定 */
      height: auto;
    }

/* ログインフォームを囲むボックス */
    .login-box {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 320px;
      text-align: center;
    }

    /* ログインフォーム全体のスタイル */
    .login-form {
      width: 100%;
      max-width: 300px; /* フォームの最大幅を制限 */
      display: flex;
      flex-direction: column;
    }

    .login-form label {
      margin-bottom: 5px;
      font-weight: bold;
    }

    .login-form input {
      margin-bottom: 15px;
      padding: 10px;
      font-size: 16px;
    }

    .login-form button {
      padding: 10px;
      font-size: 16px;
      color: #fff;
      background-color: #007bff;
      border: none;
      cursor: pointer;
    }

    .login-form button:hover {
      background-color: #0056b3;
    }

  </style>
</head>
<body>
  <div class="container">
    <!-- 左半分：スピーチをイメージする画像を設定 -->
     
    <div class="left-panel">
      <!-- speech.png など、後から差し替えてください -->
    </div>

    <!-- 右半分：透かし背景にロゴとログインフォームを配置 -->
    <div class="right-panel">
    <div class="logo">
        <!-- 会社ロゴを入れる(logo.png などを差し替え) -->
        <img src="logo.png" alt="Company Logo">
      </div>

      
    <div class='login-box'>
      <form class="login-form" action="login_act.php" method="post">
        <label for="userId">ID</label>
        <input type="text" id="userId" name="user_id" placeholder="IDを入力">

        <label for="password">パスワード</label>
        <input type="password" id="password" name="login_pw" placeholder="パスワードを入力">

        <button type="submit">ログイン</button>
      </form>
    </div>
  </div>
</body>
</html>

