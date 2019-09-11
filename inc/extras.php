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


/* GENERATE SITEMAP */
function generate_sitemap($menuNames=null) {
    global $wpdb;
    $pages = $wpdb->get_results( "SELECT ID,post_title,post_parent,post_type FROM {$wpdb->prefix}posts WHERE post_type = 'page' AND post_status='publish' ORDER BY post_title ASC", OBJECT );
    $links = array();

    echo "<pre>";

    $menus = array();
    if($menuNames) {
        $menuArrs = array();
        foreach($menuNames as $mName) {
            if( wp_get_nav_menu_items($mName) ) {
                $menuArrs[] = wp_get_nav_menu_items($mName);
            }
        }

        if($menuArrs) {
            foreach($menuArrs as $mergeItems) {
                foreach($mergeItems as $mi) {
                    $menus[] = $mi;
                }
            }
        }
        
    }

  $site_url = get_site_url();
  $menu_pages = array();
  $mItems = array();

    /* Main Menu */
    if( $menus ) {
        foreach ($menus as $m) {
            $menuId = $m->ID;
            $m_type = $m->type;
            $pagelink = $m->url;
            $menu_parent_id = $m->menu_item_parent;
            $object_id = $m->object_id;
            $parts = explode("#",$pagelink);

            $custom_url_parse = parse_url($pagelink);
            $site_url_parse = parse_url($site_url);
            $external_link = '';

            if( isset($custom_url_parse['host']) && $custom_url_parse['host'] ) {
                $custom_host = $custom_url_parse['host'];
                $site_host = $site_url_parse['host'];
                if($custom_host!=$site_host) {
                    $external_link = $pagelink;
                }
            }

            if($menu_parent_id==0) {

                $mItems[$menuId] = (object) array(
                    'ID'=>$object_id,
                    'post_title'=> $m->title,
                    'post_parent'=> $m->post_parent,
                    'menu_item_parent'=>$menu_parent_id,
                    'menu_type'=>$oType,
                    'url'=>$pagelink,
                    'external_link'=>$external_link
                );

            } else {

                $arg = (object) array(
                    'ID'=>$object_id,
                    'post_title'=> $m->title,
                    'post_parent'=> $m->post_parent,
                    'menu_item_parent'=>$menu_parent_id,
                    'menu_type'=>$oType,
                    'url'=>$pagelink,
                    'external_link'=>$external_link
                );
                
                $mItems[$menu_parent_id]->menu_children[] = $arg;
            }
        }


        //print_r($mItems);

    }

    /* All Publish Pages */
    $pageList = array();
    if($pages) {
        foreach($pages as $p) {
            $postId = $p->ID;
            $parentId = $p->post_parent;
            if($parentId==0) {
                $pageList[$postId] = (object) array(
                    'ID'=>$postId,
                    'post_title'=> $p->post_title,
                    'post_parent'=> $parentId,
                    'menu_item_parent'=>0,
                    'menu_type'=>'page',
                    'url'=>get_permalink($postId),
                    'external_link'=>''
                );
            } else {

                $pg_items = (object) array(
                    'ID'=>$postId,
                    'post_title'=> $p->post_title,
                    'post_parent'=> $parentId,
                    'menu_item_parent'=>0,
                    'menu_type'=>'page',
                    'url'=>get_permalink($postId),
                    'external_link'=>''
                );

                $pageList[$parentId]->menu_children[] = $pg_items;
            }
        }
    }

    /* Merge Menu and Pages that were not included in the Menu */
    if($mItems && $pageList) {
        // foreach($mItems as $mm) {
        //     $menu_postId = $mm->ID;
        //     $menu_children = ( isset($mm->menu_children) && $mm->menu_children ) ? $mm->menu_children : array();
        //     $mcIndex = ($menu_children) ? count($menu_children) : 0;
        //     if( array_key_exists($menu_postId, $pageList) ) {
        //         if( isset($pageList[$menu_postId]->menu_children) ) {
        //             $page_childrens = $pageList[$menu_postId]->menu_children;
        //             $i = $mcIndex;
        //             foreach($page_childrens as $pc) {
        //                 $menu_children[$i] = $pc;
        //                 $i++;
        //             }

        //             /* Sort Children */
        //             $menu_children_sorted = sort_array_items($menu_children, 'post_title', 'ASC','OBJECT');
        //             $mm->menu_children = $menu_children_sorted;

        //         }
        //     } 
        // }

        $menu_page_ids = array();
        foreach($mItems as $mm) {
            $k = $mm->ID;
            $menu_page_ids[$k] = $mm;
        }

        //$pageList = array_values($pageList);
        $newPageList = array();
        $records = array();
        foreach($pageList as $k=>$pi) {
            $postId = $pi->ID;
            $post_title = ($pi->post_title) ? string_cleaner($pi->post_title) : '';
            $pchildren = ( isset($pi->menu_children) && $pi->menu_children ) ? $pi->menu_children : array();
            $mcIndex = ($pchildren) ? count($pchildren) : 0;
            if( array_key_exists($postId, $menu_page_ids) ) {
                if( isset($menu_page_ids[$postId]->menu_children) ) {
                    $page_childrens = $menu_page_ids[$postId]->menu_children;
                    $i = $mcIndex;
                    foreach($page_childrens as $pc) {
                        $pchildren[$i] = $pc;
                        $i++;
                    }

                    /* Sort Children */
                    $menu_children_sorted = sort_array_items($pchildren, 'post_title', 'ASC','OBJECT');
                    $pi->menu_children = $menu_children_sorted;
                }
            } 
            if($post_title!=='sitemap') {
                $newPageList[$postId] = $pi;
                $records[] = $pi;
            }
        }

        $end = count($records);
        $i=$end;
        foreach($menu_page_ids as $mx) {
            $ppId = $mx->ID;
            if( !array_key_exists($ppId, $newPageList) ) {
                $records[$i] = $mx;
                $i++;
            }
        }

        /* Sort All pages */
        $sortedPages = sort_array_items($records, 'post_title', 'ASC','OBJECT');
        print_r($sortedPages);
        
    }

    

}


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
    $string = preg_replace("/[^0-9]/", "", "705-666-8888" );
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
