<?php

$op = $_GET['option'];
if($op == 'buy'){
    $fNo = $_GET['fNo'];
    
}
elseif($op == 'cancel'){
    $fNo = $_GET['fNo'];
    $passenger = $_GET['passenger'];
    $de_time = $_GET['time'];

    $_SESSION['user']['id'];
    $mysqli = new mysqli('47.101.211.158','mxy','123456','ticket_system');

    $query = "SELECT t.seat,c.id 
              FROM ticket t INNER JOIN customer c 
              ON t.passenger_id = c.id
              WHERE t_fNo = ? AND t_departure_time = ? AND c.name = ?";
    
    $query2 = "SELECT ?,? from inventory WHERE fNo = ? and departure_time = ?";

    $query3 = "DELETE from ticket WHERE t_fNo = ? AND passenger_id = ?";

    $query4 = "UPDATE inventory SET ? = ? WHERE fNo = and departure_time = ?";
 
    $query5 = "UPDATE customer SET balance = ? WHERE id = ?";

    if ($stmt = $mysqli->prepare($query)){
        $stmt->bind_param('ss', $fNo, $de_time, $passenger);
        $stmt->execute();
        $stmt->bind_result($seat, $pas_id);
        $stmt->store_result();
        if($stmt->num_rows != 1){

        }
        $stmt->fetch();
        $stmt->free_result();
        if(strpos($seat,'A') === 0){
            $price = "seat1_price";
            $left = "seat1_surplus";
        }
        else{
            $price = "seat2_price";
            $left = "seat2_surplus";
        }

        $stmt = $mysqli->prepare($query2);
        $stmt->bind_param('ssss',$price,$left,$fNo,$de_time);
        $stmt->execute();
        $stmt->bind_result($money, $num);
        $stmt->store_result();
        $stmt->fetch();

        $stmt = $mysqli->prepare($query3);
        $stmt->bind_param('ss',$fNo,$de_time);
        $stmt->execute();

        $stmt = $mysqli->prepare($query4);
        $stmt->bind_param('siss',$left,$num+1,$fNo,$de_time);
        $stmt->execute();

        $stmt = $mysqli->prepare($query5);
        $stmt->bind_param('ds',$_SESSION['user']['balance']+$money,$_SESSION['user']['id']);
        $stmt->execute();

    }
    $mysqli->close();


}
?>