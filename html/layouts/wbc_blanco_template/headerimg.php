<?php
/*
*  HTML fuer das Headerbild
*  verwendete Klassen: wbc-background-image-stretch
*
*  Standard Module Style ist headerimg. Achtung: Gibt nur das Hintergrundbild aus dem
Modul mod_custom aus. Keinen Modulinhalt.
*
* Hintergrundbild responsive. Die hoehe des Containers muss dem container individuell definiert werden.
*
*  Wenn ein Slidermodul benutzt wird muss der Modulstyle im Modul geaendert werden.
*
*/

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

extract($displayData);
$htmlbackground = '';
$imagearray = array();
$backgroundimage = '';
$backgroundimageClass = "wbc-background-image-stretch";

if (isset($CustomModules['header']['rawvalue']) && !empty($CustomModules['header']['rawvalue'])) {
    $imagearray = json_decode( $CustomModules['header']['rawvalue'], false);
    $backgroundimage = $imagearray->imagefile;
} elseif (!empty($jhtml->params->get('headerimg'))) {
    $backgroundimage = $jhtml->params->get('headerimg');
    $backgroundimageClass .= " wbc-default_headerimg";
}
if ( !empty($backgroundimage )) {
    $htmlbackground  =  '<div class="';
    $htmlbackground .=  $backgroundimageClass;
    $htmlbackground .=  '" style="background-image: url(';
    $htmlbackground .=  Uri::root(true) . '/' . HTMLHelper::_('cleanImageURL', $backgroundimage)->url;
    $htmlbackground .=  ')"></div>';
}   
?>

<!-- start headerimg -->
<div id="headerimg" class="headerimg <?php echo ($jhtml->params->get('bg-headerimg') != '') ? 'bg-headerimg'  : ''; ?>"  aria-label="<?php echo Text::_('TPL_WBC_BLANCO_J4_HEADERIMG'); ?>">
    <div class="container<?php echo ($jhtml->params->get('headerimg-width') == 1) ? '-fluid' : '';?>">
        <div class="base-row row">
            <div class="base-col wrap-headerimg <?php $headerimgSizeClass; ?> <?php echo $bootstrap_colclass; ?>12" >

            <?php
                if ($jhtml->countModules('headerimg') || (isset( $imagearray) && !empty( $imagearray))):?>
                    <?php if (isset( $imagearray) && !empty( $imagearray)) : ?>
                        <?php echo  $htmlbackground; ?>
                    <?php elseif ($jhtml->countModules('headerimg')) : ?>
                            <jdoc:include type="modules" name="headerimg" style="headerimg" />
                    <?php endif; ?>
            <?php else : ?>
            <?php    echo $htmlbackground; ?>           
            <?php endif; ?>

            <?php if($jhtml->countModules('headerimg-overlay')) : ?>
                <div id="overlay_headerimg" class="overlay_headerimg d-none d-sm-block">
                    <jdoc:include type="modules" name="headerimg-overlay" style="none"/>
                </div>
            <?php endif; ?>
            </div>
        </div>
    </div>
</div><!--End headerimg -->
