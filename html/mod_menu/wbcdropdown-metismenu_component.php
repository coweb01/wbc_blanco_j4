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
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\Language\Text;


$attributes = [];
$class = 'wbcmetismenu-link ';
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

if ($menuedescription) {
    $description     = '<span class="wbcmetis-subtitel">' . $menuedescription . '</span>';
}
$linktype          = '<span class="wbcmetis-titel">' . $item->title .'</span>'.$description;

if ($item->menu_icon)
{
    // The link is an icon
    if ($itemParams->get('menu_text', 1))
    {
        // If the link text is to be displayed, the icon is added with aria-hidden
        $linktype = '<span class="wbcmetis-icon ' . $item->menu_icon . '" aria-hidden="true"></span><span class="wbcmetis-titel">' . $item->title .'</span>'.$description;
    }
    else
    {
        // If the icon itself is the link, it needs a visually hidden text
        $linktype = '<span class="wbcmetis-icon ' . $item->menu_icon . '" aria-hidden="true"></span><span class="visually-hidden">' . $item->title . '</span>';
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
    $attributes['class'] = ' mm-collapsed mm-toggler mm-toggler-nolink';

    if (isset($dropdowncolumns)) {
        if ( $dropdowncolums === true && $item->level == 2 ) {
            $attributes['class'] .=  ' wbcmetismenue_level2_btn';
        }
    }
    $attributes['aria-haspopup'] = 'true';
    $attributes['aria-expanded'] = 'false';
    $attributes['aria-label'] = Text::_('TPL_WBC_BLANCO_J4_TOOGLER_ARIA_LABEL');
    $attributes['aria-label'] .= ' '.$item->title;
    echo '<button ' . ArrayHelper::toString($attributes) . '><i aria-hidden="true" class="fas fa-chevron-down"></i></button>';
}
