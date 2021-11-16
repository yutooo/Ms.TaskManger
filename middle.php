<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <title>追加</title>
  </head>

  <body>
	<p>
		<?php

			session_start();
			//ログイン済みの場合
			if(isset($_SESSION['userid'])) {
				$userid= $_SESSION['userid'];
			}
			
			$did = '';
			if(isset($_GET['did']) == true && $_GET['did'] != ''){
				$did = $_GET['did'];
			}
			
			$category = '';
			if(isset($_GET['category']) == true && $_GET['category'] != ''){
				$category= $_GET['category'];
			}
			
			$time = '';
			if(isset($_GET['time']) == true && $_GET['time'] != ''){
				$time= $_GET['time'];
			}
			
			$date = '';
			if(isset($_GET['date']) == true && $_GET['date'] != ''){
				$date= $_GET['date'];
			}
		

			try{
				
				//DB接続
				require_once('./DBInfo.php');
				$pdo = new PDO(DBInfo::DSN, DBInfo::USER, DBInfo::PASSWORD);
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				//PDO::beginTransactionメソッドでトランザクション開始
				$pdo->beginTransaction();
				
				//SQL1を実行
				$sql = "INSERT INTO dstack VALUES('$userid','$did','$category','$time','$date')";
				$pdo->exec($sql);		//今回は戻り値を取っていない
				
				
				//PDO::commitメソッドでコミット
				$pdo->commit();
				print('コミットしました<br/>');
				
			}
			catch(PDOException $e){
				
				//$pdoがsetされていて、トランザクション中であれば真
				if(isset($pdo) == true && $pdo->inTransaction() == true){
					
					//PDO::commitメソッドでロールバック
					$pdo->rollBack();
					print('ロールバックしました<br/>');
				}
				
				//エラー情報の表示
				$code = $e->getCode();
				$message = $e->getMessage();
				print("{$code}/{$message}<br/>");
				
			}
			
			$pdo = null;
			print('処理終了<br/>');
			?>
	</p>

	<p>
		<a href="./front.php">home</a>
	</p>
  </body>
</html>
