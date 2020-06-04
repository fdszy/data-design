<?php
session_start();
if(!isset($_POST['op'])){
    echo "<script language='javascript' type='text/javascript'>window.location.href='./user.php'</script>";
    exit;
}
$mysqli = new mysqli('47.101.211.158','mxy','123456','ticket_system');
$op = $_POST['op'];
if($op === "query"){
    $query = "SELECT i.departure_time, i.arrival_time, f.seat1_total, i.seat1_surplus, f.seat2_total, i.seat2_surplus
        FROM inventory i INNER JOIN flight f
        On i.fNo = f.flightNo
        WHERE i.fNo = ? AND DATE_FORMAT(i.departure_time,'%Y-%m-%d') = ?";
    $results = array();
    if ($stmt = $mysqli->prepare($query)){
        $stmt->bind_param('ss', $_POST['fNo'], $_POST['date']);
        $stmt->execute();
        $stmt->bind_result($de_time,$ar_time,$total_1,$left_1,$total_2,$left_2);    
        $stmt->store_result();
        while ($stmt->fetch()){
            $result = array("fNo"=>$fNo,
                            "de-time"=>$de_time,
                            "ar-time"=>$ar_time,
                            "t-1"=>$total_1,
                            "l-1"=>$left_1,
                            "t-2"=>$total_2,
                            "l-2"=>$left_2);
            array_push($results,$result);
        }
        $_SESSION['admin_query_flight'] = $results;
        echo "<script language='javascript' type='text/javascript'>window.location.href='./admin_plane.php'</script>";
    }
    $mysqli->close();
}
/*else if($op === "black"){
    $query = "UPDATE customer SET credit = -9999.0 WHERE name = ?";
    if ($stmt = $mysqli->prepare($query)){
        $stmt->bind_param('s', $_POST['username']);
        if($stmt->execute()){
            echo "<script>alert('添加成功');</script>";
        }
        else{
            echo "<script>alert('添加失败');</script>";
        }
    }
    $mysqli->close();
    echo "<script language='javascript' type='text/javascript'>window.location.href='./admin_user.php'</script>";
}*/


?>