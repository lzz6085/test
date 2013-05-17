<?php
function getPage($url) {
    $ch = curl_init($url); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    $c = curl_exec($ch);
    $c =  strtr(trim($c), array("\r\n" => " ", "\n\r" => " ", "\n" => " ", "\r" => " ", "\t" => " ", '"' => "'"));
    preg_match_all("/.li class=.post clea.+? ..li./", $c, $ids);
    $ret =  isset($ids[0]) && count($ids[0]) > 0 ? $ids[0] : array();
    return $ret;

}

function loadIds($c) {
    $sql = 'insert into lzz.somag (`html`) values(?)';
    $db = DB::getInstance(SALARY_DB_CONNECT_URL);
    foreach ($c as $html) {
        $stmt = $db->execute($sql, array('s', $html));
    }
    $db->commit();
    return count($c);
}



$page = '';
while ($page <= 2142) {
    $url = "http://www.somag.net/category/%E7%94%B5%E5%BD%B1/" . $page;
    $ids = getPage($url);
    $count = 0;
    if ($ids) {
        $count = loadIds($ids);
    }
    echo "page:" , $page , "\tcount:", $count , "\n";
    sleep(1);
    $page++;
    if (!$ids) break;
}

die;
