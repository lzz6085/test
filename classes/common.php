<?php

function getUrl($cur) {
	$req = $_REQUEST;
	unset($req[$cur]);
	foreach ($req as $k => &$v) {
		$v = "$k=$v";
	}
	return '?' . htmlspecialchars(implode('&', $req));
}

function getMovieList($ret)
{
	$list = array();
	foreach ($ret as $r) {
		$m = array();
		$json = json_decode($r['xml'], true);
		$m['title_show'] = $m['title'] = isset($json['alt_title']) && $json['alt_title'] != '' ? $json['alt_title'] : (isset($json['title']) ? $json['title'] : '');
		$m['id'] = $r['id'];
		$s = strtr($m['title'], array("'" => ' ', '／'=>'-','.'=>'-','('=>'-',':'=>'-','/'=>'-','–=> '-''));
		$s = htmlspecialchars($s);
		if(strpos($s,'-')) {
			$m['title_show'] = substr($m['title'],0, strpos($s,'-'));
		}
		if ($m['title_show'] == '') {
			$m['title_show'] = '-blank-';
		}
		$list[] = $m;
	}
	return $list;
}

function getTagsStr($tags)
{
	$t = array();
	foreach ($tags as $tt) {
		isset($tt['name']) && $t[] = $tt['name'];
	}
	return implode(', ', $t);
}

function getMovieInfo($id)
{
	$sql = "select xml from mt.dm where id = $id";
	$ret = mysqli_prepared_query($sql);
	$m = array();
	if (!empty($ret[0]['xml'])) {
		$json = json_decode($ret[0]['xml'], true);
		$m['片名'] = (isset($json['title']) ? $json['title'] : '') . (isset($json['alt_title']) && $json['alt_title'] != '' ? (' / ' . $json['alt_title'] ): '' );
		isset($json['attrs']) && $json = array_merge($json, $json['attrs']);
		$m['导演'] = isset($json['director']) && is_array($json['director']) ? implode(', ', $json['director']) : '';
		$m['演员'] = isset($json['cast']) && is_array($json['cast']) ? implode(', ', $json['cast']) : '';
		$m['上映时间'] = isset($json['year']) && is_array($json['year']) ? implode(', ', $json['year']) : '';
		$m['地区'] = isset($json['country']) && is_array($json['country']) ? implode(', ', $json['country']) : '';
		$m['类型'] = isset($json['movie_type']) && is_array($json['movie_type']) ? implode(', ', $json['movie_type']) : '';
		$m['标签'] = isset($json['tags']) && is_array($json['tags']) ? getTagsStr($json['tags']) : '';
		$m['简介'] = isset($json['summary']) ? $json['summary'] : '';

	}
	foreach ($m as &$str) {
		$str = strtr($str, array('"' => '', "\n" => ' '));
	}
	return $m;
}


function convertUrlQuery($query) { 
	$queryParts = explode('&', $query);

	$params = array();
	foreach ($queryParts as $param) {
		$item = explode('=', $param);
		isset($item[1]) && $params[$item[0]] = $item[1];
	}
	return $params;
}

function getMovieiResource($id)
{
	$sql = "select type,url from mt.dyfm where dmid = $id";
	$ret = mysqli_prepared_query($sql);
	$m = array();
	foreach($ret as $row) {
		$type = $row['type'];
		$url = htmlspecialchars_decode($row['url']);
		$p_url = convertUrlQuery($url);
		$name = isset($p_url['dn']) ? $p_url['dn'] : $url;
		$name = htmlspecialchars(urldecode($name));
		$url = htmlspecialchars($url);
		$show = $url;
		if (isset($p_url['magnet:?xt'])) {
			$btid = explode(':', $p_url['magnet:?xt']);
			isset($btid[2]) && $show = "http://www.x2yun.com/#!u=bt%3A%2F%2F{$btid[2]}%2F0";
		}
		$m[$type][] = array('url' => $url, 'name' => $name, 'show' => $show);
	}
	return $m;
}

function echoMovieList($list)
{
	foreach ($list as $l) {
		echo "
			<li>
				<a target='_blank' href='./moive.php?id={$l['id']}' title=\"{$l['title']}\"><img alt=\"{$l['title']}\" src='images.php?id={$l['id']}' /><div class='overlay link'></div>{$l['title_show']}</a>
			</li>
			";
	}
}
