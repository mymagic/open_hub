<?php

$this->breadcrumbs = array('Organization' => array('join'), 'Join Exisiting');

?>

<section id="organization-search">
	<h2><?php echo Yii::t('app', 'Join Existing Organization') ?></h2>

	<input class="shadow-panel appearance-none border w-full my-4 py-6 px-8 text-gray-700 leading-tight focus:outline-none focus:shadow-panel" v-model="keyword" id="username" type="text" placeholder="To request access and manage an organization">

	<div class="list_content my-3" v-if="!loading && companies.length > 0">

		<div class="row" v-for="(data, key) in companies" :key="key">
			<div class="col-sm-2 col-md-1 col-lg-1">
				<img :src="data.imageLogoThumbUrl" class="img-responsive" />
			</div>
			<div class="col-sm-5 col-md-7 col-lg-7">
				<h3>{{data.title}}</h3>
				<p class="text-muted">{{data.textOneliner}}</p>
			</div>
			<div class="col-sm-5 col-md-4 col-lg-4">
				<div class="col-xs-12 text-center">
					<a class="btn btn-sd btn-sd-green" :href="baseUrl + '/organization/requestJoinEmail?organizationId=' + data.id + '&email=' + username"><?php echo Yii::t('app', 'Request Access') ?></a>
				</div>
			</div>
			<div class="col-xs-12">

			</div>

		</div>

	</div>

	<div class="my-3" v-if="loading">
		<div class="flex items-center justify-center">
			<div class="loader"></div>
		</div>
	</div>

	<div class="px-8 py-6 nav-select shadow-panel">
		<div class="row md:flex md:items-center">
			<div class="col-md-8">
				<h3><?php echo Yii::t('app', "Don't have an organization yet") ?>?</h3>
				<p><?php echo Yii::t('app', 'If your organization is not exists in our system yet, please create an organization profile here')?></p>
			</div>
			<div class="col-md-4 flex md:justify-end">
				<a class="btn btn-outline btn-default btn-lg" style="color: #333; line-height: 1.3333333;" href="<?php echo $this->createUrl('/organization/create', array('realm' => 'cpanel')); ?>"><?php echo Yii::t('app', 'Create Organization')?> <i class="fa fa-arrow-right"></i></a>
			</div>
		</div>
	</div>


	<hr>


	<?php if (!empty($model)) : ?>
		<h2 class="mb-2" ><?php echo Yii::t('app', 'Waiting for Approval...') ?></h2>

		<div class="list_content my-3">
			<?php foreach ($model as $data) : ?>
				<div class="row">
					<div class="col-sm-2 col-md-1 col-lg-1">
						<img src="<?php echo $data['imageLogoThumbUrl'] ?>" class="img-responsive" />
					</div>
					<div class="col-sm-5 col-md-7 col-lg-7">
						<h3><?php echo $data['title'] ?></h3>
						<p class="text-muted"><?php echo $data['text_oneliner'] ?></p>
						<!-- <?php foreach ($data['industries'] as $industry) : ?>
                            <span class="label label-default"><?php echo $industry['title'] ?></span>
                        <?php endforeach; ?>
                        <?php foreach ($data['sdgs'] as $sdg) : ?>
                            <span class="label label-default"><?php echo $sdg['title'] ?></span>
                        <?php endforeach; ?> -->
					</div>
					<div class="col-sm-5 col-md-4 col-lg-4 md:flex md:items-center">
						<div class="col-xs-6 text-center"><span class="label label-warning"><?php echo Yii::t('app', 'Pending')?></span></div>
						<div class="col-xs-6 text-center"><a type="button" class="btn btn-w-m btn-danger" href="<?php echo Yii::app()->params['baseUrl'] ?>/organization/deleteUserOrganization2Email?organizationID=<?php echo $data['id'] ?>&userEmail=<?php echo Yii::app()->user->username ?>"><?php echo Yii::t('app', 'Remove')?></a></div>
					</div>
					<div class="col-xs-12">

					</div>
				</div>
			<?php endforeach; ?>
		</div>

	<?php endif; ?>


</section>


<?php Yii::app()->clientScript->registerScript('organization-search', "
new Vue({
    el: '#organizatio-search',
    data: () => ({
        keyword: '',
        companies: [],
        loading: false,
        baseUrl: '" . Yii::app()->params['baseUrl'] . "',
        username: '" . Yii::app()->user->username . "'
    }),
    watch: {
        keyword: _.debounce(function (val) {
			this . getOrganization(val);
        }, 2000)
    },
    methods: {
        getOrganization (val) {
            this.loading = true;
            let me = this;
            $.get('" . Yii::app()->params['baseUrl'] . "/api/getUserOrganizationsCanJoin', { keyword: val} )
            .done(function( json ) 
            {
                if(json.data) {
                    me.companies = json.data;
                }

                me.loading = false;
            });
        }
    }
});
"); ?>