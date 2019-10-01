<?php 
/*
 * Template Name: Contact
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
				$section_title = get_field('section_title'); 
				$careers_description = get_field('careers_description'); 
				$careers_details = get_field('careers_details'); 
				$button_text = get_field('button_text'); 
				$button_link = get_field('button_link'); 
				?>
				
				<?php if ($careers_description || $careers_details) { ?>
				<section class="careers-details clear">
					<div class="flexrow text-image-block">

						<?php if ($careers_description) { ?>
						<div class="fcol left">
							<div class="inside">
								<?php if ($section_title) { ?>
								<h2 class="hd2"><?php echo $section_title ?></h2>	
								<?php } ?>
								<?php echo $careers_description ?>
							</div>
						</div>	
						<?php } ?>

						<?php if ($careers_details) { ?>
						<div class="fcol right">
							<div class="inside">
								<?php echo $careers_details ?>
							</div>
						</div>	
						<?php } ?>

					</div>
				</section>
				<?php } ?>

				<?php /* CONTACT FORM */ 
					$form_shortcode = get_field('form_shortcode');
				?>
				<?php if ( $form_shortcode ) { ?>
				<section class="contactform-section">
					<div class="wrapper">
						<div class="contactform text-center"><?php echo $form_shortcode; ?></div>
					</div>
				</section>	
				<?php } ?>

			<?php endwhile;  ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
