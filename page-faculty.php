<?php 
/*
 * Template Name: Faculty
*/

$banner = get_field('banner_image');
$subtitle = get_field('alternate_header_text');
$pagetitle = ($subtitle) ? $subtitle : get_the_title();
get_header(); ?>

	<div id="primary" class="content-area default">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php  
					$subtitle = get_field('title_for_introduction_section');
					$message_to_faculty = get_field('message_to_faculty');
				?>
				<header class="page-header">  
					<div class="wrapper">
						<h1 class="page-title">
							<span class="title"><?php echo $pagetitle; ?></span>
							<span class="stripe"><i></i></span></span>
						</h1>
					</div>
				</header>
				
				<div class="entry-content clear <?php echo ($subtitle) ? 'twocol':'onecol';?>">
					<div class="wrapper clear">
						<div class="innerpad">
							<?php if ($subtitle) { ?>
								<div class="flexrow">
									<div class="stitlecol col">
										<h2><?php echo $subtitle; ?></h2>
									</div>

									<div class="intro col">
										<?php the_content(); ?>
									</div>
								</div>
							<?php } else { ?>
								<div class="intro full">
									<?php the_content(); ?>
								</div>
							<?php } ?>
							<div class="vline"></div>
						</div>

						<?php if ($message_to_faculty) { ?>
						<div class="message-faculty clear">
							<div class="pad"><?php echo $message_to_faculty ?></div>
						</div>	
						<?php } ?>
					</div>
				</div>

			<?php endwhile;  ?>

			<?php  
			/* FACULTIES POST TYPE */
			get_template_part('template-parts/content','faculties');
			?>


		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
