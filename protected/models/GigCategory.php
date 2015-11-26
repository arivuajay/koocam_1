<?php

/**
 * This is the model class for table "{{gig_category}}".
 *
 * The followings are the available columns in table '{{gig_category}}':
 * @property integer $cat_id
 * @property string $cat_name
 * @property string $cat_description
 * @property string $cat_image
 * @property string $status
 * @property string $created_at
 * @property string $modified_at
 * @property integer $created_by
 * @property integer $modified_by
 *
 * The followings are the available model relations:
 * @property Gig[] $gigs
 */
class GigCategory extends RActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{gig_category}}';
    }

    public function behaviors() {
        return array(
            'NUploadFile' => array(
                'class' => 'ext.nuploadfile.NUploadFile',
                'fileField' => 'cat_image',
            ),
            'SlugBehavior' => array(
                'class' => 'application.models.behaviors.SlugBehavior',
                'slug_col' => 'slug',
                'title_col' => 'cat_name',
                'overwrite' => true
            )
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
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cat_name', 'required'),
            array('cat_name', 'unique'),
            array('created_by, modified_by', 'numerical', 'integerOnly' => true),
            array('cat_name', 'length', 'max' => 100),
            array('cat_image', 'length', 'max' => 500),
            array('status', 'length', 'max' => 1),
            array('cat_description, modified_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('cat_id, cat_name, cat_description, cat_image, status, created_at, modified_at, created_by, modified_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'gigs' => array(self::HAS_MANY, 'Gig', 'cat_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'cat_id' => 'Cat',
            'cat_name' => 'Category Name',
            'cat_description' => 'Category Description',
            'cat_image' => 'Category Image',
            'status' => 'Status',
            'created_at' => 'Created At',
            'modified_at' => 'Modified At',
            'created_by' => 'Created By',
            'modified_by' => 'Modified By',
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

        $criteria->compare($alias.'.cat_id', $this->cat_id);
        $criteria->compare($alias.'.cat_name', $this->cat_name, true);
        $criteria->compare($alias.'.cat_description', $this->cat_description, true);
        $criteria->compare($alias.'.cat_image', $this->cat_image, true);
        $criteria->compare($alias.'.status', $this->status, true);
        $criteria->compare($alias.'.created_at', $this->created_at, true);
        $criteria->compare($alias.'.modified_at', $this->modified_at, true);
        $criteria->compare($alias.'.created_by', $this->created_by);
        $criteria->compare($alias.'.modified_by', $this->modified_by);

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
     * @return GigCategory the static model class
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
    
    public static function getCategoryList($status = 'all') {
        return CHtml::listData(self::model()->$status()->findAll(), 'cat_id', 'cat_name');
    }
    
    public static function popularCategory($limit = 6) {
        return GigCategory::model()->active()->findAll(array('limit' => $limit));
    }
}
