<?php
header ( "Content-type:text/html;charset=utf-8" ); 
session_start();

$user = $_POST['username'];

$pwd = $_POST['password'];

$mysqli = new mysqli('47.101.211.158','mxy','123456','ticket_system');

//$sql = "SELECT * FROM user WHERE username = '$user';";

//$result = $mysqli->query($sql);

//$row = $result->fetch_assoc();

$query = "SELECT name,pwd_hash,salt FROM customer WHERE name = ?";
if ($stmt = $mysqli->prepare($query))
{
    // 给绑定的变量赋上值
    $stmt->bind_param('s', $user);
 
    // 执行SQL语句
    $stmt->execute();
 
    // 取回全部查询结果
    $stmt->bind_result($name, $password, $salt);
    $stmt->store_result();

    // 打印提示信息
    $a = 0;
    while ($stmt->fetch())
    {
        // 逐条从MySQL服务取数据
	    $a = 1;
	    if(md5($pwd+$salt,FALSE) == $password){
		    echo "<script>alert('登陆成功！');</script>";
		    $url = "login.html";
		    $_SESSION['user'] = $name;
		    header("Refresh:0.5;url=index.php");
	    }
	    else{
		    echo "<script>alert('用户名或密码错误');</script>";
		    header("Refresh:0.5;url=login.html");
	    }
    }
  if($a == 0){ // no this user
		echo "<script>alert('用户名或密码错误');</script>";
		header("Refresh:0.5;url=login.html");
    }
}


?>
