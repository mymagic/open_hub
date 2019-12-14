jQuery(document).ready(function($) {
	$('.toggle-menu').jPushMenu({
		closeOnClickOutside: false,
		closeOnClickLink   : false
	});
	
	var lgi = $(".owl-carousel");
	lgi.each(function(index) {
		var slider = $(this).parent('.lgi__slider').attr("id", "lgi__slider" + index);
		$('#lgi__slider' + index + ' .owl-carousel').owlCarousel({
			dots: false,
			slideBy: 'page',
			autoWidth: true,
			stagePadding: 0,
			margin: 15,
			nav: true,
			navText: ['<i class="icon-left-small"></i>', '<i class="icon-right-small"></i>'],
			navContainer: '#lgi__slider' + index,
			navClass: [ 'lgi__btn lgi__btn--prev', 'lgi__btn lgi__btn--next' ],
			responsive: {
				0: {
					items: 1,
				},
				768: {
					items: 2,
					autoWidth: false,
				},
				992: {
					items: 3,
					autoWidth: false,
				},
				1310: {
					items: 3,
					autoWidth: false,
					margin: 30,
				}
			}
		});
	});

});
