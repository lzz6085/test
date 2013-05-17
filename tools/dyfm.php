<?php
function getLink($url) {
    $ch = curl_init($url); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    $c = curl_exec($ch);
    curl_close($ch);
    preg_match_all("/(?<=href\=\")magnet[^\"]+/", $c, $ms);
    $ret['0'] = isset($ms[0]) && count($ms[0]) > 0 ? $ms[0] : array();
    preg_match_all("/(?<=playlink.url.)[^\"]+/", $c, $vs);
    $ret['1'] = isset($vs[0]) && count($vs[0]) > 0 ? $vs[0] : array();
    foreach ($ret['1'] as $k => $u ) {
        $ret['1'][$k] = urldecode($u); 
    }
    return $ret;
}

function getPage($url) {
    $ch = curl_init($url); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    $c = curl_exec($ch);
    curl_close($ch);
    if (strlen($c) <= 100) {
        echo $c;
        echo "\t" . $url . "\tget false";
        sleep(30);
        if (strpos($c, '500') === false and strlen($c) > 0)
            return false;
    }
    preg_match_all("/(?<=href\=\")\/movie[^\"]+/", $c, $ids);
    $ret =  isset($ids[0]) && count($ids[0]) > 0 ? $ids[0] : array();
    foreach ($ret as $k => $u ) {
        $ret[$k] = 'http://dianying.fm/' . $u; 
    }
    return $ret;

}

function LoadUrl($dmid, $c)
{
    $sql = 'insert IGNORE into lzz.dyfm (`dmid`, `type`, `url`, `url_hash`) values(?, ?, ?, ?)';
    $db = DB::getInstance(SALARY_DB_CONNECT_URL);
    foreach ($c as $type => $arr) {
        foreach ($arr as $url) {
            $url = trim($url);
            $url_hash = md5($url);
            $stmt = $db->execute($sql, array('iiss', $dmid, $type, $url, $url_hash));
        }
        echo "$type:", count($arr), "\t";
    }
    $db->commit();
}

function getIds()
{
    $sql = 'SELECT `id` from lzz.dm where id > 5164607';
    $db = DB::getInstance(SALARY_DB_CONNECT_URL);
    $stmt = $db->execute($sql);
    $ret = DB::getOneCellFromStmt($stmt);
    return $ret;
}

function getKey($id)
{
    $sql = 'SELECT `xml` from lzz.dm where id = ?'; 
    $db = DB::getInstance(SALARY_DB_CONNECT_URL);
    $stmt = $db->execute($sql, array('i', $id));
    $json = DB::getOneFromStmt($stmt);
    $arr = json_decode($json, true);
    $t = isset($arr['alt_title']) ? $arr['alt_title'] : '';
    if ($t == '') {
        $t = isset($arr['title']) ? $arr['title'] : '';
    }
    echo $t , "\t";
    return $t;
}

function setdyfm($dmid) 
{
    echo date('Y-m-d H:i:s') . "\t$dmid\t";
    $key = getKey($dmid);
    if ($key == '') 
    {
        echo "\n";
        return true;
    }
    $u = 'http://dianying.fm/category/key_' . urlencode(str_replace('-',' ',$key));
    $page = getPage($u);
    if ($page === false) {
        return false;
    }
    sleep(1);
    foreach ($page as $p) {
        $c = getLink($p);
        LoadUrl($dmid, $c);
        sleep(1);
    }
    echo "\n";
    return true;
}
$ids = getIds();

foreach ($ids as $id) {
    if(!setdyfm($id)) {
        break;
    }
}

echo "\n" . date('Y-m-d H:i:s') . "\texit\n";
die;
