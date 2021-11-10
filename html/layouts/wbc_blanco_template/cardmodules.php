 <?php 
 /* Layout für Module Card Columns 
 /* Author: Claudia Oerter
 /* Webconcept
 /* Stand: 11 / 2020

 */

defined('JPATH_BASE') or die;


extract($displayData);

$cardcolumns = "cardcols_" . $Modules_cols;

?>         
           
 <div id="wbc-<?php echo $Modules;?>" class="wbc-flexible-cards card-columns <?php echo $cardcolumns; ?>">  
             
   <?php
   		
                                               
		 
		  $modules  	= JModuleHelper::getModules($Modules);
		  $col_class    = '';
		  $style    	= 'cardbs4'; 
		  $position 	= $Modules;
		  $count 		= count($modules);
		  $countercol 	= 1;
		  $i = 0; ?>
		 
		  <?php // muss eine zeile rein !!!				
		  foreach($modules as $mod) : 
		  
		  $modparams = $mod->params;  // modulparameter ?>
		  
		  <?php
		  
		
		   if ($count == $i) { $col_class = ' last'; } 
							
		  // jetzt die module in die divs packen ?>  
		
			<div class="extension-outer-<?php echo $Modules;?> card <?php echo $col_class;?>">
			  <?php echo JModuleHelper::renderModule($modules[$i], array('style' => $style, 'position' => $position )); ?>
			  
			</div>
		 
		  <?php
		  $i++ ; ?>
		   
		  
		  <?php endforeach; ?>
  </div> 