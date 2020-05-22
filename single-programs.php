<?php

get_header(); ?>

	<div id="primary" class="content-area default">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php  
				$featimage = get_field('featimage'); 
				$featimagelarge = get_field('featimagelarge'); 
				//$overview = get_field('program_overview_copy'); 
				$overview = get_field('program_full_description'); 
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

									<?php 
									$enrollLink = get_field('button_link','option');  
									$ctaButtonName = get_field("ctaButtonName");
									$ctaButtonLink = get_field("ctaButtonLink");
									$displaySignUp = get_field("displaySignUp");
									$hide_signup = ($displaySignUp=='yes') ? true : false;
									$part = ( $ctaButtonName && $ctaButtonLink ) ? parse_external_url($ctaButtonLink) : '';
									$btnTarget = ( isset($part['target']) && $part['target'] ) ? $part['target'] : '_self';
									?>

									<div class="buttondiv programsBtn">
										<?php if ($ctaButtonName && $ctaButtonLink) { ?>
											<a href="<?php echo $ctaButtonLink ?>" target="<?php echo $btnTarget ?>" class="btngreen customCtaBtn"><?php echo $ctaButtonName ?></a>
										<?php } ?>

										<?php if ($hide_signup==false) { ?>
											<?php if ($enrollLink) { $p = parse_external_url($enrollLink); ?>
												<a href="<?php echo $enrollLink ?>" target="<?php echo $p['target'] ?>" class="btngreen">Sign Up Now</a>
											<?php } ?>
										<?php } ?>
									</div>
								</div>
								
							<?php } ?>

							<div class="spcol right">
								<?php echo $overview; ?>
							</div>
						</div>
					</div>
				</div>


				<?php
				$second_row_title = get_field('second_row_title'); 
				$second_row_image = get_field('second_row_image'); 
				$second_row_text = get_field('second_row_text'); 
				$px = get_bloginfo("template_url") . '/images/rectangle.png';
				?>

				<?php if ($second_row_text) { ?>
				<section class="section-sp-row2 clear">
					<div class="flexrow <?php echo ($second_row_image) ? 'twcol':'onecol' ?>">
						<?php if ($second_row_image) { ?>
						<div class="fcol imagecol left" style="background-image:url('<?php echo $second_row_image['url'] ?>')">
							<img src="<?php echo $px ?>" alt="" aria-hidden="true" />
						</div>
						<?php } ?>
						<div class="fcol right">
							<div class="inside">
								<?php if ($second_row_title) { ?>
								<h2 class="hd2"><?php echo $second_row_title ?></h2>	
								<?php } ?>
								<?php echo $second_row_text ?>
							</div>
						</div>
					</div>
				</section>	
				<?php } ?>


				<?php  
				$square = get_bloginfo("template_url") . '/images/square.png';
				$curriculum_director = get_field('curriculum_director');
				$message = get_field('message');
				$headshot = '';
				$authorInfo = '';
				if ($curriculum_director) {
					$faculty_Id = $curriculum_director->ID;
					$faculty_name = $curriculum_director->post_title;
					$headshot = get_field('headshot',$faculty_Id);
					$current_school = get_field('current_school',$faculty_Id);
					$position = get_field('position',$faculty_Id);
					$authorArr = array($faculty_name,$current_school,$position);
					$authorInfo = ($authorArr && array_filter($authorArr)) ? implode(", ",array_filter($authorArr)):'';
				}
				$curriculum_title = get_field("curriculum_section_title");
				$curriculum_section_title = ($curriculum_title) ? $curriculum_title : '';
				?>

				<?php if ($message) { ?>
				<section class="section-curriculum clear">
					<div class="wrapper clear">
						<?php if ($curriculum_section_title) { ?>
						<h2 class="hd2 text-center"><?php echo $curriculum_section_title; ?></h2>
						<?php } ?>
						<div class="director-message clear">
							<div class="flexrow <?php echo ($headshot) ? 'hasimage':'noimage'; ?>">
								<?php if ($headshot) { ?>
									<div class="imagecol">
										<div class="frame clear">
											<div class="photo" style="background-image:url('<?php echo $headshot['url'] ?>')">
												<img src="<?php echo $square ?>" alt="" aria-hidden="true"/>
											</div>
											<div class="hlines"><div></div></div>
										</div>
									</div>
								<?php } ?>

								<div class="textcol">
									<div class="pad">
										<?php echo $message ?>
										<?php if ($authorInfo) { ?>
										<div class="author">&ndash; <?php echo $authorInfo; ?></div>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
				<?php } ?>
				

				<?php
				$schedule_title = get_field('schedule_title');  
				$schedules = get_field('schedule');  
				?>
				
				<?php if ($schedules) { ?>
				<section class="section-schedules clear">
					<div class="flexrow clear <?php echo ($schedule_title) ? 'twocol':'onecol' ?>">
						<?php if ($schedule_title) { ?>
						<div class="titlecol">
							<h2 class="hd2"><span><?php echo $schedule_title ?></span></h2>
						</div>	
						<?php } ?>

						<div class="textcol">
							<div class="tblwrap clear">
								<table class="table table-schedules">
									<tbody>
									<?php foreach ($schedules as $sc) { ?>
										<tr>
											<td class="time"><div class="wrap"><span><?php echo $sc['time'] ?></span></div></td>
											<td class="scheduled-item"><span><?php echo $sc['schedule_item']; ?></span></td>
										</tr>
									<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</section>	
				<?php } ?>

			<?php endwhile;  ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
