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
        if(!valid_flightNo($_POST['fNo'])){
            echo "<script>alert('航班号格式不正确！');</script>";
            echo "<script language='javascript' type='text/javascript'>window.location.href='./admin_plane.php'</script>";
            exit;
        }
        $query = "SELECT i.departure_time, i.arrival_time, f.seat1_total, i.seat1_surplus, f.seat2_total, i.seat2_surplus
            FROM inventory i INNER JOIN flight f
            On i.fNo = f.flight_No
            WHERE i.fNo = ? AND DATE_FORMAT(i.departure_time,'%Y-%m-%d') = ?";
        $results = array();
        if ($stmt = $mysqli->prepare($query)){
            $stmt->bind_param('ss', $_POST['fNo'], $_POST['date']);
            $stmt->execute();
            $stmt->bind_result($de_time,$ar_time,$total_1,$left_1,$total_2,$left_2);    
            $stmt->store_result();
            while ($stmt->fetch()){
                $result = array("fNo"=>$_POST['fNo'],
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
            exit;
        }
        $mysqli->close();
        break;

    case "create_flight":
        // 输入检查
        if(!valid_flightNo($_POST['fNo'])){
            echo "<script>alert('航班号格式不正确！');</script>";
            echo "<script language='javascript' type='text/javascript'>window.location.href='./admin_plane.php'</script>";
            exit;
        }
        if(!valid_airport($_POST['departure']) || !valid_airport($_POST['arrival']) || $_POST['departure']===$_POST['arrival']){
            echo "<script>alert('机场格式不正确，或始发终到机场不能相同！');</script>";
            echo "<script language='javascript' type='text/javascript'>window.location.href='./admin_plane.php'</script>";
            exit;
        }
        if($_POST['tran-1'] === 'NULL' && $_POST['tran-2'] != 'NULL'){
            echo "<script>alert('中转机场1为空时，中转机场2不能为空！');</script>";
            echo "<script language='javascript' type='text/javascript'>window.location.href='./admin_plane.php'</script>";
            exit;
        }
        if(!valid_seat_num($_POST['seat1-total']) || !valid_seat_num($_POST['seat2-total'])){
            echo "<script>alert('座位数设置不正确！');</script>";
            echo "<script language='javascript' type='text/javascript'>window.location.href='./admin_plane.php'</script>";
            exit;  
        }
        // 根据中转机场设定情况决定语句
        if($_POST['tran-1'] === 'NULL'){
            $query = "INSERT flight 
                (flight_No,model,airline,seat1_total,seat2_total,departure_airport,arrival_airport) 
                VALUES (?,?,?,?,?,?,?)";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('sssiiss', $_POST['fNo'],$_POST['model'],$_POST['airline'],$_POST['seat1-total'],
                $_POST['seat2-total'],$_POST['departure'],$_POST['arrival']);
        }
        else if($_POST['tran-2'] === 'NULL'){
            $query = "INSERT flight 
                (flight_No,model,airline,seat1_total,seat2_total,departure_airport,transfer_airport1,arrival_airport) 
                VALUES (?,?,?,?,?,?,?,?)";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('sssiisss', $_POST['fNo'],$_POST['model'],$_POST['airline'],$_POST['seat1-total'],
                $_POST['seat2-total'],$_POST['departure'],$_POST['tran-1'],$_POST['arrival']);
        }
        else{
            $query = "INSERT flight 
                (flight_No,model,airline,seat1_total,seat2_total,departure_airport,transfer_airport1,transfer_airport2,arrival_airport) 
                VALUES (?,?,?,?,?,?,?,?,?)";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('sssiissss', $_POST['fNo'],$_POST['model'],$_POST['airline'],$_POST['seat1-total'],
                $_POST['seat2-total'],$_POST['departure'],$_POST['tran-1'],$_POST['tran-2'],$_POST['arrival']);
        }
        if($stmt->execute()){
            echo "<script>alert('添加成功!');</script>";
        }
        else{
            echo "<script>alert('添加失败');</script>";
        }
        
        echo "<script language='javascript' type='text/javascript'>window.location.href='./admin_plane.php'</script>";
        break;

    case "create_inventory":

        if(!valid_flightNo($_POST['fNo'])){
            echo "<script>alert('航班号格式不正确！');</script>";
            echo "<script language='javascript' type='text/javascript'>window.location.href='./admin_plane.php'</script>";
            exit;
        }
        if(!valid_time($_POST['de-time']) || !valid_time($_POST['ar-time'])){
            echo "<script>alert('出发或到达时间格式不正确！');</script>";
            echo "<script language='javascript' type='text/javascript'>window.location.href='./admin_plane.php'</script>";
            exit;
        }
        if(strtotime($_POST['de-time']) > strtotime($_POST['ar-time'])){
            echo "<script>alert('到达时间必须晚于出发时间！');</script>";
            echo "<script language='javascript' type='text/javascript'>window.location.href='./admin_plane.php'</script>";
            exit;
        }
        if(!valid_airport($_POST['departure'])){
            echo "<script>alert('机场格式不正确，或始发终到机场不能相同！');</script>";
            echo "<script language='javascript' type='text/javascript'>window.location.href='./admin_plane.php'</script>";
            exit;
        }  
        $query = "SELECT seat1_total, seat2_total FROM flight WHERE flight_No = ?";
        if ($stmt = $mysqli->prepare($query)){
            $stmt->bind_param('s', $_POST['fNo']);
            $stmt->execute();
            $stmt->bind_result($total_1,$total_2);    
            $stmt->store_result();
            if($stmt->num_rows != 1){
                echo "<script>alert('该航班号的航线不存在！');</script>";
                echo "<script language='javascript' type='text/javascript'>window.location.href='./admin_plane.php'</script>";
            }
            $stmt->fetch();
        }
    
        $query = "INSERT inventory (fNo,departure_time,departure_airport,arrival_time,seat1_surplus,seat2_surplus,seat1_price,seat2_price)
                    VALUES (?,?,?,?,?,?,?,?)";
        if ($stmt = $mysqli->prepare($query)){
            $stmt->bind_param('ssssiidd', $_POST['fNo'],$_POST['de-time'],$_POST['departure'],$_POST['ar-time'],
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
    
    case "modify_flight":
        // 与添加航线基本相同
        if(!valid_flightNo($_POST['fNo'])){
            echo "<script>alert('航班号格式不正确！');</script>";
            echo "<script language='javascript' type='text/javascript'>window.location.href='./admin_plane.php'</script>";
            exit;
        }
        if(!valid_airport($_POST['departure']) || !valid_airport($_POST['arrival']) || $_POST['departure']===$_POST['arrival']){
            echo "<script>alert('机场格式不正确，或始发终到机场不能相同！');</script>";
            echo "<script language='javascript' type='text/javascript'>window.location.href='./admin_plane.php'</script>";
            exit;
        }
        if($_POST['tran-1'] === 'NULL' && $_POST['tran-2'] != 'NULL'){
            echo "<script>alert('中转机场1为空时，中转机场2不能为空！');</script>";
            echo "<script language='javascript' type='text/javascript'>window.location.href='./admin_plane.php'</script>";
            exit;
        }
        if(!valid_seat_num($_POST['seat1-total']) || !valid_seat_num($_POST['seat2-total'])){
            echo "<script>alert('座位数设置不正确！');</script>";
            echo "<script language='javascript' type='text/javascript'>window.location.href='./admin_plane.php'</script>";
            exit;  
        }

        if($_POST['tran-1'] === 'NULL'){
            $query = "UPDATE flight SET model = ?,airline = ?,seat1_total = ?,seat2_total = ?,
                departure_airport = ?,arrival_airport = ?
                WHERE flight_No = ?";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('ssiisss', $_POST['model'],$_POST['airline'],$_POST['seat1-total'],$_POST['seat2-total'],
                $_POST['departure'],$_POST['arrival'], $_POST['fNo']);
        }
        elseif($_POST['tran-2'] === 'NULL'){
            $query = "UPDATE flight SET model = ?,airline = ?,seat1_total = ?,seat2_total = ?,
                departure_airport = ?,arrival_airport = ?,transfer_airport1 = ?
                WHERE flight_No = ?";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('ssiissss', $_POST['model'],$_POST['airline'],$_POST['seat1-total'],$_POST['seat2-total'],
                $_POST['departure'],$_POST['tran-1'],$_POST['arrival'], $_POST['fNo']);
        }
        else{
            $query = "UPDATE flight SET model = ?,airline = ?,seat1_total = ?,seat2_total = ?,
                departure_airport = ?,arrival_airport = ?,transfer_airport1 = ?,transfer_airport2 = ? 
                WHERE flight_No = ?";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('ssiisssss', $_POST['model'],$_POST['airline'],$_POST['seat1-total'],$_POST['seat2-total'],
                $_POST['departure'],$_POST['tran-1'],$_POST['tran-2'],$_POST['arrival'], $_POST['fNo']);
        }
        if($stmt->execute()){
            echo "<script>alert('修改成功!');</script>";
        }
        else{
            echo "<script>alert('修改失败');</script>";
        }  
        echo "<script language='javascript' type='text/javascript'>window.location.href='./admin_plane.php'</script>";
        break;

    case "modify_price":
        if(!valid_flightNo($_POST['fNo'])){
            echo "<script>alert('航班号格式不正确！');</script>";
            echo "<script language='javascript' type='text/javascript'>window.location.href='./admin_plane.php'</script>";
            exit;
        }
        if(!valid_time($_POST['de-time'])){
            echo "<script>alert('出发或到达时间格式不正确！');</script>";
            echo "<script language='javascript' type='text/javascript'>window.location.href='./admin_plane.php'</script>";
            exit;
        }
        $query = "SELECT arrival_time FROM inventory WHERE t_fNo = ? AND t_departure_time = ?";
        if ($stmt = $mysqli->prepare($query)){
            $stmt->bind_param('ss', $_POST['fNo'], $_POST['de-time']);
            $stmt->execute();
            $stmt->bind_result($temp);    
            $stmt->store_result();
            if($stmt->num_rows == 0){
                echo "<script>alert('该航班不存在！');</script>";
                echo "<script language='javascript' type='text/javascript'>window.location.href='./admin_plane.php'</script>";
                exit;
            }
        }
        $query = "UPDATE inventory SET seat1_price = ?,seat2_price = ? WHERE fNo = ? AND departure_time = ?";
        if ($stmt = $mysqli->prepare($query)){
            $stmt->bind_param('ddss', $_POST['price1'], $_POST['price2'], $_POST['fNo'], $_POST['de-time']);
            if($stmt->execute()){
                echo "<script>alert('修改成功!');</script>";
            }
            else{
                echo "<script>alert('修改失败');</script>";
            }
            echo "<script language='javascript' type='text/javascript'>window.location.href='./admin_plane.php'</script>";
            exit;
        }
        break;

    case "delete_flight":
        if(!valid_flightNo($_POST['fNo'])){
            echo "<script>alert('航班号格式不正确！');</script>";
            echo "<script language='javascript' type='text/javascript'>window.location.href='./admin_plane.php'</script>";
            exit;
        }
        $query = "SELECT model FROM flight WHERE flight_No = ?";
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
        $query = "DELETE FROM flight WHERE flight_No = ?";
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
        if(!valid_flightNo($_POST['fNo'])){
            echo "<script>alert('航班号格式不正确！');</script>";
            echo "<script language='javascript' type='text/javascript'>window.location.href='./admin_plane.php'</script>";
            exit;
        }
        if(!valid_time($_POST['de-time'])){
            echo "<script>alert('出发时间格式不正确！');</script>";
            echo "<script language='javascript' type='text/javascript'>window.location.href='./admin_plane.php'</script>";
            exit;
        }  
        $query = "SELECT passenger_id FROM ticket WHERE t_fNo = ? AND t_departure_time = ?";
        if ($stmt = $mysqli->prepare($query)){
            $stmt->bind_param('ss', $_POST['fNo'], $_POST['de-time']);
            $stmt->execute();
            $stmt->bind_result($temp);    
            $stmt->store_result();
            if($stmt->num_rows != 0){
                echo "<script>alert('该航班存在已售出的票，请先联系顾客进行退票处理！');</script>";
                echo "<script language='javascript' type='text/javascript'>window.location.href='./admin_plane.php'</script>";
                exit;
            }
        }
        $query = "DELETE FROM inventory WHERE fNo = ? AND departure_time = ?";
        if ($stmt = $mysqli->prepare($query)){
            $stmt->bind_param('ss', $_POST['fNo'], $_POST['de-time']);
            if($stmt->execute()){
                echo "<script>alert('删除成功!');</script>";
            }
            else{
                echo "<script>alert('删除失败');</script>";
            }
            echo "<script language='javascript' type='text/javascript'>window.location.href='./admin_plane.php'</script>";
            exit;
        }

}
echo "<script>alert('无效操作');</script>";
echo "<script language='javascript' type='text/javascript'>window.location.href='./admin_plane.php'</script>";

?>