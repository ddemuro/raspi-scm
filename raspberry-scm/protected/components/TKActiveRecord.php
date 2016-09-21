<?php

/*
 * This class is a wrapper to common functions all models should have, developed
 * and mantained by TakeLAN Uruguay.
 * Original Developer Derek Demuro.
 */

class TKActiveRecord extends CActiveRecord {

    public $isView = false;

    /**
     * We set if the record is a view
     * @param type $view
     */
    public function recordIsAView($view) {
        $this->isView = $view;
    }

    public function beforeSave() {
        if (parent::beforeSave()) {
            //If this ActiveRecord is a view, we disable saving.
            if ($this->isView) {
                return false;
            }
            return true;
        }
    }

    /**
     * @return model To String
     */
    public function ToString() {
        $attributes = $this->attributeLabels();
        $returnString = '';
        foreach ($attributes as $key => $value) {
            $returnString.=' ' . $value . ' ' . $this->$key;
        }
        return $returnString;
    }

}
