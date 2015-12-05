<?php

/**
 * This is the model class for table "{{user_paypal}}".
 *
 * The followings are the available columns in table '{{user_paypal}}':
 * @property integer $paypal_id
 * @property integer $user_id
 * @property string $paypal_address
 * @property string $created_at
 * @property string $modified_at
 *
 * The followings are the available model relations:
 * @property User $user
 */
class UserPaypal extends RActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{user_paypal}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id', 'required'),
            array('user_id', 'numerical', 'integerOnly' => true),
            array('paypal_address', 'email'),
            array('paypal_address', 'length', 'max' => 100),
            array('created_at, modified_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('paypal_id, user_id, paypal_address, created_at, modified_at', 'safe', 'on' => 'search'),
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

    public function scopes() {
        $alias = $this->getTableAlias(false, false);
        $user_id = Yii::app()->user->id;
        
        return array(
            'mine' => array('condition' => "$alias.user_id = {$user_id}"),
        );
    }
    
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'paypal_id' => 'Paypal',
            'user_id' => 'User',
            'paypal_address' => 'Paypal Address',
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

        $criteria->compare('paypal_id', $this->paypal_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('paypal_address', $this->paypal_address, true);
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
     * @return UserPaypal the static model class
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

    public static function getUserpaypal() {
        return CHtml::listData(self::model()->mine()->findAll(), 'paypal_address', 'paypal_address');
    }
}
