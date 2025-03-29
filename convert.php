<?php
require __DIR__ . '/../vendor/autoload.php';

use OpenAI\Whisper;

// Whisperのインスタンスを作成
$whisper = new Whisper();

// POSTリクエストをチェック
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['response_text'])) {
    $response_text = $_POST['response_text'];

    // テキストを音声に変換
    $audioFile = $whisper->textToSpeech($response_text);

    // 音声ファイルをブラウザに返す
    header('Content-Type: audio/mpeg');
    header('Content-Disposition: attachment; filename="output.mp3"');
    readfile($audioFile);
    exit;
}

?>