<?php
	$title = isset($title) ? $title : '';
	$description = isset($description) ? $description : '';
	$keywords = isset($keywords) ? $keywords : 'movie';
?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $title; ?>电影 Movie Tracker</title>
<meta charset="UTF-8">
<!--[if IE]><![endif]-->
<meta name="description" content="<?php echo $description; ?>电影 Moive Tarcker 电影速递">
<meta name="keywords" content="<?php echo $keywords; ?>电影,下载,在线">
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="css/style.css?dafdsfdgs">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/jquery.js"><\/script>')</script>
<script src="js/scripts.js"></script>
<!--[if lt IE 9]>
<script src="http://css3-mediaqueries-js.googlecode.com/files/css3-mediaqueries.js"></script>  
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>
<body>

<div id="fixedtop" class="clearfix">
  
	<div id="headercont" class="clearfix">
       <a id="headerleft" title="" href="#">MovieTracker<br/><font color="black">MTer.org</font></a>
    	<div id="headerright">
            <div class="menu">
                <ul>
                    <li class="active"><a title="" href="#">热门电影</a></li>
                   <li><a title="" href="#">最近更新</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div id="topheight"></div>

<div id="maincont" class="clearfix">
    <div id="main">
