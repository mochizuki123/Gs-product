<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>AI SPEECH Login</title>
  <style>
    /* 全体リセット */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: "Noto Sans JP", sans-serif;
      line-height: 1.6;
      color: #333;
      /* 背景に薄い模様を表示（パターン画像など） */
      background-color: #f9f9f9;
      background-image: url("background-pattern.png"); /* ここを任意の模様画像に差し替え */
      background-repeat: no-repeat;
      background-size: cover;
      background-position: center;
      /* 上下に余白を確保 */
      padding: 40px 0;
      width: 100%;
    }

    /* コンテナ（横幅100%） */
    .container {
      width: 100%;
      margin: 0 auto;
    }

    /* #Messageアイコン部分 */
    .message-icon {
      display: inline-block;
      background-color: #0070C9; /* アイコンの背景色 */
      color: #fff;
      padding: 10px 20px;
      border-radius: 30px; /* 丸み */
      font-weight: bold;
      font-size: 1rem;
      text-align: center;
    }
    .message-icon-wrapper {
      text-align: center;
      margin-bottom: 20px;
    }

    /* メッセージ部分 */
    .message-section {
      font-size: 20px;
        text-align: center;
        width: 90%;
      max-width: 1000px;
      margin: 0 auto 40px auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    .message-section p {
      margin-bottom: 1em;
      line-height: 1.8;
    }

    /* 課題部分のタイトル */
    .problems-title {
      text-align: center;
     font-size: 30px;
      color: #0070C9;
      font-weight: bold;
      margin-bottom: 20px;
    }

    /* 課題ボックスを横に並べるラッパー */
    .problems-container {
      display: flex;
      flex-wrap: wrap;        /* 画面幅が狭い場合に折り返し */
      gap: 16px;              /* ボックス間の隙間 */
      margin-bottom: 20px;
      text-align: center;
    }

    /* 課題ボックス */
    .problem-box {
      background-color:rgba(69, 184, 229, 0.84); /* アイコンの背景色 */
      color: white;
      flex: 1 1 calc(25% - 16px); /* 4つ並べるイメージ。画面幅で自動調整 */
      min-width: 220px;           /* 小さくなりすぎないように制御 */
      border-radius: 8px;
      padding: 16px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
      font-weight: bold;
    }
    .problem-box p {
      line-height: 1.6;
    }

    /* 問題下のメッセージ */
    .problems-note {
      
      text-align: center;
      margin-top: 20px;
      font-size: 20px;
      font-weight: bold;
      color: #0070C9;
      
    }

        /* レスポンシブ対応 */
    @media screen and (max-width: 768px) {
      .problems-container {
        gap: 12px;
      }
      .problem-box {
        flex: 1 1 calc(50% - 12px);
      }
    }
    @media screen and (max-width: 480px) {
      .problem-box {
        flex: 1 1 100%;
      }
      .login-form {
        width: 90%;
      }
    }

.body{
    align-items: center;

}



  </style>
</head>
<body>
  <div class="container">
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
        <span style="color: red;">AI SPEECH</span>  は自身も優れたスピーチから受けた作者が、<br>
        テクノロジーを活用して、人を勇気づけたり、感動させるスピーチを<br>
        紡ぎだす支援をしたいという想いから、作りました。
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
          <p>自分のアイディアや、原稿を他人と共有して、<br>フィードバックを受けたい</p>
        </div>
        <div class="problem-box">
          <p>過去につくったスピーチ原稿がみあたらない</p>
        </div>
      </div>
      <p class="problems-note">
        AIと人のコラボレーションにより、あなたのスピーチ作成に寄り添い、支援します
      </p>
    </div>

      </div>
</body>
</html>
