<?php

/**
 * This is the model class for table "{{gig_extra}}".
 *
 * The followings are the available columns in table '{{gig_extra}}':
 * @property integer $extra_id
 * @property integer $gig_id
 * @property string $extra_price
 * @property string $extra_description
 * @property string $extra_file
 * @property string $created_by
 * @property string $modified_by
 *
 * The followings are the available model relations:
 * @property Gig $gig
 */
class GigExtra extends CActiveRecord {

    const ALLOW_FILE_TYPES = 'jpg, gif, png';
    const ALLOW_FILE_SIZE = 2; //In MB
    
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{gig_extra}}';
    }

    /**
     * 
     * @return type
     */
    public function behaviors() {
        return array(
            'NUploadFile' => array(
                'class' => 'ext.nuploadfile.NUploadFile',
                'fileField' => 'extra_file',
            )
        );
    }
    
    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('gig_id, extra_price, extra_description', 'required'),
            array('gig_id', 'numerical', 'integerOnly' => true),
            array('extra_price', 'length', 'max' => 10),
            array('extra_file', 'length', 'max' => 500),
//            array('extra_file', 'file', 'types' => self::ALLOW_FILE_TYPES, 'maxSize'=>1024 * 1024 * self::ALLOW_FILE_SIZE, 'tooLarge' => 'File has to be smaller than '.self::ALLOW_FILE_SIZE.'MB', 'allowEmpty' => true),
            array('created_by, modified_by, extra_file', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('extra_id, gig_id, extra_price, extra_description, created_by, modified_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'gig' => array(self::BELONGS_TO, 'Gig', 'gig_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'extra_id' => 'Extra',
            'gig_id' => 'Gig',
            'extra_price' => 'Extra Price',
            'extra_description' => 'Extra Description',
            'extra_file' => 'File',
            'created_by' => 'Created By',
            'modified_by' => 'Modified By',
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

        $criteria->compare('extra_id', $this->extra_id);
        $criteria->compare('gig_id', $this->gig_id);
        $criteria->compare('extra_price', $this->extra_price, true);
        $criteria->compare('extra_description', $this->extra_description, true);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->compare('modified_by', $this->modified_by, true);

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
     * @return GigExtra the static model class
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

    protected function afterFind() {
        $this->extra_price = $this->extra_price + 0;
        return parent::afterFind();
    }
}
