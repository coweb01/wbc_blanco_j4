<?php
/**
 * @package     	Joomla.Site
 * @subpackage  	mod_menu override
 * @copyright   	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     	GNU General Public License version 2 or later; see LICENSE.txt
 * Modifications	Joomla CSS
 * Layout c.oerter  memue sublevel mit spalten & accesskey
 *  Modulposition Quicklinks in das Dropdownmenü integrieren

 */

defined('_JEXEC') or die;
// Note. It is important to remove spaces between elements.


$document = JFactory::getDocument();
$app      = JFactory::getApplication();
$tpath    = JURI::base( true ) .'/templates/'.$app->getTemplate();
$document->addStyleSheet($tpath . '/html/mod_menu/assets/akdropdown.css', array('version' => 'auto')); 

?>
<?php // The menu class is deprecated. Use nav instead. ?>
<ul class="nav menu akdropdown <?php echo $class_sfx;?>"<?php
	$tag = '';
	if ($params->get('tag_id') != null)
	{
		$tag = $params->get('tag_id').'';
		echo ' id="'.$tag.'"';
	}
?>>
<?php

	$col = 0; 
	$rowminwidth   = 0; /* init*/
	$iStyle = 0;    
	$inlineStyle        = array();
	$open_cols          = false;  // schalter zurücksetzen
	$switch_item_deeper = false;

foreach ($list as $i => &$item) :
	
	$cssarrow           = '';
    $menuitem      = $app->getMenu()->getItem($item->id);

	$menuparams    = $menuitem->params;
    $accesskey     = $menuparams->get('accesskey'); 
    $parentitem    = $menuparams->get('parentitem',0);
    $subtitle      = $menuparams->get('description','');
    $menuecol      = $menuparams->get('menucolumn',0);
    $menucolwidth  = $menuparams->get('columnwidth',33.33);
	$stylecolumn   = ' style="flex: 0 0 ' . $menucolwidth . '%;"';
	
	 	
 	$class = 'nav-item item-'.$item->id;
	$class .=  $item->anchor_css ? ' '.$item->anchor_css : '';
	$class .= ' level' . $item->level;
  
    if ( $item->level == 2 ) {$cssarrow           = ' class="arrow down hide"'; }
   
   
    if ($item->id == $active_id)
	{
		$class .= ' current';
	}

	if (in_array($item->id, $path))
	{
		$class .= ' active';
	}
	elseif ($item->type == 'alias')
	{
		$aliasToId = $item->params->get('aliasoptions');
		if (count($path) > 0 && $aliasToId == $path[count($path) - 1])
		{
			$class .= ' active';
		}
		elseif (in_array($aliasToId, $path))
		{
			$class .= ' alias-parent-active';
		}
	}

	if ($item->type == 'separator')
	{
		$class .= ' divider quicklink';
	}

	
	if ($item->deeper) {
		if ($item->level < 2) {
			$class .= ' dropdown deeper';			
			$class .= ( $parentitem == 1 ) ? ' multicolumn ' : '';
		}
		else {
			$class .= ' dropdown-submenu deeper ';
		}
	}


	if ($item->parent)
	{
		$class .= ' parent';
	}
	
	$classcolumn = $class;
	$classcolumn .= ' multi-column';
    $classcolumn = ' class="'.trim($classcolumn) .'"';

	if (!empty($class))
	{
        $class = ' class="'.trim($class) .'"';
	}

	if ( $switch_item_deeper == true ) :

		 if ( $menuecol == 1 )  //oeffnen wenn mehrspaltig
		  {
			  echo '<span' . $cssarrow. '></span><ul class="nav-child d-flex flex-row dropdown-menu dropdown-level' .  $item_level . ' multicolumn-dropdown multicolumn-dropdown-'. $item_id.'">'. "\n";
			  $col                    = 0; 
			  $rowminwidth            = 0; 
			  $rowid                  = $item_id; 
				  
		  } else {	  echo '<span' . $cssarrow. '></span><ul class="nav-child unstyled small dropdown-menu dropdown-level' .  $item_level . '">'. "\n";  }
		  
		  if ( $item_level < 2 ) { 
		  //echo ( $quicklinkOn == true ) ? $quicklinks : '';	
		  echo '<li><h3 class="menutitle">'.$rowtitle.'</h3></li>'. "\n";
		  }
		  
		  $switch_item_deeper = false; 
            
	endif;  
	  
	 // html item levels 
	switch ($item->level) :
		case 3:  echo '<li'.$class.'>';
				 break;
		case 2:  
 				 if (  $menuecol == 1 ) :
				   
			          if ( $open_cols == true ) { // vorherige Spalte erst schliessen.
						  echo '</ul><div class="clearfix"></div></div></li>'. "\n";
						  $open_cols = false; 
						  }
				       
					  $rowminwidth  = $rowminwidth + $menucolwidth;
			
					  echo '<li '.$classcolumn.  $stylecolumn.'>'. "\n";
					  //echo '<div class="wrap-nav-col">'. "\n";
					  echo '<div id="nav-col-' .$col. '-'. $item->id . '-' . $module->id .'" class="nav-col nav-col-'. $col.'">'. "\n";
					  echo '<ul>'. "\n";
					  echo '<li'.$class.'>'. "\n";
					  $col++;
					  $open_cols = true;
					  
			     else : 

					  echo '<li'.$class.'>'; 
			  	 	
					endif;
				 break;
		case 1:  
				 echo '<li'.$class.'>';
				 $rowtitle = ($menuparams->get('headlinedropdown')) ? $menuparams->get('headlinedropdown') : $item->title;
				 break;
	endswitch;
	
	  
	// Render the menu item.
	switch ($item->type) :
		case 'separator':
		case 'url':
		case 'component':
		case 'heading':
			require JModuleHelper::getLayoutPath('mod_menu', 'AKQdropdown_'.$item->type);
			break;

		default:
			require JModuleHelper::getLayoutPath('mod_menu', 'AKQdropdown_url');
			break;
	endswitch;

 

	// The next item is deeper.
	
	if ($item->deeper) {
		
		// merke .. ul wird spaeter geoeffnet
		$switch_item_deeper = true;
		$item_level = $item->level;
		$item_id = $item->id;
		
		
		// The next item is shallower.
		
     	} elseif ($item->shallower) {
			
			 $level_next = $item->level-$item->level_diff;
			 $level_diff = $item->level_diff;
			
			 if ( $item->level > 2 )  { 
			     if ( $open_cols == true && $level_next == 1  ) {
					  $level_diff = $level_diff-1;  
					  echo '</li>'. "\n";;
					  echo str_repeat('</ul></li>',$level_diff );	
					 
					  
					  echo '</ul><div class="clearfix"></div></div></li>'. "\n";
					  $level_diff = 1;
					
					  //$inlineStyle[$iStyle]   = '.multicolumn-dropdown-' . $rowid  . ' { ';	
					  //$inlineStyle[$iStyle]  .= 'min-width: ';
					  //$inlineStyle[$iStyle]  .=  $rowminwidth+20  . 'px; }';
					  $iStyle++; 
					  $open_cols = false; 				
				  
				   } else { echo '</li>';}
				   
			  } else  if ( $item->level == 2  && $open_cols == true  ) {
	                
					  echo '</li>';
					  echo '</ul><div class="clearfix"></div></div></li>'. "\n";

					  //$inlineStyle[$iStyle]   = '.multicolumn-dropdown-' . $rowid  . ' { ';	
					  //$inlineStyle[$iStyle]  .= 'min-width: ';
					  //$inlineStyle[$iStyle]  .=  $rowminwidth+20  . 'px; }';
					  $iStyle++; 
					  $open_cols = false; 
					  
			   } else {  echo '</li>'. "\n"; }
   
			 
		      echo str_repeat('</ul></li>', $level_diff);
			  
		}
		// The next item is on the same level.
		else {echo '</li>';}
	
	
	
endforeach;

 if ($open_cols == true ) {
	  //$inlineStyle[$iStyle]   = '.multicolumn-dropdown-' . $rowid  . ' { ';	
	 // $inlineStyle[$iStyle]  .= 'min-width: ';
	//  $inlineStyle[$iStyle]  .=  $rowminwidth+20  . 'px !important; }';
	  $iStyle++; 
	  $open_cols = false; 
 }
 
?></ul>

<?php
//$style = implode  ('  ', $inlineStyle);

//$document->addStyleDeclaration( $style );

?>