<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * 
 * Nur Menülevel = 1
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\CMSObject;
use Joomla\CMS\Plugin\PluginHelper;

$app      = Factory::getApplication();
$doc      = $app->getDocument();
$tpath    = 'templates/'.$app->getTemplate();


/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $app->getDocument()->getWebAssetManager();
$wa->registerAndUseScript('wbc.togglemenu', $tpath. '/js/wbctogglemenu.min.js');
$wa->registerAndUseStyle('wbc.togglemenu', $tpath. '/css/togglemenu/wbctogglemenu.min.css');

$id = '';

if ($tagId = $params->get('tag_id', ''))
{
	$id = ' id="wbctoogle-' . $tagId . '"';
}

// The menu class is deprecated. Use mod-menu instead
?>
<ul<?php echo $id; ?> class="wbc-nav-toggle nav <?php echo $class_sfx; ?>">
<?php foreach ($list as $i => &$item)
{
	if ( $item->level == 1 ) {
		$itemParams = $item->getParams();
		$class      = 'nav-item wbc-toggle-item wbc-toggle-item-' . $item->id;

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
		$content_plg         = $itemParams->get('content_plg');
		$linkcss             = $itemParams->get('linkcss');
		/* end --------------------------------------------------------------*/

		if ($item->id == $default_id)
		{
			$class .= ' default';
		}

		if ($item->id == $active_id || ($item->type === 'alias' && $itemParams->get('aliasoptions') == $active_id))
		{
			$class .= ' current';
		}

		if (in_array($item->id, $path))
		{
			$class .= ' active';
		}
		elseif ($item->type === 'alias')
		{
			$aliasToId = $itemParams->get('aliasoptions');

			if (count($path) > 0 && $aliasToId == $path[count($path) - 1])
			{
				$class .= ' active';
			}
			elseif (in_array($aliasToId, $path))
			{
				$class .= ' alias-parent-active';
			}
		}

		if ($item->type === 'separator')
		{
			$class .= ' divider';
		}

		if ($item->deeper)
		{
			$class .= ' deeper';
		}

		if ($item->parent)
		{
			$class .= ' parent';
		}

		echo '<li class="' . $class . '">';

		switch ($item->type) :
			case 'separator':
			case 'component':
			case 'heading':
			case 'url':
				require ModuleHelper::getLayoutPath('mod_menu', 'toggle_' . $item->type);
				break;

			default:
				require ModuleHelper::getLayoutPath('mod_menu', 'toggle_url');
				break;
		endswitch;

		
		echo '</li>';
	}	
}
?></ul>
