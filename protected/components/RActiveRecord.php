<?php

class RActiveRecord extends CActiveRecord {

    protected function beforeValidate() {
        return parent::beforeValidate();
    }

    protected function beforeSave() {
        $now = Yii::app()->localtime->UTCNow;

        if (!$this->isNewRecord) {
            $this->modified_at = $now;
        } else {
            $this->created_at = $now;
        }

        return parent::beforeSave();
    }

    protected function afterFind() {
        if ($this->modified_at == '0000-00-00 00:00:00') {
            $this->modified_at = '';
        } else {
            $this->modified_at = Yii::app()->localtime->toLocalDateTime($this->modified_at, 'short', 'short');
        }
        
        $this->created_at = Yii::app()->localtime->toLocalDateTime($this->created_at, 'short', 'short');
        
        $dateFields = $this->dateFields();
        if (!empty($dateFields)) {
            foreach ($dateFields as $key => $field) {
                if (isset($this->$field)) {
                    $this->$field = Yii::app()->localtime->toLocalDateTime($this->$field, 'short');
                }
            }
        }

        $dateTimeFields = $this->dateTimeFields();
        if (!empty($dateTimeFields)) {
            foreach ($dateTimeFields as $key => $field) {
                if (isset($this->$field)) {
                    $this->$field = Yii::app()->localtime->toLocalDateTime($this->$field, 'short', 'short');
                }
            }
        }
        
        return parent::afterFind();
    }

    protected function dateFields() {
        return array(
//            'book_date',
        );
    }

    protected function dateTimeFields() {
        return array(
//            'book_start_time',
//            'book_end_time',
        );
    }

}
