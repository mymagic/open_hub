
<div class="panel panel-default" id="vue-systemActivity">
    <div class="panel-heading">System Activity <small class="text-muted">(max 30 records each)</small> <span class="pull-right">Start: 
        <?php $this->widget('application.yeebase.extensions.CJuiDateTimePicker.CJuiDateTimePicker',array(
            'name'=>'dateStart',
            'value'=>date('Y-m-d', strtotime('this week monday')),
            // additional javascript options for the date picker plugin
            'options'=>array(
                'showAnim'=>'fold',
                'dateFormat'=>'yy-mm-dd',
                'changeMonth' => true, 
                'changeYear' => true,
                'timeInput' => false,
                'showTime' => false,
                'showHour' => false,
                'showMinute' => false,
                'showTimepicker' => false,
                
            ),
            'htmlOptions'=>array(
                'v-model' => 'dateStart'
            ),
        )); ?>
        End: 
        <?php $this->widget('application.yeebase.extensions.CJuiDateTimePicker.CJuiDateTimePicker',array(
            'name'=>'dateEnd',
            'value'=>date('Y-m-d', strtotime('this week sunday')),
            // additional javascript options for the date picker plugin
            'options'=>array(
                'showAnim'=>'fold',
                'dateFormat'=>'yy-mm-dd',
                'changeMonth' => true, 
                'changeYear' => true,
                'timeInput' => false,
                'showTime' => false,
                'showHour' => false,
                'showMinute' => false,
                'showTimepicker' => false,
            ),
            'htmlOptions'=>array(
                'v-model' => 'dateEnd'
            ),
        )); ?>
    <button class="btn btn-xs btn-primary" v-on:click="fetchData(0)">Go</button>
    <a class="btn btn-xs btn-white" v-on:click="fetchData(1)"><?php echo Html::faIcon('fa-refresh') ?></a></span></div>

    <div class="panel-body">
        <template v-if="loading">
            <div class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i></div>
        </template>
        <template v-else>

        <template v-if="status!='success'">
            <p class="text-danger">{{msg}}</p>
        </template>
        <template v-else>

            <div v-if="data.events" class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Events <span class="badge badge-primary">{{data.events.length}}</span></h5>
                    <div class="ibox-tools">
                        <a v-on:click="isCollapsed" class="collapse-link">
                        <i class='fa fa-chevron-up' ></i>
                        </a>
                    </div>
                </div>
                <div v-for="event in data.events" class="ibox-content inspinia-timeline" v-bind:class="{'is-collapsed' : collapsed }">
                    <div class="timeline-item">
                        <div class="row">
                            <div class="col-md-1 date">
                                <i class="fa fa-calendar"></i><br/>
                            </div>
                            <div class="col-md-11 content no-top-border">
                                <a href="{{event.urlBackendView}}" target="_blank">
                                <span class="text-muted">{{event.fDateStarted}}</span><br />
                                <b>{{event.title}}</b><br /> started at {{event.at}}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="data.mentorBookings" class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Mentorship</h5>
                <div class="ibox-tools">
                    <a v-on:click="isCollapsed" class="collapse-link">
                        <i class='fa fa-chevron-up' ></i>
                    </a>
                </div>
            </div>
            <div v-for="mentorProgram in data.mentorBookings" class="ibox-content inspinia-timeline" v-bind:class="{'is-collapsed' : collapsed }">
                <div class="timeline-item">
                    <p class="m-b-xs"><strong>{{mentorProgram.programName}}</strong> <span class="badge badge-primary">{{mentorProgram.upcomingBookings.length}}</span></p>
                    <div v-for="upcomingBooking in mentorProgram.upcomingBookings">

                    <div class="row">
                        <div class="col-md-1 date">
                            <i class="fa fa-users"></i>
                            <br/>
                        </div>
                        <div class="col-md-11 content no-top-border">
                            <a href="{{upcomingBooking.urlBackendView}}" target="_blank">
                                <span class="text-muted">{{upcomingBooking.fBookingTime}}</span><br />
                                #{{upcomingBooking.id}} {{upcomingBooking.mentor.firstname}} {{upcomingBooking.mentor.lastname}} ({{upcomingBooking.mentor.email}}) mentoring {{upcomingBooking.mentee.firstname}} {{upcomingBooking.mentee.lastname}} ({{upcomingBooking.mentee.email}}) thru {{upcomingBooking.sessionMethod}}
                            </a>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            </div>

            <div v-if="data.newOrganizations" class="ibox float-e-margins">
                <div class="ibox-title">
                <h5>Companies <span class="badge badge-primary">{{data.newOrganizations.length}}</span></h5>
                <div class="ibox-tools">
                    <a v-on:click="isCollapsed" class="collapse-link">
                        <i class='fa fa-chevron-up' ></i>
                    </a>
                </div>
                </div>
                <div v-for="organization in data.newOrganizations" class="ibox-content inspinia-timeline">
                    <div class="timeline-item">
                            <div class="row">
                                <div class="col-md-1 date">
                                    <i class="fa fa-building"></i>
                                    <br/>
                                </div>
                                <div class="col-md-11 content no-top-border">
                                    <a href="{{organization.urlBackendView}}" target="_blank">
                                        <span class="text-muted">{{organization.fDateAdded}} </span><br />
                                        <b>{{organization.title}}</b> <template v-if="organization.dateAdded==organization.dateModified">created</template><template v-else>modified</template>
                                    </a>
                                </div>
                            </div>
                    </div>
                </div>

            </div>

            <div v-if="data.newOrganizationEmailRequests" class="ibox float-e-margins">
                <div class="ibox-title">
                <h5>Join Requests <span class="badge badge-primary">{{data.newOrganizationEmailRequests.length}}</span></h5>
                <div class="ibox-tools">
                    <a v-on:click="isCollapsed" class="collapse-link">
                        <i class='fa fa-chevron-up' ></i>
                    </a>
                </div>
                </div>
                <div class="ibox-content inspinia-timeline">
                    <div class="timeline-item">
                            <div v-for="emailRequest in data.newOrganizationEmailRequests">
                            <div class="row">
                                <div class="col-md-1 date">
                                    <i class="fa fa-sign-in"></i>
                                    <br/>
                                </div>
                                <div class="col-md-11 content no-top-border">
                                    <a href="{{emailRequest.organization.urlBackendView}}" target="_blank">
                                        <span class="text-muted">{{emailRequest.fDateModified}}</span><br />
                                        <b>'{{emailRequest.userEmail}}'</b> request to join <b>'{{emailRequest.organization.title}}'</b> is now {{emailRequest.fStatus}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <div v-if="data.modifiedResources" class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Resources <span class="badge badge-primary">{{data.modifiedResources.length}}</span></h5>
                    <div class="ibox-tools">
                        <a v-on:click="isCollapsed" class="collapse-link">
                            <i class='fa fa-chevron-up' ></i>
                        </a>
                    </div>
                </div>
                <div v-for="resource in data.modifiedResources" class="ibox-content inspinia-timeline">
                    <div class="timeline-item">
                        <div class="row">
                            <div class="col-md-1 date">
                                <i class="fa fa-clipboard"></i>
                                <br/>
                            </div>
                            <div class="col-md-11 content no-top-border">
                                <a href="{{resource.urlBackendView}}" target="_blank">
                                    <span class="text-muted">{{resource.fDateModified}}</span> <br />
                                    <b>#{{resource.id}} - <b>'{{resource.title}}'</b> of <b>'{{resource.fTypefor}}'</b> <template v-if="resource.dateAdded==resource.dateModified">created</template><template v-else>modified</template>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ibox float-e-margins" v-if="data.newUsers">
                <div class="ibox-title">
                    <h5>New Users <span class="badge badge-primary">{{data.newUsers.length}}</span></h5>
                    <div class="ibox-tools">
                        <a v-on:click="isCollapsed" class="collapse-link">
                            <i class='fa fa-chevron-up' ></i>
                        </a>
                    </div>
                </div>
                <div v-for="user in data.newUsers" class="ibox-content inspinia-timeline">
                    <div class="timeline-item">
                        <div class="row">
                            <div class="col-md-1 date">
                                <i class="fa fa-user"></i>
                                <br/>
                            </div>
                            <div class="col-md-11 content no-top-border">
                                <a href="{{user.urlBackendView}}" target="_blank">
                                    <span class="text-muted">{{user.fDateAdded}}</span><br />
                                    <b>'{{user.profile.fullName}}' ({{user.username}})</b> joined
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
        </template>

        </template>

    </div>
</div>



<?php Yii::app()->clientScript->registerScript('backend-dashboard-systemActivity-vuejs', "
var vue = new Vue({
	el: '#vue-systemActivity',
	data: {loading:false, collapsed: false, dateStart:'', dateEnd:'', status:'fail', msg:'', meta:'', data:''},
	created: function(){this.fetchData(0);},
	ready: function () 
	{
		this.fetchData(0);
	},
	methods: 
	{
		isCollapsed : function(event) {
           var ibox = $(event.currentTarget).closest('div.ibox');
           var button = $(event.currentTarget).find('i');
           var content = ibox.find('div.ibox-content');
        	content.slideToggle(200);
        	button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
        },
		fetchData: function(forceRefresh)
		{
			var self = this;
			if(self.dateStart != '' && self.dateEnd != '')
			{
				this.loading = true;
				$.get(baseUrl+'/backend/getSystemActFeed?dateStart='+self.dateStart+'&dateEnd='+self.dateEnd+'&forceRefresh='+forceRefresh, function( json ) 
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