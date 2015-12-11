<?php

/**
 * This is the model class for table "{{faq}}".
 *
 * The followings are the available columns in table '{{faq}}':
 * @property integer $faq_id
 * @property string $question
 * @property string $answer
 * @property string $status
 * @property string $created_at
 * @property string $modified_at
 */
class Faq extends RActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{faq}}';
    }

    public function scopes() {
        $alias = $this->getTableAlias(false, false);

        return array(
            'active' => array('condition' => "$alias.status = '1'"),
            'inactive' => array('condition' => "$alias.status = '0'"),
        );
    }
    
    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('question, answer', 'required'),
            array('question', 'length', 'max' => 500),
            array('status', 'length', 'max' => 1),
            array('created_at, modified_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('faq_id, question, answer, status, created_at, modified_at', 'safe', 'on' => 'search'),
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
            'faq_id' => 'Faq',
            'question' => 'Question',
            'answer' => 'Answer',
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

        $criteria->compare('faq_id', $this->faq_id);
        $criteria->compare('question', $this->question, true);
        $criteria->compare('answer', $this->answer, true);
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
     * @return Faq the static model class
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
