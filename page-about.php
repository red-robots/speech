<?php 
/*
 * Template Name: About Us
*/


$banner = get_field('banner_image');
$subtitle = get_field('alternate_header_text');
$pagetitle = ($subtitle) ? $subtitle : get_the_title();
get_header(); ?>

	<div id="primary" class="content-area default">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				<header class="page-header">  
					<div class="wrapper">
						<h1 class="page-title">
							<span class="title"><?php echo $pagetitle; ?></span>
							<span class="stripe"><i></i></span></span>
						</h1>
					</div>
				</header>

				<div class="fulldiv bluepattern">
					<div class="midwrap clear textwrap">
						<?php the_content(); ?>
					</div>
				</div>

				<?php 
				$aboutInfo = get_field('about_isd'); 
				?>

				<?php if ($aboutInfo) { ?>
				<section class="about-info clear text-image-block">
					<?php $i=1; foreach ($aboutInfo as $a) { 
					$image = $a['section_image'];
					$title = $a['section_title'];
					$description = $a['section_description']; 
					$square = get_bloginfo('template_url') . '/images/square.png';
					$rectangle = get_bloginfo('template_url') . '/images/rectangle.png';
					$styleImg = ($image) ? ' style="background-image:url('.$image['url'].')"':'';
					$divClass = ($i % 2) ? 'odd':'even';
					?>

					<div class="textrow <?php echo $divClass ?>">
						<div class="flexrow">
							<div class="fcol textcol">
								<div class="inside">
									<?php if ($title) { ?>
										<h2 class="hd2"><?php echo $title ?></h2>
									<?php } ?>
									<?php echo $description ?>
								</div>
							</div>
							<div class="fcol imagecol"<?php echo $styleImg ?>>
								<?php if ($image) { ?>
								<img src="<?php echo $rectangle ?>" alt="" aria-hidden="true" />	
								<?php } ?>
							</div>
						</div>
					</div>
						
					<?php $i++; } ?>
				</section>
				<?php } ?>


				<?php 
				$bottom_banner_text = get_field('bottom_banner_text'); 
				$bottom_button_text = get_field('bottom_banner_button_text'); 
				$bottom_button_link = get_field('bottom_banner_button_link'); 
				$bottomLink = '';
				if($bottom_button_link) {
					$bottomLink = parse_external_url($bottom_button_link,'internal','external');
				}
				?>

				<?php if ($bottom_banner_text) { ?>
				<section class="bottom-section green clear">
					<div class="midwrap text-center">
						<div class="text"><?php echo $bottom_banner_text ?></div>
						<?php if ( $bottom_button_text && $bottomLink ) { ?>
						<div class="buttondiv">
							<a href="<?php echo $bottomLink['url'] ?>" target="<?php echo $bottomLink['target'] ?>" class="btnWhite <?php echo $bottomLink['class'] ?>"><?php echo $bottom_button_text ?></a>
						</div>	
						<?php } ?>
					</div>
				</section>
				<?php } ?>

			<?php endwhile;  ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
