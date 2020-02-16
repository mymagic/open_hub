<?php if(!empty($actions['journey'])): ?>
<div class="row">
    <div class="col col-md-12">
    <div class="well text-center">
    <?php foreach($actions['journey'] as $action): ?>
        <a class="margin-bottom-sm btn btn-<?php echo $action['visual']?>" href="<?php echo $action[url] ?>" title="<?php echo $action['title'] ?>"><?php echo $action[label] ?></a>
    <?php endforeach; ?>
    </div>
    </div>
</div>
<?php endif; ?>


<div class="row">
    <div class="col col-md-12">
    <?php if(!empty($model->eventRegistrations)): ?>
        <div class="row"><div class="col col-xs-12 margin-top-lg">
        <?php 
            $totalRegistrations = count($model->eventRegistrations);
            $totalAttended = count($model->eventRegistrationsAttended);
        ?>

        <span class="pull-right">
            <span class="label label-primary"><?php echo $totalRegistrations ?></span> Registered 
            <span class="label label-success"><?php echo $totalAttended ?></span> Attended
            <span class="label label-default"><?php echo sprintf('%.2f', ($totalAttended/$totalRegistrations)*100) ?>%</span> Turnout
        </span>
        <h3><?php echo Html::faIcon('fa fa-user') ?> Event Participated</h3>

        <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>No</th>
            <th>Event Date</th>
            <th>Event</th>
            <th>Registered Detail</th>
            <th class="text-center">Attended</th>
            <th class="text-center">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php $i=0; foreach($model->eventRegistrations as $registration): ?>
        <tr>
            <td><?php echo ++$i ?></td>
            <td><?php echo Html::formatDateTime($registration->event->date_started, 'standard', false) ?></td>
            <td><?php echo Html::link($registration->event->title, Yii::app()->createUrl('/event/view', array('id'=>$registration->event->id))) ?></td>
            <td>
                <label>Name:</label> <?php echo $registration->full_name ?><br />	
                <label>Email:</label> <?php echo $registration->email ?><br />
                <label>Phone:</label> <?php echo $registration->phone ?><br />
                <label>Company:</label> <?php echo $registration->organization ?>
            </td>
            <td class="text-center"><?php echo Html::renderBoolean($registration->is_attended) ?></td>
            <td class="text-center"><a class="btn btn-xs btn-primary" href="<?php echo $this->createUrl('/eventRegistration/view', array('id'=>$registration->id)) ?>">View</a></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
        </table>
        </div></div>
        <?php endif; ?>
    </div>
</div>

