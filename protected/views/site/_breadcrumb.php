<div class="full-width-false">
<p class="content__breadcrumbs"><span xmlns:v="http://rdf.data-vocabulary.org/#"><span typeof="v:Breadcrumb">

<span class="" title="Home">
<?php if($home2Icon): ?>
<a href="//mymagic.my">
    <svg width="28" height="18">
        <symbol id="SmallLogoB" class="small_logo" viewBox="0 0 80.5 47.7">
        <path class="st0" d="M27,25.1c1.7-1.7,1.9-4,0.8-5.9L12,3.4L11.6,3c-1.8-1.8-3-3-5.8-3C2.5,0,0,2.7,0,6.3v16.4
        c0.7,1.7,2.3,3.2,4.4,3.2c2.1,0,3.9-1.2,4.6-3.1v-9.2l12.1,12.1C22.9,26.8,25.3,26.8,27,25.1"></path>
        <path class="st1" d="M4.4,25.9c-2.1,0-3.7-1.4-4.4-3.2v20.3c0,2.2,1.8,4.6,4.4,4.6c2.6,0,4.6-2,4.6-4.6V22.8
        C8.3,24.7,6.6,25.9,4.4,25.9"></path>
        <path class="st2" d="M53.3,25c-1.7-1.6-1.6-4.1-0.7-5.8L40.2,31.6L27.8,19.2c1.1,1.9,0.8,4.2-0.8,5.9c-1.7,1.7-4.2,1.6-5.9,0.6
        L36,40.6c1.2,1.2,2.8,2,4.4,2c1.9,0,3.6-1.5,4.2-2.1l14.7-14.7C57.4,26.9,55,26.7,53.3,25"></path>
        <path class="st3" d="M75.9,25.9c-2.1,0-3.7-1.4-4.4-3.1v20.3c0,2.6,2,4.6,4.6,4.6c2.6,0,4.4-2.4,4.4-4.6V22.8
        C79.7,24.7,78,25.9,75.9,25.9"></path>
        <path class="st4" d="M75.9,25.9c2.1,0,3.9-1.2,4.6-3.1V6.3c0-3.7-2.3-6.3-5.7-6.3c-2.9,0-4.3,1.4-6.3,3.4L52.6,19.2
        c-1,1.8-1,4.2,0.7,5.8c1.7,1.7,4.1,1.9,6,0.8l12.1-12.1v9.1C72.1,24.5,73.7,25.9,75.9,25.9"></path>
        </symbol>
        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#SmallLogoB"></use>
    </svg>
</a></span>
<?php else: ?>
<?php echo Html::link('Home', '//mymagic.my') ?>
<?php endif; ?>
</span>

<?php $total=count($this->breadcrumbs); $count=0; foreach($this->breadcrumbs as $key=>$breadcrumb): ?>
/ 
<span class="<?php echo (($count==$total-1))?'breadcrumb_last':''?>"><?php if(!is_numeric($key)): ?><?php echo  Html::link($key, $breadcrumb) ?><?php else: ?><?php echo $breadcrumb ?><?php endif; ?></span>
<?php $count++; endforeach; ?>
</span></span></p>
</div>