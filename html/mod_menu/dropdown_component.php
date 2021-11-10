<?php

/**
 * @package     	Joomla.Site
 * @subpackage  	mod_menu override
 * @copyright   	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     	GNU General Public License version 2 or later; see LICENSE.txt
 * Modifications	Joomla CSS
 */

defined('_JEXEC') or die;

// Note. It is important to remove spaces between elements.
$class = $item->anchor_css ? 'class="nav-link '.$item->anchor_css.'" ' : 'class="nav-link" ';
$title = $item->anchor_title ? 'title="'.$item->anchor_title.'" ' : '';

if ($item->menu_image)
{
	$item->params->get('menu_text', 1) ?
		$linktype = '<img src="'.$item->menu_image.'" alt="'.$item->title.'" /><span class="image-title">'.$item->title.'</span> ' :
		$linktype = '<img src="'.$item->menu_image.'" alt="'.$item->title.'" />';

		if ($item->deeper) {
		$class = 'class="'.$item->anchor_css.' nav-link dropdown-toggle mootools-noconflict" data-toggle="dropdown href" ';
		$linktype = $item->title;
	}
}

	elseif ($item->deeper) { 
		$linktype = $item->title;
		if ($item->level < 2) {
		$class = 'class="'.$item->anchor_css.' nav-link dropdown-toggle mootools-noconflict" data-toggle="dropdown href" ';
		///$linktype = $item->title;
	}

	else {
		$linktype = $item->title;
	}
}

else {
	$linktype = $item->title;
}

switch ($item->browserNav) :
	default:
	case 0:
?><a <?php echo $class; ?>href="<?php echo $item->flink; ?>" <?php echo $title; ?>><span class="chrome-fix"><?php echo $linktype; ?></span></a><?php
		break;

	case 1:
		// _blank
?><a <?php echo $class; ?>href="<?php echo $item->flink; ?>" target="_blank" <?php echo $title; ?>><span class="chrome-fix"><?php echo $linktype; ?></span></a><?php
		break;

	case 2:
	// window.open

?><a <?php echo $class; ?>href="<?php echo $item->flink; ?>" onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes');return false;" <?php echo $title; ?>><span class="chrome-fix"><?php echo $linktype; ?></span></a>
<?php
		break;

endswitch;

