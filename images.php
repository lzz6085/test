<?php
require_once './classes/db.php';
$id = isset($_REQUEST['id']) && $_REQUEST['id'] > 0 ? intval($_REQUEST['id']) : 0;

$sql = "select pic from mt.dm where id = $id";

//$ret = mysqli_prepared_query($sql);
$conn = mysqli_connect("127.0.0.1", "root");
$result = $conn->query($sql);
$ret = null;
$ret = $result->fetch_row();
if (empty($ret[0])) {
	header('Location: ./images/portfolio-1t.jpg');
} else {
	header('Content-type: image/jpeg');
	echo isset($ret[0]) ? $ret[0] : '';
}
