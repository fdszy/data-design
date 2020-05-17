<?php

session_start();

$user = $_POST['username'];

$pwd = $_POST['password'];

$mysqli = new mysqli('47.101.211.158','mxy','123456','ticket_system_test');

//$sql = "SELECT * FROM user WHERE username = '$user';";

//$result = $mysqli->query($sql);

//$row = $result->fetch_assoc();

$query = "SELECT * FROM user WHERE username = ?";
if ($stmt = $mysqli->prepare($query))
{
    // 处理打算执行的SQL命令
    $stmt->bind_param('s', $user);
 
    // 给绑定的变量赋上值
    $stmt->execute();
 
    // 执行SQL语句
    $stmt->store_result();
 
    // 取回全部查询结果
    $stmt->bind_result($username, $password);
 
    // 打印提示信息
    $a = 0;
    while ($stmt->fetch())
    {
        // 逐条从MySQL服务取数据
	$a = 1;
	if($pwd == $password){
		echo "<script>alert('登陆成功！');</script>";
		$url = "login.html";
		$_SESSION['user'] = $username;
		header("Refresh:1;url=index.php");
	}
	else{
		echo "<script>alert('用户名或密码错误');</script>";
		header("Refresh:1;url=login.html");
	}
    }
    if($a == 0){ // no this user
		echo "<script>alert('用户名或密码错误');</script>";
		header("Refresh:1;url=login.html");
    }
}


?>
