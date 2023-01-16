<?php
	error_reporting(E_ALL ^ E_NOTICE);
	$themesurl = Yii::app()->params['prg_ctrl']['url']['themes'];
?>

<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="bootstrap admin template">
    <meta name="author" content="">
    
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
					
    <!--<link rel="apple-touch-icon" href="<?php echo Yii::app()->params['prg_ctrl']['appleicon']; ?>"> -->
	<link rel="apple-touch-icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/common/apple-touch-icon-iphone-60x60.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?php echo Yii::app()->request->baseUrl; ?>/images/common/apple-touch-icon-ipad-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo Yii::app()->request->baseUrl; ?>/images/common/apple-touch-icon-iphone-retina-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo Yii::app()->request->baseUrl; ?>/images/common/apple-touch-icon-ipad-retina-152x152.png">

    <link rel="shortcut icon" href="<?php echo Yii::app()->params['prg_ctrl']['favicon']; ?>">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/css/bootstrap-extend.min.css">
    <link rel="stylesheet" href="<?php echo $themesurl; ?>/assets/css/site.min.css">
    
    <!-- Plugins -->
    <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/animsition/animsition.css">
    <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/asscrollable/asScrollable.css">
    <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/switchery/switchery.css">
    <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/intro-js/introjs.css">
    <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/slidepanel/slidePanel.css">
    <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/flag-icon-css/flag-icon.css">
        <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/morris/morris.css">
        <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/chartist/chartist.css">
        <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css">
        <link rel="stylesheet" href="<?php echo $themesurl; ?>/assets/examples/css/dashboard/analytics.css">
		<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/jquery-ui/jquery-ui.css">
    
    <!-- Plugins -->
    <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/animsition/animsition.css">
    <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/asscrollable/asScrollable.css">
    <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/switchery/switchery.css">
    <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/intro-js/introjs.css">
    <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/slidepanel/slidePanel.css">
    <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/flag-icon-css/flag-icon.css">
    <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/waves/waves.css">
        <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/fullcalendar/fullcalendar.css">
        <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/bootstrap-datepicker/bootstrap-datepicker.css">
        <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/bootstrap4-datetimepicker/jquery.datetimepicker.css">
        <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/bootstrap-touchspin/bootstrap-touchspin.css">
        <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/jquery-selective/jquery-selective.css">
        <link rel="stylesheet" href="<?php echo $themesurl; ?>/assets/examples/css/apps/calendar.css">
        <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/formvalidation/formValidation.css">
    

    <!-- Fonts -->
	<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/fonts/glyphicons/glyphicons.css">
	<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/fonts/font-awesome/font-awesome.css">
    <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/fonts/web-icons/web-icons.min.css">
    <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/fonts/brand-icons/brand-icons.min.css">
    <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/fonts/material-design/material-design.min.css">
    <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/fonts/7-stroke/7-stroke.css">
	<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/fonts/ionicons/ionicons.css">
	<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/fonts/themify/themify.css">
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
	
	<!-- Custom -->
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/custom.css">     
    
    <!--[if lt IE 9]>
    <script src="<?php echo $themesurl; ?>/global/vendor/html5shiv/html5shiv.min.js"></script>
    <![endif]-->
    
    <!--[if lt IE 10]>
    <script src="<?php echo $themesurl; ?>/global/vendor/media-match/media.match.min.js"></script>
    <script src="<?php echo $themesurl; ?>/global/vendor/respond/respond.min.js"></script>
    <![endif]-->
    
    <!-- Scripts -->
    <script src="<?php echo $themesurl; ?>/global/vendor/breakpoints/breakpoints.js"></script>
    <script>
      Breakpoints();
    </script>
  </head>
  <body class="animsition">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <style>
      body {
        background: transparent;
      }
    </style>

    <!-- Core  -->
    <script src="<?php echo $themesurl; ?>/global/vendor/babel-external-helpers/babel-external-helpers.js"></script>
    <script src="<?php echo $themesurl; ?>/global/vendor/jquery/jquery.min.js"></script>
  
    <script src="<?php echo $themesurl; ?>/global/vendor/formvalidation/formValidation.js"></script>
    <script src="<?php echo $themesurl; ?>/global/vendor/formvalidation/framework/bootstrap4.min.js"></script>

    <?php echo $content; ?>

    <!-- Core  -->

    <script src="<?php echo $themesurl; ?>/global/vendor/popper-js/umd/popper.min.js"></script>
    <script src="<?php echo $themesurl; ?>/global/vendor/bootstrap/bootstrap.js"></script>
    <script src="<?php echo $themesurl; ?>/global/vendor/animsition/animsition.js"></script>
    <script src="<?php echo $themesurl; ?>/global/vendor/mousewheel/jquery.mousewheel.js"></script>
    <script src="<?php echo $themesurl; ?>/global/vendor/asscrollbar/jquery-asScrollbar.js"></script>
    <script src="<?php echo $themesurl; ?>/global/vendor/asscrollable/jquery-asScrollable.js"></script>
    <script src="<?php echo $themesurl; ?>/global/vendor/ashoverscroll/jquery-asHoverScroll.js"></script>
    <script src="<?php echo $themesurl; ?>/global/vendor/waves/waves.js"></script>
    
    <!-- Plugins -->
    <script src="<?php echo $themesurl; ?>/global/vendor/switchery/switchery.js"></script>
    <script src="<?php echo $themesurl; ?>/global/vendor/intro-js/intro.js"></script>
    <script src="<?php echo $themesurl; ?>/global/vendor/screenfull/screenfull.js"></script>
    <script src="<?php echo $themesurl; ?>/global/vendor/slidepanel/jquery-slidePanel.js"></script>
        <script src="<?php echo $themesurl; ?>/global/vendor/jquery-ui/jquery-ui.min.js"></script>
        <script src="<?php echo $themesurl; ?>/global/vendor/moment/moment.min.js"></script>
        <!-- <script src="<?php echo $themesurl; ?>/global/vendor/fullcalendar/fullcalendar.js"></script> -->
        <script src="<?php echo $themesurl; ?>/global/vendor/jquery-selective/jquery-selective.min.js"></script>
        <script src="<?php echo $themesurl; ?>/global/vendor/bootstrap-datepicker/bootstrap-datepicker.js"></script>
        <script src="<?php echo $themesurl; ?>/global/vendor/bootstrap4-datetimepicker/jquery.datetimepicker.full.js"></script>
        <script src="<?php echo $themesurl; ?>/global/vendor/bootstrap-touchspin/bootstrap-touchspin.min.js"></script>
        <script src="<?php echo $themesurl; ?>/global/vendor/bootbox/bootbox.js"></script>

        <script src="<?php echo $themesurl; ?>/global/vendor/chartist/chartist.js"></script>
        <script src="<?php echo $themesurl; ?>/global/vendor/raphael/raphael.min.js"></script>
        <script src="<?php echo $themesurl; ?>/global/vendor/morris/morris.min.js"></script>
        <script src="<?php echo $themesurl; ?>/global/vendor/matchheight/jquery.matchHeight-min.js"></script>
        <script src="<?php echo $themesurl; ?>/global/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.js"></script>
    
    
    <!-- Scripts -->
    <script src="<?php echo $themesurl; ?>/global/js/Component.js"></script>
    <script src="<?php echo $themesurl; ?>/global/js/Plugin.js"></script>
    <script src="<?php echo $themesurl; ?>/global/js/Base.js"></script>
    <script src="<?php echo $themesurl; ?>/global/js/Config.js"></script>
    
    <script src="<?php echo $themesurl; ?>/assets/js/Section/Menubar.js"></script>
    <script src="<?php echo $themesurl; ?>/assets/js/Section/GridMenu.js"></script>
    <script src="<?php echo $themesurl; ?>/assets/js/Section/Sidebar.js"></script>
    <script src="<?php echo $themesurl; ?>/assets/js/Section/PageAside.js"></script>
    <script src="<?php echo $themesurl; ?>/assets/js/Plugin/menu.js"></script>
    
    <script src="<?php echo $themesurl; ?>/global/js/config/colors.js"></script>
    <script src="<?php echo $themesurl; ?>/assets/js/config/tour.js"></script>
    <script>Config.set('assets', '<?php echo $themesurl; ?>/assets');</script>
    
    <!-- Page -->
    <script src="<?php echo $themesurl; ?>/assets/js/Site.js"></script>
    <script src="<?php echo $themesurl; ?>/global/js/Plugin/asscrollable.js"></script>
    <script src="<?php echo $themesurl; ?>/global/js/Plugin/slidepanel.js"></script>
    <script src="<?php echo $themesurl; ?>/global/js/Plugin/switchery.js"></script>
        <script src="<?php echo $themesurl; ?>/global/js/Plugin/bootstrap-touchspin.js"></script>
        <script src="<?php echo $themesurl; ?>/global/js/Plugin/bootstrap-datepicker.js"></script>
        <script src="<?php echo $themesurl; ?>/global/js/Plugin/material.js"></script>
        <script src="<?php echo $themesurl; ?>/global/js/Plugin/action-btn.js"></script>
        <script src="<?php echo $themesurl; ?>/global/js/Plugin/editlist.js"></script>
        <script src="<?php echo $themesurl; ?>/global/js/Plugin/bootbox.js"></script>
        <script src="<?php echo $themesurl; ?>/assets/js/Site.js"></script>
        <script src="<?php echo $themesurl; ?>/assets/js/App/Calendar.js"></script>    

		


	</body>
</html>