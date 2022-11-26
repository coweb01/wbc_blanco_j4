<?php
/*
*  HTML fuer das Headerbild
*  verwendete Klassen: wbc-background-image-stretch
*
*  Standard Module Style ist headerimg. Achtung: Gibt nur das Hintergrundbild aus dem
Modul mod_custom aus. Keinen Modulinhalt.
*
* Hintergrundbild responsive. Die hoehe des Containers muss dem container individuell definiert werden.
*
*  Wenn ein Slidermodul benutzt wird muss der Modulstyle im Modul geaendert werden.
*
*/

defined('_JEXEC') or die;

extract($displayData);

?>

<!-- start headerimg -->
<div id="headerimg" class="<?php echo ($jhtml->params->get('bg-headerimg') != '') ? 'bg-headerimg'  : ''; ?>" role="banner">
	<div class="container<?php echo ($jhtml->params->get('headerimg-width') == 1) ? '-fluid' : '';?>">
		<div class="base-row row">
			<div class="base-col wrap-headerimg <?php $headerimgSizeClass; ?> <?php echo $bootstrap_colclass; ?>12" >

			<?php
			if ($jhtml->countModules('headerimg')):
			?>
				<jdoc:include type="modules" name="headerimg" style="headerimg" />
			<?php
			else :
			?>
				<div class="wbc-background-image-stretch" style="background-image: url(<?php echo $jhtml->baseurl ?>/<?php echo $jhtml->params->get('headerimg'); ?>);"></div>
			<?php
			endif;
			?>

			<?php
			if($jhtml->countModules('headerimg-overlay')) :
			?>
				<div id="overlay_headerimg" class="d-none d-sm-block">
					<jdoc:include type="modules" name="headerimg-overlay" style="none"/>
				</div>
			<?php
			endif;
			?>
			</div>
		</div>
	</div>
</div><!--End headerimg -->
