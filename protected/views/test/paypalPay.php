 <?php $code = 'test-'.rand(100000, 999999999); ?>
 <form action="<?php echo Yii::app()->params['paypalSsl'] ?>" method="post">
    <input type="text" name="cmd" value="_xclick" />
    <input type="text" name="business" value="<?php echo Yii::app()->params['paypalBusiness'] ?>">

    <input type="text" name="custom" value='<?php echo json_encode(array('refType'=>'charge', 'refId'=>$code)) ?>'>
    <input type="text" name="invoice" value="<?php echo $code ?>">
    <input type="text" name="currency_code" value="MYR" />
    <input type="text" name="amount" value="0.99">
    <input type="text" name="item_name" value="Test Payment">
    <input type="text" name="email" value="exiang83@yahoo.com">
    <input type="text" name="no_shipping" value="1">
    <input type="text" name="return" value="<?php echo $this->createAbsoluteUrl('/test/paypalPDT') ?>">
    <!--<input type="hidden" name="notify_url" value="<?php echo $this->createAbsoluteUrl('/paypal/returnResult') ?>">-->
    <input type="text" name="cancel_return" value="<?php echo $this->createAbsoluteUrl('/paypal/cancelPayment') ?>">
    <button type="submit" class="btn btn-primary">Pay Now</button>
</form>