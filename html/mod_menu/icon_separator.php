<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

$title      = $item->anchor_title ? ' title="' . $item->anchor_title . '"' : '';
$anchor_css = $item->anchor_css ?: '';
$linktype   = $item->title;

if ($item->menu_image)
{
	$linktype = HTMLHelper::_('image', $item->menu_image, $item->title);
	$linktype .= '<span class="image-title visually-hidden visually-hidden-focusable" >' . $item->title . '</span>';
	if ($itemParams->get('menu_text', 1)) {
		$linktype .= '<span class="' . $icon_class . '" </span>';
	}
}
else
{
	$linktype = '<span class="visually-hidden visually-hidden-focusable hier">'.$item->title.'</span>';
	if ($itemParams->get('menu_text', 1)) {
		$linktype = '<span class="icon ' . $icon_class . '" ></span>' . $item->title;
	}
}
?>

<span class="separator"<?php echo $title; ?>>
	<?php echo $linktype; ?>
</span>
