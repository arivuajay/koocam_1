<?php

/**
 * This is the model class for table "{{cam_comments}}".
 *
 * The followings are the available columns in table '{{cam_comments}}':
 * @property integer $com_id
 * @property integer $cam_id
 * @property integer $user_id
 * @property integer $cam_booking_id
 * @property string $com_comment
 * @property double $com_rating
 * @property string $status
 * @property string $created_at
 * @property string $modified_at
 *
 * The followings are the available model relations:
 * @property Cam $cam
 * @property User $user
 */
class CamComments extends RActiveRecord {

    const COMMENT_APPROVED = 1;
    const COMMENT_IN_ACTIVE = 0;
    const COMMENT_SAFE_DELETE = 2;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{cam_comments}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('com_comment', 'required'),
            array('cam_id, user_id, cam_booking_id', 'numerical', 'integerOnly' => true),
            array('com_rating', 'numerical'),
            array('status', 'length', 'max' => 1),
            array('created_at, modified_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('com_id, cam_id, user_id, cam_booking_id, com_comment, com_rating, status, created_at, modified_at', 'safe', 'on' => 'search'),
        );
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

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'cam' => array(self::BELONGS_TO, 'Cam', 'cam_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'com_id' => 'Com',
            'cam_id' => 'Cam',
            'user_id' => 'User',
            'cam_booking_id' => 'Cam Booking',
            'com_comment' => 'Comment',
            'com_rating' => 'Rating',
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

        $criteria->compare('com_id', $this->com_id);
        $criteria->compare('cam_id', $this->cam_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('cam_booking_id', $this->cam_booking_id);
        $criteria->compare('com_comment', $this->com_comment, true);
        $criteria->compare('com_rating', $this->com_rating);
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
     * @return CamComments the static model class
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

    protected function afterSave() {
        self::updateRatings($this->cam_id, $this->cam->tutor_id);
        return parent::afterSave();
    }

    public static function updateRatings($cam_id, $tutor_id) {
        $tot = Yii::app()->db->createCommand()
                ->select('AVG(`com_rating`) as average')
                ->from('{{cam_comments}}')
                ->andWhere('cam_id = ' . $cam_id . ' AND status = "1"')
                ->queryRow();
        Cam::model()->updateByPk($cam_id, array('cam_rating' => $tot['average']));

        $cam_rating = Yii::app()->db->createCommand()
                ->select('AVG(`cam_rating`) as average')
                ->from('{{cam}}')
                ->andWhere('tutor_id = ' . $tutor_id . ' AND status = "1"')
                ->queryRow();
        User::model()->updateByPk($tutor_id, array('user_rating' => $cam_rating['average']));
    }

}
