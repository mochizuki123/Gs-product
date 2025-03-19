<!-- menu2.1.phpの入力内容を受けて、スピーチテーマを生成 -->
<?php
// セッション開始
session_start();
ini_set('display_errors', '1');
error_reporting(E_ALL);

// session_start();

$api_key = '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'; 
$url = 'https://api.openai.com/v1/chat/completions';

//menu3.php POST から受け取った experience、interest、theme を SESSION に保存
$experience = $_POST['experience'];
$interest = $_POST['interest'];
$theme = $_POST['theme'];

// セッションに保存
$_SESSION['experience'] = $experience;
$_SESSION['interest'] = $interest;
$_SESSION['theme'] = $theme;


// APIリクエスト用のデータ(スピーチテーマを生成)
$data = [
    "model" => "gpt-4o",
    "messages" => [
        ["role" => "system", "content" => "You are an assistant that helps users create speeches."],
        ["role" => "user", "content" => "以下の情報を基に、スピーチの構成を生成してください。
        \nテーマ：$theme\n経験：$experience\n関心：$interest
        表示方法は以下の項目1.から6.に分けること。項目と項目の間は改行して、箇条書き表示すること。
        1つの項目は50字程度とし、各項目のヘッダーと内容行は分けずに、必ず1行で表示すること。
        また、テーマや経験、関心に関連した社会の話題やイベントを検索して反映すること。

        1. スピーチタイトル：
        2. 伝えたいメッセージ：
        3. スピーチ骨子①：
        4. スピーチ骨子②：
        5. スピーチ骨子③：
        6. スピーチ骨子④ ："]
    ],
    "max_tokens" => 5000,
    // "language" => $language // 言語をAPIリクエストに含める
];

// cURLセッションを初期化
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer " . $api_key
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
//SSL証明書の検証をスキップし、エラーを回避一時的に追加
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);


$speech_themInfo = curl_exec($ch);


curl_close($ch);

$result = json_decode($speech_themInfo, true);
if (isset($result['choices'][0]['message']['content'])) {
    $text_theme = $result['choices'][0]['message']['content'];
} else {
    $text_theme = "Error: Invalid response from API for text_theme.";
}

$_SESSION['text_theme'] = $text_theme;

// menu3.php にリダイレクト
header('location: menu3.php');
exit();

// header("Location: menu3.php?speech_theme=" . urlencode($speech_theme) );
// exit();


?>

