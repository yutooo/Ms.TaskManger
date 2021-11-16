<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta  charset="UTF-8" />
		<title>pdo06 データ検索と表示</title>
	</head>
	<body>
		<?php
			
			//表示用変数
			$did = '';
			
			session_start();
			//ログイン済みの場合
			if(isset($_SESSION['userid'])) {
				$userid= $_SESSION['userid'];
			}
			
			try{
				
				//DB接続
				require_once('./DBInfo.php');
				$pdo = new PDO(DBInfo::DSN, DBInfo::USER, DBInfo::PASSWORD);
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				//参照系SQL
				$sql = "SELECT * FROM dstack where userid='$userid'";
				
				//参照系SQLを発行				
				$stmt = $pdo->prepare($sql);
				$stmt->execute();
				
				//データの取得
				while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
						print($result['did']);
						print($result['time'].'分頑張りました'.'<br>');
				}
				//DB切断
				$pdo = null;
				
			}
			catch(PDOException $e){
				
				//DB切断
				$pdo = null;
				
				//エラーページに移動する
				//header('location:error.php');
			}
		?>
	
	<p><a href="./front.php">ホーム</a></p>
	<p><a href="./add.html">追加</a></p>
	</body>
</html>