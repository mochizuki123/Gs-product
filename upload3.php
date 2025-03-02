<!-- menu2.1.phpの入力内容を受けて、スピーチテーマを生成 -->
<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);

// session_start();

$api_key = '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'; 
$url = 'https://api.openai.com/v1/chat/completions';

$experience = $_POST['experience'];
$interest = $_POST['interest'];


// APIリクエスト用のデータ
$request_data = array(
    'experience' => $experience,
    'interest' => $interest
);


// APIリクエスト用のデータ(スピーチテーマを生成)
$data = [
    "model" => "gpt-4o",
    "messages" => [
        ["role" => "system", "content" => "You are an assistant that helps users create speeches."],
        ["role" => "user", "content" => "以下の情報を基に、関連した社会の話題やイベントに関する情報を含むスピーチテーマを生成してください。箇条書きで簡潔に。\経験：$experience\n興味：$interest"]
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

$speech_themInfo = curl_exec($ch);


curl_close($ch);

$result = json_decode($speech_themInfo, true);
if (isset($result['choices'][0]['message']['content'])) {
    $speech_theme = $result['choices'][0]['message']['content'];
} else {
    $speech_theme = "Error: Invalid response from API for speech_theme.";
}

// menu2.php にリダイレクトして結果を表示. タイトルも一緒に GET パラメータとして渡す

// header("Location: menu3.php?info_text=" . urlencode($info_text) );
// exit();

header("Location: menu3.php?speech_theme=" . urlencode($speech_theme) );
exit();


?>

