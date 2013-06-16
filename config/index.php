<?php 
   $nav = array(
	"地区" => array( "美国", "中国大陆", "香港", "台湾", "日本", "韩国", "英国", "法国", "意大利", "西班牙", "德国", "泰国", "印度", "加拿大", "澳大利亚", "俄罗斯", "波兰", "丹麦", "瑞典", "巴西", "墨西哥", "阿根廷", "比利时", "奥地利"),
        "年代" => array("2013", "2012", "2011", "2010", "2009", "2008", "2007", "2006", "2005","2004","2003","2002","2001","2000","1990s","1980s","1970s"),
	"类型" => array( "剧情", "喜剧", "动作", "爱情", "科幻", "动画", "悬疑", "惊悚", "恐怖", "纪录片", "短片", "情色", "同性", "音乐", "歌舞", "家庭", "儿童", "传记", "历史", "战争", "犯罪", "西部", "奇幻", "冒险", "灾难", "武侠", "古装", "戏曲"),
);


$where = 'pic!=""';

foreach($_REQUEST as $k => $r) {
	if (isset($nav[$k]) && in_array($r, $nav[$k])) {
		$r = str_replace('0s','',$r);
		$where .= " AND xml like '%$r%'";
	}
}
$pageFlip = 40;
$max = 200;
$curr_page = isset($_REQUEST['page']) && $_REQUEST['page'] > 0 ? intval($_REQUEST['page']) : 1;
$sql = "select id,xml from mt.dm where $where limit ". (($curr_page-1) * $pageFlip) .",$pageFlip";
$ret = mysqli_prepared_query($sql);
$list = getMovieList($ret);
