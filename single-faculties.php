<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package bellaworks
 */

get_header(); ?>

	<div id="primary" class="content-area default clear faculty-single">
		<main id="main" class="site-main wrapper" role="main">

		<?php while ( have_posts() ) : the_post();
			$postid = get_the_ID();
			$headshot = get_field('headshot',$postid);
	        $position = get_field('position',$postid);
	        $programs = get_the_terms($postid,'programsx');
	        $program_list = '';
	        if($programs) {
	            $p=1; foreach($programs as $p) {
	                $prog = $p->name;
	                $split = ($p>1) ? ', ':'';
	                $program_list .= $split . $prog;
	                $p++;
	            }
	        }
	        if(empty($position)) {
	            $programs = $program_list;
	        }
	        $current_school = get_field('current_school',$postid);
	        if($current_school) {
	            if($position) {
	                $position .= ' <span class="vt">|</span> ' . $current_school;
	            } else {
	                $position  = $current_school;
	            }
	        }
	        $locations = get_the_terms($postid,'locationsx');
	        $isd_locations = '';
	        if($locations) {
	            $n=1; foreach($locations as $e) {
	                $locname = $e->name;
	                $split = ($n>1) ? ' / ':'';
	                $isd_locations .= $split . 'ISD: ' . $locname;
	                $n++;
	            }
	        }
	        $confirmed = get_field('confirmed',$postid); ?>


			<header class="entry-header">
				<h1 class="pagetitle"><?php the_title(); ?></h1>
				<?php if ($position) { ?>
                <div class="position"><?php echo $position ?></div> 
                <?php } ?>
                <?php if ($isd_locations) { ?>
                <div class="otherinfo"><?php echo $isd_locations ?></div> 
                <?php } ?>
                <?php if ($confirmed) { ?>
                <div class="otherinfo">*Confirmed for <?php echo $confirmed ?></div> 
                <?php } ?>
			</header>

			<div class="entry-content">
				<div class="contentcol-left <?php echo ($headshot) ? 'haspic':'nopic';?>">
                    <?php the_content(); ?>
                </div>

                <?php if ($headshot) { ?>
                <div class="contentcol-right">
                    <img src="<?php echo $headshot['url'] ?>" alt="<?php echo $headshot['title'] ?>">
                </div> 
                <?php } ?>
                            
			</div>
		<?php endwhile; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
