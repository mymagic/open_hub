<a data-load-url="<?php echo $this->createUrl('cpanel/createExperience') ?>" id="btn-cv-addNewExperience" class="btn btn-primary btn-sm pull-right"><?php echo Html::faIcon('fa-plus') ?> <?php echo Yii::t('cv', 'Add New') ?></a>
<h2><?php echo Yii::t('cv', 'Manage Experience') ?></h2>
<p><?php echo Yii::t('cv', 'Please click on the following items to manage') ?>

<div id="vue-cv-cpanel-experience">

<template v-if="loading">
    <div class="text-center margin-bottom-lg"><i class="fa fa-spinner fa-spin fa-2x"></i></div>
</template>

<template v-if="status!='success'">
    <p class="text-danger">{{msg}}</p>
</template>
<template v-else>

    <div v-if="data" class="experiences">

		<template v-for="record in data" >
        <div class="box-experience rounded-md" v-bind:class="(record.isEndorsed=='1')?'box-experience-endorsed':''" >
		
		<template v-if="record.isEndorsed==='1'">
			<div class="row">		
				<div class="col col-xs-1"><i class="fa fa-2x" v-bind:class="record.faIcon"></i></div>
				<div class="col col-xs-11">
					<h3><span class="text-slim">{{record.title}} <template v-if="record.organization_name"><span class="text-muted">at</span> {{record.organization_name}}</span></template></h3>
					<p class="text-muted">{{record.monthNameStart}} {{record.yearStart}} </p>
                    <span class="endorsed"><img src="/images/endorsed.png" alt=""></span>
				</div>
			</div>
		</template>
		<template v-else>
			<div class="row pointer" :data-load-url="'<?php echo $this->createUrl('cpanel/viewExperience') ?>/?id='+record.id" id="btn-cv-viewExperience" >
				
                <div class="col col-xs-1"><i class="fa fa-2x" v-bind:class="record.faIcon"></i></div>
                <div class="col col-xs-11">
                    <h3><span class="text-slim">{{record.title}} <template v-if="record.organization_name"><span class="text-muted">at</span> {{record.organization_name}}</span></template></h3>
                    <p class="text-muted">{{record.monthNameStart}} {{record.yearStart}} </p>
				</div>
				
            </div>
		</template>
		
		</div>
		</template>
    </div>

    <a class="btn btn-white btn-block margin-top-lg"  v-on:click="loadMore()" v-if="!allLoaded"><i class="fa fa-spinner fa-spin" v-if="loading"></i> <?php echo Yii::t('cv', 'Load More') ?></a>

</template>

</div>



<?php Yii::app()->clientScript->registerScript('cv-experience-vuejs', "
// vuejs2 code
vue = new Vue({
	el: '#vue-cv-cpanel-experience',
	data: {loading:false, page:'1', totalPages:'1', status:'fail', msg:'', meta:'', data:[], allLoaded:false},
	created: function(){this.fetchData(0);},
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
				
				if(forceRefresh==1){
					self.page = '1'; 
					self.totalPages = '1'; 
					self.data=[]; 
					self.allLoaded=false;
				}

				$.get(baseUrl+'/cv/cpanel/listExperiences?page='+self.page, function( json ) 
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
					self.totalPages = json.meta.output.totalPages;

					if(json.meta.output.totalPages-json.meta.input.page <1){self.allLoaded = true;}

				}).always(function() {
					self.loading = false;
				});
			}
		}
	}
});");
?>


<?php Yii::app()->clientScript->registerScript(
'cv-cpanel-experience',
<<<EOD

$('body').on( "click", '#btn-cv-addNewExperience', function(e) {
    var url2Load = $(this).data('loadUrl');
    $('#modal-common').html('<div class="text-center text-white margin-top-3x">'+$('#block-spinner').html()+'</div>').load(url2Load, function(response, status, xhr){}).modal('show');
});

$('body').on( "click", '#btn-cv-viewExperience', function(e) {
    var url2Load = $(this).data('loadUrl');
    $('#modal-common').html('<div class="text-center text-white margin-top-3x">'+$('#block-spinner').html()+'</div>').load(url2Load, function(response, status, xhr){}).modal('show');
});
					

EOD
); ?>