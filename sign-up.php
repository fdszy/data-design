<?php
header ( "Content-type:text/html;charset=utf-8" ); 

$name = $_POST['username'];
$pwd = $_POST['password'];
$confirm = $_POST['confirm'];
$id = $_POST['id'];

if($comfirm != $pwd){ // no this user
  echo "<script>alert('两次输入密码不一致');</script>";
  header("Refresh:1;url=sign-up.html");
}

$mysqli = new mysqli('47.101.211.158','mxy','123456','ticket_system');

$salt = substr(str_shuffle("QWERTYUIOPASDFGHJKLZXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm"),mt_rand(0,strlen($strs)-11),10);
$pwd = md5($pwd,$salt);

$query = "INSERT customer (id,name,password,salt,balance) VALUES (?,?,?,?,0.00)";
if ($stmt = $mysqli->prepare($query))
{
    $stmt->bind_param('ssss', $id,$name,$pwd,$salt);
    if($stmt->execute()){
		  echo "<script>alert('注册成功，正在跳转到登陆界面...');</script>";
		  header("Refresh:1;url=login.html");
    }
	  else{
		  echo "<script>alert('注册失败，请重试');</script>";
		  header("Refresh:1;url=sign-in.html");
	  }
}


?>
