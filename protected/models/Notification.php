<?php

/**
 * This is the model class for table "{{notification}}".
 *
 * The followings are the available columns in table '{{notification}}':
 * @property integer $notifn_id
 * @property integer $user_id
 * @property string $notifn_message
 * @property string $notifn_type
 * @property integer $notifn_rel_id
 * @property string $created_at
 * @property string $modified_at
 * 
 * The followings are the available model relations:
 * @property User $notifnUser
 * @property GigBooking $gigBooking
 */
class Notification extends RActiveRecord {

    const NOTIFICATION_INDEX_LIMIT = 9;
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{notification}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('notifn_message', 'required'),
            array('user_id, notifn_rel_id', 'numerical', 'integerOnly' => true),
            array('notifn_type', 'length', 'max' => 5),
            array('notifn_read', 'length', 'max' => 1),
            array('created_at, modified_at, notifn_read', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('notifn_id, user_id, notifn_message, notifn_type, notifn_rel_id, created_at, modified_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'notifnUser' => array(self::BELONGS_TO, 'User', 'user_id'),
            'gigBooking' => array(self::BELONGS_TO, 'GigBooking', 'notifn_rel_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'notifn_id' => 'Notifn',
            'user_id' => 'User',
            'notifn_message' => 'Notifn Message',
            'notifn_type' => 'Notifn Type',
            'notifn_rel_id' => 'Notifn Rel',
            'notifn_read' => 'Read/Unread',
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

        $criteria->compare('notifn_id', $this->notifn_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('notifn_message', $this->notifn_message, true);
        $criteria->compare('notifn_type', $this->notifn_type, true);
        $criteria->compare('notifn_rel_id', $this->notifn_rel_id);
        $criteria->compare('notifn_read', $this->notifn_read);
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
     * @return Notification the static model class
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

    public static function getNotificationsByUserId($user_id) {
        return self::model()->findAllByAttributes(array('user_id' => $user_id, 'notifn_read' => 'N'), array('order' => 'created_at DESC'));
    }

    public function getTopnotifymessage() {
        return CHtml::link($this->notifn_message, '#') . " <span class='timestamp'>1 min ago</span>";
    }

}
