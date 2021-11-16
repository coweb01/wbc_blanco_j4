<?php
//  Load systemvariables
//  magic.php
//  tmpl: wbc_blanco

/* Parameter und Systemvariablen */

defined( '_JEXEC' ) or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Helper\ModuleHelper;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

/** @var Joomla\CMS\Document\HtmlDocument $this */

$app                = Factory::getApplication();
$doc                = $app->getDocument();
$doc->setHtml5(true);
$wa                 = $this->getWebAssetManager();

$lang               = $app->getLanguage(); //sprachstring bei mehrsprachigen seiten
$templateparams     = $app->getTemplate(true)->params; // Templateparameter
$sitename           = htmlspecialchars($app->get('sitename'), ENT_QUOTES, 'UTF-8'); // sitename in joomla konfigurationsdatei definiert
$params             = $app->getParams(); //Parameter Menue
$pageclass          = $params->get('pageclass_sfx'); // parameter (menu entry)
$tpath              = $this->baseurl.'/templates/'.$this->template;
$vorcontent_cols    = $this->params->get('vorcontent-cols',1);
$aftercontent_cols  = $this->params->get('aftercontent-cols',1);
$NavMainPos         = $this->params->get('navmain',1);
$this->language     = $doc->language;
$this->direction    = $doc->direction;
$showrightColumn    = 0;
$showleftColumn     = 0;
$counter            = 0;

// custom css styles in Tabelle speichern
$customcss          = array();
$customcss          = explode (',',$templateparams->get('customcss'));

if ($NavMainPos == 5 ) {  // Hauptnavigation rechts
    $showrightColumn    = $this->countModules('navMain');
 }
if ($NavMainPos == 4 ) { // Hauptnavigation links
    $showleftColumn     = $this->countModules('navMain');
 }

$pos_search = '';
if ($module = ModuleHelper::getModule( 'search' )) {;
	$pos_search = $module->position;
	$anker_search = 'id="suche-'. $pos_search. '"';
}

$showrightColumn            = $showrightColumn + ( $this->countModules('right-01 or right-02 or nav-sidebar-right'  ) );
$showleftColumn             = $showleftColumn + ( $this->countModules('left-01 or left-02 or nav-sidebar-left') ) ; // erforderliche Spalten ermitteln
$colSidebarLeft             = $templateparams->get('colsidebarleft',3);
$colSidebarRight            = $templateparams->get('colsidebarright',3);
$colSidebarLeft_sm          = $templateparams->get('colsidebarleft_sm',4);
$colSidebarRight_sm         = $templateparams->get('colsidebarright_sm',4);
$googlefontname             = $templateparams->get('googlefontname');
$googlefont                 = $templateparams->get('googlefont');
$googlefontnamecss          = $templateparams->get('googlefontnamecss');
$holder                     = $templateparams->get('holder');
$fontawesome                = $templateparams->get('fontawesome');
$functions	                = $templateparams->get('funktionen');
$logo                       = $templateparams->get('logo');
$logo_mobil                 = $templateparams->get('logo_mobil');
$hidecontentwrapper         = $templateparams->get('hidecontentwrapper', 0);
$logoposition               = $templateparams->get('logoposition', 1);
$logowidth_md               = $templateparams->get('logowidthmd', 4);
$logowidth_sm               = $templateparams->get('logowidthsm', 4);
$logowidth_xs               = $templateparams->get('logowidthxs', 4);
$jquery                     = $templateparams->get('jquery',1);
$footercols                 = $templateparams->get('footercols', 4);
$fixedheader                = $templateparams->get('fixedheader', 0);
$headerimg                  = $templateparams->get('headerimg-select', 1);
$navbarHeaderWidth          = $templateparams->get('navbarheader-width', 1);
$sourcebgimage              = $templateparams->get('image-body');
$bgimage                    = $templateparams->get('image-body-select', 0);
$headerimgSizeClass         = ( $templateparams->get('headerimg-width') == 2 ) ? 'sm-slider' : 'lg-slider';
$fontsize                   = $templateparams->get('fontsize', 0);
$fontsize_pos               = $templateparams->get('fontsize-position', 1);
$compress_css               = $templateparams->get('compress_css', 1) == 1  ? '.min' : '';
$offcanvas                  = $templateparams->get('offcanvas', 1);
$offcanvas_pos              = $templateparams->get('offcanvas_pos','left');
$toggle_offcanvas_pos       = $templateparams->get('toggle_offcanvas_pos','left');
$offcanvas_breakpoint       = $templateparams->get('offcanvas_breakpoint');
$offcanvas_width            = $templateparams->get('offcanvas_width',300);
$offcanvas_navbar_height    = $templateparams->get('offcanvas_navbar_height',80);
$iconright                  = $templateparams->get('iconfixedright','fa fa-bars');
$iconleft                   = $templateparams->get('iconfixedleft','fa fa-bars');
$toggleright                = $templateparams->get('toggleright', 0);
$toggleleft                 = $templateparams->get('toggleleft', 0);
$classbody                  = $templateparams->get('bodyclass', 'default');
$floatingLabels             = $templateparams->get('floatingLabels', 0);
$bgnavbar                   = $templateparams->get('bgnavbar', 0);
$flexicontent               = $templateparams->get('flexicontent', 0);
$searchsiteId               = $templateparams->get('searchsite');
$styleswitch                = $templateparams->get('styleswitch');
$styleswitch_pos            = $templateparams->get('styleswitch-position');

// Breite der 2 Spalte wenn logo im Header
$col_md_header_top01 = 12;
$col_sm_header_top01 = 12;
$col_xs_header_top01 = 12;

if ($logoposition == 2) {
	$col_md_header_top01 = ( $logowidth_md != 12 ) ? 12 - $logowidth_md : 12;
	$col_sm_header_top01 = ( $logowidth_sm != 12 ) ? 12 - $logowidth_sm : 12;
	$col_xs_header_top01 = ( $logowidth_xs != 12 ) ? 12 - $logowidth_xs : 12;
}

if ($NavMainPos == 4) { $showleftColumn++; }
if ($NavMainPos == 5) { $showrightColumn++; }

/** Startseite und aktiven Menuepunkt  ermitteln *****/
$menu                     = $app->getMenu();
$activeMenu               = $menu->getActive(); // aktive Menue
$activeMenuId             = isset($activeMenu->id);    // aktive Menue ID
$activeMenuTitle          = isset($activeMenu->title); // aktiven Menuetitel

/**      klasse setzen für Bodytag   *****/
if ($menu->getActive() == $menu->getDefault($lang->getTag())) {
	$frontpage = 1;
	$classbody .= ' front';
} else {
	$frontpage = 0;
	$classbody  .= ' nofront';
}

$classbody  .= $pageclass;
if ($bgimage == 1 && $templateparams->get('image-body')) {
	$classbody .= ' bgimage-01';
}

/* ------------------------------------------------------------------------------*/

// Bootstrap Klassen
$bootstrap_colclass              = "col-lg-";
$bootstrap_colclass_mobil_sm     = "col-md-";
$bootstrap_colclass_mobil_xs     = "col-";
$bootstrap_rowclass              = "row";
$bootstrap_offsetclass           = "col-lg-offset-";
$bootstrap_offsetclass_mobil_sm  = "col-md-offset-";
$bootstrap_offsetclass_mobil_xs  = "col-offset-";

$containercss =  ( $navbarHeaderWidth == 1 ) ? '-fluid' : ''; // Header  zentriert oder volle breite

// Adjusting content width

$cols        = "12";
$cols_sm     = "12";
$classinside = 'inside-left inside-right';
$col_left    =  ( $colSidebarLeft_sm == 12 )  ? 0 : $colSidebarLeft_sm;
$col_right   =  ( $colSidebarRight_sm == 12 ) ? 0 : $colSidebarRight_sm;

if ($showleftColumn) {
	$cols         = 12 -  $colSidebarLeft;
	$cols_sm      = 12 -  $col_left;
	$classinside  = "inside-left inside-right";
}
elseif ($showrightColumn) {
	$cols          = 12 -  $colSidebarRight;
	$cols_sm       = 12 -  $col_right;
	$classinside  .= "inside-left inside-right";
}

if(($showleftColumn) && ($showrightColumn)) {
	$cols = 12 - ( $colSidebarLeft + $colSidebarRight );
	$cols_sm = 12 - ( $col_left + $col_right );
	$classinside  = "inside-left inside-right";
}

// generator tag
$this->setGenerator(null);

// force latest IE & chrome frame
if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)) {
	$doc->setMetadata('x-ua-compatible', 'IE=edge,chrome=1');
}

$doc->setMetadata('viewport', '');
$doc->setMetadata('content-language',substr($this->language, 0, 2));

// Enable assets
$wa->usePreset('template.wbc')
	->useStyle('template.user')
	->useScript('template.user');

// Defer font awesome
$wa->getAsset('style', 'fontawesome')->setAttribute('rel', 'lazy-stylesheet');

foreach ($customcss as $value) {

	if ((File::exists( JPATH_ROOT. '/templates/'.$this->template . '/css/'.$value ) ) ) {
		$doc->addStyleSheet($tpath . '/css/' .$value, array('version' => 'auto'));
	} // else { echo "CSS Datei" . $customcss.  "nicht vorhanden"; }
}

/* Default CSS Alternativ */
if ((File::exists( JPATH_ROOT. '/templates/'.$this->template . '/css/default.css') ) ) {
	$doc->addStyleSheet( $tpath . '/css/default.css', array(
		'version' => 'auto'),
		array('id'=>'stylesheet', 'title'=>'default')
	);
}

/* Hochkontrast CSS Alternativ */

if ($styleswitch) {
	if ((File::exists( JPATH_ROOT. '/templates/'.$this->template . '/css/hk.css') ) ) {
		$doc->addStyleSheet( $tpath . '/css/hk.css', array(
			'version' => 'auto'),
			array('id'=>'stylesheet', 'title'=>'hk')
		);
	}
}
/**************************************************************************************/

if ($bgimage == 1 ) {
	$Tmplstyle  = '.bgimage-01 { background-image: url(" ';
	$Tmplstyle  .= $this->baseurl. '/images/headers/' . $sourcebgimage.'"); ';
	$Tmplstyle  .= 'background-size: cover;';
	$Tmplstyle  .= 'background-repeat: no-repeat;';
	$Tmplstyle  .= 'background-position: center center;';
	$Tmplstyle  .= '}';
	$doc->addStyleDeclaration($Tmplstyle);
}

// jquery plugin smooth scroll

if ($functions == 1 ) $doc->addScript($tpath . '/js/vendor/page-scroll-to-id/js/jquery.malihu.PageScroll2id.min.js');

// Suchen Seite

if ($flexicontent == 1 ) {
	/* link zur Flexicontent Suchen Seite generieren */
	require_once (JPATH_ADMINISTRATOR.'/components/com_flexicontent/defineconstants.php');
	require_once (JPATH_SITE.'/components/com_flexicontent/helpers/route.php');
	$searchsite = JRoute::_(FlexicontentHelperRoute::getSearchRoute($this->params->get($searchsiteId)));
} else {
	$searchsite = '';
}

$displayData = array(
			'jhtml'                         => $this,
			'sidebar'                       => array( 0=>'left', 1=>'right'),
			'templateparams'                => $templateparams,
			'offcanvas'                     => $offcanvas,
			'offcanvas_pos'                 => $offcanvas_pos,
			'offcanvas_breakpoint'          => $offcanvas_breakpoint,
			'offcanvas_width'               => $offcanvas_width,
			'toggle_offcanvas_pos'          => $toggle_offcanvas_pos,
			'offcanvas_navbar_height'       => $offcanvas_navbar_height,
			'logoposition'                  => $logoposition,
			'logo_mobil'                    => $logo_mobil,
			'logo'                          => $logo,
			'toggleleft'                    => $toggleleft,
			'toggleright'                   => $toggleright,
			'fontsize'                      => $fontsize,
			'fontsize_pos'                  => $fontsize_pos,
			'styleswitch'                   => $styleswitch,
			'styleswitch_pos'               => $styleswitch_pos,
			'tpath'                         => $tpath,
			'fontawesome'                   => $fontawesome,
			'iconleft'                      => $iconleft,
			'iconright'                     => $iconright,
			'bgnavbar'                      => $bgnavbar,
			'headerimg'                     => $headerimg,
			'footercols'                    => $footercols,
			'headerimgSizeClass'            => $headerimgSizeClass,
			'bootstrap_colclass'            => $bootstrap_colclass,
			'bootstrap_colclass_mobil_sm'   => $bootstrap_colclass_mobil_sm
);

$this->setMetaData('viewport', 'width=device-width, initial-scale=1');
