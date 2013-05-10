<?php
$list = array_fill (0,17,
	array (
			"id" => 123,
			"title" => "21332"
	)
);
?>
	<div id="portfoliocont" class="clearfix">
		<ul>
<?php
	foreach ($list as $l) {
		echo "
			<li>
				<a title='{$l['title']}'> 
					<img alt='{$l['title']}' src='images.php?id={$l['id']}' />
					<div class='overlay link'></div>
					{$l['title']}
				</a>
			</li>
			";
	}
?>
		</ul>
	 </div>
<div class="green-black">
<?php
	$curr_page = isset($_REQUEST['page']) && $_REQUEST['page'] > 0 ? intval($_REQUEST['page']) : 1;
	$req = $_REQUEST;
	unset($req['page']);
	$url = '?' . implode('&', $req);
	$max = 200;
	
	echo  ($curr_page == 1) ? '<span class="disabled">&lt; Prev</span>' : ("<a href='$url&page=" . ($curr_page-1) . "'>&lt; Prev</a>");
	echo $curr_page > 6 ? "<a href='$url&page=1'>1</a>..." : '';
	for ($i = $curr_page <6 ? 1 : ($curr_page > $max - 6? $max - 9 : $curr_page - 5), $count = 1 ; $count <= 10 ; $i++, $count++) {
		echo $i == $curr_page ? "<span class='disabled'>$i</span>" : "<a href='$url&page=$i'>$i</a>";
	}
	echo $curr_page < $max - 5 ? "...<a href='$url&page=$max'>$max</a>" : '';
	echo  ($curr_page == $max) ? '<span class="disabled">Next &gt;</span>' : ("<a href='$url&page=" . ($curr_page+1) ."'>Next &gt;</a>");

?>
</div>
