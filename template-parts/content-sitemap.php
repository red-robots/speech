<?php
$menus = array('Main Menu Left','Main Menu Right','Top Menu');
$sitemap = generate_sitemap($menus);

// 'ID'=>$postId,
// 'post_title'=> $p->post_title,
// 'post_parent'=> $parentId,
// 'menu_item_parent'=>0,
// 'menu_type'=>'page',
// 'url'=>get_permalink($postId),
// 'external_link'=>''
if($sitemap) { ?>
<div class="page-link-list clear">
	<ul class="linklist">
		<?php foreach($sitemap as $a) { 
			$external_link = ( isset($a->external_link) && $a->external_link ) ? $a->external_link:'';
			$target_link = ($external_link) ? ' target="_blank"':'';
			$children  = ( isset($a->menu_children) ) ? $a->menu_children : '';
			$parent_title = $a->post_title;
			$parent_url = ($external_link) ? $external_link : $a->url;
		?>
		<li>
			<a class="parentlink"  href="<?php echo $parent_url; ?>"<?php echo $target_link;?>><?php echo $parent_title;?></a>
			<?php if($children) { ?>
            <ul class="children-links">
                <?php foreach($children as $c) { 
                	$c_external_link = ( isset($c->external_link) && $c->external_link ) ? $c->external_link:'';
					$c_target_link = ($c_external_link) ? ' target="_blank"':'';
					$child_link = ($c_external_link) ? $c_external_link : $c->url;
                ?>
                <li>
                    <a class="childlink" href="<?php echo $child_link; ?>"<?php echo $c_target_link;?>><?php echo $c->post_title; ?></a>
                </li>
                <?php } ?>
            </ul>
            <?php } ?>
		</li>
		<?php } ?>
	</ul>
</div>
<?php } ?>