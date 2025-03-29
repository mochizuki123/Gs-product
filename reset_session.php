<?php
session_start();
unset($_SESSION['speech_data']);
// もしくはセッション全体をクリアする場合は session_destroy();
echo "セッションがリセットされました。";
?>
