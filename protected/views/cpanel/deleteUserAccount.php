<?php
$this->breadcrumbs=array(
    'Download Your Information'
);
$this->renderPartial('/cpanel/_menu',array('model'=>$model,));
?>

<div class="sidebard-panel left-bar">
    <div id="header">
        <h2>Settings<span class="hidden-desk">
            <a class="container-arrow scroll-to" href="#">
                <span><i class="fa fa-angle-down" aria-hidden="true"></i></span>
            </a></span>
        </h2>
        <h4></h4>
    </div>
    <div id="content-services">
        <a id="unsubscribeUserEmail-link" class="service-link" href="<?php echo $this->createUrl('cpanel/manageUserEmailSubscription') ?>">
            <div class="m-t-md pad-30 service-box">
                <h4>Manage Your Newsletters</h4>
                <h5>View, change or cancel your subscriptions</h5> 
            </div>
        </a> 
        <a id="downloadUserData-link" class="service-link" href="<?php echo $this->createUrl('cpanel/downloadUserData') ?>">
            <div class="m-t-md pad-30 service-box">
                <h4>Download Your Information</h4>
                <h5>Get a copy of your data on our platform here</h5> 
            </div>
        </a>
        <a id="deleteUserAccount-link" class="service-link active" href="<?php echo $this->createUrl('cpanel/deleteUserAccount') ?>">
            <div class="m-t-md pad-30 service-box">
                <h4>Deactivate Your Account</h4>
                <h5>Permanently deactivate your MaGIC account</h5> 
            </div>
        </a>    
    </div>
</div>


<div class="wrapper wrapper-content content-bg content-left-padding">
    <div id="service-content" class="row">
        <div class="col col-md-12 margin-bottom-lg">
            <h2 style="margin-top: 15px; margin-left: 40px; max-width: 700px;margin-right: 50px;">Deactivate Your Account</h2>
            <div style="margin-left: 40px; ">

                <div class="gray-bg padding-lg margin-bottom-lg border">
                    <b>We are sad to see you leave. Before you go, please read this carefully</b>
                    <p>If you are choosing to delete your MaGIC account on our platform, please be reminded that you will no longer receive email updates from MaGIC which includes:</p>

                    <p><ol>
                        <li>Free trials to MaGIC programmes and events</li>
                        <li>Discounted tickets for MaGIC programmes and events</li>
                        <li>Promotions on ecosystem programmes and events</li>
                        <li>Ecosystem updates</li>
                    </ol> </p>

                    <p>You will also lose access to partnership services tied to this account such as the MaGIC Mentorship services. This means you will not have access to the Mentors and Mentees that you have interacted with in the past via this platform.</p>

                    <p>By completing this process, your account will be deactivated and deleted which will cause all content including your activity feed with MaGIC to be permanently erased. The deactivation and deletion of your account will take effect immediately. Your account will be inaccessible once the deactivation is complete.</p>

                    <p>You will receive an email update from our team which will include a copy of your information within 1 hour. Be sure to check your spam inbox if you do not receive any email from us within 12 hours from the deactivation of your account. </p>

                    <p>We are sorry to see you go. Please let us know if it was something we did that is causing you to leave us. As we continuously strive to improve our services, your feedback is valuable to us. Please help us do better by reaching out to us at advisor@mymagic.my or call us at +603 8324 4800. We wish you the best of luck and our mentors will always be ready to provide you with guidance <a href=<?php echo $this->createUrl('/mentor')?> >here</a>. If you would like to explore other options to manage your account or download your information, please visit the <a href=<?php echo $this->createUrl('cpanel/downloadUserData')?> >Download Your Information</a> in the <a href=<?php echo $this->createUrl('cpanel/setting')?> >Settings</a> page.

                    <p><a href=<?php echo $this->createUrl('cpanel/terminateAccount')?> id="terminate-link2" class="btn btn-sd btn-sd-pad btn-sd-red">Deactivate My Account</a></p>
                </div>
                <div style="margin-left:100px;margin-top:10px;margin-bottom:25px;" class="col-md-4 col-sm-6 col-xs-12">
                  
                </div>
             
            </div>
        </div>
    </div>
</div>