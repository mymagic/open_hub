<h2>Manage Experience</h2>


<div class="row">
<div class="col col-xs-9">
    <?php $cvExperienceMessage = Embed::model()->getByCode('cv-cpanel-adminExperience', 'html_content'); ?>
	<?php echo !empty($cvExperienceMessage) ? Notice::inline($cvExperienceMessage) : ''; ?>
</div>
<div class="col col-xs-3">
	<a href="<?php echo $this->createUrl('cpanel/createExperience') ?>" class="btn btn-primary btn-sm pull-right"><?php echo Html::faIcon('fa-plus') ?> Add New Experience</a>
</div>
</div>

<div class="clearfix"></div>

<?php $this->widget('application.components.widgets.GridView', array(
	'id' => 'experience-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		array('name' => 'genre', 'cssClassExpression' => 'enum', 'value' => '$data->formatEnumGenre($data->genre)', 'headerHtmlOptions' => array('class' => 'enum'), 'filter' => $model->getEnumGenre(false, true)),
		'title',
		'organization_name',
		//array('name' => 'country_code', 'cssClassExpression' => 'foreignKey', 'value' => '$data->country->printable_name', 'headerHtmlOptions' => array('class' => 'foreignKey'), 'filter' => Country::model()->getForeignReferList(false, true)),
		'location',

		array(
			'class' => 'application.components.widgets.ButtonColumn',
			'buttons' => array(
				'view' => array('url' => 'CHtml::normalizeUrl(array("cpanel/viewExperience", "id"=>$data->id))'),
				'update' => array('url' => 'CHtml::normalizeUrl(array("cpanel/updateExperience", "id"=>$data->id))'),
				'delete' => array('url' => 'CHtml::normalizeUrl(array("cpanel/deleteExperience", "id"=>$data->id))'),
			),
		),
	)
)); ?>
