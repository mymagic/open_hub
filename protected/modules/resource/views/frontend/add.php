<?php
$this->breadcrumbs = array(
	'Resource Directory' => array('//resource'),
	'Add New Resource'
);

?>

<?php
$subFilters = array_keys($_GET);
unset($subFilters[0]);
$subFilters = implode(',', $subFilters);
$category_filter = $_GET && trim($subFilters) != '' ? explode(',', $subFilters) : array();
$result = json_decode($data, true);

?>

<style>
.row-centered {
    text-align: center;
    display: table-row;
  }
</style>

<section class="container margin-top-lg">

    <div class="col-md-9 margin-top-lg">
        <h2>Add New Resource</h2>
        <div class="add-subtitle">
            <p>A company is required to add new resource</p>
        </div>
        <form class="search_list margin-top-lg" id="form-start" method="GET" action="">
        <fieldset>
        <h5>Join Existing Company</h5>
            <div class="form-group has-feedback">
                <div class="input-group input-group-lg dropdown ys-dropdown" style="width:100%; margin:0 auto; padding-right:5px">
                <input placeholder="To request access and manage a company" class="dropdown-toggle form-control" data-toggle="dropdown" autocomplete="off" name="keyword" id="StartForm_keyword" type="search">
                    <ul class="dropdown-menu pointer" aria-labelledby="StartForm_keyword"></ul>
                
            
                    <!-- <div class="input-group-btn">
                        <input class="input-lg btn-submit btn btn-primary" type="submit" name="yt0" value="Search">
                    </div> -->
                </div>
                    
            </div>
        <!-- <a id="request-access" class="btn btn-sd btn-sd-green hidden ">Request Access</a> -->

            <a id="request-access" class="btn btn-sd btn-sd-green hidden" href="">Request Access</a> 

        </fieldset>
        </form>
        <div class="row">
            <div class="margin-top-lg" style="text-align:center;">
                <h2 style="color:#555;"><i>OR</i></h2>
            </div>
        </div>


    </div>
    
        
    <div id="select-myorg" class="row">
    
    <?php $count = 0; foreach ($model['organizations']['approve'] as $organization): ?>
    <div class="col-lg-4 col-md-4 margin-left-25">
    <div class="ibox float-e-margins">
        <a href="<?php echo $this->createUrl('frontend/createResource', array('id' => $organization->id)) ?>">
            <div class="ibox-title box-resource">
                <?php echo $organization->title ?>
            </div>
        </a>
    </div>
    </div>
    <?php $count++; endforeach; ?>

    <?php $count = 0; foreach ($model['organizations']['pending'] as $organization): ?>
    <div class="col-lg-4 col-md-4 margin-left-25">
        <div class="ibox float-e-margins">
            <div class="ibox-title box-resource">
                <span class="label label-primary pull-right badge badge-warning">Pending</span>
                <?php echo $organization->title ?>
            </div>

        </div>
    </div>
    <?php $count++; endforeach; ?>

    <div class="col-md-4 margin-left-25">
        <div class="ibox float-e-margins">
        <a href="<?php echo $this->createUrl('frontend/createOrganization') ?>">
            <div class="create-org-btn">    
                <h3>Create a company</h3>
            </div>
        </a>
    </div>

    </div>

</section>


<?php Yii::app()->clientScript->registerScript(
	'add-resource-0',
	"
 $('#StartForm_keyword').on('input propertychange', function(e) {        
   console.log('yo', $(this).val());
    
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

    $('#form-start .dropdown-menu').on('click', 'li', function(e){
        var orgID = $(this).attr('data-id');
        console.log(orgID);
        $('#StartForm_keyword').val($(this).data('title'));
        $('#request-access').removeClass('hidden');
        $('#request-access').attr('href', '" . Yii::app()->params['baseUrl'] . "/resource/frontend/requestJoinEmail?organizationId='+orgID+'&'+'email='+'" . Yii::app()->user->username . "');



        
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