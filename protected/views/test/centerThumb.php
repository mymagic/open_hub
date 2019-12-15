<style>

.thumbContainer 
{
    width: 150px;
    height: 150px;
    border:2px solid red;
    background:yellow;
    text-align:center;
    margin:1em;
    overflow:hidden;
}

.thumbContainer span{
    width:100%;
    height:100%;
    justify-content: center;
    display: flex;
    align-items: center;
}

.thumbContainer img{
  margin: 0 auto;
  max-width:100%;
  max-height:100%;
  object-position: 50% 50%;
  object-fit: fill !important;

}

.fitFill {
  object-fit: fill
}

.fitContain {
  object-fit: contain
}

.fitCover {
  object-fit: cover
}

.fitNone {
  object-fit: none
}

.fitScaleDown {
  object-fit: scale-down
}
</style>


<div class="" style="background:green">
<div class="thumbContainer">
<span><img src="https://mymagic-hub.s3.amazonaws.com/uploads/organization/thumbnail/ee6834dc9d86f5fb17b16c4b4aaadf289b2711d7.resize.80x80.jpg" />
</span></div>

<div class="thumbContainer">
<span><img src="https://mymagic-hub.s3.amazonaws.com/uploads/organization/thumbnail/57a1d1b8018530c5fa410ad8d7f6f14232d04991.resize.320x320.png" />
</span></div>

<div class="thumbContainer">
<span><img src="https://mymagic-hub.s3.amazonaws.com/uploads/organization/thumbnail/0456d643b4dfd24a2e2fe08ffbbf4d9fe0f19961.resize.320x320.jpg" />
</span></div>

<hr />
<p>Html::thumb($imageUrl, $htmlOptions=array(), $imageUrlFull='', $altTitle='', $galleryCode='')</p>

<?php echo Html::thumb("https://mymagic-hub.s3.amazonaws.com/uploads/organization/thumbnail/57a1d1b8018530c5fa410ad8d7f6f14232d04991.resize.320x320.png") ?>

<?php echo Html::thumb("https://mymagic-hub.s3.amazonaws.com/uploads/organization/thumbnail/0456d643b4dfd24a2e2fe08ffbbf4d9fe0f19961.resize.320x320.jpg") ?>

</div>