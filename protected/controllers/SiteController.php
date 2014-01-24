<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

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
        if (isset($_POST['CheckSiteForm']))
        {
            $model->attributes = $_POST['CheckSiteForm'];
            if ($model->validate())
            {
                // Check whether the site is online
                $model->siteOk = Yii::app()->checkSite->isOnline($model->url);

                // Log the site check to the DB
                $siteCheckDao = new SiteCheckDao();
                $siteCheckDao->url = $model->url;
                $siteCheckDao->site_ok = $model->siteOk;
                if (!$siteCheckDao->save()) {
                    Yii::log('Unable to save site check record', CLogger::LEVEL_ERROR, 'controllers.SiteController');
                }
            }
        }

        // Have the model load the most recent site checks from the DB
        $model->loadMostRecentChecks();
        $this->render('index', array('model'=>$model));
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
}