<?php $access_backend =  ( Yii::app()->user->checkAccess(MipHelper::ROLE_ADMIN) ||  Yii::app()->user->checkAccess(MipHelper::ROLE_ASSOCIATION) ) ?>
<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
	    <div class="container">
	        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </a>
	     
	          <!-- Be sure to leave the brand out there if you want it shown -->
                  <a class="brand" href="#"><img src="<?php echo $baseUrl ?>/img/logo_mirador_128.png" width="48" height="48">Mirador Panamericano - <small>Sistema de Gestión</small></a>
        
			  <div class="nav-collapse">
				<?php $this->widget('zii.widgets.CMenu',array(
	                    'htmlOptions'=>array('class'=>'pull-right nav'),
	                    'submenuHtmlOptions'=>array('class'=>'dropdown-menu'),
						'itemCssClass'=>'item-test',
	                    'encodeLabel'=>false,
	                    'items'=>array(
	                        array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                                array('label'=> MipHelperFront::t('Administration'), 'url'=>array('//backend'), 'visible'=>$access_backend, 'linkOptions' => array('target' => '_blank') ), 
                                array('label'=> MipHelperFront::t('My Profile'), 'url'=>array('/site/profile'), 'visible'=>true),
	                        array('label'=>MipHelper::t('Logout').' ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
	                    ),
	                )); ?>
	    	</div>	          
	    </div>
	</div>
</div>

<div class="subnav navbar navbar-fixed-top">
    <div class="navbar-inner">
    	<div class="container">        
        	<div class="style-switcher pull-left">
          	</div>
         <!--  <form class="navbar-search pull-right" action="">
           	 
           <input type="text" class="search-query span2" placeholder="Search">
           
           </form> -->
    	</div><!-- container -->
    </div><!-- navbar-inner -->
</div><!-- subnav -->