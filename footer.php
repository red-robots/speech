	</div><!-- #content -->

	<?php  
		$email_address = get_field('email_address','option');
		$social_links = get_social_links();
	?>

	<footer id="colophon" class="site-footer clear" role="contentinfo">
		<div class="wrapper text-center">
			<?php if ($email_address) { ?>
			<div class="col left">
				<div class="info"><strong>Email:</strong> <a href="mailto:<?php echo antispambot($email_address,1); ?>"><?php echo antispambot($email_address); ?></a></div>
			</div>
			<?php } ?>

			<?php if ($social_links) { ?>
			<div class="col right social-media">
				<strong>Follow:</strong>
				<?php foreach ($social_links as $type=>$s) { ?>
				<span class="social"><a href="<?php echo $s['link'] ?>" target="_blank"><i class="<?php echo $s['icon'] ?>"></i><em class="sr"><?php echo $type ?></em></a></span>	
				<?php } ?>
			</div>
			<?php } ?>
		</div><!-- wrapper -->
	</footer><!-- #colophon -->
</div><!-- #page -->
<div id="loaderdiv"><div class="loader"><span class="loadtxt">Loading...</span></div></div>

<?php wp_footer(); ?>
<?php if ( is_front_page() || is_home() ) { ?>
<script type="text/javascript">
/* Video Controls */
jQuery(document).ready(function($){
	window.onload = function() {
		// Video
		if( $("#mp4video").length > 0 ) {
			var video = document.getElementById("mp4video");
			document.getElementById('mp4video').play();
		}
	}

	if( $("#vimeoVideo").length > 0 ) {

		var video = document.getElementById('vimeoVideo');

	    //Create a new Vimeo.Player object
	    var player = new Vimeo.Player(video);

	    //When the player is ready, set the volume to 0
	    player.ready().then(function() {
	        player.setVolume(0);
	    });
	}

});
</script>	
<?php } ?>
</body>
</html>
