<?php
/**
*
* NOTICE OF LICENSE
*
* This source file is subject to the BSD 3-Clause License
* that is bundled with this package in the file LICENSE.
* It is also available through the world-wide-web at this URL:
* https://opensource.org/licenses/BSD-3-Clause
*
*
* @author Malaysian Global Innovation & Creativity Centre Bhd <tech@mymagic.my>
* @link https://github.com/mymagic/open_hub
* @copyright 2017-2020 Malaysian Global Innovation & Creativity Centre Bhd and Contributors
* @license https://opensource.org/licenses/BSD-3-Clause
*/


class HashForRemovalCommand extends ConsoleCommand
{
    public function actionIndex()
	{
		echo "Available command:\n";
		echo "  * hashNow\n";
	}
	
    public function actionHashNow()
	{
        $connection=Yii::app()->db;

        self::HashEmailColumnInEventRegistrationTable($conncetion);

        self::HashEmailColumnInEnvoyVisitorTable($conncetion);
    }

    protected function HashEmailColumnInEventRegistrationTable($conncetion)
    {
        try{
            $sql = "SELECT COUNT(*) FROM event_registration";
            $numClients = Yii::app()->db->createCommand($sql)->queryScalar();
            $l = 0;
            while($l<$numClients)
            {
                $h = $l + 100;
                $sql = "select * from event_registration limit $l, $h";
                $eventR = EventRegistration::model()->findAllBySql($sql);

                foreach($eventR as $er) {

                    $er->email_hash = HUB::Encrypt($er->email);
                    $er->save();
                }   
                $l = $l + 100 ;
            }
        }
        catch(Exception $e)
        {
            echo "Erro while encrypting Email in 'Event Registration' table: $e";
        }
    }

    protected function HashEmailColumnInEnvoyVisitorTable($conncetion)
    {
        try
        {
            $sql = "SELECT COUNT(*) FROM envoy_visitor";
            $numClients = Yii::app()->db->createCommand($sql)->queryScalar();
            $l = 0;
            while($l<$numClients)
            {
                $h = $l + 100;
                $sql = "select * from envoy_visitor limit $l, $h";
                $eventR = EventRegistration::model()->findAllBySql($sql);

                foreach($eventR as $er) {

                    $er->email_hash = HUB::Encrypt($er->email);
                    $er->save();
                }
                $l = $l + 100 ;
            }
        }
        catch(Exception $e)
        {
            echo "Erro while encrypting Email column in 'Envoy Visitor' table: $e";
        }
    }

    
}