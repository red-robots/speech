<?php
/*
 * Template Name: Sitemap
*/

get_header(); ?>

	<div id="primary" class="content-area default">
		<main id="main" class="site-main" role="main">

			
			<?php while ( have_posts() ) : the_post(); ?> 
			
				<header class="page-header">  
					<div class="full-wrapper">
						<h1 class="page-title">
							<span class="title"><?php the_title(); ?></span>
							<span class="stripe"><i></i></span></span>
						</h1>
					</div>
				</header>
				
				<div class="entry-content text-center">
					<?php get_template_part('template-parts/content','sitemap'); ?>
				</div>

			<?php endwhile;  ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
