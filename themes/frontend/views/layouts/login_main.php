<!DOCTYPE html>
<html id="layout_login"  lang="en">
  <head>
  <?php
  $baseUrl = Yii::app()->theme->baseUrl;
  $cs = Yii::app()->getClientScript();
  ?>
    <meta charset="utf-8">
    <title>Mirador Panamericano - Backend </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Free yii themes, free web application theme">
    <meta name="author" content="Webapplicationthemes.com">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="<?php echo $baseUrl;?>/js/html5.js"></script>
    <![endif]-->
	<?php
	  Yii::app()->clientScript->registerCoreScript('jquery');
	?>
    <!-- Fav and Touch and touch icons -->
    <link rel="shortcut icon" href="<?php echo $baseUrl;?>/img/icons/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $baseUrl;?>/img/icons/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $baseUrl;?>/img/icons/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo $baseUrl;?>/img/icons/apple-touch-icon-57-precomposed.png">
	<?php  
	$cs->registerCssFile($baseUrl.'/css/fonts.css');
	  $cs->registerCssFile($baseUrl.'/css/bootstrap.min.css');
	  $cs->registerCssFile($baseUrl.'/css/bootstrap-responsive.min.css');
	  $cs->registerCssFile($baseUrl.'/css/abound.css');
	  //$cs->registerCssFile($baseUrl.'/css/style-blue.css');
	  ?>
      <!-- styles for style switcher -->
      	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl;?>/css/style-green.css" />
	  <?php

	  $cs->registerScriptFile($baseUrl.'/js/plugins/jquery.sparkline.js');
	  $cs->registerScriptFile($baseUrl.'/js/plugins/jquery.flot.min.js');
	  $cs->registerScriptFile($baseUrl.'/js/plugins/jquery.flot.pie.min.js');
	  $cs->registerScriptFile($baseUrl.'/js/charts.js');
	  $cs->registerScriptFile($baseUrl.'/js/plugins/jquery.knob.js');
	  $cs->registerScriptFile($baseUrl.'/js/plugins/jquery.masonry.min.js');
	  $cs->registerScriptFile($baseUrl.'/js/styleswitcher.js');
	?>
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl;?>/css/style.css" />
  </head>

<body id="layout_login">

<section id="navigation-main">   
</section><!-- /#navigation-main -->
    
<section class="main-body">
    <div class="container-fluid">
		<div class="page-header">
			<div class="row-fluid">
				<div class="span2">
				<figure>
				  <img src="<?php echo $baseUrl;?>/img/mirador_logo_bg_white.png" class="img-circle" alt="Baby Orang Utan hanging from a rope">
				</figure> 
				</div>
				<div class="span10 center">
					<label>Mirador Panamericano</label>
				</div>
			</div>
		</div>
    </div>
</section>

<!-- Require the footer -->
	<footer>
        <div class="subnav navbar navbar-fixed-bottom">
             <?php echo $content; ?>
        </div>     
	</footer>
  </body>
</html>