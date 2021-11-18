<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.wbc_blanco_j4
 */

defined('_JEXEC') or die;

$module  = $displayData['module'];
$params  = $displayData['params'];
$attribs = $displayData['attribs'];

if ($module->content === null || $module->content === '')
{
	return;
}

$moduleTag              = $params->get('module_tag', 'div');
$moduleAttribs          = [];
$moduleAttribs['class'] = $module->position . ' card ' . htmlspecialchars($params->get('moduleclass_sfx'), ENT_QUOTES, 'UTF-8');
$headerTag              = htmlspecialchars($params->get('header_tag', 'h3'), ENT_QUOTES, 'UTF-8');
$headerClass            = htmlspecialchars($params->get('header_class', ''), ENT_QUOTES, 'UTF-8');
$headerAttribs          = [];

$bgimage            = $params->get('backgroundimage');
$ankerid            = $headerClass;
$bootstrapSize      = ((int) $params->get('bootstrap_size') == 0) ? '12' : (int) $params->get('bootstrap_size');
$bootstrapRowclass = "row";
$bootstrapColclass = "col-" . $bootstrapSize;

/*
 * html5 (chosen html5 tag and font header tags)
 */
?>
<!-- ***************  start section <?php echo $ankerid; ?>**********************  -->
<section id="onepage-<?php echo $ankerid; ?>" class="onepage">

	<?php
	if ($bgimage != '') :
	?>
	<div class="onepage-inner" data-speed="8" data-type="background" style="background-image:url("<?php echo $bgimage; ?>")>
	<?php
	else : ?>
	<div class="onepage-inner <?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?>">
	<?php
	endif;
	?>
		<?php
		if ($module->showtitle) : ?>
		<<?php echo $headerTag; ?> class="page-header">
			<div class="container">
				<span class="mod-icon"></span>
				<span class="mod-title"><?php echo $module->title; ?></span>
			</div>
		</<?php echo $headerTag; ?>>
		<?php
		endif;
		?>
		<div class="container">
			<div class="<?php echo $bootstrapRowclass; ?>">
				<div class="<?php echo $bootstrapColclass; ?>">
					<div class="module-content"><?php echo $module->content; ?></div>
				</div>
			</div>
		</div>
	</div>
</section>
