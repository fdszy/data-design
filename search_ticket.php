<?php
//header("Content-type:text/html;charset=utf-8"); 
session_start();
$cities = array('北京','上海'); //others
$departure = $_POST['departure'];
$arrival = $_POST['arrival'];
$date = $_POST['date']; // 日期

if($departure == $arrival){
  echo "<script>alert('出发地和到达地不能相同！');</script>";
  echo "<script language='javascript' type='text/javascript'>window.location.href='./buy_ticket.php'</script>";
  exit;
}

$mysqli = new mysqli('47.101.211.158','mxy','123456','ticket_system');
$mysqli2 = new mysqli('47.101.211.158','mxy','123456','ticket_system');

$departure_ids = array();
$arrival_ids = array();
$query = "SELECT id FROM airport WHERE city = ?";
if ($stmt = $mysqli->prepare($query)){

    $stmt->bind_param('s', $cities[$departure]);
    $stmt->execute();
    $stmt->bind_result($id);    
    $stmt->store_result();
    while ($stmt->fetch()){
      array_push($departure_ids,$id);
    }
    $stmt->free_result(); 
    $stmt->bind_param('s', $cities[$arrival]);
    $stmt->execute();
    $stmt->store_result();
    while ($stmt->fetch()){
      array_push($arrival_ids,$id);
    }
    $stmt->free_result();
}

$results = array();
$query = "SELECT flight_No FROM flight WHERE departure_airport = ? AND arrival_airport = ?";
$query2 = "SELECT departure_time,arrival_time,seat1_price,seat2_price FROM inventory WHERE fNo = ? AND DATE_FORMAT(departure_time,'%Y-%m-%d') = ?";
if(($stmt = $mysqli->prepare($query)) and ($stmt2 = $mysqli2->prepare($query2))){
  foreach($departure_ids as $start){
    foreach($arrival_ids as $end){
      $result = array();
      $stmt->bind_param('ss', $start, $end);
      $stmt->execute();
      $stmt->bind_result($id);      
      $stmt->store_result();

      while ($stmt->fetch()){
        $stmt2->bind_param('ss', $id, $date);
        $stmt2->execute();
        $stmt2->bind_result($de_time,$ar_time,$price1,$price2);
        $stmt2->store_result();

        while ($stmt2->fetch()){
          $result['flightNo'] = $id;
          $result['departure'] = $start;
          $result['arrival'] = $end;
          $result['de-time'] = $de_time;
          $result['ar-time'] = $ar_time;
          $result['price1'] = $price1;
          $result['price2'] = $price2;          
        }
        array_push($results,$result);
        $stmt2->free_result();
      }
      $stmt->free_result();
    }
  }
  $_SESSION['result_inv'] = $results;
  echo "<script language='javascript' type='text/javascript'>window.location.href='./buy_ticket.php'</script>";
  exit;
}
$mysqli->close();
echo "<script language='javascript' type='text/javascript'>window.location.href='./buy_ticket.php'</script>";
?>
