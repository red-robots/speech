<?php get_header(); ?>
<div id="primary" class="full-content-area clear">
	<?php while ( have_posts() ) : the_post(); ?>

		<?php 
			$intro_text = get_field('intro_text'); 
		?>	
		<?php if ($intro_text) { ?>
		<section class="section-full clear section-intro">
			<div class="midwrap">
				<div class="text text-center"><?php echo $intro_text ?></div>
			</div>
		</section>
		<?php } ?>

		<?php  
			$title_row_2 = get_field('title_row_2'); 
			$second_title_row_2 = get_field('second_title_row_2'); 
			$row_2_image = get_field('row_2_image'); 
			$text_row_2 = get_field('text_row_2'); 
			$button_text_row_2 = get_field('button_text_row_2'); 
			$button_link_row_2 = get_field('button_link_row_2'); 
			$hashtag_row_2 = get_field('hashtag_row_2'); 
			$colBg = ($row_2_image) ? ' style="background-image:url('.$row_2_image['url'].')"':'';
		?>
		<?php if ($row_2_image || $text_row_2) { ?>
		<section class="section-full clear section-why">
			<div class="colwrap">
				<div class="flexrow">
					<div class="imagecol col"<?php echo $colBg ?>>
					<?php if ($row_2_image) { ?>
						<img src="<?php echo $row_2_image['url'] ?>" alt="<?php echo $row_2_image['title'] ?>" />
					<?php } ?>
					</div>
					
					<div class="textcol col">
						<div class="inside">
							<?php if ($title_row_2) { ?>
							<div class="section-title whytitle">
								<span><?php echo $title_row_2 ?><i class="bl"></i></span>
							</div>
							<?php } ?>
												
							<?php if ($text_row_2) { ?>
								<div class="text">
									<?php if ($second_title_row_2) { ?>
									<h2 class="t2"><?php echo $second_title_row_2 ?></h2>	
									<?php } ?>
									<?php echo $text_row_2; ?>

									<?php if ($button_text_row_2 && $button_link_row_2) { ?>
									<div class="buttondiv whyus">
										<a href="<?php echo $button_link_row_2 ?>" class="blueBtn wicon"><?php echo $button_text_row_2 ?><i class="arrow fas fa-chevron-right"></i></a>
									</div>
									<?php } ?>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php } ?>

		<?php if ($hashtag_row_2) { ?>
		<div class="hashtagwrap"><div class="hashtag"><div class="txt"><span><?php echo $hashtag_row_2 ?></span><i class="lines"></i></div></div></div>	
		<?php } ?>

		<?php 
			$threeboxes = get_field('3_boxes'); 
		?>
		<?php if ( $threeboxes ) { ?>
		<section class="section-full clear section-boxes">
			<div class="wrapper">
				<div class="flexrow">
					<?php foreach ($threeboxes as $b) { 
						$box_title = $b['box_title'];
						$box_image = $b['box_image'];
						$box_description = $b['box_description'];
						$box_button_text = $b['box_button_text'];
						$box_button_link = $b['box_button_link'];
						$hasImage = ($box_image) ? 'has-image':'no-image';
						$style = ($box_image) ? ' style="background-image:url('.$box_image['url'].')"':'';
						$pixel = get_bloginfo('template_url').'/images/rectangle.png';
						if ($box_title) { ?>
						<div class="box">
							<div class="inside clear">
								<h3 class="title"><?php echo $box_title ?></h3>
								<div class="boximage <?php echo $hasImage ?>"<?php echo $style ?>>
									<img src="<?php echo $pixel ?>" alt="" aria-hidden="true"/>
								</div>
								<div class="description clear">
									<?php if ($box_description) { ?>
									<div class="desc"><?php echo $box_description ?></div>
									<?php } ?>
									<?php if ($box_button_text && $box_button_link) { ?>
									<div class="btndiv">
										<a href="<?php echo $box_button_link ?>" class="morebtn"><?php echo $box_button_text ?><i class="fas fa-chevron-right"></i></a>
									</div>
									<?php } ?>
								</div>
								
							</div>
						</div>	
						<?php } ?>
					<?php } ?>
				</div>
			</div>
		</section>
		<?php } ?>
	<?php endwhile;  ?>

	<?php  
	/* TESTIMONIALS */
	$args = array (
		'posts_per_page'=> -1,
		'post_type'		=> 'testimonials',
		'post_status'	=> 'publish'
	);
	$testimonials = new WP_Query($args);
    if ( $testimonials->have_posts() ) {  ?> 
	<section class="section-full clear section-testimonials">
		<div class="wrapper">
			<div id="testimony-carousel" class="wrapp clear owl-carousel">
				<?php while ( $testimonials->have_posts() ) : $testimonials->the_post();  
					$photo = get_field('photo');
					$pixel = get_bloginfo('template_url').'/images/square.png';
					$imgbox = ($photo) ? ' style="background-image:url('.$photo['url'].')"':'';
					$hasImage = ($photo) ? 'has-image':'no-image';
					?>
					<div class="item <?php echo $hasImage ?>">
						<div class="flexrow">
							<div class="col right">
								<div class="photo-outer clear">
									<div class="photo"<?php echo $imgbox ?>>
										<img class="px" src="<?php echo $pixel ?>" alt="" aria-hidden="true"/>
									</div>
									<div class="hlines"><div></div></div>
								</div>
							</div>
							<div class="col left">
								<div class="inside">
									<div class="text"><?php the_content();?></div>
									<div class="name">&ndash; <?php the_title(); ?></div>
								</div>
							</div>
						</div>
                    </div>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
		</div>
	</section>
    <?php } ?>

</div><!-- #primary -->
<?php
get_footer();
