<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * 
 * Nur Menülevel = 1
 * Override um ein Modul in einem Modal zu öffnen
 * Im Menütyp URL kann al URL die ID angegeben werden #meinLink
 * Das Plugin advancedmenuparams muss aktiv sein,
 * dann kann das Modul über einen Plugincode geladen werden.
 * CSS Klassen für das Modal kann im Feld CSS in den Menüparametern des plugins advancedmenuparams angegeben werden.
 * wbc-bg-hell = Modal heller Hintergrund
 * 
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\CMSObject;
use Joomla\CMS\Plugin\PluginHelper;

$app          = Factory::getApplication();
$doc          = $app->getDocument();
$template     = $app->getTemplate(true);
$mediapath    = 'media/templates/site/wbc_blanco_j4/';
$attributes   = [];

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $app->getDocument()->getWebAssetManager();
$wa->registerAndUseScript('wbc.togglemenu', $mediapath. 'js/menues/wbctogglemenu.js',[],[]);
$wa->registerAndUseStyle('wbc.togglemenu', $mediapath. 'css/menues/wbctogglemenu.css',[],[]);

$attributes['class']  = 'wbc-nav-toggle nav ' .$class_sfx;

if ($tagId = $params->get('tag_id'))
{
	$attributes['id']     = 'wbctoogle-' .$tagId;
	
}

// The menu class is deprecated. Use mod-menu instead 

echo '<ul '. ArrayHelper::toString($attributes) .'>'; 
foreach ($list as $i => &$item)
{
	if ( $item->level == 1 ) {
		$itemParams = $item->getParams();
		$class      = 'nav-item wbc-toggle-item wbc-toggle-item-' . $item->id;

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
		$headlinedropdown     = $itemParams->get('headlinedropdown',0);
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
