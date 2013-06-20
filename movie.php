<?php
require_once './classes/common.php';
require_once './classes/db.php';

$id = isset($_REQUEST['id']) && $_REQUEST['id'] > 0 ? intval($_REQUEST['id']) : 0;
$m = getMovieInfo($id);
$title = $m['片名'];
$description = $m['简介'];
$keywords = $m['片名'] . ', ' . $m['标签'];
include("./header.php");

echo "<h4>$title</h4>";
echo "<hr />";
echo "<img alt='$title' src='images.php?id=$id' />";
echo "<hr />";
echo "<ul>";
foreach ($m as $t => $s) {
	echo "<li>$t : $s</li>";
}
echo "</ul>";
echo '
<!-- JiaThis Button BEGIN -->
  <div class="jiathis_style_32x32">
	<a class="jiathis_button_qzone"></a>
	<a class="jiathis_button_tsina"></a>
	<a class="jiathis_button_tqq"></a>
	<a class="jiathis_button_weixin"></a>
	<a class="jiathis_button_renren"></a>
	<a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a>
	<a class="jiathis_counter_style"></a>
  </div>
  <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js?uid=1370733258369661" charset="utf-8"></script>
<!-- JiaThis Button END -->
';

$randid = rand(1291543, 7513069);
$sql = "select id,xml from mt.dm where id >= $randid limit 20";
$ret = mysqli_prepared_query($sql);
$list = getMovieList($ret);
?>
		<hr />
		<h4>相关资源:</h4>
		<hr />
<?php
$r = getMovieiResource($id);
foreach ($r as $type => $re) {
	echo "<br />";
	echo $type ? "在线视频" : "下载资源";
	echo ":<br />";
	echo "<table style='width:100%;'>";
	foreach ($re as $row) {
		echo "<tr>";
		echo "<td><a target=_blank href='{$row['url']}'>{$row['name']}</a></td>";
		echo $type == 0 ? "<td><a target=_blank href='{$row['url']}'>下载 (右击, 复制链接地址)</a></td>" : '';
		echo "<td><a target=_blank href='{$row['show']}'>在线观看</a></td>";
		echo "</tr>";
	}
	echo "</table>";

}
?>
		<hr />
		<h4>相关推荐:</h4>
        <hr />
	<div id="portfoliocont" class="clearfix">
		<ul>
<?php
	echoMovieList($list);
?>
		</ul>
	 </div>

<?php
include("./footer.php");
