<?php

$params = array();
foreach( $nav as $n => $arr ) {
	$curr = isset($_REQUEST[$n]) && in_array($_REQUEST[$n], $arr) ? $_REQUEST[$n] : '不限';
	$params[$n] = "{$n}={$curr}";
}


foreach( $nav as $n => $arr ) {

    $carr = array_merge(array('不限'), $arr, array('其他'));
	$curr = isset($_REQUEST[$n]) && in_array($_REQUEST[$n], $carr) ? $_REQUEST[$n] : '不限';
	echo "
	<nav class='nav'> 
		<ul>
			<li>$n</li>";
	foreach ($carr as $c) {
		$cstr = $c == $curr ? ' class="current"' : '';
		$p = $params;
		$p[$n] = "{$n}={$c}";
		$pstr = htmlspecialchars(implode("&", $p));
		echo  "
			<li $cstr>
				<a href='?$pstr'>$c</a>
			</li>";
	}
	echo "
		</ul>
	</nav> ";
}


?>

<hr />
