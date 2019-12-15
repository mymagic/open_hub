<?php
use \DrewM\MailChimp\MailChimp;
class HubMailchimp
{

    public static function getAllMailchimpList($limit=100)
    {
        $mailchimp = new MailChimp(Yii::app()->params['mailchimpApiKey']);
        $result = $mailchimp->get('lists', array('count'=>$limit));	
        return $result['lists'];
    }

    public static function getOneMailchimpList($listId)
    {
        $lists = self::getAllMailchimpList();
        if(!empty($lists))
        {
            foreach($lists as $list)
            {
                if($list['id'] == $listId) return $list;
            }
        }
    }

    // if not, get false
    // if yes, get array of the item
    public static function isEmailExistsMailchimpList($email, $listId)
    {
        $mailchimp = new MailChimp(Yii::app()->params['mailchimpApiKey']);
		$subscriberHash = $mailchimp->subscriberHash($email);
        $result = $mailchimp->get("/lists/$listId/members/$subscriberHash");
        if($result['status'] == '404') return false;
        return $result;
    }

    public static function isEmailSubscribeMailchimpList($email, $listId)
    {
        $result = self::isEmailExistsMailchimpList($email, $listId);
        if(!empty($result))
		{
			$isSubscribed = ($result['status'] == 'subscribed')?true:false;
		}
		else
		{
			$isSubscribed = false;
        }
        return $isSubscribed;
    }

    public static function toggleSubscribeMailchimpList($email, $listId, $data)
    {
        // is already subscribed, unsubscribe
        if(self::isEmailSubscribeMailchimpList($email, $listId))
        {
            return self::unsubscribeMailchimpList($email, $listId);
        }
        // is not subscribed, subscribe
        else
        {
            return self::subscribeMailchimpList($email, $listId, $data);
        }
    }

    public static function unsubscribeMailchimpList($email, $listId, $reason='(N/A) Unsubscribed thru API')
    {
        $mailchimp = new MailChimp(Yii::app()->params['mailchimpApiKey']);
		$subscriberHash = $mailchimp->subscriberHash($email);
        $result = $mailchimp->patch("/lists/$listId/members/$subscriberHash", ['email_address'=>$email, 'status'=>'unsubscribed', 'unsubscribe_reason'=>$reason]);
        
        if($mailchimp->success()) return $result;
        return $mailchimp->getLastError();
    }

    public static function subscribeMailchimpList($email, $listId, $data)
    {
        $mailchimp = new MailChimp(Yii::app()->params['mailchimpApiKey']);
        
        $listMembersUrl = sprintf('lists/%s/members', $listId);
        $subscriberHash = $mailchimp->subscriberHash($email);

        $mailchimp->get(sprintf('%s/%s', $listMembersUrl, $subscriberHash));

        if ($mailchimp->success()) 
        {
            $result = $mailchimp->patch(sprintf('%s/%s', $listMembersUrl, $subscriberHash), array(
                // whatever should be updated
                'email_address'=>$email, 'status'=>'subscribed', 'merge_fields'=> 
                [
                    'FNAME' => $data['firstname'],
                    'LNAME' => $data['lastname']
                ]
            ));
        } 
        else 
        {
            $result = $mailchimp->post($listMembersUrl, array(
                // create a user
                'email_address'=>$email, 'status'=>'subscribed', 'merge_fields'=> 
                [
                    'FNAME' => $data['firstname'],
                    'LNAME' => $data['lastname']
                ]
            ));
        }

        if($mailchimp->success()) return $result;
        return $mailchimp->getLastError();
		
    }
}

