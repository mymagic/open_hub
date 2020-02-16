<p><?php echo Yii::t('default', 'This is a computer generated email') ?></p>
<hr />
<?php echo $message ?>
<hr />
<p><?php echo Yii::t('default', Yii::app()->params['smtpSenderName']) ?><br />
<?php echo Yii::t('default', 'Website') ?>: <?php echo CHtml::mailto(Yii::app()->params['baseUrl'], Yii::app()->params['baseUrl']) ?><br />
<?php echo Yii::t('default', 'Email') ?>: <?php echo CHtml::mailto(Yii::app()->params['contactName'] . ' (' . Yii::app()->params['contactEmail'] . ')', Yii::app()->params['contactEmail']) ?><br />
</p>