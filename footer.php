	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="wrapper">
			
		</div><!-- wrapper -->
	</footer><!-- #colophon -->
</div><!-- #page -->

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
