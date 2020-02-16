<?php
$this->breadcrumbs=array(
    'Activity Feed'
);
$this->renderPartial('/cpanel/_menu',array('model'=>$model,));

// for($year=date('Y'); $year>2014; $year--) $year_array[] = $year;
$year_array = [2019, 2018, 2017, 2016, 2015, 2014];

?>
<style type="text/css">

/* Start by setting display:none to make this hidden.
   Then we position it in relation to the viewport window
   with position:fixed. Width, height, top and left speak
   for themselves. Background we set to 80% white with
   our animation centered, and no-repeating */
.modal-load {
    display:    none;
    position:   absolute;
    z-index:    60;
    top:        0;
    left:       0;
    height:     100%;
    width:      100%;
    background: rgba( 255, 255, 255, .7 ) 
                url(masterUrl+'/images/loader.gif') 
                50% 10% 
                no-repeat;
}

/* When the body has the loading class, we turn
   the scrollbar off with overflow:hidden */
body.loading {
    overflow: hidden;   
}

/* Anytime the body has the loading class, our
   modal element will be visible */
body.loading .modal-load {
    display: block;
}

</style>
<div class="sidebard-panel left-bar">
    <div id="header">
        <h2>Activity Feed
            <span class="hidden-desk">
            <a class="container-arrow scroll-to" href="#">
                <span><i class="fa fa-angle-down" aria-hidden="true"></i></span>
            </a></span>
        </h2>
        <h4>Keeping track of your milestones and news of your selected services</h4>
    </div>
    <div id="content-services">
        <h4 style="text-transform: uppercase;margin-left:30px;font-weight: 700;">Filter</h4>
        <div class="filter-activity">
           <div class="layer1">
                <p class="heading-filter">Year <span class="fa fa-chevron-right rotate down"></span></p>
                <div class="content">  
                    <div class="set-group">
                    <?php foreach ($year_array as $y): ?>
                      <label class="set set--checkbox"> <?php echo $y ?>
                        <input type="checkbox" name="year" value="<?php echo $y ?>" <?php echo $y == $years ? 'checked' : ''?>/>
                        <div class="set__indicator radio_year"></div>
                      </label>
                    <?php endforeach; ?>
                    </div>
                 </div>
                 <p class="heading-filter">Services <span class="fa fa-chevron-right rotate down"></span></p>
                <div class="content">  
                    <div class="set-group">
                      <?php foreach ($serviceList as $s): ?>
                      <label class="set set--checkbox"><?php echo $s['title']?>
                        <input type="checkbox" name="service[]" value="<?php echo $s['slug']; ?>" <?php echo in_array($s['slug'], $services) ? 'checked' : ''?>/>
                        <div class="set__indicator"></div>
                      </label>
                      <?php $count++; endforeach; ?>

                    </div>
                </div>
<!--                 <p class="heading-filter">Company <span class="fa fa-chevron-right rotate"></span></p>
                <div class="content">    
                   <div class="set-group">
                      <?php $count=0; foreach($userOrg['organizations']['approve'] as $organization): ?>
                      <label class="set set--checkbox"><?php echo $organization->title ?>
                        <input type="checkbox"/>
                        <div class="set__indicator"></div>
                      </label>
                      <?php $count++; endforeach; ?>
                    </div>
                </div> -->
             </div>

        </div>
    </div>
</div>
<div id="mainDiv">

    <div class="wrapper wrapper-content content-bg content-left-padding" id="refreshDiv">
        <div class="row example-split">
        <!-- <div class="col-md-12 example-title">
            <h2>Timeline</h2>
        </div> -->
        <?php if(!empty($model)): ?>
        <div class="col-xs-10 col-md-10 col-xs-offset-1 col-sm-8">

            <?php foreach ($model as $day=>$timeline): ?>
            <ul class="timeline timeline-split">
                <li class="timeline-item period">
                    <div class="timeline-info"></div>
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h3 class="timeline-title"><?php echo $day ?></h3>
                    </div>
                </li>
                <?php foreach ($timeline as $time=>$timelineData): ?>
                    <?php foreach ($timelineData as $data): ?>
                        <li class="timeline-item">
                            <div class="timeline-info">
                                <span><?php echo $time ?></span>
                            </div>
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h3 class="timeline-title"><span class="label label-default service-title-tag"><?php echo ucfirst($data['serviceTitle']) ?></span></h3>
                                <p><?php echo $data['msg'] ?></p>
                                <?php if(!empty($data['actionUrl'])): ?>
                                <a class="btn btn-sd btn-sd btn-sd-green btn-view-af" target="_blank" href="<?php echo $data['actionUrl'] ?>"><?php echo $data['actionLabel'] ?></a>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </ul>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
            <div class="col-xs-10 col-md-10 col-xs-offset-1 col-sm-8">
                <h4>No result found.</h4>
            </div>
        <?php endif; ?>

    </div>

    </div>
    

</div>
<div class="modal-load"></div>
<script type="text/javascript">

//toggle the componenet with class msg_body
$(".heading-filter").click(function() {
    $(this).find("> .rotate").toggleClass("down"); 
    $(this).next(".content").slideToggle(300);
});

$body = $("body");

$(document).on({
    ajaxStart: function() { $body.addClass("loading");    },
    ajaxStop: function() { $body.removeClass("loading"); }    
}); 

var oldYear = '';

$(document).ready(function(){
   oldYear = $('input[name="year"]:checked').val();
});

$('input[name="year"], [name="service[]"]').click(function(e){
    var yearSelected = '';
    var serviceSelected = [];
    
    if(e.target.name == "year") {
        $('input[name="year"][value="'+oldYear+'"]').removeAttr('checked');
    }
    yearSelected = $('input[name="year"]:checked').val();
    oldYear = yearSelected;
    $('input[name="service[]"]:checked').each(function() {
        serviceSelected.push($(this).val());
    });
    serviceSelected = serviceSelected.filter(function(v){return v!==''});
    partialRefresh(yearSelected, serviceSelected);
});

function partialRefresh( year, serviceArray ) {
    var appendURL = '';
    if(year) {
        appendURL += '?year='+year;
    }
    if(serviceArray.length !== 0){
        appendURL += appendURL == '' ? '?service[]=' + serviceArray.join("&") : '&service[]=' + serviceArray.join("&service[]=");
    }
    $('#mainDiv').load(window.location.origin + window.location.pathname + appendURL +  ' #refreshDiv');
    //window.location.href = window.location.origin + window.location.pathname + refreshDiv ;
}

</script>