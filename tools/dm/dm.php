<?php
function getPage($tag, $page) {
    $url = "http://m.douban.com/movie/search/movie_search?q=$tag&page=$page&session=";
    $ch = curl_init($url); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    $c = curl_exec($ch);
    preg_match_all("/(?<=movie.subject.)[0-9]+/", $c, $ids);
    return isset($ids[0]) && count($ids[0]) > 0 ? $ids[0] : false;
}

function loadIds($ids) {
    $sql = 'insert into lzz.dm (`id`) values(?) ON DUPLICATE KEY update id=values(`id`)';
    $db = DB::getInstance(SALARY_DB_CONNECT_URL);
    foreach ($ids as $id) {
        $stmt = $db->execute($sql, array('i', $id));
    }
    $db->commit();
    return count($ids);
}


$year = 97;

while ($year <= 122) {
    $page = 1;
    $y = chr($year);
    while (true) {
        $ids = getPage($y,$page);
        $count = 0;
        if ($ids) {
            $count = loadIds($ids);
        }
        echo "year:" , $y , "\tpage:" , $page , "\tcount:", $count , "\n";
        $page++;
        sleep(2);
        if (!$ids) break;
    }
    $year++;
}


//var_dump(xdiff_string_diff('a','aa'));
die;

/*
function xxxx()
{
    $x = str_repeat('1',1026000);
    xdebug_debug_zval('x');
    return $x;
}
$xxx = xxxx();
$xxx = str_repeat('2',1026000);
*/

//require_once STAT_ROOT . 'common/DealStatData.php';



//$deal = new DealStatData(806054);

//var_dump($deal->revenue, $deal->profit, $deal->getRevenue('2012-07-01'));

/*

        $loginUser = isset( ControllerAction::$loginUser->name) ? ControllerAction::$loginUser->name : '脚本执行';
        $loginUserID = isset( ControllerAction::$loginUserID) ? ControllerAction::$loginUserID : 0;
        $sqlinfo = " 查询人:" . $loginUser . "(" . $loginUserID . ")\n";
var_dump(isset(ControllerAction::$loginUser->name), isset(ControllerAction::$loginUserID), $sqlinfo);
*/
/*
$x = '中文';
$error = iconv("UTF-8","gb2312",$x);
$value = mb_check_encoding($error, 'UTF-8') ? $error : mb_convert_encoding($error, "UTF-8", mb_detect_encoding($error));
var_dump($x,mb_check_encoding($error, 'UTF-8'),$value, $error, mb_detect_encoding($error, "auto"));
*/

//var_dump(is_integer("+1124"));
/*var_dump(float('123,324.987'));
die;
*/
/*
var_dump(0==='0');
die;
${'ccc' . '中国(多得多)'}=2;
$ccc中国(多得多);
die;

  class t {
    public static function test()
    {
        echo 'xxx';
    }
    public static function xxx()
    {
        self::test();
    }
    const XXXXX = 20;
};

function get_class_constants($x)
{
    $reflect = new ReflectionClass(get_class($x));
    return $reflect->getConstants();
}

$x = 't';
$t = new $x();
var_dump(get_class_constants($t), $x::XXXXX);
die;
*/
//require STAT_ROOT . '/common/common.php';


//$filename = '';
//$filename = '2012-03-05.18:18:14.DealCommissions_This.csv';
//$pattern = '/DealCommissions.+gbk.csv/';
//var_dump(preg_match($pattern, $filename));
//$ret1 = array(0);
//$ret2 = array(0);
/*$yearmo = 201205;
$firstday = date('Y-m-d', strtotime($yearmo . '01'));
echo $firstday;
echo date('Y-m-d',strtotime("$firstday +1 month -1 day"));
*/

//$a = strtotime('2099-01-01');
//$a = array_merge(array('x'), array('y'), array(), array(NULL), array('z'));
//var_dump($a);
//die;

//var_dump($ret1 || $ret2);
/*
$u = 'DW_DB_CONNECT_URL';
eval('$u = ' . $u . ';');
var_dump(DW_DB_CONNECT_URL, $u, $u);
*/

/*$t = t('b', 'yyy', 'zzz');

var_dump(strtotime('2012-02-16'));
*/
/*
$feedback_factor=0;
$d = isset($feedback_factor) ? $feedback_factor : 1;;
var_dump($d);
die;
$str = '$deal';
$pattern = '/\\' . $str . '\b/';

echo preg_match($pattern, ' $deal  ');
die;
*/
/*
$date = gmdate(DATE_RFC822);
//$date = 'Fri, 24 Feb 2012 08:14:51 GMT';
#$string_to_sign = 'GET' . " " . '/api/commission/deal' . "\n" . $date;
$string_to_sign = 'GET' . " " . '/api/commission/bd' . "\n" . $date;
#$string_to_sign = 'GET' . " " . '/api/dw/deal_daily' . "\n" . $date;
$signature = base64_encode(hash_hmac('sha1', $string_to_sign, '100f15a73f605017040c62aef8f4d8ec', true));
var_dump($signature);
$header[] = 'Date: ' . $date;
//$header[]= 'Authenticate: ' . 'MWS crm:frJIUN8DYpKDtOLCwozzyllqDzg=';
$header[] = 'Authorization: ' . 'MWS crm:' . $signature;
$ch = curl_init('http://stat.lzzmt.dev.sankuai.com/api/commission/bd?bdlist=418;1045;2602;1152;4624;20&yearmo=201208&isonline=1'); 
#$ch = curl_init('http://stat.lzzmt.dev.sankuai.com/api/commission/deal?dealidlist=123;321;604800&yearmo=201206&isonline=1'); 
#$ch = curl_init('http://stat.lzzmt.dev.sankuai.com/api/dw/deal_daily?dealid=996431;996450;996543&showdayno_from=1&showdayno_to=7&measures=profit;revenue&groupby=dealid'); 
curl_setopt($ch, CURLOPT_HEADER, 1); 
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
$c = curl_exec($ch); 
$info = curl_getinfo($ch, CURLINFO_HTTP_CODE);
var_dump($ch,$c, $info);
*/

/*
function t($x)
{
    $a = func_get_args();
    var_dump(isset($a[0]));
    return call_user_func_array($a[0], $a);
}

function b($x)
{
    return func_get_args();
}
*/

try {
    define('WIKI_DB_CONNECT_URL', 'mysql://meituan_as:c3fDSaP7TTcm@192.168.0.30:5002/meituanwiki#UTF8');
    $sql  = 'SELECT c.LASTMODDATE, b.BODY FROM CONTENT c JOIN BODYCONTENT b USING(CONTENTID) WHERE CONTENTID=47289869';
    $wiki = DB::getOneRowFromStmt(DB::getInstance(WIKI_DB_CONNECT_URL)->execute($sql), array('modtime', 'body'));
    $msg = '修改时间: ' . $wiki['modtime'] . '<br />' . $wiki['body'];
} catch (Exception $e) {
    $log = Log::getInstance("commission_debug");
    $error = $e->getMessage();
    $log->add('WIKI_ERR', array('msg' => $error));
    $msg = '如有疑问请发送邮件至: bddatareport@meituan.com';
}

var_dump($msg);
