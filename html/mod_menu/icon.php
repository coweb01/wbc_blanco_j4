<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   Copyright (C) 2009 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Factory;

$app          = Factory::getApplication();
$id = '';
if ($tagId = $params->get('tag_id', '')) {
    $id = ' id="' . $tagId . '"';
}

$template     = $app->getTemplate(true);
$mediapath    = 'media/templates/site/wbc_blanco_j4/';

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $app->getDocument()->getWebAssetManager();
$wa->registerAndUseStyle('iconmenu', $mediapath . 'css/menues/iconmenu.css');

// The menu class is deprecated. Use mod-menu instead
?>
<ul<?php echo $id; ?> class="mod-menu mod-list nav menu-icons <?php echo $class_sfx; ?>">
<?php foreach ($list as $i => &$item) {
    $itemParams = $item->getParams();
    $accesskey  = $itemParams->get('accesskey');
    $subtitle   = $itemParams->get('description','');
    $class      = ' nav-item d-inline-block mb-3 item-' . $item->id . ' nav-item-' . $item->type;

    if ($item->id == $default_id) {
        $class .= ' default';
    }

    if ($item->id == $active_id || ($item->type === 'alias' && $itemParams->get('aliasoptions') == $active_id)) {
        $class .= ' current';
    }

    if (in_array($item->id, $path)) {
        $class .= ' active';
    }
    elseif ($item->type == 'alias') {
        $aliasToId = $itemParams->get('aliasoptions');

        if (count($path) > 0 && $aliasToId == $path[count($path) - 1]) {
            $class .= ' active';
        }
        elseif (in_array($aliasToId, $path)) {
            $class .= ' alias-parent-active';
        }
    }

    if ($item->type === 'separator') {
        $class .= ' divider';
    }

    if ($item->deeper) {
        $class .= ' deeper';
    }

    if ($item->parent) {
        $class .= ' parent';
    }

    echo '<li class="' . $class . '">';

    // Render the menu item.
    switch ($item->type) :
        case 'separator':
        case 'url':
        case 'component':
        case 'heading':
            require ModuleHelper::getLayoutPath('mod_menu', 'icon_' . $item->type);
            break;

        default:
            require ModuleHelper::getLayoutPath('mod_menu', 'icon_url');
            break;
    endswitch;

    // The next item is deeper.
    if ($item->deeper) {
        echo '<ul class="mod-menu__sub list-unstyled small">';
    }
    elseif ($item->shallower) {
        // The next item is shallower.
        echo '</li>';
        echo str_repeat('</ul></li>', $item->level_diff);
    }
    else {
        // The next item is on the same level.
        echo '</li>';
    }
}
?>
</ul>
