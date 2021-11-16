<?php
//POSTのValidate。
if (!$userid = filter_var($_POST['userid'], FILTER_VALIDATE_EMAIL)) {
  echo "入力された値が不正です。";
  return false;
}
//パスワードの正規表現
if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{4,100}+\z/i', $_POST['password'])) {
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
} else {
  echo 'パスワードは半角英数字をそれぞれ1文字以上含んだ4文字以上で設定してください。';
  return false;
}
//名前
$name= $_POST['name'];

//登録処理
try {
  require_once('./DBInfo.php');
//データベースへ接続

  $pdo = new PDO(DBInfo::DSN, DBInfo::USER, DBInfo::PASSWORD);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = "INSERT INTO users VALUES('$userid','$name','$password')";
  $pdo->exec($sql);	

  session_start();
  session_regenerate_id(true); //session_idを新しく生成し、置き換える
  $_SESSION['userid'] = $userid;
  $_SESSION['name'] =   $name;
  header('location:./front.php');
  
} catch (PDOException $e) {
  echo '登録済みのメールアドレスです。';
}
