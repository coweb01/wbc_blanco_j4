<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Helper\ModuleHelper;

/** @var Joomla\CMS\Document\HtmlDocument $this */

$app                = Factory::getApplication();
$doc                = $app->getDocument();
$templateparams     = $app->getTemplate(true)->params; // Templateparameter
$tpath              = 'templates/'.$this->template;

$wa                 = $this->getWebAssetManager();

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

?>


