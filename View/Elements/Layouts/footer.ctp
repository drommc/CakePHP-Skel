<?php
/**
 * Footer of the application layout
 *
 * TODO Customize me
 */
	define('START_DATE', '2012');
	$currYear = date('Y');
	if ($currYear !== START_DATE) :
		$currYear = START_DATE . '-' . $currYear;
	endif;
?>
<hr>
<footer>
	<p>
		&copy;OccitechBakedApp!
		<?php echo $currYear ?>
	</p>
</footer>