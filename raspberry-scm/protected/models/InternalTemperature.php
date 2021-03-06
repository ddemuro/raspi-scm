<?php

/**
 * This is the model class for table "internal_temperature".
 *
 * The followings are the available columns in table 'internal_temperature':
 * @property string $date
 * @property string $temperature
 */
class InternalTemperature extends TKActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'internal_temperature';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('date, temperature, type', 'required'),
            array('temperature', 'length', 'max' => 255),
            array('type', 'length', 'max' => 3),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('date, temperature, type', 'safe', 'on' => 'search'),
        );
    }

    /**
     * Save date and password before saving
     */
    public function beforeValidate() {
        sleep(rand(1,3)+1);
        $this->date = date('Y-m-d H:m:s');
        parent::beforeValidate();
        return true;
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
            'date' => 'Date',
            'type' => 'Type',
            'temperature' => 'Temperature',
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

        $criteria->compare('date', $this->date, true);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('temperature', $this->temperature, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
