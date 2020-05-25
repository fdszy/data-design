<?php
header ( "Content-type:text/html;charset=utf-8" ); 
//session_start();

function show_userinfo($username){
    $mysqli = new mysqli('47.101.211.158','mxy','123456','ticket_system');

    $query = "SELECT id,name,balance FROM customer WHERE name = ?";
    if ($stmt = $mysqli->prepare($query)){
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->bind_result($id, $name, $balance);
        $stmt->store_result();

        while ($stmt->fetch()){
            echo '<p class = "col-md-offset-3">用户ID：'.$id.'</p>';
            echo '<p class = "col-md-offset-3">用户名称：'.$name.'</p>';
            echo '<p class = "col-md-offset-3">账户余额：'.$balance.'</p>';
	    }

	    }
    }
}
    
}


?>
