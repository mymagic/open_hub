<?php
use wadeshuler\paypalipn\IpnListener;

class PaypalController extends Controller
{
	public $layout='//layouts/frontend';

	
	public function actionCancelPayment()
	{
		if(!empty($_GET)) $params = $_GET;
		else if(!empty($_POST)) $params = $_POST;
		
		//Notice::page(Yii::t('app', 'You had cancelled the payment'), Notice_ERROR);
        $this->redirect('/charge/list');
	}
	
	public function actionReturnPDT($tx)
	{
        $tData = HUB::processPaypalPDT($tx);	
        //print_r($tData);exit;

        // store into transaction table
        $result = HUB::insertOrUpdateTransaction('paypal', $tData['txn_id'], $tData['txn_type'], json_encode($tData), '');
        //print_r($result);exit;
        $msg = $result['msg'];

        if($result['status']=='success' && !empty($tData['custom'])) 
        {
            $custom = json_decode($tData['custom'], true);

            // get the associate charge
            if($custom['refType'] == 'charge')
            {
                $charge = HUB::getChargeByCode($custom['refId']);

                // 1. Check that $_POST['payment_status'] is "Completed"
                // 2. Check that $_POST['txn_id'] has not been previously processed
                // 3. Check that $_POST['receiver_email'] is your Primary PayPal email
                // 4. Check that $_POST['payment_amount'] and $_POST['payment_currency'] are correct
                if( 
                    $tData['payment_status'] == 'Completed' && $tData['receiver_email'] == Yii::app()->params['paypalBusiness'] && 
                    !empty($charge) && $charge->status=='pending' && $charge->amount == $tData['mc_gross'] && $charge->currency_code == $tData['mc_currency']
                )
                {
                    // update charge to paid
                    $charge->status = 'paid';
                    if($charge->save())
                    {
                        Notice::page(
							Yii::t('notice', 'Payment Successful, continue here'), Notice_SUCCESS, 
							array('url'=>$this->createUrl('charge/list'))
						);
                    }
                }
                else
                {
                    $msg = 'Invalid payment parameter';
                }
            }
            
        }

        Notice::page(
            Yii::t('notice', 'Payment Failed, error: {msg}', ['{msg}'=>$msg]), Notice_ERROR,
            array('url'=>$this->createUrl('charge/list'))
        );

	}
	public function actionNotifyIPN()
	{
        // log at junk
        $junk = new Junk;
        $junk->code = 'paypal-notifyIPN-'.time();
        $junk->content = json_encode($_POST);
        $junk->save();
        
        $listener = new IpnListener();
        $listener->use_sandbox = Yii::app()->params['paypalIsSandbox'];
        $listener->use_curl = true;
        $listener->follow_location = false;
        $listener->timeout = 30;
        $listener->verify_ssl = true;
       
        // handle successful ipn request
        if ($verified = $listener->processIpn())
        {
            $tData = $_POST;

            // store into transaction table
            HUB::insertOrUpdateTransaction('paypal', $tData['txn_id'], $tData['txn_type'], json_encode($tData), '');

            if(!empty($tData['custom'])) 
            {
                $custom = json_decode($tData['custom'], true);

                // get the associate charge
                if($custom['refType'] == 'charge')
                {
                    $charge = HUB::getChargeByCode($custom['refId']);

                    // 1. Check that $_POST['payment_status'] is "Completed"
                    // 2. Check that $_POST['txn_id'] has not been previously processed
                    // 3. Check that $_POST['receiver_email'] is your Primary PayPal email
                    // 4. Check that $_POST['payment_amount'] and $_POST['payment_currency'] are correct
                    if( 
                        $tData['payment_status'] == 'Completed' && $tData['receiver_email'] == Yii::app()->params['paypalBusiness'] && 
                        !empty($charge) && $charge->status=='pending' && $charge->amount == $tData['mc_gross'] && $charge->currency_code == $tData['mc_currency']
                    )
                    {
                        // update charge to paid
                        $charge->status = 'paid';
                        $charge->save();
                    }
                    else
                    {
                        $junk = new Junk;
                        $junk->code = 'paypal-notifyIPN-'.time().'-conditionFailed';
                        $junk->content = sprintf('condition failed! %s|%s|%s|%s', $tData['payment_status'], $tData['receiver_email'], $tData['mc_gross'], $tData['mc_currency']);
                        $junk->save();
                    }
                }
                else
                {
                    $junk = new Junk;
                    $junk->code = 'paypal-notifyIPN-'.time().'-refTypeNotCharge';
                    $junk->content = 'ref type is not charge! '.json_encode($listener->getPostData());
                    $junk->save();
                }
            }
            else
            {
                $junk = new Junk;
                $junk->code = 'paypal-notifyIPN-'.time().'-customEmpty';
                $junk->content = 'custom data is empty! '.json_encode($listener->getPostData());
                $junk->save();
            }
           
        }
        else
        {
            $junk = new Junk;
            $junk->code = 'paypal-notifyIPN-'.time().'-notVerified';
            $junk->content = 'not verified! '.json_encode($listener->getPostData());
            $junk->save();
        }

	}
	
	
	
}