var _muh = _muh || {};
_muh.config = {};
_muh.config.isDebug = false;
_muh.config.isLogin = false;
_muh.config.loginUrl = '//connect.mymagic.my'
_muh.checkStyleSheet = function(url) {
    var found = false;
    for (var i = 0; i < document.styleSheets.length; i++) {
        if (document.styleSheets[i].href == url) {
            found = true;
            break;
        }
    }
    if (!found) {
        jQuery('head').append(jQuery('<link rel="stylesheet" type="text/css" href="' + url + '" />'));
    }
}
var urls = [];
urls['magic'] = [];
urls['magic']['default'] = '//www.mymagic.my';
urls['magic']['en'] = '//www.mymagic.my/en';
urls['magic']['ms'] = '//www.mymagic.my/ms';
urls['accelerator-home'] = [];
urls['accelerator-home']['default'] = '//accelerator.mymagic.my';
urls['accelerator-home']['en'] = '//accelerator.mymagic.my/en';
urls['accelerator-home']['ms'] = '//accelerator.mymagic.my/ms';
urls['accelerator-gap'] = [];
urls['accelerator-gap']['default'] = '//accelerator.mymagic.my/gap';
urls['accelerator-gap']['en'] = '//accelerator.mymagic.my/en/gap/';
urls['accelerator-gap']['ms'] = '//accelerator.mymagic.my/ms/gap/';
urls['accelerator-distroDojo'] = [];
urls['accelerator-distroDojo']['default'] = '//accelerator.mymagic.my/distro-dojo';
urls['accelerator-distroDojo']['en'] = '//accelerator.mymagic.my/en/distro-dojo/';
urls['accelerator-distroDojo']['ms'] = '//accelerator.mymagic.my/ms/distro-dojo/';
urls['global'] = [];
urls['global']['default'] = '//global.mymagic.my';
urls['global']['en'] = '//global.mymagic.my/en';
urls['global']['ms'] = '//global.mymagic.my/ms';
urls['central'] = [];
urls['central']['default'] = '//central.mymagic.my';
urls['central']['en'] = '//central.mymagic.my/en';
urls['central']['ms'] = '//central.mymagic.my/ms';
urls['se'] = [];
urls['se']['default'] = '//se.mymagic.my';
urls['se']['en'] = '//se.mymagic.my/en';
urls['se']['ms'] = '//se.mymagic.my/ms';
urls['ace'] = [];
urls['ace']['default'] = '//ace.mymagic.my';
urls['ace']['en'] = '//ace.mymagic.my/en';
urls['ace']['ms'] = '//ace.mymagic.my/ms';
urls['impact'] = [];
urls['impact']['default'] = '//impact.mymagic.my';
urls['impact']['en'] = '//impact.mymagic.my/en';
urls['impact']['ms'] = '//impact.mymagic.my/ms';
_muh.urls = urls;
_muh.setLanguage = function(lang) {
    lang = typeof lang !== 'undefined' ? lang : 'en';
    for (var urlKey in _muh.urls) {
        var url = urls[lang];
        jQuery("header .container_dark").find('a[data-url-code="' + urlKey + '"]').prop('href', _muh.urls[urlKey][lang]);
    }
    var langMenuHtml = '<a href=\"//www.mymagic.my/en\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-expanded=\"false\">\
        English <span class=\"glyphicon glyphicon-triangle-bottom\" aria-hidden=\"true\"></span>\
    </a>\
    <ul class=\"dropdown-menu\" role=\"menu\" aria-labelledby=\"Child Item\">\
        <li><a href=\"//www.mymagic.my/ms\">Bahasa Melayu</a></li>\
    </ul>';
    if (lang == 'ms') {
        langMenuHtml = '<a href=\"//www.mymagic.my/ms\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-expanded=\"false\">\
            Bahasa Melayu <span class=\"glyphicon glyphicon-triangle-bottom\" aria-hidden=\"true\"></span>\
        </a>\
        <ul class=\"dropdown-menu\" role=\"menu\" aria-labelledby=\"Child Item\">\
            <li><a href=\"//www.mymagic.my/en\">English</a></li>\
        </ul>';
    }
    jQuery('header .container_dark').find('li[data-menu1="language"]').html(langMenuHtml);
}
_muh.render = function() {
    if (_muh.config.currentUrl == null) _muh.config.currentUrl = window.location.href;
    if (_muh.config.isDebug) {
        _muh.checkStyleSheet('../css/universal-style.css');
    } else {
        _muh.checkStyleSheet('//mymagic.my/universal-assets/css/universal-style-new.css?t=1496135333');
    }
    if (!jQuery('.color-bar').length && !jQuery('header .container_dark').length) {
        jQuery("body").prepend('<div class="color-bar"></div><div class="uni-header"></div>');
    }
    jQuery("header .container_dark").empty();
    jQuery("header .container_dark").html("\r\n<div class=\"navbar-header\">\r\n    <button type=\"button\" class=\"navbar-toggle toggle-menu menu-right\">\r\n        <span>\r\n            <span class=\"icon-bar\"><\/span>\r\n            <span class=\"icon-bar\"><\/span>\r\n            <span class=\"icon-bar\"><\/span>\r\n        <\/span>\r\n    <\/button>\r\n    <a class=\"navbar-brand\" href=\"https:\/\/mymagic.my\/\">\r\n        <svg>\r\n            <symbol id=\"SmallLogo\" class=\"small_logo\" viewBox=\"0 0 80.5 47.7\">\r\n                <path class=\"st0\" d=\"M27,25.1c1.7-1.7,1.9-4,0.8-5.9L12,3.4L11.6,3c-1.8-1.8-3-3-5.8-3C2.5,0,0,2.7,0,6.3v16.4\r\n                    c0.7,1.7,2.3,3.2,4.4,3.2c2.1,0,3.9-1.2,4.6-3.1v-9.2l12.1,12.1C22.9,26.8,25.3,26.8,27,25.1\"\/>\r\n                <path class=\"st1\" d=\"M4.4,25.9c-2.1,0-3.7-1.4-4.4-3.2v20.3c0,2.2,1.8,4.6,4.4,4.6c2.6,0,4.6-2,4.6-4.6V22.8\r\n                    C8.3,24.7,6.6,25.9,4.4,25.9\"\/>\r\n                <path class=\"st2\" d=\"M53.3,25c-1.7-1.6-1.6-4.1-0.7-5.8L40.2,31.6L27.8,19.2c1.1,1.9,0.8,4.2-0.8,5.9c-1.7,1.7-4.2,1.6-5.9,0.6\r\n                    L36,40.6c1.2,1.2,2.8,2,4.4,2c1.9,0,3.6-1.5,4.2-2.1l14.7-14.7C57.4,26.9,55,26.7,53.3,25\"\/>\r\n                <path class=\"st3\" d=\"M75.9,25.9c-2.1,0-3.7-1.4-4.4-3.1v20.3c0,2.6,2,4.6,4.6,4.6c2.6,0,4.4-2.4,4.4-4.6V22.8\r\n                    C79.7,24.7,78,25.9,75.9,25.9\"\/>\r\n                <path class=\"st4\" d=\"M75.9,25.9c2.1,0,3.9-1.2,4.6-3.1V6.3c0-3.7-2.3-6.3-5.7-6.3c-2.9,0-4.3,1.4-6.3,3.4L52.6,19.2\r\n                    c-1,1.8-1,4.2,0.7,5.8c1.7,1.7,4.1,1.9,6,0.8l12.1-12.1v9.1C72.1,24.5,73.7,25.9,75.9,25.9\"\/>\r\n            <\/symbol>\r\n            <use xlink:href=\"#SmallLogo\"\/>\r\n        <\/svg>\r\n\t\t\t\t<img alt=\"Brand\" src=\"https:\/\/mymagic.my\/wp-content\/themes\/magic2017\/assets\/art\/logo.svg\" alt=\"MaGIC\">\r\n    <\/a>\r\n    <div class=\"hidden-xs hidden-sm cf\" id=\"TopNav\">\r\n        <ul class=\"nav navbar-nav\">\r\n            <li><a href=\"https:\/\/mymagic.my\/about\/\">About<\/a><\/li>\r\n            <li><a href=\"https:\/\/mymagic.my\/programs\/\">Programs<\/a><\/li>\r\n            <li><a href=\"https:\/\/mymagic.my\/events\/?fwp_event_date=upcoming\">Events<\/a><\/li>\r\n            <li><a href=\"https:\/\/mymagic.my\/facilities\/\">Co-Working<\/a><\/li>\r\n            <li><a href=\"http:\/\/resource.mymagic.my\">Resources<\/a><\/li>\r\n            <li><a href=\"https:\/\/mymagic.my\/ace\/\">ACE<\/a><\/li>\r\n            <li><a href=\"https:\/\/mymagic.my\/news\/\">News<\/a><\/li>\r\n            <li><a href=\"https:\/\/mymagic.my\/publications\/\">Publications<\/a><\/li>\r\n        <\/ul>\r\n        <ul class=\"nav navbar-nav navbar-right\">\r\n            <!--li><a href=\"https:\/\/mymagic.my\/press-media\/\">Press & Media<\/a><\/li-->\r\n            <li><a href=\"https:\/\/mymagic.my\/jobs\/\">Jobs<\/a><\/li>\r\n            <li><a href=\"https:\/\/mymagic.my\/contact\/\">Contact<\/a><\/li>\r\n            <li><a href=\"http:\/\/connect.mymagic.my\/\"><i class=\"icon-key\"><\/i> <strong>My Account<\/strong><\/a><\/li>\r\n        <\/ul>\r\n    <\/div>\r\n<\/div>");
    var re = new RegExp("(http:\/\/)?" + window.location.host);
    var currentMenuItem = jQuery("a[href=\'//" + window.location.host + "']");
    if (re.test(currentMenuItem.prop("href"))) {
        currentMenuItem.parent().addClass("current-menu-item");
    }
    if (_muh.config && _muh.config.selectedMenu1 != "") {
        jQuery('header .container_dark li').removeClass('current-menu-item');
        jQuery('header .container_dark li[data-menu1="' + _muh.config.selectedMenu1 + '"]').addClass('current-menu-item');
    }
    if (_muh.config && _muh.config.disableAccount == true) {
        jQuery('header .container_dark li[data-menu1="account"]').removeClass('dropdown');
        jQuery('header .container_dark li[data-menu1="account"] a').removeClass('dropdown-toggle').removeAttr('data-toggle');
        jQuery('header .container_dark li[data-menu1="account"] span.glyphicon').hide();
        jQuery('header .container_dark li[data-menu1="account"] ul').hide();
        jQuery('header .container_dark li[data-menu1="account"]').hide();
    }
    if (_muh.config && _muh.config.disableLanguage == true) {
        jQuery('header .container_dark li[data-menu1="language"]').hide();
    }
}
_muh.render();
(function(d) {
    var config = {
            kitId: 'ces4fvp',
            scriptTimeout: 3000,
            async: true
        },
        h = d.documentElement,
        t = setTimeout(function() {
            h.className = h.className.replace(/\bwf-loading\b/g, "") + " wf-inactive";
        }, config.scriptTimeout),
        tk = d.createElement("script"),
        f = false,
        s = d.getElementsByTagName("script")[0],
        a;
    h.className += " wf-loading";
    tk.src = 'https://use.typekit.net/' + config.kitId + '.js';
    tk.async = true;
    tk.onload = tk.onreadystatechange = function() {
        a = this.readyState;
        if (f || a && a != "complete" && a != "loaded") return;
        f = true;
        clearTimeout(t);
        try {
            Typekit.load(config)
        } catch (e) {}
    };
    s.parentNode.insertBefore(tk, s)
})(document);