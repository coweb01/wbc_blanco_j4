<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   (C) 2020 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\Factory;

$template     = $app->getTemplate(true);
$mediapath    = 'media/templates/site/wbc_blanco_j4/';
$class_sfx    = htmlspecialchars($params->get('class_sfx', ''));

/** @var \Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $app->getDocument()->getWebAssetManager();
$wa->registerAndUseScript('wbcmetismenu', $mediapath. 'js/menues/wbcmenu-metismenu.js', [], ['defer' => true], ['metismenujs']);
$wa->registerAndUseStyle('wbc.metismenu', $mediapath. 'css/menues/wbcmetismenu.css', [], [], []);

$attributes             = [];
$attributes['class']    = 'navbar-nav mod-menu wbc-multicolumn-metismenu wbcmetismenu metismenu mod-list ' . $class_sfx;
$attributes['class']    .= ' wbc-position-' . $module->position;
if ($tagId = $params->get('tag_id', '')) {
    $attributes['id'] = $tagId;
}
$start = (int) $params->get('startLevel', 1);
$ColOpen = false;  // schalter für mehrspaltiges dropdown und spalte geöffnet.
$dropdowncolums = false; // schalter für mehrspaltiges dropdown
?>
<ul <?php echo ArrayHelper::toString($attributes); ?>>
<?php foreach ($list as $i => &$item) {
    // Skip sub-menu items if they are set to be hidden in the module's options
    if (!$showAll && $item->level > $start) {
        continue;
    }

    /* menu parameters aus plugin advancedmenuparams ---------------------*/

        if ($item->getParams()) {
            $itemParams          = $item->getParams();
            $accesskey           = $itemParams->get('accesskey');
            $menuecolumn         = $itemParams->get('menucolumn',);
            $columnwidth         = $itemParams->get('columnwidth');
            $columnwidthUnit     = $itemParams->get('columnwidthunit','%');
            if ( $columnwidth &&  $menuecolumn ) {
                $stylecolumn     = ' style="flex: 0 0 ' . $columnwidth . $columnwidthUnit .'; max-width: '. $columnwidth . $columnwidthUnit .';"';
            } else {
                $stylecolumn     = '';
            }
            $menuedescription     = $itemParams->get('description');
            $headlinedropdown    = $itemParams->get('headlinedropdown',0);
            if ( $headlinedropdown == 1 ) {
                $headlinedropdowntxt = ( !empty($itemParams->get('headlinedropdowntxt')) ) ? $itemParams->get('headlinedropdowntxt') : $item->title;
            } else {
                $headlinedropdowntxt = '';
            }
            $linkcss             = $itemParams->get('linkcss');
            $content_plg         = $itemParams->get('content_plg');
            $htmlmegamenu        = [];
        }

    /* end --------------------------------------------------------------*/


    $class      = [];
    $class[]    = 'wbcmetismenu-item item-' . $item->id . ' level-' . ($item->level - $start + 1);

    // Startseite erhält class "default"
    if ($item->id == $default_id) {
        $class[] = 'default';
    }

    if ($item->id == $active_id || ($item->type === 'alias' && $itemParams->get('aliasoptions') == $active_id)) {
        $class[] = 'current';
    }
    // aktive Menueeintrag
    if (in_array($item->id, $path)) {
        $class[] = 'active';
    } elseif ($item->type === 'alias') {
        $aliasToId = $itemParams->get('aliasoptions');

        if (count($path) > 0 && $aliasToId == $path[count($path) - 1]) {
            $class[] = 'active';
        } elseif (in_array($aliasToId, $path)) {
            $class[] = 'alias-parent-active';
        }
    }

    if ($item->type === 'separator') {
        $class[] = 'divider';
    }

    if ($showAll) {
        if ($item->deeper) {
            $class[] = 'deeper';
            if ( $item->level == 1 ) {
                if ( $itemParams->get('dropdowncolums') == "1") {
                $dropdowncolums =  true;
                $class[] = 'wbcmulticolumn';
                }
            }
        }

        if ($item->parent) {
            $class[] = 'parent';
        }
    }

    // Spalten innerhalb des Dropdowns
    if ( $item->level == 2 ) { // Im Menüparameter ist ein Spaltenumbruch gesetzt
        if ( $menuecolumn  == true && $dropdowncolums == true ) {
            if ( $ColOpen == true && !$firstcol) {
                echo '</ul>'. "\n";
                echo '</div>'. "\n";
                $ColOpen = false;
            }
            if ( !$firstcol ) {
                echo '<div class="col"'. $stylecolumn .'>'. "\n";
                echo '<ul class="wbc-col">'. "\n";
                $ColOpen = true;
            }
            $firstcol = false;
        }
    }
    // ende Spalten

    echo '<li class="' . implode(' ', $class) . '">';

    // Render the menu link
    switch ($item->type) :
        case 'separator':
        case 'component':
        case 'heading':
        case 'url':
            require ModuleHelper::getLayoutPath('mod_menu', 'wbcdropdown-metismenu_' . $item->type);
            break;

        default:
            require ModuleHelper::getLayoutPath('mod_menu', 'wbcdropdown-metismenu_url');
    endswitch;

    //close Tags

    switch (true) :
        // The next item is deeper. Ebene Tiefer
        case $showAll && $item->deeper:
            if ($item->level == 1 ) {
                echo '<ul class="wbcmetismenu-submenu-dropdown sublevel-'.$item->level.' mm-collapse">';

                // öffnen wenn mehrspaltiges Untermenue
                if ( isset($dropdowncolums) && $dropdowncolums == true ) {
                    $htmlmegamenu[] = '<li class="container-fluid">'. "\n";
                    $htmlmegamenu[] = '<div class="row">'. "\n";

                    if ( !empty( $headlinedropdowntxt ) ){
                        $htmlmegamenu[] = '<h3 class="wbcheadlinedropdown" aria-hidden="true">'. $headlinedropdowntxt .'</h3>'. "\n";
                    }
                    $htmlmegamenu[] = '<div class="col"'. $stylecolumn .'>'. "\n";
                    $htmlmegamenu[] = '<ul class="wbc-col">'. "\n";
                    $htmlmegamenu   =  implode("\n",$htmlmegamenu);
                    echo $htmlmegamenu;
                    $firstcol = true;
                    $ColOpen = true;
                }
            } else {
                    echo '<ul class="wbcmetismenu-submenu sublevel-'.$item->level.'">';
                }
            break;

        // Dern nächste Datensatz ist eine Ebene höher. Schliessen des Dropdowns
        case $item->shallower:
            echo '</li>';


            // der nächste Level ist 1 mehrspaltiges Dropdown wieder schliessen
            if ( isset($dropdowncolums) && $dropdowncolums == true ) {
                if ( $item->level == 2 && $item->level_diff == 1 ) {
                    $dropdowncolums = false;
                    echo '</ul>'. "\n";
                    echo '</div>'. "\n";
                    echo '</div>'. "\n";
                    echo '</li>'. "\n";
                    echo '</ul></li>'. "\n";
                    break;
                }
                if ( $item->level > 2  && $item->level_diff > 1  ) {
                        $dropdowncolums = false;
                        echo str_repeat('</ul></li>', $item->level_diff-1);  // erst alle offenen unterebenen schliessen
                        echo '</ul>'. "\n";
                        echo '</div>'. "\n";
                        echo '</div>'. "\n";
                        echo '</li>'. "\n";
                        echo '</ul></li>'. "\n";
                    break;
                }
            }

            echo str_repeat('</ul></li>', $item->level_diff);
            break;

        // The next item is on the same level.
        default:
            echo '</li>';
            break;
    endswitch;
}
?></ul>
