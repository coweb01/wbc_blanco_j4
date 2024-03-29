<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Templates.Base Template Joomla 3
 */

defined('_JEXEC') or die;

$module  = $displayData['module'];
$params  = $displayData['params'];
$attribs = $displayData['attribs'];

if ($module->content === null || $module->content === '')
{
	return;
}

$bgimage             = $params->get('backgroundimage') ? htmlspecialchars($params->get('backgroundimage')) : '';
$ankerid             = $params->get('header_class') ? htmlspecialchars($params->get('header_class', ''), ENT_QUOTES, 'UTF-8') : 'default';

/*
 * html5 headerimg als Background image  */

if ( $bgimage != '' ) :
?>
<div id="headerimg-<?php echo $ankerid;?>" class="wbc-background-image-stretch" style="background-image:url('<?php echo $bgimage;?>')">
</div>
<?php endif; ?>
