<?php
    /* Bootstrap 5 Offcanvas 
    *  Author: Webconceopt
    */

defined( '_JEXEC' ) or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;

HTMLHelper::_('bootstrap.offcanvas','.offcanvas');

/** @var Joomla\CMS\Document\HtmlDocument $this */

extract($displayData);
$app            = Factory::getApplication();
$document       = $app->getDocument();
$templatepath   = 'templates/'.$app->getTemplate().'/';

$wa             = $document->getWebAssetManager();
$wa->registerAndUseStyle('bsoffcanvas', $templatepath . 'css/bs5-offcanvas.css');


$min_height_l             = intval($offcanvas_navbar_height)+20;
$toggle_offcanvas_bs5_pos = ($toggle_offcanvas_pos == 'left') ? 'start' : 'end';

$Doffcanvas_breakpoint = $offcanvas_breakpoint+1;
$wa->addInlineStyle("
	@media (max-width: ".$offcanvas_breakpoint."px) {
		.header-top {display: none;}
		.wrap-outer {padding-top: ".$min_height_l."px;}
		.wbc__offcanvas-navbar {min-height: ".$min_height_l."px;}
	}
	@media (max-width: 576px) {
		.wbc__offcanvas-navbar {min-height: ".$offcanvas_navbar_height."px;}
		.wrap-outer { padding-top: ".$offcanvas_navbar_height."px;}
	}
	@media (min-width: ".$Doffcanvas_breakpoint."px) {
		.header-top {display: block;}
	}");
?>


<nav class="fixed-top navbar toggle-pos-<?php echo $toggle_offcanvas_pos; ?> wbc__offcanvas-navbar" >
	<a class="nav-offcanvas btn-toggle-offcanvas" data-bs-toggle="offcanvas" href="#OffcanvasMenu<?php echo $offcanvas_pos; ?>" role="button" aria-controls="OffcanvasMenu<?php echo $offcanvas_pos;?>" aria-label="<?php echo Text::_('TPL_WBC_MENU'); ?>">
		<label class="visually-hidden-focusable"><?php echo Text::_('TPL_WBC_MENU'); ?></label>	
		<span class="wbc__hamburger"></span>
	</a>

	<?php if ($logo_mobil != '-1' || $jhtml->countModules('logo-mobil') ) : ?>
	<div class="navbar-brand">
	<?php if ($jhtml->countModules('logo-mobil')): ?>
		<jdoc:include type="modules" name="logo-mobil" style="none" />
		<?php else : ?><a href="index.php"><img src="<?php echo $jhtml->baseurl ?><?php echo $logo_mobil?>" class="img-fluid" alt="<?php echo htmlspecialchars($templateparams->get('sitetitle')); ?>" title="<?php echo htmlspecialchars($templateparams->get('sitetitle')); ?>" /></a>
	<?php endif; ?>
	</div>
	<?php endif; ?>

	<?php if ($jhtml->countModules('offcanvas-navbar') || $styleswitch == 1 ) :?>
		<div class="nav-icons">
			<jdoc:include type="modules" name="offcanvas-navbar" style="none" />
			<?php
			if ($styleswitch_pos == 5 ) {
				$LayoutSwitch = new FileLayout('wbc_blanco_template.cssswitch', $templatepath.'html/layouts');
				echo $LayoutSwitch ->render();
			}
			?>
		</div>
	<?php endif; ?>
</nav>
<div id="OffcanvasMenu<?php echo $offcanvas_pos; ?>" class="wbc-bs5-offcanvas offcanvas-<?php echo $toggle_offcanvas_bs5_pos; ?> offcanvas text-bg-dark"  tabindex="-1">
	<div class="offcanvas-header mt-3">
		<h5 class="offcanvas-title" id="wbc-bs5-offcanvasLabel"><?php echo Text::_('TPL_WBC_MENU'); ?></h5>
		<button type="button" class="btn-close btn-close-white text-reset" data-bs-dismiss="offcanvas" aria-label="<?php echo Text::_('TPL_WBC_MENU_CLOSE'); ?>"></button>
	</div>
 	<div class="offcanvas-body">
		<nav>
			<jdoc:include type="modules" name="offcanvas"/>
		</nav>
	</div>
</div>
<!--  Offcanvas -->
