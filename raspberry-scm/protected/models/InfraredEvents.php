
<?php

/**
 * This is the model class for table "infrared_events".
 *
 * The followings are the available columns in table 'infrared_events':
 * @property string $date
 * @property string $device
 * @property string $event
 * @property string $extended
 */
class InfraredEvents extends TKActiveRecord {

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
        return 'infrared_events';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('date, device, event, extended', 'required'),
            array('device, event', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('date, device, event, extended', 'safe', 'on' => 'search'),
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
            'date' => 'Date',
            'device' => 'Device',
            'event' => 'Event',
            'extended' => 'Extended',
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
        $criteria->compare('device', $this->device, true);
        $criteria->compare('event', $this->event, true);
        $criteria->compare('extended', $this->extended, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
