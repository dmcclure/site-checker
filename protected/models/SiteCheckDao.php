<?php

/**
 * This is the model class for table "site_check".
 */
class SiteCheckDao extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return SiteCheckDao the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'site_check';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('url', 'required'),
            array('check_date', 'default', 'value'=>date('Y-m-d H:i:s'), 'setOnEmpty'=>true, 'on'=>'insert'),
            array('url', 'length', 'max'=>200),
            array('site_ok', 'boolean', 'allowEmpty'=>false),
            array('id, check_date', 'unsafe'),  // Attributes that cannot be specified in create/update operations
        );
    }
}
