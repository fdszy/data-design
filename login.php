<?php
header ( "Content-type:text/html;charset=utf-8" ); 
session_start();

$user = $_POST['username'];
$pwd = $_POST['password'];

$mysqli = new mysqli('47.101.211.158','mxy','123456','ticket_system');

$query = "SELECT id,name,balance,pwd_hash,salt,credit FROM customer WHERE name = ?";
if ($stmt = $mysqli->prepare($query)){
    $stmt->bind_param('s', $user);
    $stmt->execute();
    $stmt->bind_result($id, $name, $balance, $password, $salt, $credit);
    $stmt->store_result();

    if($stmt->num_rows == 0){//没有这个用户
	  echo "<script>alert('用户名或密码错误');</script>";
      echo "<script language='javascript' type='text/javascript'>window.location.href='./login.html'</script>";
    }
    while ($stmt->fetch()){
	    if(md5($pwd.$salt,FALSE) == $password){
            $_SESSION['user'] = array('name'=>$name,'id'=>$id,'balance'=>$balance,'credit'=>$credit);
            if($name === 'admin'){
                echo "<script language='javascript' type='text/javascript'>window.location.href='./admin_user.php'</script>";
            }
            else{
                echo "<script language='javascript' type='text/javascript'>window.location.href='./index.php'</script>";
            } 
            exit;
	    }
	    else{
            echo "<script>alert('用户名或密码错误');</script>";
            echo "<script language='javascript' type='text/javascript'>window.location.href='./login.html'</script>";
            exit;
	    }
    }  
}
$mysqli->close();

?>
