<?php
/* @var $this IndividualController */
/* @var $model Individual */

$this->breadcrumbs = array(
	Yii::t('backend', 'Individuals') => array('index'),
	Yii::t('backend', 'Merge'),
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Individuals'), 'url' => array('/individual/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Individual'), 'url' => array('/individual/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);
?>

<?php $form = $this->beginWidget('ActiveForm', array(
	'action' => $this->createUrl('individual/doMerge'),
	'method' => 'GET',
	'htmlOptions' => array(
		'class' => 'form-horizontal',
		'role' => 'form'
	)
)); ?>

<h1><?php echo $this->pageTitle ?> <input type="submit" class="pull-right btn btn-primary" value="Merge!" /></h1>

<div class="row" id="vue-mergeIndividual">
    <div class="col-sm-6">
        <div class="well">
        <h3>Merge This <span class="pull-right" id="switch" style="cursor:pointer"><?php echo Html::faIcon('fa fa-exchange') ?></span></h3>

        <?php $this->widget('application.components.widgets.IndividualSelector', array('model' => 'Individual', 'attribute' => 'sourceKeyword', 'selected' => $sourceKeyword, 'urlAjax' => $this->createUrl('individual/ajaxIndividualActive'), 'htmlOptions' => array('v-model' => 'sourceKeyword'))) ?>

        <div class="margin-top-lg" v-html="previewSource"></div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="well">
        <h3>Into This</h3>
        <?php $this->widget('application.components.widgets.IndividualSelector', array('model' => 'Individual', 'attribute' => 'targetKeyword', 'selected' => $targetKeyword, 'urlAjax' => $this->createUrl('individual/ajaxIndividualActive'), 'htmlOptions' => array('v-model' => 'targetKeyword'))) ?>

        <div class="margin-top-lg" v-html="previewTarget"></div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<div>
<h2>Auto Detection</h2>
<table class="table table-borderd">
<?php $i = 1; foreach ($suggestions as $suggestion): ?>
    <tr>
        <td><?php echo $i ?></td>
        <td><?php echo $suggestion['full_name'] ?></td>
        <td>
            <?php $tmps = Yii::app()->db->createCommand()
				->select('*')
				->from('individual')
				->where('full_name LIKE :fullName', array(':fullName' => sprintf('%s%%', substr($suggestion['full_name'], 0, 20))))
				->queryAll(); ?>

            <?php foreach ($tmps as $tmp):?>
            <div class="label label-default" style="margin:2px; display:inline-block">#<?php echo $tmp['id'] ?>| <?php echo $tmp['full_name'] ?></div>
            <?php endforeach; ?>
        </td>
        <td><span class="badge badge-danger"><?php echo $suggestion['total'] ?></span></td>
    </tr>
<?php $i++; endforeach; ?>
</table>
</div>



<?php Yii::app()->clientScript->registerScript(
					'individual-merge',
"
var vue = new Vue({
    el: '#vue-mergeIndividual',
    data: {sourceKeyword:'', targetKeyword:'', previewSource:'', previewTarget:''},
    watch: {sourceKeyword: 'fetchIndividualNode2Source', targetKeyword: 'fetchIndividualNode2Target'},
    methods:
    {
        fetchIndividualNode2Source: function()
        {
            var self = this;
            self.previewSource = '<center><i class=\"fa fa-3x fas fa-spinner fa-spin\"></i></center>';
            $.get(baseUrl+'/individual/getIndividualNodes?keyword='+self.sourceKeyword, function( html )
			{
				self.previewSource = html;
			});
        },

        fetchIndividualNode2Target: function()
        {
            var self = this;
            self.previewTarget = '<center><i class=\"fa fa-3x fas fa-spinner fa-spin\"></i></center>';
            $.get(baseUrl+'/individual/getIndividualNodes?keyword='+self.targetKeyword, function( html )
			{
				self.previewTarget = html;
			});
        }
    }
});

$('#sourceKeyword').change(function() {vue.\$data.sourceKeyword = $('#sourceKeyword').val()});
$('#targetKeyword').change(function() {vue.\$data.targetKeyword = $('#targetKeyword').val()});

$('#switch').click(function(){
    var source = $('#sourceKeyword').select2('data');
    var sourceVal = source[0].id; var sourceText = source[0].text;
    var target = $('#targetKeyword').select2('data');
    var targetVal = target[0].id; var targetText = target[0].text;

    $('#targetKeyword').empty().trigger('change');
    $('#targetKeyword').append('<option value=\"'+sourceVal+'\">'+sourceText+'</option>');
    $('#targetKeyword').val(sourceVal).trigger('change');

    $('#sourceKeyword').empty().trigger('change');
    $('#sourceKeyword').append('<option value=\"'+targetVal+'\">'+targetText+'</option>');
    $('#sourceKeyword').val(targetVal).trigger('change');
});
"
				); ?>