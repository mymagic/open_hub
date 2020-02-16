<?php $this->widget('application.components.widgets.GridView', array(
	'id'=>$gridId,
    'dataProvider'=>$modelForm->search(),
    'filter'=>$modelForm,
    'viewData' => array('intakeId'=>$intakeId),
	'columns'=>array(
        'form.title',
        array('name'=>'form.date_open', 'cssClassExpression'=>'date', 'value'=>'Html::formatDateTime($data->form->date_open, \'medium\', false)', 'headerHtmlOptions'=>array('class'=>'date'), 'filter'=>false),
        array('name'=>'form.date_close', 'cssClassExpression'=>'date', 'value'=>'Html::formatDateTime($data->form->date_close, \'medium\', false)', 'headerHtmlOptions'=>array('class'=>'date'), 'filter'=>false),
        array('name'=>'form.is_multiple', 'cssClassExpression'=>'boolean', 'type'=>'raw', 'value'=>'Html::renderBoolean($data->form->is_multiple)', 'headerHtmlOptions'=>array('class'=>'boolean'), 'filter'=>false),
        array('name'=>'form.is_active', 'cssClassExpression'=>'boolean', 'type'=>'raw', 'value'=>'Html::renderBoolean($data->is_active)', 'headerHtmlOptions'=>array('class'=>'boolean'), 'filter'=>false), 
        'ordering',
		array(
            'class'=>'application.components.widgets.ButtonColumn',
                'template' => '{view}{unlink}',
				'buttons' => array(
					'view' => array('url'=>'Yii::app()->controller->createUrl("/f7/form/view", array("intakeId"=>$this->grid->viewData[intakeId], "id"=>$data->form->id))'), 
					'unlink' => array('url'=>'Yii::app()->controller->createUrl("/f7/form2Intake/delete", array("id"=>$data->form->id))', 'options'=>array('class'=>'btn btn-xs btn-danger')), 
				),		
		),
	),
)); ?>