<?php
header ( "Content-type:text/html;charset=utf-8" ); 
session_start();
$cities = array('北京','上海') //others
$departure = $_POST['departure'];
$arrival = $_POST['arrival'];
$type = $_POST['type']; // 1 头等舱， 2 经济舱

if($departure == $arrival){
  echo "<script>alert('出发地和到达地不能相同！');</script>";
  header("Refresh:0.5;url=buy_ticket.php");
  exit();
}

$mysqli = new mysqli('47.101.211.158','mxy','123456','ticket_system');

$departure_ids = array();
$arrival_ids = array();
$query = "SELECT id FROM airport WHERE city = ?";
if ($stmt = $mysqli->prepare($query)){

    $stmt->bind_param('s', $cities[$departure]);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id);
    while ($stmt->fetch()){
      array_push($departure_ids,$id)
    }
    $stmt->free_result();
  
    $stmt->bind_param('s', $cities[$arrival]);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id);
    while ($stmt->fetch()){
      array_push($arrival_ids,$id)
    }
    $stmt->free_result();
}

$correct_flight = array();
$query = "SELECT flight_No, FROM flight WHERE departure_airport = ? AND arrival_airport = ?";
$query2 = "SELECT departure_time,seat1_price,seat2_price from inventory "
if ($stmt = $mysqli->prepare($query)){
  foreach($departure_ids as $start){
    foreach($arrival_ids as $end){
      $stmt->bind_param('ss', $start, $end);
      $stmt->execute();
      $stmt->store_result();
      $stmt->bind_result($id);
      while ($stmt->fetch()){
        array_push($correct_flight,$id)
      }
      $stmt->free_result();
    }
  }

  
}


?>
