<?php

$x = '"';
var_dump(htmlspecialchars($x));
die;

include './classes/db.php';

$sql = 'select User,Host from mysql.user where  1 = ?';
$c = mysqli_init();
$c->real_connect('127.0.0.1', 'root');
$ret = mysqli_prepared_query($c, $sql, array('i', 1));
var_dump($ret);
