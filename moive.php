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
		<h4>相关推荐:</h4>
        <hr />
	<div id="portfoliocont" class="clearfix">
		<ul>
<?php
	foreach ($list as $l) {
		echo "
			<li>
				<a target='_blank' href='./moive.php?id={$l['id']}' title='{$l['title']}'><img alt='{$l['title']}' src='images.php?id={$l['id']}' /><div class='overlay link'></div>{$l['title_show']}</a>
			</li>
			";
	}
?>
		</ul>
	 </div>

<?php
include("./footer.php");
