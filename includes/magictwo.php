<?php 

$app                = JFactory::getApplication();
$doc                = JFactory::getDocument();
$templateparams     = $app->getTemplate(true)->params; // Templateparameter 

if ($floatingLabels == 1) : 
  $doc->addScript($this->baseurl. '/templates/' . $this->template . '/js/vendor/jquery.placeholder.label.min.js');


  $jscript  = " ( function($) { $(document).ready(function(){";  
  $jscript .= "$('input[placeholder]').placeholderLabel(";
  $jscript .= "  'labelColor:' + '#333333',
        'placeholderColor:' + '#999999',
        'useBorderColor:' + false,
        'labelSize:' + '14px',
        'timeMove:' + 200 
      );"; 
  $jscript .= "}) })(jQuery); ";   
  $doc->addScriptDeclaration($jscript) ;

  endif;

?>
<?php // script für den Styleumschalter HK / Default
  if( $styleswitch == 1 ) :  ?>
<script src="<?php echo $this->baseurl. '/templates/' . $this->template . '/js/CSSswitcher.js';?>"></script> 
<?php endif; ?>

<?php 
//  script fontsize  
if ( $fontsize == 1 ) :
	?> <script src="<?php echo $this->baseurl. '/templates/' . $this->template . '/js/vendor/jquery.jfontsize-1.0.min.js';?>"></script> <?php
endif;
?>
<?php 
//  script fixed Header on scroll 
if ($fixedheader == 1 ) :	?> 
 
  <?php $doc->addScript($this->baseurl. '/templates/' . $this->template . '/js/vendor/scrollPosStyler.min.js', array('version' => 'auto' )); ?>

<?php endif; ?>

<?php if ( $BootstrapMenu == 1 ) : 
  $doc->addScript($this->baseurl. '/templates/' . $this->template . '/js/wbc_bootstrap_dropdown_fix.js', array('version' => 'auto' ));
  ?>   
<?php endif ?>

<?php if ( $functions == 1 ) :  
$doc->addScript($this->baseurl. '/templates/' . $this->template . '/js/funktion.js', array('version' => 'auto' ));
?>  
<?php endif ?>

<?php if ( $offcanvas == 1 ) : 
    $doc->addScript($this->baseurl. '/templates/' . $this->template . '/js/offcanvas.js', array('version' => 'auto' ));
  ?>  
<?php endif; ?>

<?php if ($bootstrap == 4) : 
  $doc->addScript($this->baseurl. '/templates/' . $this->template . '/js/table_resp.js', array('version' => 'auto' ));
  ?>
<?php  endif; ?>


<?php

if ( $holder == 1 ) { ?>
	<script src="<?php echo $this->baseurl. '/templates/' . $this->template . '/js/holder.js';?>"></script>
<?php } ?>



 
<?php if ( $toggleright  ) : ?>
 <script >
    (function ($) { 
       $(document).ready(function () { 
         $( '#fixed-sidebar-right-toggle .btn-icon' ).click(function() {
            let ToggleContainerRight = $( '#fixed-sidebar-right-toggle .container-fix');
            ToggleContainerRight.toggle( 'slow' );
            $( '#fixed-sidebar-right-toggle').toggleClass('slide-open'); 
            
            }); 
       });
    })(jQuery);
 </script>
<?php endif;?>

<?php if ( $toggleleft  ) : ?>
 <script >
    (function ($) { 
       $(document).ready(function () { 
         $( '#fixed-sidebar-left-toggle .btn-icon' ).click(function() {
            let ToggleContainerLeft =  $('#fixed-sidebar-left-toggle .container-fix');
            ToggleContainerLeft.toggle( 'slow' );
            $( '#fixed-sidebar-left-toggle').toggleClass('slide-open'); 
                       
            }); 
       });
    })(jQuery);
 </script>
<?php endif;?>

 <?php if ( $fontsize == 1 ) : ?>
   <script >
  (function ($) {
    $(document).ready(function () {
      $('body').jfontsize({
                 btnMinusClasseId: '#jfontsize-minus',
                 btnDefaultClasseId: '#jfontsize-default',
                 btnPlusClasseId: '#jfontsize-plus',
                 btnMinusMaxHits: 10,
                 btnPlusMaxHits: 10,
                 sizeChange: 1
             }); 

    });
  })(jQuery);
</script>
<?php endif;?>

