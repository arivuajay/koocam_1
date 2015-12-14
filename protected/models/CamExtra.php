<?php

/**
 * This is the model class for table "{{cam_extra}}".
 *
 * The followings are the available columns in table '{{cam_extra}}':
 * @property integer $extra_id
 * @property integer $cam_id
 * @property string $extra_price
 * @property string $extra_description
 * @property string $extra_file
 * @property string $created_by
 * @property string $modified_by
 *
 * The followings are the available model relations:
 * @property Cam $cam
 */
class CamExtra extends CActiveRecord {

    const ALLOW_FILE_TYPES = 'jpg, gif, png';
    const ALLOW_FILE_SIZE = 2; //In MB

    /**
     * @return string the associated database table name
     */

    public function tableName() {
        return '{{cam_extra}}';
    }

    /**
     * 
     * @return type
     */
    public function behaviors() {
        return array(
            'NUploadFile' => array(
                'class' => 'ext.nuploadfile.NUploadFile',
                'fileField' => 'extra_file',
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
            array('cam_id, extra_price, extra_description', 'required'),
            array('cam_id', 'numerical', 'integerOnly' => true),
            array('extra_price', 'length', 'max' => 10),
            array('extra_file', 'length', 'max' => 500),
//            array('extra_file', 'file', 'types' => self::ALLOW_FILE_TYPES, 'maxSize'=>1024 * 1024 * self::ALLOW_FILE_SIZE, 'tooLarge' => 'File has to be smaller than '.self::ALLOW_FILE_SIZE.'MB', 'allowEmpty' => true),
            array('created_by, modified_by, extra_file', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('extra_id, cam_id, extra_price, extra_description, created_by, modified_by', 'safe', 'on' => 'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'extra_id' => 'Extra',
            'cam_id' => 'Cam',
            'extra_price' => 'Extra Price',
            'extra_description' => 'Extra Description',
            'extra_file' => 'File',
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

        $criteria->compare('extra_id', $this->extra_id);
        $criteria->compare('cam_id', $this->cam_id);
        $criteria->compare('extra_price', $this->extra_price, true);
        $criteria->compare('extra_description', $this->extra_description, true);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->compare('modified_by', $this->modified_by, true);

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
     * @return CamExtra the static model class
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

    protected function afterFind() {
        $this->extra_price = $this->extra_price + 0;
        return parent::afterFind();
    }

    protected function beforeSave() {
        if (isset($_FILES['Cam']['name']['extra_file']) && !empty($_FILES['Cam']['name']['extra_file'])) {
            $user_path = $upl_dir = UPLOAD_DIR . '/users/' . $this->cam->tutor_id;
            $user_extra_path = $user_path . '/camextra/';
            $this->setUploadDirectory($user_extra_path);
            $newName = trim(md5(time())) . '.' . CFileHelper::getExtension($_FILES['Cam']['name']['extra_file']);
            $dir = DIRECTORY_SEPARATOR . strtolower(get_class($this)) . DIRECTORY_SEPARATOR;
            if (move_uploaded_file($_FILES['Cam']['tmp_name']['extra_file'], $user_extra_path . $newName))
                $this->extra_file = $dir . $newName;
        }
        return parent::beforeSave();
    }

}
