<?php
/**
 * Base template Joomla 3
 */

defined('_JEXEC') or die;

$app                = JFactory::getApplication();
$doc                = JFactory::getDocument();
$this->language     = $doc->language;
$this->direction    = $doc->direction;
$tpath              = $this->baseurl.'/templates/'.$this->template;
JHtml::_('bootstrap.framework');
JHtmlBootstrap::loadCss();

// generator tag
$this->setGenerator(null);

// force latest IE & chrome frame
if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)) {
	$doc->setMetadata('x-ua-compatible', 'IE=edge,chrome=1');
}

$doc->setMetadata('viewport', '');
$doc->setMetadata('content-language',substr($this->language, 0, 2));



$doc->addStyleSheet($tpath . '/css/system/template.css', array('version' => 'auto'));

if ( (JFile::exists( JPATH_ROOT. '/templates/'.$this->template . '/css/custom.css' ) ) ) {
	  $doc->addStyleSheet($tpath .  '/css/custom.css', array('version' => 'auto'));
}  



?>

<!DOCTYPE html>
<!--[if IEMobile]><html class="iemobile" lang="<?php echo $this->language; ?>"> <![endif]-->
<!--[if gt IE 8]><!-->  <html class="no-js" lang="<?php echo $this->language; ?>"> <!--<![endif]-->
<head>

<?php if ($this->params->get('meta-viewport') == 0):?>
  	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	<?php endif; ?>	
<jdoc:include type="head" />

</head>
<body >
<div class="contenpane container <?php echo $this->direction === 'rtl' ? ' rtl' : ''; ?>" >
	<jdoc:include type="message" />
	<jdoc:include type="component" />
</div>
	
</body>
</html>
