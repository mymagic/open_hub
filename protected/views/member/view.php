<?php
/* @var $this MemberController */
/* @var $model Member */

$this->breadcrumbs = array(
	'Members' => array('index'),
	$model->user_id,
);

$this->menu = array(
	array(
		'label' => Yii::t('app', 'Manage Member'), 'url' => array('/member/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('backend', 'Create Member'), 'url' => array('/member/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
);
?>

<h1><?php echo Yii::t('app', 'View Member'); ?></h1>

<div class="well text-right padding-sm">
	<?php echo Html::btnDanger(Html::faIcon('fa-undo') . '&nbsp;' . Yii::t('app', 'Reset Password'), $this->createUrl('member/resetPassword', array('id' => $model->user->id))); ?>
	<?php echo Html::btnDefault(Html::faIcon('fa-arrow-circle-left') . '&nbsp;' . Yii::t('app', 'Back'), $this->createUrl('member/admin')); ?>
</div>

<?php if (!empty($model->log_admin_alert)): ?>
<div class="panel panel-warning ">
	<div class="panel-heading">
		<?php echo Yii::t('app', 'Alert for admin about this member') ?>
	</div>
	<div class="panel-body nopadding">
		<?php echo Html::htmlArea('log_admin_alert', nl2br($model->log_admin_alert), array('style' => 'height:4em; max-width:100%; border:0; overflow-y:scroll')) ?>
	</div>
</div>
<?php endif; ?>

<div class="row">
	<div class="col-lg-6">
		<!-- user -->
		<div class="panel panel-default">
			<!-- Default panel contents -->
			<div class="panel-heading"><?php echo Yii::t('app', 'User') ?> <?php if (UserSession::isOnlineNow($model->user->id) > 0): ?><span class="label label-success pull-right">Is Online</span><?php endif; ?></div>
			<?php
				if ($model->user->is_active) {
					$htmlBlockUser = sprintf('&nbsp;<a class="btn btn-xs btn-danger pull-right" href="%s"><i class="fa fa-fw fa-minus-square"></i>&nbsp;%s</a>', $this->createUrl('member/block', array('id' => $model->user->id)), Yii::t('app', 'Block'));
				} else {
					$htmlBlockUser = sprintf('&nbsp;<a class="btn btn-xs btn-success pull-right" href="%s"><i class="fa fa-fw fa-check-square"></i>&nbsp;%s</a>', $this->createUrl('member/unblock', array('id' => $model->user->id)), Yii::t('app', 'Unblock'));
				}

				$isTerminated = $model->user->isUserTerminatedInConnect();
				if ($isTerminated) {
					$htmlTerminateUser = sprintf('&nbsp;<a class="btn btn-xs btn-success pull-right" href="%s"><i class="fa fa-fw fa-check-square"></i>&nbsp;%s</a>', $this->createUrl('member/permit', array('id' => $model->user->id)), Yii::t('app', 'Enable'));
				} else {
					$htmlTerminateUser = sprintf('&nbsp;<a class="btn btn-xs btn-danger pull-right" href="%s"><i class="fa fa-fw fa-minus-square"></i>&nbsp;%s</a>', $this->createUrl('member/terminate', array('id' => $model->user->id)), Yii::t('app', 'Terminate'));
				}
				?>
			<?php $this->widget('application.components.widgets.DetailView', array(
				'data' => $model,
				'attributes' => array(
					array('name' => 'user.username', 'type' => 'html', 'value' => Html::renderEmail($model->user->username)),
					array('name' => 'user.profile.mobile_no', 'type' => 'html', 'value' => Html::renderTel($model->user->profile->mobile_no)),
					array('name' => 'user.is_active', 'type' => 'raw', 'value' => Html::renderBoolean($model->user->is_active) . $htmlBlockUser),
					array('name' => 'user.signup_type', 'value' => $model->user->signup_type),
					array('name' => 'user.signup_ip', 'value' => $model->user->signup_ip),
					array('label' => $model->attributeLabel('date_joined'), 'value' => Html::formatDateTime($model->date_joined, 'medium', 'short')),
					array('name' => 'Is Terminated', 'type' => 'raw', 'value' => Html::renderBoolean($isTerminated) . $htmlTerminateUser),
				),
			)); ?>
		</div>
		<!-- /user -->

		<!-- login -->
		<div class="panel panel-default ">
			<!-- Default panel contents -->
			<div class="panel-heading"><?php echo Yii::t('app', 'Statistic & Summary') ?></div>
			<?php $this->widget('application.components.widgets.DetailView', array(
				'data' => $model,
				'attributes' => array(
					array('name' => 'user.last_login_ip', 'value' => $model->user->last_login_ip),
					array('name' => 'user.date_last_login', 'value' => Html::formatDateTime($model->user->date_last_login, 'medium', 'short')),
					array('name' => 'user.stat_login_count', 'type' => 'html', 'value' => sprintf('%s <small>(%s)</small> / %s <small>(%s)</small>', $model->user->stat_login_success_count, Yii::t('app', 'Success'), $model->user->stat_login_count, Yii::t('app', 'Total'))),
				),
			)); ?>
		</div>
		<!-- /login -->

	</div>

	<div class="col-lg-6">

		<!-- profile -->
		<div class="panel panel-default ">
			<!-- Default panel contents -->
			<div class="panel-heading"><?php echo Yii::t('app', 'Profile') ?></div>
			<?php $this->widget('application.components.widgets.DetailView', array(
				'data' => $model,
				'attributes' => array(
					array('name' => 'user.profile.full_name', 'value' => $model->user->profile->full_name),
					array('name' => 'gender', 'value' => $model->user->profile->formatEnumGender($model->user->profile->gender)),
					//array('name'=>'user.profile.language', 'value'=>$model->user->profile->formatEnumLanguage($model->user->profile->language)),
				),
			)); ?>
		</div>
		<!-- /profile -->


	</div>

</div>

<div class="px-8 py-6 shadow-panel mt-4">
	<ul class="nav nav-tabs nav-new new-dash-tab" role="tablist">
		<?php foreach ($tabs as $tabModuleKey => $tabModules) : ?><?php foreach ($tabModules as $tabModule) : ?>
		<li role="presentation" class="tab-noborder <?php echo ($tab == $tabModule['key']) ? 'active' : '' ?>"><a href="#<?php echo $tabModule['key'] ?>" aria-controls="<?php echo $tabModule['key'] ?>" role="tab" data-toggle="tab"><?php echo $tabModule['title'] ?></a></li>
		<?php endforeach; ?><?php endforeach; ?>
	</ul>
	<!-- Tab panes -->
	<div class="tab-content padding-lg white-bg">
		<?php foreach ($tabs as $tabModuleKey => $tabModules) : ?><?php foreach ($tabModules as $tabModule) : ?>
		<div role="tabpanel" class="tab-pane <?php echo ($tab == $tabModule['key']) ? 'active' : '' ?>" id="<?php echo $tabModule['key'] ?>">
			<?php echo $this->renderPartial($tabModule['viewPath'], array('model' => $model, 'member' => $model, 'user' => $user, 'actions' => $actions, 'realm' => $realm, 'tab' => $tab)) ?>
		</div>
		<?php endforeach; ?><?php endforeach; ?>
	</div>
</div>