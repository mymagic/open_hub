<?php 
	Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/vendors/inspinia/css/plugins/fullcalendar/fullcalendar.css');
	Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/vendors/inspinia/css/plugins/fullcalendar/fullcalendar.print.css', 'print');

	Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/vendors/inspinia/js/plugins/pace/pace.min.js', CClientScript::POS_END);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/vendors/inspinia/js/plugins/fullcalendar/fullcalendar.min.js', CClientScript::POS_END);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/vendors/inspinia/js/plugins/fullcalendar/moment.min.js', CClientScript::POS_END);
?>

<?php $bufferJs = '';
$dows['monday'] = 1; $dows['tuesday'] = 2; $dows['wednesday'] = 3; $dows['thursday'] = 4; $dows['friday'] = 5; $dows['saturday'] = 6; $dows['sunday'] = 7;
foreach ($result as $weekday => $r): foreach ($r as $time => $mentors): foreach ($mentors as $mentor): ?>
    <?php $d = new DateTime($time); $d->modify('+30 minutes'); $bufferJs .= sprintf("{title:'%s', start:'%s', end:'%s', dow:[%s]},", $mentor, $time, date_format($d, 'H:i'), $dows[$weekday]); ?>
<?php endforeach; endforeach; endforeach; ?>
<?php //echo $bufferJs;exit;?>
<div class="wrapper wrapper-content">
    <div class="row animated fadeInDown">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    
                </div>
                <div class="ibox-content">
                    
                </div>
            </div>
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                   
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Mentorship Slots</h5>
                    
                </div>
                <div class="ibox-content">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php
Yii::app()->clientScript->registerScript('appCalendar', sprintf("
   $(document).ready(function() {

        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });

        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();

        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            defaultView: 'agendaDay',
            editable: false,
            droppable: true, // this allows things to be dropped onto the calendar
            drop: function() {
                // is the 'remove after drop' checkbox checked?
                if ($('#drop-remove').is(':checked')) {
                    // if so, remove the element from the 'Draggable Events' list
                    $(this).remove();
                }
            },
            events: [%s],
        });


    });
", $bufferJs));
?>