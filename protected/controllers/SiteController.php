<?php

class SiteController extends CController
{

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     *
     * If the user has entered a valid URL and entered the CAPTCHA correctly we use the CheckSite application
     * component to check whether the site is online and add the result to the model.
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
				$returnJson = array('validation_error'=>CHtml::errorSummary($model));
			}
			else {
				$returnJson = array('ok'=>$model->isSiteOk(), 'url'=>$model->url);
			}
		}

		echo CJSON::encode($returnJson);
		Yii::app()->end();
	}
}