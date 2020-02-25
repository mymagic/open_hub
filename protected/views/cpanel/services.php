<?php
$this->breadcrumbs = array(
	'Services'
);
$this->renderPartial('/cpanel/_menu', array('model' => $model, ));
?>

    <div class="sidebard-panel left-bar">
        <div id="header">
            <h2>Services<span class="hidden-desk">
                <a class="container-arrow scroll-to" href="#">
                    <span><i class="fa fa-angle-down" aria-hidden="true"></i></span>
                </a></span>
            </h2>
            <h4>List of services available</h4>

        </div>
        
        <div id="content-services">
            <?php if (!empty($selected_service_list)) {
	foreach ($selected_service_list as $row) {
		$target_div = '';

		switch ($row['service']['slug']) {
						case 'activate':
							$target_div = 'activate-link';
							$description = 'A collaborative platform for startups and corporates to find innovative solutions for real life challenges!';
						break;
						case 'idea':
							$target_div = 'accre-link';
							$description = 'Gain access and procurement from private and public sectors by accrediting your startup as an impact driven enterprise!';
						break;
						case 'mentor':
							$target_div = 'mentor-link';
							$description = 'Seek support and advice from available mentors or give back by being a mentor yourself!';
						break;
						case 'resource':
							$target_div = 'dir-link';
							$description = 'A comprehensive collection of products and services from public and private organisations available for entrepreneurs! You can even add your own service offerings!';
						break;
						case 'atas':
							$target_div = 'ats-link';
							$description = 'Accelerator Tracking and Application System for GAP';
						break;
					} ?>
            <a id="<?php echo $target_div; ?>" class="service-link" href="#">
                <div class="m-t-md pad-30 services-box">
                    <h4><?php echo $row['service']['title']; ?></h4>
                    <h5> <?php echo $description ?></h5> 
                </div>
            </a>
            <?php
	}
}?>
            <div class="add-services hidden">
              <a id="addServiceBtn" class="add-sv-btn">Add Services</a>
            </div>
        </div>
    </div>

<div class="wrapper wrapper-content content-bg content-left-padding">
    <div id="service-content" class="row">
       <!--  <h2 style="margin-top: 15px; margin-left: 40px;max-width: 700px;margin-right: 50px;">You can click on each service to discover more details</h2>
        <p style="margin-left: 40px;max-width: 700px;margin-right: 50px;"></p> -->

    </div>
  <div id="accre-content" class="hideme row">
      <div class="col-lg-12">
        <h2 style="margin-top: 15px; margin-left: 40px;max-width: 700px;margin-right: 50px;">Impact Driven Enterprise Accreditation</h2>
           <p style="margin-top: 41px; margin-left: 40px;max-width: 700px;margin-right: 50px;">
            MaGIC’s Impact Driven Enterprise Accreditation (IDEA) Program aims to create systemic shift by involving private and public sectors to drive social procurement as part of their activities
          </p>
          <div style="margin-top: 41px; margin-left: 40px;max-width: 700px;margin-right: 50px;">
          <h2>Impact Driven Enterprise Accreditation</h2>
            <p>Impact Driven Enterprise Accreditation (IDEA) is the means of validating and legally recognising the fantastic work that impact driven companies are doing across Malaysia. Accreditation as an IDE grants you a competitive leverage, helping potential partners find and engage you for business.</p>

            <p>The IDEA platform registers partners from both private and public sectors, industry leaders that are looking to impart positive change on society.</p>

            <p>IDEA envisions helping you scale to new heights by becoming part of a systemic change driving our nation towards an inclusive economy.</p>
            <br>
          <h2>Social Procurement</h2>
            <p>Social procurement is a tool capable of bringing about positive systemic change for people in need. It ensures that organisational decisions to purchase are motivated not only by price economics but also by equally important social and environmental factors. </p>

            <p>At IDEA, we make social procurement easy by connecting you directly to impact enterprises that have been vetted by MaGIC, one of the leading authorities in impact entrepreneurship in Malaysia. </p>
        </div>
        <div class="cta-services">
          <a class="btn btn-sd-ghost btn-sd-ghost-blue" href="<?php echo Yii::app()->createUrl('/idea') ?>">Get Accreditated</a>
        </div>
      </div>

    </div>
    <div id="dir-content" class="hideme row">
      <div class="col-lg-12">
          <h2 style="margin-top: 15px; margin-left: 40px;max-width: 700px;margin-right: 50px;">Resource Directory</h2>
           <p style="margin-top: 41px; margin-left: 40px;max-width: 700px;margin-right: 50px;"> 
           Resource Directory allow user to search for related resources by multiple filter</p>
          <h3 style="margin-top: 41px; margin-left: 40px;max-width: 700px;margin-right: 50px;"> 
          Features:</h3>
        <div class="content__block">
        <ul>
          <li>Public can search for resources like funding, space, programme, awards, legislation and etc</li>
          <li>Public can view the detail of a specific resource after login thru MaGIC Connect</li>
          <li>Resource owner (eg: cradle, cyberview) can manage their own resources after login thru MaGIC Connect</li>
          <li>Admin can manage all resources thru backend</li>
        </ul>
        <div class="cta-services">
        <a class="btn btn-sd-ghost btn-sd-ghost-blue" href="<?php echo Yii::app()->createUrl('/resource') ?>">Explore Resources</a>
      </div>
      </div>
      </div>
    </div>
    <div id="ats-content" class="hideme row">
      <div class="col-lg-12">
          <h2 style="margin-top: 15px; margin-left: 40px;max-width: 700px;margin-right: 50px;">ATAS</h2>
           <p style="margin-top: 41px; margin-left: 40px;max-width: 700px;margin-right: 50px;"> 
           Accelerator Tracking &amp; Application System (ATAS) is a tracking system for MaGIC's Global Accelerator Program (GAP) that streamlines the processes between applicants and account managers during registrations and through an on-going cohort.</p>
          <!-- <p style="margin-top: 41px; margin-left: 40px;max-width: 700px;margin-right: 50px;"> 
          Features:</p>
        <div class="content__block">
        <ul>
          <li>Public can search for resources like funding, space, programme, awards, legislation and etc</li>
          <li>Public can view the detail of a specific resource after login thru MaGIC Connect</li>
          <li>Resource owner (eg: cradle, cyberview) can manage their own resources after login thru MaGIC Connect</li>
          <li>Admin can manage all resources thru backend</li>
        </ul>
        <div class="cta-services">
        <a class="btn btn-sd-ghost btn-sd-ghost-blue" href="<?php echo Yii::app()->createUrl('/resource') ?>">Explore Resources</a>
      </div>
      </div> -->
      <div class="cta-services">
        <a class="btn btn-sd-ghost btn-sd-ghost-blue" href="http://atasbe.mymagic.my">Explore</a>
        
      </div>
      </div>
    </div>
    <div id="mentor-content" class="hideme row">
      <div class="col-lg-12">
        <h2 style="margin-top: 15px; margin-left: 40px;max-width: 700px;margin-right: 50px;">Mentor</h2>
        <p style="margin-top: 41px; margin-left: 40px;max-width: 700px;margin-right: 50px;">   
        The idea is to allow central member to book mentoring session thru the platform where this service are provided by external party: Futurelab. Hence, all the following details are tightly related to Futurelab, and designed base on Futurelab system capability.
        </p>
        <p style="margin-top: 41px; margin-left: 40px;max-width: 700px;margin-right: 50px;">
          There are 2 type of mentoring: public and private.
        </p>
        <div class="cta-services">
        <a class="btn btn-sd-ghost btn-sd-ghost-blue" href="<?php echo Yii::app()->createUrl('/mentor') ?>">Book Your Session</a>
        <a class="btn btn-sd-ghost btn-sd-ghost-blue" href="<?php echo Yii::app()->createUrl('/mentor/frontend/manage') ?>">My Bookings</a>
        
      </div>
      </div>
    </div>
    <div id="activate-content" class="hideme row">
      <div class="col-lg-12">
        <h2 style="margin-top: 15px; margin-left: 40px;max-width: 700px;margin-right: 50px;">Activate</h2>
        <p style="margin-top: 41px; margin-left: 40px;max-width: 700px;margin-right: 50px;">   
        MaGIC Activate is an open innovation challenge platform that supports the innovation of corporates and private sector players by connecting them with a global community of entrepreneurs. The platform is an initiative by MaGIC in partnership with Techstars Startup Program to foster collaboration between corporate innovators and startups/entrepreneurs in line with the promotion of Corporate Entrepreneurship Responsibility (CER) - a national initiative to encourage more private sector involvement in Entrepreneurship Development.
        </p>
        <!-- <p style="margin-top: 41px; margin-left: 40px;max-width: 700px;margin-right: 50px;">
          There are 2 type of mentoring: public and private.
        </p> -->
        <div class="cta-services">
        <a class="btn btn-sd-ghost btn-sd-ghost-blue" href="<?php echo Yii::app()->createUrl('/activate') ?>">Check out Challenges</a>
        
      </div>
      </div>
    </div>

</div>

<div id="sampleModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true" class="skip-btn">Cancel</span>

                </button>
                  <h4 class="modal-title" id="myTitle">Add Services</h4>

            </div>
            <div id="step2"> 

                <div class="modal-body">
                    <?php
						$selected_service_slug_list = array();
						if (!empty($selected_service_list)):
							foreach ($selected_service_list as $service):
								$selected_service_slug_list[] = $service->service->slug;
							endforeach;
						endif;

					?>

                    <h2 class="modal-subtitle">Services Available on MaGIC</h2>
                    <br>
                    <p style="margin-bottom: 20px;">Here are the available services provided by MaGIC. You can add more services to your dashboard.</p>
                      <div class="section group-services">
                      <?php foreach ($service_list as $list): ?>
                          <?php if (!empty($selected_service_list) && in_array($list['slug'], $selected_service_slug_list)) {
						?>
                            <a class="col-services span_1_of_3 button-desc disabled" href="javascript:void(0);" data-slug="<?php echo $list['slug']?>">
                            <span class="service-title"><?php echo $list['title']?></span>
                            </a>
                          <?php
					} else {
						?>
                            <a class="col-services span_1_of_3 button-desc enabled" href="javascript:void(0);" data-slug="<?php echo $list['slug']?>">
                            <span class="service-title"> <?php echo $list['title']?></span>
                            </a>
                          <?php
					} ?>
                      
                    
                  <?php endforeach; ?>
                  </div>
                
                </div>
            </div>
            <div class="submit-service">
            <button class="btn-sd-green" id="submitService">Submit</button>

            </div>
        </div>
    </div>
</div>




<script type="text/javascript">
  $(function() {
   // don't cache ajax or content won't be fresh
   $.ajaxSetup({
      cache: false
   });
   // var ajax_load = "<img id='loader' class='loader' src='http://gifimage.net/wp-content/uploads/2017/08/loading-gif-transparent-4.gif' />";

   // load() functions
   
  function hideContents() {
    $('#accre-content').hide();
    $('#corp-content').hide();
    $('#dir-content').hide();
    $('#mentor-content').hide();
    $('#activate-content').hide();
    $('#ats-content').hide();
    
  }
   
   $(document).ready(function() {
      hideContents();
      $("#content-services a").first().addClass("active").click();

   });


    $("#accre-link").click(function(){
      hideContents();
      $('#content-services a').removeClass('active');
      $(this).addClass('active');

         // $("#service-content").html(ajax_load);
         $("#service-content").fadeIn('200', function() {
            $("#loader").hide();
            $('#accre-content').fadeIn();
         });


     


   });
    $("#corp-link").click(function(){
    hideContents();
      $('#content-services a').removeClass('active');
      $(this).addClass('active');

         // $("#service-content").html(ajax_load);
         $("#service-content").fadeIn('200', function() {
            $("#loader").hide();
            $('#corp-content').fadeIn();
         });





   });

    $("#dir-link").click(function(){
    hideContents();
      $('#content-services a').removeClass('active');
      $(this).addClass('active');

         // $("#service-content").html(ajax_load);
         $("#service-content").fadeIn('200', function() {
            $("#loader").hide();
            $('#dir-content').fadeIn();
         });


   



   });

    $("#mentor-link").click(function(){
    hideContents();
      $('#content-services a').removeClass('active');
      $(this).addClass('active');

         // $("#service-content").html(ajax_load);
         $("#service-content").fadeIn('200', function() {
            $("#loader").hide();
            $('#mentor-content').fadeIn();
         });


 



   });

    $("#activate-link").click(function(){
    hideContents();
      $('#content-services a').removeClass('active');
      $(this).addClass('active');

     
         // $("#service-content").html(ajax_load);
         $("#service-content").fadeIn('200', function() {
            $("#loader").hide();
            $('#activate-content').fadeIn();
         });





   });
  $("#ats-link").click(function(){
    hideContents();
      $('#content-services a').removeClass('active');
      $(this).addClass('active');

     
         // $("#service-content").html(ajax_load);
         $("#service-content").fadeIn('200', function() {
            $("#loader").hide();
            $('#ats-content').fadeIn();
         });





   });

   // end  
});
</script>

<script type="text/javascript">
    $(function () {

        $(".col-services.enabled").click(function () {
            $(this).toggleClass("active");
            e.preventDefault(); /*ignores actual link*/
        });

    });

</script>

<script type="text/javascript">
  $("#addServiceBtn").click(function () {
    $("#sampleModal").fadeIn('fast', function() {
        $(this).modal('show');

    });  
          
  });

  $("#submitService").click(function () {
        
        var selected_service = [];
        $("#sampleModal").find("#step2 .group-services a.enabled").each(function(k,v){
            if($(this).hasClass("active"))
            {
                selected_service.push($(this).data("slug"));
            }
        });
        
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('cpanel/setUserService'); ?>',
            data:{'<?php echo Yii::app()->request->csrfTokenName; ?>':'<?php echo Yii::app()->request->csrfToken; ?>', selected_service:selected_service},
            success:function(data)
            {
                var result = JSON.parse(data);
                if(result.status == 1)
                {

                        $("#sampleModal").modal("hide");
                        window.location.href = '/cpanel/services';
 
                }
                else
                {
                    alert(result.message);
                }
            }
        });
    });

</script>