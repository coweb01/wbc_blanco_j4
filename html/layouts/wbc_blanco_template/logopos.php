<?php
/************************************************************************************/
/*****   HTML fuer Logo                                                             */
/************************************************************************************/

defined('_JEXEC') or die;

extract($displayData);

$css_logo_mobil = ' class="d-block d-md-none"';
$css_logo_desk = ' class="d-none d-md-block"';
$css_logo = ($offcanvas == 1) ? 'wbc-offcanvas-on' : '';
?>

<div id="logo" class="base-col <?php echo $css_logo; ?>">
	<?php
	if ($logo_mobil != '-1') :
		if ($offcanvas == 0 && $logoposition != 1) : // anzeigen nur wenn logo nicht in der Navbar ?>
			<div <?php echo $css_logo_mobil;?>>
				<?php
				if ($jhtml->countModules('logo-mobil')):
				?>
				<jdoc:include type="modules" name="logo-mobil"  />
				<?php
				else :
				?>
				<a href="index.php"><img class="img-fluid" src="<?php echo $jhtml->baseurl ?><?php echo $logo_mobil?>" alt="<?php echo htmlspecialchars($templateparams->get('sitetitle')); ?>" title="<?php echo htmlspecialchars($templateparams->get('sitetitle')); ?>" /></a>
				<?php
				endif;
				?>
			</div>
		<?php
		endif;
		?>
	<?php
	endif;
	?>

	<?php
	if ($jhtml->countModules('logo') || $logo != '-1'):
	?>
	<div <?php echo $css_logo_desk;?>>
		<?php
		if ($jhtml->countModules('logo')):
		?>
		<jdoc:include type="modules" name="logo" />
		<?php
		elseif ($logo != '-1') :
		?>
		<a href="index.php"><img src="<?php echo $jhtml->baseurl ?><?php echo $logo?>" alt="<?php echo htmlspecialchars($templateparams->get('sitetitle')); ?>" title="<?php echo htmlspecialchars($templateparams->get('sitetitle')); ?>" /></a>
		<?php
		endif;
		?>
	</div>
	<?php
	endif;
	?>
</div>
