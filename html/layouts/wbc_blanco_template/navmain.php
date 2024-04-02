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
        <span class="navbar-toggler-icon"></span>
    </button>
    <span class="wbc__offcanvas-toggler-button-txt" aria-hidden="true"><?php echo Text::_('TPL_WBC_MENU'); ?></span>
</div>
<?php if (($toggle_offcanvas_pos == "start") && ($logoposition == 1)) : ?>
    <?php if ($jhtml->countModules('offcanvas-navbar')) :?>
        <div class="offcanvas-navbar">
            <jdoc:include type="modules" name="offcanvas-navbar" style="none" />
        </div>
    <?php endif; ?>
    <div class="navbar-brand logo-mo">
        <?php
            $LayoutLogo = new FileLayout('wbc_blanco_template.logopos', $tpath.'html/layouts');
            echo $LayoutLogo ->render($displayData);
        ?>
    </div>
<?php endif;  ?>

<div id="OffcanvasMenu<?php echo $offcanvas_pos; ?>" class="offcanvas-<?php echo $toggle_offcanvas_pos; ?> offcanvas <?php echo $offcanvas_color; ?>" tabindex="-1" aria-labelledby="wbc-bs5-offcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="wbc-bs5-offcanvasLabel"><?php echo Text::_('TPL_WBC_MENU'); ?></h5>
        <button type="button" class="btn-close btn-close<?php echo $btn_color; ?>" data-bs-dismiss="offcanvas" aria-label="<?php echo Text::_('TPL_WBC_MENU_CLOSE_TXT'); ?>"></button>
    </div>
    <div class="offcanvas-body">

        <?php if ($jhtml->countModules('offcanvas')) :?>
            <div class="mb-3 <?php echo $dClass; ?>">
                <jdoc:include type="modules" name="offcanvas" style="none" />
            </div>
        <?php endif; ?>

        <jdoc:include type="modules" name="navMain"/>

    </div>
</div>
