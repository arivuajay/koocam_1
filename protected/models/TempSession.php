<?php

/**
 * This is the model class for table "{{temp_session}}".
 *
 * The followings are the available columns in table '{{temp_session}}':
 * @property integer $temp_id
 * @property integer $user_id
 * @property string $last_activity_time
 *
 * The followings are the available model relations:
 * @property User $user
 */
class TempSession extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{temp_session}}';
    }

    public function scopes() {
        $user_id = Yii::app()->user->id;
        $alias = $this->getTableAlias(false, false);
        return array(
            'mine' => array('condition' => "$alias.user_id = '$user_id'"),
        );
    }
    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, last_activity_time', 'required'),
            array('user_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('temp_id, user_id, last_activity_time', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'temp_id' => 'Temp',
            'user_id' => 'User',
            'last_activity_time' => 'Last Activity Time',
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
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('last_activity_time', $this->last_activity_time, true);

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
     * @return TempSession the static model class
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

    public static function insertSession($user_id, $timestamp = null) {
//        $model = TempSession::model()->findByAttributes(array('user_id' => $user_id));
//        if(empty($model))
//            $model = new TempSession;
//        
//        $model->user_id = $user_id;
//        $timestamp = (is_null($timestamp)) ? date('Y-m-d H:i:s') : $timestamp;
//        $model->last_activity_time = $timestamp;
//        $model->save(false);
//        Yii::app()->user->setState("last_activity", $timestamp);
    }
}
