<?php 
/********************************************************************* 
 * Template  
 * Template Joomla 3 014 
 * Kunde: 
 * Author:  Claudia Oerter  
 * Stand:   01 / 2016
 * Version:  
 * copyright Template das webconcept 
 * Die Fehlerseite muss in den Templateparametern ausgewählt werden.
 *  
 *******************************************************************/
  
defined( '_JEXEC' ) or die; 


/*JHTML::_('behavior.framework', true);*/ 
$app             = JFactory::getApplication();
$params          = $app->getTemplate(true)->params; // Templateparameter
$item            = $params->get('errorsite', 0 ); // get menuitem der Fehlerseite aus dem Template
$logo            = $params->get('logo','logo.png');
$customcss       = $params->get('customcss','custom.css');


$config         = JFactory::getConfig();
$sefUrl         = $config->get('sef');

// Get language and direction
$doc             = JFactory::getDocument();
$this->language  = $doc->language;
$this->direction = $doc->direction;

$uri             = JURI::getInstance();
$base    	     = $uri->toString( array('scheme', 'host', 'port'));

// Bootstrap Klassen
	$bootstrap_colclass              = "col-md-";
	$bootstrap_colclass_mobil_tb     = "col-sm-";
	$bootstrap_colclass_mobil_ph     = "col-";
	$bootstrap_colclass_lg           = "col-lg-";
	$bootstrap_rowclass              = "row";
  $bootstrap_offsetclass           = "col-md-offset-";
  $bootstrap_offsetclass_lg        = "col-lg-offset-";
	$bootstrap_offsetclass_mobil_tb  = "col-sm-offset-";
  $bootstrap_offsetclass_mobil_ph  = "col-offset-";


if ($this->error->getcode() == '404') {
	 header("HTTP/1.0 404 Not Found");
}


if ( isset ($item ) && $this->error->getCode()==404) {
	$menus                    = $app->getMenu('site', array());
	$item                     = $menus->getItem($item); //get menue item
	$url                      = $item->link;     // link 
	$route                    = $item->route;   // sef url 
	$link                     = ( $config->get('sef') == 1 ) ? $route : $url; //sef on or not
	$UrlErrorSite             = $base . $this->baseurl . '/' . $link; // link
	
	
	//echo  base64_encode($UrlErrorSite);
	//echo (file_get_contents($UrlErrorSite));	
  header('Location: ' . JRoute::_($UrlErrorSite, false));
    exit;

} elseif  ( $this->error->getCode()==403)  {

  header('Location: ' . JRoute::_($base . $this->baseurl . '/403' , false));
    exit;

} else {
  
  ?>


<!DOCTYPE html>
<!--[if IEMobile]><html class="iemobile" lang="<?php echo $this->language; ?>"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8" lang="<?php echo $this->language; ?>"> <![endif]-->
<!--[if gt IE 8]><!-->  <html class="no-js" lang="<?php echo $this->language; ?>"> <!--<![endif]-->

<!-- ****************************************************************************************************** -->
<!-- *     Head                                                                                           * -->
<!-- ****************************************************************************************************** -->  
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />

<title><?php echo $this->error->getCode(); ?> - <?php echo htmlspecialchars($this->error->getMessage(), ENT_QUOTES, 'UTF-8'); ?></title>

	<?php if ($params->get('meta-viewport') == 0):?>
  	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	<?php endif; ?>
	
    <link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/bootstrap/css/bootstrap.min.css" type="text/css" media="screen,projection" />
    <link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/template.css" type="text/css" media="screen,projection" />

	<?php 
    if ( (JFile::exists(  JPATH_ROOT. '/templates/'.$this->template . '/css/'.$customcss ) ) ) { ?>
    <link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/<?php echo $customcss;?>" type="text/css" media="screen,projection" />
	
	<?php } ?>

</head>

<body class="errorsite"> 
  

<div class="wrap-outer error">

   
<header class="header-02 container">
   <div class="logo row justify-content-center">
        <div id="logo" class="<?php echo $bootstrap_colclass_mobil_ph . '6 ' . $bootstrap_colclass_mobil_tb . '4 ' .$bootstrap_colclass. '3 ' .$bootstrap_colclass_lg; ?>3">
        <a href="index.php"><img src="<?php echo $this->baseurl ?>/images/<?php echo $logo?>" alt="<?php echo htmlspecialchars($params->get('sitetitle')); ?>" title="<?php echo htmlspecialchars($params->get('sitetitle')); ?>" /></a>
        </div><!--End Logo-->
        
   </div>     
</header>      
     
        
  
  
<div  class="wrap-main container">    
     <div class="main row">        
        <div class="info-message col-12 border position-relative">
          <p class="h2 p-5"><?php echo JText::_('TPL_WBC_BLANCO_J3_JERROR_TEXT_ERROR'); ?></p>
            <div class="col-4 position-absolute" style="bottom:0px; right: 0px">
              <img  class="img-fluid" src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/images/fehler.jpg" alt="sorry" >
            </div>
        </div>
        <div class="alert alert-secondary col-12 justify-content-center">                
            <p class="text-center"><strong><?php echo JText::_('TPL_WBC_BLANCO_J3_JERROR_TEXT_ERRORCODE'); ?><span class="error-code"> Code: <?php echo $this->error->getCode(); ?></span></strong></p> 
              <p class="text-center"><?php echo $this->error->getMessage();?></p>
              <?php // var_dump($this->error);?>
                     
        </div> 
     </div>
</div>    
      
</div>

<?php }
 

?> 
</body> 
</html>