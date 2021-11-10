<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$modPos      = 'quicklinks';
$modStyle    = 'none';

$quickModules     = JModuleHelper::getModules('quicklinks');

//$quicklinkOn      = false;

$pattern =  "@(<(\w+)[^>]*>)?{quicklink(\s.*)?}(</\\2>)?@";

// Note. It is important to remove spaces between elements.
$title = $item->anchor_title ? ' title="' . $item->anchor_title . '" ' : '';

// Modul für die Quicklinks filtern
$quicklink = preg_match($pattern, $item->title, $matches);

if ( preg_match($pattern, $item->title, $matches) ) :

	$quicklink_mod_id = trim($matches[3]);
	$module = JModuleHelper::getModuleById($quicklink_mod_id);
 	if ( $module ) : 
		
				if (JModuleHelper::isEnabled($module->name)) :
					
		            if ( $quicklink_mod_id == $module->id) {

					echo JModuleHelper::renderModule($module, array('style' => $modStyle, 'position' => $modPos ));
					}
				endif;	
		
	endif; ?>	

<?php else: ?>

<?php
// ende Quicklinks 
 
// normaler Link

if ($item->menu_image)
	{
		$item->params->get('menu_text', 1) ?
		$linktype = '<img src="' . $item->menu_image . '" alt="' . $item->title . '" /><span class="image-title">' . $item->title . '</span> ' :
		$linktype = '<img src="' . $item->menu_image . '" alt="' . $item->title . '" />';
}
else
{
	$linktype = $item->title;
}

?>
<span class="separator"<?php echo $title; ?>>
	<?php echo $linktype; ?>
</span><span class="subtitle"><?php echo $subtitle;?> </span>

<?php endif; ?>