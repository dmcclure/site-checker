<?php

/**
 * CheckSiteForm class.
 * This class is the model used by the site checking form. It holds the form's data and performs site checking functions.
 */
class CheckSiteForm extends CFormModel
{
    // These attributes are public so they can be automatically populated by Yii
    public $url;            // URL entered by the user
    public $verifyCode;     // Verification code entered by the user
    public $siteOk;         // Will be set to true if the site was verified as working
    public $siteChecks;     // An array of SiteCheckDao objects representing the most recent site checks

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            // url is required
            array('url', 'required'),
            // The url value has to be a valid URL
            array('url', 'url', 'defaultScheme' => 'http'),
            // verifyCode needs to be entered correctly
            array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return array(
            'url'=>'URL',
            'verifyCode'=>'Verification Code',
        );
    }

    /**
     * This method will load the most recent site checks from the DB and populate $this->siteChecks.
     * @param $numChecks int The number of site checks to load from the DB (defaults to 5)
     */
    public function loadMostRecentChecks($numChecks = 5)
    {
        $this->siteChecks = SiteCheckDao::model()->findAll(array(
            'order' => 'id DESC',
            'limit' => $numChecks,
        ));
    }
}