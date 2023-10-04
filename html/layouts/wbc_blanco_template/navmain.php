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

    $app            = Factory::getApplication();
    $tpath   = 'templates/site/wbc_blanco_j4/';

    $data_attr = 'collapse';
    $cssbutton = 'navbar-toggler navbar-toggler-right';

?>

<!-- Static navbar -->
<?php
if($offcanvas == 0) :
?>
    <?php // dieser Button aktiviert das normale Bootstrap offcanvas ?>
    <button class="<?php echo $cssbutton;?>" type="button" data-bs-toggle="<?php echo $data_attr; ?>" data-bs-target="#navMain" aria-controls="navMain" aria-expanded="false" aria-label="<?php echo Text::_('TPL_WBC_BLANCO_J4_MENU'); ?><">
        <span class="navbar-toggler-icon"></span>
    </button>
<?php
endif
?>
<div id="navMain" class="navbar navbar-collapse collapse">

    <?php
    if ($logoposition == 1) : // Logo vor der Navigation
    ?>
    <div class="navbar-brand logo-mo">
        <?php
            $LayoutLogo = new FileLayout('wbc_blanco_template.logopos', $tpath.'html/layouts');

            echo $LayoutLogo ->render($displayData);
        ?>
    </div>
    <?php
    endif;
    ?>

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
