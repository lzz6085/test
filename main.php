	<div id="portfoliocont" class="clearfix">
		<ul>
<?php
	echoMovieList($list);
?>
		</ul>
	 </div>
<div class="green-black">
<?php
	$url = getUrl('page');
	echo  ($curr_page == 1) ? '<span class="disabled">&lt; Prev</span>' : ("<a href='$url&amp;page=" . ($curr_page-1) . "'>&lt; Prev</a>");
	echo $curr_page > 6 ? "<a href='$url&amp;page=1'>1</a>..." : '';
	for ($i = $curr_page < 7 ? 1 : ($curr_page > $max - 6? $max - 8 : $curr_page - 4), $count = 1 ; $count < 10 ; $i++, $count++) {
		echo $i == $curr_page ? "<span class='disabled'>$i</span>" : "<a href='$url&amp;page=$i'>$i</a>";
	}
	echo $curr_page < $max - 5 ? "...<a href='$url&amp;page=$max'>$max</a>" : '';
	echo  ($curr_page == $max) ? '<span class="disabled">Next &gt;</span>' : ("<a href='$url&amp;page=" . ($curr_page+1) ."'>Next &gt;</a>");

?>
</div>
