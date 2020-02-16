<?php
/* @var $this ProductController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Products',
);

?>

<section>
    <div class="md:flex md:items-center md:justify-between">
        <h2>Product List</h2>
        <a style="text-decoration: none;" href="<?php echo $this->createUrl('create', array('organization_id' => $this->customParse, 'realm' => 'cpanel')); ?>">
            <h3>Create Product <i class="fa fa-arrow-right"></i></h3>
        </a>
    </div>
    <div class="row">
        <!-- <?php foreach ($model as $product) : ?>
            <div class="col-md-6 my-4">
                <a href="<?php echo $this->createUrl('coinformation/viewProduct', array('id' => $product->id)); ?>" style="text-decoration: none;">
                    <div class="shadow-panel p-4">
                        <img src="<?php echo StorageHelper::getUrl($product->image_cover) ?>" style="width: 100%; height: 260px; object-fit: cover" class="my-4">
                        <h3><?php echo $product->title ?></h3>
                    </div>
                </a>
            </div>
        <?php endforeach; ?> -->
        <div class="wrapper wrapper-content content-bg content-left-padding">
            <div class="manage-pad">
                <?php $this->widget('application.components.widgets.GridView', array(
                    'id' => 'product-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'columns' => array(
                        //array('name'=>'id', 'cssClassExpression'=>'id', 'value'=>$data->id, 'headerHtmlOptions'=>array('class'=>'id')),
                        'title',
                        // array('name'=>'typeof', 'cssClassExpression'=>'enum', 'value'=>'$data->formatEnumTypeof($data->typeof)', 'headerHtmlOptions'=>array('class'=>'enum'), 'filter'=>$model->getEnumTypeof(false, true)), 
                        array('name' => 'is_active', 'cssClassExpression' => 'boolean', 'type' => 'raw', 'value' => 'Html::renderBoolean($data->is_active)', 'headerHtmlOptions' => array('class' => 'boolean'), 'filter' => $model->getEnumBoolean()),
                        // array('name'=>'date_added', 'cssClassExpression'=>'date', 'value'=>'Html::formatDateTime($data->date_added, \'medium\', false)', 'headerHtmlOptions'=>array('class'=>'date'), 'filter'=>false),

                        array(
                            'class' => 'application.components.widgets.ButtonColumn',
                            'buttons' => array(
                                'view' => array('url' => 'Yii::app()->controller->createUrl(\'view\', array(\'id\'=>$data->id, \'realm\'=>\'cpanel\'))'),
                                'update' => array('url' => 'Yii::app()->controller->createUrl(\'update\', array(\'id\'=>$data->id, \'realm\'=>\'cpanel\'))'),
                                'delete' => array('visible' => false)
                            ),
                        ),
                    ),
                )); ?>
            </div>

        </div>
    </div>


</section>