
<?php
$bootstrapVersion = Yii::app()->controller->layoutParams['bootstrapVersion'];
$jqueryVersion = Yii::app()->controller->layoutParams['jqueryVersion'];

$cs = Yii::app()->clientScript;
$cs->scriptMap["jquery.js"] = Yii::app()->theme->baseUrl . "/vendors/jquery/jquery-{$jqueryVersion}.min.js";
$cs->registerScriptFile(Yii::app()->theme->baseUrl . "/vendors/bootstrap-{$bootstrapVersion}/js/bootstrap.min.js" , CClientScript::POS_HEAD);
?>
<div id="vue-organization-backendDashboard">
   	
	<div class="well text-center">
		Start: 
			<?php $this->widget('application.yeebase.extensions.CJuiDateTimePicker.CJuiDateTimePicker', array(
				'name' => 'dateStart',
				'value' => date('Y-m-d', strtotime('this week monday')),
				// additional javascript options for the date picker plugin
				'options' => array(
					'showAnim' => 'fold',
					'dateFormat' => 'yy-mm-dd',
					'changeMonth' => true,
					'changeYear' => true,
					'timeInput' => false,
					'showTime' => false,
					'showHour' => false,
					'showMinute' => false,
					'showTimepicker' => false,
				),
				'htmlOptions' => array(
					'v-model' => 'dateStart'
				),
			)); ?>
			End: 
			<?php $this->widget('application.yeebase.extensions.CJuiDateTimePicker.CJuiDateTimePicker', array(
				'name' => 'dateEnd',
				'value' => date('Y-m-d', strtotime('this week sunday')),
				// additional javascript options for the date picker plugin
				'options' => array(
					'showAnim' => 'fold',
					'dateFormat' => 'yy-mm-dd',
					'changeMonth' => true,
					'changeYear' => true,
					'timeInput' => false,
					'showTime' => false,
					'showHour' => false,
					'showMinute' => false,
					'showTimepicker' => false,
				),
				'htmlOptions' => array(
					'v-model' => 'dateEnd'
				),
			)); ?>
		<button class="btn btn-xs btn-primary" v-on:click="fetchData(0)">Go</button>
		<a class="btn btn-xs btn-white" v-on:click="fetchData(1)"><?php echo Html::faIcon('fa-refresh') ?></a>
	</div>

    <div>
        <template v-if="loading">
            <div class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i></div>
        </template>
        <template v-else>

        <template v-if="status!='success'">
            <p class="text-danger">{{msg}}</p>
        </template>
        <template v-else>

            <div v-if="data" class="ibox float-e-margins">
            <div class="ibox-content inspinia-timeline">
          
				<div v-for="organization in data">

					<div class="timeline-item">
						<div class="row">
							<div class="col-xs-3 date">
								<i class="fa fa-briefcase"></i>
								{{organization.fDateModified}}
							</div>
							<div class="col-xs-9 content">
								<a href="{{organization.urlBackendView}}">
								<p class="m-b-xs"><strong>{{organization.title}} </strong> <template v-if="organization.dateAdded==organization.dateModified">created</template><template v-else>modified</template>
                                </p>
								</a>
								</a>
							</div>
						</div>
					</div>
				
				</div>
            </div>
            </div>
            
        </template>

        </template>

    </div>
</div>



<?php Yii::app()->clientScript->registerScript('backend-dashboard-organization-vuejs', "
var vue = new Vue({
	el: '#vue-organization-backendDashboard',
    data: {loading:false, collapsed: false, dateStart:'', dateEnd:'', status:'fail', msg:'', meta:'', data:''},
    ready: function () 
	{
		//this.fetchData(0);
	},
	methods: 
	{
		fetchData: function(forceRefresh)
		{
			var self = this;
			if(self.dateStart != '' && self.dateEnd != '')
			{
				this.loading = true;
				$.get(baseUrl+'/journey/backend/getOrganizationSystemActFeed?dateStart='+self.dateStart+'&dateEnd='+self.dateEnd+'&forceRefresh='+forceRefresh, function( json ) 
				{
					self.data = json.data;
					self.status = json.status;
					self.meta = json.meta;
					self.msg = json.msg;
				}).always(function() {
					self.loading = false;
				});
			}
		}
	}
});");
?>