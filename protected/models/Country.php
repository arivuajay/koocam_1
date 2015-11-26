<?php

/**
 * This is the model class for table "{{country}}".
 *
 * The followings are the available columns in table '{{country}}':
 * @property integer $country_Id
 * @property string $country_name
 * @property string $country_two_code
 * @property string $country_three_code
 * @property string $status
 * @property string $created_at
 * @property string $modified_at
 *
 * The followings are the available model relations:
 * @property UserProfile[] $userProfiles
 */
class Country extends RActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{country}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('country_name', 'required'),
            array('country_name', 'length', 'max' => 45),
            array('country_two_code', 'length', 'max' => 3),
            array('country_three_code', 'length', 'max' => 5),
            array('status', 'length', 'max' => 1),
            array('created_at, modified_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('country_Id, country_name, country_two_code, country_three_code, status, created_at, modified_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'userProfiles' => array(self::HAS_MANY, 'UserProfile', 'country_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'country_Id' => 'Country',
            'country_name' => 'Country Name',
            'country_two_code' => 'Country Two Code',
            'country_three_code' => 'Country Three Code',
            'status' => 'Status',
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

        $criteria->compare('country_Id', $this->country_Id);
        $criteria->compare('country_name', $this->country_name, true);
        $criteria->compare('country_two_code', $this->country_two_code, true);
        $criteria->compare('country_three_code', $this->country_three_code, true);
        $criteria->compare('status', $this->status, true);
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
     * @return Country the static model class
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
    
    public function scopes() {
        $alias = $this->getTableAlias(false, false);
        return array(
            'active' => array('condition' => "$alias.status = '1'"),
            'inactive' => array('condition' => "$alias.status = '0'"),
            'deleted' => array('condition' => "$alias.status = '2'"),
            'all' => array('condition' => "$alias.status is not null"),
        );
    }

    public static function getCountryList($status = 'all') {
        return CHtml::listData(self::model()->$status()->findAll(), 'country_Id', 'country_name');
    }

}
