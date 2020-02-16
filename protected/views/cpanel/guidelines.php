<?php
$this->breadcrumbs=array(
    'Guidelines'
);
$this->renderPartial('/cpanel/_menu',array('model'=>$model,));

?>

<div class="sidebard-panel left-bar">
    <div id="header">
        <h2>Guidelines
        	<span class="hidden-desk">
            <a class="container-arrow scroll-to" href="#">
                <span><i class="fa fa-angle-down" aria-hidden="true"></i></span>
            </a></span>
        </h2>
        <h4>Your ultimate guide to the best MaGIC Central experience</h4>
    </div>
    <div id="content-services">
            <div class="get-started">
                <h3>Getting Started</h3>
                <div class="guide-link">
                    <ul>
                        <li><a id="abt-ctrl" href="#">About MaGIC Central</a></li>
                        <li><a id="abt-dash" href="#">About MaGIC Dashboard</a></li>
                    </ul>
                </div>
               <h3 class="margin-top-2x">Frequently Asked Questions (FAQs)</h3>
                <div class="guide-link">
                    <ul>
                        <li><a id="create-acc" href="#">Managing Account</a></li>
                        <li><a id="what-org" href="#">What is a Company?</a></li>
                        <li><a id="create-org" href="#">How to Create a Company?</a></li>
                        <li><a id="manage-org" href="#">Managing Company</a></li>
                        <li><a id="join-org" href="#">How to Join an Existing Company?</a></li>
                        <li><a id="prod" href="#">What is Product?</a></li>
                        <li><a id="manage-prod" href="#">Managing Product</a></li>
                        <li><a id="serv" href="#">What is Services?</a></li>
                        <li><a id="actv-feed" href="#">What is Activity Feed?</a></li>
                        <!-- <li><a id="actv-hist" href="#">Manage Activity History</a></li> -->
                    </ul>
                </div>
            </div>
            
    </div>
</div>
<div class="wrapper wrapper-content content-bg content-left-padding">
    <div id="service-content" class="row">
     <!--    <h2 style="margin-top: 15px; margin-left: 40px;max-width: 700px;margin-right: 50px;">You can click on each topic to discover more details</h2>
        <p style="margin-left: 40px;max-width: 700px;margin-right: 50px;"></p>
 -->
    </div>
	<div id="about-content" class="hideme row">
	    <div class="col-lg-12">
	    	<h2 style="margin-top: 15px; margin-left: 40px;max-width: 700px;margin-right: 50px;">About MaGIC Central</h2>
	         <p style="margin-top: 41px; margin-left: 40px;max-width: 700px;margin-right: 50px;">
				MaGIC Central is a digital platform where you can find and apply for entrepreneurship related services provided by MaGIC and many other service providers, all in one place. You can benefit from various services at MaGIC Central such as finding mentors, applying for accreditation or certification, profiling your company, listing your services and registering for training. As MaGIC Central keep expanding, more services will be available.

			</p>
	    </div>
    </div>
    <div id="about-dash" class="hideme row">
	    <div class="col-lg-12">
	    	<h2 style="margin-top: 15px; margin-left: 40px;max-width: 700px;margin-right: 50px;">About MaGIC  Dashboard</h2>
	         <p style="margin-top: 41px; margin-left: 40px;max-width: 700px;margin-right: 50px;">		
				MaGIC Central dashboard is the place where you can perform various activities on MaGIC Central. Here, you can manage and edit your registered account, companies, products and services. You can also search and apply for services available under MaGIC Central. Within the dashboard is where you can track all your activities performed.
			</p>
	    </div>
    </div>
       <div id="create-acc-content" class="hideme row">
	    <div class="col-lg-12">
	    	<h2 style="margin-top: 15px; margin-left: 40px;max-width: 700px;margin-right: 50px;">Creating and Manage Account</h2>
	 
      <div class="content__block">
        <p style="margin-left: 40px;max-width: 700px;margin-right: 50px;"> Before you can use MaGIC Central, you need to create an account. You can create a new account at MaGIC Central. You can also sign up using your existing Google account or Social Media account, Facebook or Linkedin. </p>
          <ol id="manage_acc_guide" style="list-style-type: i;">
            
            <li>Click the Profile button under Account. <br><img class="guide-shot" src="<?php echo Yii::app()->params['masterUrl']?>/images/dashboard_guideline/manage_account/manage_account1.png"></li>
            <li>Click any form field to start editing. <br><img class="guide-shot" src="<?php echo Yii::app()->params['masterUrl']?>/images/dashboard_guideline/manage_account/manage_account2.png"></li>
            <li>Click Save Changes to save changes. <br><img class="guide-shot" src="<?php echo Yii::app()->params['masterUrl']?>/images/dashboard_guideline/manage_account/manage_account3.png"></li>
            <li>Central will process your application and update your account details. <br><img class="guide-shot" src="<?php echo Yii::app()->params['masterUrl']?>/images/dashboard_guideline/manage_account/manage_account4.png"></li>
          </ol>
      </div>
	    </div>
    </div>

    <div id="what-org-content" class="hideme row">
	    <div class="col-lg-12">
	    	<h2 style="margin-top: 15px; margin-left: 40px;max-width: 700px;margin-right: 50px;">What is a Company?</h2>
      <div class="content__block">
        <ul>
          <li>A company is defined as an entity that you are currently joining or representing. A company can be in the form of:
            <ul>
              <li>Government ministry or agency</li>
              <li>Private company, profit or non-profit</li>
              <li>Association or club</li>
              <li>Non-governmental company (NGO)</li>
            </ul>
          </li>
          <li>Certain service will require you to create a company. Company created at MaGIC Central can be used for any services provided or integrated within MaGIC Central.</li>
        </ol>
      </div>
	    </div>
    </div>

    <div id="create-org-content" class="hideme row">
	    <div class="col-lg-12">
	    	<h2 style="margin-top: 15px; margin-left: 40px;max-width: 700px;margin-right: 50px;">Create a Company</h2>
			 <div class="content__block">
          <ol id="create_org_guide" style="list-style-type: i;">
  					<li>Click the Manage link under Company. <br><img class="guide-shot" src="<?php echo Yii::app()->params['masterUrl']?>/images/dashboard_guideline/create_organisation/create_organisation1.png"></li>
  					<li>Click the Create Company button. <br><img class="guide-shot" src="<?php echo Yii::app()->params['masterUrl']?>/images/dashboard_guideline/create_organisation/create_organisation2.png"></li>
            <li>Fill the form and requirements. <br><img class="guide-shot" src="<?php echo Yii::app()->params['masterUrl']?>/images/dashboard_guideline/create_organisation/create_organisation3.png"></li>
            <li>Click Create Company once you are done completing the form. <br><img class="guide-shot" src="<?php echo Yii::app()->params['masterUrl']?>/images/dashboard_guideline/create_organisation/create_organisation4.png"></li>
            <li>Central will process your application and create your company page. <br><img class="guide-shot" style="max-width: 90%;max-height: 220px;" src="<?php echo Yii::app()->params['masterUrl']?>/images/complete_org_form.png"></li>
            
  				</ol>
        </div>
	    </div>
    </div>
        <div id="manage-org-content" class="hideme row">
      <div class="col-lg-12">
        <h2 style="margin-top: 15px; margin-left: 40px;max-width: 700px;margin-right: 50px;">Manage Company</h2>
       <div class="content__block">
          <ol id="create_org_guide" style="list-style-type: i;">
            <li>Click the Manage button under Company. <br><img class="guide-shot" src="<?php echo Yii::app()->params['masterUrl']?>/images/dashboard_guideline/manage_organisation/manage_organisation1.png"></li>
            <li>Click the Create Company button. <br><img class="guide-shot" src="<?php echo Yii::app()->params['masterUrl']?>/images/dashboard_guideline/manage_organisation/manage_organisation2.png"></li>
            <li>Fill the form and requirements. <br><img class="guide-shot" src="<?php echo Yii::app()->params['masterUrl']?>/images/dashboard_guideline/manage_organisation/manage_organisation3.png"></li>
            <li>Click Create Company once you are done completing the form. <br><img class="guide-shot" src="<?php echo Yii::app()->params['masterUrl']?>/images/dashboard_guideline/manage_organisation/manage_organisation4.png"></li>
            <li>Central will process your application and create your company page. <br><img class="guide-shot" src="<?php echo Yii::app()->params['masterUrl']?>/images/dashboard_guideline/manage_organisation/manage_organisation5.png"></li>
            
          </ol>
        </div>
      </div>
    </div>

    <div id="join-org-content" class="hideme row">
	    <div class="col-lg-12">
	    	<h2 style="margin-top: 15px; margin-left: 40px;max-width: 700px;margin-right: 50px;">Join Existing Company</h2>
	         <p style="margin-top: 41px; margin-left: 40px;max-width: 700px;margin-right: 50px;">		
				In certain case, your company may have been created by other account or by MaGIC administrator. MaGIC Central allow for multiple accounts to manage a company. To gain access to a company, you will need to request to join the company and provide required information. Your request will then be reviewed by MaGIC administrator. Should your request approved, you will receive an email notification.
			</p>
      <ol id="join_org_guide" style="list-style-type: i;">
            
            <li>Click the Company button under Account. <br><img class="guide-shot" src="<?php echo Yii::app()->params['masterUrl']?>/images/dashboard_guideline/join_existing_organisation/join_existing_organisation1.png"></li>
            <li>Click the search box and type your company name. <br><img class="guide-shot" src="<?php echo Yii::app()->params['masterUrl']?>/images/dashboard_guideline/join_existing_organisation/join_existing_organisation2.png"></li>
            <li>The search box will show result if the company is already in MaGIC database <br><img class="guide-shot" src="<?php echo Yii::app()->params['masterUrl']?>/images/dashboard_guideline/join_existing_organisation/join_existing_organisation3.png"></li>
            <li>Click request access to join the company <br><img class="guide-shot" src="<?php echo Yii::app()->params['masterUrl']?>/images/dashboard_guideline/join_existing_organisation/join_existing_organisation4.png"></li>
            <li>The company will be added to your company pending list. You can access and start managing the company once the admin approves your access request. <br><img class="guide-shot" src="<?php echo Yii::app()->params['masterUrl']?>/images/dashboard_guideline/join_existing_organisation/join_existing_organisation5.png"></li>
          </ol>
	    </div>
    </div>

    <div id="product-content" class="hideme row">
      <div class="col-lg-12">
        <h2 style="margin-top: 15px; margin-left: 40px;max-width: 700px;margin-right: 50px;">What is Product?</h2>
        <div class="content__block">
           <p style="margin-left: 40px;max-width: 700px;margin-right: 50px;">   
            A product in MaGIC Central refers to products and services offered or sold by your company. Your created products here is centralised in MaGIC Central platform and can be featured in various relevant services.
          </p>
        </div>
          <h2 style="margin-top: 15px; margin-left: 40px;max-width: 700px;margin-right: 50px;">How to create a Product?</h2>
           <div class="content__block">
            <ol id="create_product_guide" style="list-style-type: i;">
            <li>Click the Manage button under Company.<br><img class="guide-shot" src="<?php echo Yii::app()->params['masterUrl']?>//images/dashboard_guideline/create_manage_product/create_product/create_product1.png"></li>
            <li>Click your company.<br><img class="guide-shot" src="<?php echo Yii::app()->params['masterUrl']?>/images/dashboard_guideline/create_manage_product/create_product/create_product2.png"></li>
            <li>Click Create Product.<br><img class="guide-shot" src="<?php echo Yii::app()->params['masterUrl']?>/images/dashboard_guideline/create_manage_product/create_product/create_product3.png"></li>
            <li>Fill the form and requirements.<br><img class="guide-shot" src="<?php echo Yii::app()->params['masterUrl']?>/images/dashboard_guideline/create_manage_product/create_product/create_product4.png"></li>
            <li>Click Create. Central will process your application and create your product page.<br><img class="guide-shot" src="<?php echo Yii::app()->params['masterUrl']?>/images/dashboard_guideline/create_manage_product/create_product/create_product5.png"></li>
            
          </ol>
          </div>
      </div>
    </div>
    <div id="manage-prod-content" class="hideme row">
      <div class="col-lg-12">
        <h2 style="margin-top: 15px; margin-left: 40px;max-width: 700px;margin-right: 50px;">Managing Product</h2>
        <!-- <div class="content__block">
           <p style="margin-left: 40px;max-width: 700px;margin-right: 50px;">   
            A product in MaGIC Central refers to products and services offered or sold by your company. Your created products here is centralised in MaGIC Central platform and can be featured in various relevant services.
          </p>
        </div> -->
           <div class="content__block">
            <ol id="create_product_guide" style="list-style-type: i;">
            <li>Click the Company button under Account.<br><img class="guide-shot" src="<?php echo Yii::app()->params['masterUrl']?>/images/dashboard_guideline/create_manage_product/manage_product/manage_product1.png"></li>
            <li>Click your company.<br><img class="guide-shot" src="<?php echo Yii::app()->params['masterUrl']?>/images/dashboard_guideline/create_manage_product/manage_product/manage_product2.png"></li>
            <li>Click Manage Product.<br><img class="guide-shot" src="<?php echo Yii::app()->params['masterUrl']?>/images/dashboard_guideline/create_manage_product/manage_product/manage_product3.png"></li>
            <li>The dashboard will show result if the any product is already in MaGIC database.<br><img class="guide-shot" src="<?php echo Yii::app()->params['masterUrl']?>/images/dashboard_guideline/create_manage_product/manage_product/manage_product4.png"></li>
            <li>Click Edit Product.<br><img class="guide-shot" src="<?php echo Yii::app()->params['masterUrl']?>/images/dashboard_guideline/create_manage_product/manage_product/manage_product5.png"></li>
            <li>Fill the form and requirements.<br><img class="guide-shot" src="<?php echo Yii::app()->params['masterUrl']?>/images/dashboard_guideline/create_manage_product/manage_product/manage_product6.png"></li>
            <li>Click Save. Central will process your application and update your product page.<br><img class="guide-shot" src="<?php echo Yii::app()->params['masterUrl']?>/images/dashboard_guideline/create_manage_product/manage_product/manage_product7.png"></li>
          </ol>
          </div>
      </div>
    </div>

    <div id="what-service-content" class="hideme row">
      <div class="col-lg-12">
        <h2 style="margin-top: 15px; margin-left: 40px;max-width: 700px;margin-right: 50px;">What is Service?</h2>
          <div class="content__block">
            <ul>
              <li>A service in MaGIC Central refers to entrepreneurship related services provided by MaGIC and various other providers that you can apply or participate. Example of services are mentorship, training, marketplace, business opportunities program, resource listing and many more.</li>
              <li>Each service may be provided by MaGIC or providers in partner with MaGIC. Each service may have different process to apply and some service may require more information as well as payment.</li>
            </ul>
          </div>
          
          <h2 style="margin-top: 15px; margin-left: 40px;max-width: 700px;margin-right: 50px;">Using Service</h2>
          <div class="content__block">
            <ul>
              <li>To search for suitable services, you can use the service recommendation wizard (screenshot)</li>
              <li>To apply for services, you may be directed to each of the respective service website, you may also required to create your company and product depending on the service requirement.</li>
            </ul>
          </div>
      </div>
    </div>
 <div id="what-activity-content" class="hideme row">
      <div class="col-lg-12">
        <h2 style="margin-top: 15px; margin-left: 40px;max-width: 700px;margin-right: 50px;">What is Activity?</h2>
          <div class="content__block">
            <p style="margin-left: 40px;max-width: 700px;margin-right: 50px;">Activity is the record of your interaction performed from various services in MaGIC Central. Example of activities are such as book a mentor, list your product at the marketplace, register for a training and apply for a corporate challenge.</p>
          </div>
          
      </div>
    </div>
   <!--     <div id="activity-history" class="hideme row">
      <div class="col-lg-12">
        <h2 style="margin-top: 15px; margin-left: 40px;max-width: 700px;margin-right: 50px;">Tracking Your Activity</h2>
          <div class="content__block">
            <p style="margin-left: 40px;max-width: 700px;margin-right: 50px;">You can track your activity history at MaGIC Central dashboard activity section. Here you can search and view all your activities performed from services under MaGIC Central (screenshot)</p>
          </div>
          
      </div>
    </div> -->












</div>



<script type="text/javascript">
	$(function() {
   // don't cache ajax or content won't be fresh
   $.ajaxSetup({
      cache: false
   });
  
   // load() functions
   
	function hideContents() {
    $('#about-content').hide();
    $('#about-dash').hide();
    $('#create-acc-content').hide();
    $('#what-org-content').hide();
    $('#create-org-content').hide();
    $('#manage-org-content').hide();
    $('#join-org-content').hide();
    $('#product-content').hide();
    $('#manage-prod-content').hide();
    $('#what-service-content').hide();
    $('#what-activity-content').hide();
    $('#activity-history').hide();
  }
   
   $(document).ready(function() {
    	hideContents();
      $("#content-services a").first().addClass("active").click();

	 });


   $("#abt-ctrl").click(function() {
   		hideContents();
      $('#content-services a').removeClass('active');
      $(this).addClass('active');

         $("#service-content").fadeIn('slow', function() {
            $("#loader").hide();
            $('#about-content').fadeIn();
      


      });



   });
   $("#abt-dash").click(function() {
    hideContents();
      $('#content-services a').removeClass('active');
      $(this).addClass('active');

         $("#service-content").fadeIn('slow', function() {
            $("#loader").hide();
            $('#about-dash').fadeIn();
         });



   });

   $("#create-acc").click(function() {
    hideContents();
      $('#content-services a').removeClass('active');
      $(this).addClass('active');

         $("#service-content").fadeIn('slow', function() {
            $("#loader").hide();
            $('#create-acc-content').fadeIn();
         });


   });

   $("#what-org").click(function() {
    hideContents();
      $('#content-services a').removeClass('active');
      $(this).addClass('active');


         $("#service-content").fadeIn('slow', function() {
            $("#loader").hide();
            $('#what-org-content').fadeIn();
         });



   });

    $("#create-org").click(function() {
    hideContents();
      $('#content-services a').removeClass('active');
      $(this).addClass('active');

         $("#service-content").fadeIn('slow', function() {
            $("#loader").hide();
            $('#create-org-content').fadeIn();
         });


   });
   $("#manage-org").click(function() {
    hideContents();
      $('#content-services a').removeClass('active');
      $(this).addClass('active');

         $("#service-content").fadeIn('slow', function() {
            $("#loader").hide();
            $('#manage-org-content').fadeIn();
         });


   });

   $("#join-org").click(function() {
    hideContents();
      $('#content-services a').removeClass('active');
      $(this).addClass('active');

         $("#service-content").fadeIn('slow', function() {
            $("#loader").hide();
            $('#join-org-content').fadeIn();
         });

   });

   $("#prod").click(function() {
    hideContents();
      $('#content-services a').removeClass('active');
      $(this).addClass('active');

         $("#service-content").fadeIn('slow', function() {
            $("#loader").hide();
            $('#product-content').fadeIn();
         });


   });

  $("#manage-prod").click(function() {
    hideContents();
      $('#content-services a').removeClass('active');
      $(this).addClass('active');

         $("#service-content").fadeIn('slow', function() {
            $("#loader").hide();
            $('#manage-prod-content').fadeIn();
         });


   });

   $("#serv").click(function() {
    hideContents();
      $('#content-services a').removeClass('active');
      $(this).addClass('active');

         $("#service-content").fadeIn('slow', function() {
            $("#loader").hide();
            $('#what-service-content').fadeIn();
         });


   });
   $("#actv-feed").click(function() {
    hideContents();
      $('#content-services a').removeClass('active');
      $(this).addClass('active');

         $("#service-content").fadeIn('slow', function() {
            $("#loader").hide();
            $('#what-activity-content').fadeIn();
         });

   });

   $("#actv-hist").click(function() {
    hideContents();
      $('#content-services a').removeClass('active');
      $(this).addClass('active');

         $("#service-content").fadeIn('slow', function() {
            $("#loader").hide();
            $('#activity-history').fadeIn();
         });


   });
   // end  
});
</script>