<?php

/**
 * This is the model class for table "{{cms}}".
 *
 * The followings are the available columns in table '{{cms}}':
 * @property integer $cms_id
 * @property string $slug
 * @property string $cms_title
 * @property string $cms_description
 * @property string $cms_meta_keywords
 * @property string $cms_meta_description
 * @property string $cms_tag
 * @property string $status
 * @property string $created_at
 * @property string $modified_at
 */
class Cms extends RActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{cms}}';
    }
    
    public function behaviors() {
        return array(
            'SlugBehavior' => array(
                'class' => 'application.models.behaviors.SlugBehavior',
                'slug_col' => 'slug',
                'title_col' => 'cms_title',
                'overwrite' => false
            )
        );
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cms_title, cms_description', 'required'),
            array('cms_description', 'compare', 'compareValue' => '<br>', 'operator' => '!=', 'message' => 'Description cannot be blank'),
            array('slug, cms_title, cms_tag', 'length', 'max' => 255),
            array('status', 'length', 'max' => 1),
            array('cms_meta_keywords, cms_meta_description, modified_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('cms_id, slug, cms_title, cms_description, cms_meta_keywords, cms_meta_description, status, created_at, modified_at', 'safe', 'on' => 'search'),
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
            'cms_id' => 'Cms',
            'slug' => 'Cms Slug',
            'cms_title' => 'Title',
            'cms_description' => 'Description',
            'cms_meta_keywords' => 'Meta Keywords',
            'cms_meta_description' => 'Meta Description',
            'cms_tag' => 'Tag',
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

        $criteria->compare('cms_id', $this->cms_id);
        $criteria->compare('slug', $this->slug, true);
        $criteria->compare('cms_title', $this->cms_title, true);
        $criteria->compare('cms_description', $this->cms_description, true);
        $criteria->compare('cms_meta_keywords', $this->cms_meta_keywords, true);
        $criteria->compare('cms_meta_description', $this->cms_meta_description, true);
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
     * @return Cms the static model class
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
