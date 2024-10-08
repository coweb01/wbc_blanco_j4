<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Filter\OutputFilter;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\Language\Text;


$attributes = [];
$html_description = '';
$attributes['role'] = 'button';
$string_pos = strpos($item->flink,'#');

$attributes['class'] = 'nav-link';
$toggle_container_id = '';

if ( $string_pos !== false ) {
	$toggle_container_id  	= substr($item->flink, 1);
	$toggle_container_id 	.= '-'.$item->id;
	$attributes['data-toggle-container'] = $toggle_container_id;

	if ($item->type != 'alias') {
		$attributes['class'] .= ' wbc-toggle-item-link';
	}	
}

if ($accesskey ) {
	$attributes['accesskey'] = $accesskey;
}

if ($item->anchor_title)
{
	$attributes['title'] = $item->anchor_title;
}

if ($item->anchor_rel)
{
	$attributes['rel'] = $item->anchor_rel;
}

if ($menuedescription) {
	$html_description 	= '<span class="wbc-toggle-subtitel">' . $menuedescription . '</span>';
}
$linktype  		= '<span class="wbc-toggle-titel">' . $item->title .'</span>'.$html_description;

if ($item->menu_icon)
{
	// The link is an icon
	if ($itemParams->get('menu_text', 1))
	{
		// If the link text is to be displayed, the icon is added with aria-hidden
		if ($item->type !== 'alias') {		
			$linktype = '<span class="nav-icon wbc-toggle-item-icon ' . $item->menu_icon . '" aria-hidden="true" data-toggle-container="'.$toggle_container_id.'"></span>' . $item->title;
		} else {
			$linktype = '<span class="nav-icon ' . $item->menu_icon . '" aria-hidden="true"></span>' . $item->title;
		}
	}
	else
	{
		// If the icon itself is the link, it needs a visually hidden text
		if ($item->type !== 'alias') {
			$linktype = '<span class="nav-icon wbc-toggle-item-icon ' . $item->menu_icon . '" aria-hidden="true" data-toggle-container="'.$toggle_container_id.'"></span><span class="visually-hidden">' . $item->title . '</span>';
		} else {	
			$linktype = '<span class="nav-icon ' . $item->menu_icon . '" aria-hidden="true"></span><span class="visually-hidden">' . $item->title . '</span>';
		}	
	}
}
elseif ($item->menu_image)
{
	// The link is an image, maybe with an own class
	$image_attributes = [];

	if ($item->menu_image_css)
	{
		$image_attributes['class'] = $item->menu_image_css;
	}

	$linktype = HTMLHelper::_('image', $item->menu_image, $item->title, $image_attributes);

	if ($itemParams->get('menu_text', 1))
	{
		$linktype .= '<span class="image-title">' . $item->title . '</span>';
	}
}

if ($item->browserNav == 1)
{
	$attributes['target'] = '_blank';
	$attributes['rel'] = 'noopener noreferrer';

	if ($item->anchor_rel == 'nofollow')
	{
		$attributes['rel'] .= ' nofollow';
	}

}
elseif ($item->browserNav == 2)
{
	$options = 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,' . $params->get('window_open');

	$attributes['onclick'] = "window.open(this.href, 'targetWindow', '" . $options . "'); return false;";
}

echo HTMLHelper::_('link', OutputFilter::ampReplace(htmlspecialchars($item->flink, ENT_COMPAT, 'UTF-8', false)), $linktype, $attributes);

if ($item->type !== 'alias') {
	if ( $content_plg ) { 
		$attributes['class'] = 'btn-close btn-close-white wbc-toggle-container-close';
		$attributes['aria-label'] =  Text::_('TPL_WBC_BLANCO_J4_CLOSE');
		$attributes['type'] = 'button';
		if ( $string_pos !== false) {	
			$pluginContent = \Joomla\CMS\HTML\HTMLHelper::_('content.prepare', $content_plg);?>
			<div id="<?php echo $toggle_container_id ?>" class="wbc-toggle-container overflow-scroll <?php echo isset($linkcss) ? $linkcss : '';?>">
				<button <?php echo  ArrayHelper::toString($attributes) ?>></button>
				<div class="container">
					<div class="row">
						<div class="col-12">
							<?php echo $pluginContent; ?>
						</div>
					</div>
				</div>
			</div>
	<?php } 
	}
}		
?>