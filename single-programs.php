<?php

get_header(); ?>

	<div id="primary" class="content-area default">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php  
				$featimage = get_field('featimage'); 
				$featimagelarge = get_field('featimagelarge'); 
				$overview = get_field('program_overview_copy'); 
				$tuition = get_field('tuition'); 
				$locations_dates_info = get_field('locations_dates_info');
				$px = get_bloginfo('template_url') . '/images/portrait.png';
				$img = ($featimage) ? ' style="background-image:url('.$featimage['url'].')"':'';
				$topImage = '';
				$topImgAlt = '';
				if($featimagelarge) {
					$topImage = $featimagelarge['url'];
					$topImgAlt = $featimagelarge['title'];
				} else {
					if($featimage) {
						$topImage = $featimage['url'];
						$topImgAlt = $featimage['title'];
					}
				} 
				?>
				<header class="page-header">  
					<div class="full-wrapper">
						<h1 class="page-title">
							<span class="title"><?php the_title(); ?></span>
							<span class="stripe"><i></i></span></span>
						</h1>
					</div>
				</header>
				
				<div class="fulldiv bluepattern singleprogramtext">
					<div class="wrapper">
						<div class="flexrow <?php echo ($locations || $tuition) ? 'colbox':'nocol'; ?>">

							<?php if ($locations || $tuition) { ?>

								<div class="spcol left">
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

									<?php if($tuition) { ?>
									<div class="tuitionbox">
										<div class="ltitle">Tuition</div>
										<?php foreach ($tuition as $t) { 
											$program_title = $t['program_title'];
											$program_notes = $t['program_notes'];
											$tuition_cost = $t['tuition_cost'];
											?>
											<div class="tuition-info">
												<h3 class="type"><?php echo $program_title ?></h3>
												<?php if ($program_notes) { ?>
												<div class="notes"><?php echo $program_notes ?></div>	
												<?php } ?>

												<?php if ($tuition_cost) { ?>
												<div class="cost">
													<table class="table tuitionCost">
														<tbody>
														<?php foreach ($tuition_cost as $c) { 
															$length = $c['length_of_program'];
															$cost = $c['cost_of_program']; ?>
															<tr>
																<td class="tdlength">
																	<div class="tblflex">
																		<div class="wk"><span><?php echo $length; ?></span></div>
																		<div class="hr"></div>
																	</div>
																</td>
																<td class="tdcost"><div><?php echo $cost; ?></div></td>
															</tr>
														<?php } ?>
														</tbody>
													</table>
												</div>	
												<?php } ?>
											</div>
										<?php } ?>
									</div>
									<?php } ?>

								</div>
								
							<?php } ?>

							<div class="spcol right">
								<?php echo $overview; ?>
							</div>
						</div>
					</div>
				</div>

			<?php endwhile;  ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
