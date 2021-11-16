<?php

  session_start();
  //ログイン済みの場合
  if (isset($_SESSION['name'])) {
    $name =  $_SESSION['name'];
    $userid = $_SESSION['userid'];
    echo 'ようこそ' . $name . "さん<br>";
  }
  else{
    echo 'ログインしてください<br>';
    echo "<a href='./index.php'>ログインはこちら。</a>";
    exit;
  }
?>
    
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <title>フロントページ</title>
  </head>

  <body>

    <ul>
      <li><a href="./list.php">リスト</a></li>
      <li><a href="./add.html">追加</a></li>
      <li><a href="./analyze.php">分析</a></li>

    </ul>

    <p><a href='./logout.php'>ログアウトはこちら。</a><br></p>
  </body>

</html>