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
				if ( $programs->have_posts() ) {  ?>
				<div class="wrapper programs-listing">
					<div class="flexlist flexrow">
					<?php $j=1; while ( $programs->have_posts() ) : $programs->the_post(); ?>
						<?php 
							$featimage = get_field('featimage'); 
							$featimagelarge = get_field('featimagelarge'); 
							$overview = get_field('program_overview_copy'); 
							//$locations = get_field('locations_dates_info'); 
							$img = '';
							$imgClass = 'noimage';
							if($featimage) {
								$imgClass = 'hasimage';
								$img = ' style="background-image:url('.$featimage['url'].')"';
							} else {
								if($featimagelarge) {
									$imgClass = 'hasimage';
									$img = ' style="background-image:url('.$featimagelarge['sizes']['large'].')"';
								}
							}
							$locations_dates_info = get_field('locations_dates_info');
							$px = get_bloginfo('template_url') . '/images/portrait.png';
						?>
						<div class="block <?php echo $imgClass;?>">
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
						$signup = get_field("signupbox");
						$showSignUp = ( isset($signup['showthisbox']) && $signup['showthisbox'] ) ? $signup['showthisbox'] : '';
						$signUpImage = ( isset($signup['SignUpImage']) && $signup['SignUpImage'] ) ? $signup['SignUpImage']['url'] : '';
						$signButtonName = ( isset($signup['SignButtonName']) && $signup['SignButtonName'] ) ? $signup['SignButtonName'] : '';
						$signButtonLink = ( isset($signup['SignButtonLink']) && $signup['SignButtonLink'] ) ? $signup['SignButtonLink'] : '';
						$signlink = ($signButtonLink) ? parse_external_url($signButtonLink,'internal','external') : '';
						$signUpStyle = ($signUpImage) ? ' style="background-image:url('.$signUpImage.')"':'';
						if($showSignUp=='yes') { ?>
							<?php if ($signButtonName && $signButtonLink) { ?>
								<div class="block signupbox">
									<div class="inside">
										<div class="wrap"<?php echo $signUpStyle ?>>
											<div class="btndiv"><a href="<?php echo $signButtonLink ?>" class="signUpBtn" target="<?php echo $signlink['target'] ?>"><?php echo $signButtonName ?></a></div>
										</div>
									</div>
								</div>
							<?php } ?>
						<?php } ?>

					</div>
				</div>
				<?php } ?>
			</section>
			<?php } ?>


			<?php  
				$locations_title = get_field('locations_title'); 
				$locations_text = get_field('locations_text'); 
				$location_info = get_field('locations'); 
				$program_types = get_field('program_types'); 
				$important_notes = get_field('notes'); 
			?>
			
			<section class="location-dates-tuition clear">
				<div class="wrapper clear">
					<div class="fcol left">
						<?php if ($locations_title) { ?>
							<h2 class="title"><?php echo $locations_title ?></h2>	
						<?php } ?>

						<?php if ($locations_text) { ?>
							<div class="text"><?php echo $locations_text ?></div>	
						<?php } ?>

						<?php if ($location_info) { ?>
							<div class="locationsinfo">
								<?php foreach ($location_info as $e) { 
								$loc = $e['location'];
								$locname = ($loc) ? $loc->name : '';
								$date = $e['date'];
								?>
								<div class="info">
									<?php if ($locname) { ?>
									<div class="location"><strong>ISD: <?php echo $locname ?></strong></div>	
									<?php } ?>

									<?php if ($date) { ?>
									<div class="dates"><?php echo $date; ?></div>
									<?php } ?>
								</div>
								<?php }  ?>
							</div>
						<?php } ?>

						<?php if ($program_types) { ?>
						<div class="program-types">
							<div class="flexrow">
							<?php foreach ($program_types as $t) { 
								$t_title = $t['title'];
								$t_note = $t['note'];
								$t_desc = $t['description'];
								?>
								<div class="type">
									<?php if ($t_title) { ?>
									<h3 class="ptitle"><?php echo $t_title ?></h3>
									<?php } ?>
									<?php if ($t_note) { ?>
									<div class="pnote"><?php echo $t_note ?></div>
									<?php } ?>
									<?php if ($t_desc) { ?>
									<div class="pdesc"><?php echo $t_desc ?></div>
									<?php } ?>
								</div>
								<?php } ?>
							</div>
						</div>
						<?php } ?>
					</div>
					
					<div class="fcol right">
						<?php if ($important_notes) { ?>
							<div class="notes ulstyle clear">
								<div class="note-title">Important Notes</div>
								<div class="note-text"><?php echo $important_notes; ?></div>
							</div>
						<?php } ?>
					</div>
				</div>
			</section>


			<?php  
				$arrival_title = get_field('arrival_title'); 
				$arrival_departure = get_field('arrival_departure'); 
			?>
			
			<section class="arrival-departure section clear">
				<div class="wrapper">
					<?php if ($arrival_title) { ?>
						<h2 class="section-title text-center"><?php echo $arrival_title ?></h2>
					<?php } ?>

					<?php if ($arrival_departure) { ?>
					<div class="travel-info clear">
						<div class="flexrow">
						<?php foreach ($arrival_departure as $a) { 
							$locationId = $a->ID;
							$locationName = $a->post_title; 
							$location_logo = get_field('logo',$locationId);
							$flightsInfo = get_field('flights',$locationId);
							
							if($flightsInfo) { ?>
							<div class="infobox">
								<?php if ($location_logo) { ?>
									<div class="isdLogo text-center"><img src="<?php echo $location_logo['url'] ?>" alt="<?php echo $location_logo['title'] ?>"></div>
								<?php } ?>
								<div class="flightInfo">
									<?php echo $flightsInfo ?>
								</div>
							</div>
							<?php } ?>

						<?php } ?>
						</div>
					</div>	
					<?php } ?>
				</div>
			</section>

			<?php 
				$ground_title1 = get_field('ground_title1'); 
				$ground_title2 = get_field('ground_title2'); 
				$ground_text = get_field('ground_text'); 
			?>

			<section class="section ground-transpo">
				<div class="wrapper">
					<?php if ($ground_title1) { ?>
						<h2 class="section-title text-center"><?php echo $ground_title1 ?></h2>
					<?php } ?>

					<?php if ($ground_title2) { ?>
						<div class="subtitle text-center"><?php echo $ground_title2 ?></div>
					<?php } ?>

					<?php if ($ground_text) { ?>
						<div class="textwrap">
							<div class="groundtext ulstyle"><?php echo $ground_text ?></div>
						</div>
					<?php } ?>
				</div>
			</section>
	

			<?php  
			$groundcol1 = get_field('groundcol1'); 
			$groundcol2 = get_field('groundcol2'); 
			?>
			<?php if ($groundcol1 || $groundcol2) { ?>
				<section class="two-column-text">
					<div class="flexrow">
						<?php if ($groundcol1) { ?>
						<div class="fcol text-center left">
							<div class="inside"><?php echo $groundcol1 ?></div>
						</div>	
						<?php } ?>

						<?php if ($groundcol2) { ?>
						<div class="fcol text-center right">
							<div class="inside"><?php echo $groundcol2 ?></div>
						</div>	
						<?php } ?>
					</div>
				</section>
			<?php } ?>


			<?php  
			$financial_aid_title = get_field('financial_aid_title'); 
			$financial_aid_text = get_field('financial_aid_text'); 
			?>

			<?php if ($financial_aid_text) { ?>
			<section class="section financialAid">
				<div class="wrapper">
					<?php if ($financial_aid_title) { ?>
					<h2 class="section-title text-center"><?php echo $financial_aid_title ?></h2>
					<?php } ?>

					<div class="text ulstyle">
						<?php echo $financial_aid_text ?>
					</div>	
				</div>
			</section>
			<?php } ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
