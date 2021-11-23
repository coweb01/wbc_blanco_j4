<?php
/**********************************************************
 * Template Blanco
 * Template Joomla 4
 * Kunde:
 * Author: Claudia Oerter / Viviana Menzel
 * Stand: 11 / 2021
 * Version: 1.0
 * copyright Template das webconcept
 **********************************************************/
defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\FileLayout;


include_once JPATH_THEMES . '/' . $this->template . '/includes/magic.php'; // load magic.php
if (!isset($bootstrap_colclass_mobil_sm)) { $bootstrap_colclass_mobil_sm = ''; };
if (!isset($bootstrap_colclass_mobil_xs)) { $bootstrap_colclass_mobil_xs = ''; };

// Template path
$tpath = 'templates/' . $this->template;


// Favicons
$this->addHeadLink($tpath . '/images/favicons/apple-touch-icon.png', 'apple-touch-icon', 'rel', ['sizes' => '180x180']);
$this->addHeadLink($tpath . '/images/favicons/favicon-32x32.png', 'icon', 'rel', ['sizes' => '32x32', 'type' => 'image/png']);
$this->addHeadLink($tpath . '/images/favicons/favicon-16x16.png', 'icon', 'rel', ['sizes' => '16x16', 'type' => 'image/png']);
$this->addHeadLink($tpath . '/images/favicons/safari-pinned-tab.svg', 'mask-icon', 'rel', ['color' => '#41599a']);
$this->addHeadLink($tpath . '/images/favicons/site.webmanifest', 'manifest', 'rel', []);
$this->addHeadLink($tpath . '/images/favicons/favicon.ico', 'shortcut icon', 'rel', []);
$this->setMetaData('msapplication-config', $tpath . '/images/favicons/browserconfig.xml');
$this->setMetaData('theme-color', '#ffffff');

?>

<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<jdoc:include type="metas" />
	<?php include "includes/style.php";?>
	<jdoc:include type="styles" />
	<jdoc:include type="scripts" />

<!-- ***************************************************************************************************** -->
<!-- *****     copyright Template www.das-webconcept.de       2021                                    **** -->
<!-- ***************************************************************************************************** -->
</head>
<body id="top" class="body-01 <?php echo $classbody; ?>">
	<div class="prevent-scrolling">
		<!-- start Accesibility -->
		<h1 class="visually-hidden visually-hidden-focusable">Navigation</h1>
		<ul class="visually-hidden visually-hidden-focusable">
			<li>
				<a href="#wrap-content" class="visually-hidden visually-hidden-focusable">
					<?php echo Text::_('TPL_WBC_BLANCO_J4_SKIP_TO_CONTENT'); ?>
				</a>
			</li>
			<li>
				<a href="#navigation-main" class="visually-hidden visually-hidden-focusable">
					<?php echo Text::_('TPL_WBC_BLANCO_J4_SKIP_TO_MAIN_NAVIGATION'); ?>
				</a>
			</li>
			<?php
			if ($this->countModules('header-top-01')) :
			?>
			<li>
				<a href="#header-top-01" class="visually-hidden visually-hidden-focusable">
					<?php echo Text::_('TPL_WBC_BLANCO_J4_SKIP_TO_TOP_NAVIGATION'); ?>
				</a>
			</li>
			<?php
			endif;
			?>
			<?php
			if ($showleftColumn) :
			?>
			<li>
				<a href="#sidebar-left" class="visually-hidden visually-hidden-focusable">
					<?php echo Text::_('TPL_WBC_BLANCO_J4_JUMP_TO_LEFT_INFORMATION'); ?>
				</a>
			</li>
			<?php
			endif
			?>
			<?php
			if ($showrightColumn) :
			?>
			<li>
				<a href="#sidebar-right" class="visually-hidden visually-hidden-focusable">
					<?php echo Text::_('TPL_WBC_BLANCO_J4_JUMP_TO_RIGHT_INFORMATION'); ?>
				</a>
			</li>
			<?php
			endif;
			?>
			<li>
				<a href="#suche" class="visually-hidden visually-hidden-focusable">
					<?php echo Text::_('TPL_WBC_BLANCO_J4_JUMP_TO_SEARCH'); ?>
				</a>
			</li>
		</ul>
		<!-- end Accesibility -->

		<?php /* wenn Modul grossflaechiges hintergrundbild */?>
		<?php if ($this->countModules('bg-01')) : ?>
			<div id="bg">
				<jdoc:include type="modules" name="bg-01" style="none" />
			</div>
		<?php endif; ?>

		<div id="navbar-phone" class="d-block d-sm-none"></div>

		<div class="wrap-outer">
			<!-- ****************************************************************************************************** -->
			<!-- *     Header                                                                                         * -->
			<!-- ****************************************************************************************************** -->
			<header class="header" >
				<div class="header-top <?php echo ( $fixedheader == 1) ? 'sps' :'';?>" >
					<div class="container<?php echo ( $navbarHeaderWidth == 1) ? '-fluid' : '';?>">

						<?php if ($logoposition == 2) : ?>
							<?php
								$LayoutLogo = new FileLayout('wbc_blanco_template.logopos', $tpath.'/html/layouts');
								echo $LayoutLogo ->render($displayData);
							?>
						<?php endif; ?>

						<?php if ($this->countModules('navMain') && $NavMainPos == 1): ?>
						<nav id="navigation-main">
							<?php
								$LayoutMain = new FileLayout('wbc_blanco_template.navmain', $tpath.'/html/layouts');
								echo $LayoutMain ->render($displayData);
							?>
						</nav>
						<?php endif; ?>
					</div>
				</div><!-- End header-top -->

				<div class="header-middle" role="heading">

					<?php if ($this->countModules('header-top-01-1') || $this->countModules('header-top-01-2')) : ?>
					<div class="container<?php echo ($navbarHeaderWidth == 1) ? '-fluid' : '';?>">
						<div id="header-top-01" class="base-row <?php echo $bootstrap_rowclass; ?> d-none d-sm-block">
							<div class="
								<?php echo $bootstrap_colclass_mobil_xs . $col_xs_header_top01;?>
								<?php echo $bootstrap_colclass_mobil_sm . $col_sm_header_top01;?>
								<?php echo $bootstrap_colclass . $col_md_header_top01; ?>
							">
								<jdoc:include type="modules" name="header-top-01-1" style="none" />
								<jdoc:include type="modules" name="header-top-01-2" style="none" />
							</div>
						</div>
					</div>
					<?php endif; ?>

					<?php if ($this->countModules('navMain') && $NavMainPos == 2): ?>
					<nav id="navigation-main" role="navigation" <?php echo ( $fixedheader == 1) ? 'class="sps"' :'';?> >
						<?php
							$LayoutMain = new FileLayout('wbc_blanco_template.navmain', $tpath.'/html/layouts');
							echo $LayoutMain ->render($displayData);
						?>
					</nav>
					<?php endif; ?>

					<?php if ($this->countModules('header-top-02')): ?>
					<div <?php echo ($pos_search == 'header-top-02') ? $anker_search : ''; ?> class="header-02 container<?php echo ( $navbarHeaderWidth == 1) ? '-fluid' : '';?>">
						<div id="header-top-02" class="base-row <?php echo $bootstrap_rowclass; ?>">
							<?php if ($this->countModules('header-top-02')) : ?>
							<div class="base-col col">
								<jdoc:include type="modules" name="header-top-02" style="none" />
							</div>
							<?php endif; ?>
						</div>
					</div>
					<?php endif; ?>

					<?php if ($logoposition == 3) : ?>
					<div class="header-02" role="heading">
						<div class="base-row <?php echo $bootstrap_rowclass; ?>">
							<?php
								$LayoutLogo = new FileLayout('wbc_blanco_template.logopos', $tpath.'/html/layouts');
								echo $LayoutLogo ->render($displayData);
							?>
						</div>
					</div><!-- End header-02 -->
					<?php endif; ?>

					<?php
					if (($this->params->get('headerimg-select') == 1) && (($this->params->get('headerimg') != -1) || ($this->countModules('headerimg')))) :
					/* wenn headerbild */
					?>
						<?php
							$Layoutheaderimg = new FileLayout('wbc_blanco_template.headerimg', $tpath.'/html/layouts');
							echo $Layoutheaderimg->render($displayData);
						?>
					<?php endif; ?>

					<?php if ($this->countModules('navMain') && $NavMainPos == 3): ?>
					<nav id="navigation-main" <?php echo ($fixedheader == 1 ) ? 'class="sps"' :'';?> >

						<?php if ($fixedheader && $this->countModules('logo-mobil')): ?>
						<div id="logo-mobil" class="navbar-brand hidden">
							<jdoc:include type="modules" name="logo-mobil" style="none" />
						</div>
						<?php endif; ?>
						<div class="container <?php echo $fixedheader ? 'container-fixed ' : '' ;?>">
							<?php
								$LayoutMain = new FileLayout('wbc_blanco_template.navmain', $tpath.'/html/layouts');
								echo $LayoutMain ->render($displayData);
							?>
						</div>
					</nav>
					<?php endif; ?>
				</div>
			</header>
			<!-- ********************  End Header ******************************************************************** -->

			<!-- ****************************************************************************************************** -->
			<!-- *    Main Content                                                                                   * -->
			<!-- ****************************************************************************************************** -->
			<?php if ($headerimg == 0) :?>
			<div class="no-headerimg separator"></div>
			<?php endif;?>

			<?php if ($this->countModules('onepagetop')): ?>
			<jdoc:include type="modules" name="onepagetop" style="onepage"/>
			<?php endif;?>


			<?php if ($this->countModules('breadcrumb')): ?>
			<!-- start Breadcrumbs -->
			<nav id="wrap-breadcrumb" class="d-none d-md-block" aria-label="breadcrumb">
				<div class="container">
					<div class="base-row <?php echo $bootstrap_rowclass; ?>">
						<div class="base-col <?php echo $bootstrap_colclass; ?>12">
							<jdoc:include type="modules" name="breadcrumb" style="none" />
						</div>
					</div>
				</div>
			</nav>
			<!-- end breadcrumbs -->
			<?php endif; ?>

			<div class="container ">
				<div class="main">
					<!-- Begin Container content-->
					<div class="main-content" role="main">
						<div class="base-col <?php echo $bootstrap_rowclass; ?>">

							<?php if($showleftColumn) : ?>

							<!-- ****************************************************************************************************** -->
							<!-- *    Sidebar left                                                                                    * -->
							<!-- ****************************************************************************************************** -->

							<div id="sidebar-left" role="complementary" class="append-sidebar-left base-col col-12 <?php echo $bootstrap_colclass_mobil_sm . $colSidebarLeft_sm . ' ' . $bootstrap_colclass . $colSidebarLeft; ?>" data-set="appendsection">


								<?php if ($this->countModules('nav-sidebar-left')) : ?>
								<div id="toggle-menu-left"><jdoc:include type="modules" name="nav-sidebar-left" style="default" /></div>
								<?php endif; ?>
								<?php echo ($pos_search == 'left-01') ? 'div '. $anker_search .'></div>' : ''; ?>
								<jdoc:include type="modules" name="left-01" style="default" /><!--End left-01-->
								<?php echo ( $pos_search == 'left-02') ? 'div'. $anker_search .'></div>' : ''; ?>
								<jdoc:include type="modules" name="left-02" style="none" /><!--End left-02-->
							</div>
							<!-- ***************************** End Sidebar Left ****************************************************** -->
							<?php endif; ?>

							<div id="wrap-content" class="base-row col-12 <?php echo $bootstrap_colclass_mobil_sm . $cols_sm . ' ' . $bootstrap_colclass . $cols;?>">
								<div class="contentarea <?php echo $classinside;?>">
									<noscript>
									<!-- Anzeige wenn kein JavaScript -->
									<div class="alert alert-danger" role="alert"><?php echo Text::_('TPL_WBC_BLANCO_J4_INFOTXTJS'); ?></div>
									<!-- Ende -->
									</noscript>

									<jdoc:include type="message" />

									<div id="wrap-nav-sidebar-append" class="append-sidebar-before" data-set="appendsectionone"></div>
									<?php
									if ($this->countModules('vorInhalt-01') > 0) : ?>
									<div id="vorInhalt-01">
										<jdoc:include type="modules" name="vorInhalt-01" style="default" />
									</div>
									<?php
									endif;
									?>

									<?php
									if ($this->countModules('vorInhalt-01-col') > 0) : /* wenn Modul mehrspaltig */
										$LayoutModules = new FileLayout('wbc_blanco_template.cardmodules', $tpath.'/html/layouts');

										$ReplacedisplayData = array('Modules' => 'vorInhalt-01-col',
																'Modules_cols' => $vorcontent_cols
																);

										$displayData = array_replace($displayData, $ReplacedisplayData);
										echo $LayoutModules->render($displayData);
									endif;
									?>

									<?php
									if (!$hidecontentwrapper) : // contentbereich + module anzeigen
									?>
									<jdoc:include type="component" />
									<?php
									endif;
									?>

									<?php
									if ($this->countModules('nachInhalt-01-col') > 0) : /* wenn Module mehrspaltig */
										$LayoutModules = new FileLayout('wbc_blanco_template.cardmodules', $tpath.'/html/layouts');

										$ReplacedisplayData = array('Modules' => 'nachInhalt-01-col',
																'Modules_cols' => $aftercontent_cols
																);

										$displayData = array_replace($displayData, $ReplacedisplayData);
										echo $LayoutModules->render($displayData);
									endif;
									?>
								</div> <!-- Contenarea -->
							</div><!--Content -->

							<?php
							if ($showrightColumn) :
							?>
							<!-- ****************************************************************************************************** -->
							<!-- *    Sidebar right                                                                                   * -->
							<!-- ****************************************************************************************************** -->
							<div id="sidebar-right" role="complementary" class="base-col col-12 <?php echo $bootstrap_colclass_mobil_sm . $colSidebarRight_sm . ' ' . $bootstrap_colclass . $colSidebarRight ; ?>">

								<?php
								if ($this->countModules('nav-sidebar-right')) :
								?>
								<div class="append-sidebar-nav" data-set="appendsectionone">
									<nav id="wrap-nav-sidebar-right">
										<a href="#" id="toggle-btn-right" class="wbc-toggle-btn">
											<p class="headline-submenue d-inline visually-hidden"><?php echo Text::_('TPL_WBC_BLANCO_J4_HEADLINE_SUBMENUSIDEBAR'); ?> </p>
											<p class="d-inline wbc-hamburger">
												<span class="line"></span>
												<span class="line"></span>
												<span class="line"></span>
											</p>
										</a>
										<div id="toggle-container-right">
											<jdoc:include type="modules" name="nav-sidebar-right" style="default" />
										</div>
									</nav>
								</div>
								<?php
								endif;
								?>

								<?php echo ( $pos_search == 'right-01') ? 'div'. $anker_search .'></div' : ''; ?>
									<jdoc:include type="modules" name="right-01" style="icon" /><!--End right-01-->
								<?php echo ( $pos_search == 'right-02') ? 'div'. $anker_search .'></div' : ''; ?>
									<jdoc:include type="modules" name="right-02" style="none" /><!--End right-02-->
							</div>
							<!-- ******************************** End Sidebar Right ************************************************** -->
							<?php
							endif;
							?>
						</div><!--End Row-->
					</div><!--End Container main-Content-->

					<div class="clearfix"></div>
					<div class="append-sidebar-bottom" role="complementary" data-set="appendsection"></div>

					<?php
					if ($this->countModules('nachInhalt-02')) :
					?>
					<div id="wrap-nach-content-02">
						<jdoc:include type="modules" name="nachInhalt-02" style="default" />
					</div>
					<?php
					endif;
					?>
				</div> <!-- end main -->
			</div> <!-- end container -->
			<!-- </div> end wrap-main -->

			<div class="clearfix"></div>
			<!-- ****************************  End Main Content ***************************************************** -->

			<?php
			if ($this->countModules('onepagebottom')):
			?>
			<jdoc:include type="modules" name="onepagebottom" style="onepage"/>
			<?php
			endif;
			?>

			<?php
			if ($this->countModules('onepagetoggle')):
			?>
			<section id="toggle01" class="onepage-toggle">
				<div id="toggle-module">
					<jdoc:include type="modules" name="onepagetoggle" style="onepagefullsize"/>
				</div>
			</section>
			<?php
			endif;
			?>

		</div> <!-- wrap outer -->
		<!-- ****************************************************************************************************** -->
		<!-- *    Footer                                                                                         * -->
		<!-- ****************************************************************************************************** -->

		<footer id="wrap-footer" class="wbc-footer">

			<?php if ($this->countModules('footer-top')) : ?>
			<div class="container-fluid">
				<div class="base-row <?php echo $bootstrap_rowclass; ?>">
					<div id="footer-top" class="base-col wbc-footer-top <?php echo $bootstrap_colclass_mobil_sm . '12 ' . $bootstrap_colclass; ?>12">
						<div class="footer-top-bg">
							<jdoc:include type="modules" name="footer-top" style="none" />
						</div>
					</div>
				</div>
			</div><!--Container-->
			<?php endif; ?>

			<?php $modpos = 'footer'; ?>
			<?php if ($this->countModules($modpos)) : ?>
			<div id="footer-middle" class="wbc-footer-middle">
				<div class="container-fluid">
					<?php
						$LayoutFooter = new FileLayout('wbc_blanco_template.footermodules', $tpath.'/html/layouts');
						echo $LayoutFooter ->render($displayData);
					?>
				</div>
			</div>
			<?php endif; ?>

			<?php if ($this->countModules('footer-bottom')): ?>
			<div id="footer-bottom" class="wbc-footer-bottom d-none d-sm-block">
				<div class="container-fluid">
					<div class="base-row <?php echo $bootstrap_rowclass; ?>">
						<div id="footer-modules-bottom" class="base-col <?php echo $bootstrap_colclass_mobil_sm . '12 ' . $bootstrap_colclass; ?>12 ">
							<jdoc:include type="modules" name="footer-bottom" style="none" />
						</div>
					</div>
				</div><!--Container-->
			</div>
			<?php endif; ?>
		</footer>
		<!--End Footer-->
		<jdoc:include type="modules" name="debug" style="none" />

		<div id="gototop">
			<a class="mb-2 gototop shadow-sm d-inline-flex justify-content-center align-items-center" href="#top" >
				<i class="fa fa-chevron-up"></i>
				<span class="visually-hidden"><?php echo Text::_('TPL_WBC_BLANCO_J4_TOP'); ?></span>
			</a>
		</div>

		<div id="gototop-mobil" class="d-flex d-sm-none shadow-sm p-1 fixed-bottom">
			<a class="gototop" href="#top">
				<i class="fa fa-chevron-up"></i>
				<span class="visually-hidden"> <?php echo Text::_('TPL_WBC_BLANCO_J4_TOP'); ?></span>
			</a>
			<jdoc:include type="modules" name="fixed-footer-mobil" style="none" />
		</div>
	</div> <!-- end prevent-scrolling / used offcanvas -->

	<!-- offcanvas menü -->
	<?php
	if ($offcanvas == 1 && $this->countModules('offcanvas')) :
		$LayoutOffcanvas = new FileLayout('wbc_blanco_template.hcoffcanvas', $tpath.'/html/layouts');
		echo $LayoutOffcanvas ->render($displayData);
	endif; ?>
	<!-- end offcanvas -->

	<!-- fixed sidebars -->
	<?php
	if( $this->countModules('sidebar-left-fix') ||
		$this->countModules('sidebar-left-toggle') ||
		$toggleleft) :
	?>
		<?php $LayoutSidebar = new FileLayout('wbc_blanco_template.fixedsidebars', $tpath.'/html/layouts');

		$ReplacedisplayData = array( 'side' => 'left',
									 'toggle' => $toggleleft,
									 'pos' => '3'
									);
		$displayData = array_replace( $displayData, $ReplacedisplayData);
		echo $LayoutSidebar ->render($displayData); ?>

	<?php
	endif;
	?>

	<?php
	if( $this->countModules('sidebar-right-fix') ||
		$this->countModules('sidebar-right-toggle') ||
		$toggleright) :
	?>
		<?php $LayoutSidebar = new FileLayout('wbc_blanco_template.fixedsidebars', $tpath.'/html/layouts');

		$ReplacedisplayData = array( 'side' => 'right',
									 'toggle' => $toggleright,
									 'pos' => '4'
									);
		$displayData = array_replace( $displayData, $ReplacedisplayData);
		echo $LayoutSidebar ->render($displayData); ?>
	<?php
	endif;
	?>
	<!-- end fixed sidebars -->

	<?php include_once JPATH_THEMES . '/' . $this->template . '/includes/magictwo.php'; // load scripts ?>
</body>
</html>
