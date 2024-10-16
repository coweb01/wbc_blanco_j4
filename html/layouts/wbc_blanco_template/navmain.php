<?php
    defined('JPATH_BASE') or die;

    use Joomla\CMS\Factory;
    use Joomla\CMS\HTML\HTMLHelper;
    use Joomla\CMS\Language\Text;
    use Joomla\CMS\Layout\FileLayout;
    use Joomla\CMS\Uri\Uri;

    HTMLHelper::_('bootstrap.collapse');
    HTMLHelper::_('bootstrap.offcanvas');

    $variablen = $displayData;
    extract($displayData);

    $app       = Factory::getApplication();
    $tpath     = 'templates/site/wbc_blanco_j4/';

    $btn_color = '';
    if ($offcanvas_color == 'offcanvas-dark') {
        $btn_color = '-white';
    }

?>

<?php if (($toggle_offcanvas_pos == "end") && ($logoposition == 1)) : ?>
    <div class="navbar-brand logo-mo">
        <?php
        $LayoutLogo = new FileLayout('wbc_blanco_template.logopos', $tpath.'html/layouts');
        echo $LayoutLogo ->render($displayData);
        ?>
    </div>
    <?php if ($jhtml->countModules('offcanvas-navbar')) :?>
        <div class="offcanvas-navbar">
            <jdoc:include type="modules" name="offcanvas-navbar" style="none" />
        </div>
    <?php endif; ?>
<?php endif;  ?>
<div class="navbar-button">
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#OffcanvasMenu<?php echo $offcanvas_pos; ?>" aria-controls="OffcanvasMenu<?php echo $offcanvas_pos;?>" aria-label="<?php echo Text::_('TPL_WBC_MENU'); ?>">
        <svg class="svg-toggler-icon" width="20" height="27" viewBox="0 0 20 27" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg">
            <rect class="toggler-line1" y="12" width="20" height="2"></rect>
            <rect class="toggler-line2" y="3" width="20" height="2"></rect>
            <rect class="toggler-line3" y="12" width="20" height="2"></rect>
            <rect class="toggler-line4" y="21" width="20" height="2"></rect>
        </svg>
    </button>
    <span class="wbc__offcanvas-toggler-button-txt" aria-hidden="true"><?php echo Text::_('TPL_WBC_MENU'); ?></span>
</div>
<?php if (($toggle_offcanvas_pos == "start") && ($logoposition == 1)) : ?>
    <div class="navbar-brand logo-mo">
        <?php
            $LayoutLogo = new FileLayout('wbc_blanco_template.logopos', $tpath.'html/layouts');
            echo $LayoutLogo ->render($displayData);
        ?>
    </div>
    <?php if ($jhtml->countModules('offcanvas-navbar')) :?>
        <div class="offcanvas-navbar">
            <jdoc:include type="modules" name="offcanvas-navbar" style="none" />
        </div>
    <?php endif; ?>
<?php endif;  ?>

<div id="OffcanvasMenu<?php echo $offcanvas_pos; ?>" class="offcanvas-<?php echo $toggle_offcanvas_pos; ?> offcanvas <?php echo $offcanvas_color; ?>" tabindex="-1" aria-labelledby="wbc-bs5-offcanvasLabel">
    <div class="offcanvas-header">
        <p class="h5 offcanvas-title" id="wbc-bs5-offcanvasLabel"><?php echo Text::_('TPL_WBC_MENU'); ?></p>
        <button type="button" class="btn-close btn-close<?php echo $btn_color; ?>" data-bs-dismiss="offcanvas" aria-label="<?php echo Text::_('TPL_WBC_MENU_CLOSE_TXT'); ?>"></button>
    </div>
    <div class="offcanvas-body">

        <?php if ($jhtml->countModules('offcanvas')) :?>
            <div class="mb-3 <?php echo $dClass; ?>">
                <jdoc:include type="modules" name="offcanvas" style="none" />
            </div>
        <?php endif; ?>

        <jdoc:include type="modules" name="navMain"/>

        <?php if ($jhtml->countModules('offcanvas-after')) :?>
            <div class="my-3 <?php echo $dClass; ?>">
                <jdoc:include type="modules" name="offcanvas-after" style="none" />
            </div>
        <?php endif; ?>

    </div>
</div>
