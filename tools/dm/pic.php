<?php
function getPic($id)
{
    $url = getPicUrl($id);
    if (empty($url)) {
        return '';
    }
    $ch = new CUrlHttp(); 
    $c = '';
    $f = $ch->httpGet($url, $c);
    if ($f) {
        echo $ch->getErrMsg(), "\t";
        return NULL;
    }
    $ch->curlClose();
    return $c;
}

function getPicUrl($id)
{
    $sql = 'SELECT `xml` from lzz.dm where id = ?'; 
    $db = DB::getInstance(SALARY_DB_CONNECT_URL);
    $stmt = $db->execute($sql, array('i', $id));
    $json = DB::getOneFromStmt($stmt);
    $arr = json_decode($json, true);
    $url = isset($arr['image']) ? $arr['image'] : '';
    $url = str_replace('spic', 'lpic', $url);
    if (stripos($url,'movie-default',0) !== false) {
        $url = '';
    }
    echo $url , "\t";
    return $url;
}

function loadIds($id, $c)
{
    $sql = 'update lzz.dm set pic = ? where `id` = ?';
    $db = DB::getInstance(SALARY_DB_CONNECT_URL);
    $stmt = $db->execute($sql, array('si', $c, $id));
    $db->commit();
}

function getIds()
{
    $sql = 'SELECT `id` from lzz.dm where xml != "" and pic is null'; 
    $db = DB::getInstance(SALARY_DB_CONNECT_URL);
    $stmt = $db->execute($sql);
    $ret = DB::getOneCellFromStmt($stmt);
    return $ret;
}

while (1) {
$ids = getIds();

if (count($ids) == 0) {
    sleep(200);
    continue;
}

foreach ($ids as $id) {
    $count = 0;
    while (1) {
        $count++;
        $c = getPic($id);
        if ($c !== NULL) {
            break;
        } else {
            echo $id,"\t","sleep 100, count:",$count;
            sleep(100);
        }
        if ($count>=5) {
            echo "\t","continue\t";
            continue;
        }
    }
    if ($c !== NULL) {
        loadIds($id, $c);
    }
    echo $id,":\t",strlen($c) ,"\n";
    if ($c !== '') {
        sleep(2);
    }
}
}
