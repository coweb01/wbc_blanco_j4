<?php
defined( '_JEXEC' ) or die;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

$app            = Factory::getApplication();
$mediapath   = 'media/templates/site/wbc_blanco_j4/';
?>

<div id="styleswitcher" class="d-none d-sm-block mb-3 navbar-css-switch" >
  <p><strong><?php echo Text::_('TPL_CO_BLANCO_J4_CSSSWITCH')?></strong></p>
  <button class="btn btn-default" data-stylesheet="<?php echo  $mediapath . 'css/default.css';?>"><?php echo Text::_('TPL_CO_BLANCO_J4_CSSSWITCH_DEFAULT')?></button>
  <button class="btn btn-default" data-stylesheet="<?php echo  $mediapath .  'css/hk.css';?>"><?php echo Text::_('TPL_CO_BLANCO_J4_CSSSWITCH_HK')?></button>
</div>
