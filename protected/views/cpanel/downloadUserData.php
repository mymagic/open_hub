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
        <a id="downloadUserData-link" class="service-link active" href="<?php echo $this->createUrl('cpanel/downloadUserData') ?>">
            <div class="m-t-md pad-30 service-box">
                <h4>Download Your Information</h4>
                <h5>Get a copy of your data on our platform here</h5> 
            </div>
        </a>
        <a id="deleteUserAccount-link" class="service-link " href="<?php echo $this->createUrl('cpanel/deleteUserAccount') ?>">
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
            <h2 style="margin-top: 15px; margin-left: 40px; max-width: 700px;margin-right: 50px;">Download Your Information</h2>
            <div style="margin-left: 40px; ">

                <div class="<?php echo $isGeneratingFile?'darkGray':'gray'?>-bg padding-lg margin-bottom-lg border">
                    <b>Getting a copy of your data on MaGIC Platform</b>
                    <p>Depending on how much activity you have on MaGIC platform. It might take sometime for the file to be prepared.</p>
                    
                    <?php if(!$isGeneratingFile): ?>
                    <div class="btn-group">
                        <div class="dropdown">
                            <a class="btn btn-sd btn-sd-green dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Create File<i class="icon-down-open-big"></i>
                            </a>
                            <ul class="dropdown-menu" style="width: 100%;">
                                <li><a href="<?php echo $this->createUrl('cpanel/requestDownloadUserData', array('format'=>'html')) ?>">HTML</a></li>
                                <li><a href="<?php echo $this->createUrl('cpanel/requestDownloadUserData', array('format'=>'json')) ?>">JSON</a></li>
                            </ul>
                        </div>
                    </div>
                    <?php else: ?>
                        <a class="btn btn-sd btn-sd-pad btn-sd-disabled">Creating File...</a>
                    <?php endif; ?>
                </div>
            
                <?php echo $isGeneratingFile?Notice::inline(Yii::t('notice', "Your file is being processed. We'll let you know when it's complete, so you can download it to your preferred device.")):'' ?>

                <?php if(!empty($availableFiles)): ?>
                <h4>Available Files</h4>
                
                <?php foreach($availableFiles as $file): ?>
                <div class="border">
                    <div class="row margin-md">
                        <div class="col col-md-10">Requested data archived on <?php echo Html::formatDateTime($file->jsonArray_data->dateProcessed, 'standard', 'standard') ?> (<?php echo strtoupper($file->jsonArray_data->format) ?>)</div>
                        <div class="col col-md-2"><a href="<?php echo $this->createUrl('/cpanel/downloadUserDataFile', array('id'=>$file->id)) ?>">Download</a></div>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>