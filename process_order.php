<?php
include 'functions.php';

$mysqli = new mysqli('47.101.211.158','mxy','123456','ticket_system');
$op = $_REQUEST['option'];

if($op == 'buy'){
    $fNo = $_POST['fNo'];
    $seat = $_POST['seat'];    
    $passenger = $_POST['passenger'];
    $pas_id = $_POST['passenger_id'];
    $de_time = $_POST['time'];

    if($seat == '1'){
        $query = "SELECT seat1_price,seat1_surplus,seat1_total from inventory i INNER JOIN flight f
            ON i.fNo =  f.flight_No
            WHERE i.fNo = ? AND i.departure_time = ?";
        $query3 = "UPDATE inventory SET seat1_surplus = ? WHERE fNo = ? AND departure_time = ?";
        $price = "seat1_price";
        $left = "seat1_surplus";
        $total = "seat1_total";
        $a = 'A';
    }
    else{
        $query = "SELECT seat2_price,seat2_surplus,seat2_total from inventory i INNER JOIN flight f
            ON i.fNo =  f.flight_No
            WHERE i.fNo = ? AND i.departure_time = ?";
        $query3 = "UPDATE inventory SET seat2_surplus = ? WHERE fNo = ? AND departure_time = ?";
        $price = "seat2_price";
        $left = "seat2_surplus";
        $total = "seat2_total";
        $a = 'B';
    }

    $query2 = "INSERT ticket (t_fNo,t_departure_time,passenger_id,purchaser_id,seat) VALUES (?,?,?,?,?)";
 
    $query4 = "UPDATE customer SET balance = balance - ? WHERE id = ?";

    if ($stmt = $mysqli->prepare($query)){
        $stmt->bind_param('ss', $fNo, $de_time);
        $stmt->execute();
        $stmt->bind_result($pay, $seat_left, $seat_total);
        $stmt->store_result();
        $stmt->fetch();
        if($seat_left == 0){
            echo "<script>alert('该航班该舱位已无余票！');</script>";
            echo "<script language='javascript' type='text/javascript'>window.location.href='./buy_ticket.php'</script>";
        }
        $stmt->free_result();

        $seat_No = $a.strval($seat_total-$seat_left+1);

        $stmt = $mysqli->prepare($query2);
        $stmt->bind_param('sssss',$fNo,$de_time,$pas_id,$_SESSION['user']['id'],$seat_No);
        $stmt->execute();

        $seat_left = $seat_left-1;
        $stmt = $mysqli->prepare($query3);
        $stmt->bind_param('iss',$seat_left,$fNo,$de_time);
        $stmt->execute();

        $stmt = $mysqli->prepare($query4);
        $stmt->bind_param('ds',$pay,$_SESSION['user']['id']);
        $stmt->execute();

        update_userinfo($_SESSION['user']['name']);
        echo "<script>alert('购买成功，正在转到订单页面');</script>";
        echo "<script language='javascript' type='text/javascript'>window.location.href='./ticket.php'</script>";
    }


}
elseif($op == 'cancel'){
    $fNo = $_GET['fNo'];
    $passenger = $_GET['passenger'];
    $de_time = $_GET['time'];

    $query = "SELECT t.seat,c.id 
              FROM ticket t INNER JOIN customer c 
              ON t.passenger_id = c.id
              WHERE t_fNo = ? AND t_departure_time = ? AND c.name = ?";
    
    $query2 = "SELECT ?,? from inventory WHERE fNo = ? AND departure_time = ?";

    $query3 = "DELETE from ticket WHERE t_fNo = ? AND passenger_id = ?";

    $query4 = "UPDATE inventory SET ? = ? WHERE fNo = AND departure_time = ?";
 
    $query5 = "UPDATE customer SET balance = balance + ? WHERE id = ?";

    if ($stmt = $mysqli->prepare($query)){
        $stmt->bind_param('ss', $fNo, $de_time, $passenger);
        $stmt->execute();
        $stmt->bind_result($seat, $pas_id);
        $stmt->store_result();
        if($stmt->num_rows != 1){
            echo "<script>alert('未知错误！');</script>";
            echo "<script language='javascript' type='text/javascript'>window.location.href='./buy_ticket.php'</script>";
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
        $stmt->bind_result($pay, $seat_left);
        $stmt->store_result();
        $stmt->fetch();

        $stmt = $mysqli->prepare($query3);
        $stmt->bind_param('ss',$fNo,$de_time);
        $stmt->execute();

        $seat_left = $seat_left+1;
        $stmt = $mysqli->prepare($query4);
        $stmt->bind_param('siss',$left,$seat_left+1,$fNo,$de_time);
        $stmt->execute();

        $stmt = $mysqli->prepare($query5);
        $stmt->bind_param('ds',$pay,$_SESSION['user']['id']);
        $stmt->execute();

        update_userinfo($_SESSION['user']['name']);
        echo "<script>alert('退票成功，正在转到订单页面');</script>";
        echo "<script language='javascript' type='text/javascript'>window.location.href='./ticket.php'</script>";

    }
    $mysqli->close();


}
?>