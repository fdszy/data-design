<?php
header ( "Content-type:text/html;charset=utf-8" ); 
session_start();

$user = $_POST['username'];

$pwd = $_POST['password'];

$mysqli = new mysqli('47.101.211.158','mxy','123456','ticket_system');

//$sql = "SELECT * FROM user WHERE username = '$user';";

//$result = $mysqli->query($sql);

//$row = $result->fetch_assoc();

$query = "SELECT id,name,balance,pwd_hash,salt FROM customer WHERE name = ?";
if ($stmt = $mysqli->prepare($query))
{
    // 给绑定的变量赋上值
    $stmt->bind_param('s', $user);
 
    // 执行SQL语句
    $stmt->execute();
 
    // 取回全部查询结果
    $stmt->bind_result($id, $name, $balance, $password, $salt);
    $stmt->store_result();

    if($stmt->num_rows == 0){//没有这个用户
		  echo "<script>alert('用户名或密码错误');</script>";
      echo "<script language='javascript' type='text/javascript'>window.location.href='./login.html'</script>";
    }
    while ($stmt->fetch())
    {
        // 逐条从MySQL服务取数据
	    if(md5($pwd+$salt,FALSE) == $password){
		    echo "<script>alert('登陆成功！');</script>";
            $_SESSION['user'] = array('name'=>$name,'id'=>$id,'balance'=>$balance);
            echo "<script language='javascript' type='text/javascript'>window.location.href='./index.php'</script>";
            exit;
	    }
	    else{
        echo "<script>alert('用户名或密码错误');</script>";
        echo "<script language='javascript' type='text/javascript'>window.location.href='./login.html'</script>";
        exit;
	    }
    }

    
}


?>
