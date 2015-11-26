<?php

/**
 * This is the model class for table "{{gig_comments}}".
 *
 * The followings are the available columns in table '{{gig_comments}}':
 * @property integer $com_id
 * @property integer $gig_id
 * @property integer $user_id
 * @property string $com_comment
 * @property double $com_rating
 * @property string $status
 * @property string $created_at
 * @property string $modified_at
 *
 * The followings are the available model relations:
 * @property Gig $gig
 * @property User $user
 */
class GigComments extends RActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{gig_comments}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('gig_id, user_id, com_comment, created_at', 'required'),
            array('gig_id, user_id', 'numerical', 'integerOnly' => true),
            array('com_rating', 'numerical'),
            array('status', 'length', 'max' => 1),
            array('modified_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('com_id, gig_id, user_id, com_comment, com_rating, status, created_at, modified_at', 'safe', 'on' => 'search'),
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
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'com_id' => 'Com',
            'gig_id' => 'Gig',
            'user_id' => 'User',
            'com_comment' => 'Com Comment',
            'com_rating' => 'Com Rating',
            'status' => '0 -> In-Active, 1 -> Approved, 2 -> --',
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

        $criteria->compare($alias.'.com_id', $this->com_id);
        $criteria->compare($alias.'.gig_id', $this->gig_id);
        $criteria->compare($alias.'.user_id', $this->user_id);
        $criteria->compare($alias.'.com_comment', $this->com_comment, true);
        $criteria->compare($alias.'.com_rating', $this->com_rating);
        $criteria->compare($alias.'.status', $this->status, true);
        $criteria->compare($alias.'.created_at', $this->created_at, true);
        $criteria->compare($alias.'.modified_at', $this->modified_at, true);

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
     * @return GigComments the static model class
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
