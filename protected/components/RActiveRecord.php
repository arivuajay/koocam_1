<?php
class RActiveRecord extends CActiveRecord {
    
    protected function beforeValidate() {
        return parent::beforeValidate();
    }
    
    protected function beforeSave() {
        $now = Yii::app()->localtime->UTCNow;
        
        if(!$this->isNewRecord){
            $this->modified_at = $now;
        }else{
            $this->created_at = $now;
        }
        return parent::beforeSave();
    }
    
    protected function afterFind() {
        if($this->modified_at == '0000-00-00 00:00:00'){
            $this->modified_at = '';
        }else{
            $this->modified_at = Yii::app()->localtime->toLocalDateTime($this->modified_at,'short','short');
        }
        $this->created_at = Yii::app()->localtime->toLocalDateTime($this->created_at,'short','short');
        return parent::afterFind();
    }
}
