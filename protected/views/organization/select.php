<?php

$this->breadcrumbs = array('Organization' => array('select'), 'Select');
$this->renderPartial('/cpanel/_menu', array('model' => $model, ));

?>

<?php $totalOrganizations = count($model['organizations']['approve']) + count($model['organizations']['pending']) ?>

<!-- <li>Username: <?php echo !empty(Yii::app()->user->username) ? Yii::app()->user->username : 'NULL'; ?></li> -->
    <div class="sidebard-panel left-bar">
        <div id="header">
            
            <h2><?php echo Yii::t('app', 'My Organization|My Organizations', $totalOrganizations) ?><span class="hidden-desk">
                <a class="container-arrow scroll-to" href="#">
                    <span><i class="fa fa-angle-down" aria-hidden="true"></i></span>
                </a></span>
            </h2>

        </div>
    <div id="content-services">
        
    <?php $count = 0; foreach ($model['organizations']['approve'] as $organization): ?>
    <a class="m-t-md pad-30 green-hov" href="<?php echo $this->createUrl('/organization/view', array('id' => $organization->id, 'realm' => 'cpanel')) ?>">
       <?php echo $organization->title ?>
        <small><?php echo $organization->text_oneliner ?></small>
        <!--  <h6 class="no-margins">Website</h6> -->
   </a> 
    <?php $count++; endforeach; ?>

    <?php $count = 0; foreach ($model['organizations']['pending'] as $organization): ?>

    <div class="m-t-md pad-30 green-hov cursor-default">   
            <!-- <?php echo Html::image(ImageHelper::thumb(50, 50, $organization->image_logo), Yii::t('app', 'Logo Image'), array('class' => 'img-circle m-t-xs img-responsive')); ?>
--> <?php echo $organization->title ?>
    <small><?php echo $organization->text_oneliner ?></small>

    <span class="label label-primary pull-right badge badge-warning noborder-status"><?php echo Yii::t('app', 'Pending') ?></span>

    <a href="<?php echo $this->createUrl('organization/deleteUserOrganization2Email', array('organizationID' => $organization->id, 'userEmail' => Yii::app()->user->username, 'realm' => 'cpanel'))?>" class="no-border pull-right badge badge-danger noborder-status close-badge" title="<?php echo Yii::t('app', 'Cancel Request') ?>">&times;</a>

    </div>

<?php $count++; endforeach; ?>

</div>
        </div>
    

    <div class="wrapper wrapper-content content-bg content-left-padding">
       <div id="search-exist-org" class="row">
<div class="col-md-12 margin-bottom-lg">
<h2 style="margin-top: 15px; margin-left: 26px;max-width: 700px;margin-right: 50px;"><?php echo Yii::t('app', 'Join Existing Organization') ?></h2>
<form class="search_list" id="form-start" method="GET" action="">
<fieldset>
    <div class="form-group has-feedback">
        <div class="input-group input-group-lg dropdown ys-dropdown" style="width:100%; margin:0 auto; padding-right:5px">
           <input placeholder="<?php echo Yii::t('backend', 'To request access and manage an organization')?>" class="dropdown-toggle form-control" data-toggle="dropdown" autocomplete="off" name="keyword" id="StartForm_keyword" type="search">
            <ul class="dropdown-menu pointer" aria-labelledby="StartForm_keyword"></ul>
        
       
            <!-- <div class="input-group-btn">
                <input class="input-lg btn-submit btn btn-primary" type="submit" name="yt0" value="Search">
            </div> -->
                <a id="request-access" class="btn btn-sd btn-sd-green hidden" href=""><?php echo Yii::t('app', 'Request Access') ?></a> 

        </div>
            
    </div>
   <!-- <a id="request-access" class="btn btn-sd btn-sd-green hidden ">Request Access</a> -->


</fieldset>
</form>
    </div>
   <!--  <div class="col-md-2 margin-top-lg ">        
        <button id="request-access" class="btn btn-default hidden ">Request Access</button>
    </div>-->
</div>

    <div class="center-block text-center margin-top-3x text-muted margin-bottom-2x">
        <h3 class="nopadding" style="font-weight: 500;"><?php echo Yii::t('app', "Don't have an organization yet") ?>?</h3>
        <p><?php echo Yii::t('app', 'If your organization is not exists in our system yet, please create a organization profile here') ?></p>
     </div>

    <div class="createorgbtn center-block text-center margin-top-lg text-muted">
        <a href="<?php echo $this->createUrl('organization/create', array('realm' => 'cpanel')) ?>"><?php echo Yii::t('app', 'Create Organization') ?></a>
    </div>

    </div>




<?php Yii::app()->clientScript->registerScript(
	'organization-select-0',
	"
 $('#StartForm_keyword').on('input propertychange', function(e) {        
    //console.log('yo', $(this).val());
    
    var self = $(this);
    if($(this).val() == '' || $(this).val().length < 2)
    {
        
        
        $('#form-start').find('#request-access').addClass('hidden');
        var dropdownMenu = self.parent('.dropdown').find('.dropdown-menu');
        dropdownMenu.html('');
        self.parent('.dropdown').removeClass('open');
        return;
    }

    $.get('" . Yii::app()->params['baseUrl'] . "/api/getUserOrganizationsCanJoin', { keyword:$(this).val()} )
    .done(function( json ) 
    {
        var dropdownMenu = self.parent('.dropdown').find('.dropdown-menu');
        dropdownMenu.html('');
        var type = '';
        if(json.data && json.data.length>0)
        {
            $.each(json.data, function(k, v) {
                
                dropdownMenu.append('<li data-id=\"'+v.id+'\" data-title=\"'+v.title+'\" class=\"item\">'+v.title+'</li>');
            });

        }
        
        if(Object.keys(json).length !== 0)
        {
            self.parent('.dropdown').addClass('open')
        }
        else
        {
            self.parent('.dropdown').removeClass('open')
        }
    });
     function truncateString(str, length) {
         return str.length > length ? str.substring(0, length - 3) + '...' : str
      }
    $('#form-start .dropdown-menu').on('click', 'li', function(e){
        var orgID = $(this).attr('data-id');
        console.log(orgID);
        $('#StartForm_keyword').val(truncateString($(this).data('title'),40));
        $('#request-access').removeClass('hidden');
        $('#request-access').attr('href', '" . Yii::app()->params['baseUrl'] . "/organization/requestJoinEmail?organizationId='+orgID+'&'+'email='+'" . Yii::app()->user->username . "');



        
        $('#form-start').bind('keypress keyup keydown', function (event) {
            if (event.keyCode == 8 || event.keyCode == 46) {
                $('#request-access').addClass('hidden');

            }  
        });

    });

}).on('focus keyup', function(e){
        var self = $(this);
        var key = e.keyCode;
        
        var dropdownMenu = self.parent('.dropdown').find('.dropdown-menu');
        var dropdownMenuList = dropdownMenu.find('li').filter('.item');
        if(dropdownMenuList.length>0)
        {
            var current;
            var selected = dropdownMenuList.filter('.selected');
            dropdownMenuList.removeClass('selected');
            
            // Down key
            if(key==40) 
            {
                if(!selected.length || selected.is(':last-child'))
                {
                    current = dropdownMenuList.eq(0);
                }
                else 
                {
                    current = selected.nextAll('.item:first');
                }
            }
            else if(key==38) 
            {
                if(!selected.length || selected.is(':first-child'))
                {
                    current = dropdownMenuList.last();
                }
                else 
                {
                    current = selected.prevAll('.item:first');
                }
            }
            
            if(current && current.length)
            {
                current.addClass('selected');
            }
        }
        
        
        if (key === 13 && selected && selected.length)
        {
            selected.trigger('click');

        }
    });"
); ?>


