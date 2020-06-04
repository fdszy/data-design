<?php
header ( "Content-type:text/html;charset=utf-8" ); 
session_start();

function update_userinfo($username){
    $mysqli = new mysqli('47.101.211.158','mxy','123456','ticket_system');

    $query = "SELECT id,name,balance FROM customer WHERE name = ?";
    if ($stmt = $mysqli->prepare($query)){
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->bind_result($id, $name, $balance);
        $stmt->store_result();

        while ($stmt->fetch()){
            $_SESSION['user'] = array('name'=>$name,'id'=>$id,'balance'=>$balance);
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

    $query3 = "SELECT a.name 
            FROM flight f INNER JOIN airport a
            ON f.arrival_airport = a.id
            WHERE fNo = ?";

    $results = array();
    if ($stmt = $mysqli->prepare($query)){
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $stmt->bind_result($fNo, $de_time, $seat, $pas_name);
        $stmt->store_result();

        while ($stmt->fetch()){
            $stmt2 = $mysqli->prepare($query2);
            //通过座位号区分舱位，未完成
            if(strpos($seat,'A') === 0){
                $type = 'seat1_price';
            }
            else{
                $type = 'seat2_price';
            }

            $stmt2->bind_param('sss', $type, $fNo, $de_time);
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
