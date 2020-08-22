<?php
/* @var $this AdminController */
/* @var $model Admin */

$this->breadcrumbs = array(
	'Admins' => array('index'),
	$model->user_id,
);

$this->menu = array(
	array(
		'label' => Yii::t('backend', 'Manage Admin'), 'url' => array('/admin/admin'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')
	),
	array(
		'label' => Yii::t('backend', 'Create Admin'), 'url' => array('/admin/create'),
		'visible' => HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'create')
	),
	// array('label'=>Yii::t('backend','Reset Password'), 'url'=>array('resetPassword', 'id'=>$model->user->id)),
);
?>

<h1><?php echo Yii::t('backend', 'View Admin'); ?></h1>

<?php if (HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'resetPassword') || HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')): ?>
<div class="well text-right padding-sm">
	<?php if (HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'resetPassword')): ?>
		<?php echo Html::btnDanger(Html::faIcon('fa-undo') . '&nbsp;' . Yii::t('backend', 'Reset Password'), $this->createUrl('admin/resetPassword', array('id' => $model->user->id))); ?>
	<?php endif; ?>
	<?php if (HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'admin')): ?>
		<?php echo Html::btnDefault(Html::faIcon('fa-arrow-circle-left') . '&nbsp;' . Yii::t('backend', 'Back'), $this->createUrl('admin/admin')); ?>
	<?php endif; ?>
</div>
<?php endif; ?>

<div class="row">
	<div class="col-lg-6">
		<!-- user -->
		<div class="panel panel-default">
			<!-- Default panel contents -->
			<div class="panel-heading"><?php echo Yii::t('backend', 'User') ?> <?php if (UserSession::isOnlineNow($model->user->id) > 0): ?><span class="label label-success pull-right">Is Online</span><?php endif; ?></div>
			<?php
				if ($model->user->is_active):
					if (HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'block')):
						$htmlBlockUser = sprintf('&nbsp;<a class="btn btn-xs btn-danger pull-right" href="%s">%s</a>', $this->createUrl('admin/block', array('id' => $model->user->id)), Yii::t('backend', 'Block'));
					endif;
				else:
					if (HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'unblock')):
						$htmlBlockUser = sprintf('&nbsp;<a class="btn btn-xs btn-success pull-right" href="%s">%s</a>', $this->createUrl('admin/unblock', array('id' => $model->user->id)), Yii::t('backend', 'Unblock'));
					endif;
				endif;
				?>
			<?php $this->widget('application.components.widgets.DetailView', array(
				'data' => $model,
				'attributes' => array(
					//array('name'=>'user.nickname', 'value'=>$model->user->nickname),
					array('name' => 'user.username',  'type' => 'html', 'value' => Html::renderEmail($model->user->username)),
					array('name' => 'user.is_active', 'type' => 'raw', 'value' => Html::renderBoolean($model->user->is_active) . $htmlBlockUser),

					array('name' => 'user.signup_type', 'value' => $model->user->signup_type),
					array('name' => 'user.signup_ip', 'value' => $model->user->signup_ip),
				),
			)); ?>
		</div>
		<!-- /user -->

		<!-- login -->
		<div class="panel panel-default ">
			<!-- Default panel contents -->
			<div class="panel-heading"><?php echo Yii::t('backend', 'Login Stat') ?></div>
			<?php $this->widget('application.components.widgets.DetailView', array(
				'data' => $model,
				'attributes' => array(
					array('name' => 'user.last_login_ip', 'value' => $model->user->last_login_ip),
					array('name' => 'user.date_last_login', 'value' => Html::formatDateTime($model->user->date_last_login, 'medium', 'short')),
					array('name' => 'user.stat_login_count', 'type' => 'html', 'value' => sprintf('%s <small>(%s)</small> / %s <small>(%s)</small>', $model->user->stat_login_success_count, Yii::t('backend', 'Success'), $model->user->stat_login_count, Yii::t('backend', 'Total'))),
				),
			)); ?>
		</div>
		<!-- /login -->

		<!-- profile -->
		<div class="panel panel-default ">
			<!-- Default panel contents -->
			<div class="panel-heading"><?php echo Yii::t('backend', 'Profile') ?></div>
			<?php $this->widget('application.components.widgets.DetailView', array(
				'data' => $model,
				'attributes' => array(
					array('name' => 'user.profile.full_name', 'value' => $model->user->profile->full_name),
					array('name' => 'gender', 'value' => $model->user->profile->formatEnumGender($model->user->profile->gender)),
					array('label' => Yii::t('core', 'Address'), 'value' => $model->user->profile->getFullAddress()),
					array('name' => 'user.profile.mobile_no', 'type' => 'html', 'value' => Html::renderTel($model->user->profile->mobile_no)),
					array('name' => 'user.profile.fax_no', 'value' => $model->user->profile->fax_no),
				),
			)); ?>
		</div>
		<!-- /profile -->

		<!-- member -->
		<div class="panel panel-default ">
			<!-- Default panel contents -->
			<div class="panel-heading"><?php echo Yii::t('backend', 'Member') ?></div>
			<?php $this->widget('application.components.widgets.DetailView', array(
				'data' => $model,
				'attributes' => array(
					array('label' => 'Can Login Cpanel', 'type' => 'raw', 'value' => Html::renderBoolean($model->user->member)),
				),
			)); ?>
		</div>
		<!-- /member -->

		<!--<?php foreach ($model->user->sessions as $s): ?>
			<p><?php echo $s->session_code ?></p>
		<?php endforeach; ?>-->

	</div>

	<div class="col-lg-6">


		<!-- role -->
		<div class="panel panel-default ">
			<!-- Default panel contents -->
			<div class="panel-heading"><?php echo Yii::t('backend', 'Role') ?></div>
				<?php
					// if (!Yii::app()->user->isRoleManager):
					if (!HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), (object)['id' => 'custom', 'action' => (object)['id' => 'roleManager']])):
						echo Notice::inline(Yii::t('backend', 'You need to have Role Manager right to edit'));
					endif;
				?>
				<table class="table-detail-view table table-striped">
				<?php $roles = Role::model()->isActive()->findAll(); foreach ($roles as $role): ?>
					<?php if ($role->code == 'developer') {
					continue;
				} ?>
					<tr>
						<td><?php echo $role->title; $userHasRole = $model->user->hasRole($role->code); ?></td>
						<td class="text-center"><?php echo Html::renderBoolean($userHasRole); ?></td>
						<?php // if (Yii::app()->user->isRoleManager):?>
						<?php if (HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'addRole') || HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'removeRole')): ?>
							<?php if ($userHasRole): ?>
								<?php if (HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'removeRole')): ?>
								<td class="text-right"><?php echo Html::link(Yii::t('backend', 'Remove'), $this->createUrl('admin/removeRole', array('id' => $model->user->id, 'roleCode' => $role->code)), array('class' => 'btn btn-danger btn-xs'))?></td>
								<?php else: ?>
									<td>&nbsp;</td>
								<?php endif; ?>
							<?php else: ?>
								<?php if (HUB::roleCheckerAction(Yii::app()->user->getState('rolesAssigned'), Yii::app()->controller, 'addRole')): ?>
								<td class="text-right"><?php echo Html::link(Yii::t('backend', 'Add'), $this->createUrl('admin/addRole', array('id' => $model->user->id, 'roleCode' => $role->code)), array('class' => 'btn btn-success btn-xs'))?></td>
								<?php else: ?>
									<td>&nbsp;</td>
								<?php endif; ?>
							<?php endif; ?>
						<?php endif; ?>
					</tr>
				<?php endforeach; ?>
				</table>
		</div>
		<!-- /role -->
	</div>

</div>
