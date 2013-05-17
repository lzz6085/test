<?php

function getPage($id, $table)
{
    $sql = "SELECT `html` from lzz.$table limit ? , 1"; 
    $db = DB::getInstance(SALARY_DB_CONNECT_URL);
    $stmt = $db->execute($sql, array('i', $id));
    $json = DB::getOneFromStmt($stmt);
    return $json;
}


function getSoMagArr($html)
{
    $arr = array(
        'name' => '',
        'filename' => '',
        'type'  => 1,
        'size'  => '',
        'url'   => '',
        'tags'  => '' 
    );
    preg_match_all("/(?<=『)[^』]+/", $html, $filename);
    $arr['filename'] =  isset($filename[0][0]) ? $filename[0][0] : '';
    $name = preg_split("/\d{4}/", str_replace('.', ' ', $arr['filename']));
    $arr['name'] = isset($name[0]) ? trim(substr($name[0], 0, -1)) : '';
    preg_match_all("/(?<=大小 )[^\<]+/", $html, $size);
    $arr['size'] =  isset($size[0][0]) ? $size[0][0] : '';
    preg_match_all("/magnet:\?[^']+/", $html, $url);
    $arr['url'] =  isset($url[0][0]) ? $url[0][0] : '';
    preg_match_all("/(?<=tag\/)[^\/]+/", $html, $tags);
    $arr['tags'] =  isset($tags[0]) ? urldecode(implode(', ', $tags[0])) : '';
    return $arr;
}


function getOabtArr($html)
{
    $arr = array(
        'name' => '',
        'filename' => '',
        'type'  => 1,
        'size'  => '',
        'url'   => '',
        'tags'  => '' 
    );
    preg_match_all("/(?<=_blank\'\>)[^\<]+/", $html, $filename);
    $arr['filename'] =  isset($filename[0][0]) ? $filename[0][0] : '';

    $name = preg_split("/\d{4}/", str_replace('.', ' ', $arr['filename']));
    $arr['name'] = isset($name[0]) ? trim(substr($name[0], 0, -1)) : '';

    preg_match_all("/(?<=seed\'\>)[^\<]+/", $html, $size);
    $arr['size'] =  isset($size[0][0]) ? $size[0][0] : '';

    preg_match_all("/(?<=sbule\'\>)[^\<]+/", $html, $tags);
    $arr['tags'] =  isset($tags[0]) ? urldecode(implode(', ', $tags[0])) : '';
    
    preg_match_all("/magnet:\?[^']+/", $html, $url);
    $magnet =  isset($url[0][0]) ? $url[0][0] : '';
    
    preg_match_all("/ed2k:[^']+/", $html, $url);
    $ed2k =  isset($url[0][0]) ? $url[0][0] : '';

    $ret = array();
    if ($magnet != '') {
        $arr['url'] = $magnet;
        $arr['type'] = 1;
        $ret[] = $arr;
    }

    if ($ed2k != '') {
        $arr['url'] = $ed2k;
        $arr['type'] = 2;
        $ret[] = $arr;
    }
    return $ret;
}

function LoadSourceUrl($arr)
{
    $sql = 'insert IGNORE into lzz.source_link (`name`, `filename`, `type`, `size`, `url`, `tags`) values(?, ?, ?, ?, ?, ?)';
    $db = DB::getInstance(SALARY_DB_CONNECT_URL);
    $stmt = $db->execute($sql, array_merge(array('ssssss'), $arr));
    $db->commit();
}


$page = 1;

while ($page <= 100000) {
    $html = getPage($page, 'oabt');
    if ($html) {
//        $arr = getSoMagArr($html);
//        LoadSourceUrl($arr);
          $arr = getOabtArr($html);
          foreach($arr as $row) {
                LoadSourceUrl($row);
                 echo $row['size'],"\t",$row['type'],"\t",$row['name'] , "\n";
          }
    }
    usleep(20000);
//    break;
    if (empty($html)) break;
    $page ++;
}
