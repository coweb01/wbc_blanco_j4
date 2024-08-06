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

$imagearray = array();
$backgroundimage = '';

if (isset($imgHeaderraw) && !empty($imgHeaderraw)) {
    $imagearray = json_decode($imgHeaderraw, false);
    $backgroundimage = $imagearray->imagefile;
} elseif (!empty($jhtml->params->get('headerimg'))) {
    $backgroundimage = $jhtml->params->get('headerimg');
}

if ( !empty($backgroundimage )) {
    $htmlbackground  =  '<div class="wbc-background-image-stretch" style="background-image: url(';
    $htmlbackground .=  Uri::root(true) . '/' . HTMLHelper::_('cleanImageURL', $backgroundimage)->url;
    $htmlbackground .=  ')"></div>';
}   
?>

<!-- start headerimg -->
<div id="headerimg" class="headerimg <?php echo ($jhtml->params->get('bg-headerimg') != '') ? 'bg-headerimg'  : ''; ?>" role="banner"  aria-label="<?php echo Text::_('TPL_WBC_BLANCO_J4_HEADERIMG'); ?>">
    <div class="container<?php echo ($jhtml->params->get('headerimg-width') == 1) ? '-fluid' : '';?>">
        <div class="base-row row">
            <div class="base-col wrap-headerimg <?php $headerimgSizeClass; ?> <?php echo $bootstrap_colclass; ?>12" >

            <?php
                if ($jhtml->countModules('headerimg') || (isset($imgHeader) && !empty($imgHeader))):?>
                    <?php if (isset($imgHeaderraw) && !empty($imgHeaderraw)) : ?>
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
