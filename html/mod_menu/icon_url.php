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
$accesskey = $itemParams->get('accesskey');
$attributes['role'] = 'button';
$class = "nav-link ";

if ($item->anchor_title)
{
	$attributes['title'] = $item->anchor_title;
}

if ($item->anchor_rel)
{
	$attributes['rel'] = $item->anchor_rel;
}
if ($item->anchor_css)
{
	$class .= $item->anchor_css;
}
if ($item->id == $active_id)
{
	$attributes['aria-current'] = 'location';

	if ($item->current)
	{
		$attributes['aria-current'] = 'page';
	}
}
$attributes['class'] = $class;
$linktype = '<span class="icon icon-default" aria-hidden="true"></span><span class="wbc-link-title">' . $item->title . '</span>';

if ($item->menu_icon)
{
	// The link is an icon
	if ($itemParams->get('menu_text', 1))
	{
		// If the link text is to be displayed, the icon is added with aria-hidden
		$linktype = '<span class="icon ' . $item->menu_icon . '" aria-hidden="true"></span><span class="wbc-link-title">' . $item->title . '</span>';
	}
	else
	{
		// If the icon itself is the link, it needs a visually hidden text
		$linktype = '<span class="icon ' . $item->menu_icon . '" aria-hidden="true"></span><span class="wbc-link-title visually-hidden">' . $item->title . '</span>';
	}
}
elseif ($item->menu_image)
{
	// The link is an image, maybe with an own class
	$image_attributes = [];

	if ($item->menu_image_css)
	{
		$image_attributes['class'] = $item->menu_image_css;
	}

	$linktype = HTMLHelper::_('image', $item->menu_image, $item->title, $image_attributes);

	if ($itemParams->get('menu_text', 1))
	{
		$linktype .= '<span class="image-title">' . $item->title . '</span>';
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
	$options = 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,';

	$attributes['onclick'] = "window.open(this.href, 'targetWindow', '" . $options . "'); return false;";
}
?>
<div class="bg-icon d-inline-block">
<?php echo HTMLHelper::_('link', OutputFilter::ampReplace(htmlspecialchars($item->flink, ENT_COMPAT, 'UTF-8', false)), $linktype, $attributes);
?>
</div>
