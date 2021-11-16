function timeChart($dailyTime, $date){
  var ctx = document.getElementById('timeChart').getContext('2d');

  //バーチャート
  //今日の日付までをこっちで取得して、データベースからのデータと合わせる
  var labels = $date;
  var values = $dailyTime;

  var tconfig= {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        label: '時間（分）',
        borderColor: 'rgba(200,0,0,0.1)',
        backgroundColor: 'rgba(200,0,0,0.8)',
        data: values,
      }],
    },
    options: {
      scales: {
        xAxes: [{
              type: 'time',
              time: {
                  unit: 'day'
              }
        }]
      },
      title: {
        display: true,
        text: '一週間の積み重ね時間'
      }
    }
  };

  var myChart = new Chart(ctx, tconfig);
  }



function pieChart($category){
  var ctx = document.getElementById('pieChart').getContext('2d');
  
  //カテゴリーパイチャート
  var labels = ["健康","知見","学習","思考","自己理解","give"];
  var values = $category;

  const data = {
    labels: labels,
    datasets: [{
      label: 'Dataset 1',
      data: values,
      backgroundColor: [
        'rgb(255, 99, 132)',
        'rgb(54, 162, 235)',
        'rgb(255, 205, 86)',
        'rgb(25, 250, 50)',
        'rgb(55, 205, 86)',
        'rgb(50, 50, 230)'
      ]
    }]
  };
  const config = {
    type: 'pie',
    data: data,
    options: {
        title: {
          display: true,
          text: '一週間の積み重ねカテゴリー'
        }
      }
  };
  var myChart = new Chart(ctx, config);
}