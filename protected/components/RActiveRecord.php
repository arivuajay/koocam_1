<?php
class RActiveRecord extends CActiveRecord {
    
    protected function beforeSave() {
        if(!$this->isNewRecord){
            $this->modified_at = new CDbExpression('NOW()');
        }
        return parent::beforeSave();
    }
    
    protected function afterFind() {
        if($this->modified_at == '0000-00-00 00:00:00')
            $this->modified_at = '';
        parent::afterFind();
    }
}
