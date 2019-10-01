<?php
/*
 * Template Name: Sitemap
*/

get_header(); ?>

	<div id="primary" class="content-area clear defaultpage">
		<main id="main" class="site-main wrapper" role="main">
			
			<?php while ( have_posts() ) : the_post(); ?> 
			
				<header class="page-header text-center">
					<h1 class="page-title"><?php the_title(); ?></h1>
				</header>
				
				
				<div class="entry-content text-center">
					<?php get_template_part('template-parts/content','sitemap'); ?>
				</div>

			<?php endwhile;  ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
