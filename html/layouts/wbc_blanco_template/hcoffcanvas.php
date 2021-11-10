<?php 
    /* HC Off-canvas Nav
    *  https://github.com/somewebmedia/hc-offcanvas-nav
    */
//$tpath    = JURI::base( true ) .'/templates/'.$app->getTemplate();

defined( '_JEXEC' ) or die; 
extract($displayData);
$document = JFactory::getDocument();    

$app            = JFactory::getApplication();
$templatepath   = JURI::base(true).'/templates/'.$app->getTemplate().'/';

$document->addStyleSheet($templatepath . 'libraries/hc-offcanvas/dist/hc-offcanvas-nav.carbon.css', array('version' => 'auto')); 
$document->addScript($templatepath . 'libraries/hc-offcanvas/dist/hc-offcanvas-nav.js', array('version' => 'auto')); 

$document  = JFactory::getDocument();
$min_height_l       = intval($offcanvas_navbar_height)+20;

$js = "
( function($) {
  $(document).ready(function(){

    $('#OffcanvasMenu". $offcanvas_pos . "').hcOffcanvasNav({
            position:  '". $offcanvas_pos ."',
            disableAt: ". $offcanvas_breakpoint .",
            width: '". $offcanvas_width ."',
            customToggle: '.nav-toggle',
            levelSpacing: 40,
            navTitle: '". JText::_('TPL_WBC_MENU') ."',
            levelTitles: true,
            levelTitleAsBack: true,
            pushContent: '.prevent-scrolling',
            labelClose: false,
            ariaLabels: {
                    open:     'Menü öffnen',
                    close:    'Menü schliessen',
                    submenu:  'Untermenü'
                  }
          });
  })
 })(jQuery);";

$document->addScriptDeclaration($js); 


    $style = '@media ( max-width: ';
    $style .=  $offcanvas_breakpoint;
    $style .=  'px ) {';
    $style .=  '.header-top { display: none;}'; 
    $style .=  '.offcanvas { display: block;}';
    $style .=  '.wrap-outer { padding-top: '; 
    $style .=  $min_height_l; 
    $style .= 'px;}';
    $style .=  '.offcanvas .navbar { min-height:' . $min_height_l . 'px; }';
    $style .= '}';

    $style .= '@media ( max-width: 576px ) {';
    $style .= '.offcanvas .navbar { min-height:' . $offcanvas_navbar_height . 'px; }';
    $style .=  '.wrap-outer { padding-top: '; 
    $style .=  $offcanvas_navbar_height; 
    $style .= 'px;}';
    $style .= '}';

    $style .= '@media ( min-width: ';
    $style .=  $offcanvas_breakpoint+1;
    $style .=   'px ) {
      .header-top { display: block; }
      .offcanvas { display: none; }
}';


$document->addStyleDeclaration($style);


?>

<div class="offcanvas offcanvas-<?php echo $offcanvas_pos; ?> "> 
  <nav class="fixed-top navbar toggle-pos-<?php echo $toggle_offcanvas_pos; ?>" >
        
        <a class="nav-toggle " href="#">          
          <span></span>
        </a>
   
        <?php if ($logo_mobil != '-1' || $jhtml->countModules('logo-mobil') ) : ?>
          <div class="navbar-brand">
          <?php if ($jhtml->countModules('logo-mobil')): ?>
              <jdoc:include type="modules" name="logo-mobil" style="none" />
              <?php else : ?><a href="index.php"><img src="<?php echo $jhtml->baseurl ?>/images/<?php echo $logo_mobil?>" class="img-fluid" alt="<?php echo htmlspecialchars($templateparams->get('sitetitle')); ?>" title="<?php echo htmlspecialchars($templateparams->get('sitetitle')); ?>" /></a>
          <?php endif; ?>
          </div> 
        <?php endif; ?>

        <?php if ($jhtml->countModules('offcanvas-navbar') || $styleswitch == 1 ) :?>
          <div class="nav-icons">
          <jdoc:include type="modules" name="offcanvas-navbar" style="none" /> 
          <?php if($styleswitch_pos == 5 ) { ?> 

            <?php $Layout  = new JLayoutFile('wbc_blanco_template.cssswitch', $templatepath.'/html/layouts');
            echo $Layout->render(); ?>
          
          <?php } ?>
          </div>
        <?php endif; ?>

     
  </nav>

  <nav id="OffcanvasMenu<?php echo $offcanvas_pos; ?>" class="sidebar-offcanvas " >  
      <jdoc:include type="modules" name="offcanvas"/>                 
  </nav> 
</div><!--  Offcanvas -->  


						
      
