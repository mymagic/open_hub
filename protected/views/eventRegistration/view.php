<?php
/* @var $this EventRegistrationController */
/* @var $model EventRegistration */

$this->breadcrumbs = array(
    'Event Registrations' => array('index'),
    $model->id,
);

$this->menu = array(
    array('label' => Yii::t('app', 'Manage EventRegistration'), 'url' => array('/eventRegistration/admin')),
    array('label' => Yii::t('app', 'Create EventRegistration'), 'url' => array('/eventRegistration/create')),
    array('label' => Yii::t('app', 'Update EventRegistration'), 'url' => array('/eventRegistration/update', 'id' => $model->id)),
);
?>


<h1><?php echo Yii::t('backend', 'View Event Registration'); ?></h1>

<div class="crud-view">
<?php $this->widget('application.components.widgets.DetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        array('name' => 'event_code', 'type' => 'raw', 'value' => Html::link($model->event->title, $this->createUrl('event/view', array('id' => $model->event->id)))),
        'event_vendor_code',
        'registration_code',
        'full_name',
        'first_name',
        'last_name',
        'email',
        'phone',
        'organization',
        array('name' => 'gender', 'value' => $model->formatEnumGender($model->gender)),
        'age_group',
        'where_found',
        'persona',
        'nationality',
        array('label' => $model->attributeLabel('paid_fee'), 'value' => $model->paid_fee),
        array('name' => 'is_attended', 'type' => 'raw', 'value' => Html::renderBoolean($model->is_attended)),
        array('name' => 'is_bumi', 'type'=>'raw', 'value'=>Html::renderBoolean(HUB::checkEventRegistrationIsBumiStatus($model))), 
        array('label' => $model->attributeLabel('date_registered'), 'value' => Html::formatDateTime($model->date_registered, 'long', 'medium')),
        array('label' => $model->attributeLabel('date_payment'), 'value' => Html::formatDateTime($model->date_payment, 'long', 'medium')),
        array('label' => $model->attributeLabel('date_added'), 'value' => Html::formatDateTime($model->date_added, 'long', 'medium')),
        array('label' => $model->attributeLabel('date_modified'), 'value' => Html::formatDateTime($model->date_modified, 'long', 'medium')),

        // developer only
        array('name' => 'json_original', 'type' => 'raw', 'value' => sprintf('<textarea class="full-width" rows="6" disabled>%s</textarea>', nl2br($model->json_original)), 'visible' => Yii::app()->user->isDeveloper),
    ),
)); ?>

</div>

