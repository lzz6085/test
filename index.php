<?php
require_once './classes/common.php';
require_once './classes/db.php';
include("./config/index.php");

$title = '';
$description = '';
$keywords = '';
foreach($_REQUEST as $k => $r) {
	if (isset($nav[$k]) && in_array($r, $nav[$k])) {
		$title .= "$r ";
		$description .= "$r ";
		$keywords .= "$r,";
	}
}

include("./header.php");
include("./nav.php");
include("./main.php");
include("./footer.php");
