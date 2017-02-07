<?php

/**
 * This is the model class for table "ups".
 *
 * The followings are the available columns in table 'ups':
 * @property string $ups_details
 * @property string $date
 * @property string $setting
 */
class Ups extends TKActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'ups';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ups_details, date', 'required'),
            array('setting', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('ups_details, date, setting', 'safe', 'on' => 'search'),
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
     * Save date and password before saving
     */
    public function beforeSave() {
        parent::beforeSave();
        $this->date = date('Y-m-d H:m:s');
	return true;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'ups_details' => 'Ups Details',
            'date' => 'Date',
            'setting' => 'Setting',
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

        $criteria->compare('ups_details', $this->ups_details, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('setting', $this->setting, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Ups the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
