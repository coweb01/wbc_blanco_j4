<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;

/** @var Joomla\CMS\Document\HtmlDocument $this */

$app = Factory::getApplication();
$wa  = $this->getWebAssetManager();

$doc = $app->getDocument();
$templateparams = $app->getTemplate(true)->params; // Templateparameter
$fontawesome = $templateparams->get('fontawesome');
$mediapath   = 'media/templates/site/'.$this->template.'/';

// generator tag
$this->setGenerator(null);

// force latest IE & chrome frame
if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)) {
	$doc->setMetadata('x-ua-compatible', 'IE=edge,chrome=1');
}

$doc->setMetadata('viewport', '');
$doc->setMetadata('content-language',substr($this->language, 0, 2));

// Load Icons
if ($fontawesome == 1)
{
	$wa->useStyle('fontawesome');
}

// Enable assets
$wa->usePreset('template.wbc')
	->useStyle('template.user')
	->useScript('template.user');

// Favicons https://realfavicongenerator.net/
$this->addHeadLink(HTMLHelper::_('image', 'favicons/apple-touch-icon.png', '', [], true, 1), 'apple-touch-icon', 'rel', ['sizes' => '180x180']);
$this->addHeadLink(HTMLHelper::_('image', 'favicons/favicon-32x32.png', '', [], true, 1), 'icon', 'rel', ['sizes' => '32x32', 'type' => 'image/png']);
$this->addHeadLink(HTMLHelper::_('image', 'favicons/favicon-16x16.png', '', [], true, 1), 'icon', 'rel', ['sizes' => '16x16', 'type' => 'image/png']);
$this->addHeadLink(HTMLHelper::_('image', 'favicons/safari-pinned-tab.svg', '', [], true, 1), 'mask-icon', 'rel', ['color' => '#41599a']);
$this->addHeadLink(HTMLHelper::_('image', 'favicons/favicon.ico', '', [], true, 1), 'shortcut icon', 'rel', ['type' => 'image/vnd.microsoft.icon']);
$this->addHeadLink($mediapath . 'images/favicons/site.webmanifest', 'manifest', 'rel', []);
$this->setMetaData('msapplication-config', $mediapath . 'images/favicons/browserconfig.xml');
$this->setMetaData('theme-color', '#ffffff');

// Defer font awesome
$wa->getAsset('style', 'fontawesome')->setAttribute('rel', 'lazy-stylesheet');
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
<jdoc:include type="metas" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<jdoc:include type="styles" />
	<?php include "includes/style.php";?>
	<jdoc:include type="scripts" />
</head>
<body >
	<div class="contenpane container <?php echo $this->direction === 'rtl' ? ' rtl' : ''; ?>" >
		<jdoc:include type="message" />
		<jdoc:include type="component" />
	</div>
</body>
</html>
