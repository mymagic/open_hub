$(function() {
	var url = document.location.toString();
	
	if (url.match('#')) 
	{
		$('.nav-tabs a[href=#'+url.split('#')[1]+']').tab('show') ;
		setTimeout(function() {window.scrollTo(0, 0);}, 1);
	}
	else
	{
		var lastTab = localStorage.getItem('lastTab');
		$('#'+lastTab).parents('div[role="tabpanel"]').find('a[aria-controls="'+lastTab+'"]').tab('show');
		setTimeout(function() {window.scrollTo(0, 0);}, 1);
	}
	
	/*$('.nav-tabs a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		window.location.hash = e.target.hash;
		setTimeout(function() {window.scrollTo(0, 0);}, 1);
		//console.log($(e.target).attr('aria-controls'));
		localStorage.setItem('lastTab', $(e.target).attr('aria-controls'));
	})*/
	
	$('.box-filter radio, .box-filter input').on('change', function() {
		$(this).closest('form').submit();
    });
});



var $window = $(window);
function checkWidth() {
   var windowsize = $window.width();

   if (windowsize < 768) {
   	  $("#content-services").hide();
      $("#header").unbind('click').click(function(event){
      	event.stopPropagation();
         $("#content-services").slideToggle('slow');
      });
   } else if (windowsize > 768) { 
      $("#content-services").show().height('auto');
   }
}


checkWidth(); // on load
$(window).resize(checkWidth); // on window resize


function goBack()
{
	window.history.back();
}