<?php $this->beginContent(sprintf('webroot.themes.%s.views.layouts._frontend', Yii::app()->theme->name)); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/javascript/app.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/javascript/frontend.js', CClientScript::POS_END); ?>
<?php //Yii::app()->clientScript->registerScriptFile("//www.mymagic.my/universal-assets/css/bootstrap-social.css", CClientScript::POS_END);
?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/css/mymagic.css'); ?>

<?php Yii::app()->getClientScript()->registerCssFile('https://mymagic-central.s3-ap-southeast-1.amazonaws.com/universal-assets/dist/css/app.css'); ?>
<?php Yii::app()->ClientScript->registerScriptFile('https://mymagic-central.s3-ap-southeast-1.amazonaws.com/universal-assets/dist/js/universal.js', CClientScript::POS_END); ?>

<?php Yii::app()->getClientScript()->registerCssFile('https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css'); ?>
<?php Yii::app()->getClientScript()->registerScriptFile('https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js'); ?>


<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico" type="image/x-icon" />

<?php $this->layoutParams['bodyClass'] .= ' body-stampede layout-frontend'; ?>
<?php $this->layoutParams['hideFlashes'] = false; ?>

<?php if (!$this->layoutParams['hideFlashes'] && Notice::hasFlashes()) : ?>
    <div id="layout-flashNotice">
        <?php echo Notice::renderFlashes(); ?>
    </div>
<?php endif; ?>


<style type="text/css">
    .header__fnav .navbar-brand {
        background: #fff;
    }

    .header__fnav .navbar-brand .st0 {
        fill: #00AAC6;
    }

    .header__fnav .navbar-brand .st1 {
        fill: #CE3640;
    }

    .header__fnav .navbar-brand .st2 {
        fill: #F3A629;
    }

    .header__fnav .navbar-brand .st3 {
        fill: #6EA945;
    }

    .header__fnav .navbar-brand .st4 {
        fill: #E75C2D;
    }

    .nav-select {
        background: url(/images/stripe-quote.png) 0 0 no-repeat;
    }

    @media (min-width: 1200px) {
        .uni-header .header__fnav .navbar-brand {
            height: 40px;
            margin-left: 0;
            margin-right: 20px;
            height: 40px;
            line-height: 35px;
            padding: 12px 0;
            width: 42px;
            margin-left: 0 !important;
        }
    }

    .header__fnav .navbar-brand svg {
        height: 15px !important;
        width: 18px !important;

    }
</style>

<?php
foreach ($this->menuSub as $key => $menu) {
    $this->menuSub[$key]['url'] = CHtml::normalizeUrl($menu['url']);
}
?>

<header id="universal-header" class="sticky top-0 z-40">
    <universal-header sub-menu='<?php echo CJSON::encode($this->menuSub) ?>' bucket-url="<?php echo Yii::app()->params->s3Url; ?>" central-url="<?php echo Yii::app()->baseUrl; ?>">
        <template slot="language" class="mr-2">
            <?php if ($this->layoutParams['isShowMenuSubLanguageSelector']) : ?>
                <div class="flex items-center">
                    <?php if (count(Yii::app()->params['frontendLanguages']) > 1) : ?>
                        <?php $last_key = end(array_keys(Yii::app()->params['frontendLanguages'])); foreach (Yii::app()->params['frontendLanguages'] as $langCode => $langTitle) : ?>
                            <div>
                                <a href="<?php echo $this->createMultilanguageReturnUrl($langCode); ?>" title="<?php echo $langTitle; ?>" class="<?php echo (Yii::app()->language == $langCode) ? 'text-magic-nav font-black' : ''; ?> text-black hover:text-black focus:text-black sofia-pro" style="text-decoration: none"><?php echo $langTitle; ?></a>
                            </div>
                            <?php if ($langCode !== $last_key) : ?>
                                <span class="mx-1"> | </span>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </template>
        <template slot="language-mobile" class="mr-2">
            <?php if ($this->layoutParams['isShowMenuSubLanguageSelector']) : ?>
                <div class="flex">
                    <?php if (count(Yii::app()->params['frontendLanguages']) > 1) : ?>
                        <?php $last_key = end(array_keys(Yii::app()->params['frontendLanguages'])); foreach (Yii::app()->params['frontendLanguages'] as $langCode => $langTitle) : ?>
                            <div>
                                <a href="<?php echo $this->createMultilanguageReturnUrl($langCode); ?>" title="<?php echo $langTitle; ?>" class="<?php echo (Yii::app()->language == $langCode) ? 'text-black font-black' : 'text-white'; ?> hover:text-white focus:text-white sofia-pro font-medium tracking-wider no-underline" style="text-decoration: none"><?php echo $langTitle; ?></a>
                            </div>
                            <?php if ($langCode !== $last_key) : ?>
                                <span class="mx-1 text-white"> | </span>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </template>
    </universal-header>
</header>


<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KJ9387R" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<!-- container -->
<div class="<?php echo $this->layoutParams['containerFluid'] ? 'container-fluid' : 'container'; ?>">

    <!-- main-content -->
    <div id="main-content">
        <?php echo $content; ?>
    </div>
    <!-- /main-content -->


</div>
<!-- /container -->

<!-- universal footer -->
<footer id="universal-footer">
    <universal-footer central-url="<?php echo Yii::app()->baseUrl; ?>"></universal-footer>
</footer>
<!-- /universal footer -->


<?php if (Yii::app()->params['environment'] == 'production') : ?>
    <?php /* ?>
    <script>
        (function(i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function() {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
        // .mymagic.my
        ga('create', 'UA-62910124-1', 'auto');
        ga('send', 'pageview');
        // central
        ga('create', 'UA-62910124-5', 'auto', 'centralTracker');
        ga('centralTracker.send', 'pageview');
        // custom
        <?php foreach ($this->layoutParams['gaAccounts'] as $gaAccount) : ?>
            ga('create', '<?php echo $gaAccount['id']; ?>', 'auto', '<?php echo $gaAccount['trackerName']; ?>');
            ga('<?php echo $gaAccount['trackerName']; ?>', 'pageview');
        <?php endforeach; ?>
        // user id
        <?php if (!empty(Yii::app()->user->username)) : ?> ga('set', 'userId', '<?php echo Yii::app()->user->username; ?>');
        <?php endif; ?>
    </script>
    <?php // */ ?>

    <!-- Google Tag Manager -->
    <!-- End Google Tag Manager -->
<?php endif; ?>

<?php if (Yii::app()->params['environment'] == 'production') : ?>
    <!-- Matomo -->
    <script type="text/javascript">
        var _paq = _paq || [];
        /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
        _paq.push(["setDocumentTitle", document.domain + "/" + document.title]);
        _paq.push(["setCookieDomain", "*.mymagic.my"]);
        _paq.push(['setDomains', '*.mymagic.my']);
        _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);
        _paq.push(['trackAllContentImpressions']);
        <?php foreach ($this->layoutParams['piwik']['events'] as $piwikEvent) : ?>
            _paq.push(['trackEvent', '<?php echo $piwikEvent['category']; ?>', '<?php echo $piwikEvent['action']; ?>', '<?php echo $piwikEvent['key']; ?>', '<?php echo $piwikEvent['value']; ?>']);
        <?php endforeach; ?>
            (function() {
                var u = "<?php echo Yii::app()->params['piwikTrackerUrl']; ?>";
                _paq.push(['setTrackerUrl', u + 'piwik.php']);
                _paq.push(['setSiteId', '1']);
                var d = document,
                    g = d.createElement('script'),
                    s = d.getElementsByTagName('script')[0];
                g.type = 'text/javascript';
                g.async = true;
                g.defer = true;
                g.src = u + 'piwik.js';
                s.parentNode.insertBefore(g, s);
            })();
    </script>
    <!-- End Matomo Code -->
<?php endif; ?>

<?php if (Yii::app()->params['enableMixPanel']) : ?>
    <!-- start Mixpanel -->
    <script type="text/javascript">
        (function(e, a) {
            if (!a.__SV) {
                var b = window;
                try {
                    var c, l, i, j = b.location,
                        g = j.hash;
                    c = function(a, b) {
                        return (l = a.match(RegExp(b + "=([^&]*)"))) ? l[1] : null
                    };
                    g && c(g, "state") && (i = JSON.parse(decodeURIComponent(c(g, "state"))), "mpeditor" === i.action && (b.sessionStorage.setItem("_mpcehash", g), history.replaceState(i.desiredHash || "", e.title, j.pathname + j.search)))
                } catch (m) {}
                var k, h;
                window.mixpanel = a;
                a._i = [];
                a.init = function(b, c, f) {
                    function e(b, a) {
                        var c = a.split(".");
                        2 == c.length && (b = b[c[0]], a = c[1]);
                        b[a] = function() {
                            b.push([a].concat(Array.prototype.slice.call(arguments,
                                0)))
                        }
                    }
                    var d = a;
                    "undefined" !== typeof f ? d = a[f] = [] : f = "mixpanel";
                    d.people = d.people || [];
                    d.toString = function(b) {
                        var a = "mixpanel";
                        "mixpanel" !== f && (a += "." + f);
                        b || (a += " (stub)");
                        return a
                    };
                    d.people.toString = function() {
                        return d.toString(1) + ".people (stub)"
                    };
                    k = "disable time_event track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config reset people.set people.set_once people.unset people.increment people.append people.union people.track_charge people.clear_charges people.delete_user".split(" ");
                    for (h = 0; h < k.length; h++) e(d, k[h]);
                    a._i.push([b, c, f])
                };
                a.__SV = 1.2;
                b = e.createElement("script");
                b.type = "text/javascript";
                b.async = !0;
                b.src = "undefined" !== typeof MIXPANEL_CUSTOM_LIB_URL ? MIXPANEL_CUSTOM_LIB_URL : "file:" === e.location.protocol && "//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js".match(/^\/\//) ? "https://cdn.mxpnl.com/libs/mixpanel-2-latest.min.js" : "//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js";
                c = e.getElementsByTagName("script")[0];
                c.parentNode.insertBefore(b, c)
            }
        })(document, window.mixpanel || []);
        mixpanel.init("<?php echo Yii::app()->params['mixpanelToken']; ?>");
        <?php if (!empty(Yii::app()->user) && !empty(Yii::app()->user->username)) : ?>mixpanel.identify("<?php echo Yii::app()->user->username; ?>");
        <?php endif; ?>
    </script><!-- end Mixpanel -->
<?php endif; ?>

<?php $utm_source = isset($_GET['utm_source']) ? $_GET['utm_source'] : ''; ?>
<?php $utm_medium = isset($_GET['utm_medium']) ? $_GET['utm_medium'] : ''; ?>
<?php $utm_campaign = isset($_GET['utm_campaign']) ? $_GET['utm_campaign'] : ''; ?>
<?php $utm_term = isset($_GET['utm_term']) ? $_GET['utm_term'] : ''; ?>
<?php $utm_content = isset($_GET['utm_content']) ? $_GET['utm_content'] : ''; ?>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $(function() {
            /*$("a").attr('href', function(i, h) {
                if(i && h && h.indexOf('#') == -1)
                {
                    return h + (h.indexOf('?') != -1 ? "&utm_source=<?php echo $utm_source; ?>&utm_medium=<?php echo $utm_medium; ?>&utm_campaign=<?php echo $utm_campaign; ?>&utm_term=<?php echo $utm_term; ?>&utm_content=<?php echo $utm_content; ?>" : "?utm_source=<?php echo $utm_source; ?>&utm_medium=<?php echo $utm_medium; ?>&utm_campaign=<?php echo $utm_campaign; ?>&utm_term=<?php echo $utm_term; ?>&utm_content=<?php echo $utm_content; ?>");
                }

            });*/
        });
    });
</script>

<iframe style="border:0; width:1px; height:1px" src="https://<?php echo Yii::app()->params['connectUrl']; ?>/profile"></iframe>


<!-- modal-common -->
<div id="modal-common" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalLabel-common" data-load-url="">
</div>
<!-- /modal-common -->


<div id="block-spinner" class="hidden">
    <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
    <span class="sr-only">Loading...</span>
    <h3 class="margin-top-2x"><?php echo Yii::t('core', 'Loading...'); ?></h3>
</div>

<?php $this->endContent(); ?>



<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/vendor/stampede/css/owl.carousel.css'); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/vendor/stampede/js/owl.carousel.js', CClientScript::POS_END); ?>

<?php //Yii::app()->getClientScript()->registerCssFile('https://fonts.googleapis.com/css?family=Montserrat');
?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/vendor/stampede/css/jpushmenu.css'); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/vendor/stampede/js/jpushmenu.js', CClientScript::POS_END); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/vendor/stampede/css/base.css'); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/vendor/stampede/js/base.js', CClientScript::POS_END); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/vendor/stampede/css/fix-inspinia-conflict.css'); ?>


<?php Yii::app()->clientScript->registerScript('vue-main-content', "

$('.js-multi-select').select2({
    placeholder: 'Please Select',
    allowClear: true
});

"); ?>