<?php
   $nav = array(
	"类型" => array( "剧情", "喜剧", "动作", "爱情", "科幻", "动画", "悬疑", "惊悚", "恐怖", "纪录片", "短片", "情色", "同性", "音乐歌舞", "家庭", "儿童", "传记", "历史", "战争", "犯罪", "西部", "奇幻", "冒险", "灾难", "武侠", "古装", "鬼怪运动", "戏曲"),
	"地区" => array( "美国", "中国大陆", "香港", "台湾", "日本", "韩国", "英国", "法国", "意大利", "西班牙", "德国", "泰国", "印度", "加拿大", "澳大利亚", "俄罗斯", "波兰", "丹麦", "瑞典", "巴西", "墨西哥", "阿根廷", "比利时", "奥地利"),
        "年代" => array("2013", "2012", "2011", "2010", "2009", "2008", "2007", "2006", "2001-2005", "1996-2000", "1991-1995"),
);

$params = array();
foreach( $nav as $n => $arr ) {
	$curr = isset($_REQUEST[$n]) && in_array($_REQUEST[$n], $arr) ? $_REQUEST[$n] : '不限';
	$params[$n] = "{$n}={$curr}";
}


foreach( $nav as $n => $arr ) {

	$curr = isset($_REQUEST[$n]) && in_array($_REQUEST[$n], $arr) ? $_REQUEST[$n] : '不限';

        $carr = array_merge(array('不限'), $arr);
	echo "
	<nav class='nav'> 
		<ul>
			<li>$n</li>";
	foreach ($carr as $c) {
		$cstr = $c == $curr ? ' class="current"' : '';
		$p = $params;
		$p[$n] = "{$n}={$c}";
		$pstr = implode("&", $p);
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