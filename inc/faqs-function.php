<?php
/**
 * FAQ page helpers: query, markup, scripts, and styles.
 */

/**
 * Get FAQs grouped by faqs-category terms.
 *
 * @return array Array of items: [ 'term' => WP_Term, 'faqs' => WP_Post[] ]
 */
function isd_get_faqs_by_category() {
	$taxonomy  = 'faqs-category';
	$post_type = 'faqs';
	$grouped   = array();

	$terms = get_terms( array(
		'taxonomy'   => $taxonomy,
		'hide_empty' => true,
		'orderby'    => 'name',
		'order'      => 'ASC',
	) );

	if ( empty( $terms ) || is_wp_error( $terms ) ) {
		return $grouped;
	}

	foreach ( $terms as $term ) {
		$query = new WP_Query( array(
			'post_type'      => $post_type,
			'posts_per_page' => -1,
			'post_status'    => 'publish',
			'orderby'        => array(
				'menu_order' => 'ASC',
				'title'      => 'ASC',
			),
			'tax_query'      => array(
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'term_id',
					'terms'    => $term->term_id,
				),
			),
		) );

		if ( $query->have_posts() ) {
			$grouped[] = array(
				'term' => $term,
				'faqs' => $query->posts,
			);
		}

		wp_reset_postdata();
	}

	return $grouped;
}

/**
 * Build a safe anchor ID from a term slug.
 *
 * @param string $slug Term slug.
 * @return string
 */
function isd_faq_term_anchor_id( $slug ) {
	return 'faq-category-' . sanitize_title( $slug );
}

/**
 * Render the FAQs page layout (sidebar + category sections).
 */
function isd_render_faqs_page() {
	$categories = isd_get_faqs_by_category();

	if ( empty( $categories ) ) {
		return;
	}
	?>
	<section class="faqs-page-section" aria-label="<?php esc_attr_e( 'Frequently Asked Questions', 'bellaworks' ); ?>">
		<div class="wrapper clear">
			<div class="faqs-layout">
				<aside class="faqs-sidebar">
					<div class="faqs-sidebar-inner">
						<div class="faqs-sidebar-title"><?php esc_html_e( 'Frequently Asked Questions', 'bellaworks' ); ?></div>

						<div class="faqs-sidebar-select-wrap">
							<label class="sr" for="faqs-category-select"><?php esc_html_e( 'Jump to category', 'bellaworks' ); ?></label>
							<select id="faqs-category-select" class="faqs-category-select" aria-label="<?php esc_attr_e( 'FAQ categories', 'bellaworks' ); ?>">
								<option value=""><?php esc_html_e( 'Select a category', 'bellaworks' ); ?></option>
								<?php foreach ( $categories as $group ) :
									$term      = $group['term'];
									$anchor_id = isd_faq_term_anchor_id( $term->slug );
									?>
									<option value="#<?php echo esc_attr( $anchor_id ); ?>">
										<?php echo esc_html( $term->name ); ?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>

						<nav class="faqs-sidebar-nav" aria-label="<?php esc_attr_e( 'FAQ categories', 'bellaworks' ); ?>">
							<ul>
								<?php foreach ( $categories as $group ) :
									$term      = $group['term'];
									$anchor_id = isd_faq_term_anchor_id( $term->slug );
									?>
									<li>
										<a class="faqs-scroll-link" href="#<?php echo esc_attr( $anchor_id ); ?>">
											<?php echo esc_html( $term->name ); ?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</nav>
					</div>
				</aside>

				<div class="faqs-main">
					<?php foreach ( $categories as $group ) :
						$term      = $group['term'];
						$faqs      = $group['faqs'];
						$anchor_id = isd_faq_term_anchor_id( $term->slug );
						?>
						<div class="faq-category" id="<?php echo esc_attr( $anchor_id ); ?>">
							<h2 class="faq-category-title"><?php echo esc_html( $term->name ); ?></h2>

							<div class="faq-list">
								<?php foreach ( $faqs as $faq ) :
									$faq_id    = (int) $faq->ID;
									$question  = get_the_title( $faq_id );
									$answer_id = 'faq-answer-' . $faq_id;
									$answer    = apply_filters( 'the_content', $faq->post_content );
									?>
									<div class="faq-item">
										<button
											type="button"
											class="faq-question"
											aria-expanded="false"
											aria-controls="<?php echo esc_attr( $answer_id ); ?>"
											id="faq-question-<?php echo esc_attr( $faq_id ); ?>"
										>
											<span class="faq-question-text"><?php echo esc_html( $question ); ?></span>
											<span class="faq-chevron" aria-hidden="true">
												<svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M1 1L7 7L13 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
												</svg>
											</span>
										</button>
										<div
											class="faq-answer"
											id="<?php echo esc_attr( $answer_id ); ?>"
											role="region"
											aria-labelledby="faq-question-<?php echo esc_attr( $faq_id ); ?>"
											hidden
										>
											<div class="faq-answer-inner">
												<?php echo $answer; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- filtered via the_content ?>
											</div>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>
	<?php
}

/**
 * Enqueue FAQ page scripts on the FAQs template only.
 */
function isd_faqs_enqueue_assets() {
	if ( ! is_page_template( 'page-faqs.php' ) ) {
		return;
	}

	wp_enqueue_script(
		'isd-faqs',
		get_template_directory_uri() . '/assets/js/faqs.js',
		array( 'jquery' ),
		filemtime( get_template_directory() . '/assets/js/faqs.js' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'isd_faqs_enqueue_assets', 20 );
