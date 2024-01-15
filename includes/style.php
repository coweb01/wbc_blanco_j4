<?php

defined('_JEXEC') or die;

$r = '255';
$g = '255';
$b = '255';
$bgnavbaroptions = $templateparams->get('bgnavbaroptions');

if ( $templateparams->get('bgnavbar') == 0) {
	$bgnavbarcolor = 'transparent';
} else {
	if (!empty($bgnavbaroptions->bgnavbarcolor && $bgnavbaroptions->bgnavbarcolor != 'transparent' )) {
		$r = hexdec(substr($bgnavbaroptions->bgnavbarcolor,1,2));
		$g = hexdec(substr($bgnavbaroptions->bgnavbarcolor,3,2));
		$b = hexdec(substr($bgnavbaroptions->bgnavbarcolor,5,2));
	}
	$bgnavbarcolor = 'rgba('.$r.','.$g.','.$b.','.$bgnavbaroptions->transnavbar.')';
}

$wa->addInlineStyle('
:root {
	--color1: ' . $templateparams->get('color1') . ';
	--color2: ' . $templateparams->get('color2') . ';
	--color3: ' . $templateparams->get('color3') . ';
	--color4: ' . $templateparams->get('color4') . ';
	--color5: ' . $templateparams->get('color5') . ';
	
	--fontsize: ' . $templateparams->get('defaultfontsize') . 'rem;
	--bgfooter: ' . $templateparams->get('bgfootercolor') . ';
	--bgfooterfix: ' . $templateparams->get('bgfootercolorfix') . ';
	--bgfooterB: ' . $templateparams->get('bgfootercolorB') . ';

	--bgnavbar: ' . $templateparams->get('bgnavbarcolor') . ';
	--bgnavbarcolor: '. $bgnavbarcolor . ';
	--bgcolor: ' . $templateparams->get('backgroundcolor') . ';
	--bgcolormain: ' . $templateparams->get('backgroundcolormain') . ';
	--defaultcolor: ' . $templateparams->get('defaultcolor') . ';
	--linkcolor: ' . $templateparams->get('linkcolor') . ';
	--linkHovercolor: ' . $templateparams->get('linkHovercolor') . ';

	--h1_color: ' . $templateparams->get('h1_color') . ';
	--h2_color: ' . $templateparams->get('h2_color') . ';
	--h3_color: ' . $templateparams->get('h3_color') . ';
	--h4_color: ' . $templateparams->get('h4_color') . ';

	--h1_size: ' . $templateparams->get('h1_size') . 'rem;
	--h2_size: ' . $templateparams->get('h2_size') . 'rem;
	--h3_size: ' . $templateparams->get('h3_size') . 'rem;
	--h4_size: ' . $templateparams->get('h4_size') . 'rem;

	--colorfooter: ' . $templateparams->get('Colorfooter') . ';
	--Linkcolorfooter: ' . $templateparams->get('Linkcolorfooter') . ';
	--Hovercolorfooter: ' . $templateparams->get('Hovercolorfooter') . ';
	--Activecolorfooter: ' . $templateparams->get('Activecolorfooter') . ';

	--colorfooterB: ' . $templateparams->get('ColorfooterB') . ';
	--LinkcolorfooterB: ' . $templateparams->get('LinkcolorfooterB') . ';
	--HovercolorfooterB: ' . $templateparams->get('HovercolorfooterB') . ';
	--ActivecolorfooterB: ' . $templateparams->get('ActivecolorfooterB') . ';

	--colorfooterfix: ' . $templateparams->get('Colorfooterfix') . ';
	--Linkcolorfooterfix: ' . $templateparams->get('Linkcolorfooterfix') . ';
	--Hovercolorfooterfix: ' . $templateparams->get('Hovercolorfooterfix') . ';
	--Activecolorfooterfix: ' . $templateparams->get('Activecolorfooterfix') . ';

	--colornavbar: ' . $templateparams->get('colornavbar') . ';
	--Linkcolornavbar: ' . $templateparams->get('Linkcolornavbar') . ';
	--Hovercolornavbar: ' . $templateparams->get('Hovercolornavbar') . ';
	--Activecolornavbar: ' . $templateparams->get('Activecolornavbar') . ';

	--linkcolorbtn: ' . $templateparams->get('Linkcolorbtn') . ';
	--linkbgcolorbtn: ' . $templateparams->get('Linkbgcolorbtn') . ';
	--linkbordercolorbtn: ' . $templateparams->get('Linkcolorbtn') . ';

	--hovercolorbtn: ' . $templateparams->get('Hovercolorbtn') . ';
	--hoverbgcolorbtn: ' . $templateparams->get('Hoverbgcolorbtn') . ';
	--hoverbordercolorbtn: ' . $templateparams->get('Hovercolorbtn') . ';

	--activecolorbtn: ' . $templateparams->get('Activecolorbtn') . ';
	--activebgcolorbtn: ' . $templateparams->get('Activebgcolorbtn') . ';
	--activebordercolorbtn: ' . $templateparams->get('Activecolorbtn') . ';
	
	--transnavbar: ' . $templateparams->get('transnavbar') . ';
}'
);