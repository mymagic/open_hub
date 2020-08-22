<?php
/* @var $this MilestoneController */
/* @var $model Milestone */

$this->breadcrumbs = array(
	'Milestones' => array('index'),
	$model->title,
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Milestone'), 'url' => array('/milestone/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('app', 'Create Milestone'), 'url' => array('/milestone/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
	array(
		'label' => Yii::t('app', 'Update Milestone'), 'url' => array('/milestone/update', 'id' => $model->id),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'update')
	),
	array(
		'label' => Yii::t('app', 'Delete Milestone'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'csrf' => Yii::app()->request->enableCsrfValidation, 'confirm' => Yii::t('core', 'Are you sure you want to delete this item?')),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'delete')
	),
);
?>


<h1><?php echo Yii::t('backend', 'View Milestone'); ?></h1>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		'username',
		array('name' => 'organization_id', 'type' => 'raw', 'value' => Html::link($model->organization->title, Yii::app()->controller->createUrl('/organization/view', array('id' => $model->organization->id)))),
		array('name' => 'preset_code', 'value' => $model->preset_code),
		'title',
		array('name' => 'text_short_description', 'type' => 'raw', 'value' => nl2br($model->text_short_description)),
		'source',
		// array('name'=>'viewMode', 'type'=>'raw', 'value'=>$model->formatEnumViewMode($model->viewMode)),
		array('name' => 'is_disclosed', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_disclosed)),
		array('name' => 'is_star', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_star)),
		array('name' => 'is_active', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_active)),
		array('label' => $model->attributeLabel('date_added'), 'value' => Html::formatDateTime($model->date_added, 'long', 'medium')),
		array('label' => $model->attributeLabel('date_modified'), 'value' => Html::formatDateTime($model->date_modified, 'long', 'medium')),
	),
)); ?>



</div>


<div id="form-milestone-values">
<input type="hidden" v-model="id" value="<?php echo $model->id ?>" />
<input type="hidden" v-model="viewMode" value="<?php echo $model->viewMode ?>" />
<input type="hidden" v-model="year" value="<?php echo $year ?>" />
<input type="hidden" id="input-csrfTokenName" value="<?php echo Yii::app()->request->csrfTokenName ?>" />
<input type="hidden" id="input-csrfToken" value="<?php echo Yii::app()->request->csrfToken ?>" />

<div class="btn-group pull-right btn-group-xs" role="group">
<?php foreach ($model->getEnumViewMode() as $viewMode): ?>
	<button type="button" class="btn btn-<?php echo ($viewMode['code'] == $model->viewMode || $viewMode['code'] == 'weekly' && empty($model->viewMode)) ? 'primary' : 'white' ?>" data-code="<?php echo $viewMode['code'] ?>" v-on:click="setViewMode"><?php echo $viewMode['title'] ?></button>
<?php endforeach; ?>
</div>

<h2>Year <a v-on:click="prevYear"><?php echo Html::faIcon('fa fa-caret-left') ?></a> {{year}} <a v-on:click="nextYear"><?php echo Html::faIcon('fa fa-caret-right') ?></a></h2>

<div class="alert alert-info">
	<strong>Instruction on updating weekly milestone:</strong>
	<ol>
		<li>Insert number only value in (except custom milestone) as we can only trace numeric value in reporting.</li>
		<li>Insert only <b><u>accumulated value</u></b>. For example, your week1 value is 1000, and you gain extra 200 in week2. You should insert 1200 to week2 milestone, not 200.</li>
		<li>Mark the checkbox besides the value when you realized it.</li>
		<li>If you do not wanto go down to weekly level of recording:
			<ul>
				<li>For monthly: Only insert value to week4 of every month.</li>
				<li>For quaterly: Only insert value to week4 of month Mar, Jun, Sep &amp; Dec.</li>
				<li>For semiyearly: Only insert value to week4 of month Jun, Dec.</li>
				<li>For yearly: Only insert value to week4 of month Dec.</li>
			</ul>
		</li>
		<li>Remember to convert to <b>USD</b> if you are recording monetary value</li>
	</ol>
</div>

<div class="row">
	<?php for ($m = 1; $m <= 12; $m++): ?>
	<div class="col col-sm-6" id="section-month-<?php echo $m ?>">
		<div class="ibox">
			<div class="ibox-title"><h3><?php echo date('M', mktime(0, 0, 0, $m, 10)) ?></h3></div>
			<div class="ibox-content"><div class="row">
				<?php for ($w = 1; $w <= 4; $w++): ?>
				<div class="col col-sm-3" id="section-month-<?php echo $m ?>-week-<?php echo $w?>">
					<div class="form-group" data-milestone-id="<?php echo $model->id ?>" data-year="{{year}}" data-month="<?php echo $m ?>" data-week="<?php echo $w ?>">
						<h4>W<?php echo $w ?> <small class="pull-right"><span class="glyphicon"></span></small></h4>
						<div class="input-group">
							<span class="input-group-addon"><input id="input-weekRealized-{{year}}-<?php echo $m ?>-<?php echo $w ?>"  class="input-weekRealized"  type="checkbox" aria-label="Realised" v-model="values[<?php echo $m ?>][<?php echo $w ?>]['realized']" v-on:change="changedRealized" title="Realized" /></span>
							<input type="text" id="input-weekValue-{{year}}-<?php echo $m ?>-<?php echo $w ?>" class="form-control input-weekValue" aria-label="Value" v-model="values[<?php echo $m ?>][<?php echo $w ?>]['value']" v-on:change="changedValue" />
						</div>
					</div>
				</div>
				<?php endfor; ?>

			</div></div>
		</div>
	</div>
	<?php endfor ?>
</div>

</div>



<?php Yii::app()->clientScript->registerScript('milestone-view2', "
	Vue.config.silent = true;
	var vue = new Vue({
		el: '#form-milestone-values',
		data: {id:'', year:'', viewMode:'weekly', values:[]},
		ready: function ()
		{
			this.fetchData();
			this.renderViewMode();
		},

		methods:
		{
			fetchData: function()
			{
				var self = this;
				$.get(baseUrl+'/api/getMilestone?id='+self.id+'&year='+self.year, function(json)
				{
					self.values = json.data.jsonArrayValue[self.year];
				});
			},
			nextYear: function(e)
			{
				this.year = parseInt(this.year)+1;
				this.fetchData();
			},
			prevYear: function(e)
			{
				this.year = parseInt(this.year)-1;
				this.fetchData();
			},
			changedValue: function(e)
			{
				var element = e.target;
				var milestoneId = $(element).closest('.form-group').data('milestoneId');
				var year = $(element).closest('.form-group').data('year');
				var month = $(element).closest('.form-group').data('month');
				var week = $(element).closest('.form-group').data('week');
				var value = $(element).val();
				var domId = $(element).attr('id');
				var csrfTokenName = $('#input-csrfTokenName').val();
				var csrfToken = $('#input-csrfToken').val();

				// console.log(domId, milestoneId, year, month, week, value, csrfTokenName, csrfToken);

				var postData = {};
				postData['content'] = value;
				postData['year'] = year;
				postData['month'] = month;
				postData['week'] = week;
				postData['domId'] = domId;
				postData['key'] = 'value';
				postData[csrfTokenName] = csrfToken;

				$.post(baseUrl+'/api/updateMilestoneWeekValue?id='+milestoneId, postData, function(json) {
					if(json.status == 'success')
					{
						$('#'+json.meta.domId).closest('.form-group').addTempClass('has-success', 3000);
						$('#'+json.meta.domId).closest('.form-group').find('.glyphicon').removeClass('glyphicon-remove text-danger').addTempClass('glyphicon-ok text-success', 3000);
					}
					else
					{
						$('#'+json.meta.domId).closest('.form-group').addTempClass('has-error', 10000);
						$('#'+json.meta.domId).closest('.form-group').find('.glyphicon').removeClass('glyphicon-ok text-success').addTempClass('glyphicon-remove text-danger', 10000);
						toastr.error(json.msg);
					}
				}, 'json');

			},
			changedRealized: function(e)
			{
				var element = e.target;
				var milestoneId = $(element).closest('.form-group').data('milestoneId');
				var year = $(element).closest('.form-group').data('year');
				var month = $(element).closest('.form-group').data('month');
				var week = $(element).closest('.form-group').data('week');
				var value = $(element).is(':checked')?true:false;
				var domId = $(element).attr('id');
				var csrfTokenName = $('#input-csrfTokenName').val();
				var csrfToken = $('#input-csrfToken').val();

				// console.log(domId, milestoneId, year, month, week, value, csrfTokenName, csrfToken);

				var postData = {};
				postData['content'] = value;
				postData['year'] = year;
				postData['month'] = month;
				postData['week'] = week;
				postData['domId'] = domId;
				postData[csrfTokenName] = csrfToken;

				$.post(baseUrl+'/api/updateMilestoneWeekRealized?id='+milestoneId, postData, function(json) {
					if(json.status == 'success')
					{
						$('#'+json.meta.domId).closest('.form-group').addTempClass('has-success', 3000);
						$('#'+json.meta.domId).closest('.form-group').find('.glyphicon').removeClass('glyphicon-remove text-danger').addTempClass('glyphicon-ok text-success', 3000);
					}
					else
					{
						$('#'+json.meta.domId).closest('.form-group').addTempClass('has-error', 10000);
						$('#'+json.meta.domId).closest('.form-group').find('.glyphicon').removeClass('glyphicon-ok text-success').addTempClass('glyphicon-remove text-danger', 10000);
						$('#'+json.meta.domId).prop('checked', !json.meta.content);
						toastr.error(json.msg);
					}
				}, 'json');

			},
			setViewMode: function(e)
			{
				this.viewMode = $(e.target).data('code');
				$(e.target).siblings('.btn').removeClass('btn-primary').addClass('btn-white');
				$(e.target).addClass('btn-primary').removeClass('btn-white');

				var csrfTokenName = $('#input-csrfTokenName').val();
				var csrfToken = $('#input-csrfToken').val();

				var postData = {};
				postData['viewMode'] = this.viewMode;
				postData[csrfTokenName] = csrfToken;

				$.post(baseUrl+'/api/updateMilestoneViewMode?id='+this.id, postData, function(json) {
					if(json.status == 'success')
					{

					}
				}, 'json');

				this.renderViewMode();
			},
			renderViewMode: function()
			{
				// console.log('renderViewMode', this.viewMode);

				if(this.viewMode == 'monthly')
				{
					for(m=1; m<=12; m++)
					{
						$('#section-month-'+m).show().addClass('col-sm-6').removeClass('col-sm-12');
						$('#section-month-'+m+'-week-4').show().addClass('col-sm-12').removeClass('col-sm-3');
						for(w=1; w<=3; w++) $('#section-month-'+m+'-week-'+w).hide();
					}
				}
				// every 3 months
				else if(this.viewMode == 'quaterly')
				{
					for(m=1; m<=12; m++) $('#section-month-'+m).hide();
					for(m=3; m<=12; m+=3)
					{
						$('#section-month-'+m).show().addClass('col-sm-6').removeClass('col-sm-12');
						$('#section-month-'+m+'-week-4').show().addClass('col-sm-12').removeClass('col-sm-3');
						for(w=1; w<=3; w++) $('#section-month-'+m+'-week-'+w).hide();

					}
				}
				// every 6 months
				else if(this.viewMode == 'semiyearly')
				{
					for(m=1; m<=12; m++) $('#section-month-'+m).hide();
					for(m=6; m<=12; m+=6)
					{
						$('#section-month-'+m).show().addClass('col-sm-6').removeClass('col-sm-12');
						$('#section-month-'+m+'-week-4').show().addClass('col-sm-12').removeClass('col-sm-3');
						for(w=1; w<=3; w++) $('#section-month-'+m+'-week-'+w).hide();

					}
				}
				// yearly
				else if(this.viewMode == 'yearly')
				{
					for(m=1; m<=12; m++) $('#section-month-'+m).hide();
					m = 12;
					$('#section-month-'+m).show().addClass('col-sm-12').removeClass('col-sm-6');
					$('#section-month-'+m+'-week-4').show().addClass('col-sm-12').removeClass('col-sm-3');
					for(w=1; w<=3; w++) $('#section-month-'+m+'-week-'+w).hide();
				}
				else
				{
					for(m=1; m<=12; m++)
					{
						$('#section-month-'+m).show().addClass('col-sm-6').removeClass('col-sm-12');
						for(w=1; w<=4; w++) $('#section-month-'+m+'-week-'+w).show().addClass('col-sm-3').removeClass('col-sm-12');
					}
				}
			},
		}
	})

");
?>
