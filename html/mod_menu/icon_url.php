<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Filter\OutputFilter;
use Joomla\CMS\HTML\HTMLHelper;

$attributes = array();
$attributes['role'] = 'button';

if ($item->anchor_title)
{
	$attributes['title'] = $item->anchor_title;
}

if ($item->anchor_rel)
{
	$attributes['rel'] = $item->anchor_rel;
}

if ($item->id == $active_id)
{
	$attributes['aria-current'] = 'location';

	if ($item->current)
	{
		$attributes['aria-current'] = 'page';
	}
}

$linktype = $item->title;

if ($item->anchor_css)
{
	$icon_class = $item->anchor_css;
}

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

if ($item->browserNav == 1)
{
	$attributes['target'] = '_blank';
	$attributes['rel'] = 'noopener noreferrer';

	if ($item->anchor_rel == 'nofollow')
	{
		$attributes['rel'] .= ' nofollow';
	}
}
elseif ($item->browserNav == 2)
{
	$options = 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,' . $params->get('window_open');

	$attributes['onclick'] = "window.open(this.href, 'targetWindow', '" . $options . "'); return false;";
}
?>
<div class="bg-secondary shadow-sm d-inline-block">
<?php echo HTMLHelper::_('link', OutputFilter::ampReplace(htmlspecialchars($item->flink, ENT_COMPAT, 'UTF-8', false)), $linktype, $attributes);
?>
</div>
