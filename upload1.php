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

// $text_prompt = $_POST['text_prompt'] ?? '';
// 初期化（認識結果の変数）
$prompt_response = '';

// $prompt_response = $_POST['prompt_response'];



// 音声データをアップロード
if (!empty($_FILES['voice']['tmp_name'])) {
    $upload_dir = 'voice_upload/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $upload_file = $upload_dir . basename($_FILES['voice']['name']);
    
    if (move_uploaded_file($_FILES['voice']['tmp_name'], $upload_file)) {
        // echo '<div class="d-none">ファイルがアップロードされました: ' . $upload_file.'</div>';
        
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
        //SSL証明書の検証をスキップし、エラーを回避一時的に追加
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        } else {    
                $response_data = json_decode($response, true);
            if (isset($response_data['text'])) {
                $prompt_response = $response_data['text'];
                // echo '<div style="font-size: 18px;">' . $response_data['text']. '</div>';
            } else {
                echo 'テキストが見つかりませんでした。';
            }
        }
        //  } else {
        //     echo 'Response:' . $response;
        //     // echo $response;
        // }
        curl_close($ch);
    } else {
        echo "ファイルのアップロードに失敗しました。";
    }
} else {
    echo "音声ファイルが選択されていません。";
}

echo $prompt_response;
// echo '<div style="font-size: 18px;">' . $prompt_response . '</div>';



// セッションに保存
$_SESSION['speech_data'] = [
    // 'text_prompt' => $text_prompt,
    'response_data' => $prompt_response
    // 'prompt_response' => $prompt_response,
    
];


?>