<?php

defined( '_JEXEC' ) or die; 

/* Template Farben  Less Datein compilieren / CSS  *************************************/

$less = new JLess;
$less->setFormatter(new JLessFormatterJoomla);
//$source = JPATH_ROOT.'/templates/wbc_blanco_bts4/less/template.less';
//$output = JPATH_ROOT.'/templates/wbc_blanco_bts4/css/template.css';

if ( JFile::exists( JPATH_ROOT. '/templates/'.$this->template . '/less/custom.less' ) ) {   

		$templates = array(JPATH_ROOT.'/templates/'.$this->template . '/less/template.less' =>
					JPATH_ROOT.'/templates/'.$this->template . '/css/template.css',
					JPATH_ROOT.'/templates/'.$this->template . '/less/custom.less' =>
					JPATH_ROOT.'/templates/'.$this->template . '/css/custom.css',
					JPATH_ROOT.'/templates/'.$this->template . '/less/hk.less' =>
					JPATH_ROOT.'/templates/'.$this->template . '/css/hk.css',
					JPATH_ROOT.'/templates/'.$this->template . '/less/default.less' =>
					JPATH_ROOT.'/templates/'.$this->template . '/css/default.css',	
					 );
} else {
		$templates = array(JPATH_ROOT.'/templates/'.$this->template . '/less/template.less' =>
					JPATH_ROOT.'/templates/'.$this->template . '/css/template.css'
					);
}



// HEX Farbwert in RGB umwandeln 

$r = '255';
$g = '255';
$b = '255';

if ($templateparams->get('bgnavbarcolor')) {
	
	$r   = hexdec(substr($templateparams->get('bgnavbarcolor'),1,2)); 
	$g   = hexdec(substr($templateparams->get('bgnavbarcolor'),3,2)); 
	$b   = hexdec(substr($templateparams->get('bgnavbarcolor'),5,2));
	//var_dump($rgb);
} 

if ($templateparams->get('fontawesome', 5) == 5) {
	$iconfont  = "Font Awesome 5 Free";

	
}

$less->setVariables(array(

		'fontsize'		    =>  $templateparams->get('defaultfontsize', '1.2rem'),
		'bgfooter'          =>  $templateparams->get('bgfootercolor', '#DDDDDD'),
		'bgfooterfix'       =>  $templateparams->get('bgfootercolorfix', '#333333'),
		'bgfooterB'         =>  $templateparams->get('bgfootercolorB', '#333333'),

		'bgnavbar'          =>  $templateparams->get('bgnavbarcolor', '#DDDDDD'),
		'bgcolor'           =>  $templateparams->get('backgroundcolor', '#FFFFFF'),
		'bgcolormain'       =>  $templateparams->get('backgroundcolormain', '#FFFFFF'),
		'defaultcolor'      =>  $templateparams->get('defaultcolor', '#333333'),
		'linkcolor'         =>  $templateparams->get('linkcolor', '#333333'),
		'linkHovercolor'    =>  $templateparams->get('linkHovercolor', '#333333'),

		'h1_color'          =>  $templateparams->get('h1_color', '#666666'), 
		'h2_color'          =>  $templateparams->get('h2_color', '#333333'),
		'h3_color'          =>  $templateparams->get('h3_color', '#333333'),
		'h4_color'          =>  $templateparams->get('h4_color', '#333333'),

		'h1_size'           =>  $templateparams->get('h1_size', '1.8rem'), 
		'h2_size'           =>  $templateparams->get('h2_size', '1.6rem'),
		'h3_size'           =>  $templateparams->get('h3_size', '1.4rem'),
		'h4_size'           =>  $templateparams->get('h4_size', '1rem'),

		'colorfooter'	    =>  $templateparams->get('Colorfooter'),
		'Linkcolorfooter'   =>  $templateparams->get('Linkcolorfooter'),
		'Hovercolorfooter'  =>  $templateparams->get('Hovercolorfooter'),
		'Activecolorfooter' =>  $templateparams->get('Activecolorfooter'),

		'colorfooterB'	     =>  $templateparams->get('ColorfooterB'),
		'LinkcolorfooterB'   =>  $templateparams->get('LinkcolorfooterB'),
		'HovercolorfooterB'  =>  $templateparams->get('HovercolorfooterB'),
		'ActivecolorfooterB' =>  $templateparams->get('ActivecolorfooterB'),

		'colorfooterfix'	   =>  $templateparams->get('Colorfooterfix'),
		'Linkcolorfooterfix'   =>  $templateparams->get('Linkcolorfooterfix'),
		'Hovercolorfooterfix'  =>  $templateparams->get('Hovercolorfooterfix'),
		'Activecolorfooterfix' =>  $templateparams->get('Activecolorfooterfix'),
		
		'bgnavbarcolor'		=>  $templateparams->get('bgnavbarcolor'),
		'bgnavbarcolorR'    =>  $r,
		'bgnavbarcolorG'    =>  $g,
		'bgnavbarcolorB'    =>  $b,

		'colornavbar'       =>  $templateparams->get('colornavbar', '#333333'),	
		'Linkcolornavbar'   =>  $templateparams->get('Linkcolornavbar', '#333333'),
		'Hovercolornavbar'  =>  $templateparams->get('Hovercolornavbar', '#333333'),
		'Activecolornavbar' =>  $templateparams->get('Activecolornavbar', '#333333'),

		'linkcolorbtn'      =>  $templateparams->get('Linkcolorbtn', '#333333'),	
		'linkbgcolorbtn'    =>  $templateparams->get('Linkbgcolorbtn', '#333333'),
		'hovercolorbtn'     =>  $templateparams->get('Hovercolorbtn', '#333333'),
		'hoverbgcolorbtn'   =>  $templateparams->get('Hoverbgcolorbtn', '#333333'),
		'activecolorbtn'    =>  $templateparams->get('Activecolorbtn', '#333333'),
		'activebgcolorbtn'  =>  $templateparams->get('Activebgcolorbtn', '#333333'),

		'transnavbar'       =>  $templateparams->get('transnavbar', '1'),
		'iconfont'          =>  '"'.$iconfont .'"'

)); 

foreach ($templates as $source => $output) {

		// create a new cache object, and compile
		$cache = $less->cachedCompile($source);
		//var_dump($cache);
		file_put_contents($output, $cache["compiled"]);

		// the next time we run, write only if it has updated
		$last_updated = $cache["updated"];
		$cache = $less->cachedCompile($cache);
		if ($cache["updated"] > $last_updated) {
		    file_put_contents($output, $cache["compiled"]);
		}
}
//$less->compileFile($source, $output);

?>