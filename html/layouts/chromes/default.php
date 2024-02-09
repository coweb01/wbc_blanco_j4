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
$moduleClassSfx         = ($params->get('moduleclass_sfx')) ? htmlspecialchars($params->get('moduleclass_sfx'), ENT_QUOTES, 'UTF-8') : '';
$headerTag              = ($params->get('header_tag', 'h3')) ? htmlspecialchars($params->get('header_tag'), ENT_QUOTES, 'UTF-8') : 'h3';
$headerClass            = ($params->get('header_class', '')) ? htmlspecialchars($params->get('header_class'), ENT_QUOTES, 'UTF-8') : '';
$headerClass            = !empty($headerClass) ? ' class="' . $headerClass . '"' : '';
$headerAttribs          = [];

$bootstrapSize  = (int) $params->get('bootstrap_size', 0);
$bootstrapSize  = ((int) $params->get('bootstrap_size', 12) == 0) ? '' : 'col-sm-' . (int) $params->get('bootstrap_size', 12);

?>
	<<?php echo $moduleTag; ?> class="extension-outer <?php echo $bootstrapSize . ' ' . htmlspecialchars($params->get('moduleclass_sfx')); ?>">

		<?php if ($module->showtitle) : ?>
			<div class="ext-header">
			<<?php echo $headerTag . $headerClass . '>' . $module->title; ?></<?php echo $headerTag; ?>>
			</div>
		<?php endif; ?>

			<?php echo $module->content; ?>

	</<?php echo $moduleTag; ?>>

