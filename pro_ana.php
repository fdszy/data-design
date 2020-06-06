<?php
header ( "Content-type:text/html;charset=utf-8" );

$dbconf = array(
    'host' => '47.101.211.158',
    'user' => 'mxy',
    'password' => '123456',
    'dbName' => 'ticket_system',
    'port' => '3306'
);

function openDb($dbConf){
    $conn=mysqli_connect($dbConf['host'],$dbConf['user'],$dbConf['password'],$dbConf['dbName'],$dbConf['port']) or die('打开失败');
    return $conn;
}

$conn = openDb($dbconf);

$sql = 'select COUNT(*) flight_count from inventory group by MONTH(departure_time)';

$rs = $conn->query($sql);

$data = array();

while($tmp = mysqli_fetch_assoc($rs)){
    $data[] = $tmp;
}

echo json_encode($data);