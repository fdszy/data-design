<?php

$userid = $_POST['user'];
$content = $_POST['content'];

if($content === ""){
  echo "<script>alert('不允许发送空白留言！');</script>";
  echo "<script language='javascript' type='text/javascript'>window.location.href='./user.php'</script>";
  exit;
}

$mysqli = new mysqli('47.101.211.158','mxy','123456','ticket_system');

$query = "SELECT name FROM customer WHERE id = ? AND credit < 0.00";
if ($stmt = $mysqli->prepare($query)){
    $stmt->bind_param('s', $userid);
    $stmt->execute(); 
    $stmt->bind_result($t);
    $stmt->store_result();
    if($stmt->num_rows != 0){
      echo "<script>alert('您在黑名单中，无法留言，请联系管理员');</script>";
      echo "<script language='javascript' type='text/javascript'>window.location.href='./user.php'</script>";
      exit;
    }
}

if($_POST['reply'] === 'NULL'){
  $query = "INSERT post (user,content) VALUES (?,?)";
}
else{
  $query = "INSERT post (user,content,reply_id) VALUES (?,?,?)";
}
if ($stmt = $mysqli->prepare($query)){
  if($_POST['reply'] === 'NULL'){
    $stmt->bind_param('ss', $userid, $content);
  }
  else{
    $stmt->bind_param('sss', $userid, $content, $_POST['reply']);
  }
  if($stmt->execute()){
    echo "<script>alert('留言成功，正在跳转...');</script>";
    }
	else{
    echo "<script>alert('留言失败，请重试');</script>";
    }
}
echo "<script language='javascript' type='text/javascript'>window.location.href='./user.php'</script>";
exit;