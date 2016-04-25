<?php

/**
 * This is the model class for table "{{cam_category}}".
 *
 * The followings are the available columns in table '{{cam_category}}':
 * @property integer $cat_id
 * @property string $cat_name
 * @property string $cat_description
 * @property string $cat_image
 * @property string $cat_cover_image
 * @property string $status
 * @property string $created_at
 * @property string $modified_at
 * @property integer $created_by
 * @property integer $modified_by
 *
 * The followings are the available model relations:
 * @property Cam[] $cams
 */
class CamCategory extends RActiveRecord {

    const IMG_WIDTH = 640;
    const IMG_HEIGHT = 540;
    const COVER_IMG_WIDTH = 1600;
    const COVER_IMG_HEIGHT = 600;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{cam_category}}';
    }

    public function behaviors() {
        return array(
            'NUploadFile' => array(
                'class' => 'ext.nuploadfile.NUploadFile',
                'fileField' => array('cat_image', 'cat_cover_image'),
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
            array('cat_name, slug', 'unique'),
            array('created_by, modified_by', 'numerical', 'integerOnly' => true),
            array('cat_name', 'length', 'max' => 100),
            array('cat_image, cat_cover_image', 'length', 'max' => 500),
            array('status', 'length', 'max' => 1),
            array('cat_image, cat_cover_image', 'file', 'allowEmpty' => false, 'on' => 'create'),
            array('cat_image, cat_cover_image', 'file', 'allowEmpty' => true, 'on' => 'update'),
//            array('cat_cover_image', 'dimensionValidation'),
            array('cat_description, modified_at, cat_cover_image', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('cat_id, cat_name, cat_description, cat_image, status, created_at, modified_at, created_by, modified_by, cat_cover_image', 'safe', 'on' => 'search'),
        );
    }

//    public function dimensionValidation($attribute, $param) {
//        if (isset($_FILES['CamCategory']['tmp_name']['cat_cover_image']) && !empty($_FILES['CamCategory']['tmp_name']['cat_cover_image'])) {
//            list($width, $height) = getimagesize($_FILES['CamCategory']['tmp_name']['cat_cover_image']);
//
//            if ($width != self::COVER_IMG_WIDTH || $height != self::COVER_IMG_HEIGHT){
//                $this->addError('cat_cover_image', 'Cover image size should be ' . self::COVER_IMG_WIDTH . '*' . self::COVER_IMG_HEIGHT . ' dimension');
//            }
//        }
//    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'cams' => array(self::HAS_MANY, 'Cam', 'cat_id'),
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
            'cat_image' => 'Category Image (640 X 540)',
            'cat_cover_image' => 'Cover Image (1600 X 600)',
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

        $criteria->compare($alias . '.cat_id', $this->cat_id);
        $criteria->compare($alias . '.cat_name', $this->cat_name, true);
        $criteria->compare($alias . '.cat_description', $this->cat_description, true);
        $criteria->compare($alias . '.cat_image', $this->cat_image, true);
        $criteria->compare($alias . '.status', $this->status, true);
        $criteria->compare($alias . '.created_at', $this->created_at, true);
        $criteria->compare($alias . '.modified_at', $this->modified_at, true);
        $criteria->compare($alias . '.created_by', $this->created_by);
        $criteria->compare($alias . '.modified_by', $this->modified_by);
        
        $criteria->order = "{$alias}.created_at DESC";

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
     * @return CamCategory the static model class
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
        return CamCategory::model()->active()->findAll(array(
                    'select' => '*, rand() as rand',
                    'limit' => $limit,
                    'order' => 'rand'
        ));
    }

    public function getCategoryimage($htmlOptions = array()) {
        if (!empty($this->cat_image))
            $path = UPLOAD_DIR . $this->cat_image;
        if (!isset($path) || !is_file($path))
            $path = 'themes/koocam/images/cam-cat-img.jpg';
        return CHtml::image(Yii::app()->createAbsoluteUrl($path), '', $htmlOptions);
    }

    public function getCoverimage($htmlOptions = array()) {
        if (!empty($this->cat_cover_image))
            $path = UPLOAD_DIR . $this->cat_cover_image;
        if (!isset($path) || !is_file($path))
            $path = 'themes/koocam/images/inner-banner.jpg';
        return CHtml::image(Yii::app()->createAbsoluteUrl($path), '', $htmlOptions);
    }

    public function getCoverimageurl($htmlOptions = array()) {
        if (!empty($this->cat_cover_image))
            $path = UPLOAD_DIR . $this->cat_cover_image;
        if (!isset($path) || !is_file($path))
            $path = 'themes/koocam/images/inner-banner.jpg';
        return Yii::app()->createAbsoluteUrl($path);
    }

    protected function afterSave() {
//        if ($this->cat_image && isset($_FILES['CamCategory']['name']['cat_image']) && !empty($_FILES['CamCategory']['name']['cat_image'])) {
//            $camcategory_path = UPLOAD_DIR;
//            $source = UPLOAD_DIR . $this->cat_image;
//
//            $width1 = self::IMG_WIDTH;
//            $height1 = self::IMG_HEIGHT;
//
//            $img = new Img;
//            $img->resampleGD($source, $camcategory_path, $this->cat_image, $width1, $height1, 1, 0);
//        }

        return parent::afterSave();
    }

}
