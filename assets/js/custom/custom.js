/**
 *	Custom jQuery Scripts
 *	
 *	Developed by: Austin Crane	
 *	Designed by: Austin Crane
 */

jQuery(document).ready(function ($) {

	// $.confirm({
	//     title: '',
	//     content: 'Simple confirm!',
	//     boxWidth: '50%',
 //    	useBootstrap: false,
 //    	draggable: false,
 //    	theme: 'modern',
	//     buttons: {
	//         confirm: function () {
	//             $.alert('Confirmed!');
	//         },
	//         close: function () {
	//             $.alert('Canceled!');
	//         },
	//         somethingElse: {
	//             text: 'Something else',
	//             btnClass: 'btn-blue',
	//             keys: ['enter', 'shift'],
	//             action: function(){
	//                 $.alert('Something else?');
	//             }
	//         }
	//     }
	// });

	var homePopupMessage = $("#homePopUpmessage");
	if( homePopupMessage.length ) {
		var message = $("#homePopUpmessage").text();
		if(message) {
			var messageAlert = $("#homePopUpmessage").html();
			var link='', buttonName = '';
			var button_obj= {
					close: function () {
					}
				};
			var buttonOption = $("#buttonOption");
			if( buttonOption.length ) {
				link = buttonOption.attr("data-link");
				buttonName = buttonOption.attr("data-name");
				button_obj = {
					ok: {
			            text: buttonName, // text for button
			            btnClass: 'btn-blue', // class for the button
			            action: function(heyThereButton){
			                location.href = link;
			            }
			        }
				}
			}
			
			$.confirm({
			    title: '',
			    content: messageAlert,
			    boxWidth: '50%',
		    	useBootstrap: false,
		    	draggable: false,
		    	theme: 'modern',
		    	closeIcon: true,
			    buttons: button_obj,
			    onContentReady: function () {

			    }
			});
		}
	}

	/* Select Style */
	$(".selectstyle").select2();
	$(".contactform select").select2();
	

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

	//$('.flightInfo li').matchHeight();
    

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

	// Cache the highest
    adjust_list_container();
    function adjust_list_container() {
    	if( $(".flightInfo ul li").length > 0 ) {
			var maxHeight = 0;

			$(".flightInfo ul li").each(function(){
				if( $(this).find(".listtext").length == 0 ) {
					if ($(this).height() > maxHeight) { maxHeight = $(this).height(); }
				} else {
					if ($(this).find(".listtext").height() > maxHeight) { maxHeight = $(this).find(".listtext").height(); }
				}
			});

			$(".flightInfo ul li").height(maxHeight);
			$(".flightInfo ul li").each(function(){
				if( $(this).find(".listtext").length == 0 ) {
					$(this).wrapInner('<div class="listtext"></div>');
				} 
			});
		}
    }

    if( $(".programs-listing .block .title").length > 0 ) {
    	var maxHeight = 0;
    	$(".programs-listing .block .title").each(function() {
    		if ($(this).height() > maxHeight) { maxHeight = $(this).height(); }
    	});
    	$(".programs-listing .block .title").height(maxHeight);
    }


	$(document).on("submit","#facultyfilter",function(e){
		e.preventDefault();
		var formdata = $(this).serialize();
		var pageTitle = document.title;
		var url = currentPage + '?' + formdata;
		setTimeout(function(){
			$(".loaderwrap").addClass('show');
			$("#facultiesInner").load(url + ' .loadcontent',function(){
				//window.history.pushState('', pageTitle, url);
				$(".loaderwrap").removeClass('show');
				$(".selectstyle").select2();
			});
		},800);
		
	});

	$(document).on("change","#facultyfilter select",function(){
		var opt = $(this).val();
		var currentPage = $("input#currentPage").val();
		$("#facultyfilter").trigger("submit");
	});

	$(document).on("click",".resetfilter",function(e){
		e.preventDefault();
		var url = $(this).attr('href');
		var pageTitle = document.title;
		setTimeout(function(){
			$(".loaderwrap").addClass('show');
			$("#facultiesInner").load(url + ' .loadcontent',function(){
				//window.history.pushState('', pageTitle, url);
				$(".loaderwrap").removeClass('show');
				$(".selectstyle").select2();
			});
		},800);
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

	$(document).on("click","#morepageBtnFaculty",function(e){
		e.preventDefault();
		var target = $(this);
		var paged = target.attr('data-pg');
		var nextPage = parseInt(paged) + 1;
		var total = target.attr('data-total');
		var post_type = target.attr('data-posttype');
		var $postContainer = $(".innerPosts");
		var pageLink = '';
		var nextPageLink = '';
		target.attr('data-pg',nextPage);

		if( $("#pagination a").length ) {
			var part = $("#pagination a")[0];
			pageLink = $(part).attr('href');
			var paramsArr = pageLink.split("?");
			var params = paramsArr[1];
			var pgArr = pageLink.split("pg=");
			var xpg = pgArr[1];		
			var theParams = params.replace('pg='+xpg,'pg='+nextPage);
			nextPageLink = currentPage + '?' + theParams;	
		}

		if(nextPageLink) {
			$.ajax({
				url: nextPageLink,
				type: 'GET',
				beforeSend:function(){
					$("#loaderdiv").addClass("show");
				},
				success: function(res) {
					if( $(res).find('div.innerPosts .boxinfo').length ) {
						var content = $(res).find('div.innerPosts').html();
						$postContainer.append(content);
						var totalItems = $("#faculties .boxinfo").length;
						$("#loaderdiv").removeClass("show");
						//window.history.pushState("","",nextPageLink);
						if(total == totalItems) {
							$(".lastposts").removeClass("hide");
							target.hide();
						}
					}  else {
						//console.log("NOT FOUND!");
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					$("#loaderdiv").removeClass("show");
				}
			});
		}

	});


	$(document).on("click","#morepageBtn",function(e){
		e.preventDefault();
		var target = $(this);
		var paged = target.attr('data-pg');
		var total = target.attr('data-total');
		var post_type = target.attr('data-posttype');
		$.ajax({
			url : frontajax.ajaxurl,
			type : 'post',
			dataType : "json",
			data : {
				action : 'get_next_posts',
				pg : paged,
				posttype : post_type
			},
			beforeSend:function(){
				$("#loaderdiv").addClass("show");
			},
			success : function( obj ) {
				var nextpage = obj.next_page;
				var result = obj.content;
				if(result) {
					target.attr('data-pg',nextpage);
					setTimeout(function(){
						$("#loaderdiv").removeClass("show");
						$(".postresults .postflex").append(result);
						var count = $(".post-item").length;
						if(total==count) {
							$(".lastposts").removeClass("hide");
							target.hide();
						}
					},300);
				} else {
					$("#loaderdiv").removeClass("show");
					$(".lastposts").removeClass("hide");
					target.hide();
				}
			}
		});
	});

	append_list_part();

	/* To Balance The Text under Financial Aid */
	function append_list_part() {
		var contentWidth = $("#content").outerWidth();
		if( $(".ulstyle li.part").length > 0 ) {
			$(".ulstyle li.part").each(function(){
				var target = $(this);
				var prev = $(this).prev();
				var text = $(this).html();

				if(contentWidth < 768 ) {
					if( $(".ulstyle span.continue").length == 0 ) {
						prev.append(' <span class="continue">' + text + '</span>');
					} 
					target.hide();
				} else {
					target.show();
					$(".ulstyle span.continue").remove();
				}

			});
		} 
	}

	/* Perform function on window resize */
	$( window ).resize(function() {
	  nophoto_placeholder();
	  adjust_list_container();
	  show_popup_close_button();
	  append_list_part();
	  detect_week_span_width();
	});
	
	detect_week_span_width();
	function detect_week_span_width() {
		if( $(".tdlength .wk").length ) {
			$(".tdlength .wk").each(function(){
				var textWidth = $(this).find('span').outerWidth();
				var tw = parseInt(textWidth) + 30;
				$(this).css('width',+tw+'px');
			});
		}
	}
	
	
	
	/* Single Program page (Tuition cost) */

});// END #####################################    END