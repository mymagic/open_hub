<div class="viewCard col-sm-6 item-flex">
    <div class="media margin-md">

    <div class="media-left">
    </div>
    <div class="media-body">
        <a href="<?php echo $this->createUrl('/eventRegistration/view', array('id' => $data->id)); ?>">
        <h4 class="media-heading">
            <?php echo $data->full_name; ?>
            <small><span class="text-muted">
                <?php if (!empty($data->gender)): ?>(<?php echo $data->formatEnumGender($data->gender); ?>) <?php endif; ?>
            </span>
            </small>
        </h4></a>
        <p><?php if (!empty($data->registration_code)): ?>#<?php echo $data->registration_code; ?> - <?php endif; ?><b><a href="<?php echo $this->createUrl('/event/view', array('id' => $data->event->id)); ?>"><?php echo $data->event->title; ?></a></b><br />Attendance: <?php echo Html::renderBoolean($data->is_attended); ?></p>
        <?php if (!empty($data->organization)): ?><div><span class="label label-white"><?php echo YsUtil::truncate($data->organization, 25); ?></span></div><?php endif; ?>
        <?php // if (Yii::app()->user->isSuperAdmin || Yii::app()->user->isSensitiveDataAdmin):?>
        <?php if (HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'backend', 'action' => (object)['id' => 'searchJourney'], 'module' => (object)['id' => 'journey']]) || Yii::app()->user->getState('accessSensitiveData')): ?>
            <?php if (!empty($data->email)): ?>
                <a class="label label-primary margin-right-sm" style="display:inline-block" href="<?php echo $this->createUrl('/journey/backend/searchJourney', array('email' => $data->email)); ?>"><?php echo Html::faIcon('fa fa-envelope'); ?> <?php echo $data->email; ?></a>
            <?php endif; ?>
            <?php if (!empty($data->mobile_number)): ?>&nbsp;
                <a class="label label-primary margin-right-sm" style="display:inline-block" href="<?php echo $this->createUrl('/journey/backend/searchJourney', array('mobileNo' => $data->mobile_number)); ?>">
                <?php echo Html::faIcon('fa fa-phone'); ?> <?php echo $data->mobile_number; ?></a>
            <?php endif; ?>
        <?php endif; ?>
        </p>
    </div>
    </div>
</div>


