<?php

/**
 * This is the model class for table "{{gig_tokens}}".
 *
 * The followings are the available columns in table '{{gig_tokens}}':
 * @property integer $token_id
 * @property integer $book_id
 * @property string $session_key
 * @property string $token_key
 * @property string $session_data
 * @property string $tutor_attendance
 * @property string $tutor_attend_time
 * @property string $learner_attendance
 * @property string $learner_attend_time
 * @property string $created_at
 * @property string $modified_at
 *
 * The followings are the available model relations:
 * @property GigBooking $book
 */
class GigTokens extends RActiveRecord {

    const TOKEN_ROLE = 'moderator';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{gig_tokens}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('book_id, session_key, token_key, session_data', 'required'),
            array('book_id', 'numerical', 'integerOnly' => true),
            array('session_key, token_key, session_data, modified_at, learner_attendance, tutor_attendance, tutor_attend_time, learner_attend_time', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('token_id, book_id, session_key, token_key, session_data, created_at, modified_at, learner_attendance, tutor_attendance, tutor_attend_time, learner_attend_time', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'book' => array(self::BELONGS_TO, 'GigBooking', 'book_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'token_id' => 'Token',
            'book_id' => 'Book',
            'session_key' => 'Session Key',
            'token_key' => 'Token Key',
            'session_data' => 'Session Data',
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

        $criteria->compare('token_id', $this->token_id);
        $criteria->compare('book_id', $this->book_id);
        $criteria->compare('session_key', $this->session_key, true);
        $criteria->compare('token_key', $this->token_key, true);
        $criteria->compare('session_data', $this->session_data, true);
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
     * @return GigTokens the static model class
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
        if (is_array($this->session_data))
            $this->session_data = CJSON::encode($this->session_data);
        return parent::beforeSave();
    }

    public static function getChatToken($guid) {
        $token_exists = null;
        $booking_model = GigBooking::model()->findByAttributes(array('book_guid' => $guid, 'book_approve' => '1'));
        if (!empty($booking_model)) {
            $token_exists = GigTokens::model()->findByAttributes(array('book_id' => $booking_model->book_id));
        }
        return $token_exists;
    }

    public static function getAuthData($guid) {
        $token_data = null;
        $token = self::getChatToken($guid);
        if (!empty($token)) {
            $is_tutor = $is_learner = false;

            $is_tutor = $token->book->gig->tutor->user_id == Yii::app()->user->id;
            $is_learner = $token->book->bookUser->user_id == Yii::app()->user->id;

            if ($is_tutor || $is_learner) {
                $token_data = $token;
            }
        }
        return $token_data;
    }

    public static function generateToken($guid) {
        $ret = false;
        $booking_model = GigBooking::model()->findByAttributes(array('book_guid' => $guid, 'book_approve' => '1'));
        if (!empty($booking_model)) {
            $token_exists = GigTokens::model()->findByAttributes(array('book_id' => $booking_model->book_id));

            if (empty($token_exists)) {
                $token_model = new GigTokens;
                $role = GigTokens::TOKEN_ROLE;
                $expire = time() + ($booking_model->book_duration * 60);
                $session_data = array(
                    'expire' => $expire,
                    'role' => $role,
                );

                $session_key = Yii::app()->tok->createSession()->id;
                $token_key = Yii::app()->tok->generateToken($session_key, $role, $expire);

                $token_model->attributes = array(
                    'book_id' => $booking_model->book_id,
                    'session_key' => $session_key,
                    'token_key' => $token_key,
                    'session_data' => $session_data,
                );
                $ret = $token_model->save();
            }
        }
        return $ret;
    }

    public static function getConnectInfo($guid) {
        $token = self::getAuthData($guid);
        $info = array();
        if (!empty($token)) {
            $is_tutor = $token->book->gig->tutor->user_id == Yii::app()->user->id;
            $is_learner = $token->book->bookUser->user_id == Yii::app()->user->id;

            $tutor_name = $token->book->gig->tutor->fullname;
            $tutor_thumb = $token->book->gig->tutor->getProfilethumb(array('class' => 'img-circle', 'width' => '50'));
            $learner_name = $token->book->bookUser->fullname;
            $learner_thumb = $token->book->bookUser->getProfilethumb(array('class' => 'img-circle', 'width' => '50'));
            
            if ($is_tutor) {
                $info['my_role'] = 'tutor';
                $info['my_name'] = $tutor_name;
                $info['my_thumb'] = $tutor_thumb;
                $info['their_name'] = $learner_name;
                $info['their_thumb'] = $learner_thumb;
            }else if($is_learner){
                $info['my_role'] = 'learner';
                $info['my_name'] = $learner_name;
                $info['my_thumb'] = $learner_thumb;
                $info['their_name'] = $tutor_name;
                $info['their_thumb'] = $tutor_thumb;
            }
            
            $info['token'] = $token;
        }
        return $info;
    }

    public static function saveAttendance($token_id, $tutor_attendance, $learner_attendance) {
        $model = self::model()->findByPk($token_id);
        $model->attributes = array('tutor_attendance' => $tutor_attendance, 'learner_attendance' => $learner_attendance);
        if($tutor_attendance == 1){
            $model->tutor_attend_time = date('Y-m-d H:i:s');
            User::switchStatus($model->book->gig->tutor_id, 'B');
        }
        if($learner_attendance == 1){
            $model->learner_attend_time = date('Y-m-d H:i:s');
            User::switchStatus($model->book->bookUser->user_id, 'B');
        }
        $model->save(false);
    }
}
