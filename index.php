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

// Template path
$mediapath = 'media/templates/site/wbc_blanco_j4/';
$tpath = 'templates/wbc_blanco_j4/';

include 'templates/wbc_blanco_j4/includes/magic.php'; // load magic.php
if (!isset($bootstrap_colclass_mobil_sm)) { $bootstrap_colclass_mobil_sm = ''; };
if (!isset($bootstrap_colclass_mobil_xs)) { $bootstrap_colclass_mobil_xs = ''; };

// Favicons https://realfavicongenerator.net/
$this->addHeadLink($mediapath . 'images/favicons/apple-touch-icon.png', 'apple-touch-icon', 'rel', ['sizes' => '180x180']);
$this->addHeadLink($mediapath . 'images/favicons/favicon-32x32.png', 'icon', 'rel', ['sizes' => '32x32', 'type' => 'image/png']);
$this->addHeadLink($mediapath . 'images/favicons/favicon-16x16.png', 'icon', 'rel', ['sizes' => '16x16', 'type' => 'image/png']);
$this->addHeadLink($mediapath . 'images/favicons/safari-pinned-tab.svg', 'mask-icon', 'rel', ['color' => '#41599a']);
$this->addHeadLink($mediapath . 'images/favicons/site.webmanifest', 'manifest', 'rel', []);
$this->addHeadLink($mediapath . 'images/favicons/favicon.ico', 'shortcut icon', 'rel', []);
$this->setMetaData('msapplication-config', $mediapath . '/images/favicons/browserconfig.xml');
$this->setMetaData('theme-color', '#ffffff');

$himg = false;
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
    <?php include "templates/wbc_blanco_j4/includes/style.php";?>
    <jdoc:include type="styles" />
    <jdoc:include type="scripts" />

<!-- ***************************************************************************************************** -->
<!-- *****     copyright Template www.das-webconcept.de       2023                                    **** -->
<!-- ***************************************************************************************************** -->
</head>
<body id="top" class="body-01 <?php echo $classbody; ?>">

    <div class="prevent-scrolling">
       
        <?php
        if ($offcanvas == 1 && $this->countModules('offcanvas')) :

            $LayoutOffcanvas = new FileLayout('wbc_blanco_template.bts5offcanvas', $tpath.'html/layouts');
            echo $LayoutOffcanvas ->render($displayData);
        endif; ?>

        <!-- Offcanvas Body -->
        <div id="OffcanvasMenu<?php echo $offcanvas_pos; ?>" class="wbc-bs5-offcanvas offcanvas-<?php echo $toggle_offcanvas_pos; ?> offcanvas text-bg-dark"  tabindex="-1" aria-labelledby="wbc-bs5-offcanvasLabel">
            <div class="offcanvas-header mt-3">
                <h5 class="offcanvas-title" id="wbc-bs5-offcanvasLabel"><?php echo Text::_('TPL_WBC_MENU'); ?></h5>
                <button type="button" class="btn-close btn-close-white text-reset" data-bs-dismiss="offcanvas" aria-label="<?php echo Text::_('TPL_WBC_MENU_CLOSE_TXT'); ?>"></button>
            </div>
            <div class="offcanvas-body">
                <jdoc:include type="modules" name="offcanvas"/>
            </div>
        </div>
        <!-- Offcanvas Body -->

      
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
            <header class="header" >
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

                        <?php if ($this->countModules('navMain') && $NavMainPos == 1): ?>
                        <nav id="navigation-main" class="navbar navbar-expand-lg navbar-light <?php echo ($bgnavbar == 1 ) ? 'wbc-bg-navbar' : '';?> <?php echo ($fixedheader == 1) ? 'sps' :'';?>" aria-label="Main Navigation">
                            <?php
                                $LayoutMain = new FileLayout('wbc_blanco_template.navmain', $tpath.'html/layouts');
                                echo $LayoutMain ->render($displayData);
                            ?>
                        </nav>
                        <?php endif; ?>
                    </div>
                </div><!-- End header-top -->

                <div class="header-middle">

                    <?php if ($this->countModules('navMain') && $NavMainPos == 2): ?>
                    <nav id="navigation-main" class="navbar navbar-expand-lg navbar-light <?php echo ($bgnavbar == 1 ) ? 'wbc-bg-navbar' : '';?> <?php echo ($fixedheader == 1) ? 'sps"' :'';?>" aria-label="Main Navigation">
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

                    <?php
                    if (($this->params->get('headerimg-select') == 1) && (($himg == true) || ($this->countModules('headerimg')))) :
                    /* wenn headerbild */
                    ?>
                        <?php
                            $Layoutheaderimg = new FileLayout('wbc_blanco_template.headerimg', $tpath.'html/layouts');
                            echo $Layoutheaderimg->render($displayData);
                        ?>
                    <?php endif; ?>

                    <?php if ($this->countModules('navMain') && $NavMainPos == 3): ?>
                        <nav id="navigation-main" class="navbar navbar-expand-lg navbar-light <?php echo ($bgnavbar == 1 ) ? 'wbc-bg-navbar' : '';?> <?php echo ($fixedheader == 1) ? 'sps"' :'';?>" aria-label="Main Navigation">

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
            <div id="wrap-breadcrumb" class="d-none d-md-block">
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

                            <div id="sidebar-left" role="complementary" class="append-sidebar-left base-col col-12 <?php echo $bootstrap_colclass_mobil_sm . $colSidebarLeft_sm . ' ' . $bootstrap_colclass . $colSidebarLeft; ?>" data-set="appendsection" aria-labelledby="Sidebar left">


                                <?php if ($this->countModules('nav-sidebar-left')) : ?>
                                <div id="toggle-menu-left"><jdoc:include type="modules" name="nav-sidebar-left" style="default" /></div>
                                <?php endif; ?>
                                <?php echo ($pos_search == 'left-01') ? '<div '. $anker_search .'></div>' : ''; ?>
                                <jdoc:include type="modules" name="left-01" style="default" /><!--End left-01-->
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
                                    <?php
                                    if ($this->countModules('vorInhalt-01') > 0) : ?>
                                    <div id="vorInhalt-01">
                                        <jdoc:include type="modules" name="vorInhalt-01" style="default" />
                                    </div>
                                    <?php
                                    endif;
                                    ?>

                                    <?php
                                    if ($this->countModules('vorInhalt-01-col') > 0) : /* wenn Modul mehrspaltig */
                                        $LayoutModules = new FileLayout('wbc_blanco_template.cardmodules', $tpath.'html/layouts');

                                        $ReplacedisplayData = array('Modules' => 'vorInhalt-01-col',
                                                                'Modules_cols' => $vorcontent_cols
                                                                );

                                        $displayData = array_replace($displayData, $ReplacedisplayData);
                                        echo $LayoutModules->render($displayData);
                                    endif;
                                    ?>

                                    <?php
                                    if (!$hidecontentwrapper) : // contentbereich + module anzeigen
                                    ?>
                                    <jdoc:include type="component" />
                                    <?php
                                    endif;
                                    ?>

                                    <?php
                                    if ($this->countModules('nachInhalt-01-col') > 0) : /* wenn Module mehrspaltig */
                                        $LayoutModules = new FileLayout('wbc_blanco_template.cardmodules', $tpath.'html/layouts');

                                        $ReplacedisplayData = array('Modules' => 'nachInhalt-01-col',
                                                                'Modules_cols' => $aftercontent_cols
                                                                );

                                        $displayData = array_replace($displayData, $ReplacedisplayData);
                                        echo $LayoutModules->render($displayData);
                                    endif;
                                    ?>
                                </div> <!-- Contenarea -->
                            </div><!--Content -->

                            <?php
                            if ($showrightColumn) :
                            ?>
                            <!-- ****************************************************************************************************** -->
                            <!-- *    Sidebar right                                                                                   * -->
                            <!-- ****************************************************************************************************** -->
                            <div id="sidebar-right" role="complementary" class="base-col col-12 <?php echo $bootstrap_colclass_mobil_sm . $colSidebarRight_sm . ' ' . $bootstrap_colclass . $colSidebarRight ; ?>" aria-labelledby="Sidebar right">

                                <?php
                                if ($this->countModules('nav-sidebar-right')) :
                                ?>
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
                                <?php
                                endif;
                                ?>

                                <?php echo ($pos_search == 'right-01') ? '<div '. $anker_search .'></div>' : ''; ?>
                                <jdoc:include type="modules" name="right-01" style="icon" /><!--End right-01-->
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
                    <div class="append-sidebar-bottom" role="complementary" data-set="appendsection" aria-labelledby="Sidebar bottom"></div>

                    <?php
                    if ($this->countModules('nachInhalt-02')) :
                    ?>
                    <div id="wrap-nach-content-02">
                        <jdoc:include type="modules" name="nachInhalt-02" style="default" />
                    </div>
                    <?php
                    endif;
                    ?>
                </div> <!-- end container -->
                </main> <!-- end main -->
            <!-- </div> end wrap-main -->

            <div class="clearfix"></div>
            <!-- ****************************  End Main Content ***************************************************** -->

            <?php
            if ($this->countModules('onepagebottom')):
            ?>
            <jdoc:include type="modules" name="onepagebottom" style="onepage"/>
            <?php
            endif;
            ?>

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

        <div id="gototop">
            <a class="mb-2 gototop shadow-sm d-inline-flex justify-content-center align-items-center" href="#top" >
                <i class="fa fa-chevron-up"></i>
                <span class="visually-hidden"><?php echo Text::_('TPL_WBC_BLANCO_J4_TOP'); ?></span>
            </a>
        </div>

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
