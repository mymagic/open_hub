<?php

class InterestCommand extends ConsoleCommand
{
    public $verbose = false;

    public function actionIndex()
    {
        echo "Available command:\n";
        echo "  * syncNeo\nSync neo4j\n";
        echo "\n";
    }

    public function actionSyncNeo()
    {
        $events = Event::model()->findAll();

        foreach($events as $event) {
            Neo4jEvent::model($event)->sync();
        }
    }
}
