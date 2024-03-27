 <?php
 /* Layout für Module Card Columns
 /* Author: Claudia Oerter
 /* Webconcept
 /* Stand: 11 / 2020

 */

defined('JPATH_BASE') or die;

use Joomla\CMS\Helper\ModuleHelper;

extract($displayData);

$cardcolumns = "cardcols_" . $Modules_cols;
$modules = ModuleHelper::getModules($Modules);
$style = 'card';
$position = $Modules;

?>

<div id="wbc-<?php echo $Modules;?>" class="wbc-flexible-cards card-columns <?php echo $cardcolumns; ?>">
    <?php foreach($modules as $mod) : ?>
        <?php echo ModuleHelper::renderModule($mod, array('style' => $style, 'position' => $position )); ?>
    <?php endforeach; ?>
</div>
