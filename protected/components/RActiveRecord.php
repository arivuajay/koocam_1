<?php

class RActiveRecord extends CActiveRecord {

    protected function beforeValidate() {
        return parent::beforeValidate();
    }

    protected function beforeSave() {
        $now = Yii::app()->localtime->UTCNow;

        if (!$this->isNewRecord) {
            $this->modified_at = $now;
//            $this->convertTime('to');
        } else {
            $this->created_at = $now;
        }
        
        return parent::beforeSave();
    }

    protected function afterFind() {
        if ($this->modified_at == '0000-00-00 00:00:00') {
            $this->modified_at = '';
        } else {
            $this->modified_at = Yii::app()->localtime->fromUTC($this->modified_at);
        }
        
        $this->created_at = Yii::app()->localtime->fromUTC($this->created_at);
        
        $this->convertTime('from');
        return parent::afterFind();
    }

    protected function dateFields() {
        return array(
            'book_date',
        );
    }

    protected function dateTimeFields() {
        return array(
            'book_start_time',
            'book_end_time',
        );
    }

    protected function convertTime($flag) {
        $dateFields = $this->dateFields();
        if (!empty($dateFields)) {
            foreach ($dateFields as $key => $field) {
                if (isset($this->$field)) {
                    if($flag == 'to'):
                        $this->$field = Yii::app()->localtime->toUTC($this->$field);
                    elseif($flag == 'from'):
                        $this->$field = Yii::app()->localtime->fromUTC($this->$field);
                    endif;
                }
            }
        }

        $dateTimeFields = $this->dateTimeFields();
        if (!empty($dateTimeFields)) {
            foreach ($dateTimeFields as $key => $field) {
                if (isset($this->$field)) {
                    if($flag == 'to'):
                        $this->$field = Yii::app()->localtime->toUTC($this->$field);
                    elseif($flag == 'from'):
                        $this->$field = Yii::app()->localtime->fromUTC($this->$field);
                    endif;
                }
            }
        }
    }
}
