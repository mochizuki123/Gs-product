<?php

//XSS対応（ echoする場所で使用！それ以外はNG ）
function h($str)
{
   return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}


//DB接続
function db_conn()
{
    try {
        $db_name = 'gs_product_v1';    //つぶやきベース名
        $db_id   = 'root';      //アカウント名
        $db_pw   = '';      //パスワード：XAMPPはパスワード無しに修正してください。
        $db_host = 'localhost'; //DBホスト
        $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
        return $pdo;
    } catch (PDOException $e) {
        exit('DB Connection Error:' . $e->getMessage());
    }
}

//SQLエラー
function sql_error($stmt)
{
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit('SQLError:' . $error[2]);
}

//リダイレクト　header 関数を使用して、HTTPレスポンスヘッダーに Location ヘッダーを設定します。
//$file_name 変数にはリダイレクト先のURLが含まれていると仮定されます。
//この行により、クライアント（ブラウザ）は指定されたURLにリダイレクトされます。
function redirect($file_name)
{
    header('Location: ' . $file_name);
    exit();
}


// ログインチェク処理 loginCheck()
function loginCheck()
{
    if (!isset($_SESSION['chk_ssid'])  ||  $_SESSION['chk_ssid']  !==  session_id()) {
        redirect('login.php');
    } else {
        // ログイン済み処理。ユーザがログインした場合、セッションIDを再生成し、古いセッションIDを無効にします。これにより、セッション固定攻撃を防ぎます
        //新しいセッションIDをセッション変数 $_SESSION['chk_ssid'] に保存します。
        session_regenerate_id(true);
        $_SESSION['chk_ssid'] = session_id();
    }
}
