<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package bellaworks
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function bellaworks_body_classes( $classes ) {
    // Adds a class of group-blog to blogs with more than 1 published author.
    if ( is_multi_author() ) {
        $classes[] = 'group-blog';
    }

    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    if ( is_front_page() || is_home() ) {
        $classes[] = 'homepage';
    } else {
        $classes[] = 'subpage';
    }

    $browsers = ['is_iphone', 'is_chrome', 'is_safari', 'is_NS4', 'is_opera', 'is_macIE', 'is_winIE', 'is_gecko', 'is_lynx', 'is_IE', 'is_edge'];
    $classes[] = join(' ', array_filter($browsers, function ($browser) {
        return $GLOBALS[$browser];
    }));

    return $classes;
}
add_filter( 'body_class', 'bellaworks_body_classes' );

if( function_exists('acf_add_options_page') ) {
    acf_add_options_page();
}


function add_query_vars_filter( $vars ) {
    $vars[] = "pg";
    return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );



function get_menu_object( $menuId, $menus ) {
    $obj = '';
    if( $menus ) {
        foreach( $menus as $m ) {
            $id = $m->ID;
            if( $menuId==$id ) {
                $obj = $m;
                break;
            }
        }
    }
    return $obj;
}


function title_formatter($string) {
    if($string) {
        $parts = explode(' ',trim($string));
        $count_str = count($parts);
        $offset = ceil($count_str/2);
        $row_title = '<span>';
        $i=1; foreach($parts as $a) {
            $comma = ($i>1) ? ' ' : '';
            if($i<=$offset) {
                $row_title .= $comma . $a;
                if($i==$offset) {
                    $row_title .= '</span>';
                }
            } else {
                $row_title .= $comma . $a;
            }
            $i++;
        }
        $row_title = trim($row_title);
        $row_title = preg_replace('/\s+/', ' ', $row_title);
    } else {
        $row_title = '';
    }
    return $row_title;
}


function shortenText($string, $limit, $break=".", $pad="...") {
  // return with no change if string is shorter than $limit
  if(strlen($string) <= $limit) return $string;

  // is $break present between $limit and the end of the string?
  if(false !== ($breakpoint = strpos($string, $break, $limit))) {
    if($breakpoint < strlen($string) - 1) {
      $string = substr($string, 0, $breakpoint) . $pad;
    }
  }

  return $string;
}

function truncate($text, $chars = 25) {
    if (strlen($text) <= $chars) {
        return $text;
    }
    $text = $text." ";
    $text = substr($text,0,$chars);
    $text = substr($text,0,strrpos($text,' '));
    $text = $text."...";
    return $text;
}

/* Fixed Gravity Form Conflict Js */
add_filter("gform_init_scripts_footer", "init_scripts");
function init_scripts() {
    return true;
}

function get_page_id_by_template($fileName) {
    $page_id = 0;
    if($fileName) {
        $pages = get_pages(array(
            'post_type' => 'page',
            'meta_key' => '_wp_page_template',
            'meta_value' => $fileName.'.php'
        ));

        if($pages) {
            $row = $pages[0];
            $page_id = $row->ID;
        }
    }
    return $page_id;
}

function string_cleaner($str) {
    if($str) {
        $str = str_replace(' ', '', $str); 
        $str = preg_replace('/\s+/', '', $str);
        $str = preg_replace('/[^A-Za-z0-9\-]/', '', $str);
        $str = strtolower($str);
        $str = trim($str);
        return $str;
    }
}


function sort_array_items($array, $key, $sort='DESC',$type='ARRAY') {
    $sorter=array();
    $ret=array();
    $items = array();


    foreach($array as $k=>$v) {
        if($type=='ARRAY') {
            $str = string_cleaner($v[$key]);
        } else {
            $str = string_cleaner($v->$key);
        }
        
        $index = $str.'_'.$k;
        $sorter[$index] = $v;
    }

    if($sort=='DESC') {
        krsort($sorter);
    } else {
        ksort($sorter);
    }

    foreach($sorter as $key=>$val) {
        $parts = explode('_',$key);
        $n = $parts[1];
        $items[$n] = $val;
    }
    return $items;
}


function format_phone_number($string) {
    if(empty($string)) return '';
    $append = '';
    if (strpos($string, '+') !== false) {
        $append = '+';
    }
    $string = preg_replace("/[^0-9]/", "", $string );
    $string = preg_replace('/\s+/', '', $string);
    return $append.$string;
}

function get_instagram_setup() {
    global $wpdb;
    $result = $wpdb->get_row( "SELECT option_value FROM $wpdb->options WHERE option_name = 'sb_instagram_settings'" );
    if($result) {
        $option = ($result->option_value) ? @unserialize($result->option_value) : false;
    } else {
        $option = '';
    }
    return $option;
}

function extract_emails_from($string){
  preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $string, $matches);
  return $matches[0];
}

function email_obfuscator($string) {
    $output = '';
    if($string) {
        $emails_matched = ($string) ? extract_emails_from($string) : '';
        if($emails_matched) {
            foreach($emails_matched as $em) {
                $encrypted = antispambot($em,1);
                $replace = 'mailto:'.$em;
                $new_mailto = 'mailto:'.$encrypted;
                $string = str_replace($replace, $new_mailto, $string);
                $rep2 = $em.'</a>';
                $new2 = antispambot($em).'</a>';
                $string = str_replace($rep2, $new2, $string);
            }
        }
        $output = apply_filters('the_content',$string);
    }
    return $output;
}

function get_social_links() {
    $social_types = array(
        'facebook'=>'fab fa-facebook-square',
        'twitter'=>'fab fa-twitter-square',
        'instagram'=>'fab fa-instagram',
        'snapchat'=>'fab fa-snapchat-ghost'
    );
    $social = array();
    foreach($social_types as $k=>$icon) {
        $value = get_field($k,'option');
        if($value) {
            $social[$k] = array('link'=>$value,'icon'=>$icon);
        }
    }
    return $social;
}

/* Add Confirmed years dynamically */

function acf_some_field( $field ) {
    //Change this to whatever data you are using.
    $current_year = date('Y');
    $max = 10;
    $years = array();
    for($i=0; $i<=$max; $i++) {
        $yr = $current_year + $i;
        $years[$yr] = $yr;
    }

    $field['choices'] = array();

    //Loop through whatever data you are using, and assign a key/value
    foreach($years as $field_key => $field_value) {
        $field['choices'][$field_key] = $field_value;
    }
    return $field;
}
add_filter('acf/load_field/name=confirmed', 'acf_some_field');


function get_faculties_terms() {
    $taxonomies[] = array('title'=>'Event Program','taxonomy'=>'programsx','slug'=>'programs');
    $taxonomies[] = array('title'=>'Location','taxonomy'=>'locationsx','slug'=>'locations');
    $taxonomies[] = array('title'=>'Senior/Junior Faculty','taxonomy'=>'typesx','slug'=>'types');
    return $taxonomies;
}

function get_taxonomies_faculties() {
    $taxonomies = get_faculties_terms();
    $taxlist = array();
    $post_type = ( isset($_GET['cpt']) && $_GET['cpt'] ) ? $_GET['cpt'] : '';
    foreach($taxonomies as $tax) {
        $taxonomy = $tax['taxonomy'];
        if( isset($_GET[$taxonomy]) && $_GET[$taxonomy] ) {
            $term_id = ( is_numeric($_GET[$taxonomy]) ) ? $_GET[$taxonomy] : '';
            $queries[$taxonomy] = $_GET[$taxonomy];
            if($term_id) {
                $taxlist[] = array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'term_id',
                    'terms'    => array($term_id),
                );
            }
            
        }
    }
    return $taxlist;
}

function get_filtered_faculties($paged=1) {
    global $wpdb;
    $result = '';
    $taxonomies = get_faculties_terms();
    $queries = array();
    $post_type = ( isset($_GET['cpt']) && $_GET['cpt'] ) ? $_GET['cpt'] : '';
    $posts_per_page = ( isset($_GET['perpage']) && $_GET['perpage'] ) ? $_GET['perpage'] : 20;
    $taxlist = get_taxonomies_faculties();

    if($post_type && $taxlist) {
        // $args = array(
        //     'posts_per_page'=> $posts_per_page,
        //     'post_type'     => $post_type,
        //     'tax_query'     => array($taxlist),
        //     'post_status'   => 'publish',
        //     'orderby'       => 'date',
        //     'order'         => 'DESC',
        //     'suppress_filters' => true,
        //     'paged'         => $paged
        // );

        $args = array(
            'posts_per_page'=> $posts_per_page,
            'post_type'     => $post_type,
            'tax_query'     => array($taxlist),
            'post_status'   => 'publish',
            'suppress_filters' => true,
            'paged'         => $paged,
            'orderby'       => 'title',       
            'order'         => 'ASC'
        );

        $args2 = array(
            'posts_per_page'=> -1,
            'post_type'     => $post_type,
            'tax_query'     => array($taxlist),
            'post_status'   => 'publish'
        );

        $posts = get_posts($args2);
        $total = ($posts) ? count($posts) : 0;
        $result = new WP_Query($args);
        if( $result->have_posts() ) {
            $result->total_items_found = $total;
        }
    }

    return $result;
}

/* Get Faculty Details via Ajax */
add_action( 'wp_ajax_nopriv_get_the_page_content', 'get_the_page_content' );
add_action( 'wp_ajax_get_the_page_content', 'get_the_page_content' );
function get_the_page_content() {
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        $postid = ($_POST['postid']) ? $_POST['postid'] : '';
        $html = ajax_get_page_content($postid);
        $response['content'] = $html;
        echo json_encode($response);
    }
    else {
        header("Location: ".$_SERVER["HTTP_REFERER"]);
    }
    die();
}


function ajax_get_page_content($postid=null) {
    global $wpdb;
    if(empty($postid)) return '';
    $content = '';
    $result = $wpdb->get_row( "SELECT * FROM {$wpdb->prefix}posts WHERE ID=".$postid." AND post_status = 'publish'", OBJECT );
    if($result) { 
        ob_start(); 
        $page_title = $result->post_title;
        $content = $result->post_content;
        $page_content = apply_filters('the_content', $content);
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

        if(empty($position)) {
            $position = $program_list;
        }
        $confirmed = get_field('confirmed',$postid);
        ?>

        <div id="detailsPage" class="popupwrapper animated">
            <div class="maincontent clear animated fadeIn">
                <div class="popclose"><div class="mid"><a href="#" id="closepopup"><span>x</span></a></div></div>
                <div class="inner clear">
                    <div class="textwrap clear ajax_contentdiv">
                        <span id="closeplacement" style="visibility:hidden;"><i>x</i></span>
                        <div class="textcontent full">
                            <header class="headertitle">
                                <h1 class="ptitle"><?php echo $page_title;?></h1>
                                <div class="programinfo">
                                    <?php if ($position) { ?>
                                    <div class="position"><?php echo $position ?></div> 
                                    <?php } ?>
                                    <?php if ($isd_locations) { ?>
                                    <div class="otherinfo"><?php echo $isd_locations ?></div> 
                                    <?php } ?>
                                    <?php if ($confirmed) { ?>
                                    <div class="otherinfo">*Confirmed for <?php echo $confirmed ?></div> 
                                    <?php } ?>
                                </div>

                            </header>
                            <div class="content-left <?php echo ($headshot) ? 'haspic':'nopic';?>">
                                <?php echo $page_content;?>

                                <?php if( current_user_can('edit_others_pages') ) {  ?>
                                    <p class="admin-edit"><a class="post-edit" href="<?php echo get_edit_post_link($postid); ?>">Edit</a></p>
                                <?php } ?>
                            </div>

                            <?php if ($headshot) { ?>
                            <div class="content-right">
                                <img src="<?php echo $headshot['url'] ?>" alt="<?php echo $headshot['title'] ?>">
                            </div> 
                            <?php } ?>

                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php 
        $content = ob_get_contents();
        ob_end_clean();
    }
    return $content;
}


function parse_external_url( $url = '', $internal_class = 'internal-link', $external_class = 'external-link') {

    $url = trim($url);

    // Abort if parameter URL is empty
    if( empty($url) ) {
        return false;
    }

    //$home_url = parse_url( $_SERVER['HTTP_HOST'] );     
    $home_url = parse_url( home_url() );  // Works for WordPress

    $target = '_self';
    $class = $internal_class;

    if( $url!='#' ) {
        if (filter_var($url, FILTER_VALIDATE_URL)) {

            $link_url = parse_url( $url );

            // Decide on target
            if( empty($link_url['host']) ) {
                // Is an internal link
                $target = '_self';
                $class = $internal_class;

            } elseif( $link_url['host'] == $home_url['host'] ) {
                // Is an internal link
                $target = '_self';
                $class = $internal_class;

            } else {
                // Is an external link
                $target = '_blank';
                $class = $external_class;
            }
        } 
    }

    // Return array
    $output = array(
        'class'     => $class,
        'target'    => $target,
        'url'       => $url
    );

    return $output;
}

function inline_cta_button( $atts ) {
    
    $atts = shortcode_atts( array(
        'post' => '-1',
    ), $atts, 'call-to-action-button' );

    $postid = $atts['post'];

    $button_text = get_field('button_text',$postid); 
    $button_link = get_field('button_link',$postid); 
    $cta_button = '';
    if($button_text && $button_link) {
        $parts = parse_external_url($button_link,'internal','external');
        $cta_button = '<a href="'.$parts['url'].'" target="'.$parts['target'].'" class="ctaBtnGreen full '.$parts['class'].'">'.$button_text.'</a>';
    }
    return $cta_button;
}
add_shortcode( 'call-to-action-button', 'inline_cta_button' );


/* Get Next Posts via Ajax */
add_action( 'wp_ajax_nopriv_get_next_posts', 'get_next_posts' );
add_action( 'wp_ajax_get_next_posts', 'get_next_posts' );
function get_next_posts() {
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        $paged = ($_POST['pg']) ? $_POST['pg'] : 0;
        $posttype = ($_POST['posttype']) ? $_POST['posttype'] : 'post';
        $paged = $paged + 1;
        $html = get_blog_posts($paged,$posttype);
        $response['content'] = $html;
        $response['next_page'] = $paged;
        echo json_encode($response);
    }
    else {
        header("Location: ".$_SERVER["HTTP_REFERER"]);
    }
    die();
}


function get_blog_posts($paged,$post_type='post') {
    $posts_per_page = 6;
    $content = '';
    $args = array(
        'posts_per_page'=> $posts_per_page,
        'post_type'     => $post_type,
        'post_status'   => 'publish',
        'paged'         => $paged
    );
    $blogs = new WP_Query($args);
    if ( $blogs->have_posts() ) { ob_start(); ?>

        <?php if ($post_type=='post') { /* BLOGS */ ?>
    
            <?php $j=1; while ( $blogs->have_posts() ) : $blogs->the_post(); 
                $content = get_the_content();
                $content = ($content) ? strip_tags($content) : '';
                $excerpt = ($content) ? shortenText($content,200,' ',' [&hellip;]') : '';
                $thumbnail_id = get_post_thumbnail_id( get_the_ID() );
                $featImage = wp_get_attachment_image_src($thumbnail_id,'large');
                $pix = get_bloginfo('template_url') . '/images/rectangle.png';
                ?>
                <article id="paged<?php echo $paged.'-'.$j ?>" data-pagegroup="<?php echo $paged ?>" class="post-item">
                    <div class="inside flexrow">
                        <?php if ($featImage) { ?>
                        <div class="imagecol" style="background-image:url('<?php echo $featImage[0] ?>')">
                            <img src="<?php echo $pix ?>" alt="" aria-hidden="true" />
                        </div>
                        <?php } ?>
                        <div class="textcol <?php echo ($featImage) ? 'hasimage':'noimage';?>">
                            <div class="pad">
                                <h3 class="title"><?php the_title(); ?></h3>
                                <div class="text"><?php echo $excerpt ?></div>
                                <div class="btnwrap">
                                    <div class="btnpad">
                                        <a href="<?php echo get_permalink(); ?>">Read Post <i class="arrow fas fa-chevron-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            <?php $j++; endwhile; wp_reset_postdata(); ?>

        <?php } ?>

    <?php
     $content = ob_get_contents();
     ob_end_clean();
    }
    return $content;
}

function check_taxonomy($slug,$taxonomy) {
    global $wpdb;
    $result = $wpdb->get_row( "SELECT tax.term_id, terms.name, terms.slug, tax.taxonomy FROM $wpdb->term_taxonomy tax, $wpdb->terms terms WHERE tax.term_id=terms.term_id AND tax.taxonomy='".$taxonomy."' AND terms.slug='".$slug."'", OBJECT );
    return ($result) ? $result : '';
}

/* Add Location Taxonomy automatically when adding a location custom post */
add_action('save_post','custom_save_post_callback');
function custom_save_post_callback($post_id){
    global $post;
    if ($post->post_type == 'locations'){
        $obj = get_post($post_id);
        if($obj) {
            $taxonomy = 'locationsx';
            $term = $obj->post_title;
            //$slug = $obj->post_name;
            $slug = sanitize_title($term );
            $status = $obj->post_status;
            $res = check_taxonomy($slug,$taxonomy);
            if(empty($res)) {
                wp_insert_term( $term, $taxonomy, array(
                    'description' => '',
                    'parent'      => 0,
                    'slug'        => $slug,
                ) );
            }
        }
        return;
    }
}

