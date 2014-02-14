<?php

/**
 * CheckSiteForm class.
 * This class is the model used by the site checking form. It holds the form's data and performs validation.
 */
class CheckSiteForm extends CFormModel
{
    // These attributes are public so they can be automatically populated by Yii
    public $url;            // URL entered by the user
    public $testMethod;     // Method with which to test the site (CheckSite::CURL or CheckSite::SOCKET)

    protected $siteOk;      // Will be set to true if the site was verified as working
    protected $siteChecks;  // An array of SiteCheckDao objects representing the most recent site checks

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            array('url', 'required'), // url is required
            array('url', 'url', 'defaultScheme' => 'http', 'message'=>"&quot;{$_GET['CheckSiteForm']['url']}&quot; is not a valid URL"), // The url value has to be a valid URL
			array('testMethod', 'in', 'range'=>array(CheckSite::$CURL, CheckSite::$SOCKET)), // The test method must be valid
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
			'testMethod'=>'Test Method',
        );
    }

	/**
	 * Perform a test of the site located at $this->url and log the result to the DB.
	 */
	public function checkSite()
	{
		$this->siteOk = Yii::app()->checkSite->isOnline($this->url, $this->testMethod);

		// Log the site check to the DB
		$siteCheckDao = new SiteCheckDao();
		$siteCheckDao->url = $this->url;
		$siteCheckDao->site_ok = $this->siteOk;
		if (!$siteCheckDao->save()) {
			Yii::log('Unable to save site check record', CLogger::LEVEL_ERROR, 'controllers.SiteController');
		}
	}

	/**
	 * @return boolean true if the site checked is online, false if the site is offline or there was a problem
	 */
	public function isSiteOk()
	{
		return $this->siteOk;
	}

	/**
	 * @param $numChecks int The number of site checks to load from the DB (defaults to 8)
	 * @return array An array of SiteCheckDao objects representing the most recent site checks stored in the DB
	 */
	public function getSiteChecks($numChecks = 8)
	{
		if (!isset($this->siteChecks))
		{
			$this->siteChecks = SiteCheckDao::model()->findAll(array(
				'order' => 'id DESC',
				'limit' => $numChecks,
			));
		}

		return $this->siteChecks;
	}
}