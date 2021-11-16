<?php

require_once('./DBInfo.php');

session_start();
//POSTのvalidate
if (!filter_var($_POST['userid'], FILTER_VALIDATE_EMAIL)) {
  echo '入力された値が不正です。';
  return false;
}
//DB内でPOSTされたメールアドレスを検索
try {
  $pdo = new PDO(DBInfo::DSN, DBInfo::USER, DBInfo::PASSWORD);
  $stmt = $pdo->prepare('select * from users where userid = ?');
  $stmt->execute([$_POST['userid']]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);  //連想配列で取得
} catch (\Exception $e) {
  echo $e->getMessage() . PHP_EOL;
}
//useridがDB内に存在しているか確認
if (!isset($row['userid'])) {
  echo 'メールアドレス又はパスワードが間違っています。';
  return false;
}
//パスワード確認後sessionにメールアドレスを渡す
if (password_verify($_POST['password'], $row['password'])) {
  session_regenerate_id(true); //session_idを新しく生成し、置き換える
  $_SESSION['userid'] = $row['userid'];
  $_SESSION['name'] =   $row['name'];
  header('location:./front.php');

} else {
  echo 'メールアドレス又はパスワードが間違っています。';
  return false;
}