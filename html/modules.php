<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Templates.Base Template Joomla 3
 */

defined('_JEXEC') or die;

/*
 * html5 (chosen html5 tag and font header tags)
 */
 
function modChrome_cardbs4($module, &$params, &$attribs)
{
	$moduleTag      = $params->get('module_tag', 'div');
	$headerTag      = htmlspecialchars($params->get('header_tag', 'h3'));
	$bootstrapSize  = (int) $params->get('bootstrap_size', 0);
	

	// Temporarily store header class in variable
	$headerClass    = $params->get('header_class');
	$headerClass    = !empty($headerClass) ? ' class="' . htmlspecialchars($headerClass) . '"' : '';

	if (!empty ($module->content)) : ?>
		<?php echo '<' .$moduleTag . ' class="card-body ';?> <?php echo htmlspecialchars($params->get('moduleclass_sfx')) ?>">
        
		<?php if ((bool) $module->showtitle) :?>
			<div class="card-title">
			<<?php echo $headerTag . $headerClass . '>' . $module->title; ?></<?php echo $headerTag; ?>>
			</div>
		<?php endif; ?>
		
		<?php echo $module->content; ?>
            
		</<?php echo $moduleTag; ?>>

	<?php endif;
}

/*
 * html5 (chosen html5 tag and font header tags)
 */
 
function modChrome_default($module, &$params, &$attribs)
{
	$moduleTag      = $params->get('module_tag', 'div');
	$headerTag      = htmlspecialchars($params->get('header_tag', 'h3'));
	$bootstrapSize  = (int) $params->get('bootstrap_size', 0);
	$bootstrapSize  = ((int) $params->get('bootstrap_size', 12) == 0) ? '' : 'col-sm-' . (int) $params->get('bootstrap_size', 12);

	// Temporarily store header class in variable
	$headerClass    = $params->get('header_class');
	$headerClass    = !empty($headerClass) ? ' class="' . htmlspecialchars($headerClass) . '"' : '';

	if (!empty ($module->content)) : ?>
		<?php echo '<' .$moduleTag . ' class="extension-outer ';?><?php echo $bootstrapSize;?> <?php echo htmlspecialchars($params->get('moduleclass_sfx')) ?>">
        
		<?php if ((bool) $module->showtitle) :?>
			<div class="ext-header">
			<<?php echo $headerTag . $headerClass . '>' . $module->title; ?></<?php echo $headerTag; ?>>
			</div>
		<?php endif; ?>

			<?php echo $module->content; ?>
       
		</<?php echo $moduleTag; ?>>

	<?php endif;
}



/*
 * html5 onepage modul
 */

function modChrome_onepage($module, &$params, &$attribs)
{
	$app                = JFactory::getApplication();
	$templateparams     = $app->getTemplate(true)->params; // Templateparameter
	$bgimage            = $params->get('backgroundimage');      
	$moduleTag          = $params->get('module_tag', 'div');
	$headerTag          = htmlspecialchars($params->get('header_tag', 'h3'));
	$ankerid            = htmlspecialchars($params->get('header_class'));
	$bootstrap          = $templateparams->get('bootstrapselect');
	$bootstrapSize      = ((int) $params->get('bootstrap_size') == 0) ? '12' : (int) $params->get('bootstrap_size');
    
	if  ( $bootstrap == 4 ) { 
	     $bootstrapRowclass = "row";
		 $bootstrapColclass = "col-" . $bootstrapSize;  
	} else {
		 $bootstrapRowclass = "row-fluid";
		 $bootstrapColclass = "span" . $bootstrapSize;
		   }
	
	
	if ($module->content)
	{
		echo "\r\n";
		echo "<!-- ***************  start   section " . $ankerid ." **********************  --> \r\n";
			echo "<section id=\"onepage-" .$ankerid . "\" class=\"onepage\">\r\n";

				if ( $bgimage != '' ) {	
				echo "<div class=\"onepage-inner\" data-speed=\"8\" data-type=\"background\" style=\"background-image:url(" . $bgimage . "\")\">\r\n";					  
				} else {
				echo "<div class=\"onepage-inner " . htmlspecialchars($params->get('moduleclass_sfx'))."\">\r\n";		
				}
				if ($module->showtitle)	{ echo "<" .$headerTag. " class=\"page-header\"><div class=\"container\"><span class=\"mod-icon\"></span><span class=\"mod-title\">" . $module->title . "</span></div></".$headerTag.">";	}
					echo "<div class=\"container\" >\r\n";
					echo "<div class=\"" .$bootstrapRowclass. "\">\r\n";
						echo "<div class=\"". $bootstrapColclass . "\"> \r\n";
						echo "<div class=\"module-content\">" . $module->content . "</div>";
						echo "</div> \r\n";
					echo "</div> \r\n";
			echo "</div> \r\n";
		echo "</div>";
		echo "</section> \r\n";
		echo "<!-- ***************  end   section **********************  --> \r\n";
		echo "\r\n";

	}
}

/*
 * html5 headerimg
 */

function modChrome_onepageSlider($module, &$params, &$attribs)
{
	$app                 = JFactory::getApplication();
	$templateparams      = $app->getTemplate(true)->params; // Templateparameter
	
	$moduleTag           = $params->get('module_tag', 'div');
	$headerTag           = htmlspecialchars($params->get('header_tag', 'h3'));
	$ankerid             = htmlspecialchars($params->get('header_class'));
	$bgimage             = $params->get('backgroundimage');      
	$bootstrap           = $templateparams->get('bootstrapselect');
	$headerimgWidth      = $templateparams->get('headerimg-width', 1);
	$bootstrapSize       = ((int) $params->get('bootstrap_size') == 0) ? '12' : (int) $params->get('bootstrap_size');
    $headerimgSizeClass  = ( $templateparams->get('headerimg-width') == 2 ) ? 'sm-slider' : 'lg-slider';


	if  ( $bootstrap == 4 ) { 
	     $bootstrapRowclass = "row";
		 $bootstrapColclass = "col-12 col-md-" . $bootstrapSize;  
	} else {
		 $bootstrapRowclass = "row-fluid";
		 $bootstrapColclass = "span" . $bootstrapSize;
		   }
	
	
	if ($module->content)
	{
		echo "\r\n";
		echo "<!-- ***************  start   Headerimg **********************  --> \r\n";
			$containderclass = ( $headerimgWidth == 1 ) ? "-fluid" : "";
			
							echo $module->content;
			 
			  
		echo "<!-- ***************  end   Headerimg **********************  --> \r\n";
		echo "\r\n";

	}
}


function modChrome_onepagefullsize($module, &$params, &$attribs)
{
	$moduleTag      = $params->get('module_tag', 'div');
	$headerTag      = htmlspecialchars($params->get('header_tag', 'h3'));
	$ankerid        = htmlspecialchars($params->get('header_class'));
	$bootstrapSize  = 12;
	$moduleClass    = $bootstrapSize != 0 ? ' col-12 col-md-' . $bootstrapSize : '';
	
	if ($module->content)
	{
		echo "\r\n";
		echo "<!-- ***************  start   section **********************  --> \r\n";
		echo "<div id=\"" .$ankerid . "\" class=\"onepage-fullsize " . htmlspecialchars($params->get('moduleclass_sfx')) . "\">";
			echo '<div class="container-fluid" >';
				echo '<div class="row">';
			// 	echo '<div class="' . $moduleClass . '">';
				
				if ($module->showtitle)
				{
				echo '<div class="container">';	
				echo "\r\n";
				echo '<h3 class="page-header">' . $module->title . '</h3>';
				echo "\r\n";				
				echo '</div>';
				}
				
				echo '<div class="module-content">' . $module->content . '</div>';
			//	echo  '</div>';
				echo '</div>';
			echo "</div>";
		echo "</div> \r\n";
		echo "<!-- ***************  end   section **********************  --> \r\n";
		echo "\r\n";

	}
}

function modChrome_icon($module, &$params, &$attribs)
{
	$moduleTag      = $params->get('module_tag', 'div');
	$headerTag      = htmlspecialchars($params->get('header_tag', 'h3'));
	$bootstrapSize  = ((int) $params->get('bootstrap_size', 12) == 0) ? '' : 'col-sm-' . (int) $params->get('bootstrap_size', 12);
	

	// Temporarily store header class in variable
	$headerClass    = $params->get('header_class');
	$headerClass    = !empty($headerClass) ?  htmlspecialchars($headerClass)  : 'fa fa-bars';

	if (!empty ($module->content)) : ?>
		<?php echo '<' .$moduleTag . ' class="extension-outer extension-outer-icon ';?> <?php echo htmlspecialchars($params->get('moduleclass_sfx')) .  $bootstrapSize; ?>">
            <div class="extension-inner extension-icon">
            <?php if ((bool) $module->showtitle) :?>
                <div class="ext-header"><span class="ext-icon-block "><i class="<?php echo $headerClass;?>"></i></span><?php echo '<'.$headerTag . '>' . $module->title; ?></<?php echo $headerTag; ?>></div>
            <?php endif; ?>
    
                <?php echo $module->content; ?>
            </div>
		</<?php echo $moduleTag; ?>>

	<?php endif;
}


/*
 * html5 headerimg als Background image  */

function modChrome_headerimg($module, &$params, &$attribs)
{
	$app                 = JFactory::getApplication();
	$templateparams      = $app->getTemplate(true)->params; // Templateparameter
	$bgimage             = htmlspecialchars($params->get('backgroundimage'));      
	$ankerid             = htmlspecialchars($params->get('header_class'));
   
    
	if ( $bgimage != '' ) {	?>

		<div id="headerimg-<?php echo $ankerid;?>" class="wbc-background-image-stretch" style="background-image:url('<?php echo $bgimage;?>')">			
		</div>
		
	<?php }
}




?>