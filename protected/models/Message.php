<?php

/**
 * This is the model class for table "{{message}}".
 *
 * The followings are the available columns in table '{{message}}':
 * @property integer $id
 * @property integer $conversation_id
 * @property integer $user1
 * @property integer $user2
 * @property string $message
 * @property integer $timestamp
 * @property string $user1read
 * @property string $user2read
 * @property integer $gig_id
 * @property string $created_at
 * @property string $modified_at
 *
 * The followings are the available model relations:
 * @property User $user1
 * @property User $user2
 */
class Message extends RActiveRecord {
    
    public $maxColumn;
    public $userSlug;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{message}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('message', 'required'),
            array('conversation_id, user1, user2, timestamp, gig_id', 'numerical', 'integerOnly' => true),
            array('user1read, user2read', 'length', 'max' => 1),
            array('modified_at, userSlug, maxColumn', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, conversation_id, user1, user2, message, timestamp, user1read, user2read, gig_id, created_at, modified_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user1' => array(self::BELONGS_TO, 'User', 'user1'),
            'user2' => array(self::BELONGS_TO, 'User', 'user2'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'conversation_id' => 'Conversation',
            'user1' => 'User1',
            'user2' => 'User2',
            'message' => 'Message',
            'timestamp' => 'Timestamp',
            'user1read' => 'User1read',
            'user2read' => 'User2read',
            'gig_id' => 'Gig',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('conversation_id', $this->conversation_id);
        $criteria->compare('user1', $this->user1);
        $criteria->compare('user2', $this->user2);
        $criteria->compare('message', $this->message, true);
        $criteria->compare('timestamp', $this->timestamp);
        $criteria->compare('user1read', $this->user1read, true);
        $criteria->compare('user2read', $this->user2read, true);
        $criteria->compare('gig_id', $this->gig_id);
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
     * @return Message the static model class
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

}
