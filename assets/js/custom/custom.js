/**
 *	Custom jQuery Scripts
 *	
 *	Developed by: Austin Crane	
 *	Designed by: Austin Crane
 */

jQuery(document).ready(function ($) {

	/* Select Style */
	$(".selectstyle").select2();
	
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

	nophoto_placeholder();
	function nophoto_placeholder() {
		if( $("#faculties .boxinfo").length > 0 ) {
			$("#faculties .boxinfo").each(function(){
				var boxHeight = $(this).outerHeight();
				var captionheight = $(this).find('.caption').outerHeight();
				var topHeight = boxHeight - captionheight;
				if( $(this).find(".noimage").length ) {
					$(this).find(".noimage").css('height',topHeight+'px');
				}
			});
		}
	}

	$( window ).resize(function() {
	  nophoto_placeholder();
	});

	$(document).on("submit","#facultyfilter",function(e){
		e.preventDefault();
		var formdata = $(this).serialize();
		var pageTitle = document.title;
		var url = currentPage + '?' + formdata;
		setTimeout(function(){
			$(".loaderwrap").addClass('show');
			$("#facultiesInner").load(url + ' .loadcontent',function(){
				window.history.pushState('', pageTitle, url);
				$(".loaderwrap").removeClass('show');
				$(".selectstyle").select2();
			});
		},800);
		
	});

	$(document).on("change","#facultyfilter select",function(){
		var opt = $(this).val();
		$("#facultyfilter").trigger("submit");
	});

	$(document).on("click",".resetfilter",function(e){
		e.preventDefault();
		var url = $(this).attr('href');
		var pageTitle = document.title;
		setTimeout(function(){
			$(".loaderwrap").addClass('show');
			$("#facultiesInner").load(url + ' .loadcontent',function(){
				window.history.pushState('', pageTitle, url);
				$(".loaderwrap").removeClass('show');
				$(".selectstyle").select2();
			});
		},800);
	});

});// END #####################################    END