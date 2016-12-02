<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $email
 * @property string $role
 * @property string $password
 */
class User extends TKActiveRecord {

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
        return 'user';
    }

    /**
     * Simple yet efficient way for password hashing
     */
    public function hashPassword($password, $salt) {
        return sha1(md5($salt) . $password);
    }

    /**
     * Generate a random readable password
     */
    public function generatePassword($minLength = 5, $maxLength = 10) {
        $length = rand($minLength, $maxLength);

        $letters = 'bcdfghjklmnpqrstvwxyz';
        $vowels = 'aeiou';
        $code = '';
        for ($i = 0; $i < $length; ++$i) {
            if ($i % 2 && rand(0, 10) > 2 || !($i % 2) && rand(0, 10) > 9)
                $code.=$vowels[rand(0, 4)];
            else
                $code.=$letters[rand(0, 20)];
        }

        return $code;
    }

    /**
     * Save date and password before saving
     */
    public function beforeSave() {
        if ($this->isNewRecord || $this->scenario == 'login') {
            $this->ipaddress = Yii::app()->request->getUserHostAddress();
        }

        if ($this->scenario == 'register' || $this->scenario == 'change') {
            $this->password = $this->hashPassword($this->password, $this->email);
        }

        if (($this->scenario == 'update' && $this->password)) {
            $this->password = $this->hashPassword($this->password, $this->email);
        }
        
        return parent::beforeSave();
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('email, role, password', 'required'),
            array('email, role, ipaddress, password', 'length', 'max' => 128),
            array('ipaddress', 'length', 'max' => 16),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, email, password', 'safe', 'on' => 'search'),
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
            'id' => 'ID',
            'email' => 'Email',
            'role' => 'Role',
            'ipaddress' => 'IP Address',
            'password' => 'Password',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('role', $this->role, true);
        $criteria->compare('ipaddress', $this->ipaddress, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('password', $this->password, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
