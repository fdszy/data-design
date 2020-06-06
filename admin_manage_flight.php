<?php
include 'functions.php';
session_start();
if(!isset($_POST['op'])){
    echo "<script language='javascript' type='text/javascript'>window.location.href='./user.php'</script>";
    exit;
}
$mysqli = new mysqli('47.101.211.158','mxy','123456','ticket_system');

switch($_POST['op']){
    case "query":

        $query = "SELECT i.departure_time, i.arrival_time, f.seat1_total, i.seat1_surplus, f.seat2_total, i.seat2_surplus
            FROM inventory i INNER JOIN flight f
            On i.fNo = f.flightNo
            WHERE i.fNo = ? AND DATE_FORMAT(i.departure_time,'%Y-%m-%d') = ?";
        $results = array();
        if ($stmt = $mysqli->prepare($query)){
            echo "sssbupa";
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
            var_dump($_SESSION['admin_query_flight']);
            echo "<script language='javascript' type='text/javascript'>window.location.href='./admin_plane.php'</script>";
            exit;
        }
        else{
            echo "ssszhuaba";
        }
        $mysqli->close();
        break;

    case "create_flight":
        //存放的是机场id,先进行转换
        $_POST['departure'] = airport_name_to_id($_POST['departure'],$mysqli);
        $_POST['arrival'] = airport_name_to_id($_POST['arrival'],$mysqli);
        if($_POST['tran-1'] != NULL){
            $_POST['tran-1'] = airport_name_to_id($_POST['tran-1'],$mysqli);
        }
        if($_POST['tran-2'] != NULL){
            $_POST['tran-2'] = airport_name_to_id($_POST['tran-2'],$mysqli);
        }

        $query = "INSERT flight (flight_No,model,airline,seat1_total,seat2_total,departure_airport,transfer_airport1,transfer_airport2,arrival_airport)
                    VALUES (?,?,?,?,?,?,?,?,?)";
        if ($stmt = $mysqli->prepare($query)){
            $stmt->bind_param('sssiisssss', $_POST['fNo'],$_POST['model'],$_POST['airline'],$_POST['seat1-total'],$_POST['seat2-total'],
                                        $_POST['departure'],$_POST['tran-1'],$_POST['tran-2'],$_POST['arrival']);
            if($stmt->execute()){
                echo "<script>alert('添加成功!');</script>";
            }
            else{
                echo "<script>alert('添加失败');</script>";
            }
        }
        echo "<script language='javascript' type='text/javascript'>window.location.href='./admin_plane.php'</script>";
        exit;
        break;

    case "create_inventory":
        //同上
        $_POST['departure'] = airport_name_to_id($_POST['departure'],$mysqli);

        $query = "SELECT seat1_total, seat2_total FROM flight WHERE flight_No = ?";

        if ($stmt = $mysqli->prepare($query)){
            $stmt->bind_param('s', $_POST['fNo']);
            $stmt->execute();
            $stmt->bind_result($total_1,$total_2);    
            $stmt->store_result();
            if($stmt->num_rows != 1){
                echo "<script>alert('航班号输入有误!');</script>";
                echo "<script language='javascript' type='text/javascript'>window.location.href='./admin_plane.php'</script>";
            }
            $stmt->fetch();
        }
    
        $query = "INSERT inventory (fNo,departure_time,departure_airport,arrival_time,seat1_surplus,seat2_surplus,seat1_price,seat2_price)
                    VALUES (?,?,?,?,?,?,?,?,?)";
        if ($stmt = $mysqli->prepare($query)){
            $stmt->bind_param('ssssiiff', $_POST['fNo'],$_POST['de-time'],$_POST['departure'],$_POST['ar-time'],
                            $total_1,$total_2,$_POST['price1'],$_POST['price2']);
            if($stmt->execute()){
                echo "<script>alert('添加成功!');</script>";
            }
            else{
                echo "<script>alert('添加失败');</script>";
            }
        }
        echo "<script language='javascript' type='text/javascript'>window.location.href='./admin_plane.php'</script>";
        break;
    
    case "delete-flight":
        
        $query = "SELECT departure_time FROM inventory WHERE fNo = ?";
        if ($stmt = $mysqli->prepare($query)){
            $stmt->bind_param('s', $_POST['fNo']);
            $stmt->execute();
            $stmt->bind_result($temp);    
            $stmt->store_result();
            if($stmt->num_rows != 0){
                echo "<script>alert('该航线还有对应的航班未删除，请先删除航班');</script>";
                echo "<script language='javascript' type='text/javascript'>window.location.href='./admin_plane.php'</script>";
                exit;
            }
        }

        $query = "SELECT model FROM flight WHERE fNo = ?";
        if ($stmt = $mysqli->prepare($query)){
            $stmt->bind_param('s', $_POST['fNo']);
            $stmt->execute();
            $stmt->bind_result($temp);    
            $stmt->store_result();
            if($stmt->num_rows == 0){
                echo "<script>alert('航线不存在！');</script>";
                echo "<script language='javascript' type='text/javascript'>window.location.href='./admin_plane.php'</script>";
                exit;
            }
        }

        $query = "DELETE flight WHERE fNo = ?";
        if ($stmt = $mysqli->prepare($query)){
            $stmt->bind_param('s', $_POST['fNo']);
            if($stmt->execute()){
                echo "<script>alert('删除成功!');</script>";
            }
            else{
                echo "<script>alert('删除失败');</script>";
            }
            echo "<script language='javascript' type='text/javascript'>window.location.href='./admin_plane.php'</script>";
            exit;
        }
        break;
    
    case "delete_inventory":

}
echo "<script language='javascript' type='text/javascript'>window.location.href='./admin_plane.php'</script>";

?>