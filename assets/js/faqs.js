/**
 * FAQs page: accordion + smooth category navigation
 */
(function ($) {
	'use strict';

	function scrollToTarget($target) {
		if (!$target || !$target.length) {
			return;
		}
		var offset = 40;
		var top = $target.offset().top - offset;
		$('html, body').stop(true).animate({ scrollTop: top }, 500);
	}

	// Accordion toggle
	$(document).on('click', '.faq-question', function () {
		var $btn = $(this);
		var $item = $btn.closest('.faq-item');
		var $answer = $item.find('.faq-answer');
		var isOpen = $item.hasClass('is-open');

		if (isOpen) {
			$item.removeClass('is-open');
			$btn.attr('aria-expanded', 'false');
			$answer.slideUp(200, function () {
				$answer.attr('hidden', true);
			});
		} else {
			$item.addClass('is-open');
			$btn.attr('aria-expanded', 'true');
			$answer.removeAttr('hidden').hide().slideDown(200);
		}
	});

	function goToCategory(href) {
		if (!href || href.charAt(0) !== '#') {
			return;
		}
		var $target = $(href);
		if (!$target.length) {
			return;
		}
		scrollToTarget($target);
		if (history.pushState) {
			history.pushState(null, null, href);
		} else {
			window.location.hash = href;
		}
		$('.faqs-scroll-link').removeClass('is-active');
		$('.faqs-scroll-link[href="' + href + '"]').addClass('is-active');
		$('#faqs-category-select').val(href);
	}

	// Smooth scroll for sidebar anchors
	$(document).on('click', '.faqs-scroll-link', function (e) {
		var href = this.getAttribute('href');
		if (!href || href.charAt(0) !== '#') {
			return;
		}
		e.preventDefault();
		goToCategory(href);
	});

	// Mobile select jump links
	$(document).on('change', '#faqs-category-select', function () {
		var href = $(this).val();
		if (!href) {
			return;
		}
		goToCategory(href);
	});

	// Handle deep link on load
	if (window.location.hash) {
		var $hashTarget = $(window.location.hash);
		if ($hashTarget.length && $hashTarget.hasClass('faq-category')) {
			$('#faqs-category-select').val(window.location.hash);
			$('.faqs-scroll-link[href="' + window.location.hash + '"]').addClass('is-active');
			setTimeout(function () {
				scrollToTarget($hashTarget);
			}, 100);
		}
	}
})(jQuery);
