<?php
/**********************************************************
 * Template Blanco
 * Template Joomla 4
 * Kunde:
 * Author: Claudia Oerter / Viviana Menzel
 * Stand: 10 / 2023
 * Version: 1.1.1
 * copyright Template das webconcept
 **********************************************************/
defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\FileLayout;
use Joomla\Component\Fields\Administrator\Helper\FieldsHelper;
use Joomla\CMS\Categories\Categories;
use Joomla\CMS\HTML\HTMLHelper;

// Template path
$template    = $this->template;
$mediapath   = 'media/templates/site/'.$this->template.'/';
$tpath       = 'templates'. $template .'/';
$includepath = 'templates/wbc_blanco_j4/includes/';

include $includepath.'magic.php'; // load magic.php
if (!isset($bootstrap_colclass_mobil_sm)) { $bootstrap_colclass_mobil_sm = ''; };
if (!isset($bootstrap_colclass_mobil_xs)) { $bootstrap_colclass_mobil_xs = ''; };

$modNoBC = $this->countModules('vorInhalt-01-col');
$modNoAC = $this->countModules('nachInhalt-01-col');
$repeatAC = '';
if ($modNoBC > 3) {
    $repeatBC = 3;
} else {
    $repeatBC = $modNoBC;
}
if ($modNoAC > 3) {
    $repeatAC = 3;
} else {
    $repeatAC = $modNoAC;
}
$wa->addInlineStyle('
@media (min-width: 992px) {
  #wbc-vorInhalt-01-col {
    --repeatBC: ' . $repeatBC . ';
  }
  #wbc-nachInhalt-01-col {
    --repeatAC: ' . $repeatAC . ';
  }
}
');

// Favicons https://realfavicongenerator.net/
$this->addHeadLink(HTMLHelper::_('image', 'favicons/apple-touch-icon.png', '', [], true, 1), 'apple-touch-icon', 'rel', ['sizes' => '180x180']);
$this->addHeadLink(HTMLHelper::_('image', 'favicons/favicon-32x32.png', '', [], true, 1), 'icon', 'rel', ['sizes' => '32x32', 'type' => 'image/png']);
$this->addHeadLink(HTMLHelper::_('image', 'favicons/favicon-16x16.png', '', [], true, 1), 'icon', 'rel', ['sizes' => '16x16', 'type' => 'image/png']);
$this->addHeadLink(HTMLHelper::_('image', 'favicons/safari-pinned-tab.svg', '', [], true, 1), 'mask-icon', 'rel', ['color' => '#41599a']);
$this->addHeadLink(HTMLHelper::_('image', 'favicons/favicon.ico', '', [], true, 1), 'shortcut icon', 'rel', ['type' => 'image/vnd.microsoft.icon']);
$this->addHeadLink($mediapath . 'images/favicons/site.webmanifest', 'manifest', 'rel', []);
$this->setMetaData('msapplication-config', $mediapath . 'images/favicons/browserconfig.xml');
$this->setMetaData('theme-color', '#ffffff');

if (($this->params->get('headerimg') != NULL) && ($this->params->get('headerimg') != "-1")) {
    $himg = true;
}
$footerwidth = 'container-fluid';
if (($this->params->get('footerwidth') == 1)) {
    $footerwidth = 'container-xl';
}
$nocontent = '';
if (($this->params->get('hidecontentwrapper') == 1)) {
    $nocontent = 'wbc-nocontent';
}

?>

<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <jdoc:include type="metas" />
    <?php include $includepath.'style.php';?>
    <jdoc:include type="styles" />
    <jdoc:include type="scripts" />

<!-- ***************************************************************************************************** -->
<!-- *****     copyright Template www.das-webconcept.de       2023                                    **** -->
<!-- ***************************************************************************************************** -->
</head>
<body id="top" class="body-01 <?php echo $classbody; ?>">

    <div class="prevent-scrolling">

        <?php
        if( $this->countModules('sidebar-left-fix') ||
            $this->countModules('sidebar-left-toggle') ||
            $toggleleft) : ?>

        <!-- fixed sidebars -->
            <?php $LayoutSidebar = new FileLayout('wbc_blanco_template.fixedsidebars', $tpath.'html/layouts');

            $ReplacedisplayData = array( 'side' => 'left',
                                        'toggle' => $toggleleft,
                                        'pos' => '3'
                                        );
            $displayData = array_replace( $displayData, $ReplacedisplayData);
            echo $LayoutSidebar ->render($displayData); ?>

        <?php endif; ?>

        <?php
        if( $this->countModules('sidebar-right-fix') ||
            $this->countModules('sidebar-right-toggle') ||
            $toggleright) : ?>

            <?php $LayoutSidebar = new FileLayout('wbc_blanco_template.fixedsidebars', $tpath.'html/layouts');

            $ReplacedisplayData = array( 'side' => 'right',
                                        'toggle' => $toggleright,
                                        'pos' => '4'
                                        );
            $displayData = array_replace( $displayData, $ReplacedisplayData);
            echo $LayoutSidebar ->render($displayData); ?>
        <!-- end fixed sidebars -->
        <?php endif; ?>

        <?php /* wenn Modul grossflaechiges hintergrundbild */?>
        <?php if ($this->countModules('bg-01')) : ?>
        <div id="bg">
            <jdoc:include type="modules" name="bg-01" style="none" />
        </div>
        <?php endif; ?>

        <div class="wrap-outer">
            <!-- ****************************************************************************************************** -->
            <!-- *     Header                                                                                         * -->
            <!-- ****************************************************************************************************** -->
            <header class="header <?php echo ($navbarHeaderWidth == 1) ? 'header-fluid' : '';?>" aria-label="<?php echo Text::_('TPL_WBC_BLANCO_J4_HEADER'); ?>">
                <div class="header-top <?php echo ($fixedheader == 1) ? 'sps' :'';?>" >

                    <?php if ($this->countModules('header-top-01') ) : ?>
                    <div class="container<?php echo ($navbarHeaderWidth == 1) ? '-fluid' : '';?>">
                        <div id="header-top-01" class="base-row <?php echo $bootstrap_rowclass; ?> d-none d-sm-block">
                            <div class="base-col col">
                                <jdoc:include type="modules" name="header-top-01" style="none" />
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="container<?php echo ( $navbarHeaderWidth == 1) ? '-fluid' : '';?>">

                        <?php if ($logoposition == 2) : ?>
                            <?php
                                $LayoutLogo = new FileLayout('wbc_blanco_template.logopos', $tpath.'html/layouts');
                                echo $LayoutLogo ->render($displayData);
                            ?>
                        <?php endif; ?>

                        <?php if ($this->countModules('navMain') && $NavMainPos == 1 || $this->countModules('offcanvas') && $NavMainPos == 1): ?>
                        <nav id="navigation-main" class="navbar <?php echo $offcanvas_breakpoint; ?> <?php echo ($fixedheader == 1) ? 'sps' :'';?>" aria-label="Main Navigation">
                            <?php
                                $LayoutMain = new FileLayout('wbc_blanco_template.navmain', $tpath.'html/layouts');
                                echo $LayoutMain ->render($displayData);
                            ?>
                        </nav>
                        <?php endif; ?>
                    </div>
                </div><!-- End header-top -->

                <?php if ($NavMainPos == 2 || $this->countModules('header-top-02') || $logoposition == 3 || $NavMainPos == 3 || ($himg == true) || ($this->countModules('headerimg'))): ?>
                <div class="header-middle">

                <?php if ($this->countModules('navMain') && $NavMainPos == 2 || $this->countModules('offcanvas') && $NavMainPos == 2): ?>
                        <nav id="navigation-main" class="navbar <?php echo $offcanvas_breakpoint; ?> <?php echo ($fixedheader == 1) ? 'sps' :'';?>" aria-label="Main Navigation">
                            <?php
                                $LayoutMain = new FileLayout('wbc_blanco_template.navmain', $tpath.'html/layouts');
                                echo $LayoutMain ->render($displayData);
                            ?>
                        </nav>
                    <?php endif; ?>

                    <?php if ($this->countModules('header-top-02')): ?>
                        <div <?php echo ($pos_search == 'header-top-02') ? $anker_search : ''; ?> class="header-02 container<?php echo ( $navbarHeaderWidth == 1) ? '-fluid' : '';?>">
                            <div id="header-top-02" class="base-row <?php echo $bootstrap_rowclass; ?>">
                                <?php if ($this->countModules('header-top-02')) : ?>
                                <div class="base-col col">
                                    <jdoc:include type="modules" name="header-top-02" style="none" />
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($logoposition == 3) : ?>
                        <div class="header-02" role="heading">
                            <div class="base-row <?php echo $bootstrap_rowclass; ?>">
                                <?php
                                    $LayoutLogo = new FileLayout('wbc_blanco_template.logopos', $tpath.'html/layouts');
                                    echo $LayoutLogo ->render($displayData);
                                ?>
                            </div>
                        </div><!-- End header-02 -->
                    <?php endif; ?>

                    <?php if ( ($himg == true) || ($this->countModules('headerimg')) ) :
                    /* wenn headerbild */
                    ?>
                        <?php
                            $Layoutheaderimg = new FileLayout('wbc_blanco_template.headerimg', $tpath.'html/layouts');
                            echo $Layoutheaderimg->render($displayData);
                        ?>
                    <?php endif; ?>

                    <?php if ($this->countModules('navMain')  && $NavMainPos == 3 || $this->countModules('offcanvas')  && $NavMainPos == 3): ?>
                        <nav id="navigation-main" class="navbar <?php echo $offcanvas_breakpoint; ?> <?php echo ($fixedheader == 1) ? 'sps' :'';?>" aria-label="Main Navigation">

                        <?php if ($fixedheader && $this->countModules('logo-mobil')): ?>
                        <div id="logo-mobil" class="navbar-brand hidden">
                            <jdoc:include type="modules" name="logo-mobil" style="none" />
                        </div>
                        <?php endif; ?>
                        <div class="container <?php echo $fixedheader ? 'container-fixed ' : '' ;?>">
                            <?php
                                $LayoutMain = new FileLayout('wbc_blanco_template.navmain', $tpath.'html/layouts');
                                echo $LayoutMain ->render($displayData);
                            ?>
                        </div>
                    </nav>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </header>
            <!-- ********************  End Header ******************************************************************** -->

            <!-- ****************************************************************************************************** -->
            <!-- *    Main Content                                                                                   * -->
            <!-- ****************************************************************************************************** -->
            <?php if ($headerimg == 0) :?>
            <div class="no-headerimg separator"></div>
            <?php endif;?>

            <?php if ($this->countModules('onepagetop')): ?>
            <jdoc:include type="modules" name="onepagetop" style="onepage"/>
            <?php endif;?>


            <?php if ($this->countModules('breadcrumb')): ?>
            <!-- start Breadcrumbs -->
            <div id="wrap-breadcrumb">
                <div class="container">
                    <div class="base-row <?php echo $bootstrap_rowclass; ?>">
                        <div class="base-col <?php echo $bootstrap_colclass; ?>12">
                            <jdoc:include type="modules" name="breadcrumb" style="none" />
                        </div>
                    </div>
                </div>
            </div>
            <!-- end breadcrumbs -->
            <?php endif; ?>

            <main>
                <div class="container main">
                    <!-- Begin Container content-->
                    <div class="main-content">
                        <div class="base-col <?php echo $bootstrap_rowclass; ?>">

                            <?php if($showleftColumn) : ?>

                            <!-- ****************************************************************************************************** -->
                            <!-- *    Sidebar left                                                                                    * -->
                            <!-- ****************************************************************************************************** -->

                            <div id="sidebar-left" role="complementary" class="append-sidebar-left base-col col-12 <?php echo $bootstrap_colclass_mobil_sm . $colSidebarLeft_sm . ' ' . $bootstrap_colclass . $colSidebarLeft; ?>" data-set="appendsection" aria-label="Sidebar left">


                                <?php if ($this->countModules('nav-sidebar-left')) : ?>
                                <div id="toggle-menu-left"><jdoc:include type="modules" name="nav-sidebar-left" style="default" /></div>
                                <?php endif; ?>
                                <?php echo ($pos_search == 'left-01') ? '<div '. $anker_search .'></div>' : ''; ?>
                                <jdoc:include type="modules" name="left-01" style="card" /><!--End left-01-->
                                <?php echo ( $pos_search == 'left-02') ? '<div'. $anker_search .'></div>' : ''; ?>
                                <jdoc:include type="modules" name="left-02" style="none" /><!--End left-02-->
                            </div>
                            <!-- ***************************** End Sidebar Left ****************************************************** -->
                            <?php endif; ?>

                            <div id="wrap-content" class="base-row col-12 <?php echo $bootstrap_colclass_mobil_sm . $cols_sm . ' ' . $bootstrap_colclass . $cols . ' ' . $nocontent;?>">
                                <div class="contentarea">
                                    <noscript>
                                    <!-- Anzeige wenn kein JavaScript -->
                                    <div class="alert alert-danger" role="alert"><?php echo Text::_('TPL_WBC_BLANCO_J4_INFOTXTJS'); ?></div>
                                    <!-- Ende -->
                                    </noscript>

                                    <jdoc:include type="message" />

                                    <div id="wrap-nav-sidebar-append" class="append-sidebar-before" data-set="appendsectionone"></div>
                                    <?php if ($this->countModules('vorInhalt-01') > 0) : ?>
                                    <div id="vorInhalt-01">
                                        <jdoc:include type="modules" name="vorInhalt-01" style="default" />
                                    </div>
                                    <?php endif; ?>

                                    <?php if ($this->countModules('vorInhalt-01-col') > 0) {
                                        /* wenn Modul mehrspaltig */
                                        $LayoutModules = new FileLayout('wbc_blanco_template.cardmodules', $tpath.'html/layouts');

                                        $ReplacedisplayData = array('Modules' => 'vorInhalt-01-col');

                                        $displayData = array_replace($displayData, $ReplacedisplayData);
                                        echo $LayoutModules->render($displayData);
                                    }
                                    ?>

                                    <?php /* contentbereich + module anzeigen */?>
                                    <?php if (!$hidecontentwrapper) : ?>
                                    <div class="base-row row">
                                        <div class="base-col col ">
                                            <jdoc:include type="component" />
                                        </div>
                                        <?php if ( $this->countModules('content-right') || 
                                                    (isset($CustomModules['content']) && !empty($CustomModules['content'])) ) : ?>
                                                <div class="base-col col-lg-4 my-5 my-lg-0">
                                                    <?php if (isset($CustomModules['content']) && !empty($CustomModules['content'])) : ?>
                                                        <?php echo $CustomModules['content']['value']; ?> 
                                                    <?php else : ?>   
                                                        <jdoc:include type="modules" name="content-right" style="default" />
                                                    <?php endif; ?>
                                                </div>   
                                        <?php endif; ?>    
                                    </div>
                                    <?php endif; ?>

                                    <?php if ($this->countModules('nachInhalt-01-col') > 0) {
                                        /* wenn Module mehrspaltig */
                                        $LayoutModules = new FileLayout('wbc_blanco_template.cardmodules', $tpath.'html/layouts');

                                        $ReplacedisplayData = array('Modules' => 'nachInhalt-01-col');

                                        $displayData = array_replace($displayData, $ReplacedisplayData);
                                        echo $LayoutModules->render($displayData);
                                    }
                                    ?>
                                </div> <!-- Contenarea -->
                            </div><!--Content -->

                            <?php if ($showrightColumn) : ?>
                            <!-- ****************************************************************************************************** -->
                            <!-- *    Sidebar right                                                                                   * -->
                            <!-- ****************************************************************************************************** -->
                            <div id="sidebar-right" role="complementary" class="base-col col-12 <?php echo $bootstrap_colclass_mobil_sm . $colSidebarRight_sm . ' ' . $bootstrap_colclass . $colSidebarRight ; ?>" aria-label="Sidebar right">

                                <?php if ($this->countModules('nav-sidebar-right')) : ?>
                                <div class="append-sidebar-nav" data-set="appendsectionone">
                                    <nav id="wrap-nav-sidebar-right" aria-label="Nav sidebar right">
                                        <a href="#" id="toggle-btn-right" class="wbc-toggle-btn">
                                            <p class="headline-submenue d-inline visually-hidden"><?php echo Text::_('TPL_WBC_BLANCO_J4_HEADLINE_SUBMENUSIDEBAR'); ?> </p>
                                            <p class="d-inline wbc-hamburger">
                                                <span class="line"></span>
                                                <span class="line"></span>
                                                <span class="line"></span>
                                            </p>
                                        </a>
                                        <div id="toggle-container-right">
                                            <jdoc:include type="modules" name="nav-sidebar-right" style="default" />
                                        </div>
                                    </nav>
                                </div>
                                <?php endif; ?>

                                <?php echo ($pos_search == 'right-01') ? '<div '. $anker_search .'></div>' : ''; ?>
                                <jdoc:include type="modules" name="right-01" style="card" /><!--End right-01-->
                                <?php echo ($pos_search == 'right-02') ? '<div '. $anker_search .'></div>' : ''; ?>
                                <jdoc:include type="modules" name="right-02" style="none" /><!--End right-02-->
                            </div>
                            <!-- ******************************** End Sidebar Right ************************************************** -->
                            <?php
                            endif;
                            ?>
                        </div><!--End Row-->
                    </div><!--End Container main-Content-->

                    <div class="clearfix"></div>

                    <?php if ($this->countModules('nachInhalt-02')) : ?>
                    <div id="wrap-nach-content-02">
                        <jdoc:include type="modules" name="nachInhalt-02" style="default" />
                    </div>
                    <?php endif; ?>
                </div> <!-- end container -->
                </main> <!-- end main -->
            <!-- </div> end wrap-main -->

            <div class="clearfix"></div>
            <!-- ****************************  End Main Content ***************************************************** -->

            <?php if ($this->countModules('onepagebottom')) : ?>
                <jdoc:include type="modules" name="onepagebottom" style="onepage"/>
            <?php endif; ?>

        </div> <!-- wrap outer -->
        <!-- ****************************************************************************************************** -->
        <!-- *    Footer                                                                                         * -->
        <!-- ****************************************************************************************************** -->

        <footer id="wrap-footer" class="wbc-footer">

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

            <?php $modpos = 'footer'; ?>
            <?php if ($this->countModules($modpos)) : ?>
            <div id="footer-middle" class="wbc-footer-middle">
                <div class="<?php echo $footerwidth; ?>">
                    <?php
                        $LayoutFooter = new FileLayout('wbc_blanco_template.footermodules', $tpath.'html/layouts');
                        echo $LayoutFooter ->render($displayData);
                    ?>
                </div>
            </div>
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
        <!--End Footer-->
        <jdoc:include type="modules" name="debug" style="none" />

        <a href="#top" id="back-top" class="back-to-top-link" aria-label="<?php echo Text::_('TPL_WBC_BLANCO_J4_TOP'); ?>">
            <span class="fa fa-chevron-up" aria-hidden="true"></span>
        </a>

        <div id="gototop-mobil" class="d-flex d-sm-none shadow-sm p-1 fixed-bottom">
            <a class="gototop" href="#top">
                <i class="fa fa-chevron-up"></i>
                <span class="visually-hidden"> <?php echo Text::_('TPL_WBC_BLANCO_J4_TOP'); ?></span>
            </a>
            <jdoc:include type="modules" name="fixed-footer-mobil" style="none" />
        </div>
    </div> <!-- end prevent-scrolling / used offcanvas -->
</body>
</html>
