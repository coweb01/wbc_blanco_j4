<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Helper\ModuleHelper;

/** @var Joomla\CMS\Document\HtmlDocument $this */

$app                = Factory::getApplication();
$doc                = $app->getDocument();
$templateparams     = $app->getTemplate(true)->params; // Templateparameter
$tpath              = '/templates/'.$this->template;

$wa                 = $this->getWebAssetManager();

if ($floatingLabels == 1) {
	$wa->registerAndUseScript('floating', $tpath . '/js/vendor/jquery.placeholder.label.min.js', [], [], []);

	$jscript  = " ( function($) { $(document).ready(function(){";
	$jscript .= "$('input[placeholder]').placeholderLabel(";
	$jscript .= "  'labelColor:' + '#333333',
			'placeholderColor:' + '#999999',
			'useBorderColor:' + false,
			'labelSize:' + '14px',
			'timeMove:' + 200
		);";
	$jscript .= "}) })(jQuery); ";
	$doc->addScriptDeclaration($jscript) ;
}
?>

<?php // script für den Styleumschalter HK / Default
if($styleswitch == 1) {
	$wa->registerAndUseScript('switcher', $tpath . '/js/CSSswitcher.js', [], [], []);
}
?>

<?php
//  script fixed Header on scroll
if ($fixedheader == 1) {
	$wa->registerAndUseScript('scroller', $tpath . '/js/vendor/scrollPosStyler.min.js', [], [], []);
}
?>

<?php
if ($functions == 1) {
	$wa->registerAndUseScript('funktion', $tpath . '/js/funktion.js', [], [], []);
}
?>

<?php
if ($offcanvas == 1) {
	$wa->registerAndUseScript('offcanvas', $tpath . '/js/offcanvas.js', [], [], []);
}
?>

<?php
	$wa->registerAndUseScript('tables', $tpath . '/js/table_resp.js', [], [], []);
?>

<?php
if ($holder == 1) {
	$wa->registerAndUseScript('holder', $tpath . '/js/holder.js', [], [], []);
}
?>

<?php
if ($toggleright) : ?>
<script >
(function ($) {
	$(document).ready(function () {
		$( '#fixed-sidebar-right-toggle .btn-icon' ).click(function() {
		let ToggleContainerRight = $( '#fixed-sidebar-right-toggle .container-fix');
		ToggleContainerRight.toggle( 'slow' );
		$( '#fixed-sidebar-right-toggle').toggleClass('slide-open');

		});
	});
})(jQuery);
</script>
<?php endif;?>

<?php
if ($toggleleft) : ?>
<script >
(function ($) {
	$(document).ready(function () {
		$( '#fixed-sidebar-left-toggle .btn-icon' ).click(function() {
		let ToggleContainerLeft =  $('#fixed-sidebar-left-toggle .container-fix');
		ToggleContainerLeft.toggle( 'slow' );
		$( '#fixed-sidebar-left-toggle').toggleClass('slide-open');

		});
	});
})(jQuery);
</script>
<?php endif;?>
