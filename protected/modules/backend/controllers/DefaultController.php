<?php

class DefaultController extends Controller
{
	

	public function actionIndex()
	{
		$this->render('index');
	}
	
	
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
            Yii::app()->theme = 'backend';

            if($error=Yii::app()->errorHandler->error)
            {
                if (Yii::app()->request->isAjaxRequest) {
                    echo $error['message'];
                } else {
                    $this->render('error', $error);
                }
            }
	}	
	
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}	
	
}