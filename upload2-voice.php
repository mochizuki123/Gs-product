    <?php
ini_set('display_errors', '1');
error_reporting(E_ALL);

session_start();

require __DIR__ . '/../vendor/autoload.php';

use OpenAI\Whisper;

// 音声（alloy, echo, fable, onyx, nova, shimmerから選択。novaとshimmerが女性。）
$voice_assistant = "nova";

// API KEY
$openai_api_key = "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";

// system（AIの役割、人格）
$system_set = "大勢の聴衆に向けて心に残るスピーチを行う";

// ユーザー履歴の制限（何回分まで保持するか）
// $chat_limit = 30;

// chatGPTのモデル
// $model ="gpt-4-0125-preview";

// 言語(指定した方が読み取りやすいです。)
// ; $language = "ja";


// 音声化(text to speech)
	        // $text = $responseData2["choices"][0]["message"]["content"]; 
        
            // POSTリクエストをチェック
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['$response_text'])) {
            $$response_text = $_POST['$response_text'];
	        $data = [
    	        'model' => 'tts-1',
    	        'input' => $$response_text,
    	        'voice' => $voice_assistant,
                // 'language' => $language,
	        ];
        
	        $ch = curl_init('https://api.openai.com/v1/audio/speech');
	        curl_setopt($ch, CURLOPT_HTTPHEADER, [
    	        'Authorization: Bearer ' . $openai_api_key,
    	        'Content-Type: application/json'
	        ]);
	        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        
	        $response2 = curl_exec($ch);
	        curl_close($ch);
	        
            // 音声データを作成
	        // $file_ver = rand(10000001, 99999999);
			$date = date('Ymd_His'); // 日付情報を取得
			$directory = 'voice_data';
            if (!is_dir($directory)) {
                mkdir($directory, 0777, true);
            }   
    
			$file_name = 'voice_data/speech_'.$date.'_'.'.mp3';
			file_put_contents($file_name, $response2);

             // 音声ファイルをブラウザに返す
            header('Content-Type: audio/mpeg');
            header('Content-Disposition: attachment; filename="output.mp3"');
            readfile($audioFile);
           
        }
        ?>
    
        <!-- audio を生成 -->
    <audio controls autoplay style="display: none;" onended="window.location.href='index.php';">
    <source src="<?php echo $file_name; ?>" type="audio/mpeg">
    <!-- Your browser does not support the audio element. -->
    
	</audio>
    
    