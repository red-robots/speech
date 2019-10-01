<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package bellaworks
 */

get_header(); ?>

	<div id="primary" class="content-area error-404 not-found clear">
		<main id="main" class="site-main wrapper" role="main">
			
			<header class="page-header text-center">
				<h1 class="page-title"><?php esc_html_e( 'Sorry... That page can&rsquo;t be found.', 'bellaworks' ); ?></h1>
			</header><!-- .page-header -->
			
			
			<div class="entry-content text-center">
				<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below.', 'bellaworks' ); ?></p>

				<?php get_template_part('template-parts/content','sitemap'); ?>
			</div>


		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
