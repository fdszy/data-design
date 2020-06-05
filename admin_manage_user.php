<?php
session_start();
if(!isset($_POST['op'])){
    echo "<script language='javascript' type='text/javascript'>window.location.href='./user.php'</script>";
    exit;
}

$mysqli = new mysqli('47.101.211.158','mxy','123456','ticket_system');
$op = $_POST['op'];
if($op === "query"){
    $query = "SELECT id,name,balance FROM customer WHERE name = ?";
    if ($stmt = $mysqli->prepare($query)){
        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
        echo "<script>alert('".$stmt->num_rows."');</script>"; // 测试使用
        $stmt->bind_result($id, $name, $balance);    
        $stmt->store_result();
        while ($stmt->fetch()){
            $_SESSION['admin_query_user'] = array('name'=>$name,'id'=>$id,'balance'=>$balance);
        }
        echo "<script language='javascript' type='text/javascript'>window.location.href='./admin_user.php'</script>";
    }
    $mysqli->close();

}
else if($op === "black"){
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
}


?>