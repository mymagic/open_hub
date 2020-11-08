<?php date_default_timezone_set('Asia/Kuala_Lumpur'); ?>

<div class="section"><div class="w-container">
  <h1 class="title">Event Registration</h1>
  <?php if (!Yii::app()->user->isGuest): ?>
    <h4 class="title nopadding">You&#x27;re registering for</h4>
    <h5 class="title"> <span class="text-span"><?php echo HUB::getSessionUsername(); ?></span><br></h5>
  <?php endif; ?>
  <!-- event-card -->
  <div class="event-card">
  
    <h3 class="title"><?php echo $event->title; ?></h3>

    <?php if (date('d F Y', $event->date_started) == date('d F Y', $event->date_ended)):?>
    <h5 class="title">Date: <?php echo date('d F Y', ysUtil::convertTimezone($event->date_started, $event->jsonArray_original->start->timezone, 'GMT')); ?><br></h5>
    <?php endif; ?>
    <?php if (date('d F Y', $event->date_started) != date('d F Y', $event->date_ended)):?> 
    <h5 class="title">Date: <?php echo date('d F Y', ysUtil::convertTimezone($event->date_started, $event->jsonArray_original->start->timezone, 'GMT')); ?> - <?php echo date('d F Y', ysUtil::convertTimezone($event->date_ended, $event->jsonArray_original->end->timezone, 'GMT')); ?><br></h5>
    <?php endif; ?>

    <h5 class="title">Time: <?php echo date('h:iA', ysUtil::convertTimezone($event->date_started, $event->jsonArray_original->start->timezone, 'GMT')); ?> - <?php echo date('h:iA', ysUtil::convertTimezone($event->date_ended, $event->jsonArray_original->end->timezone, 'GMT')); ?> (<?php echo ysUtil::timezone2offset($event->jsonArray_original->end->timezone); ?> TZ)<br></h5>

    <h5 class="title">Venue: <?php echo $event->full_address; ?><br></h5>
    <div class="short-gnome no-float">
      <div class="gnome-blue"></div>
      <div class="gnome-orange"></div>
      <div class="gnome-red"></div>
    </div>
  </div>
  <!-- /event-card -->

  <?php if (!Yii::app()->user->isGuest): ?>
    <h5 class="title">Kindly use the same email when registering for programmes, events and initiatives across this platform.<br></h5>
  <?php endif; ?>

</div></div>

<div class="section-2"><div class="w-container">
    
    <div style="width:100%; text-align:left;"><iframe src="https://eventbrite.com/tickets-external?eid=<?php echo $event->code; ?>&ref=etckt" frameborder="0" height="360" width="100%" vspace="0" hspace="0" marginheight="5" marginwidth="5" scrolling="auto" allowtransparency="true"></iframe><div style="font-family:Helvetica, Arial; font-size:12px; padding:10px 0 5px; margin:2px; width:100%; text-align:left;" ><a class="powered-by-eb" style="color: #ADB0B6; text-decoration: none;" target="_blank" href="https://www.eventbrite.com/">Powered by Eventbrite</a></div></div>
  
</div></div>

<?php Yii::app()->clientScript->registerCss('eventbrite-register', '
.event-card {
  position: relative;
  width: 50%;
  height: auto;
  margin-bottom: 20px;
  padding: 0px 30px 15px;
  border: 1px solid #f4f4f4;
  box-shadow: 0 0 16px 10px rgba(0, 0, 0, .03);
}

.short-gnome.no-float {
  left: 0px;
  top: 0px;
}


.text-span {
  padding: 2px 5px;
  border-radius: 3px;
  background-color: #66ab44;
  color: #fff;
  font-weight: 400;
}

.section {
  padding-top: 40px;
  padding-bottom: 30px;
  border-bottom: 1px solid #e4e4e4;
  box-shadow: inset 0 0 45px -40px #000;
}

.section-2 {
  padding-bottom: 60px;
  padding-top: 30px;
}

.w-container {
  margin-left: auto;
  margin-right: auto;
  max-width: 940px;
}

.widget-container {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  height: 100px;
  -webkit-box-pack: center;
  -webkit-justify-content: center;
  -ms-flex-pack: center;
  justify-content: center;
  -webkit-box-align: center;
  -webkit-align-items: center;
  -ms-flex-align: center;
  align-items: center;
  border: 1px dashed #000;
  background-color: #f3f3f3;
}

@media (max-width: 991px) {
  .event-card {
    width: 100%;
  }
}

@media (max-width: 767px) {
  .title {
    margin-right: 10px;
    /*margin-left: 10px;*/
  }
  .event-card {
    width: auto;
    margin-right: 10px;
    margin-left: 10px;
  }
}

@media (max-width: 479px) {
  .event-card {
    padding-right: 15px;
    padding-left: 15px;
  }
  .section {
    padding-bottom: 20px;
  }
  .section-2 {
    padding-right: 10px;
    padding-left: 10px;
  }
}

.widget-main-view{background:white;}
') ?>