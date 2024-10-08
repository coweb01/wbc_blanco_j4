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
$linktype = '<span class="icon icon-default" aria-hidden="true"></span><span class="wbc-ink-title">' . $item->title . '</span>';

if ($item->menu_icon)
{
    // The link is an icon
    if ($itemParams->get('menu_text', 1))
    {
        // If the link text is to be displayed, the icon is added with aria-hidden
        $linktype = '<span class="icon ' . $item->menu_icon . '" aria-hidden="true"></span><span class="wbc-ink-title">' . $item->title . '</span><span class="wbc-ink-title">' . $item->title . '</span>';
    }
    else
    {
        // If the icon itself is the link, it needs a visually hidden text
        $linktype = '<span class="icon ' . $item->menu_icon . '" aria-hidden="true"></span><span class="wbc-ink-title visually-hidden">' . $item->title . '</span>';
    }
}
elseif ($item->menu_image)
{
    // The link is an image, maybe with its own class
    $image_attributes = [];

    if ($item->menu_image_css)
    {
        $image_attributes['class'] = $item->menu_image_css;
    }

    $linktype = HTMLHelper::_('image', $item->menu_image, '', $image_attributes);

    $linktype .= '<span class="image-title' . ($itemParams->get('menu_text', 1) ? '' : ' visually-hidden') . '">' . $item->title . '</span>';
}

?>

<span class="separator"<?php echo $title; ?>>
    <?php echo $linktype; ?>
</span>
