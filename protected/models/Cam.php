<?php

/**
 * This is the model class for table "{{cam}}".
 *
 * The followings are the available columns in table '{{cam}}':
 * @property integer $cam_id
 * @property integer $tutor_id
 * @property string $cam_title
 * @property integer $cat_id
 * @property string $cam_media
 * @property string $cam_tag
 * @property string $cam_description
 * @property string $cam_duration
 * @property string $cam_price
 * @property string $cam_avail_visual
 * @property string $is_extra
 * @property string $status
 * @property string $slug
 * @property string $created_at
 * @property string $modified_at
 * @property string $cam_youtube_url
 * @property integer $created_by
 * @property integer $modified_by
 * @property integer $cam_important
 * @property integer $cam_rating
 *
 * The followings are the available model relations:
 * @property CamCategory $cat
 * @property User $tutor
 * @property CamComments[] $camComments
 * @property CamExtra[] $camExtras
 * @property CamBooking[] $camBookings
 */
class Cam extends RActiveRecord {

    public $extra_price;
    public $extra_description;
    public $extra_file;
    public $tutorUserName;
    public $camCategory;
    public $is_video;
    public $video_id;

    const CAM_MIN_DURATION = 5;
    const CAM_MAX_DURATION = 60;
    const CAM_ALLOW_FILE_TYPES = 'jpg, gif, png';
    const CAM_ALLOW_FILE_SIZE = 5; //In MB
    const EXTRA_ALLOW_FILE_TYPES = 'jpg, gif, png, pdf, doc';
    const EXTRA_ALLOW_FILE_SIZE = 5; //In MB
    const CAM_MIN_AMT = 5;
    const CAM_MAX_AMT = 100000;
    const EXTRA_MIN_AMT = 5;
    const EXTRA_MAX_AMT = 100000;
    const IMG_WIDTH = 750;
    const IMG_HEIGHT = 528;
    const THUMB_WIDTH = 500;
    const THUMB_HEIGHT = 440;
    //PAGE LIMITS
    const CAM_SEARCH_LIMIT = 9;
    const MY_CAM_LIMIT = 9;

    protected $_is_tutor;
    protected $_logged_user;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{cam}}';
    }

    public function init() {
        if ($this->isNewRecord) {
            $this->cam_duration = Cam::CAM_MIN_DURATION;
            $this->cam_price = Cam::CAM_MIN_AMT;
            $this->extra_price = Cam::EXTRA_MIN_AMT;

            $this->cam_avail_visual = 'Y';
            $this->is_video = 'N';
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
                'fileField' => 'cam_media',
            ),
            'SlugBehavior' => array(
                'class' => 'application.models.behaviors.SlugBehavior',
                'slug_col' => 'slug',
                'title_col' => 'cam_title',
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
            array('cam_title, cat_id, cam_tag, cam_description, cam_duration, cam_price', 'required'),
            array('tutor_id', 'required', 'on' => 'admin_create'),
            array('tutor_id', 'required', 'on' => 'admin_update'),
            array('tutor_id, cat_id, created_by, modified_by', 'numerical', 'integerOnly' => true),
            array('cam_title, cam_youtube_url', 'length', 'max' => 100),
            array('cam_youtube_url', 'url'),
            array('cam_media', 'length', 'max' => 500),
            array('cam_tag', 'length', 'max' => 255),
            array('cam_price, extra_price', 'length', 'max' => 10),
            array('cam_duration', 'numerical', 'integerOnly' => true, 'min' => self::CAM_MIN_DURATION, 'max' => self::CAM_MAX_DURATION),
            array('cam_price', 'numerical', 'integerOnly' => false, 'min' => self::CAM_MIN_AMT, 'max' => self::CAM_MAX_AMT),
            array('cam_avail_visual, status', 'length', 'max' => 1),
            array('cam_title, slug', 'unique'),
            array('cam_media', 'file', 'types' => self::CAM_ALLOW_FILE_TYPES, 'maxSize' => 1024 * 1024 * self::CAM_ALLOW_FILE_SIZE, 'tooLarge' => 'File has to be smaller than ' . self::CAM_ALLOW_FILE_SIZE . 'MB', 'allowEmpty' => true, 'on' => 'update'),
            array('cam_media', 'file', 'types' => self::CAM_ALLOW_FILE_TYPES, 'maxSize' => 1024 * 1024 * self::CAM_ALLOW_FILE_SIZE, 'tooLarge' => 'File has to be smaller than ' . self::CAM_ALLOW_FILE_SIZE . 'MB', 'allowEmpty' => true, 'on' => 'admin_update'),
            array('extra_file', 'file', 'maxSize' => 1024 * 1024 * self::EXTRA_ALLOW_FILE_SIZE, 'tooLarge' => 'File has to be smaller than ' . self::CAM_ALLOW_FILE_SIZE . 'MB', 'allowEmpty' => true),
            array('cam_price', 'priceValidate'),
//            array('modified_at', 'date', 'format' => Yii::app()->localtime->getLocalDateTimeFormat('short', 'short')),
            array('cam_description, cam_duration, created_at, modified_at, is_extra, extra_price, extra_description, tutorUserName, camCategory, extra_file, cam_important, cam_rating, is_video, cam_youtube_url', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('cam_id, tutor_id, cam_title, cat_id, cam_media, cam_tag, cam_description, cam_duration, cam_price, cam_avail_visual, status, created_at, modified_at, created_by, modified_by, cam_youtube_url', 'safe', 'on' => 'search'),
        );
    }

    public static function ajaxValidationFields() {
        // validate all except "file_field"
        return array('cam_title', 'cat_id', 'cam_tag', 'cam_description', 'cam_duration', 'cam_price', 'is_extra', 'extra_price', 'extra_description', 'cam_youtube_url');
    }

    /**
     * 
     * @param type $attribute
     * @param type $params
     */
    public function durationValidate($attribute, $params) {
        if (strtotime($this->cam_duration) < strtotime(self::CAM_MIN_DURATION)) {
            $this->addError($attribute, "Duration should be minimum " . self::CAM_MIN_DURATION);
        } else if (strtotime($this->cam_duration) > strtotime(self::CAM_MAX_DURATION)) {
            $this->addError($attribute, "Duration should not exceed " . self::CAM_MAX_DURATION);
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
        if ($this->cam_duration == '')
            $this->cam_duration = 0;
        $given_timestamp = strtotime(date('H:i', mktime(0, $this->cam_duration)));
        $given_price = $this->cam_price;

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
            $this->addError($attribute, "Cam price must be minumum {$err_price}");
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'cat' => array(self::BELONGS_TO, 'CamCategory', 'cat_id'),
            'camComments' => array(self::HAS_MANY, 'CamComments', 'cam_id'),
            'camExtras' => array(self::HAS_ONE, 'CamExtra', 'cam_id'),
            'tutor' => array(self::BELONGS_TO, 'User', 'tutor_id'),
            'camBookings' => array(self::HAS_MANY, 'CamBooking', 'book_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'cam_id' => 'Cam',
            'tutor_id' => 'User Id',
            'cam_title' => 'Title',
            'cat_id' => 'Category',
            'cam_media' => 'Photo',
            'cam_tag' => 'Tag (separate tags with commas)',
            'cam_description' => 'Description',
            'cam_duration' => 'Time (Minutes)',
            'cam_price' => 'Price ($)',
            'cam_avail_visual' => 'Will be available on visual chat',
            'is_extra' => 'Extras',
            'extra_price' => 'Extra File Price ($)',
            'extra_description' => 'About Extra File',
            'status' => 'Status',
            'cam_important' => 'Important',
            'created_at' => 'Created At',
            'modified_at' => 'Modified At',
            'created_by' => 'Created By',
            'modified_by' => 'Modified By',
            'is_video' => 'Video or Photo',
            'cam_youtube_url' => 'Video URL',
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

        $criteria->compare($alias . '.cam_id', $this->cam_id);
        $criteria->compare($alias . '.tutor_id', $this->tutor_id);
        $criteria->compare($alias . '.cam_title', $this->cam_title, true);
        $criteria->compare($alias . '.cat_id', $this->cat_id);
        $criteria->compare($alias . '.cam_media', $this->cam_media, true);
        $criteria->compare($alias . '.cam_tag', $this->cam_tag, true);
        $criteria->compare($alias . '.cam_description', $this->cam_description, true);
        $criteria->compare($alias . '.cam_duration', $this->cam_duration, true);
        $criteria->compare($alias . '.cam_price', $this->cam_price, true);
        $criteria->compare($alias . '.cam_avail_visual', $this->cam_avail_visual, true);
        $criteria->compare($alias . '.status', $this->status, true);
        $criteria->compare($alias . '.created_at', $this->created_at, true);
        $criteria->compare($alias . '.modified_at', $this->modified_at, true);
        $criteria->compare($alias . '.created_by', $this->created_by);
        $criteria->compare($alias . '.modified_by', $this->modified_by);

        $criteria->addSearchCondition('tutor.username', $this->tutorUserName);
        $criteria->addSearchCondition('cat.cat_name', $this->camCategory);

        $criteria->order = "{$alias}.created_at DESC";

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
     * @return Cam the static model class
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

    public static function topInstructors($tutor_id = '') {
        if ($tutor_id) {
            return Cam::model()->active()->findAll(array("condition" => "tutor_id = $tutor_id", 'limit' => 10));
        } else {
            return Cam::model()->active()->findAll(array('limit' => 10));
        }
    }

    public static function featuredCams() {
        return Cam::model()->active()->findAll(array('limit' => 4));
    }

    public function getUploadpath() {
        return $this->getFilePath();
    }

    protected function afterFind() {
        if ($this->is_extra == 'Y') {
            $this->extra_price = $this->camExtras->extra_price;
            $this->extra_description = $this->camExtras->extra_description;
            $this->extra_file = $this->camExtras->extra_file;
        }
        $time = explode(":", $this->cam_duration);
        $this->cam_duration = intval($time[0]) * 60 + intval($time[1]);

        $this->cam_price = $this->cam_price + 0;
        $this->extra_price = $this->extra_price + 0;

        if (!empty($this->cam_media) && empty($this->cam_youtube_url)) {
            $this->is_video = 'N';
        } else if (empty($this->cam_media) && !empty($this->cam_youtube_url)) {
            $this->is_video = 'Y';
        }

        parse_str(parse_url($this->cam_youtube_url, PHP_URL_QUERY), $my_array_of_vars);
        $this->video_id = $my_array_of_vars['v'];
        
        return parent::afterFind();
    }

    public static function userCamsCount($user_id, $status = 'active') {
        return Cam::model()->$status()->count('tutor_id = :user_id', array(':user_id' => $user_id));
    }

    protected function afterSave() {
        if ($this->cam_media && isset($_FILES['Cam']['name']['cam_media']) && !empty($_FILES['Cam']['name']['cam_media'])) {
            $cam_path = UPLOAD_DIR . '/users/' . $this->tutor_id;
            $source = $destination1 = $cam_path . $this->cam_media;

            $width1 = self::IMG_WIDTH;
            $height1 = self::IMG_HEIGHT;

            $img = new Img;
            $img->resampleGD($source, $cam_path, $this->cam_media, $width1, $height1, 1, 0);

            $this->setUploadDirectory($cam_path . '/thumb/cam');
            $destination2 = $cam_path . '/thumb' . $this->cam_media;
            $width2 = self::THUMB_WIDTH;
            $height2 = self::THUMB_HEIGHT;

            $image = Yii::app()->image->load($source);
            $image->resize($width2, $height2, Image::NONE);
            $image->save($destination2);
        }

        if ($this->is_extra == 'N' && !empty($this->camExtras)) {
            $this->camExtras->delete();
        }

        return parent::afterSave();
    }

    protected function beforeSave() {
        $this->cam_duration = date('H:i', mktime(0, $this->cam_duration));

        if ($this->is_video == 'N') {
            $this->cam_youtube_url = '';
        } else if ($this->is_video == 'Y') {
            $this->cam_media = '';
        }
        return parent::beforeSave();
    }

    public function beforeValidate() {
        if ($this->is_extra == 'Y') {
            $this->validatorList->add(CValidator::createValidator('required', $this, 'extra_price, extra_description'));
            $this->validatorList->add(CValidator::createValidator('numerical', $this, 'extra_price', array('min' => self::EXTRA_MIN_AMT, 'max' => self::EXTRA_MAX_AMT, 'integerOnly' => false)));
        }
        if ($this->is_video == 'Y') {
            $this->validatorList->add(CValidator::createValidator('required', $this, 'cam_youtube_url'));
            $this->validatorList->add(CValidator::createValidator('isEmbeddableYoutubeURL', $this, 'cam_youtube_url'));
        } else {
            $this->validatorList->add(CValidator::createValidator('file', $this, 'cam_media', array('types' => self::CAM_ALLOW_FILE_TYPES, 'maxSize' => 1024 * 1024 * self::CAM_ALLOW_FILE_SIZE, 'tooLarge' => 'File has to be smaller than ' . self::CAM_ALLOW_FILE_SIZE . 'MB', 'allowEmpty' => $this->is_video == 'Y', 'on' => 'create')));
            $this->validatorList->add(CValidator::createValidator('file', $this, 'cam_media', array('types' => self::CAM_ALLOW_FILE_TYPES, 'maxSize' => 1024 * 1024 * self::CAM_ALLOW_FILE_SIZE, 'tooLarge' => 'File has to be smaller than ' . self::CAM_ALLOW_FILE_SIZE . 'MB', 'allowEmpty' => $this->is_video == 'Y', 'on' => 'admin_create')));
        }

        return parent::beforeValidate();
    }

    public function getCamimage($htmlOptions = array()) {
        if ($this->is_video == 'N' && empty($this->cam_youtube_url)) {
            if (!empty($this->cam_media))
                $path = UPLOAD_DIR . '/users/' . $this->tutor_id . $this->cam_media;
            if (!isset($path) || !is_file($path))
                $path = 'themes/koocam/images/cam-img.jpg';
            $url = Yii::app()->createAbsoluteUrl($path);
        }else if ($this->is_video == 'Y' && !empty($this->cam_youtube_url)) {
            $url = "http://img.youtube.com/vi/{$this->video_id}/default.jpg";
        }
        return CHtml::image($url, '', $htmlOptions);
    }

    public function getCamthumb($htmlOptions = array(), $extraOptions = array()) {
        if ($this->is_video == 'N' && empty($this->cam_youtube_url)) {
            if (!empty($this->cam_media))
                $path = UPLOAD_DIR . '/users/' . $this->tutor_id . '/thumb' . $this->cam_media;
            if (!isset($path) || !is_file($path))
                $path = 'themes/koocam/images/cam-img.jpg';
            $url = Yii::app()->createAbsoluteUrl($path);
        }else if ($this->is_video == 'Y' && !empty($this->cam_youtube_url)) {
            $url = "http://img.youtube.com/vi/{$this->video_id}/default.jpg";
            $htmlOptions = array_merge($htmlOptions, $extraOptions);
        }
        return CHtml::image($url, '', $htmlOptions);
    }

    public function getStartnowButton($text = '<i class="fa fa-video-camera"></i> Start Now !', $class = 'big-btn btn btn-default', $data_target = 'startnow') {
        $this->setButtonOptions();
        $button = NULL;
        if (!$this->_is_tutor) :
            if ($this->_logged_user) {
                if ($this->tutor->live_status == 'A')
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

    public function getMessageButton($text = '<i class="fa fa-envelope-o"></i> Message', $class = 'big-btn btn big-btn3 btn-default', $data_target = 'message') {
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

    public function isEmbeddableYoutubeURL($attribute, $params) {
        $url = $this->cam_youtube_url;
        // Let's check the host first
        $parse = parse_url($url);
        $host = $parse['host'];
        if (!in_array($host, array('youtube.com', 'www.youtube.com'))) {
            return false;
        }

        $ch = curl_init();
        $oembedURL = 'www.youtube.com/oembed?url=' . urlencode($url) . '&format=json';
        curl_setopt($ch, CURLOPT_URL, $oembedURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($output);

        if (!$data)
            $this->addError($attribute, "Youtube Video Id must be valid id. (Unauthorized Video Id)");
        if (!$data->{'html'})
            $this->addError($attribute, "Youtube Video Id must be valid id. (Not Embeddable Video Id)");
    }

}
