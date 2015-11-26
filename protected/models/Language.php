<?php

/**
 * This is the model class for table "{{language}}".
 *
 * The followings are the available columns in table '{{language}}':
 * @property integer $lang_Id
 * @property string $lang_code
 * @property string $lang_name
 * @property string $status
 * @property string $created_at
 * @property string $modified_at
 */
class Language extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{language}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('lang_name', 'required'),
            array('lang_code', 'length', 'max' => 10),
            array('lang_name', 'length', 'max' => 45),
            array('status', 'length', 'max' => 1),
            array('created_at, modified_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('lang_Id, lang_code, lang_name, status, created_at, modified_at', 'safe', 'on' => 'search'),
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
            'lang_Id' => 'ID:',
            'lang_code' => 'Lang Code',
            'lang_name' => 'Language:',
            'status' => 'Status:',
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
        $alias = $this->getTableAlias(false, false);

        $criteria->compare($alias . '.lang_Id', $this->lang_Id);
        $criteria->compare($alias . '.lang_code', $this->lang_code, true);
        $criteria->compare($alias . '.lang_name', $this->lang_name, true);
        $criteria->compare($alias . '.status', $this->status, true);
        $criteria->compare($alias . '.created_at', $this->created_at, true);
        $criteria->compare($alias . '.modified_at', $this->modified_at, true);

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
     * @return Language the static model class
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

    public static function getLanguagesList($status = 'all') {
        return CHtml::listData(self::model()->$status()->findAll(), 'lang_Id', 'lang_name');
    }

}
