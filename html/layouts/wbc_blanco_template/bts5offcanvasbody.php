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
//$wa->registerAndUseStyle('bsoffcanvas', $mediapath . 'css/bs5-offcanvas.css');


$min_height_l             = intval($offcanvas_navbar_height)+20;

$Doffcanvas_breakpoint = $offcanvas_breakpoint+1;
$wa->addInlineStyle("
    @media (max-width: ".$offcanvas_breakpoint."px) {
        #navigation-main .navbar.collapse  { display: none!important; }
        .wbc__offcanvas-navbar { min-height: ".$min_height_l."px; display: flex!important; }
    }
    @media (max-width: 576px) {
        .wbc__offcanvas-navbar { min-height: ".$offcanvas_navbar_height."px; }
    }
    @media (min-width: ".$Doffcanvas_breakpoint."px) {
        #navigation-main .navbar.collapse { display: flex!important; }
        .wbc__offcanvas-navbar { display: none!important; }
    }");
?>
<?php
$inlinejs = "
function checkScreenSize() {
    let navMain        = document.querySelector('.main-append'); 
    let offCanvasBody  = document.querySelector('.offcanvas-body');
    let originalParent = document.getElementById('navMain');

    if (window.innerWidth <= $offcanvas_breakpoint) { 
        if (navMain && offCanvasBody && originalParent && !offCanvasBody.contains(navMain)) { 
            offCanvasBody.appendChild(navMain);
            navMain.querySelector('ul.mod-menu').classList.add('flex-column');
        }
    } else {
        if (navMain && offCanvasBody && originalParent && !originalParent.contains(navMain)) { 
            navMain.querySelector('ul.mod-menu').classList.remove('flex-column');
            originalParent.appendChild(navMain);
        }
    }
}

window.addEventListener('resize', checkScreenSize);
window.addEventListener('DOMContentLoaded', checkScreenSize);
";
$wa->addInlineScript($inlinejs, ['type' => 'text/javascript']);
?>
<div id="OffcanvasMenu<?php echo $offcanvas_pos; ?>" class="wbc-bs5-offcanvas offcanvas-<?php echo $toggle_offcanvas_pos; ?> offcanvas text-bg-dark"  tabindex="-1" aria-labelledby="wbc-bs5-offcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="wbc-bs5-offcanvasLabel"><?php echo Text::_('TPL_WBC_MENU'); ?></h5>
        <button type="button" class="btn-close btn-close-white text-reset" data-bs-dismiss="offcanvas" aria-label="<?php echo Text::_('TPL_WBC_MENU_CLOSE_TXT'); ?>"></button>
    </div>
    <div class="offcanvas-body">
        <jdoc:include type="modules" name="offcanvas"/>
    </div>
</div>