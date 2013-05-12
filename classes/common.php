<?php

function getUrl($cur) {
	$req = $_REQUEST;
	unset($req[$cur]);
	foreach ($req as $k => &$v) {
		$v = "$k=$v";
	}
	return '?' . implode('&', $req);
}
