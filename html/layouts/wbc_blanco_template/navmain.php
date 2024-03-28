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
<?php endif;  ?>
<div class="navbar-button">
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#OffcanvasMenu<?php echo $offcanvas_pos; ?>" aria-controls="OffcanvasMenu<?php echo $offcanvas_pos;?>" aria-label="<?php echo Text::_('TPL_WBC_MENU'); ?>">
    <svg xmlns="http://www.w3.org/2000/svg" class="icon" aria-hidden="true" focusable="false" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
        <path 
            fill="currentColor"
            d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z"
            />
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

        <?php if ($jhtml->countModules('offcanvas-navbar')) :?>
            <div class="mt-3 <?php echo $dClass; ?>">
                <jdoc:include type="modules" name="offcanvas-navbar" style="none" />
            </div>
        <?php endif; ?>
    </div>
</div>
