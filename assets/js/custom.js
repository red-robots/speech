/**
 *	Custom jQuery Scripts
 *	
 *	Developed by: Austin Crane	
 *	Designed by: Austin Crane
 */

jQuery(document).ready(function ($) {
	
	/*
	*
	*	Flexslider
	*
	------------------------------------*/
	$('.flexslider').flexslider({
		animation: "slide",
	}); // end register flexslider
	
	/*
	*
	*	Colorbox
	*
	------------------------------------*/
	$('a.gallery').colorbox({
		rel:'gal',
		width: '80%', 
		height: '80%'
	});

	$('#testimony-carousel').owlCarousel({
		items:1,
		margin:10,
		autoHeight:true,
		autoplay: true,
		autoplayTimeout: 6000,
		loop: true,
		dots: false,
		nav    : true,
		smartSpeed :900,
		navText : ["<i class='custom-arrow left'><span class='sr'>Previous</span></i>","<i class='custom-arrow right'><span class='sr'>Next</span></i>"]
	});

	/*
	*
	*	Wow Animation
	*
	------------------------------------*/
	new WOW().init();


	$(document).on("click","#toggleMenu",function(){
		$(this).toggleClass('open');
		$('body').toggleClass('open-menu');
		$('.main-navigation').toggleClass('open');
	});

});// END #####################################    END