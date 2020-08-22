<div class="row">
    <div class="col col-md-12">
        <h3>History Log</h3>

        <div class="" id="vue-organization-esLog">
            <input type="hidden" v-model="organizationId" value="<?php echo $model->id ?>" />
            <template v-if="loading">
                <div class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i></div>
            </template>

            <template v-if="status!='success'">
                <p class="text-danger">{{msg}}</p>
            </template>
            <template v-else>

                <div v-if="data" class="feed-activity-list">
                    <div v-for="record in data" class="feed-element padding-sm margin-sm">
                        <div class="media-body ">
                            <span class="pull-right"><small class="text-muted">{{record.fDateLog}}</small></span>
                            <strong><span class="text-navy">[{{record.context}}]</span> {{record.username}}</strong> {{record.msg}}
                        </div>
                    </div>
                </div>

                <a class="btn btn-primary btn-block margin-top-lg"  v-on:click="loadMore()" v-if="!allLoaded"><i class="fa fa-spinner fa-spin" v-if="loading"></i> Load More</a>

            </template>
        </div>

    <?php Yii::app()->clientScript->registerScript('organization-esLog-vuejs', "
    var vue = new Vue({
        el: '#vue-organization-esLog',
        data: {loading:false, page:'1', organizationId:'99', status:'fail', msg:'', meta:'', data:[], allLoaded:false},
        //created: function(){this.fetchData(0);},
        ready: function () 
        {
            this.fetchData(0);
        },
        methods: 
        {
            loadMore: function()
            {
                var self = this;
                self.page++;
                self.fetchData(0);
            },
            fetchData: function(forceRefresh)
            {
                var self = this;
                {
                    this.loading = true;
                    $.get(baseUrl+'/esLog/api/getOrganizationLog?organizationId='+self.organizationId+'&page='+self.page, function( json ) 
                    {
                        if(json.data != null && json.data.length>0)
                        {
                            for (var i=0; i < json.data.length; i++) {
                                self.data.push( json.data[i] );
                            }
                        }
                        else
                        {
                            self.allLoaded = true;
                        }

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
    </div>
</div>