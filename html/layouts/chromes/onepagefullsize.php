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
$moduleClassSfx = ($params->get('moduleclass_sfx')) ? htmlspecialchars($params->get('moduleclass_sfx'), ENT_QUOTES, 'UTF-8') : '';
$moduleTag      = $params->get('module_tag', 'div');
$headerTag      = ($params->get('header_tag', 'h3')) ? htmlspecialchars($params->get('header_tag'), ENT_QUOTES, 'UTF-8') : 'h3';
$ankerid        = ($params->get('header_class', '')) ? htmlspecialchars($params->get('header_class', ''), ENT_QUOTES, 'UTF-8') : '';

?>

<!-- ***************  start   section **********************  -->
<div id="<?php echo $ankerid; ?>" class="onepage-fullsize <?php echo $moduleClassSfx; ?>">
	<div class="container-fluid">
		<div class="row">
			<?php
			if ($module->showtitle) : ?>
			<div class="container">
				<h3 class="page-header"><?php echo $module->title; ?></h3>
			</div>
			<?php endif; ?>
			<div class="module-content"><?php echo $module->content; ?></div>
		</div>
	</div>
</div>
<!-- ***************  end   section **********************  -->
