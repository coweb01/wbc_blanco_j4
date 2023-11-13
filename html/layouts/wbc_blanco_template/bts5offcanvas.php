<?php
    /* Bootstrap 5 Offcanvas
    *  Author: Webconcept
    */

defined( '_JEXEC' ) or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Layout\LayoutHelper;


HTMLHelper::_('bootstrap.offcanvas','.offcanvas');

/** @var Joomla\CMS\Document\HtmlDocument $this */

extract($displayData);

$app            = Factory::getApplication();
$document       = $app->getDocument();
$template       = $app->getTemplate(true);
$mediapath      = 'media/templates/site/wbc_blanco_j4/';
$tpath          = 'templates/wbc_blanco_j4/';

$wa             = $document->getWebAssetManager();
$wa->registerAndUseStyle('bsoffcanvas', $mediapath . 'css/bs5-offcanvas.css');


$min_height_l             = intval($offcanvas_navbar_height)+20;

$Doffcanvas_breakpoint = $offcanvas_breakpoint+1;
$wa->addInlineStyle("
    @media (max-width: ".$offcanvas_breakpoint."px) {
        #navigation-main .navbar.collapse  { display: none!important; }
        .wrap-outer { padding-top: ".$min_height_l."px; }
        .wbc__offcanvas-navbar { min-height: ".$min_height_l."px; display: flex!important; }
    }
    @media (max-width: 576px) {
        .wbc__offcanvas-navbar { min-height: ".$offcanvas_navbar_height."px; }
        .wrap-outer { padding-top: ".$offcanvas_navbar_height."px; }
    }
    @media (min-width: ".$Doffcanvas_breakpoint."px) {
        #navigation-main .navbar.collapse { display: flex!important; }
        .wbc__offcanvas-navbar { display: none!important; }
    }");
?>

<!-- Bootstrap 5 offcanvas navbar -->
<nav class="fixed-top navbar navbar-light toggle-pos-<?php echo $toggle_offcanvas_pos; ?> wbc__offcanvas-navbar" >
    <div class="container-fluid">
        <button class="btn btn-primary " type="button" data-bs-toggle="offcanvas" data-bs-target="#OffcanvasMenu<?php echo $offcanvas_pos; ?>" aria-controls="OffcanvasMenu<?php echo $offcanvas_pos;?>">
            <span class="navbar-toggler-icon"></span>
        </button>

        <?php if ($logo_mobil != '-1' || $jhtml->countModules('logo-mobil') ) : ?>
        <div class="navbar-brand wbc__logo">
        <?php if ($jhtml->countModules('logo-mobil')): ?>
            <jdoc:include type="modules" name="logo-mobil" style="none" />
                <?php else : ?><a href="index.php"><?php  echo LayoutHelper::render('joomla.html.image', ['src' => $logo_mobil, 'loading' => 'eager', 'alt' => htmlspecialchars($templateparams->get('sitetitle'))]);?></a>
        <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if ($jhtml->countModules('offcanvas-navbar') || $styleswitch == 1 ) :?>
            <div class="nav-icons">
                <jdoc:include type="modules" name="offcanvas-navbar" style="none" />
                <?php
                if ($styleswitch_pos == 5 ) {
                    $LayoutSwitch = new FileLayout('wbc_blanco_template.cssswitch', $tpath.'html/layouts');
                    echo $LayoutSwitch ->render();
                }
                ?>
            </div>
        <?php endif; ?>
    </div>
</nav>
<!-- end offcanvas navbar -->