<?php
    /* HC Off-canvas Nav
    *  https://github.com/somewebmedia/hc-offcanvas-nav
    */
//$tpath    = JURI::base( true ) .'/templates/'.$app->getTemplate();

defined( '_JEXEC' ) or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

/** @var Joomla\CMS\Document\HtmlDocument $this */

extract($displayData);
$app            = Factory::getApplication();
$document       = $app->getDocument();
$templatepath   = 'templates/'.$app->getTemplate().'/';


$wa             = $document->getWebAssetManager();
$wa->registerAndUseStyle('hcoffcanvas', $templatepath . 'libraries/hc-offcanvas/dist/hc-offcanvas-nav.carbon.css');
$wa->registerAndUseScript('hcoffcanvasjs', $templatepath . 'libraries/hc-offcanvas/dist/hc-offcanvas-nav.js', [], [], []);

$min_height_l       = intval($offcanvas_navbar_height)+20;

$js = "
	document.addEventListener('DOMContentLoaded', function() {

		var Nav = new hcOffcanvasNav('#OffcanvasMenu$offcanvas_pos', {
			position: '$offcanvas_pos',
			disableAt: $offcanvas_breakpoint,
			width: '$offcanvas_width',
			customToggle: '.nav-toggle',
			levelSpacing: 40,
			navTitle: '". Text::_('TPL_WBC_MENU') ."',
			levelTitles: true,
			levelTitleAsBack: true,
			pushContent: '.prevent-scrolling',
			labelClose: false,
			ariaLabels: {
					open: 'Menü öffnen',
					close: 'Menü schliessen',
					submenu: 'Untermenü'
					}
		});
	});
";

$wa->addInlineScript($js);

$wa->addInlineStyle("
	@media (max-width: $offcanvas_breakpoint px) {
		.header-top {display: none;};
		.wbc-hc-offcanvas {display: block;};
		.wrap-outer {padding-top: $min_height_l px;}
		.wbc-hc-offcanvas .navbar {min-height: $min_height_l px;}
	}
	@media (max-width: 576px) {
		.wbc-hc-offcanvas .navbar {min-height: $offcanvas_navbar_height px;}
		.wrap-outer { padding-top: $offcanvas_navbar_height px;}
	}
	@media (min-width: $offcanvas_breakpoint+1 px) {
		.header-top {display: block;}
		.wbc-hc-offcanvas {display: none;}
	}");
?>

<div class="wbc-hc-offcanvas wbc-hc-offcanvas-<?php echo $offcanvas_pos; ?> ">
  <nav class="fixed-top navbar toggle-pos-<?php echo $toggle_offcanvas_pos; ?>" >

        <a class="nav-toggle " href="#">
          <span></span>
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

  <nav id="OffcanvasMenu<?php echo $offcanvas_pos; ?>" class="sidebar-offcanvas " >
      <jdoc:include type="modules" name="offcanvas"/>
  </nav>
</div>
<!--  Offcanvas -->
