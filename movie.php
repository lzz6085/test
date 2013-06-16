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


$sql = "select id,xml from mt.dm order by rand() limit 20";
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
