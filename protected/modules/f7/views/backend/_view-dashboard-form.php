<div id="vue-form-backendDashboard">
   	
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

            <div v-if="data" class="ibox float-e-margins ibox-content inspinia-timeline">
            <div v-for="form in data" class="timeline-item">
                    
                <div class="row">
                    <div class="col-xs-3 date">
                        <i class="fa fa-file-text"></i>
                        <small class="text-muted">From</small> <span class="text-navy">{{form.fDateOpenDateOnly}}</span><br />
                        <small>{{form.fDateOpenTimeOnly}}</small><br />
                        <small class="text-muted">to</small> <span class="text-navy">{{form.fDateCloseDateOnly}}</span><br />
                        <small>{{form.fDateCloseTimeOnly}}</small>
                    </div>
                    <div class="col-xs-9 content">
                        
                        <p class="m-b-xs">
                            <span v-if="form.intakes[0].id"><a href="<?php echo $this->createUrl('f7/intake/view') ?>?id={{form.intakes[0].id}}">{{form.intakes[0].title}}</a> \ </span>
                            <strong><a href="<?php echo $this->createUrl('f7/form/view') ?>?id={{form.id}}">{{form.title}}</a> </strong>
                        </p>
                        
						<p>{{form.intakes[0].textOneliner}}</p>
						
						<p>
							<button class="btn btn-xs btn-default margin-right">Draft <span class="badge">{{form.fCountDraftSubmissions}}</span></button>
							<button class="btn btn-xs btn-success margin-right">Submit <span class="badge">{{form.fCountSubmittedSubmissions}}</span></button> 
	
							<button v-for="(workflowName, workflowCount) in form.fCountWorkflowSubmissions" class="btn btn-xs btn-white margin-right-sm">{{workflowName | capitalize}} <span class="badge">{{workflowCount}}</span></button> 
						
						</p>
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



<?php Yii::app()->clientScript->registerScript('backend-dashboard-form-vuejs', "
var vue = new Vue({
	el: '#vue-form-backendDashboard',
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
				$.get(baseUrl+'/f7/backend/getOpeningForms?dateStart='+self.dateStart+'&dateEnd='+self.dateEnd+'&forceRefresh='+forceRefresh, function( json ) 
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