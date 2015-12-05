<?php

/**
 * This is the model class for table "{{gig}}".
 *
 * The followings are the available columns in table '{{gig}}':
 * @property integer $gig_id
 * @property integer $tutor_id
 * @property string $gig_title
 * @property integer $cat_id
 * @property string $gig_media
 * @property string $gig_tag
 * @property string $gig_description
 * @property string $gig_duration
 * @property string $gig_price
 * @property string $gig_avail_visual
 * @property string $is_extra
 * @property string $status
 * @property string $slug
 * @property string $created_at
 * @property string $modified_at
 * @property integer $created_by
 * @property integer $modified_by
 * @property integer $gig_important
 * @property integer $gig_rating
 *
 * The followings are the available model relations:
 * @property GigCategory $cat
 * @property User $tutor
 * @property GigComments[] $gigComments
 * @property GigExtra[] $gigExtras
 * @property GigBooking[] $gigBookings
 */
class Gig extends RActiveRecord {

    public $extra_price;
    public $extra_description;
    public $extra_file;
    public $tutorUserName;
    public $gigCategory;

    const GIG_MIN_DURATION = 5;
    const GIG_MAX_DURATION = 60;
    const GIG_ALLOW_FILE_TYPES = 'jpg, gif, png';
    const GIG_ALLOW_FILE_SIZE = 1; //In MB
    const EXTRA_ALLOW_FILE_TYPES = 'jpg, gif, png, pdf, doc';
    const EXTRA_ALLOW_FILE_SIZE = 5; //In MB
    const GIG_MIN_AMT = 5;
    const GIG_MAX_AMT = 100000;
    const EXTRA_MIN_AMT = 5;
    const EXTRA_MAX_AMT = 100000;
    const IMG_WIDTH = 750;
    const IMG_HEIGHT = 528;
    const THUMB_WIDTH = 500;
    const THUMB_HEIGHT = 440;
    
    //PAGE LIMITS
    const GIG_SEARCH_LIMIT = 9;
    const MY_GIG_LIMIT = 9;

    protected $_is_tutor;
    protected $_logged_user;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{gig}}';
    }

    public function init() {
        if ($this->isNewRecord) {
            $this->gig_duration = Gig::GIG_MIN_DURATION;
            $this->gig_price = Gig::GIG_MIN_AMT;
            $this->extra_price = Gig::EXTRA_MIN_AMT;
        }

        parent::init();
    }

    /**
     * 
     * @return type
     */
    public function behaviors() {
        return array(
            'NUploadFile' => array(
                'class' => 'ext.nuploadfile.NUploadFile',
                'fileField' => 'gig_media',
            ),
            'SlugBehavior' => array(
                'class' => 'application.models.behaviors.SlugBehavior',
                'slug_col' => 'slug',
                'title_col' => 'gig_title',
                'overwrite' => true
            )
        );
    }

    /*     * *
     * 
     */

    public function scopes() {
        $alias = $this->getTableAlias(false, false);
        $user_id = Yii::app()->user->id;
        
        return array(
            'active' => array('condition' => "$alias.status = '1'"),
            'inactive' => array('condition' => "$alias.status = '0'"),
            'deleted' => array('condition' => "$alias.status = '2'"),
            'all' => array('condition' => "$alias.status is not null"),
            'exceptDelete' => array('condition' => "$alias.status IN ('1','0')"),
            'mine' => array('condition' => "$alias.tutor_id = $user_id"),
        );
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('gig_title, cat_id, gig_tag, gig_description, gig_duration, gig_price', 'required'),
            array('tutor_id', 'required', 'on' => 'admin_create'),
            array('tutor_id', 'required', 'on' => 'admin_update'),
            array('tutor_id, cat_id, created_by, modified_by', 'numerical', 'integerOnly' => true),
            array('gig_title', 'length', 'max' => 100),
            array('gig_media', 'length', 'max' => 500),
            array('gig_tag', 'length', 'max' => 255),
            array('gig_price, extra_price', 'length', 'max' => 10),
            array('gig_duration', 'numerical', 'integerOnly' => true, 'min' => self::GIG_MIN_DURATION, 'max' => self::GIG_MAX_DURATION),
            array('gig_price', 'numerical', 'integerOnly' => false, 'min' => self::GIG_MIN_AMT, 'max' => self::GIG_MAX_AMT),
            array('gig_avail_visual, status', 'length', 'max' => 1),
            array('gig_title, slug', 'unique'),
            array('gig_media', 'file', 'types' => self::GIG_ALLOW_FILE_TYPES, 'maxSize' => 1024 * 1024 * self::GIG_ALLOW_FILE_SIZE, 'tooLarge' => 'File has to be smaller than ' . self::GIG_ALLOW_FILE_SIZE . 'MB', 'allowEmpty' => false, 'on' => 'create'), array('gig_media', 'file', 'types' => self::GIG_ALLOW_FILE_TYPES, 'maxSize' => 1024 * 1024 * self::GIG_ALLOW_FILE_SIZE, 'tooLarge' => 'File has to be smaller than ' . self::GIG_ALLOW_FILE_SIZE . 'MB', 'allowEmpty' => true, 'on' => 'update'),
            array('gig_media', 'file', 'types' => self::GIG_ALLOW_FILE_TYPES, 'maxSize' => 1024 * 1024 * self::GIG_ALLOW_FILE_SIZE, 'tooLarge' => 'File has to be smaller than ' . self::GIG_ALLOW_FILE_SIZE . 'MB', 'allowEmpty' => false, 'on' => 'admin_create'),
            array('gig_media', 'file', 'types' => self::GIG_ALLOW_FILE_TYPES, 'maxSize' => 1024 * 1024 * self::GIG_ALLOW_FILE_SIZE, 'tooLarge' => 'File has to be smaller than ' . self::GIG_ALLOW_FILE_SIZE . 'MB', 'allowEmpty' => true, 'on' => 'admin_update'),
            array('extra_file', 'file', 'types' => self::EXTRA_ALLOW_FILE_TYPES, 'maxSize' => 1024 * 1024 * self::EXTRA_ALLOW_FILE_SIZE, 'tooLarge' => 'File has to be smaller than ' . self::GIG_ALLOW_FILE_SIZE . 'MB', 'allowEmpty' => true),
            array('gig_price', 'priceValidate'),
//            array('modified_at', 'date', 'format' => Yii::app()->localtime->getLocalDateTimeFormat('short', 'short')),
            array('gig_description, gig_duration, created_at, modified_at, is_extra, extra_price, extra_description, tutorUserName, gigCategory, extra_file, gig_important, gig_rating', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('gig_id, tutor_id, gig_title, cat_id, gig_media, gig_tag, gig_description, gig_duration, gig_price, gig_avail_visual, status, created_at, modified_at, created_by, modified_by', 'safe', 'on' => 'search'),
        );
    }

    public static function ajaxValidationFields() {
        // validate all except "file_field"
        return array('gig_title', 'cat_id', 'gig_tag', 'gig_description', 'gig_duration', 'gig_price', 'is_extra', 'extra_price', 'extra_description');
    }

    /**
     * 
     * @param type $attribute
     * @param type $params
     */
    public function durationValidate($attribute, $params) {
        if (strtotime($this->gig_duration) < strtotime(self::GIG_MIN_DURATION)) {
            $this->addError($attribute, "Duration should be minimum " . self::GIG_MIN_DURATION);
        } else if (strtotime($this->gig_duration) > strtotime(self::GIG_MAX_DURATION)) {
            $this->addError($attribute, "Duration should not exceed " . self::GIG_MAX_DURATION);
        }
    }

    /**
     * 
     * @param type $attribute
     * @param type $params
     */
    public function priceValidate($attribute, $params) {
        $limits = Myclass::priceLimitation();
        $prev_timestamp = key(array(current($limits)));
        if ($this->gig_duration == '')
            $this->gig_duration = 0;
        $given_timestamp = strtotime(date('H:i', mktime(0, $this->gig_duration)));
        $given_price = $this->gig_price;

        $i = 1;
        $iMax = count($limits);

//      old calculations
//        foreach ($limits as $calc_timestamp => $calc_price) {
//            if ($given_price < $calc_price) {
//                if (($given_timestamp > $prev_timestamp && $given_timestamp < $calc_timestamp)) {
//                    $error = true;
//                    $err_price = $calc_price;
//                } else if ($given_timestamp > $calc_timestamp && $i == $iMax) {
//                    $error = true;
//                    $err_price = $calc_price;
//                }
//            }
//            $prev_timestamp = $calc_timestamp;
//            $i++;
//        }

        foreach ($limits as $calc_timestamp => $calc_price) {
            if ($given_timestamp >= $calc_timestamp) {
                if ($given_price < $calc_price) {
                    $error = true;
                    $err_price = $calc_price;
                }
            }
            $prev_timestamp = $calc_timestamp;
            $i++;
        }

        if ($error)
            $this->addError($attribute, "Gig price must be minumum {$err_price}");
    }

    /**
     * 
     * @param type $attribute
     * @param type $params
     */
    public function mediaValidate($attribute, $params) {
        
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'cat' => array(self::BELONGS_TO, 'GigCategory', 'cat_id'),
            'gigComments' => array(self::HAS_MANY, 'GigComments', 'gig_id'),
            'gigExtras' => array(self::HAS_ONE, 'GigExtra', 'gig_id'),
            'tutor' => array(self::BELONGS_TO, 'User', 'tutor_id'),
            'gigBookings' => array(self::HAS_MANY, 'GigBooking', 'book_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'gig_id' => 'Gig',
            'tutor_id' => 'User Id',
            'gig_title' => 'Title',
            'cat_id' => 'Category',
            'gig_media' => 'Video or Photo',
            'gig_tag' => 'Tag',
            'gig_description' => 'Description',
            'gig_duration' => 'Time (Minutes)',
            'gig_price' => 'Price ($)',
            'gig_avail_visual' => 'Will be available on visual chat',
            'is_extra' => 'Extras',
            'extra_price' => 'Extra File Price ($)',
            'extra_description' => 'About Extra File',
            'status' => 'Status',
            'gig_important' => 'Important',
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

        $criteria->compare($alias . '.gig_id', $this->gig_id);
        $criteria->compare($alias . '.tutor_id', $this->tutor_id);
        $criteria->compare($alias . '.gig_title', $this->gig_title, true);
        $criteria->compare($alias . '.cat_id', $this->cat_id);
        $criteria->compare($alias . '.gig_media', $this->gig_media, true);
        $criteria->compare($alias . '.gig_tag', $this->gig_tag, true);
        $criteria->compare($alias . '.gig_description', $this->gig_description, true);
        $criteria->compare($alias . '.gig_duration', $this->gig_duration, true);
        $criteria->compare($alias . '.gig_price', $this->gig_price, true);
        $criteria->compare($alias . '.gig_avail_visual', $this->gig_avail_visual, true);
        $criteria->compare($alias . '.status', $this->status, true);
        $criteria->compare($alias . '.created_at', $this->created_at, true);
        $criteria->compare($alias . '.modified_at', $this->modified_at, true);
        $criteria->compare($alias . '.created_by', $this->created_by);
        $criteria->compare($alias . '.modified_by', $this->modified_by);

        $criteria->addSearchCondition('tutor.username', $this->tutorUserName);
        $criteria->addSearchCondition('cat.cat_name', $this->gigCategory);

        $criteria->with = array('tutor', 'cat');

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
     * @return Gig the static model class
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

    public static function topInstructors() {
        return Gig::model()->active()->findAll(array('limit' => 10));
    }

    public static function featuredGigs() {
        return Gig::model()->active()->findAll(array('limit' => 4));
    }

    public function getUploadpath() {
        return $this->getFilePath();
    }

    protected function afterFind() {
        if ($this->is_extra == 'Y') {
            $this->extra_price = $this->gigExtras->extra_price;
            $this->extra_description = $this->gigExtras->extra_description;
            $this->extra_file = $this->gigExtras->extra_file;
        }
        $time = explode(":", $this->gig_duration);
        $this->gig_duration = intval($time[0]) * 60 + intval($time[1]);

        $this->gig_price = $this->gig_price + 0;
        $this->extra_price = $this->extra_price + 0;
        return parent::afterFind();
    }

    public static function userGigsCount($user_id, $status = 'active') {
        return Gig::model()->$status()->count();
    }

    protected function afterSave() {
        if ($this->gig_media && isset($_FILES['Gig']['name']['gig_media']) && !empty($_FILES['Gig']['name']['gig_media'])) {
            $gig_path = UPLOAD_DIR . '/users/' . $this->tutor_id;
            $source = $destination1 = $gig_path . $this->gig_media;

            $width1 = self::IMG_WIDTH;
            $height1 = self::IMG_HEIGHT;

            $img = new Img;
            $img->resampleGD($source, $gig_path, $this->gig_media, $width1, $height1, 1, 0);

            $this->setUploadDirectory($gig_path . '/thumb/gig');
            $destination2 = $gig_path . '/thumb' . $this->gig_media;
            $width2 = self::THUMB_WIDTH;
            $height2 = self::THUMB_HEIGHT;

            $image = Yii::app()->image->load($source);
            $image->resize($width2, $height2, Image::NONE);
            $image->save($destination2);
        }

        if ($this->is_extra == 'N' && !empty($this->gigExtras)) {
            $this->gigExtras->delete();
        }

        return parent::afterSave();
    }

    protected function beforeSave() {
        $this->gig_duration = date('H:i', mktime(0, $this->gig_duration));
        return parent::beforeSave();
    }

    public function beforeValidate() {
        if ($this->is_extra == 'Y') {
            $this->validatorList->add(CValidator::createValidator('required', $this, 'extra_price, extra_description', array()));
            $this->validatorList->add(CValidator::createValidator('numerical', $this, 'extra_price', array('min' => self::EXTRA_MIN_AMT, 'max' => self::EXTRA_MAX_AMT, 'integerOnly' => false)));
        }

        return parent::beforeValidate();
    }

    public function getGigimage($htmlOptions = array()) {
        if (!empty($this->gig_media))
            $path = UPLOAD_DIR . '/users/' . $this->tutor_id . $this->gig_media;
        if (!isset($path) || !is_file($path))
            $path = 'themes/koocam/images/profile-img.jpeg';
        return CHtml::image(Yii::app()->createAbsoluteUrl($path), '', $htmlOptions);
    }

    public function getGigthumb($htmlOptions = array()) {
        if (!empty($this->gig_media))
            $path = UPLOAD_DIR . '/users/' . $this->tutor_id . '/thumb' . $this->gig_media;
        if (!isset($path) || !is_file($path))
            $path = 'themes/koocam/images/profile-img.jpeg';
        return CHtml::image(Yii::app()->createAbsoluteUrl($path), '', $htmlOptions);
    }

    public function getStartnowButton($text = '<i class="fa fa-video-camera"></i> Start Now !', $class = 'big-btn btn btn-default', $data_target = 'startnow') {
        $this->setButtonOptions();
        $button = NULL;
        if (!$this->_is_tutor) :
            if ($this->_logged_user) {
                $button = CHtml::link($text, '#', array('class' => $class, 'data-toggle' => "modal", 'data-target' => "#$data_target"));
            } else {
                $button = CHtml::link($text, '#', array('class' => $class, 'data-toggle' => "modal", 'data-target' => ".bs-example-modal-sm1", 'data-dismiss' => ".bs-example-modal-sm"));
            }
        endif;
        return $button;
    }

    public function getBookingButton($text = '<i class="fa fa-pencil"></i> Booking', $class = 'big-btn btn btn-default big-btn2', $data_target = 'booking') {
        $button = NULL;
        if (!$this->_is_tutor) :
            if ($this->_logged_user) {
                $button = CHtml::link($text, '#', array('class' => $class, 'data-toggle' => "modal", 'data-target' => "#$data_target"));
            } else {
                $button = CHtml::link($text, '#', array('class' => $class, 'data-toggle' => "modal", 'data-target' => ".bs-example-modal-sm1", 'data-dismiss' => ".bs-example-modal-sm"));
            }
        endif;
        return $button;
    }
    public function getMessageButton($text = '<i class="fa fa-envelope-o"></i> Message', $class = 'big-btn btn big-btn3 btn-default', $data_target = 'booking') {
        $button = NULL;
        if (!$this->_is_tutor) :
            if ($this->_logged_user) {
                $button = CHtml::link($text, '#', array('class' => $class, 'data-toggle' => "modal", 'data-target' => "#$data_target"));
            } else {
                $button = CHtml::link($text, '#', array('class' => $class, 'data-toggle' => "modal", 'data-target' => ".bs-example-modal-sm1", 'data-dismiss' => ".bs-example-modal-sm"));
            }
        endif;
        return $button;
    }

    public function setButtonOptions() {
        $this->_is_tutor = !Yii::app()->user->isGuest && Yii::app()->user->id == $this->tutor_id;
        $this->_logged_user = !$this->_is_tutor && !Yii::app()->user->isGuest;
    }
}
