<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link href="https://fonts.googleapis.com/css?family=Anton|Barlow:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
<script defer src="<?php bloginfo( 'template_url' ); ?>/assets/svg-with-js/js/fontawesome-all.js"></script>
<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '317213192009597');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=317213192009597&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->

<script>var currentPage = '<?php echo get_permalink()?>';</script>

<?php wp_head(); 
$banner = get_field('banner_image'); 
if( is_404() ) {
	$banner = get_field('page404image','option');
}
$addClass = ($banner) ? 'hasbanner':'nobanner';
?>
</head>

<body <?php body_class($addClass); ?>>
<?php /* Homepage Alert Message */ ?>
<?php
$popup_message = get_field('popup_message','option');  
$popup_btn_name = get_field('popup_btn_name','option');  
$popup_btn_link_option = get_field('popup_btn_link_option','option');  
$link_internal = get_field('link_internal','option');  
$link_external = get_field('link_external','option');  
$enable_popup = get_field('enable_popup','option');  
if($popup_btn_link_option=='external') {
	$target = ' target="_blank"';
	$buttonLink = $link_external;
} else {
	$target = '';
	$buttonLink = $link_internal;
}
?>

<?php if ( is_front_page() ) { ?>
<?php if ($popup_message && $enable_popup=='Yes') { ?>
<div id="homePopUpmessage" style="display:none;">
	<div class="messageAlert">
		<?php echo $popup_message; ?>
		<?php if ($popup_btn_name && $buttonLink) { ?>
		<div id="buttonOption" data-link="<?php echo $buttonLink ?>" data-name="<?php echo $popup_btn_name ?>" data-target="<?php echo $target ?>">
		</div>	
		<?php } ?>
	</div>
</div>	
<?php } ?>
<?php } ?>

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
