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

if ($item->menu_icon)
{
    // The link is an icon
    if ($itemParams->get('menu_text', 1))
    {
        // If the link text is to be displayed, the icon is added with aria-hidden
        $linktype = '<div class="overlay overlay-icon"><span class="overlay-symbol ' . $item->menu_icon . '" aria-hidden="true"></span><span class="link-title h4 mt-3">' . $item->title. '</span></div>';
    }
    else
    {
        // If the icon itself is the link, it needs a visually hidden text
        $linktype = '<div class="overlay overlay-icon"><span class="overlay-symbol ' . $item->menu_icon . '" aria-hidden="true"></span><span class="visually-hidden">' . $item->title . '</span></div>';
    }
}
elseif ($item->menu_image)
{
    $linktype = HTMLHelper::_('image', $item->menu_image, $item->title);
    if ($itemParams->get('menu_text', 1)){
        $linktype .= '<div class="overlay"><span class="image-title">' . $item->title . '</span></div>';
    }
}
else
{
    $linktype = '<span class="link-title h4 mt-3"' .$item->title .'</span>';
}

?>
<span class="separator"<?php echo $title; ?>>
    <?php echo $linktype; ?>
</span>
