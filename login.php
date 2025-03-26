<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ログイン</title>
  <style>
    /* リセット */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    /* body全体の設定 */
    html, body {
      width: 100%;
      min-height: 100vh;
      font-family: "Noto Sans JP", sans-serif;
      line-height: 1.6;
      color: #333;
      /* 全体の背景に薄い模様を表示する場合 */
      background-color: #f9f9f9;
      background-image: url("background-pattern.png"); /* 模様画像パスを差し替えてください */
      background-repeat: no-repeat;
      background-size: cover;
      background-position: center;
    }

    /* ---------- 上段: ログイン画面 ---------- */
    .top-container {
      display: flex;        /* 左右に分割 */
      width: 100%;
      height: 80vh;         /* 高さは任意で調整。例: 80%画面の高さ */
    }

    /* 左パネル: スピーチをイメージする画像 */
    .left-panel {
      width: 60%;
      background: url('img/login_image_left.png') no-repeat center center;
      background-size: cover;
    }

    /* 右パネル: ロゴとログインフォーム */
    .right-panel {
      width: 40%;
      /* もし透かし効果を出したい場合は以下のようにする
         background-color: rgba(255, 255, 255, 0.7); 
      */
      background: url('img/login_rightside_transparent.png') no-repeat center center;
      background-size: cover; /* 必要に応じて調整 */
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 40px;
      position: relative;
    }

    /* ロゴ配置 */
    .logo {
      margin-bottom: 30px;
      position: absolute;
      top: 100px;       /* 上からの位置を調整 */
      left: 50%;
      transform: translateX(-50%);
      z-index: 10;
    }
    .logo img {
      /* ロゴ画像の幅や高さを調整 */
      width: 320px;
      height: auto;
    }

    /* ログインフォームを囲むボックス */
    .login-box {
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 320px;
      text-align: center;
      z-index: 5; /* ロゴより下に行かないよう注意(必要なら値を調整) */
    }

    /* ログインフォーム */
    .login-form {
      width: 100%;
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
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .login-form button {
      padding: 10px;
      font-size: 16px;
      color: #fff;
      background-color: #007bff;
      border: none;
      cursor: pointer;
      border-radius: 4px;
    }
    .login-form button:hover {
      background-color: #0056b3;
    }

    /* ---------- 下段: メッセージ & 課題 ---------- */
    .bottom-container {
      width: 100%;
      margin: 0 auto;
      padding: 40px 0; /* 上下に余白を確保 */
    }

    /* #Messageアイコン */
    .message-icon-wrapper {
      text-align: center;
      margin-bottom: 20px;
    }
    .message-icon {
      display: inline-block;
      background-color: #0070C9;
      color: #fff;
      padding: 10px 20px;
      border-radius: 30px;
      font-weight: bold;
      font-size: 1rem;
      text-align: center;
    }

    /* メッセージセクション */
    .message-section {
      width: 90%;
      max-width: 1000px;
      margin: 0 auto 40px auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      font-size: 20px;
      text-align: center;
    }
    .message-section p {
      margin-bottom: 1em;
      line-height: 1.8;
    }

    /* 課題タイトル */
    .problems-title {
      text-align: center;
      font-size: 30px;
      color: #0070C9;
      font-weight: bold;
      margin-bottom: 20px;
    }

    /* 課題ボックスのラッパ */
    .problems-container, .solution-container {
      display: flex;
      flex-wrap: wrap;
      gap: 16px;
      justify-content: center; /* 中央揃えしたい場合 */
      margin-bottom: 20px;
    }

    /* 課題ボックス */
    .problem-box {
      background-color: rgba(69, 184, 229, 0.84);
      color: white;
      flex: 1 1 calc(25% - 16px);
      min-width: 220px;
      border-radius: 8px;
      padding: 16px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
      font-weight: bold;
    }
    .problem-box p {
      line-height: 1.6;
      margin: 0; /* 余白調整 */
    }
    .solution-box p {
      line-height: 1.6;
      margin: 0; /* 余白調整 */
    }

  .solution-box {
          background-color: #0070C9;
      color: white;
      flex: 1 1 calc(25% - 16px);
      min-width: 220px;
      border-radius: 8px;
      padding: 16px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
      font-weight: bold;
    }

    /* 下部のメッセージ */
    .problems-note {
      text-align: center;
      margin-top: 20px;
      font-size: 20px;
      font-weight: bold;
      color: #0070C9;
    }

    /* レスポンシブ対応 */
    @media screen and (max-width: 768px) {
      .left-panel {
        width: 50%;
      }
      .right-panel {
        width: 50%;
      }
      .problem-box {
        flex: 1 1 calc(50% - 12px);
      }
    }
    @media screen and (max-width: 480px) {
      .top-container {
        flex-direction: column; /* スマホ等で上下配置にする場合 */
        height: auto;          /* 高さを自動に */
      }
      .left-panel, .right-panel {
        width: 100%;
        height: 50vh; /* 必要に応じて調整 */
      }
      .problem-box {
        flex: 1 1 100%;
      }
    }
  </style>
</head>
<body>

  <!-- 上段コンテナ: ログイン部分 -->
  <div class="top-container">
    <!-- 左パネル -->
    <div class="left-panel"></div>

    <!-- 右パネル -->
    <div class="right-panel">
      <!-- ロゴ -->
      <div class="logo">
        <img src="img/company-logo2.png" alt="Company Logo2">
      </div>

      <!-- ログインボックス -->
      <div class="login-box">
        <form class="login-form" action="login_act.php" method="post">
          <label for="userId">ID</label>
          <input type="text" id="userId" name="user_id" placeholder="IDを入力">

          <label for="password">パスワード</label>
          <input type="password" id="password" name="login_pw" placeholder="パスワードを入力">

          <button type="submit">ログイン</button>
        </form>
      </div>
    </div>
  </div>

  <!-- 下段コンテナ: メッセージ & 課題 -->
  <div class="bottom-container">
    <!-- #Message アイコン -->
    <div class="message-icon-wrapper">
      <div class="message-icon">Message</div>
    </div>

    <!-- メッセージセクション -->
    <div class="message-section">
      <p>
        結婚式、送別会のようなカジュアルなシーンから、営業、ピッチなど<br>
        様々なライフシーンで私たちは人前でスピーチをする機会があります。
      </p>
      <p>
        <span style="color: red;">アイスピーチ</span>は、優れたスピーチから多くのインスピレーションを受けた作者が、<br>
        テクノロジーを活用して、人を勇気づけたり、感動させるスピーチを<br>
        作り出す支援をしたいという想いから、作りました。
      </p>
    </div>

    <!-- 課題セクション -->
    <div class="message-section">
      <div class="problems-title">こんな課題ありませんか？</div>
  
      <div class="problems-container">
        <div class="problem-box">
          <p>伝えたいことがあるが、言葉にできない。</p>
        </div>
        <div class="problem-box">
          <p>スピーチ原稿をつくる時間が無い</p>
        </div>
        <div class="problem-box">
          <p>自分のアイディアや、原稿を他人と共有し、フィードバックを受けたい</p>
        </div>
        <div class="problem-box">
          <p>過去につくったスピーチ原稿がみあたらない</p>
        </div>

        <p class="problems-note">
        <span style="color: red;">アイスピーチ</span>が、AIと人のコラボレーションにより、あなたのスピーチ作成に寄り添い、支援します
        </p>
 
        <div class="solution-container">
        <div class="solution-box">
          <p>日常の出来事を記録するダイアリ―機能</p>
        </div>
        <div class="solution-box">
          <p>AIとの協創によるスピーチのテーマと原稿生成機能</p>
        </div>
        <div class="solution-box">
          <p>作成したスピーチ原稿を共有する機能</p>
        </div>
        <div class="solution-box">
          <p>磨き上げたスピーチを記憶とともに保存する機能</p>
        </div>
      </div>
 
 
      </div>
      
    </div>
  </div>

</body>
</html>
