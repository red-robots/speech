<?php if ( is_front_page() || is_home() ) { 
	$video = get_field('video_mp4_format');  
	$video_thumb = get_field('video_thumbnail');
	$styles = ($video_thumb ) ? ' style="background-image:url('.$video_thumb['url'].')"':'';
	$video_type = '';
	$query = '';
	$v = '';
	if($video) {
		$parts = parse_url($video);
		$base = basename($video);
		if( isset($parts['query']) && $parts['query'] ) {
			parse_str($parts['query'], $query);
			$v = ( isset($query['v']) && $query['v'] ) ? $query['v'] : '';
		}

		if (strpos($video, 'youtube') > 0) {
	        $video_type = 'youtube';
	    } elseif (strpos($video, 'vimeo') > 0) {
	        $video_type = 'vimeo';
	    } else {
	    	$path = pathinfo($video);
	    	$extension = ( isset($path['extension']) && $path['extension'] ) ? strtolower($path['extension']) : '';
	    	if($extension=='mp4') {
	    		$video_type = 'mp4';
	    	}
	    }
	}
	?>
	<?php if ($video) { ?>
	<div class="hero">
		<div class="cover"></div>
		<div class="videowrap"<?php echo $styles ?>>
			<?php if ( $video_type=='vimeo' && is_numeric($base) ) { ?>
				<div style="padding:56.25% 0 0 0;position:relative;"><iframe id="vimeoVideo" src="https://player.vimeo.com/video/<?php echo $base; ?>?autoplay=1&loop=1&title=0&mute=1" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe></div><script src="https://player.vimeo.com/api/player.js"></script>
			<?php } elseif($video_type=='youtube' && $v) { ?>
				<div style="padding:56.25% 0 0 0;position:relative;">
					<iframe type="text/html" src="https://www.youtube.com/embed/<?php echo $v;?>?rel=0&hd=1" frameborder="0" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe>
	  			</div>
			<?php } elseif($video_type=='mp4') { ?>
				<video id="mp4video" width="400" height="300" muted playsinline loop>
					<source src="<?php echo $video; ?>" type="video/mp4">
				</video>
			<?php } ?>
		</div>
	</div>
	<?php } ?>

<?php } else { ?>

	<?php /* SINGLE PROGRAMS PAGE */ ?>
	<?php if ( is_single() && get_post_type() == 'programs' ) { ?>
		
		<?php  
			$featimage = get_field('featimage'); 
			$featimagelarge = get_field('featimagelarge'); 
			$topImage = '';
			$topImgAlt = '';
			if($featimagelarge) {
				$topImage = $featimagelarge['url'];
				$topImgAlt = $featimagelarge['title'];
			} else {
				if($featimage) {
					$topImage = $featimage['url'];
					$topImgAlt = $featimage['title'];
				}
			} 
		?>

		<?php if ($topImage) { ?>
		<div class="subpage-banner clear">
			<div class="imagediv" style="background-image:url('<?php echo $topImage; ?>');"></div>
			<img src="<?php echo $topImage ?>" alt="<?php echo $topImgAlt ?>" class="banner" />
		</div>	
		<?php } ?>

	<?php }  else  { ?>
	
		<?php  
		$banner = get_field('banner_image');
		if( is_404() ) {
			$banner = get_field('page404image','option');
		}

		?>
		<?php if ($banner) { ?>
		<div class="subpage-banner clear">
			<div class="imagediv" style="background-image:url('<?php echo $banner['url']; ?>');"></div>
			<img src="<?php echo $banner['url'] ?>" alt="<?php echo $banner['title'] ?>" class="banner" />
		</div>	
		<?php } ?>

	<?php } ?>



<?php } ?>