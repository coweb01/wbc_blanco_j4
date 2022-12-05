<?php
/*
/*  HTML fixed sidebars Links oder rechts
/*
*/

defined( '_JEXEC' ) or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Factory;

extract($displayData);

$app            = Factory::getApplication();
$document       = $app->getDocument();
$tpath          = 'templates/'.$app->getTemplate().'/';
$wa             = $document->getWebAssetManager();

if ($toggle) : 
	$wa->registerAndUseScript('togglesidebars', $tpath . 'js/toggle-sidebars.js', [], [], []);
endif;
?>


<div id="<?php echo $side; ?>-fixed" class="position-fixed wbc-fixed-sidebar d-print-none ">

    <?php if ( $jhtml->countModules('sidebar-'. $side .'-fix') ): ?>
    <div class="wbc-fixed-sidebar-<?php echo $side; ?> d-none d-sm-block">
      <jdoc:include type="modules" name="sidebar-<?php echo $side; ?>-fix" style="none"/>
    </div>
    <?php endif; ?>


    <?php if ( $toggle ) :?>
            <?php if ( $jhtml->countModules('sidebar-'. $side .'-toggle') ||
                                  ( $fontsize && $fontsize_pos == $pos )||
                                   ( $styleswitch && $styleswitch_pos == $pos )) : ?>

              <div id="fixed-sidebar-<?php echo $side; ?>-toggle" class="wbc-fixed-sidebar-toggle d-none d-sm-block">
                  <a id="<?php echo $side; ?>-fixed-btn" class="toggle-btn nav-link btn-icon shadow-sm" role="button" href="#" aria-label="<?php echo Text::_('TPL_WBC_BLANCO_J4_OPEN_TXT'); ?>">
                      <i class="<?php echo ($side == 'left') ? $iconleft : $iconright;?>"></i> 
                      <span class="visually-hidden"><?php echo Text::_('TPL_WBC_BLANCO_J4_OPEN_TXT'); ?></span>
                  </a>   
                  <div id="<?php echo $side; ?>-container-fix" class="container-fix shadow-sm">
                                
                      <?php if ( $fontsize  && ($fontsize_pos == $pos )) : ?>
                        <!-- Schriftgroesse anpassen -->
                        <?php $Layout  = new FileLayout('wbc_blanco_template.fontsize', $tpath.'/html/layouts');
                        echo $Layout->render(); ?>
                      <?php endif; ?>
                    
                      <?php if ( $styleswitch && ($styleswitch_pos == $pos ) ) : ?>  
                        <!-- Styleswitcher Hochkontrast / Default -->
                        <?php $Layout  = new FileLayout('wbc_blanco_template.cssswitch', $tpath.'/html/layouts');
                        echo $Layout->render(); ?>
                      <?php endif; ?>

                      <jdoc:include type="modules" name="sidebar-<?php echo $side; ?>-toggle" style="none"/>
                  </div>
              </div>
            <?php endif; ?>
    <?php endif; ?>
</div>

