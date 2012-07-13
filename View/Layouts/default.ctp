<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>	<html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>	<html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<?= $this->Html->charset(); ?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title><?= $title_for_layout; ?></title>

	<meta name="viewport" content="width=device-width">

	<?=
		$this->Html->meta('icon') .
		$this->fetch('meta') .

		$this->fetch('css') .
		$this->Html->css(array('app.css')) .

		$this->Html->script(array('libs/modernizr-2.5.3.min.js')) .
		$this->element('Layouts/google_analytics')
	?>
</head>
<body>
	<?=
		$this->element('Layouts/chrome_frame') .
		$this->element('Layouts/top_navigation')
	?>

	<div class="container">
		<?php
			if ($this->Html->hasCrumbs()) :
				echo $this->Html->getCrumbList(array('class' => 'breadcrumb'), __('Home'));
			endif;
		?>
		<?=
			$this->Session->flash() . $this->Session->flash('auth') .
			$this->fetch('content')
		?>
	</div>
	<?= $this->element('Layouts/footer') ?>

	<?=
		$this->Html->script(array(
			'//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js',
			'libs/bootstrap.min.js',
			'plugins.js',
			'script.js'
		)) .
		$this->Html->scriptBlock('
			window.jQuery || document.write(\'<script src="/js/libs/jquery-1.7.2.min.js"><\/script>\')
		') .
		$this->fetch('script') .
		$this->Js->writeBuffer()
	?>
</body>
</html>
