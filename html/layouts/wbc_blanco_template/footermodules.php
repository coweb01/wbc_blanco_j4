<?php
defined( '_JEXEC' ) or die; 

extract($displayData);
?>           

<?php
       $fcolbootstrap = 12;

		/** Spaltenanzahl im Footer */
		switch ($footercols) {
			case 3: $fcolbootstrap = 4;
			        break;
			case 4: $fcolbootstrap = 3;
				break;
			case 2: $fcolbootstrap = 6;
			        break;
			      
		}
   		$col_class   = ' col-12 '; 
   		$col_class  .= ( isset($bootstrap_colclass_mobil_sm)) ? $bootstrap_colclass_mobil_sm . '6 ' : ' ';
   		$col_class  .= ' ' .$bootstrap_colclass. $fcolbootstrap;

    
	   
	  	$modules  = JModuleHelper::getModules('footer');
	  	$style    = 'none'; 
	  	$position = 'footer';
	  	$count = count($modules);
	  	$countercol = 1;
	  	$i = 0; ?>
		
          <div class="row">
		  <?php // muss eine zeile rein !!!				
		  foreach($modules as $mod) : 
		  
		  $modparams = $mod->params;  // modulparameter ?>
		  
		  <?php
			   if ($count == $i) { $col_class .= ' last'; } 
								
			  // jetzt die module in die divs packen ?>  

              <div  id="footer-0<?php echo $i;?>" class="base-col <?php echo $col_class; ?>">
			  <?php echo JModuleHelper::renderModule($modules[$i], array('style' => $style, 'position' => $position )); ?>
			  <div class="clearfix"></div>
			  </div>
			  <?php
			  $i++ ;
			  $countercol++;
			  $css_row = $i % $footercols;
		  
		  if ( $css_row == 0 || $count == $i)  { ?>
		 
		  <?php } ?>
		  
		  <?php endforeach; ?>
          </div>
