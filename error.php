<?php
/**********************************************************
 * Template Blanco
 * Template Joomla 4
 * Kunde:
 * Author: Claudia Oerter / Viviana Menzel
 * Stand:  11 / 2021
 * Version: 1.0
 * copyright Template das webconcept
 **********************************************************/
defined( '_JEXEC' ) or die; 

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\HTML\HTMLHelper;

/** @var Joomla\CMS\Document\ErrorDocument $this */

$app = Factory::getApplication();
$doc = $app->getDocument();

$templateparams = $app->getTemplate(true)->params; // Templateparameter
$item = $templateparams->get('errorsite', 0 ); // get menuitem der Fehlerseite aus dem Template
$logo = $templateparams->get('logo');
$mediapath   = 'media/templates/site/'.$this->template.'/';

$config = $app->getConfig();
$sefUrl = $config->get('sef');
$sitename = htmlspecialchars($app->get('sitename'), ENT_QUOTES, 'UTF-8'); // sitename in joomla konfigurationsdatei definiert
$logo = HTMLHelper::_('image', Uri::root(false) . htmlspecialchars($logo, ENT_QUOTES), $sitename, ['loading' => 'eager', 'decoding' => 'async'], false, 0);


// Get language and direction
$this->language  = $doc->language;
$this->direction = $doc->direction;

$uri = URI::getInstance();
$base = $uri->toString( array('scheme', 'host', 'port'));

$wa = $this->getWebAssetManager();
$wa->useStyle('template.wbc')
	->useStyle('template.user')
	->useScript('template.user');
$doc->setMetadata('viewport', '');
$doc->setMetadata('content-language',substr($this->language, 0, 2));
// Defer font awesome
$wa->getAsset('style', 'fontawesome')->setAttribute('rel', 'lazy-stylesheet');

// Favicons https://realfavicongenerator.net/
$this->addHeadLink(HTMLHelper::_('image', 'favicons/apple-touch-icon.png', '', [], true, 1), 'apple-touch-icon', 'rel', ['sizes' => '180x180']);
$this->addHeadLink(HTMLHelper::_('image', 'favicons/favicon-32x32.png', '', [], true, 1), 'icon', 'rel', ['sizes' => '32x32', 'type' => 'image/png']);
$this->addHeadLink(HTMLHelper::_('image', 'favicons/favicon-16x16.png', '', [], true, 1), 'icon', 'rel', ['sizes' => '16x16', 'type' => 'image/png']);
$this->addHeadLink(HTMLHelper::_('image', 'favicons/safari-pinned-tab.svg', '', [], true, 1), 'mask-icon', 'rel', ['color' => '#41599a']);
$this->addHeadLink(HTMLHelper::_('image', 'favicons/favicon.ico', '', [], true, 1), 'shortcut icon', 'rel', ['type' => 'image/vnd.microsoft.icon']);
$this->addHeadLink($mediapath . 'images/favicons/site.webmanifest', 'manifest', 'rel', []);
$this->setMetaData('msapplication-config', $mediapath . 'images/favicons/browserconfig.xml');
$this->setMetaData('theme-color', '#ffffff');

// Bootstrap Klassen
$bootstrap_colclass              = "col-md-";
$bootstrap_colclass_mobil_tb     = "col-sm-";
$bootstrap_colclass_mobil_ph     = "col-";
$bootstrap_colclass_lg           = "col-xl-";
$bootstrap_rowclass              = "row";
$bootstrap_offsetclass           = "col-md-offset-";
$bootstrap_offsetclass_lg        = "col-lg-offset-";
$bootstrap_offsetclass_mobil_tb  = "col-sm-offset-";
$bootstrap_offsetclass_mobil_ph  = "col-offset-";

if ($this->error->getcode() == '404') {
	header("HTTP/1.0 404 Not Found");
}

if (isset ($item ) && $this->error->getCode()==404) {
	$menus                    = $app->getMenu('site', array());
	$item                     = $menus->getItem($item); //get menue item
	$url                      = $item->link;     // link
	$route                    = $item->route;   // sef url
	$link                     = ( $config->get('sef') == 1 ) ? $route : $url; //sef on or not
	$UrlErrorSite             = $base . $this->baseurl . '/' . $link; // link

	//echo  base64_encode($UrlErrorSite);
	//echo (file_get_contents($UrlErrorSite));
  header('Location: ' . Route::_($UrlErrorSite, false));
  exit;
}
elseif ($this->error->getCode()==403) {
  header('Location: ' . Route::_($base . $this->baseurl . '/403' , false));
  exit;
}
else {
?>

<!DOCTYPE html>
<!--[if IEMobile]><html class="iemobile" lang="<?php echo $this->language; ?>"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8" lang="<?php echo $this->language; ?>"> <![endif]-->
<!--[if gt IE 8]><!-->  <html class="no-js h-100" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>"> <!--<![endif]-->

<!-- ****************************************************************************************************** -->
<!-- *     Head                                                                                           * -->
<!-- ****************************************************************************************************** -->
<head>
	<jdoc:include type="metas" />
	<?php include "includes/style.php";?>
	<jdoc:include type="styles" />
	<jdoc:include type="scripts" />
	<title><?php echo $this->error->getCode(); ?> - <?php echo htmlspecialchars($this->error->getMessage(), ENT_QUOTES, 'UTF-8'); ?></title>
</head>

<body class="errorsite d-flex flex-column h-100">
	<div class="wrap-outer error">
		<header class="header-02 container">
			<div class="logo row justify-content-center my-5">
				<div id="logo" class="col <?php echo $bootstrap_colclass_mobil_tb . '6 ' .$bootstrap_colclass. '4 ' .$bootstrap_colclass_lg; ?>4">
					<a href="<?php echo $this->baseurl; ?>/"><?php echo $logo; ?></a>
				</div><!--End Logo-->
			</div>
		</header>
		<main class="wrap-main container mb-5">
			<div class="info-message row justify-content-center align-items-center">
				<h1 class="h2 p-3 col"><?php echo Text::_('TPL_WBC_BLANCO_J4_JERROR_TEXT_ERROR'); ?></h1>
			</div>
			<div class="alert alert-light d-flex justify-content-center p-5 my-3" role="alert">
				<div class="pe-5 pb-2">
					<svg xmlns="http://www.w3.org/2000/svg" height="32" width="32" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm0-384c13.3 0 24 10.7 24 24V264c0 13.3-10.7 24-24 24s-24-10.7-24-24V152c0-13.3 10.7-24 24-24zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"/></svg>				
				</div>
				<div>	
					<p>
						<strong><?php echo Text::_('TPL_WBC_BLANCO_J4_JERROR_TEXT_ERRORCODE'); ?>
						<span class="error-code"> Code: <?php echo $this->error->getCode(); ?></span>
						</strong>
					</p>
					<p><?php echo $this->error->getMessage();?></p>
					<p><?php echo Text::_('TPL_WBC_BLANCO_J4_JERROR_TEXT2'); ?></p>
					<p class="text-center"><a class="btn btn-primary my-3 " href="<?php echo $this->baseurl; ?>/" role="button"><?php echo Text::_('TPL_WBC_BLANCO_J4_GO_TO_THE_HOME_PAGE'); ?></a>
				</div>
			</div>
			<?php if ($this->debug) : ?>
			<div class="mt-5">
				<?php echo $this->renderBacktrace(); ?>
				<?php // Check if there are more Exceptions and render their data as well ?>
				<?php if ($this->error->getPrevious()) : ?>
					<?php $loop = true; ?>
					<?php // Reference $this->_error here and in the loop as setError() assigns errors to this property and we need this for the backtrace to work correctly ?>
					<?php // Make the first assignment to setError() outside the loop so the loop does not skip Exceptions ?>
					<?php $this->setError($this->_error->getPrevious()); ?>
					<?php while ($loop === true) : ?>
						<p><strong><?php echo Text::_('JERROR_LAYOUT_PREVIOUS_ERROR'); ?></strong></p>
						<p><?php echo htmlspecialchars($this->_error->getMessage(), ENT_QUOTES, 'UTF-8'); ?></p>
						<?php echo $this->renderBacktrace(); ?>
						<?php $loop = $this->setError($this->_error->getPrevious()); ?>
					<?php endwhile; ?>
					<?php // Reset the main error object to the base error ?>
					<?php $this->setError($this->error); ?>
				<?php endif; ?>
			</div>
			<?php endif; 
 
}?>
		</main>
	</div>
<!-- ****************************************************************************************************** -->
<!-- *    Footer                                                                                         * -->
<!-- ****************************************************************************************************** --> 
	<footer id="wrap-footer" class="wbc-footer mt-auto">
		<?php if ($this->countModules('footer-top')) : ?>
		<div class="container-fluid">
			<div class="base-row <?php echo $bootstrap_rowclass; ?>">
				<div id="footer-top" class="base-col wbc-footer-top <?php echo $bootstrap_colclass_mobil_sm . '12 ' . $bootstrap_colclass; ?>12">
					<div class="footer-top-bg">
						<jdoc:include type="modules" name="footer-top" style="none" />
					</div>
				</div>
			</div>
		</div><!--Container-->
		<?php endif; ?>

		<?php if ($this->countModules('footer-bottom')): ?>
		<div id="footer-bottom" class="wbc-footer-bottom d-none d-sm-block">
			<div class="container-fluid">
				<div class="base-row <?php echo $bootstrap_rowclass; ?>">
					<div id="footer-modules-bottom" class="base-col <?php echo $bootstrap_colclass_mobil_sm . '12 ' . $bootstrap_colclass; ?>12 ">
						<jdoc:include type="modules" name="footer-bottom" style="none" />
					</div>
				</div>
			</div><!--Container-->
		</div>
		<?php endif; ?>
	</footer>
</body>
</html>
