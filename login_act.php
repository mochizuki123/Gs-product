<?php

session_start();
$lid = $_POST['user_id'];
$lpw = $_POST['login_pw'];

require_once 'funcs.php';
$pdo = db_conn();

// ユーザー登録時のパスワードハッシュ化
$hashed_password = password_hash($lpw, PASSWORD_DEFAULT);
// var_dump($hashed_password);

// usersに、IDとWPがあるか確認する。このSQL文は、users テーブルから lid カラムが指定された値と一致するレコードを選択するものです。
//:lid はプレースホルダーで、後で実際の値に置き換えられます。
$stmt = $pdo->prepare('SELECT * FROM users WHERE user_id = :lid;');
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
$status = $stmt->execute();


//3. SQL実行時にエラーがある場合STOP
if($status === false) {
    sql_error($stmt);
}

//4. 抽出つぶやき数を取得　データベースクエリの結果からユーザー情報を1行取得し、その情報を後続の処理で使用するために変数 $val に格納
$val = $stmt->fetch();

// var_dump($val['login_pw']);
// var_dump($lpw);
// var_dump(password_verify($lpw, $val['login_pw']));
// exit();
// var_dump(password_verify($lpw, $val['login_pw']));
// exit();

// if (password_verify($lpw, $val['login_pw'])) {
if($val['user_id'] !== '') { //* PasswordがHash化の場合はこっちのIFを使う
    //Login成功時 該当レコードがあればSESSIONに値を代入
    $_SESSION['chk_ssid'] = session_id();
    $_SESSION['kanri_flg'] = $val['kanri_flg'];
    $_SESSION['user_id'] = $val['user_id'];
    header('Location: index.php');
} else {
    //Login失敗時(Logout経由)
    header('Location: login.php');
}
exit();
