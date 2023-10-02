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

$app      = Factory::getApplication();
$doc      = $app->getDocument();
$template     = $app->getTemplate(true);
$mediapath    = 'media/templates/site/'. $template->template. '/';

/** @var \Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $doc->getWebAssetManager();
$wa->registerAndUseScript('wbcmetismenu', $mediapath. 'js/menues/wbcmenu-metismenu.min.js', [], ['defer' => true], ['metismenujs']);
$wa->registerAndUseStyle('wbc.offcanvas', $mediapath. 'css/menues/wbcoffcanvasmenu.css');

$attributes          = [];
$attributes['class'] = 'mod-menu mod-menu_wbcdropdown-metismenu wbcoffcanvasmenu mod-list ' . $class_sfx;

if ($tagId = $params->get('tag_id', ''))
{
    $attributes['id'] = $tagId;
}

$start = (int) $params->get('startLevel', 1);

?>

<ul <?php echo ArrayHelper::toString($attributes); ?>>

<?php
/*  variablen für das mehrspaltige Untermenü --------------------------*/

$col                = 0; /* zähler spalten */
$rowminwidth        = 0; /* init*/
$open_cols          = false;  // schalter spalte dropdown geöffnet
$switch_item_deeper = false;

/* end ----------------------------------------------------------------*/
?>

<?php foreach ($list as $i => &$item)
{

    // Skip sub-menu items if they are set to be hidden in the module's options
    if (!$showAll && $item->level > $start)
    {
        continue;
    }

    $itemParams         = $item->getParams();

    /* menu parameters aus plugin advancedmenuparams ---------------------*/

    $accesskey           = $itemParams->get('accesskey');
    $dropdowncolums      = $itemParams->get('dropdowncolums');
    $menuecolumn         = $itemParams->get('menucolumn',0);
    $columnwidth         = $itemParams->get('columnwidth',30);
    $columnwidthUnit     = $itemParams->get('columnwidthunit','%');
    $stylecolumn         = ' style="flex: 0 0 ' . $columnwidth . $columnwidthUnit .'; max-width: '. $columnwidth . $columnwidthUnit .';"';

    $menudescription     = $itemParams->get('description');
    $headlinedropdown    = $itemParams->get('headlinedropdown',0);
    $headlinedropdowntxt = $itemParams->get('headlinedropdowntxt');

    $linkcss            = $itemParams->get('linkcss');
    $toggleLink         = '';
    $image_class        = '';

    /* end --------------------------------------------------------------*/

    if ( $item->level == 1 && $item->menu_image)
    {
        if ($item->menu_image_css)
        {
            $image_class = ($item->menu_image_css) ? '<i class="link-image '. $item->menu_image_css .'"></i>' : '';
        }
        $toggleLink = '<a href="#" title="" class="toggle-offcanvas toggle-offcanvas-item offcanvas-left" data-toggle="wbc-offcanvas" ><img src="'.$item->menu_image.'" alt="'.$item->title.' "/>'.$image_class.'</a>';
    }

    $class      = [];
    $class[]    = 'wbcoffcanvasmenu-item item-' . $item->id . ' level-' . ($item->level - $start + 1);

    if ($item->id == $default_id)
    {
        $class[] = 'default';
    }

    if ($item->id == $active_id || ($item->type === 'alias' && $itemParams->get('aliasoptions') == $active_id))
    {
        $class[] = 'current';
    }

    if (in_array($item->id, $path))
    {
        $class[] = 'active';
    }
    elseif ($item->type === 'alias')
    {
        $aliasToId = $itemParams->get('aliasoptions');

        if (count($path) > 0 && $aliasToId == $path[count($path) - 1])
        {
            $class[] = 'active';
        }
        elseif (in_array($aliasToId, $path))
        {
            $class[] = 'alias-parent-active';
        }
    }

    if ($item->type === 'separator')
    {
        $class[] = 'divider';
    }

    if ($showAll)
    {
        if ($item->deeper)
        {
            $class[] = 'deeper';
            if ( $item->level == 1 && $dropdowncolums == 1 ) {
                $class[] = 'wbc-dropdown-multicolumn';  /* Klasse li Elternelement wenn menu mehrspaltig */
            }
        }

        if ($item->parent)
        {
            $class[] = 'parent';
        }
        $classcolumn = ' class="' .implode(' ', $class) .'"';
    }

    if ( $switch_item_deeper == true ) :

         if ( $menuecolumn == 1 )  //oeffnen wenn mehrspaltig
        {
            echo '<ul class="mm-collapse wbc-multicolumn-dropdown-' .  $item_level . ' wbc-multicolumn-dropdown wbc-multicolumn-dropdown-'. $item_id.'">'. "\n";
            $col                    = 0;
            $rowminwidth            = 0;
            $rowid                  = $item_id;

        } else {
            echo '<ul class="mm-collapse wbc-multicolumn-dropdown-' .  $item_level . '">'. "\n";  }

            if ( $item_level < 2 && !empty($rowtitle) ) {
                echo '<li class="wbc-dropdown-titel" style="flex: 0 0 100%; max-width: 100%;"><p class="h3 wbc-menutitle">'.$rowtitle.'</p></li>'. "\n";
            }
        $switch_item_deeper = false;
    endif;

     // html item levels
    switch ($item->level) :
        case 3:  echo '<li class="'. implode(' ', $class) .'">';
            break;
        case 2:
            if (  $menuecolumn == 1  ) :
                $rowminwidth  = $rowminwidth + $columnwidth;
                echo '<li clas="wbc-wrap-nav-col-'. $col .'" ' . $stylecolumn .' >'. "\n";
                $col++;
                $open_cols = true;
            else :
                if ( $open_cols == false ) {
                    echo '<li class="'. implode(' ', $class) .'">';
                }
            endif;
            break;
        case 1:
            if ( $dropdowncolums == true  ) { $class[] = 'wbc-dropdown'; }

            if ( $headlinedropdown == 1 ) {
                $rowtitle = ( $headlinedropdowntxt  ) ? $headlinedropdowntxt : $item->title;
            }
            echo '<li class="'. implode(' ', $class) .'">';
            break;
    endswitch;

    // render the menu item

    switch ($item->type) :
        case 'separator':
        case 'component':
        case 'heading':
        case 'url':
            require ModuleHelper::getLayoutPath('mod_menu', 'wbcdropdown-offcanvas_' . $item->type);
            break;

        default:
            require ModuleHelper::getLayoutPath('mod_menu', 'wbcdropdown-offcanvas_url');
    endswitch;

    switch (true) :
        // The next item is deeper.
        case $showAll && $item->deeper:
            // merke .. ul wird spaeter geoeffnet
            $switch_item_deeper = true;
            $item_level = $item->level;
            $item_id = $item->id;
            break;
        // The next item is shallower.
        case $item->shallower:
            $level_next = $item->level;
            //$level_diff = $item->level_diff;

            if ( $item->level > 2 )  {

                if ( $open_cols == true && $level_next == 1  ) {
                    echo '</li>'. "\n";
                    $open_cols = false;
                }
            } else  if ( $item->level == 2  ) {

                if ($open_cols == true ) {
                    echo '</ul></li>'. "\n";
                    $open_cols = false;
                } else {
                    echo '</li></ul>'. "\n";
                }
            }
            break;

        // The next item is on the same level.
        default:

        if ( $item->level == 1 || $item->level > 2 ) {
            echo '</li>';
        }
        break;
    endswitch;
}
?></ul>
