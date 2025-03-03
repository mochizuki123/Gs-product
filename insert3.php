
<?php
// エラーを出力する
ini_set('display_errors', '1');
error_reporting(E_ALL);

session_start();
require_once 'funcs.php';

//1. menu2 からタイトルとスピーチ原稿と取得
if (isset($_POST['title'])) {
    $title = $_POST['title'];
    echo "title: $title<br>";
// } else {
//     exit('Error: title is not set.');
}

//２．登録SQL作成
$pdo = db_conn();


// セッションに必要なデータが存在するか確認
if (isset($_SESSION['experience']) && isset($_SESSION['interest']) && isset($_SESSION['speech_theme'])) {
    $experience  = $_SESSION['experience'];
    $interest    = $_SESSION['interest'];
    $speech_theme = $_SESSION['speech_theme'];

    
    
    // 【ポイント】数字＋ドットのパターンで分割して各テーマを抽出（例：1.、2.）
    $themes_array = preg_split('/\r\n|\r|\n/', $speech_theme, -1, PREG_SPLIT_NO_EMPTY);
    // 各テーマの先頭・末尾の空白をトリム
    $theme1 = isset($themes_array[0]) ? trim($themes_array[0]) : '';
    $theme2 = isset($themes_array[1]) ? trim($themes_array[1]) : '';
    $theme3 = isset($themes_array[1]) ? trim($themes_array[2]) : '';
    $theme4 = isset($themes_array[1]) ? trim($themes_array[3]) : '';
    
    // プリペアドステートメントを利用してINSERT
    $stmt = $pdo->prepare('INSERT INTO speech_text_ready(user_id, title, experience, interest, theme1text_ready, created_at) VALUES(:user_id, :title, :text_ready, NOW());');

    $stmt = $pdo->prepare("INSERT INTO $table (experience, interest, theme1) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ssssss", $experience, $interest, $theme1, $theme2, $theme3, $theme4);
    
    if ($stmt->execute()) {
        $message = "データベースに保存されました。";
        // 保存後は必要に応じてセッションのデータをクリア
        unset($_SESSION['experience']);
        unset($_SESSION['interest']);
        unset($_SESSION['speech_theme']);
    } else {
        $message = "保存に失敗しました: " . $stmt->error;
    }
    $stmt->close();
} else {
    $message = "保存するデータが見つかりません。";
}

$conn->close();

// 結果メッセージをセッションに保存してmenu3.phpへリダイレクト
$_SESSION['db_message'] = $message;
header("Location: menu3.php");
exit();
?>
