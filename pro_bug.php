<?php

include 'functions.php';
session_start();
if(!isset($_SESSION['user'])){
    exit;
}

$bug = $_POST['bug'];
$mysqli = new mysqli('47.101.211.158','mxy','123456','ticket_system');

$query = "insert into buginfo (submitter,description,isfixed) values(?,?,'N')";

if ($stmt = $mysqli->prepare($query)){
    $stmt->bind_param('ss',$_SESSION['user']['id'],$bug);
    if($stmt->execute()){
          echo "<script>alert('bug信息提交成功，感谢...');</script>";
          echo "<script language='javascript' type='text/javascript'>window.location.href='./index.php'</script>";

          exit;
        }
    exit;

}

?>
