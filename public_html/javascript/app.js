$(function() {
	
	$("img").error(function(){
		$(this).hide();
	});

	$('.nav-tabs a:first').tab('show')

	var url = document.location.toString();
	if (url.match('#')) {
		$('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
	} 

});


function sessionTimeoutPopup(pTimeout, pCountdown)
{
	pTimeout = typeof pTimeout !== 'undefined' ? pTimeout : 7200;
	pCountdown = typeof pCountdown !== 'undefined' ? pCountdown : 10;
	$.timeoutDialog({
		timeout:pTimeout, 
		countdown:pCountdown, 
		keep_alive_url:baseUrl+"/api/keepAlive", 
		logout_url:baseUrl+"/site/logout", 
		restart_on_yes:true
	});
}
