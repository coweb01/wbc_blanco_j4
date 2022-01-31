<div class="overlay"><?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   Copyright (C) 2009 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

$title = $item->anchor_title ? ' title="' . $item->anchor_title . '" ' : '';

if ($item->menu_image)
{
	$linktype = HTMLHelper::_('image', $item->menu_image, $item->title);
	if ($itemParams->get('menu_text', 1)){
		$linktype .= '<div class="overlay"><span class="image-title">' . $item->title . '</span></div>';
	}
}
else
{
	$linktype = $item->title;
}

?>
<span class="separator"<?php echo $title; ?>>
	<?php echo $linktype; ?>
</span>
