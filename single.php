<?php

get_header(); ?>

	<div id="primary" class="content-area default">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				<header class="page-header">  
					<div class="full-wrapper clear">
						<div class="page-title">
							<span class="title">News</span>
							<span class="stripe"><i></i></span></span>
						</div>
					</div>
				</header>
				
				<div class="entry-content singlecontent">
					<div class="wrapper">
						<div class="entry-header text-center">
							<h1 class="entry-title"><?php the_title(); ?></h1>
							<div class="postdate">&ndash; <?php echo get_the_date('F j, Y') ?> &ndash;</div>
						</div>
						<div class="text">
							<?php if ( has_post_thumbnail() ) { ?>
							<div class="feat-image"><?php the_post_thumbnail('large'); ?></div>
							<?php } ?>
							<?php the_content(); ?>
						</div>
					</div>
				</div>

			<?php endwhile;  ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
