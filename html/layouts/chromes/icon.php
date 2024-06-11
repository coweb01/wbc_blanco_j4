<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.wbc_blanco_j4
 */

defined('_JEXEC') or die;

use Joomla\Utilities\ArrayHelper;

$module  = $displayData['module'];
$params  = $displayData['params'];
$attribs = $displayData['attribs'];

if ($module->content === null || $module->content === '') {
    return;
}

$moduleTag              = htmlspecialchars($params->get('module_tag', 'div'), ENT_QUOTES, 'UTF-8');
$moduleAttribs          = [];
$moduleAttribs['class'] = 'extension-outer extension-outer-icon ' . htmlspecialchars($params->get('moduleclass_sfx', ''), ENT_QUOTES, 'UTF-8');
$bootstrapSize          = (int) $params->get('bootstrap_size', 0);
$moduleAttribs['class'] .= $bootstrapSize !== 0 ? ' col-md-' . $bootstrapSize : '';
$headerTag              = htmlspecialchars($params->get('header_tag', 'h3'), ENT_QUOTES, 'UTF-8');
$headerClass            = htmlspecialchars($params->get('header_class', ''), ENT_QUOTES, 'UTF-8');
$headerClass            = !empty($headerClass) ? $headerClass : 'fa fa-bars';
$headerAttribs          = [];

// Add class from attributes if any
if (!empty($attribs['class'])) {
    $moduleAttribs['class'] .= ' ' . htmlspecialchars($attribs['class'], ENT_QUOTES, 'UTF-8');
}

// Only add aria if the moduleTag is not a div
if ($moduleTag !== 'div') {
    if ($module->showtitle) :
        $moduleAttribs['aria-labelledby'] = 'mod-' . $module->id;
        $headerAttribs['id']              = 'mod-' . $module->id;
    else :
        $moduleAttribs['aria-label'] = $module->title;
    endif;
}

$header = '<' . $headerTag . ' ' . $module->title . '>' . $module->title . '</' . $headerTag . '>';

?>
<<?php echo $moduleTag; ?> <?php echo ArrayHelper::toString($moduleAttribs); ?>>
    <div class="extension-inner extension-icon">
        <?php if ((bool) $module->showtitle) : ?>
        <div class="ext-header">
            <span class="ext-icon-block ">
                <i class="<?php echo $headerClass;?>"></i>
            </span>
            <?php echo '<' .$headerTag . '>' . $module->title . '</' . $headerTag . '>' ;?></div>
        <?php endif; ?>

        <?php echo $module->content; ?>
    </div>
</<?php echo $moduleTag; ?>>
