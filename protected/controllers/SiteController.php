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
        if (isset($_POST['CheckSiteForm']))
        {
            $model->attributes = $_POST['CheckSiteForm'];
            if ($model->validate())
            {
                // Check whether the site is online
                $model->checkSite();
            }
        }

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
}