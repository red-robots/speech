<?php 
/*
 * Template Name: Why ISD
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

				<div class="fulldiv bluepattern">
					<div class="midwrap clear textwrap">
						<?php the_content(); ?>
					</div>
				</div>

				<?php 
				$repeaterItems = get_field('why_isd'); 
				$square = get_bloginfo('template_url') . '/images/square.png';
				?>

				<?php if ($repeaterItems) { ?>
				<section class="whyus-info clear text-image-block">
					<div class="wrapper">
						<div class="flexrow">
							<?php $i=1; foreach ($repeaterItems as $a) { 
							$icon = $a['icon'];
							$title = $a['why_short_description'];
							$description = $a['why_long_description'];
							$divClass = ($i % 2) ? 'odd':'even';
							?>

							<div id="block<?php echo $i; ?>" class="textrow <?php echo $divClass ?>">
								<div class="inside">
									<?php if ($icon) { ?>
									<div class="icondiv">
										<div class="icon" style="background-image:url('<?php echo $icon['url'] ?>');">
											<img src="<?php echo $square ?>" alt="" aria-hidden="true"/>
										</div>
									</div>	
									<?php } ?>
									<?php if ($title) { ?>
									<h3 class="ptitle"><?php echo $title; ?></h3>	
									<?php } ?>

									<?php if ($description) { ?>
									<div class="description"><?php echo $description; ?></div>	
									<?php } ?>
								</div>
							</div>
							
						<?php $i++; } ?>
						</div>
					</div>
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
