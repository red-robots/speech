<?php 
/*
 * Template Name: Programs
*/


$banner = get_field('banner_image');
$subtitle = get_field('alternate_header_text');
$pagetitle = ($subtitle) ? $subtitle : get_the_title();
get_header(); ?>

	<div id="primary" class="content-area default">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				<header class="page-header">  
					<div class="full-wrapper">
						<h1 class="page-title">
							<span class="title"><?php echo $pagetitle; ?></span>
							<span class="stripe"><i></i></span></span>
						</h1>
					</div>
				</header>
			
				<?php if ( get_the_content() ) { ?>
				<div class="fulldiv bluepattern">
					<div class="midwrap clear textwrap">
						<?php the_content(); ?>
					</div>
				</div>
				<?php } ?>
			<?php endwhile;  ?>

			<?php  
				/* PROGRAMS LIST */
				$programs = get_field('programs');
			?>
			<?php if ($programs) { ?>
			<section class="programs-section clear">
				<div class="midwrap">
					<?php if ($programs) { ?>
					<div class="program-intro text-center"><?php echo $programs; ?></div>
					<?php } ?>
				</div>

				<?php
				//$posts_per_page = 6;
				$paged = ( get_query_var( 'pg' ) ) ? absint( get_query_var( 'pg' ) ) : 1;
				$args = array(
					'posts_per_page'=> -1,
					'post_type'		=> 'programs',
					'post_status'	=> 'publish',
					//'paged'			=> $paged
				);
				$programs = new WP_Query($args);
				//$blog_entries = get_blog_posts($paged);
				if ( $programs->have_posts() ) {  ?>
				<div class="wrapper programs-listing">
					<div class="flexlist flexrow">
					<?php $j=1; while ( $programs->have_posts() ) : $programs->the_post(); ?>
						<?php 
							$featimage = get_field('featimage'); 
							$overview = get_field('program_overview_copy'); 
							$locations = get_field('locations_dates_info'); 
							$px = get_bloginfo('template_url') . '/images/portrait.png';
							$img = ($featimage) ? ' style="background-image:url('.$featimage['url'].')"':'';
							$locations_dates_info = get_field('locations_dates_info');
						?>
						<div class="block <?php echo ($featimage) ? 'hasimage':'noimage';?>">
							<div class="inside">
								<div class="wrap">
									<div class="featimage fl"<?php echo $img ?>>
										<img src="<?php echo $px ?>" alt="" aria-hidden="true" />
									</div>
									<div class="title fl"><h2><?php the_title(); ?></h2></div>
									<div class="overview fl">
										<?php if ($overview) { ?>
											<div class="text"><?php echo $overview ?></div>
										<?php } ?>

										<?php if ($locations_dates_info) { ?>
											<div class="locations-dates">
												<div class="ltitle">Locations/Dates</div>
												<?php foreach ($locations_dates_info as $d) { 
												$location_option = $d['location'];
												$i_location = ($location_option) ? $location_option->name:'';
												$i_date = $d['date'];
												?>
												<div class="info">
													<?php if ($i_location) { ?>
														<strong>ISD: <?php echo $i_location ?></strong>&nbsp;
													<?php } ?>
													<?php if ($i_date) { ?>
														<span class="date">(<?php echo trim($i_date) ?>)</span>
													<?php } ?>
												</div>	
												<?php } ?>
											</div>
										<?php } ?>
									</div>
									<div class="postlink fl">
										<a href="<?php echo get_permalink(); ?>" class="postBtn">Learn More</a>
									</div>
								</div>
							</div>
						</div>
					<?php $j++; endwhile; wp_reset_postdata(); ?>

						<?php
						$signUpImage = get_field('SignUpImage');
						$signButtonName = get_field('SignButtonName');
						$signButtonLink = get_field('SignButtonLink');  
						$signupbox = ($signUpImage) ? ' style="background-image:url('.$signUpImage['url'].')"':'';
						$signlink = ($signButtonLink) ? parse_external_url($signButtonLink,'internal','external') : '';
						?>

						<?php if ($signButtonName && $signButtonLink) { ?>
							<div class="block signupbox">
								<div class="inside">
									<div class="wrap"<?php echo $signupbox ?>>
										<div class="btndiv"><a href="<?php echo $signButtonLink ?>" class="signUpBtn" target="<?php echo $signlink['target'] ?>"><?php echo $signButtonName ?></a></div>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
				<?php } ?>
			</section>
			<?php } ?>

			
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
