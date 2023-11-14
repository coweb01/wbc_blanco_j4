<?php
    defined('JPATH_BASE') or die;

    use Joomla\CMS\Factory;
    use Joomla\CMS\Layout\FileLayout;
    use Joomla\CMS\HTML\HTMLHelper;
    use Joomla\CMS\Language\Text;
    use Joomla\CMS\Uri\Uri;

    HTMLHelper::_('bootstrap.collapse');

    $variablen = $displayData;
    extract($displayData);

    $app       = Factory::getApplication();
    $tpath     = 'templates/site/wbc_blanco_j4/';

?>

<!-- Static navbar -->
<?php if($offcanvas == 0) :?>
    <?php // dieser Button aktiviert das normale Bootstrap offcanvas ?>
    <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#OffcanvasMenu<?php echo $offcanvas_pos; ?>" aria-controls="#OffcanvasMenu<?php echo $offcanvas_pos; ?>" aria-label="<?php echo Text::_('TPL_WBC_BLANCO_J4_MENU'); ?><">
    <span class="navbar-toggler-icon"></span>
    </button>
<?php
endif
?>
<div id="navMain" class="navigation-main navbar navbar-collapse collapse">
    <?php
    if ($logoposition == 1) : // Logo vor der Navigation ?>
    <div class="navbar-brand logo-mo">
        <?php
        $LayoutLogo = new FileLayout('wbc_blanco_template.logopos', $tpath.'html/layouts');
        echo $LayoutLogo ->render($displayData);
        ?>
    </div>
    <?php endif;  ?>
   
    <jdoc:include type="modules" name="navMain"/>
   
   <?php
    if ($jhtml->countModules('suche')) : // suche in der Navbar
    ?>
    <div class="suche d-print-none wbc-d-xlarge">
        <jdoc:include type="modules" name="suche" style="none" />
    </div>
    <?php
    endif;
    ?>
</div><!--/.nav-collapse -->
