<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package bellaworks
 */

$banner = get_field('page404image','option');
$page_404_title = get_field('page_404_title','option');
$page_title = ($page_404_title) ? $page_404_title : 'Page Not Found';
$pageErrorMessage = get_field('page_error_message','option');
get_header(); ?>

	<div id="primary" class="content-area error-404 not-found default">
		<main id="main" class="site-main" role="main">


			<header class="page-header">  
				<div class="full-wrapper">
					<h1 class="page-title">
						<span class="title"><?php echo $page_title; ?></span>
						<span class="stripe"><i></i></span></span>
					</h1>
				</div>
			</header>
			
			<div class="entry-content">
				<div class="wrapper">
					<?php if ($pageErrorMessage) { ?>
						<div class="text-center"><?php echo $pageErrorMessage ?></div>
					<?php } else { ?>
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below.', 'bellaworks' ); ?></p>
					<?php } ?>

					<?php get_template_part('template-parts/content','sitemap'); ?>
				</div>
			</div>


		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
