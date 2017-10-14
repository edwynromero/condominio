<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
  <div class="row-fluid">
	<div class="span2">
		<div class="sidebar-nav">
        
		  <?php $this->widget('zii.widgets.CMenu', array(
			/*'type'=>'list',*/
			'encodeLabel'=>false,
			'items'=>array(				// Include the operations menu
                            array(  'label'=>'<i class="icon icon-home"></i>  ' . MipHelperFront::t('Options') . ' <span class="label label-success pull-right">' . MipHelperFront::t('Neighbor') .'</span>',
                                    'items'=>array(
                                    	array('label'=>  MipHelperFront::t('My panel'),'url'=>array('//site/panel')),
                                        array('label'=>  MipHelperFront::t('My current debt'),'url'=>array('//site/currentDebt')),
                                        array('label'=>MipHelperFront::t('My payments'),'url'=>array('//site/payments')),
                                        array('label'=>MipHelperFront::t('Report payment'),'url'=>array('//site/reportPayment')),
                                        array('label'=> MipHelperFront::t('Account Historical'), 'url'=>array('/site/historical') ),
                                    ))
			),
			));?>
		</div>
        <br>
    </div><!--/span-->
    <div class="span9">
    
    <?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
            'links'=>$this->breadcrumbs,
			'homeLink'=>CHtml::link('Dashboard'),
			'htmlOptions'=>array('class'=>'breadcrumb')
        )); ?><!-- breadcrumbs -->
    <?php endif?>
    
    <!-- Include content pages -->
    <?php echo $content; ?>

	</div><!--/span-->
  </div><!--/row-->


<?php $this->endContent(); ?>