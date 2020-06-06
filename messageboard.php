<?php

$userid = $_POST['user'];
$content = $_POST['content'];

$mysqli = new mysqli('47.101.211.158','mxy','123456','ticket_system');

$query = "SELECT id FROM customer WHERE credit < 0.00";
if ($stmt = $mysqli->prepare($query)){
    $stmt->execute();
    $stmt->bind_result($id);
    $stmt->store_result();
    while($stmt->fetch()){
      if($userid === $id){
        echo "<script>alert('您在黑名单中，无法留言，请联系管理员');</script>";
        echo "<script language='javascript' type='text/javascript'>window.location.href='./user.php'</script>";
        exit;
      }
    }
}

$query = "SELECT id FROM post ORDER BY time DESC limit 1";
if ($stmt = $mysqli->prepare($query)){
    $stmt->execute();
    $stmt->bind_result($id);
    $stmt->store_result();
    $stmt->fetch();
}

$id = (string)((int)$id+1);
if($_POST['reply'] === 'NULL'){
  $query = "INSERT post (id,user,content) VALUES (?,?,?)";
}
else{
  $query = "INSERT post (id,user,content,reply_id) VALUES (?,?,?,?)";
}
if ($stmt = $mysqli->prepare($query)){
  if($_POST['reply'] === 'NULL'){
    $stmt->bind_param('sss', $id, $userid, $content);
  }
  else{
    $stmt->bind_param('ssss', $id, $userid, $content, $_POST['reply']);
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