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
?>
<nav class="fixed-top navbar navbar-light toggle-pos-<?php echo $toggle_offcanvas_pos; ?> wbc__offcanvas-navbar" >
    <div class="container-fluid">
        <div class="navbar-button">
            <button class="btn wbc__offcanvas-toggler-button" type="button" data-bs-toggle="offcanvas" data-bs-target="#OffcanvasMenu<?php echo $offcanvas_pos; ?>" aria-controls="OffcanvasMenu<?php echo $offcanvas_pos;?>" aria-label="<?php echo Text::_('TPL_WBC_MENU'); ?>">
                <span class="navbar-toggler-icon"></span>
            </button>
            <span class="wbc__offcanvas-toggler-butto-txt"><?php echo Text::_('TPL_WBC_MENU'); ?></span>        
        </div>
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
