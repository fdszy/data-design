<?php
session_start();
if(!isset($_SESSION['user'])){
    exit;
}


$money = $_POST['money'];


$mysqli = new mysqli('47.101.211.158','mxy','123456','ticket_system');

$query = "UPDATE customer SET balance = ? WHERE id = ?";

if ($stmt = $mysqli->prepare($query)){
    $stmt->bind_param('ds', ((double)$money+(double)$_SESSION['user']['balance']), $_SESSION['user']['id']);
    if($stmt->execute()){
          echo "<script>alert('充值成功，正在跳转购票页面...');</script>";
          echo "<script language='javascript' type='text/javascript'>window.location.href='./buy_ticket.php'</script>";
          update_userinfo($_SESSION['user']['name']);
          exit;
        }
}
?>