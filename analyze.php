<!DOCTYPE html>
<html lang="ja">
<head>
  <title>グラフ</title>
  <link rel="stylesheet" href="analyze.css">
  <script src="./analyze.js"></script>
</head>

<body>
  <!-- 今日の日付を取得して前の一週間分のデータを昇順で取得する -->

  <?php
    // $today= strtotime(date("Y-m-d"));
    // $lastWeek= $today-(60*60*24*6);
    $today= date("Y-m-d");
    $lastWeek= date("Y-m-d",strtotime("-6 day"));
    $date;
    for($i=0;$i<7;$i++){
      $date[$i]=date("Y-m-d",strtotime("-".(6-$i)."day"));
    }

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
      $sql = "SELECT time, date, category FROM dstack 
      where userid='$userid' and
      date >= '$lastWeek' and  date <='$today'
      order by date asc";
      
      //参照系SQLを発行				
      $stmt = $pdo->prepare($sql);
      $stmt->execute();
      
      // 一日の学習時間
      $dailyTime = array_fill(0,7,0);
      
      //カテゴリー別時間
      $subcategory = array(
        "health" => 0,
        "knowledge" => 0,
        "learning" => 0,
        "thinking" => 0,
        "self" => 0,
        "give" => 0
      );

      //データの取得
      while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
        $dailyTime[(strtotime($result['date'])-strtotime($lastWeek))/(60*60*24)]+= $result['time']; //～日目の時間を計算

        $subcategory[$result['category']] += $result['time'];
      }
      
      $category = array_fill(0,6,0);
      $i=0;
      foreach($subcategory as $key => $value){
        $category[$i]= $value;
        $i++;
      }
      //DB切断
      $pdo = null;
      
    }
    catch(PDOException $e){
      
      //DB切断
      $pdo = null;
    }
    //json形式に変換
    $json_date = json_encode($date);
    $json_dailyTime = json_encode($dailyTime);
    $json_category = json_encode($category);
    ?>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>

  <div id="tChart" >
    <canvas id="timeChart" style="position: relative;"></canvas>
    <script type="text/javascript">
      //phpからjsへの受け渡し
      let js_date = <?php echo $json_date; ?>;
      let js_dailyTime = <?php echo $json_dailyTime; ?>;

      timeChart(js_dailyTime, js_date);
    </script>
  </div>
  <div id="pChart" >
    <canvas id="pieChart" style="position: relative;"></canvas>
    <script type="text/javascript">
      let js_category = <?php echo $json_category; ?>;

      pieChart(js_category);
    </script>
  </div>

  <p><a href="./front.php">ホーム</a>

  
  </body>
  </html>