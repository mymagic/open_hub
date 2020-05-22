<?php
/* @var $this OrganizationController */
/* @var $model Organization */

$this->breadcrumbs = array(
	Yii::t('backend', 'Organizations') => array('index'),
	Yii::t('backend', 'Merge'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Organizations'), 'url' => Yii::app()->createUrl('organization/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'organization', 'action' => (object)['id' => 'admin']])
	),
	array(
		'label' => Yii::t('app', 'Create Organization'), 'url' => Yii::app()->createUrl('organization/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'organization', 'action' => (object)['id' => 'create']])),
);
?>

<?php $form = $this->beginWidget('ActiveForm', array(
	'action' => $this->createUrl('organization/doMerge'),
	'method' => 'GET',
	'htmlOptions' => array(
		'class' => 'form-horizontal',
		'role' => 'form'
	)
)); ?>

<h1><?php echo $this->pageTitle ?> <input type="submit" class="pull-right btn btn-primary" value="Merge!" /></h1>


<div class="row" id="vue-mergeOrganization">
    <div class="col-sm-6">
        <div class="well">
        <h3><?php echo Yii::t('backend', 'Merge this')?> <span class="pull-right" id="switch" style="cursor:pointer"><?php echo Html::faIcon('fa fa-exchange') ?></span></h3>

        <?php echo Html::foreignKeyDropDownList('sourceKeyword', 'Organization', $sourceKeyword, array('class' => 'form-control ', 'v-model' => 'sourceKeyword', 'nullable' => true)); ?>

        <div class="margin-top-lg" v-html="previewSource"></div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="well">
        <h3><?php echo Yii::t('backend', 'Into this')?></h3>
        <?php echo Html::foreignKeyDropDownList('targetKeyword', 'Organization', $targetKeyword, array('class' => 'form-control ', 'v-model' => 'targetKeyword', 'nullable' => true)); ?>
        <div class="margin-top-lg" v-html="previewTarget"></div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<div>
<h2><?php echo Yii::t('backend', 'Auto Detection')?></h2>
<table class="table table-borderd">
<?php $i = 1; foreach ($suggestions as $suggestion): ?>
    <tr>
        <td><?php echo $i ?></td>
        <td><?php echo $suggestion['title'] ?></td>
        <td>
            <?php $sql = 'SELECT * FROM organization WHERE title LIKE :title';
			$tmps = Yii::app()->db->createCommand($sql)->bindValues(array(':title' => substr($suggestion['title'], 0, 10) . '%%'))->queryAll(); ?>
            <?php foreach ($tmps as $tmp):?>
                <div class="label label-default" style="margin:2px; display:inline-block">#<?php echo $tmp['id'] ?>| <?php echo $tmp['title'] ?></div>
            <?php endforeach; ?>
        </td>
        <td><span class="badge badge-danger"><?php echo $suggestion['total'] ?></span></td>
    </tr>
<?php $i++; endforeach; ?>
</table>
</div>



<?php Yii::app()->clientScript->registerScript(
				'organization-merge',
"
var vue = new Vue({
    el: '#vue-mergeOrganization',
    data: {sourceKeyword:'', targetKeyword:'', previewSource:'', previewTarget:''},
    watch: {sourceKeyword: 'fetchOrganizationNode2Source', targetKeyword: 'fetchOrganizationNode2Target'},
    methods:
    {
        fetchOrganizationNode2Source: function()
        {
            var self = this;
            self.previewSource = '<center><i class=\"fa fa-3x fas fa-spinner fa-spin\"></i></center>';
            $.get(baseUrl+'/organization/getOrganizationNodes?keyword='+self.sourceKeyword, function( html )
			{
				self.previewSource = html;
			});
        },

        fetchOrganizationNode2Target: function()
        {
            var self = this;
            self.previewTarget = '<center><i class=\"fa fa-3x fas fa-spinner fa-spin\"></i></center>';
            $.get(baseUrl+'/organization/getOrganizationNodes?keyword='+self.targetKeyword, function( html )
			{
				self.previewTarget = html;
			});
        }
    }
});
$('#sourceKeyword').chosen().change(function() {vue.\$data.sourceKeyword = $('#sourceKeyword').val()});
$('#targetKeyword').chosen().change(function() {vue.\$data.targetKeyword = $('#targetKeyword').val()});

$('#switch').click(function(){
    var source = $('#sourceKeyword').val();
    var target = $('#targetKeyword').val();

    $('#sourceKeyword').val(target).trigger('chosen:updated').trigger('change');
    $('#targetKeyword').val(source).trigger('chosen:updated').trigger('change');
});
"
			); ?>