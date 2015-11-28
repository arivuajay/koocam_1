<?php

class MyDbConnection extends CDbConnection {

    protected function initConnection($pdo) {
        parent::initConnection($pdo);
        if(Yii::app()->user->hasState('timezone')) {
            $pdo->exec("set time_zone='+00:00';");
            exit;
        }
    }
}
    