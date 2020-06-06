<?php

$userid = $_POST['user'];
$content = $_POST['content'];

$mysqli = new mysqli('47.101.211.158','mxy','123456','ticket_system');

$query = "SELECT id FROM post ORDER BY time DESC limit 1";
if ($stmt = $mysqli->prepare($query)){
    $stmt->execute();
    $stmt->bind_result($id);
    $stmt->store_result();
    $stmt->fetch();
}
$id = (string)((int)$id+1);
$query = "INSERT post (id,user,content,reply_id) VALUES (?,?,?,?)";
if ($stmt = $mysqli->prepare($query)){
    $stmt->bind_param('ssss', $id, $userid, $content, $_POST['reply']);
    if($stmt->execute()){
      echo "<script>alert('留言成功，正在跳转...');</script>";
    }
	else{
      echo "<script>alert('留言失败，请重试');</script>";
    }
}
echo "<script language='javascript' type='text/javascript'>window.location.href='./user.php'</script>";
exit;