 <?php
 /* Layout für Module Card Columns
 /* Author: Claudia Oerter
 /* Webconcept
 /* Stand: 11 / 2020

 */

defined('JPATH_BASE') or die;

use Joomla\CMS\Helper\ModuleHelper;

extract($displayData);

$modules = ModuleHelper::getModules($Modules);
$style = 'card';
$position = $Modules;

?>
<div class="clearfix"></div>
<div id="wbc-<?php echo $Modules;?>" class="wbc-flexible-cards card-columns">
    <?php foreach($modules as $mod) : ?>
        <?php echo ModuleHelper::renderModule($mod, array('style' => $style, 'position' => $position )); ?>
    <?php endforeach; ?>
</div>
