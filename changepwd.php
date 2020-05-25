<?php
session_start();
if(!isset($_SESSION['user'])){
    exit;
}
$oldpwd = $_POST['oldpwd'];

$mysqli = new mysqli('47.101.211.158','mxy','123456','ticket_system');
$query = "SELECT pwd_hash,salt FROM customer WHERE name = ?";
if ($stmt = $mysqli->prepare($query)){
    $stmt->bind_param('s', $_SESSION['user']);
    $stmt->execute();
    $stmt->bind_result($pwd, $salt);
    $stmt->store_result();
    while ($stmt->fetch()){
        if(md5($oldpwd+$salt,FALSE) != $pwd){
            echo "<script>alert('旧密码错误');</script>";
            echo "<script language='javascript' type='text/javascript'>window.location.href='./user.php'</script>";
            exit;
        }
    }
}

$newpwd = $_POST['newpwd'];
$confirm = $_POST['confirm'];
if($confirm != $newpwd){
    echo "<script>alert('两次输入密码不一致！');</script>";
    echo "<script language='javascript' type='text/javascript'>window.location.href='./user.php'</script>";
    exit;
}

$query = "UPDATE customer SET pwd_hash = ? WHERE name = ?";
if ($stmt = $mysqli->prepare($query)){
  $stmt->bind_param('ss', md5($newpwd+$salt,FALSE),$name);
  if($stmt->execute()){
    echo "<script>alert('修改成功！');</script>";
    echo "<script language='javascript' type='text/javascript'>window.location.href='./user.php'</script>";
  }
  else{
    echo "<script>alert('修改失败，请重试');</script>";
    echo "<script language='javascript' type='text/javascript'>window.location.href='./user.php'</script>";
  }
  exit;
}

?>