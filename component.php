<?php

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;

/** @var Joomla\CMS\Document\HtmlDocument $this */

$app = Factory::getApplication();
$wa  = $this->getWebAssetManager();

// Template path
$templatePath = 'templates/' . $this->template;

$doc = $app->getDocument();
$templateparams = $app->getTemplate(true)->params; // Templateparameter
$fontawesome = $templateparams->get('fontawesome');

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
