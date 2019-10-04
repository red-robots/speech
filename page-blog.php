<?php 
/*
 * Template Name: Blog
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
			
				<?php if ( get_the_content() ) { ?>
				<div class="fulldiv bluepattern">
					<div class="midwrap clear textwrap">
						<?php the_content(); ?>
					</div>
				</div>
				<?php } ?>

			<?php endwhile;  ?>

			<?php  
			$posts_per_page = 6;
			$paged = ( get_query_var( 'pg' ) ) ? absint( get_query_var( 'pg' ) ) : 1;
			$args = array(
				'posts_per_page'=> $posts_per_page,
				'post_type'		=> 'post',
				'post_status'	=> 'publish',
				'paged'			=> $paged
			);
			$blogs = new WP_Query($args);
			$blog_entries = get_blog_posts($paged);
			if ( $blogs->have_posts() ) {  ?>	
			<section class="blogs-section clear">
				<div class="postresults wrapper">
					<div class="postflex flexrow">
					 	<?php echo $blog_entries; /* see extras.php */ ?>
					</div>
				</div>

				<div class="wrapper">
					<?php
				    $total_pages = $blogs->max_num_pages;
				    $totalpost = $blogs->found_posts; 

				    if ($total_pages > 1){ ?>
				    	<div class="moreposts">
				    		<span class="lastposts hide">No more posts to load.</span>
				    		<a href="#" id="morepageBtn" data-total="<?php echo $totalpost ?>" data-pg="1">More Posts</a>
				    	</div>
				        <div id="pagination" class="pagination clear">
				            <?php
				                $pagination = array(
				                    'base' => @add_query_arg('pg','%#%'),
				                    'format' => '?paged=%#%',
				                    'current' => $paged,
				                    'total' => $total_pages,
				                    'prev_text' => __( '&laquo;', 'red_partners' ),
				                    'next_text' => __( '&raquo;', 'red_partners' ),
				                    'type' => 'plain'
				                );
				                echo paginate_links($pagination);
				            ?>
				        </div>
				        <?php
		    		} ?>
				</div>
				
			</section>
			<?php } ?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
