<div id="vue-event-backendDashboard">
   	
	<div class="well text-center">
		Start: 
		<input type="text" name="dateStart" v-model="dateStart" value="<?php echo date('Y-m-d', strtotime('this week monday')) ?>" placeholder="YYYY-MM-DD" />
		End: 
		<input type="text" name="dateEnd" v-model="dateEnd" value="<?php echo date('Y-m-d', strtotime('this week sunday')) ?>" placeholder="YYYY-MM-DD" />
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
          
				<div v-for="event in data">

					<div class="timeline-item">
						<div class="row">
							<div class="col-xs-3 date">
								<i class="fa fa-calendar"></i>
								<small class="text-muted">From</small> <span class="text-navy">{{event.fDateStartedDateOnly}}</span><br />
								<small>{{event.fDateStartedTimeOnly}}</small><br />
								<small class="text-muted">to</small> <span class="text-navy">{{event.fDateEndedDateOnly}}</span><br />
								<small>{{event.fDateEndedTimeOnly}}</small>
							</div>
							<div class="col-xs-9 content">
								<a href="{{event.urlBackendView}}">
								<p class="m-b-xs">
									<span v-if="event.eventGroupCode"><a href="<?php echo $this->createUrl('eventGroup/view') ?>?id={{event.eventGroup[0].id}}">{{event.eventGroup[0].title}}</a> \ </span>
									<strong><a href="<?php echo $this->createUrl('event/view') ?>?id={{event.id}}">{{event.title}}</a> </strong>
								</p>

								<p v-if="event.at">at '{{event.at}}'</p>
								</a>
								</a>
							</div>
						</div>
					</div>
				
				</div>
            </div>
            </div>
			<div v-else>
				<?php echo Notice::inline(Yii::t('backend', 'No data found for above date range')) ?>
			</div>
            
        </template>

        </template>

    </div>
</div>



<?php Yii::app()->clientScript->registerScript('backend-dashboard-event-vuejs', "
var vue = new Vue({
	el: '#vue-event-backendDashboard',
    data: {loading:false, collapsed: false, dateStart:'', dateEnd:'', status:'fail', msg:'', meta:'', data:''},
    ready: function () 
	{
		this.fetchData(0);
	},
	methods: 
	{
		fetchData: function(forceRefresh)
		{
			var self = this;
			if(self.dateStart != '' && self.dateEnd != '')
			{
				this.loading = true;
				$.get(baseUrl+'/journey/backend/getEventSystemActFeed?dateStart='+self.dateStart+'&dateEnd='+self.dateEnd+'&forceRefresh='+forceRefresh, function( json ) 
				{
					self.data = json.data;
					self.status = json.status;
					self.meta = json.meta;
					self.msg = json.msg;

					console.log(json);
				}).always(function() {
					self.loading = false;
				});
			}
		}
	}
});");
?>