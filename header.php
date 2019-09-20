<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link href="https://fonts.googleapis.com/css?family=Anton|Barlow:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
<script defer src="<?php bloginfo( 'template_url' ); ?>/assets/svg-with-js/js/fontawesome-all.js"></script>


<?php wp_head(); 
$banner = get_field('banner_image'); 
$addClass = ($banner) ? 'hasbanner':'nobanner';
?>
</head>

<body <?php body_class($addClass); ?>>
<div id="page" class="site clear">
	<a class="skip-link sr" href="#content"><?php esc_html_e( 'Skip to content', 'bellaworks' ); ?></a>

	<header id="masthead" class="site-header clear" role="banner">
		<div class="wrapper">
			
			<?php if( get_custom_logo() ) { ?>
	            <div class="logo">
	            	<?php the_custom_logo(); ?>
	            </div>
	        <?php } else { ?>
	            <h1 class="logo">
		            <a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a>
	            </h1>
	        <?php } ?>
			
	        <div class="midwrap">
	        	<div class="sitename">Institute for Speech and Debate</div>
				<nav id="site-navigation" class="main-navigation" role="navigation">
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu','container_class'=>'navwrap','link_before'=>'<span>','link_after'=>'</span>' ) ); ?>
				</nav><!-- #site-navigation -->

				<?php 
				$enrollBtn = get_field('button_name','option'); 
				$enrollLink = get_field('button_link','option'); 
				?>
				<?php if ($enrollBtn && $enrollLink) { ?>
				<div class="arrowbtn">
					<a href="<?php echo $enrollLink ?>" target="_blank" class="enrollbtn">
					<span><?php echo $enrollBtn ?></span></a>
					<span class="btnshadow"></span>
				</div>
				
				<?php } ?>

				<button id="toggleMenu" class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><span class="sr"><?php esc_html_e( 'MENU', 'bellaworks' ); ?></span><span class="bar"></span></button>
	        </div>
	        
	</div><!-- wrapper -->
	</header><!-- #masthead -->

	<?php get_template_part('template-parts/content','hero'); ?>

	<div id="content" class="site-content clear">
