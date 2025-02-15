<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);

// session_start();

$api_key = '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'; // OpenAIのAPIキーを設定
$url = 'https://api.openai.com/v1/chat/completions';

$purpose = $_POST['purpose'];
$char_limit = $_POST['char_limit'];
$message = $_POST['message'];
$language = $_POST['language'];
$outline1 = $_POST['outline1'];
$outline2 = $_POST['outline2'];
$outline3 = $_POST['outline3'];
$outline4 = $_POST['outline4'];

// APIリクエスト用のデータ
$request_data = array(
    'purpose' => $purpose,
    'char_limit' => $char_limit,
    'message' => $message,
    // 'language' => $language,
    'outline1' => $outline1,
    'outline2' => $outline2,
    'outline3' => $outline3,
    'outline4' => $outline4
);

$data = [
    "model" => "gpt-4o",
    "messages" => [
        ["role" => "system", "content" => "You are an assistant that helps users create speeches."],
        ["role" => "user", "content" => "スピーチの目的: $purpose\n字数の上限: $char_limit\n伝えたいメッセージ: $message\nスピーチの骨子①: $outline1\nスピーチの骨子②: $outline2\nスピーチの骨子③: $outline3\nスピーチの骨子④: $outline4"]
    ],
    "max_tokens" => 1500,
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

// APIリクエストを送信
$text_ready = curl_exec($ch);

// エラーチェック
// if (curl_errno($ch)) {
//     $error_msg = curl_error($ch);
//     curl_close($ch);
//     die("cURL error: $error_msg");
// }

curl_close($ch);

// // APIリクエストを送信
// $ch = curl_init('https://api.example.com/generate_speech');
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_POST, true);
// curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($request_data));
// $response = curl_exec($ch);
// curl_close($ch);
$result = json_decode($text_ready, true);
if (isset($result['choices'][0]['message']['content'])) {
    $response_text = $result['choices'][0]['message']['content'];
} else {
    $response_text = "Error: Invalid response from API.";
}

// index.php にリダイレクトして結果を表示
header("Location: menu2.php?response=" . urlencode($response_text));
exit();

?>

