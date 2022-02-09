<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   Copyright (C) 2009 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Filter\OutputFilter;
use Joomla\CMS\HTML\HTMLHelper;

$accesskey = $itemParams->get('accesskey');

$attributes = array();

if ($item->anchor_title)
{
	$attributes['title'] = $item->anchor_title;
}

if ($item->anchor_css)
{
	$attributes['class'] = $item->anchor_css;
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
if ($accesskey)
{
	$attributes['accesskey'] = $accesskey;
}
$desc = '';
if ($subtitle)
{
	$desc = '<span class="subtitle">' . $subtitle . '</span>';
}


$linktype = $item->title;

if ($item->menu_image)
{
	$linktype = HTMLHelper::_('image', $item->menu_image, $item->title);
	if ($itemParams->get('menu_text', 1)){
		$linktype .= '<div class="overlay"><div class="image-title"><span class="title">' . $item->title . '</span>' . $desc . '</div></div>';
	}
}
else
{
	$linktype = $item->title;
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

echo HTMLHelper::_('link', OutputFilter::ampReplace(htmlspecialchars($item->flink, ENT_COMPAT, 'UTF-8', false)), $linktype, $attributes);
