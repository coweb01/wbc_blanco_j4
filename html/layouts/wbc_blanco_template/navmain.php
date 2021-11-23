<?php
	defined('JPATH_BASE') or die;

	use Joomla\CMS\Factory;
	use Joomla\CMS\Language\Text;
	use Joomla\CMS\Layout\FileLayout;
	use Joomla\CMS\Uri\Uri;

	$variablen = $displayData;
	extract($displayData);

	$app            = Factory::getApplication();
	$templatepath   = URI::base(true).'/templates/'.$app->getTemplate().'/';

	$data_attr = 'collapse';
	$cssbutton = 'navbar-toggler collapsed';

?>

<!-- Static navbar -->
<div class="navbar navbar-light navbar-expand-lg <?php echo ($bgnavbar == 1 ) ? 'wbc-bg-navbar' : '';?>" role="navigation">

	<?php
	if($offcanvas == 0) :
	?>
		<?php // dieser Button aktiviert das normale Bootstrap offcanvas ?>
		<button type="button" class="<?php echo $cssbutton;?>" data-toggle="<?php echo $data_attr; ?>" data-target=".navbar-collapse" aria-controls="wbc-navbar-main">
			<span class="visually-hidden"><?php echo Text::_('TPL_CO_BLANCO_J3_MENU'); ?></span>
			<span class="navbar-toggler-icon"></span>
		</button>
	<?php
	endif
	?>
	<div class="navbar navbar-collapse collapse flex-nowrap">

	<?php
	if ($logoposition == 1) : // Logo vor der Navigation
	?>
	<div class="navbar-brand logo-mo">
		<?php
			$LayoutLogo = new FileLayout('wbc_blanco_template.logopos', $templatepath.'html/layouts');
			$displayData       = array(
								'jhtml'          => $jhtml,
								'templateparams' => $templateparams,
								'offcanvas'      => $offcanvas,
								'logoposition'   => $logoposition,
								'logo_mobil'     => $logo_mobil,
								'logo'           => $logo
								);

			echo $LayoutLogo ->render($displayData);
		?>
	</div>
	<?php
	endif;
	?>

		<jdoc:include type="modules" name="navMain"/>

		<?php
		if ($jhtml->countModules('suche')) : // suche in der Navbar
		?>
		<div class="suche d-print-none wbc-d-xlarge">
			<jdoc:include type="modules" name="suche" style="none" />
		</div>
		<?php
		endif;
		?>
	</div><!--/.nav-collapse -->
</div>
