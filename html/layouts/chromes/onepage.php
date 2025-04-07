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
$headerTag              = ($params->get('header_tag', 'h3')) ? htmlspecialchars($params->get('header_tag'), ENT_QUOTES, 'UTF-8') : 'h3';
$headerClass            = ($params->get('header_class', '')) ? htmlspecialchars($params->get('header_class'), ENT_QUOTES, 'UTF-8') : '';
$headerAttribs          = [];

$moduleClassSfx         = ($params->get('moduleclass_sfx')) ? htmlspecialchars($params->get('moduleclass_sfx'), ENT_QUOTES, 'UTF-8') : '';
$bgimage                = $params->get('backgroundimage');
$ankerid                = $headerClass;
$bootstrapSize          = ((int) $params->get('bootstrap_size') == 0) ? '12' : (int) $params->get('bootstrap_size');
$bootstrapRowclass      = "row";
$bootstrapColclass      = "col-" . $bootstrapSize;

/*
 * html5 (chosen html5 tag and font header tags)
 */
?>
<!-- ***************  start section <?php echo $ankerid; ?>**********************  -->
<section id="onepage-<?php echo $ankerid; ?>" class="onepage <?php echo $moduleClassSfx; ?>">

    <?php
    if ($bgimage != '') :
    ?>
    <div class="onepage-inner" data-speed="8" data-type="background" style="background-image:url('<?php echo $bgimage; ?>')">
    <?php
    else : ?>
    <div class="onepage-inner <?php echo $moduleClassSfx; ?>">
    <?php
    endif;
    ?>
        <?php
        if ($module->showtitle) : ?>
        <div class="container">
            <<?php echo $headerTag; ?> class="page-header">
                <span class="mod-icon"></span>
                <span class="mod-title"><?php echo $module->title; ?></span>
            </<?php echo $headerTag; ?>> 
        </div>
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
