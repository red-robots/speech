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
		?>
		<?php if ($row_2_image || $text_row_2) { ?>
		<section class="section-full clear section-why">
			<div class="colwrap">
				<div class="flexrow">
					<div class="imagecol col">
					<?php if ($row_2_image) { ?>
						<img src="<?php echo $row_2_image['url'] ?>" alt="<?php echo $row_2_image['title'] ?>" />
					<?php } ?>
					</div>
					
					<div class="textcol col">
					<?php if ($text_row_2) { ?>
						<?php if ($title_row_2) { ?>
						<div class="section-title">
							<span><?php echo $title_row_2 ?></span>
						</div>
						<?php } ?>
						<div class="text">
							<?php if ($second_title_row_2) { ?>
							<h2 class="t2"><?php echo $second_title_row_2 ?></h2>	
							<?php } ?>
							<?php echo $text_row_2; ?>
						</div>
					<?php } ?>
					</div>
				</div>
			</div>
		</section>
		<?php } ?>

	<?php endwhile;  ?>
</div><!-- #primary -->
<?php
get_footer();
