<?php

defined('_JEXEC') or die;

$r = '255';
$g = '255';
$b = '255';

if ($templateparams->get('bgnavbarcolor')) {
	$r = hexdec(substr($templateparams->get('bgnavbarcolor'),1,2));
	$g = hexdec(substr($templateparams->get('bgnavbarcolor'),3,2));
	$b = hexdec(substr($templateparams->get('bgnavbarcolor'),5,2));
}

$wa->addInlineStyle('
:root {
	--fontsize: ' . $templateparams->get('defaultfontsize') . 'rem;
	--bgfooter: ' . $templateparams->get('bgfootercolor') . ';
	--bgfooterfix: ' . $templateparams->get('bgfootercolorfix') . ';
	--bgfooterB: ' . $templateparams->get('bgfootercolorB') . ';

	--bgnavbar: ' . $templateparams->get('bgnavbarcolor') . ';
	--bgnavbarr: ' . $r .';
	--bgnavbarg: ' . $g .';
	--bgnavbarb: ' . $b .';
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

	--bgnavbarcolor: ' . $templateparams->get('bgnavbarcolor') . ';

	--colornavbar: ' . $templateparams->get('colornavbar') . ';
	--Linkcolornavbar: ' . $templateparams->get('Linkcolornavbar') . ';
	--Hovercolornavbar: ' . $templateparams->get('Hovercolornavbar') . ';
	--Activecolornavbar: ' . $templateparams->get('Activecolornavbar') . ';

	--linkcolorbtn: ' . $templateparams->get('Linkcolorbtn') . ';
	--linkbgcolorbtn: ' . $templateparams->get('Linkbgcolorbtn') . ';
	--hovercolorbtn: ' . $templateparams->get('Hovercolorbtn') . ';
	--hoverbgcolorbtn: ' . $templateparams->get('Hoverbgcolorbtn') . ';
	--activecolorbtn: ' . $templateparams->get('Activecolorbtn') . ';
	--activebgcolorbtn: ' . $templateparams->get('Activebgcolorbtn') . ';

	--transnavbar: ' . $templateparams->get('transnavbar') . ';
}'
);
