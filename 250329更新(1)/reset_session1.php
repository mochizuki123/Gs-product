<?php
session_start();
unset($_SESSION['experience']);
unset($_SESSION['interest']);
unset($_SESSION['theme']);
unset($_SESSION['text_theme']);
echo json_encode(['status' => 'success', 'message' => 'セッションデータが削除されました。']);
exit();
?>
