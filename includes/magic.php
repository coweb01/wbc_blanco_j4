<?php
//  Load systemvariables
//  magic.php
//  tmpl: wbc_blanco

/* Parameter und Systemvariablen */

defined( '_JEXEC' ) or die;

use Joomla\CMS\Factory;
use Joomla\Filesystem\File;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\Component\Fields\Administrator\Helper\FieldsHelper;

/** @var Joomla\CMS\Document\HtmlDocument $this */

$app                = Factory::getApplication();
$doc                = $app->getDocument();
$mediapath          = 'media/templates/site/wbc_blanco_j4/';
$wa                 = $this->getWebAssetManager();

$lang               = $app->getLanguage(); //sprachstring bei mehrsprachigen seiten
$templateparams     = $app->getTemplate(true)->params; // Templateparameter
$sitename           = htmlspecialchars($app->get('sitename'), ENT_QUOTES, 'UTF-8'); // sitename in joomla konfigurationsdatei definiert
$params             = $app->getParams(); //Parameter Menue
$pageclass          = $params->get('pageclass_sfx'); // parameter (menu entry)
$NavMainPos         = $templateparams->get('navmain',1);
$showrightColumn    = 0;
$showleftColumn     = 0;
$counter            = 0;
$himg               = false;

// custom css styles in Tabelle speichern
$customcss          = array();
if (!empty($templateparams->get('customcss'))) {
    $customcss          = explode (',',$templateparams->get('customcss'));
}

if ($NavMainPos == 5 ) {
    // Hauptnavigation rechts
    $showrightColumn    = $this->countModules('navMain');
}
if ($NavMainPos == 4 ) {
    // Hauptnavigation links
    $showleftColumn     = $this->countModules('navMain');
}

$pos_search = '';
if ($module = ModuleHelper::getModule('finder')) {;
    $pos_search = $module->position;
    $anker_search = 'id="suche-'. $pos_search. '"';
}

$showrightColumn            = $showrightColumn + (($this->countModules('right-01')) || ($this->countModules('right-02')) || ($this->countModules('nav-sidebar-right')));
$showleftColumn             = $showleftColumn + (($this->countModules('left-01')) || ($this->countModules('left-02')) || ($this->countModules('nav-sidebar-left'))); // erforderliche Spalten ermitteln
$colSidebarLeft             = $templateparams->get('colsidebarleft',3);
$colSidebarRight            = $templateparams->get('colsidebarright',3);
$colSidebarLeft_sm          = $templateparams->get('colsidebarleft_sm',4);
$colSidebarRight_sm         = $templateparams->get('colsidebarright_sm',4);
$holder                     = $templateparams->get('holder');
$fontawesome                = $templateparams->get('fontawesome');
$logo                       = $templateparams->get('logo');
$logo_mobil                 = $templateparams->get('logo_mobil');
$sitetitle                  = $templateparams->get('sitetitle');
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
/* offcanvas Menue*/

$offcanvas_pos              = $templateparams->get('offcanvas_pos');
$toggle_offcanvas_pos       = $templateparams->get('toggle_offcanvas_pos');
$offcanvas_breakpoint       = $templateparams->get('offcanvas_breakpoint');
$dClass    = '';
if ($offcanvas_breakpoint == 'navbar-expand-sm') {
    $dClass = 'd-sm-none';
}
if ($offcanvas_breakpoint == 'navbar-expand-md') {
    $dClass = 'd-md-none';
}
if ($offcanvas_breakpoint == 'navbar-expand-lg') {
    $dClass = 'd-lg-none';
}
if ($offcanvas_breakpoint == 'navbar-expand-xl') {
    $dClass = 'd-xl-none';
}
if ($offcanvas_breakpoint == 'navbar-expand-xxl') {
    $dClass = 'd-xxl-none';
}
$offcanvas_width            = $templateparams->get('offcanvas_width');
$offcanvas_navbar_height    = $templateparams->get('offcanvas_navbar_height');
$offcanvas_color            = $templateparams->get('offcanvas_color');
/* end offcanvas */
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

$classbody .= $pageclass;
if ($bgimage == 1 && $templateparams->get('image-body')) {
    $classbody .= ' bgimage-01';
}

$input = $app->getInput();
$view     = $input->getCmd('view', '');
$layout   = $input->getCmd('layout', '');
$task     = $input->getCmd('task', '');
$itemid   = $input->getCmd('Itemid', '');
$classbody .=  ' view-' . $view
. ($layout ? ' layout-' . $layout : ' no-layout')
. ($task ? ' task-' . $task : ' no-task')
. ($itemid ? ' itemid-' . $itemid : '');

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
$col_left    =  ( $colSidebarLeft_sm == 12 )  ? 0 : $colSidebarLeft_sm;
$col_right   =  ( $colSidebarRight_sm == 12 ) ? 0 : $colSidebarRight_sm;

if ($showleftColumn) {
    $cols         = 12 -  $colSidebarLeft;
    $cols_sm      = 12 -  $col_left;
}
elseif ($showrightColumn) {
    $cols          = 12 -  $colSidebarRight;
    $cols_sm       = 12 -  $col_right;
}

if(($showleftColumn) && ($showrightColumn)) {
    $cols = 12 - ( $colSidebarLeft + $colSidebarRight );
    $cols_sm = 12 - ( $col_left + $col_right );
}

// generator tag
$this->setGenerator(null);

// force latest IE & chrome frame
if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)) {
    $doc->setMetadata('x-ua-compatible', 'IE=edge,chrome=1');
}

$doc->setMetadata('viewport', '');
$doc->setMetadata('content-language',substr($this->language, 0, 2));

// Load Icons
if ($fontawesome == 1)
{
    $wa->useStyle('fontawesome');
}

// Enable assets
$wa->usePreset('template.wbc')
    ->useStyle('template.user')
    ->useScript('template.user');
$i = 1;
foreach ($customcss as $value) {
    if ((file_exists($mediapath . 'css/'.$value ) ) ) {
        $rname = 'custom'.$i;
        $wa->registerAndUseStyle($rname, $mediapath . 'css/'. $value);
    } // else { echo "CSS Datei" . $customcss.  "nicht vorhanden"; }
    $i++;
}

/* Default CSS Alternativ */
if ((file_exists( JPATH_ROOT. '/templates/'.$this->template . '/css/default.css') ) ) {
    $wa->registerAndUseStyle('default', $mediapath . 'css/default.css');
}

/* Hochkontrast CSS Alternativ */

if ($styleswitch) {
    if ((file_exists( JPATH_ROOT. '/templates/'.$this->template . '/css/hk.css') ) ) {
        $wa->registerAndUseStyle('hk', $mediapath . 'css/hk.css');
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

//if ($functions == 1 ) $doc->addScript($mediapath . 'js/vendor/page-scroll-to-id/js/jquery.malihu.PageScroll2id.min.js');//

// Template Java Script
$wa->registerAndUseScript('funktion', $mediapath . 'js/funktion.js', [], ['defer' => true], []);

// Suchen Seite

// check if Flexicontent is enabled
if ( ComponentHelper::getComponent('com_flexicontent', true)->enabled === 1 ) {
    /* link zur Flexicontent Suchen Seite generieren */
    require_once (JPATH_ADMINISTRATOR.'/components/com_flexicontent/defineconstants.php');
    require_once (JPATH_SITE.'/components/com_flexicontent/helpers/route.php');
    $searchsite = JRoute::_(FlexicontentHelperRoute::getSearchRoute($this->params->get($searchsiteId)));
} else {
    $searchsite = '';
}



/****************************************************************************************************/
/******     Headerbild aus Custom field Beitrag oder Kategorie                                   ****/   
/******     Modul rechts im Bereich content                                                      ****/
/******     Custom Field muss den Namen headerimg / cat-headerimg haben                          ****/
/****************************************************************************************************/

if (strpos($activeMenu->link, 'com_content') !== false &&  strpos($activeMenu->link, 'view=article') !== false ||
    strpos($activeMenu->link, 'com_content') !== false &&  strpos($activeMenu->link, 'view=category') !== false)
{
    $input = JFactory::getApplication()->input;
    $id = $input->get('id', 0, 'UINT');
    $context = 'com_content.article';
    $arrayKey = array('header' => '', 'content' => '');

    switch ($view) {
        case 'article':
        case 'form':
            $item    = $app->bootComponent('com_content')->getMVCFactory()->createModel('Article', 'Administrator')->getItem($id);
            $context = 'com_content.article';
            $arrayKey['header'] = 'headerimg';
            $arrayKey['content'] = 'content-pos-right';
            break;
        case 'category':
            $item    = $app->bootComponent('com_categories')->getMVCFactory()->createModel('Category', 'Administrator', ['ignore_request' => true])->getItem($id);
            $context = 'com_content.categories';
            $arrayKey['header'] = 'cat-headerimg';
            break;
    }
    // alle Custom Fields des Beitrags oder der Kategorie
    $fields = FieldsHelper::getFields($context, $item, true);
    if ($fields){
        foreach($fields as $field)
        {
            $fields[$field->name] = $field;
        }
    }
    // wenn $arrayKey ( headerimg / cat-headerimg / content-pos-right ) im Array vorhanden 
    foreach ($arrayKey as $key => $keycontent) {
        if (array_key_exists($keycontent,$fields ) && !empty($fields[$keycontent]->value))  {
            $CustomModules[$key]['value']       =  $fields[$keycontent]->value;
            $CustomModules[$key]['rawvalue']    =  $fields[$keycontent]->rawvalue;
            if ( $key == "header") {
                $himg = true;
            }
        }
    } 
}

$displayData = array(
            'jhtml'                         => $this,
            'sitename'                      => $sitename,
            'sidebar'                       => array( 0=>'left', 1=>'right'),
            'templateparams'                => $templateparams,
            'offcanvas_pos'                 => $offcanvas_pos,
            'offcanvas_breakpoint'          => $offcanvas_breakpoint,
            'offcanvas_width'               => $offcanvas_width,
            'toggle_offcanvas_pos'          => $toggle_offcanvas_pos,
            'offcanvas_color'               => $offcanvas_color,
            'offcanvas_navbar_height'       => $offcanvas_navbar_height,
            'dClass'                        => $dClass,
            'logoposition'                  => $logoposition,
            'logo_mobil'                    => $logo_mobil,
            'logo'                          => $logo,
            'sitetitle'                     => $sitetitle,
            'toggleleft'                    => $toggleleft,
            'toggleright'                   => $toggleright,
            'fontsize'                      => $fontsize,
            'fontsize_pos'                  => $fontsize_pos,
            'styleswitch'                   => $styleswitch,
            'styleswitch_pos'               => $styleswitch_pos,
            'mediapath'                     => $mediapath,
            'fontawesome'                   => $fontawesome,
            'iconleft'                      => $iconleft,
            'iconright'                     => $iconright,
            'bgnavbarcolor'                 => $bgnavbar,
            'headerimg'                     => $headerimg,
            'footercols'                    => $footercols,
            'headerimgSizeClass'            => $headerimgSizeClass,
            'bootstrap_colclass'            => $bootstrap_colclass,
            'bootstrap_colclass_mobil_sm'   => $bootstrap_colclass_mobil_sm,
            'CustomModules'                 => isset($CustomModules) ? $CustomModules : '',
);
$this->setMetaData('viewport', 'width=device-width, initial-scale=1');

// script für den Styleumschalter HK / Default
if($styleswitch == 1) {
    $wa->registerAndUseScript('switcher', $mediapath . 'js/CSSswitcher.js', [], ['defer' => true], []);
}

//  script fixed Header on scroll
if ($fixedheader == 1) {
    $wa->registerAndUseScript('scroller', $mediapath . 'js/vendor/scrollPosStyler.min.js', [], ['defer' => true], []);
}
