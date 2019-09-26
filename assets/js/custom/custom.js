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

	$( window ).resize(function() {
	  show_popup_close_button();
	});

	//show_popup_close_button();
	function show_popup_close_button() {
		if( $(".ajax_contentdiv").length ) {
			var closePos = $(".ajax_contentdiv").position();
			$(".popclose").css('top',closePos.top + 'px');
		}
	}

	$(document).on("click",".facultydata",function(e){
		e.preventDefault();
		var postid = $(this).attr('data-postid');
		$.ajax({
			url : frontajax.ajaxurl,
			type : 'post',
			dataType : "json",
			data : {
				action : 'get_the_page_content',
				postid : postid
			},
			beforeSend:function(){
				$("#loaderdiv").addClass("show");
			},
			success : function( response ) {
				if(response.content) {
					var content = response.content;
					setTimeout(function(){
						$('body').append(content);
						$('body').addClass('modal-open');
						$("#detailsPage").addClass('fadeIn');
						$("#loaderdiv").removeClass("show");
						show_popup_close_button();
					},200);
				} 
			}
		});
	});

	$(document).on("click","#closepopup",function(e){
		e.preventDefault();
		$(".popupwrapper").remove();
		$('body').removeClass('modal-open');
	});

	$(document).keyup(function(e) {
		if( $(".popupwrapper").length ) {
			$(".popupwrapper").remove();
			$('body').removeClass('modal-open');
		}
	});

});// END #####################################    END