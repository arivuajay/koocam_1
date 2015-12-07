<?php

/**
 * This is the model class for table "{{testimonial}}".
 *
 * The followings are the available columns in table '{{testimonial}}':
 * @property integer $testimonial_id
 * @property string $testimonial_user
 * @property string $testimonial_text
 * @property string $testimonial_image
 * @property string $created_at
 * @property string $modified_at
 * @property string $status
 */
class Testimonial extends RActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{testimonial}}';
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
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('testimonial_user, testimonial_text', 'required'),
            array('testimonial_image', 'required', 'on' => 'create'),
            array('testimonial_user', 'length', 'max' => 50),
            array('testimonial_image', 'length', 'max' => 255),
            array('created_at, modified_at, status', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('testimonial_id, testimonial_user, testimonial_text, testimonial_image, created_at, modified_at', 'safe', 'on' => 'search'),
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
            'testimonial_id' => 'Testimonial',
            'testimonial_user' => 'Username',
            'testimonial_text' => 'Description',
            'testimonial_image' => 'Image',
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

        $criteria->compare('testimonial_id', $this->testimonial_id);
        $criteria->compare('testimonial_user', $this->testimonial_user, true);
        $criteria->compare('testimonial_text', $this->testimonial_text, true);
        $criteria->compare('testimonial_image', $this->testimonial_image, true);
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
     * @return Testimonial the static model class
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

    public function getImage($htmlOptions = array()) {
        if(!empty($this->testimonial_image))
            $path = UPLOAD_DIR . $this->testimonial_image;
        if (!isset($path) || !is_file($path))
            $path = 'themes/koocam/images/testimonails-img1.jpg';
        return CHtml::image(Yii::app()->createAbsoluteUrl($path), '', $htmlOptions);
    }
    
    public function behaviors() {
        return array(
            'NUploadFile' => array(
                'class' => 'ext.nuploadfile.NUploadFile',
                'fileField' => 'testimonial_image',
            ),
        );
    }
}
