<?php
header ( "Content-type:text/html;charset=utf-8" ); 

$name = $_POST['username'];
$pwd = $_POST['password'];
$confirm = $_POST['confirm'];
$id = $_POST['id'];

if($confirm == $pwd){

  $mysqli = new mysqli('47.101.211.158','mxy','123456','ticket_system');

  $strs = "QWERTYUIOPASDFGHJKLZXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm";
  $salt = substr(str_shuffle($strs),mt_rand(0,strlen($strs)-11),10);
  $pwd = md5($pwd+$salt,FALSE);

  $query = "INSERT customer (id,name,pwd_hash,salt,balance) VALUES (?,?,?,?,0.00)";
  if ($stmt = $mysqli->prepare($query)){
    $stmt->bind_param('ssss', $id,$name,$pwd,$salt);
    if($stmt->execute()){
      echo "<script>alert('注册成功，正在跳转到登陆界面...');</script>";
      echo '<meta http-equiv="refresh" content="0.5;url=login.html>';
    }
	  else{
      echo "<script>alert('注册失败，请重试');</script>";
      echo '<meta http-equiv="refresh" content="0.5;url=sign-up.html>';
    }
    exit;
  }
}
else{
  echo "<script>alert('两次输入密码不一致');</script>";
  echo '<meta http-equiv="refresh" content="0.5;url=sign-up.html>';  
}

?>
