<?php  

$posts_per_page = 20;
$paged = ( get_query_var( 'pg' ) ) ? absint( get_query_var( 'pg' ) ) : 1;

/* Terms */
$post_type = 'faculties';
// $taxonomies[] = array('title'=>'Event Program','taxonomy'=>'programsx','slug'=>'programs');
// $taxonomies[] = array('title'=>'Location','taxonomy'=>'locationsx','slug'=>'locations');
// $taxonomies[] = array('title'=>'Senior/Junior Faculty','taxonomy'=>'typesx','slug'=>'types');

$queried = get_taxonomies_faculties();

$taxonomies = get_faculties_terms();
$all_terms = array();
foreach($taxonomies as $tax) {
	$taxonomy = $tax['taxonomy'];
	$terms = get_terms( array(
	    'taxonomy' => $taxonomy,
	    'post_types'=> array($post_type),
	    'hide_empty' => false,
	) );
	if($terms) {
		$tax['terms'] = $terms;
		$all_terms[] = $tax;
	}
}

/* FACULTIES POST TYPE */

$extra_text = get_field('extra_text');
$args = array(
	'posts_per_page'=> $posts_per_page,
	'post_type'		=> 'faculties',
	'post_status'	=> 'publish',
	'paged'			=> $paged
);

$portrait = get_bloginfo('template_url') . '/images/portrait.png';
if($queried) {
	$faculties = get_filtered_faculties($paged);
} else {
	$faculties = new WP_Query($args);
}

$total_found = ( isset($faculties->total_items_found) ) ? $faculties->total_items_found : 0; 
$message_to_faculty = get_field('message_to_faculty');

?>
<section class="section clear faculties">
	<div id="posts" class="pagecontent wrapper clear">

		<div id="facultiesInner" class="innerwrapper clear">
			<div class="loadcontent clear">
				<?php if ($extra_text) { ?>
				<h2 class="hd2 text-center"><?php echo $extra_text ?></h2>	
				<?php } ?>

				<?php if ($all_terms) { ?>
				<div class="faculty-terms clear">
					<form action="" method="get" id="facultyfilter">
						<div class="flexrow">
							<?php foreach ($all_terms as $tm) { 
								$term_label = $tm['title'];
								$term_tax = $tm['taxonomy'];
								$term_slug = $tm['slug'];
								$categories = $tm['terms'];
								$currentVal = ( isset($_GET[$term_tax]) && $_GET[$term_tax] ) ? $_GET[$term_tax] : '';
								$selected = '';
								?>
								<div class="termbox">
									<label for="<?php echo $term_tax ?>"><?php echo $term_label ?></label>
									<select name="<?php echo $term_tax ?>" class="selectstyle">
										<option value="all">All</option>
										<?php foreach ($categories as $cat) { 
											$catId = $cat->term_id;
											$selectedOpt = ($catId==$currentVal) ? ' selected':''; ?>
											<option value="<?php echo $catId; ?>"<?php echo $selectedOpt ?>><?php echo $cat->name; ?></option>
										<?php } ?>
									</select>
								</div>
							<?php } ?>
						</div>
						<input type="hidden" name="cpt" value="<?php echo $post_type ?>">
						<input type="hidden" name="perpage" value="<?php echo $posts_per_page ?>">
						<div class="input-button text-center"><input type="submit" id="filter" value="Filter" /></div>
					</form>
				</div>
				<?php } ?>

				<div class="faculties-result-wrap clear">
					
					<div class="loadresult clear">
						<?php if ( $faculties->have_posts() ) {  ?>

							<div class="faculties-posts clear">
								<div id="faculties" class="postslist clear">
									<?php if ($total_found) { 
										$item_text = ($total_found>1) ? 'results':'result'; ?>
										<div class="total-found text-center">
											<span class="found"><strong><?php echo $total_found ?></strong> <?php echo $item_text ?></span>
										</div>	
									<?php } ?>

									<div class="posts-inner clear">
										<div class="flexrow">
											<?php while ( $faculties->have_posts() ) : $faculties->the_post();  
												$pid = get_the_ID();
												$headshot = get_field('headshot');
												$stylePic = ($headshot) ? ' style="background-image:url('.$headshot['url'].')"':'';
												$div_class = ($headshot) ? 'haspic':'nopic';
												$name = get_the_title();
												$pos = get_field('position');
												$position = $pos;
												//$position = ($pos) ? truncate($pos,50) : '';
												//$position = ($position) ? shortenText($position,5,',','...') : '';
												$title_att = $name;
												if($position) {
													$title_att .= '<br>' . $pos;
												}
												$confirmed = get_field('confirmed');
												$locations = get_the_terms($pid,'locationsx');
												$programs = get_the_terms($pid,'programsx');
												$isd_locations = '';
												if($locations) {
													$n=1; foreach($locations as $e) {
														$locname = $e->name;
														$split = ($n>1) ? ' / ':'';
														$isd_locations .= $split . 'ISD: ' . $locname;
														$n++;
													}
												}
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
													$position = $program_list;
												}
												?>
												<div class="boxinfo <?php echo $div_class ?>">
													<a data-href="<?php echo get_permalink(); ?>" class="link facultydata" data-postid="<?php echo $pid ?>">
														<span class="inside clear"<?php echo $stylePic ?>>
															<img class="px" src="<?php echo $portrait ?>" alt="" aria-hidden="true" />
															<?php if (!$headshot) { ?>
															<span class="noimage"></span>	
															<?php } ?>
															<span class="caption">
																<span class="blue">
																	<h3 class="name"><?php echo $name ?></h3>
																	<?php if ($position) { ?>
																	<div class="position"><?php echo $position ?></div>	
																	<?php } ?>
																</span>

																<span class="green">
																	<span class="inner">
																		<?php if ($isd_locations) { ?>
																		<span class="isd spancol"><?php echo $isd_locations ?></span>
																		<?php } ?>
																		<?php if ($confirmed) { ?>
																		<span class="confirm spancol">*Confirmed for <?php echo $confirmed ?></span>
																		<?php } ?>
																	</span>
																</span>
															</span>
														</span>
													</a>
												</div>
											<?php endwhile; wp_reset_postdata(); ?>
										</div>
									</div>

									<?php
								    $total_pages = $faculties->max_num_pages;
								    if ($total_pages > 1){ ?>
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
							</div>

						<?php } else { ?>
							
							<h2 class="notfound text-center">Nothing found. <a class="reset resetfilter" href="<?php echo get_permalink(); ?>">Reset</a></h2>

						<?php } ?>
					
					</div>
				</div>
			</div>
		</div>

		<div class="loaderwrap"><div class="loader"><span class="loadtxt">Loading...</span></div></div>

	</div>

</section>

