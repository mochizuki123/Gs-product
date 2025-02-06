<?php

session_start();
ini_set('display_errors', '1');
error_reporting(E_ALL);
// API KEY
$openai_api_key = "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";

// $language = "ja";

// index2.phpの言語選択に対応予定
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//         $language = $_POST["language"];
//     } else {
//         $language = "ja"; // デフォルトは日本語
//     }
    
// 音声データをアップロード
if (!empty($_FILES['voice']['tmp_name'])) {
    $upload_dir = 'voice_upload/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $upload_file = $upload_dir . basename($_FILES['voice']['name']);
    
    if (move_uploaded_file($_FILES['voice']['tmp_name'], $upload_file)) {
        echo '<div class="d-none">ファイルがアップロードされました: ' . $upload_file.'</div>';
        
        // 音声データをテキストに変換（speech to text）
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/audio/transcriptions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        $headers = [
            'Authorization: Bearer ' . $openai_api_key,
            'Content-Type: multipart/form-data'
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $postFields = [
            'file' => new CURLFile($upload_file),
            'model' => 'whisper-1',
            // 'language' => $language,
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Add the file to the POST fields
        $post_fields = [
            'file' => new CURLFile($upload_file),
            'model' => 'whisper-1',
            // 'language' => $language
        ];
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        } else {
            echo 'Response:' . $response;
        }
        curl_close($ch);
    } else {
        echo "ファイルのアップロードに失敗しました。";
    }
} else {
    echo "音声ファイルが選択されていません。";
}
?>