$(function () {
	//
	// common

	//
	// notify
	$('#action-notifyX').on('click', '#btn-notifyX-message-string', function (e) {
		//var payload = {"msg":"notifyX test from local.drapster.com on 2 "+date(), "link":"http:\/\/www.yahoo.com"};
		var payload = "notifyX test string from " + appId + " on " + Date();
		$('#notifyX-message').html(payload);
	});
	$('#action-notifyX').on('click', '#btn-notifyX-message-json', function (e) {
		var payload = { "msg": "notifyX test json from " + appId + " on " + Date(), "var1": "abc", "var2": "def" };
		$('#notifyX-message').html(JSON.stringify(payload));
	});
	$('#action-notifyX').on('click', '#btn-notifyX-message-url', function (e) {
		var payload = { "msg": "notifyX test url from " + appId + " on " + Date(), "link": "http:\/\/www.yahoo.com" };
		$('#notifyX-message').html(JSON.stringify(payload));
	});
	$('#action-notifyX').on('click', '#btn-notifyX-message-internalUrl', function (e) {
		var payload = { "msg": "notifyX test internal url from " + appId + " on " + Date(), "link": "/shop/edragon" };
		$('#notifyX-message').html(JSON.stringify(payload));
	});
});
