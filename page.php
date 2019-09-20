<?php 
$banner = get_field('banner_image');
$subtitle = get_field('subtitle');
$pagetitle = ($subtitle) ? $subtitle : get_the_title();
get_header(); ?>

	<div id="primary" class="content-area default">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				<header class="page-header">  
					<div class="wrapper">
						<h1 class="page-title">
							<span class="title"><?php echo $pagetitle; ?></span>
							<span class="stripe"><i></span></span>
						</h1>
					</div>
				</header>
				
				<div class="entry-content">
					<div class="wrapper">
						<?php the_content(); ?>
					</div>
				</div>

			<?php endwhile;  ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
