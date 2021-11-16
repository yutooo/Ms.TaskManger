<?php

session_start();
//ログイン済みの場合
if (isset($_SESSION['name'])) {
  header('location:./front.php');
  exit;
}

 ?>

<!DOCTYPE html>
<html lang="ja">
 <head>
   <meta charset="utf-8">
   <title>Login</title>
 </head>
 <body>
   <h1>ようこそ、ログインしてください。</h1>
   <form  action="login.php" method="post">
     <label for="userid">userid(email)</label>
     <input type="email" name="userid">
     <label for="password">password</label>
     <input type="password" name="password">
     <button type="submit">Sign In!</button>
   </form>
   <h1>初めての方はこちら</h1>
   <form action="signUp.php" method="post">
     <label for="userid">userid(email)</label>
     <input type="email" name="userid">
  
     <label for="name">name</label>
     <input type="name" name="name">

     <label for="password">password</label>
     <input type="password" name="password">
     <button type="submit">Sign Up!</button>
     <p>※パスワードは半角英数字をそれぞれ１文字以上含んだ、4文字以上で設定してください。</p>
   </form>
 </body>
</html>
