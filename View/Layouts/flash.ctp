<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>	<html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>	<html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<html>
<head>
	<?= $this->Html->charset(); ?>
	<title><?= $page_title; ?></title>

	<?php if (Configure::read('debug') == 0) : ?>
		<meta http-equiv="Refresh" content="<?= $pause?>;url=<?= $url?>"/>
	<?php endif; ?>
	<style><!--
	P { text-align:center; font:bold 1.1em sans-serif }
	A { color:#444; text-decoration:none }
	A:HOVER { text-decoration: underline; color:#44E }
	--></style>
</head>
<body>
	<p><a href="<?= $url?>"><?= $message?></a></p>
</body>
</html>