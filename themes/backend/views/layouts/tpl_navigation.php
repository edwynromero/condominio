  <?php
  $baseUrl = Yii::app()->theme->baseUrl;
  ?>
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
                        array('label'=>MipHelper::t('Dashboard'), 'url'=>array('/backend')),
                   		
                        array('label'=>MipHelper::t("Fee and Pay's").' <span class="caret"></span>', 'url'=>'#','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                        'items'=>array(                        		
                        	array('label'=>"<b>".MipHelper::t("Pay's")."</b>", 'url'=>'#', 'itemOptions' => array('class' => 'nav-header')),
	                        	array('label'=>MipHelper::t("Payment Record"), 'url'=>array('/backend/pay/admin')),
                        		array('label'=>MipHelper::t("Payment Record to Bank"), 'url'=>array('/backend/payNotCashInfo/review')),
                                        array('label'=>MipHelper::t("Fees Assigment to Pays"), 'url'=>array('/backend/fixPay/processLocation')),
                        		
                        		array('label'=>"<b>".MipHelper::t("Fee's")."</b>", 'url'=>'#', 'itemOptions' => array('class' => 'nav-header')),
                        		array('label'=>MipHelper::t("Location Fee's"), 'url'=>array('/backend/fee/admin')),
                        		array('label'=>MipHelper::t("Fee Type"), 'url'=>array('/backend/feeType/admin')),
                            
                                        array('label'=>"<b>".MipHelper::t("Report's")."</b>", 'url'=>'#', 'itemOptions' => array('class' => 'nav-header')),
                                        array('label'=>MipHelper::t("Debtors"), 'url'=>array('/backend/report/defaulters')),
                        )),
                        array('label'=>MipHelper::t('Owners/Persons').' <span class="caret"></span>', 'url'=>'#','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                        'items'=>array(                        		
                        	array('label'=>"<b>".MipHelper::t('Locations')."</b>", 'url'=>'#', 'itemOptions' => array('class' => 'nav-header')),
	                        	array('label'=>MipHelper::t('Locations'), 'url'=>array('/backend/location/admin')),
	                        	array('label'=>MipHelper::t('Coordinates'), 'url'=>array('/backend/locationGeometry/admin')),
	                        	array('label'=>MipHelper::t('Owners'), 'url'=>array('/backend/owner/admin')),                        		
                        	array('label'=>"<b>".MipHelper::t('Owners')."</b>", 'url'=>'#', 'itemOptions' => array('class' => 'nav-header')),                        		
	                        	array('label'=>MipHelper::t('Persons'), 'url'=>array('/backend/person/admin')),
                        		array('label'=>MipHelper::t('Group Persons'), 'url'=>array('/backend/groupPerson/admin')),
	                        	array('label'=>MipHelper::t('Residents Association'), 'url'=>array('/backend/residentAssociation/admin')),
                        		array('label'=>MipHelper::t('Requests User Register'), 'url'=>array('/backend/registerRequest/admin')),
                        )),
                    	array('label'=>MipHelper::t('Finances').' <span class="caret"></span>', 'url'=>'#','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"),
                    		'items'=>array(
                    				array('label'=>"<b>".MipHelper::t('Banks')."</b>", 'url'=>'#', 'itemOptions' => array('class' => 'nav-header')),
                    				array('label'=>MipHelper::t('Bank Accounts'), 'url'=>array('/backend/bankAccount/index')),
                                                array('label'=>"<b>".MipHelper::t('AccountingAccounts')."</b>", 'url'=>'#', 'itemOptions' => array('class' => 'nav-header')),
                                                    array('label'=>MipHelper::t('AccountingAccounts'), 'url'=>array('/backend/accountingAccount/index')),
                                                    array('label'=>MipHelper::t('AccountingAliases'), 'url'=>array('/backend/accountingAlias/index')),
                                                array('label'=>"<b>".MipHelper::t('AccountingPeriods')."</b>", 'url'=>'#', 'itemOptions' => array('class' => 'nav-header')),
                                                    array('label'=>MipHelper::t('FiscalYears'), 'url'=>array('/backend/fiscalYear/index')),
                                                    array('label'=>MipHelper::t('AccountingPeriods'), 'url'=>array('/backend/accountingPeriod/index')),
                                                array('label'=>"<b>".MipHelper::t('AccountingMoves')."</b>", 'url'=>'#', 'itemOptions' => array('class' => 'nav-header')),
                                                    array('label'=>AccountingHelper::t('AccountingMoves Menu'), 'url'=>array('/backend/accountingMove/index')),
                                                array('label'=>"<b>".MipHelper::t('Configurations')."</b>", 'url'=>'#', 'itemOptions' => array('class' => 'nav-header')),
                                                    array('label'=> AccountingHelper::t('Accounting Journals'), 'url'=>array('/backend/accountingJournal/index')),
                                                    array('label'=>MipHelper::t('AccountingMoveStatuses'), 'url'=>array('/backend/accountingMoveStatus/index')),
                                                    array('label'=>MipHelper::t('AccountingAccountsType'), 'url'=>array('/backend/accountingAccountType/index')),


                                    )),                    
                    		
                    	array('label'=>MipHelper::t('System').' <span class="caret"></span>', 'url'=>'#','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"),
                    		'items'=>array(
                                                array('label'=>"<b>".MipHelper::t('Library')."</b>", 'url'=>'#', 'itemOptions' => array('class' => 'nav-header')),
                                                        array('label'=>MipHelper::t('Countries'), 'url'=>array('/backend/country/admin')),
                                                        array('label'=>MipHelper::t('States'), 'url'=>array('/backend/state/admin')),
	                    			array('label'=>MipHelper::t('Banks'), 'url'=>array('/backend/bank/admin')),
                                                array('label'=>"<b>".MipHelper::t('Residents Association')."</b>", 'url'=>'#', 'itemOptions' => array('class' => 'nav-header')),
                                                            array('label'=>MipHelper::t('Association Positions'), 'url'=>array('/backend/associationPosition/admin')),
                                                            array('label'=>MipHelper::t('Bank Accounts'), 'url'=>array('/backend/bankAccount/admin')),
                                                        array('label'=>"<b>".MipHelper::t('Users and Roles')."</b>", 'url'=>'#', 'itemOptions' => array('class' => 'nav-header')),                    				
                                                            array('label'=>MipHelper::t('Users'), 'url'=>array('/backend/user')),
                                                            array('label'=>MipHelper::t('Assign Permissions'), 'url'=>array('/auth/assignment')),
                                                            array('label'=>MipHelper::t('Roles'), 'url'=>array('/auth/role')),
                                                            array('label'=>MipHelper::t('Tasks'), 'url'=>array('/auth/task')),
                                                            array('label'=>MipHelper::t('Operations'), 'url'=>array('/auth/operation')),
                                                        array('label'=>"<b>".MipHelper::t('System Audit')."</b>", 'url'=>'#', 'itemOptions' => array('class' => 'nav-header')),
                                                            array('label'=>MipHelper::t('Operations Records'), 'url'=>array('/backend/log')),                    				
                    	), 'visible'=>Yii::app()->user->checkAccess(BizLogic::CONST_ROL_ADMIN_KEY) ),
                        array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                    	array('label'=> MipHelper::t('My account'), 'url'=>array('//site'), 'linkOptions' => array('target' => '_blank', 'class' => 'myaccount-link') ),
                        array('label'=>MipHelper::t('Logout').' ('.Yii::app()->user->name.')', 'url'=>array('//backend/default/logout'), 'visible'=>!Yii::app()->user->isGuest),
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