<?php
/************************************************************************************/
/*****   HTML fuer Logo                                                             */
/************************************************************************************/

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;

extract($displayData);
$css_logo_mobil = 'd-block d-md-none';
$css_logo_desk  = 'd-none d-md-block';

// Logo file or site title param
if (!empty($logo_mobil)) {
    $logoMobil = HTMLHelper::_('image', Uri::root(false) . htmlspecialchars($logo_mobil, ENT_QUOTES), $sitename, ['loading' => 'eager', 'decoding' => 'async'], false, 0);
} elseif (!empty($sitetitle)) {
    $logoMobil = '<span title="' . $sitename . '">' . htmlspecialchars($sitetitle, ENT_COMPAT, 'UTF-8') . '</span>';
}
if (!empty($logo)) {
    $logo = HTMLHelper::_('image', Uri::root(false) . htmlspecialchars($logo, ENT_QUOTES), $sitename, ['loading' => 'eager', 'decoding' => 'async'], false, 0);
} elseif (!empty($sitetitle)) {
    $logo = '<span title="' . $sitename . '">' . htmlspecialchars($sitetitle, ENT_COMPAT, 'UTF-8') . '</span>';
}

?>

<div id="logo" class="base-col wbc__logo">

    <?php if (!empty($logo_mobil) || $jhtml->countModules('logo-mobil')) : ?>
        <div class="logo-mobil <?php echo $css_logo_mobil; ?>">
            <?php if ($jhtml->countModules('logo-mobil')): ?>
                <jdoc:include type="modules" name="logo-mobil" />
            <?php else : ?>
                <a href="<?php echo Uri::root(false); ?>"><?php echo $logoMobil; ?></a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if ($jhtml->countModules('logo') || (!empty($logo))): ?>
        <div class="logo-desk <?php echo $css_logo_desk;?>">
            <?php if ($jhtml->countModules('logo')): ?>
            <jdoc:include type="modules" name="logo" />
            <?php elseif (!empty($logo)) : ?>
                <a href="<?php echo Uri::root(false); ?>"><?php echo $logo; ?></a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
