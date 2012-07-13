<?php
/**
 * Google Analytics element
 * Allows to include the Google Analytics code configured in the admin backend
 * If Google Analytics has not be enabled, the tracking code will not be displayed
 *
 * The tracking code is not displayed in debug mode by default, the option can
 * be changed from the backend
 */
$gaCode = Configure::read('Analytics.code');
if (!empty($gaCode) && Configure::read('debug') == 0) :
?>
<script type="text/javascript">
	var _gaq = _gaq || [];		
	_gaq.push(['_setAccount', '<?php echo $gaCode; ?>']);
	_gaq.push(['_trackPageview']);
	_gaq.push(['_trackPageLoadTime']);
		
	(function() {	
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;	
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';	
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);	
	})();
</script>
<?php endif; ?>