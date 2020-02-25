<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = array(
	'Central'
);
?>


<style type="text/css">
.magic-nav li {
    display: inline-block;
}
.magic-nav li:first-child a {
    padding-left: 0;
}
.magic-nav li a {
    color: #000000;
    font-size: 14px;
    font-weight: bold;
    padding: 10px 15px;
}

.sub-header .magic-nav {
    float: right;
}


 .sub-header {
    padding-top: 30px;
    padding-bottom: 55px;
    margin-right: auto;
    margin-left: auto;
    padding-left: 15px;
    padding-right: 15px;
}

@media (min-width: 992px)
{
    .sub-header .logo-container {
    float: left;
    width: 16.6666666667%;
}

}
.sub-header .logo-container {
    position: relative;
    min-height: 1px;
    padding-left: 15px;
    padding-right: 15px;
}

@media (min-width: 992px)
{
    .sub-header .menu {
    float: left;
    width: 83.3333333333%;
    }
}
.sub-header .menu {
    position: relative;
    min-height: 1px;
    padding-left: 15px;
    padding-right: 15px;
}

#mobile-menu > select {
    display: none;
}

.banner{
    margin-right: 15px;
    margin-left: 15px;
    margin-bottom: 40px;
    height: 400px;
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    position: relative;
}
.overlay-primary {
    position: relative;
}

.overlay-primary:after {
    content: ' ';
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    z-index: 1;
    background-color: rgba(0, 185, 209, 0.8);
    transition: background-color 0.5s ease;
}
.banner .hover-txt {
    overflow: hidden;
    margin: auto;
    height: calc(100% - 150px);
    width: calc(100% - 150px);
    position: absolute;
    z-index: 2;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    text-align: center;
}
.banner .hover-txt h1 {
    font-weight: 700;
    color: #FFFFFF;
    font-size: 32px;
}
.banner .hover-txt p {
    font-size: 18px;
    color: #FFFFFF;
}

@media (min-width: 992px){
    .page-central .title-bar {
        float: left;
        width: 100%;
    }
}

.page-central .title-bar {
    position: relative;
    min-height: 1px;
    padding-left: 15px;
    padding-right: 15px;
    padding-top: 10px;
    padding-bottom: 10px;
}

.page-central .companies-logo-color {
    padding-bottom: 20px;
}


@media (min-width: 992px){

.page-central .companies-logo-color .logo {
    float: left;
    width: 16.6666666667%;
}
}

.page-central .companies-logo-color .logo {
    position: relative;
    min-height: 1px;
    padding-left: 15px;
    padding-right: 15px;
}


.companies-logo-color .logo {
    position: relative;
    min-height: 1px;
    padding-left: 15px;
    padding-right: 15px;
}
.companies-logo-color section {
    margin-left: -15px;
    margin-right: -15px;
}

.central-content {
    margin-top: 40px;
}


.tease {
    transition: all 0.5s ease !important;
    border: 1px solid transparent;
    padding-top: 15px;
    padding-bottom: 15px;
    position: relative;
}

.tease:hover {
    border: 1px solid #D0D0D0;
    color: #666666;
}
.tease:hover .image {
    position: relative;
}

.tease-list-3 {
    display: inline-block;
}

.tease-list-3 article:first-child {
    margin-left: 0;
}


.tease:hover .hover-actions {
    opacity: 1;
}
.tease .hover-actions {
    position: absolute;
    top: 50%;
    z-index: 2;
    width: 100%;
    text-align: center;
    -webkit-transform: translateY(-50%);
    transform: translateY(-50%);
    opacity: 0;
    transition: opacity 0.4s ease;
}
.tease:hover .image:after {
    content: ' ';
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    z-index: 1;
    background-color: rgba(208, 208, 208, 0.8);
    transition: background-color 0.5s ease;
}
.tease-list-3 article img {
    min-width: 100%;
}

@media (min-width: 992px)
{
    .tease-list-3 article {
        float: left;
        width: 31.5%;
    }

}
.tease-list-3 article {
    position: relative;
    min-height: 1px;
    padding-left: 15px;
    padding-right: 15px;
    margin-left: 0.625%;
    margin-right: 0.625%;
}
@media (min-width: 992px)
{
    .page-central .central-content .feedback-text {
        float: left;
        width: 100%;
    }

}
.page-central .central-content .feedback-text {
    position: relative;
    min-height: 1px;
    padding-left: 15px;
    padding-right: 15px;
    padding-top: 20px;
    text-align: center;
    padding-bottom: 50px;
}

@media (max-width: 991px)
{
#mobile-menu {
    position: relative;
    min-height: 1px;
    padding-left: 15px;
    padding-right: 15px;
    margin-top: 15px;
}
#mobile-menu > select {
    display: block;
}

#desktop-menu {
    display: none;
}
 
}


</style>


<!-- <div class="row">
    <div class="col col-sm-2">
        <a class="btn btn-block btn-primary padding-top-xlg padding-bottom-xlg" href="<?php echo $this->createUrl('/idea') ?>">IDEA<br /><small>&nbsp;</small></a>
    </div>
    <div class="col col-sm-2">
        <a class="btn btn-block btn-white padding-top-xlg padding-bottom-xlg" href="">Resource<br /><small class="text-muted">(coming soon)</small></a>
    </div>
    <div class="col col-sm-2">
        <a class="btn btn-block btn-white padding-top-xlg padding-bottom-xlg" href="">Job Vacancy<br /><small class="text-muted">(coming soon)</small></a>
    </div>
    <div class="col col-sm-2">
        <a class="btn btn-block btn-white padding-top-xlg padding-bottom-xlg" href="">Mentor Booking<br /><small class="text-muted">(coming soon)</small></a>
    </div>
    <div class="col col-sm-2">
        <a class="btn btn-block btn-white padding-top-xlg padding-bottom-xlg" href="">Profile<br /><small class="text-muted">(coming soon)</small></a>
    </div>
</div> -->




<div class="page-container page-central">
<div class="banner overlay-primary" style="background-image: url(<?php echo Yii::app()->params['masterUrl']?>/legacy/2016/02/971A3090-2220x800-c-default.jpg)">
<div class="hover-txt">
<br>
<h1>MaGIC Central</h1>
<p>MaGIC Central provides advisory and information on entrepreneurship as well as facilitation with collaborating agencies. It is a useful platform for those undertaking entrepreneurship path and seeking answer for their enquiries</p>
</div>
</div>

<div class="companies-logo-color hidden">
<div class="title-bar">
<p class="text-muted pull-left">OUR PARTNERS</p>
<div style="padding-left: 65px;"><hr></div>
</div>
<section> <div class="logo">
<a href="http://resource.mymagic.my/startup/company/magic-malaysian-global-innovation-creativity-centre/#sthash.kTrZc9lW.dpbs" target="_blank"><img src="<?php echo Yii::app()->params['masterUrl']?>/legacy/2015/04/magic_logo1.jpg"></a>
</div>
<div class="logo">
<a href="http://resource.mymagic.my/startup/company/cradle-fund/#sthash.9lbDFyPn.dpbs" target="_blank"><img src="<?php echo Yii::app()->params['masterUrl']?>/legacy/2015/04/cradle_logo.png"></a>
</div>
<div class="logo">
<a href="http://resource.mymagic.my/startup/company/unit-peneraju-agenda-bumiputra-teraju/#sthash.Do2LDBAe.dpbs" target="_blank"><img src="<?php echo Yii::app()->params['masterUrl']?>/legacy/2015/04/teraju.jpg"></a>
</div>
<div class="logo">
<a href="http://resource.mymagic.my/startup/company/mdv-malaysia-debt-ventures-berhad/" target="_blank"><img src="<?php echo Yii::app()->params['masterUrl']?>/legacy/2015/04/mdv.jpg"></a>
</div>
<div class="logo">
<a href="http://resource.mymagic.my/startup/company/mdec-multimedia-development-corporation/#sthash.5U3EhfMa.dpbs" target="_blank"><img src="<?php echo Yii::app()->params['masterUrl']?>/legacy/2015/04/mdec.jpg"></a>
</div>
<div class="logo">
<a href="http://resource.mymagic.my/startup/company/mavcap-malaysia-venture-capital-management-berhad/#sthash.ghNBw4Pk.dpbs" target="_blank"><img src="<?php echo Yii::app()->params['masterUrl']?>/legacy/2015/04/mavcap.jpg"></a>
</div>
</section><section> <div class="logo">
<a href="http://resource.mymagic.my/startup/company/myipo-malaysian-intellectual-property-company/#sthash.HEoZgNt1.dpbs" target="_blank"><img src="<?php echo Yii::app()->params['masterUrl']?>/legacy/2015/04/myipo.jpg"></a>
</div>
<div class="logo">
<a href="http://resource.mymagic.my/startup/company/biotech-corp-malaysian-biotechnology-corporation-sdn-bhd/#sthash.s6DtCvdO.dpbs" target="_blank"><img src="<?php echo Yii::app()->params['masterUrl']?>/legacy/2015/04/biotech.jpg"></a>
</div>
<div class="logo">
<a href="http://resource.mymagic.my/startup/company/tpm-technology-park-malaysia/" target="_blank"><img src="<?php echo Yii::app()->params['masterUrl']?>/legacy/2015/07/TPM-logo.jpeg"></a>
</div>
<div class="logo">
<a href="http://resource.mymagic.my/startup/company/sirim-berhad/#sthash.LdpCNemS.dpbs" target="_blank"><img src="<?php echo Yii::app()->params['masterUrl']?>/legacy/2015/04/sirim.jpg"></a>
</div>
<div class="logo">
<a href="http://resource.mymagic.my/startup/company/pns-perbadanan-nasional-berhad/#sthash.zUDNF5uH.dpbs" target="_blank"><img src="<?php echo Yii::app()->params['masterUrl']?>/legacy/2015/04/pns.jpg"></a>
</div>
<div class="logo">
<a href="http://resource.mymagic.my/startup/company/ssm-companies-commission-of-malaysia/#sthash.Rb9yvU8D.dpbs" target="_blank"><img src="<?php echo Yii::app()->params['masterUrl']?>/legacy/2015/04/ssm.jpg"></a>
</div>
</section><section> <div class="logo">
<a href="http://resource.mymagic.my/startup/company/aim-amanah-ikhtiar-malaysia/#sthash.B9n205u2.dpbs" target="_blank"><img src="<?php echo Yii::app()->params['masterUrl']?>/legacy/2015/04/amanah.jpg"></a>
</div>
<div class="logo">
<a href="http://resource.mymagic.my/startup/company/fama-federal-agricultural-marketing-authority/#sthash.qzqi1QzH.dpbs" target="_blank"><img src="<?php echo Yii::app()->params['masterUrl']?>/legacy/2015/04/fama.jpg"></a>
</div>
<div class="logo">
<a href="http://resource.mymagic.my/startup/company/cgc-credit-guarantee-corporation-malaysia-berhad/#sthash.b260FTu4.dpbs" target="_blank"><img src="<?php echo Yii::app()->params['masterUrl']?>/legacy/2015/05/cgc.jpg"></a>
</div>
<div class="logo">
<a href="http://resource.mymagic.my/startup/company/sme-bank-berhad/#sthash.D9TP1F6V.dpuf" target="_blank"><img src="<?php echo Yii::app()->params['masterUrl']?>/legacy/2015/05/smebank2.jpg"></a>
</div>
<div class="logo">
<a href="http://resource.mymagic.my/startup/company/bsn-bank-simpanan-nasional/#sthash.0qppo9KE.dpbs" target="_blank"><img src="<?php echo Yii::app()->params['masterUrl']?>/legacy/2016/01/bsn.png"></a>
</div>
<div class="logo">
<a href="http://resource.mymagic.my/startup/company/might-malaysian-industry-government-group-for-high-technology/#sthash.ZSjjsBIh.dpbs" target="_blank"><img src="<?php echo Yii::app()->params['masterUrl']?>/legacy/2016/01/might.png"></a>
</div>
</section><section> <div class="logo">
<a href="http://resource.mymagic.my/startup/company/kmp-kumpulan-modal-perdana/#sthash.sgECpzvd.dpuf" target="_blank"><img src="<?php echo Yii::app()->params['masterUrl']?>/legacy/2016/02/kmp.png"></a>
</div>
<div class="logo">
<a href="http://resource.mymagic.my/startup/company/malaysian-green-technology-corporation-greentech-malaysia/#sthash.wbjbOqp1.dpbs" target="_blank"><img src="<?php echo Yii::app()->params['masterUrl']?>/legacy/2016/02/greentech.png"></a>
</div>
<div class="logo">
<a href="http://resource.mymagic.my/startup/company/bank-rakyat/#sthash.45uS5VnG.dpuf" target="_blank"><img src="<?php echo Yii::app()->params['masterUrl']?>/legacy/2016/02/bankrakyat.png"></a>
</div>
<div class="logo">
<a href="http://resource.mymagic.my/startup/program/institut-keusahawanan-negara-insken/" target="_blank"><img src="<?php echo Yii::app()->params['masterUrl']?>/legacy/2016/03/insken.png"></a>
</div>
<div class="logo">
<a href="http://www.sarawak.gov.my/" target="_blank"><img src="<?php echo Yii::app()->params['masterUrl']?>/legacy/2016/03/upuih.png"></a>
</div>
<div class="logo">
<a href="http://resource.mymagic.my/startup/company/sarawak-economic-development-corporation-sedc/" target="_blank"><img src="<?php echo Yii::app()->params['masterUrl']?>/legacy/2016/03/sedc.png"></a>
</div>
</section><section> <div class="logo">
<a href="http://resource.mymagic.my/startup/company/punb-perbadanan-usahawan-nasional-berhad/" target="_blank"><img src="<?php echo Yii::app()->params['masterUrl']?>/legacy/2016/03/punb.png"></a>
</div>
<div class="logo">
<a href="https://www.google.com/url?q=http://resource.mymagic.my/startup/company/platcom-ventures/" target="_blank"><img src="<?php echo Yii::app()->params['masterUrl']?>/legacy/2016/03/platcom.png"></a>
</div>
<div class="logo">
<a href="http://resource.mymagic.my/startup/company/cyberview-sdn-bhd/" target="_blank"><img src="<?php echo Yii::app()->params['masterUrl']?>/legacy/2016/03/cyberview.png"></a>
</div>
<div class="logo">
<a href="http://resource.mymagic.my/startup/company/mara-majlis-amanah-rakyat/" target="_blank"><img src="<?php echo Yii::app()->params['masterUrl']?>/legacy/2016/03/mara.png"></a>
</div>
<div class="logo">
<a href="http://uam.org.my/" target="_blank"><img src="<?php echo Yii::app()->params['masterUrl']?>/legacy/2016/03/uam.png"></a>
</div>
<div class="logo">
<a href="http://resource.mymagic.my/startup/company/kpdnkk-ministry-of-domestic-trade-cooperatives-and-consumerism/" target="_blank"><img src="<?php echo Yii::app()->params['masterUrl']?>/legacy/2016/03/kpdnkk.png"></a>
</div>
</section><section> <div class="logo">
<a href="http://resource.mymagic.my/startup/company/sme-corp-sme-corporation-malaysia/#sthash.K9ysFhHC.dpbs" target="_blank"><img src="<?php echo Yii::app()->params['masterUrl']?>/legacy/2016/03/smecorp.png"></a>
</div>
<div class="logo">
<a href="http://resource.mymagic.my/startup/company/matrade-malaysia-external-trade-development-corporation/" target="_blank"><img src="<?php echo Yii::app()->params['masterUrl']?>/legacy/2016/03/matrade.png"></a>
</div>
<div class="logo">
<a href="http://resource.mymagic.my/startup/company/mida-malaysian-investment-development-authority/" target="_blank"><img src="<?php echo Yii::app()->params['masterUrl']?>/legacy/2016/03/mida.png"></a>
</div>
<div class="logo">
<a href="http://resource.mymagic.my/startup/company/midf-malaysian-industrial-development-finance-berhad/" target="_blank"><img src="<?php echo Yii::app()->params['masterUrl']?>/legacy/2016/03/midf.png"></a>
</div>
<div class="logo">
<a href="http://resource.mymagic.my/startup/company/mpc-malaysia-productivity-corporation/" target="_blank"><img src="<?php echo Yii::app()->params['masterUrl']?>/legacy/2016/03/mpc.png"></a>
</div>
</section></div>
<div class="central-content">
<div class="title-bar">
<p class="text-muted pull-left">WAYS TO USE MAGIC CENTRAL</p>
<div style="padding-left: 65px;"><hr></div>
</div>
<div class="tease-list-3">
<div class="clearfix">
<article class="tease tease-page" id="tease-17">
<div class="image">
<img src="<?php echo Yii::app()->params['masterUrl']?>/legacy/2015/01/resourcetool-icon-v2-700x400-c-center.jpg">
<div class="hover-actions">
<a href="http://resources.mymagic.my/" class="btn btn-sd btn-sd-green btn-sm">Explore Resource Directory</a>
</div>
</div>
<div class="text">
<h5 class="text-title"><a href=""><strong>Resource Directory</strong></a></h5>
<p>Explore comprehensive collection of over 700 products &amp; services from over 180 organisations available for entrepreneurs</p>
</div>
</article>
<article class="tease tease-page" id="tease-17">
<div class="image">
<img src="<?php echo Yii::app()->params['masterUrl']?>/legacy/2015/04/img3-700x400-c-center.png">
<div class="hover-actions">
<a href="<?php echo $this->createUrl('/forum') ?>" class="btn btn-sd btn-sd-green btn-sm">Enter Q&amp;A Forum</a>
</div>
</div>
<div class="text">
<h5 class="text-title"><a href=""><strong>Q&amp;A Forum</strong></a></h5>
<p>A virtual forum where you can post questions related to entrepreneurship and have it answered</p>
</div>
</article>
<article class="tease tease-page" id="tease-17">
<div class="image">
<img src="<?php echo Yii::app()->params['masterUrl']?>/legacy/2015/04/img4-700x400-c-center.png">
<div class="hover-actions">
<a href="<?php echo $this->createUrl('/mentor') ?>" class="btn btn-sd btn-sd-green btn-sm">Book Appointment</a>
</div>
</div>
<div class="text">
<h5 class="text-title"><a href=""><strong>Mentorship</strong></a></h5>
<p>Book appointment to seek advice from MaGIC and collaborating agencies either via Video Call or physical meet-up</p>
</div>
</article> </div>
</div>
<div class="title-bar">
<p class="text-muted pull-left">FEEDBACK</p>
<div style="padding-left: 90px;"><hr></div>
</div>
<div class="feedback-text">
<h2><strong>Have You Tried MaGIC Central?<br>Please share with us your suggestions and experience.</strong></h2>
<br>
<a href="https://docs.google.com/a/mymagic.my/forms/d/1icOfJvRHNfNsHGhyNj_GRsWEFVuJdNcNgJOuesfqJnU/viewform" target="_blank"><div class="btn btn-sd btn-sd-green"><strong>SUBMIT FEEDBACK</strong></div></a>
</div>
</div>
</div>