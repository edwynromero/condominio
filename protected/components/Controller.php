<?php

Yii::import('application.modules.auth.filters.*');

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		$filters = parent::filters();
		$filters[]=array('auth.filters.AuthFilter');
		return $filters;
	}	
	
	
	public  function init()	
	{
		//
		// Tema por defecto:  website  
		// cambiamos el tema dependiendo del modulo donde se encuentre
		//
		$module = $this->getModule();

		if( empty( $module ) )
		{		
			if(  Yii::app()->user->checkAccess(MipHelper::ROLE_ADMIN) ) 
				$this->redirect(array('//backend'));
			 	
           Yii::app()->theme = "frontend";	
		}
		else 
		{
			switch( $module->Id )
			{
				case  "backend":
					
					Yii::app()->theme = "backend";
					break;
				case "auth":
					
					Yii::app()->theme = "backend";
					$module->defaultLayout = "webroot.themes.backend.views.layouts.column2";					
					break;
			}		
		}
		
	}
	
	
	/**
	 * 
	 * @return string
	 */
	public function getBodyClass()
	{
		$classBody = "page-";
		$module = $this->getModule();
		$classBody .= empty($module)?"":$module->id;
		$classBody .= "-".$this->getId();
		$classBody .= "-".$this->getAction()->getId();
				
		return $classBody;
	}
	
	
	
}