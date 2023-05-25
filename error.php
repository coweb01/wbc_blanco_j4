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

/** @var Joomla\CMS\Document\ErrorDocument $this */

$app = Factory::getApplication();
$doc = $app->getDocument();

$templateparams = $app->getTemplate(true)->params; // Templateparameter
$item = $templateparams->get('errorsite', 0 ); // get menuitem der Fehlerseite aus dem Template
$logo = $templateparams->get('logo','logo.png');
$customcss = $templateparams->get('customcss','custom.css');

$config = $app->getConfig();
$sefUrl = $config->get('sef');

// Get language and direction
$this->language  = $doc->language;
$this->direction = $doc->direction;

$uri = URI::getInstance();
$base = $uri->toString( array('scheme', 'host', 'port'));

$wa = $this->getWebAssetManager();
$wa->useStyle('template.wbc');
$doc->setMetadata('viewport', '');
$doc->setMetadata('content-language',substr($this->language, 0, 2));

// Bootstrap Klassen
$bootstrap_colclass              = "col-md-";
$bootstrap_colclass_mobil_tb     = "col-sm-";
$bootstrap_colclass_mobil_ph     = "col-";
$bootstrap_colclass_lg           = "col-lg-";
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
<!--[if gt IE 8]><!-->  <html class="no-js" lang="<?php echo $this->language; ?>"> <!--<![endif]-->

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

<body class="errorsite">
	<div class="wrap-outer error">
		<header class="header-02 container">
			<div class="logo row justify-content-center">
				<div id="logo" class="<?php echo $bootstrap_colclass_mobil_ph . '6 ' . $bootstrap_colclass_mobil_tb . '4 ' .$bootstrap_colclass. '3 ' .$bootstrap_colclass_lg; ?>3">
					<a href="index.php"><img src="<?php echo $this->baseurl ?><?php echo $logo ?>" alt="<?php echo htmlspecialchars($templateparams->get('sitetitle')); ?>" title="<?php echo htmlspecialchars($templateparams->get('sitetitle')); ?>" /></a>
				</div><!--End Logo-->
			</div>
		</header>
		<div class="wrap-main container">
			<div class="main">
				<div class="info-message row border position-relative">
					<p class="h2 p-5 col-8"><?php echo Text::_('TPL_WBC_BLANCO_J4_JERROR_TEXT_ERROR'); ?></p>
					<div class="col-4">
						<img src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/images/fehler.jpg" alt="sorry" >
					</div>
				</div>
				<div class="alert alert-secondary row justify-content-center">
					<p class="text-center">
						<strong><?php echo Text::_('TPL_WBC_BLANCO_J4_JERROR_TEXT_ERRORCODE'); ?>
						<span class="error-code"> Code: <?php echo $this->error->getCode(); ?></span>
						</strong>
					</p>
					<p class="text-center"><?php echo $this->error->getMessage();?></p>
					<?php // var_dump($this->error);?>
				</div>
			</div>
		</div>
	</div>
<?php
}
?>
</body>
</html>
