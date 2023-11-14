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
$headerTag              = htmlspecialchars($params->get('header_tag', 'h3'), ENT_QUOTES, 'UTF-8');
$headerClass            = htmlspecialchars($params->get('header_class', ''), ENT_QUOTES, 'UTF-8');
$headerClass            = !empty($headerClass) ? $headerClass : 'fa fa-bars';
$headerAttribs          = [];

$bgimage            = $params->get('backgroundimage');
$ankerid            = $headerClass;
$bootstrapSize      = ((int) $params->get('bootstrap_size') == 0) ? '12' : (int) $params->get('bootstrap_size');

?>
<<?php echo $moduleTag; ?> class="extension-outer extension-outer-icon <?php echo htmlspecialchars($params->get('moduleclass_sfx')) .  $bootstrapSize; ?>">
    <div class="extension-inner extension-icon">
        <?php if ((bool) $module->showtitle) : ?>
        <div class="ext-header">
            <span class="ext-icon-block ">
                <i class="<?php echo $headerClass;?>"></i>
            </span>
            <?php echo '<'.$headerTag . '>' . $module->title; ?></<?php echo $headerTag; ?>></div>
        <?php endif; ?>

        <?php echo $module->content; ?>
    </div>
</<?php echo $moduleTag; ?>>
