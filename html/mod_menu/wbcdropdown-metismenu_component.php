<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   (C) 2020 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Filter\OutputFilter;
use Joomla\CMS\HTML\HTMLHelper;

$attributes = [];
$class = 'wbcmetis-link ';
$description = '';

if ($accesskey ) {
	$attributes['accesskey'] = $accesskey;
}

if ( $linkcss ) {  

	$class .=  $linkcss;
} 


if ($item->anchor_title)
{
	$attributes['title'] = $item->anchor_title;
}



if ($item->anchor_css)
{
	$class .= ' '. $item->anchor_css;
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

$attributes['class'] = $class;

if ($menudescription) {
	$description 	= '<span class="wbcmetis-subtitel">' . $menudescription . '</span>';
}

$linktype  		= '<span class="wbcmetis-titel">' . $item->title .'</span>' . $description;

if ($item->menu_image)
{
	$linktype = HTMLHelper::image($item->menu_image, $item->title);

	if ($item->menu_image_css)
	{
		$image_attributes['class'] = $item->menu_image_css;
		$linktype                  = HTMLHelper::image($item->menu_image, $item->title, $image_attributes);
	}

	if ($itemParams->get('menu_text', 1))
	{
		$linktype .= '<span class="image-title">' . $item->title . '</span>';
	}
}

if ($item->browserNav == 1)
{
	$attributes['target'] = '_blank';
}
elseif ($item->browserNav == 2)
{
	$options = 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes';

	$attributes['onclick'] = "window.open(this.href, 'targetWindow', '" . $options . "'); return false;";
}

echo HTMLHelper::link(OutputFilter::ampReplace(htmlspecialchars($item->flink, ENT_COMPAT, 'UTF-8', false)), $linktype, $attributes);

if ($showAll && $item->deeper)
{
	echo '<button class="mm-collapsed mm-toggler mm-toggler-link" aria-haspopup="true" aria-expanded="false" aria-label="' . $item->title . '"></button>';
}