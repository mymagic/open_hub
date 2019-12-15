<?php

$this->breadcrumbs=array('Organization'=>array('join'),'Join Exisiting');

$this->renderPartial('/cpanel/_menu',array('model'=>$model,));

?>

<div id="select-join" class="row"></div>
<?php foreach($model as $exs): ?>
<div class="col-lg-8">
    	<div class="ibox float-e-margins">
       		 <div class="ibox-title">
             	<h3 class=""><?php echo $exs['title'] ?></h3>
             	
    		</div>
    		<div class="ibox-content">
    			Click <a class="btn btn-xs btn-primary" href="<?php echo $this->createUrl('organization/requestJoinEmail', array('organizationId'=>$exs['id'], 'email'=>Yii::app()->user->username)) ?>">here</a> to request to join. 
    		</div>
   
        </div>
    </div>
<?php $count++; endforeach; ?>




</div>
