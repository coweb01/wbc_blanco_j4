<?php
/*
/*  HTML fixed sidebars 
/*
*/

defined( '_JEXEC' ) or die; 

extract($displayData);

$app            = JFactory::getApplication();
$templatepath   = JURI::base(true).'/templates/'.$app->getTemplate().'/';

?>
 

<div id="<?php echo $side; ?>-fixed" class="position-fixed wbc-fixed-sidebar d-print-none ">
    <?php if ( $jhtml->countModules('sidebar-'. $side .'-fix') ): ?>
    <div class="wbc-fixed-sidebar-<?php echo $side; ?> d-none d-sm-block">
      <jdoc:include type="modules" name="sidebar-<?php echo $side; ?>-fix" style="none"/>
      <div class="d-inline-block">
        <div id="icon-<?php echo $side; ?>-search" class="d-print-none wbc-h-xlarge d-flex">
          <a class="nav-link shadow-sm mb-2" title="<?php echo JText::_('COM_SEARCH_SEARCH');?>" href="<?php echo  $searchsite; ?>" aria-label="Seite durchsuchen"><i class="<?php echo $faclass; ?> fa-search" aria-hidden="true"><span class="sr-only sr-only-focusable"><?php echo JText::_('COM_SEARCH_SEARCH'); ?></span></i></a>
        </div> 
      </div>
    </div>
    <?php endif; ?>

    
    <?php if ( $toggle ) :?>    


            <?php if ( $jhtml->countModules('sidebar-'. $side .'-toggle') || 
                                  ( $fontsize && $fontsize_pos == $pos )|| 
                                   ( $styleswitch && $styleswitch_pos == $pos )) : ?> 
              
              <div id="fixed-sidebar-<?php echo $side; ?>-toggle" class="wbc-fixed-sidebar-toggle d-none d-sm-block">
                
                   <a class="toggle-btn nav-link btn-icon shadow-sm" role="button" href="#" aria-label="Button"><i class="<?php echo ($side == 'left') ? $iconleft : $iconright;?>"></i> <span class="sr-only"><?php echo JText::_('TPL_WBC_BLANCO_J3_OPEN_TXT'); ?></span></a>


                  
                   <div id="<?php echo $side; ?>-container-fix" class="container-fix shadow-sm">
                    <?php if ( $fontsize  && ($fontsize_pos == $pos )) : ?> 

                       
                    <?php $Layout  = new JLayoutFile('wbc_blanco_template.fontsize', $tpath.'/html/layouts');
                    echo $Layout->render(); ?>

                    <?php endif; ?> 

                    <?php if ( $styleswitch && ($styleswitch_pos == $pos ) ) : ?> 

                    <?php $Layout  = new JLayoutFile('wbc_blanco_template.cssswitch', $templatepath.'/html/layouts');
                    echo $Layout->render(); ?>

                    <?php endif; ?> 

                     <jdoc:include type="modules" name="sidebar-<?php echo $side; ?>-toggle" style="none"/>
                   </div>
              </div>
             
            <?php endif; ?>
    <?php endif; ?>  
</div>

