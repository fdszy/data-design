<?php
header ( "Content-type:text/html;charset=utf-8" ); 

$name = $_POST['username'];
$pwd = $_POST['password'];
$confirm = $_POST['confirm'];
$id = $_POST['id'];

if($name === ""){
  echo "<script>alert('用户名不能为空！');</script>";
  echo "<script language='javascript' type='text/javascript'>window.location.href='./sign-up.html'</script>";
  exit;
}

if($confirm === $pwd){

  $mysqli = new mysqli('47.101.211.158','mxy','123456','ticket_system');

  $strs = "QWERTYUIOPASDFGHJKLZXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm";
  $salt = substr(str_shuffle($strs),mt_rand(0,strlen($strs)-11),10);
  $pwd = md5($pwd+$salt,FALSE);

  //康康用户名用过没
  $query = "SELECT id from customer WHERE name = ?";
  if ($stmt = $mysqli->prepare($query)){
    $stmt->bind_param('s',$name);
    $stmt->execute();
    $stmt->bind_result($temp);
    $stmt->store_result();
    if($stmt->num_rows != 0){
      echo "<script>alert('用户名已被使用！');</script>";
      echo "<script language='javascript' type='text/javascript'>window.location.href='./sign-up.html'</script>";
      exit;
    }
  }

  //正常注册
  $query = "INSERT customer (id,name,pwd_hash,salt,balance,credit) VALUES (?,?,?,?,0.00,0.00)";
  if ($stmt = $mysqli->prepare($query)){
    $stmt->bind_param('ssss', $id,$name,$pwd,$salt);
    if($stmt->execute()){
      echo "<script>alert('注册成功，正在跳转到登陆界面...');</script>";
      echo "<script language='javascript' type='text/javascript'>window.location.href='./login.html'</script>";
    }
	  else{
      echo "<script>alert('注册失败，请重试');</script>";
      echo "<script language='javascript' type='text/javascript'>window.location.href='./sign-up.html'</script>";
    }
    exit;
  }
}
else{
  echo "<script>alert('两次输入密码不一致');</script>";
  echo "<script language='javascript' type='text/javascript'>window.location.href='./sign-up.html'</script>";
}
$mysqli->close();
?>
