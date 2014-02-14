<?php

class SiteController extends CController
{

    /**
     * This is the default 'index' action that is invoked when an action is not explicitly requested by users.
     * It displays the default home page.
     */
    public function actionIndex()
    {
		$model = new CheckSiteForm();
		$this->render('index', array('model'=>$model));
    }

    /**
     * This is the action to handle the About page.
     */
    public function actionAbout()
    {
        $this->render('about');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if($error=Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

	/**
	 * This action is called via AJAX and returns whether a site is online.
	 * It uses the CheckSiteForm model to perform field validation. If the fields are valid it then uses the
	 * CheckSite application component to check whether the site is online.
	 * The result (or any validation errors) is returned as JSON.
	 */
	public function actionSitecheck()
	{
		header('Content-type: application/json');

		$model = new CheckSiteForm();
		$returnJson = array();

		if (isset($_GET['CheckSiteForm']))
		{
			$model->attributes = $_GET['CheckSiteForm'];

			if ($model->validate())
			{
				// Check whether the site is online
				$model->checkSite();
			}

			if ($model->hasErrors()) {
				// Yii reports all validation errors but we only want to return the first one
				$errors = $model->getErrors();
				$firstError = reset($errors)[0];
				$returnJson = array('validation_error'=>$firstError);
			}
			else {
				$returnJson = array('ok'=>$model->isSiteOk(), 'url'=>$model->url);
			}
		}

		echo CJSON::encode($returnJson);
		Yii::app()->end();
	}

	/**
	 * This action is called via AJAX and returns an array of the most recent site checks as JSON.
	 */
	public function actionRecentsitechecks()
	{
		header('Content-type: application/json');
		$model = new CheckSiteForm();
		$siteChecks = $model->getSiteChecks();
		echo CJSON::encode($siteChecks);
		Yii::app()->end();
	}
}