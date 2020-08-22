<?php Yii::app()->getClientScript()->registerCssFile('https://cdn.jsdelivr.net/npm/@riophae/vue-treeselect@^0.4.0/dist/vue-treeselect.min.css'); ?>
<?php Yii::app()->ClientScript->registerScriptFile('https://cdn.jsdelivr.net/npm/@riophae/vue-treeselect@^0.4.0/dist/vue-treeselect.umd.min.js'); ?>


<div id="v-timeline">
    <h2>Activity Feed</h2>
    <p>Keeping track of your milestones and news of your selected services</p>

    <div class="row">
        <div class="col-md-2">
            <h3>Filter</h3>
        </div>
        <div class="col-md-4">
            <treeselect :options="years" v-model="year" placeholder="Select Year"></treeselect>
        </div>
        <div class="col-md-6">
            <treeselect :options="services" v-model="service" multiple placeholder="Select Services"></treeselect>
        </div>
    </div>


    <div id="vertical-timeline" class="vertical-container light-timeline" v-if="model && !loading">

        <div class="vertical-timeline-block" v-for="(timeline, date) in model" :key="date">
            <div class="vertical-timeline-icon navy-bg">
                <i class="fa fa-calendar"></i>
            </div>
            <div class="vertical-timeline-content" style="padding: 0 1em">
                <div class="text-xl">{{date}}</div>
            </div>
            <div v-for="(timelineData, time) in timeline" :key="time">
                <div class="vertical-timeline-content" v-for="(data, key) in timelineData" :key="key">
                    <h2>{{data.serviceTitle | capitalize}}</h2>
                    <p>{{data.msg}}</p>
                    <a :href="data.actionUrl" class="btn btn-sm btn-primary" v-if="data.actionUrl">{{data.actionLabel}}</a>
                    <span class="vertical-date">
                        <small>{{time}}</small>
                    </span>
                </div>
            </div>
        </div>

    </div>

    <div class="my-3" v-if="model.length < 1 && !loading">
        <div class="flex items-center justify-center">
            <h4>No result found.</h4>
        </div>
    </div>

    <div class="my-3" v-if="loading">
        <div class="flex items-center justify-center">
            <div class="loader"></div>
        </div>
    </div>


</div>

<?php Yii::app()->clientScript->registerScript('v-timeline', "

Vue . component('treeselect', VueTreeselect . Treeselect);

new Vue({
    el: '#v-timeline',
    name: 'timeline',
    mounted () {
        this . getTimeline();
        let dt = new Date();
        for (let i = dt.getFullYear(); i >= 2014 ; i-- ) {
            this.years.push({id: i, label: i});
        }
    },
    filters: {
        capitalize: function (value) {
          if (!value) return ''
          value = value.toString()
          return value.charAt(0).toUpperCase() + value.slice(1)
        }
    },
    data: () => ({
        year: '" . $years . "',
        years: [],
        service: null,
        services: " . CJSON::encode($serviceList) . ",
        loading: false,
        model: '',
        baseUrl: '" . Yii::app()->params['baseUrl'] . "',
        username: '" . Yii::app()->user->username . "'
    }),
    watch: {
        year: _.debounce(function (val) {
			this . getTimeline();
        }, 500),
        service: _.debounce(function (val) {
			this . getTimeline();
        }, 500),
    },
    methods: {
        getTimeline () {
            this.loading = true;
            let me = this;
            $.get('" . Yii::app()->params['baseUrl'] . "/cpanel/getTimeline', { year: me.year, service: me.service} )
            .done(function( json )
            {
                me.model = JSON.parse(json);
                me.loading = false;
            });
        }
    }
});

"); ?>