<?php
include 'gzdecode.php';

function getPage($page) {
    $exec = 'gzip -dc oabt/' . $page . '.gzip';
    $c =shell_exec($exec);
    echo strlen($c);
    $c =  strtr(trim($c), array("\r\n" => " ", "\n\r" => " ", "\n" => " ", "\r" => " ", "\t" => " ", '"' => "'"));
    preg_match_all("/.tbody onmouseover.+?tbody./", $c, $ids);
    return isset($ids[0]) && count($ids[0]) > 0 ? $ids[0] : false;
}

function loadIds($c) {
    $sql = 'insert into lzz.oabt (`html`) values(?)';
    $db = DB::getInstance(SALARY_DB_CONNECT_URL);
    foreach ($c as $html) {
        $stmt = $db->execute($sql, array('s', $html));
    }
    $db->commit();
    return count($c);
}



$page = 1;
while ($page <= 468) {
    $ids = getPage($page);
    $count = 0;
    if ($ids) {
        $count = loadIds($ids);
    }
    echo "page:" , $page , "\tcount:", $count , "\n";
    $page++;
    if (!$ids) break;
}

die;
