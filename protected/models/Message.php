<?php

/**
 * This is the model class for table "{{message}}".
 *
 * The followings are the available columns in table '{{message}}':
 * @property integer $message_id
 * @property integer $id1
 * @property integer $id2
 * @property integer $user1
 * @property integer $user2
 * @property string $message
 * @property integer $timestamp
 * @property string $user1read
 * @property string $user2read
 * @property integer $cam_id
 * @property string $created_at
 * @property string $modified_at
 * @property string $userSlug
 *
 * The followings are the available model relations:
 * @property User $user2
 * @property User $user1
 */
class Message extends RActiveRecord {

    public $maxColumn;
    public $userSlug;
    
    const NEW_CONVERSATION_START = 1;
    const USER_READ_YES = "Y";
    const USER_READ_NO = "N";

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
            array('id1, id2, user1, user2, timestamp, cam_id', 'numerical', 'integerOnly' => true),
            array('user1read, user2read', 'length', 'max' => 1),
            array('modified_at, maxColumn, userSlug', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('message_id, id1, id2, user1, user2, message, timestamp, user1read, user2read, cam_id, created_at, modified_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user2' => array(self::BELONGS_TO, 'User', 'user2'),
            'user1' => array(self::BELONGS_TO, 'User', 'user1'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'message_id' => 'Message',
            'id1' => 'Id1',
            'id2' => 'Id2',
            'user1' => 'User1',
            'user2' => 'User2',
            'message' => 'Message',
            'timestamp' => 'Timestamp',
            'user1read' => 'User1read',
            'user2read' => 'User2read',
            'cam_id' => 'Cam',
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

        $criteria->compare('message_id', $this->message_id);
        $criteria->compare('id1', $this->id1);
        $criteria->compare('id2', $this->id2);
        $criteria->compare('user1', $this->user1);
        $criteria->compare('user2', $this->user2);
        $criteria->compare('message', $this->message, true);
        $criteria->compare('timestamp', $this->timestamp);
        $criteria->compare('user1read', $this->user1read, true);
        $criteria->compare('user2read', $this->user2read, true);
        $criteria->compare('cam_id', $this->cam_id);
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

    public static function getMyMsgListQuery() {
        $session_userid = Yii::app()->user->id;
        $new_conversation_end = "(SELECT MAX(m3.id2) FROM {{message}} `m3` WHERE m3.id1 = m1.id1)";

        $sql = "SELECT m1.*, count(m2.id1) as reps, user.user_id, user.username FROM {{message}} `m1`, {{message}} `m2`, {{user}} `user` WHERE ((m1.user1 = '{$session_userid}' and user.user_id = m1.user2) or (m1.user2 = '{$session_userid}' and user.user_id = m1.user1)) and m1.id2 = {$new_conversation_end} and m2.id1 = m1.id1 GROUP BY `m1`.`id1` ORDER BY `m1`.`id1` DESC, `m1`.`id2` DESC";
        return $sql;
    }

    public static function getMyUnReadMsgCount() {
        $uid = Yii::app()->user->id;
        $user_read_no = self::USER_READ_NO;
        $condition_unread = "((user1=" . $uid . " AND user1read='{$user_read_no}') OR (user2=" . $uid . " AND user2read='{$user_read_no}'))";
        $dispcount = self::model()->count($condition_unread);
        return $dispcount;
    }

    public static function getMyUnReadMsg() {
        $session_userid = Yii::app()->user->id;
        $user_read_no = self::USER_READ_NO;
        $sql = "SELECT m1.* FROM {{message}} `m1`, {{user}} `user` WHERE ((m1.user2 = '{$session_userid}' and m1.user2read='{$user_read_no}' and user.user_id = m1.user1)) ORDER BY `m1`.`message_id` DESC";
        $total_items = Yii::app()->db->createCommand($sql)->queryAll();
        return $total_items;
    }

    public static function getMyReadMsg($limit = 5) {
        $session_userid = Yii::app()->user->id;
        $user_read_no = self::USER_READ_YES;
        $sql = "SELECT m1.* FROM {{message}} `m1`, {{user}} `user` WHERE ((user1=" . $session_userid . " AND user1read='{$user_read_no}') OR (user2=" . $session_userid . " AND user2read='{$user_read_no}')) And user.user_id = m1.user1 ORDER BY `m1`.`message_id` DESC LIMIT {$limit}";
        $total_items = Yii::app()->db->createCommand($sql)->queryAll();
        return $total_items;
    }

    public static function insertMessage($msg, $user1, $user2, $cam_id = NULL) {
        $message = new Message;
        // Genreate the conversation id
        $criteria = new CDbCriteria;
        $criteria->select = 'max(id1) AS maxColumn';
        $row = self::model()->find($criteria);

        $npm_count = $row['maxColumn'];
        $id1 = $npm_count + 1;

        $message->id1 = $id1; // conversation id
        $message->id2 = self::NEW_CONVERSATION_START; //New conversation start
        $message->user1 = $user1; // Sender
        $message->user2 = $user2; // Receiver
        $message->timestamp = time();
        $message->user1read = self::USER_READ_YES;
        $message->user2read = self::USER_READ_NO;
        $message->cam_id = $cam_id;
        $message->message = $msg;
        $message->save(false);
    }
}
