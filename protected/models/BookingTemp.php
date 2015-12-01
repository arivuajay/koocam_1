<?php

/**
 * This is the model class for table "{{booking_temp}}".
 *
 * The followings are the available columns in table '{{booking_temp}}':
 * @property integer $temp_id
 * @property string $temp_guid
 * @property string $temp_key
 * @property string $temp_value
 * @property string $created_at
 * @property string $modified_at
 */
class BookingTemp extends RActiveRecord {
    
    public $temp_gig_id;
    public $temp_book_session;
    public $temp_book_is_extra;
    public $temp_book_user_id;
    
    const TEMP_BOOKING_KEY = "Start Now Booking";

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{booking_temp}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('temp_book_session', 'required'),
            array('temp_guid', 'length', 'max' => 50),
            array('created_at, modified_at, temp_gig_id, temp_book_session, temp_book_is_extra', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('temp_id, temp_guid, temp_key, temp_value, created_at, modified_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'temp_id' => 'Temp',
            'temp_guid' => 'Temp Guid',
            'temp_key' => 'Temp Key',
            'temp_value' => 'Temp Value',
            'created_at' => 'Created At',
            'modified_at' => 'Modified At',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('temp_id', $this->temp_id);
        $criteria->compare('temp_guid', $this->temp_guid, true);
        $criteria->compare('temp_key', $this->temp_key, true);
        $criteria->compare('temp_value', $this->temp_value, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('modified_at', $this->modified_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => PAGE_SIZE,
            )
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return BookingTemp the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function dataProvider() {
        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => PAGE_SIZE,
            )
        ));
    }
    
    protected function beforeSave() {
        if ($this->isNewRecord){
            $this->temp_guid = Myclass::guid(false);
            $this->temp_key = self::TEMP_BOOKING_KEY;
        }
        
        return parent::beforeSave();
    }

}
