<?php
header ( "Content-type:text/html;charset=utf-8" ); 

function update_userinfo($username){
    session_start();
    $mysqli = new mysqli('47.101.211.158','mxy','123456','ticket_system');

    $query = "SELECT id,name,balance,credit FROM customer WHERE name = ?";
    if ($stmt = $mysqli->prepare($query)){
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->bind_result($id, $name, $balance, $credit);
        $stmt->store_result();

        while ($stmt->fetch()){
            $_SESSION['user'] = array('name'=>$name,'id'=>$id,'balance'=>$balance,'credit'=>$credit);
	    }
    }
    $mysqli->close();
}

function get_blacklist(){
    $mysqli = new mysqli('47.101.211.158','mxy','123456','ticket_system');

    $query = "SELECT id,name,balance FROM customer WHERE credit < 0.00";
    $results = array();

    if ($stmt = $mysqli->prepare($query)){
        $stmt->execute();
        $stmt->bind_result($id, $name, $balance);
        $stmt->store_result();

        while ($stmt->fetch()){
            $result = array('name'=>$name,'id'=>$id,'balance'=>$balance);
            array_push($results,$result);
        }
        $mysqli->close();
        return $results;
    }
    $mysqli->close();

}

function airport_name_to_id($name, $mysqli){
    $query = "SELECT id FROM airport WHERE name = ?";
    if ($stmt = $mysqli->prepare($query)){
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $stmt->bind_result($id);
        $stmt->store_result();
        if($stmt->num_rows != 1){
            echo "<script>alert('机场名称(".$name.")输入有误!');</script>";
            echo "<script language='javascript' type='text/javascript'>window.location.href='./user.php'</script>";
        }
        $stmt->fetch();
        return $id;
    }
}

function check_if_user_exist($name, $mysqli){
    $query = "SELECT * FROM customer WHERE name = ?";
    if ($stmt = $mysqli->prepare($query)){
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $stmt->bind_result($temp);
        $stmt->store_result();
        if($stmt->num_rows == 1){
            return true;
        }
    }
    return false;
}

function user_id_to_name($id, $mysqli){
    $query = "SELECT name FROM customer WHERE id = ?";
    if ($stmt = $mysqli->prepare($query)){
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $stmt->bind_result($name);
        $stmt->store_result();
        $stmt->fetch();
        return $name;
    }
}

function refresh_message(){
    $mysqli = new mysqli('47.101.211.158','mxy','123456','ticket_system');
    $results = array();
    $query = "SELECT id,user,time,content,reply_id FROM post ORDER BY time DESC";
    if ($stmt = $mysqli->prepare($query)){
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $stmt->bind_result($id, $userid, $time, $content, $reply_id);
        $stmt->store_result();
        while ($stmt->fetch()){
            $user = user_id_to_name($userid, $mysqli);
            $results["$id"] = array("user"=>$user,"time"=>$time,"content"=>$content,"reply"=>$reply_id);
        }
    }
    return $results;
}

function query_user_tickets($id){
    $mysqli = new mysqli('47.101.211.158','mxy','123456','ticket_system');

    $query = "SELECT t.t_fNo,t.t_departure_time,t.seat,c.name 
            FROM ticket t INNER JOIN customer c 
            ON t.passenger_id = c.id
            WHERE t.purchaser_id = ?";

    $query2 = "SELECT i.arrival_time,a.name,? 
            FROM inventory i INNER JOIN airport a
            ON i.departure_airport = a.id
            WHERE fNo = ? and departure_time = ?";

    $query3 = "SELECT arrival_airport FROM flight WHERE flight_No = ?";

    $results = array();
    if ($stmt = $mysqli->prepare($query)){
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $stmt->bind_result($fNo, $de_time, $seat, $pas_name);
        $stmt->store_result();

        while ($stmt->fetch()){

            //通过座位号区分舱位
            if(strpos($seat,'A') === 0){
                $query2 = "SELECT arrival_time,departure_airport,seat1_price
                FROM inventory WHERE fNo = ? and departure_time = ?";
            }
            else{
                $query2 = "SELECT arrival_time,departure_airport,seat2_price
                FROM inventory WHERE fNo = ? and departure_time = ?";
            }

            $stmt2 = $mysqli->prepare($query2);
            $stmt2->bind_param('ss', $fNo, $de_time);
            $stmt2->execute();
            $stmt2->bind_result($ar_time, $departure, $price);
            $stmt2->store_result();
            $stmt2->fetch();

            $stmt3 = $mysqli->prepare($query3);
            $stmt3->bind_param('s', $fNo);
            $stmt3->execute();
            $stmt3->bind_result($arrival);
            $stmt3->store_result();
            $stmt3->fetch();
            
            $result = array('No' => $fNo, 
                            'passenger' => $pas_name, 
                            'departure' => $departure,
                            'de_time' => $de_time,
                            'arrival' => $arrival,
                            'ar_time' => $ar_time,
                            'price' => $price,
                            'seatNo' => $seat
                        );
            array_push($results,$result);
            $stmt2->free_result();
            $stmt3->free_result();           
        }
    }
    $mysqli->close();
    return $results;
}


?>
