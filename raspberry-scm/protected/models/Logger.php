<?php

/**
 * This is the model class for table "logger".
 *
 * The followings are the available columns in table 'logger':
 * @property string $date
 * @property string $log
 */
class Logger extends TKActiveRecord {

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
        return 'logger';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('date, log', 'required'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('date, log', 'safe', 'on' => 'search'),
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
            'log' => 'Log',
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
        $criteria->compare('log', $this->log, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
