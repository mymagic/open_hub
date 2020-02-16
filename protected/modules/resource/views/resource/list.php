<section>
    <div class="md:flex md:items-center md:justify-between">
        <h2>Resources List</h2>
        <a style="text-decoration: none;" href="<?php echo $this->createUrl('/resource/resource/create', array('organization_id' => $organization->id, 'realm' => 'cpanel')); ?>">
            <h3>Create Resources <i class="fa fa-arrow-right"></i></h3>
        </a>
    </div>
    <div class="row">
        <?php $this->widget('application.components.widgets.GridView', array(
            'id' => 'resource-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
                //array('name'=>'id', 'cssClassExpression'=>'id', 'value'=>$data->id, 'headerHtmlOptions'=>array('class'=>'id')),
                // array('name'=>'typefor', 'cssClassExpression'=>'enum', 'value'=>'$data->formatEnumTypefor($data->typefor)', 'headerHtmlOptions'=>array('class'=>'enum'), 'filter'=>$model->getEnumTypefor(false, true)), 
                'title',
                array('name' => 'is_featured', 'cssClassExpression' => 'boolean', 'type' => 'raw', 'value' => 'Html::renderBoolean($data->is_featured)', 'headerHtmlOptions' => array('class' => 'boolean'), 'filter' => $model->getEnumBoolean()),
                array('name' => 'is_active', 'cssClassExpression' => 'boolean', 'type' => 'raw', 'value' => 'Html::renderBoolean($data->is_active)', 'headerHtmlOptions' => array('class' => 'boolean'), 'filter' => $model->getEnumBoolean()),
                array('name' => 'date_added', 'cssClassExpression' => 'date', 'value' => 'Html::formatDateTime($data->date_added, \'medium\', false)', 'headerHtmlOptions' => array('class' => 'date'), 'filter' => false),
                array(
                    'class' => 'application.components.widgets.ButtonColumn',
                    'buttons' => array(
                        'update' => array('url' => 'Yii::app()->controller->createUrl(\'update\', array(\'id\'=>$data->id, \'organization_id\'=>$_GET[organization_id], \'realm\'=>\'cpanel\'))'),
                        'view' => array('url' => 'Yii::app()->controller->createUrl(\'view\', array(\'id\'=>$data->id, \'organizationId\'=>$_GET[organization_id], \'realm\'=>$_GET[realm]))'),
                        // 'update' => array('url' => 'Yii::app()->controller->createUrl(\'update\', array(\'id\'=>$data->id, \'organization_id\'=>$_GET[organization_id], \'realm\'=>$_GET[realm])))'),
                        'delete' => array('visible' => false)
                    ),
                ),
            ),
        )); ?>
    </div>


</section>