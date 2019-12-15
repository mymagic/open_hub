<?php

class HashForRemovalCommand extends CConsoleCommand
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