<?php
defined( '_JEXEC' ) or die; 

$app            = JFactory::getApplication();
$templatepath   = JURI::base(true).'/templates/'.$app->getTemplate().'/';

?>

<div id="styleswitcher" class="d-none d-sm-block mb-3 navbar-css-switch" >
  <p><strong><?php echo JText::_('TPL_CO_BLANCO_J3_CSSSWITCH')?></strong></p>
  <button class="btn btn-default" data-stylesheet="<?php echo  $templatepath . 'css/default.css';?>"><?php echo JText::_('TPL_CO_BLANCO_J3_CSSSWITCH_DEFAULT')?></button>
  <button class="btn btn-default" data-stylesheet="<?php echo  $templatepath .  'css/hk.css';?>"><?php echo JText::_('TPL_CO_BLANCO_J3_CSSSWITCH_HK')?></button>
</div>
