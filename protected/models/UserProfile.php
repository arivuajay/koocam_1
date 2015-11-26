<?php

/**
 * This is the model class for table "{{user_profile}}".
 *
 * The followings are the available columns in table '{{user_profile}}':
 * @property integer $prof_id
 * @property integer $user_id
 * @property string $prof_firstname
 * @property string $prof_lastname
 * @property string $prof_tag
 * @property string $prof_address
 * @property string $prof_phone
 * @property string $prof_skype
 * @property string $prof_website
 * @property string $prof_about
 * @property string $prof_languages
 * @property string $prof_interests
 * @property double $prof_rating
 * @property string $prof_picture
 * @property string $prof_cover_photo
 * @property string $created_at
 * @property string $modified_at
 * @property integer $created_by
 * @property integer $modified_by
 * @property integer $country_id
 *
 * The followings are the available model relations:
 * @property User $user
 * @property Country $country
 */
class UserProfile extends RActiveRecord {

    const IMG_WIDTH = 750;
    const IMG_HEIGHT = 529;
    const THUMB_WIDTH = 100;
    const THUMB_HEIGHT = 100;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{user_profile}}';
    }

    public function behaviors() {
        return array(
            'NUploadFile' => array(
                'class' => 'ext.nuploadfile.NUploadFile',
                'fileField' => 'prof_picture',
            ),
        );
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('prof_firstname', 'required'),
            array('user_id, created_by, modified_by', 'numerical', 'integerOnly' => true),
            array('prof_rating', 'numerical'),
            array('prof_firstname, prof_lastname', 'length', 'max' => 50),
            array('prof_tag, prof_skype, prof_website, prof_languages', 'length', 'max' => 100),
            array('prof_phone', 'length', 'max' => 30),
            array('prof_picture, prof_cover_photo', 'length', 'max' => 500),
            array('prof_address, prof_about, prof_interests, created_at, modified_at, country_id', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('prof_id, user_id, prof_firstname, prof_lastname, prof_tag, prof_address, prof_phone, prof_skype, prof_website, prof_about, prof_languages, prof_interests, prof_rating, prof_picture, prof_cover_photo, created_at, modified_at, created_by, modified_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'country' => array(self::BELONGS_TO, 'Country', 'country_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'prof_id' => 'Prof',
            'user_id' => 'User',
            'prof_firstname' => 'Firstname',
            'prof_lastname' => 'Lastname',
            'prof_tag' => 'Tag',
            'prof_address' => 'Address',
            'prof_phone' => 'Phone',
            'prof_skype' => 'Skype',
            'prof_website' => 'Website',
            'prof_about' => 'About',
            'prof_languages' => 'Languages',
            'prof_interests' => 'Interests',
            'prof_rating' => 'Rating',
            'prof_picture' => 'Profile Picture',
            'prof_cover_photo' => 'Cover Photo',
            'created_at' => 'Created At',
            'modified_at' => 'Modified At',
            'created_by' => 'Created By',
            'modified_by' => 'Modified By',
            'country_id' => 'Country',
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

        $criteria->compare($alias . '.prof_id', $this->prof_id);
        $criteria->compare($alias . '.user_id', $this->user_id);
        $criteria->compare($alias . '.prof_firstname', $this->prof_firstname, true);
        $criteria->compare($alias . '.prof_lastname', $this->prof_lastname, true);
        $criteria->compare($alias . '.prof_tag', $this->prof_tag, true);
        $criteria->compare($alias . '.prof_address', $this->prof_address, true);
        $criteria->compare($alias . '.prof_phone', $this->prof_phone, true);
        $criteria->compare($alias . '.prof_skype', $this->prof_skype, true);
        $criteria->compare($alias . '.prof_website', $this->prof_website, true);
        $criteria->compare($alias . '.prof_about', $this->prof_about, true);
        $criteria->compare($alias . '.prof_languages', $this->prof_languages, true);
        $criteria->compare($alias . '.prof_interests', $this->prof_interests, true);
        $criteria->compare($alias . '.prof_rating', $this->prof_rating);
        $criteria->compare($alias . '.prof_picture', $this->prof_picture, true);
        $criteria->compare($alias . '.prof_cover_photo', $this->prof_cover_photo, true);
        $criteria->compare($alias . '.created_at', $this->created_at, true);
        $criteria->compare($alias . '.modified_at', $this->modified_at, true);
        $criteria->compare($alias . '.created_by', $this->created_by);
        $criteria->compare($alias . '.modified_by', $this->modified_by);

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
     * @return UserProfile the static model class
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

    protected function beforeValidate() {
        if ($this->prof_languages && is_array($this->prof_languages))
            $this->prof_languages = CJSON::encode($this->prof_languages);
        return parent::beforeValidate();
    }

    protected function afterSave() {
        if ($this->prof_picture) {
            $user_path = UPLOAD_DIR . '/users/' . $this->user_id;
            $source = $destination1 = $user_path . $this->prof_picture;

            $width1 = self::IMG_WIDTH;
            $height1 = self::IMG_HEIGHT;

            $this->setUploadDirectory($user_path . '/thumb/userprofile');
            $destination2 = $user_path . '/thumb' . $this->prof_picture;
            $width2 = self::THUMB_WIDTH;
            $height2 = self::THUMB_HEIGHT;

            $image = Yii::app()->image->load($source);

            $image->resize($width1, $height1, Image::NONE);
            $image->save($destination1);

            $image->resize($width2, $height2, Image::NONE);
            $image->save($destination2);
        }

        return parent::afterSave();
    }

}
