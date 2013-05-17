<?php
function getPage($id)
{
    $url = "http://api.douban.com/v2/movie/$id?apikey=08025f97d915f32c18071ec78b41d984";
    $ch = curl_init($url); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    $c = curl_exec($ch);
    return $c;
}

function loadIds($id, $c)
{
    $sql = 'update lzz.dm set xml = ? where `id` = ?';
    $db = DB::getInstance(SALARY_DB_CONNECT_URL);
    $stmt = $db->execute($sql, array('si', $c, $id));
    $db->commit();
}

function getIds()
{
    $sql = 'SELECT `id` from lzz.dm where xml = ""'; 
    $db = DB::getInstance(SALARY_DB_CONNECT_URL);
    $stmt = $db->execute($sql);
    $ret = DB::getOneCellFromStmt($stmt);
    return $ret;
}

while(1) {

$ids = getIds();

if (count($ids) == 0) {
    break;
}

foreach ($ids as $id) {
    $c = getPage($id);
    loadIds($id, $c);
    echo $id,":\t",strlen($c) ,"\n";
    sleep(2);
}

}
