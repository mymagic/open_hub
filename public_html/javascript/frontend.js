$(function () {
	var url = document.location.toString();

	$('.box-filter radio, .box-filter input').on('change', function () {
		$(this).closest('form').submit();
	});
});



var $window = $(window);
function checkWidth() {
	var windowsize = $window.width();

	if (windowsize < 768) {
		$("#content-services").hide();
		$("#header").unbind('click').click(function (event) {
			event.stopPropagation();
			$("#content-services").slideToggle('slow');
		});
	} else if (windowsize > 768) {
		$("#content-services").show().height('auto');
	}
}


checkWidth(); // on load
$(window).resize(checkWidth); // on window resize


function goBack() {
	window.history.back();
}