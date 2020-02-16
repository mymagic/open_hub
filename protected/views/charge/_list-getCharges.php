<div class="ibox-content <?php echo ($chargeToCode==$data->charge_to_code)?'bg-highlight':'white-bg'?>" style="margin-bottom:1em !important">
    <form action="<?php echo Yii::app()->params['paypalSsl'] ?>" method="post">
        <input type="hidden" name="cmd" value="_xclick" />
        <input type="hidden" name="business" value="<?php echo Yii::app()->params['paypalBusiness'] ?>">
        
        <input type="hidden" name="custom" value='<?php echo json_encode(array('refType'=>'charge', 'refId'=>$data->code)) ?>'>
        <input type="hidden" name="invoice" value="<?php echo $data->code ?>">
        <input type="hidden" name="currency_code" value="<?php echo $data->currency_code ?>" />
        <input type="hidden" name="amount" value="<?php echo $data->amount ?>">
        <input type="hidden" name="item_name" value="<?php echo $data->title ?>">
        <input type="hidden" name="email" value="<?php echo Yii::app()->user->username ?>">
        <input type="hidden" name="no_shipping" value="1">
        <input type="hidden" name="return" value="<?php echo $this->createAbsoluteUrl('/charge/list') ?>">
        <input type="hidden" name="notify_url" value="<?php echo $this->createAbsoluteUrl('/paypal/notifyIPN') ?>">
        <input type="hidden" name="cancel_return" value="<?php echo $this->createAbsoluteUrl('/paypal/cancelPayment') ?>">
        <?php if($data->canMakePayment()): ?>
            <button type="submit" class="btn btn-primary btn-sm pull-right"><sup>Pay</sup> <?php echo Html::formatMoney($data->amount, $data->currency_code); ?></button>
        <?php else: ?>
            <a class="btn btn-white btn-sm disabled pull-right"><?php echo Html::formatMoney($data->amount, $data->currency_code); ?></a>
        <?php endif; ?>
    </form>
    <h3 class="nopadding"><span class="badge badge-<?php echo $data->renderStatusMode() ?>"><?php echo $data->formatEnumStatus($data->status) ?></span> <?php echo Html::encodeDisplay($data->title); ?></h3>
    <hr />
    <div class="">
    <p>To: <?php echo $data->renderChargeTo('html') ?></p>
    <?php if($data->status == 'pending'): ?><p>Pay between <b><?php echo Html::formatDateTime($data->date_started) ?></b> - <b><?php echo Html::formatDateTime($data->date_expired) ?></b></p><?php endif; ?>
    </div>

    <?php if(!empty($data->text_description)): ?>
        <p><?php echo Html::encodeDisplay($data->text_description); ?></p>
    <?php endif; ?>
	
</div>