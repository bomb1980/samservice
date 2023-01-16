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
    <script src="<?php echo $themesurl; ?>/global/vendor/jquery/jquery.min.js"></script>
    
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
        <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/bootstrap-select/bootstrap-select.css">
        <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/select2/select2.css">
        <link rel="stylesheet" href="<?php echo $themesurl; ?>/assets/examples/css/dashboard/analytics.css">
        <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/bootstrap4-datetimepicker/jquery.datetimepicker.css">
        <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/formvalidation/formValidation.css">
        <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/dropify/dropify.css">
		<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/jquery-ui/jquery-ui.css">
		<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/alertify/alertify.css">

		<link rel="stylesheet" href="<?php echo $themesurl; ?>/assets/examples/css/apps/media.css">
    
    <!-- Fonts -->
	<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/fonts/glyphicons/glyphicons.css">
	<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/fonts/font-awesome/font-awesome.css">
    <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/fonts/web-icons/web-icons.min.css">
    <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/fonts/brand-icons/brand-icons.min.css">
    <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/fonts/material-design/material-design.min.css">
    <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/fonts/7-stroke/7-stroke.css">
	<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/fonts/ionicons/ionicons.css">
	<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/fonts/themify/themify.css">
	<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/fonts/octicons/octicons.css">
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
	
	<!-- Custom -->
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/custom.css">   
	<style>

		/* make it single-line */
		.overflow-tip {
		  white-space: nowrap;
		  overflow-x: hidden;
		  /* truncate by container's size */
		  /* add three dots */
		  text-overflow: ellipsis;
		  /* on touch or hover */
		}
    
		.overflow-tip:active, .overflow-tip:hover {
		  /* show hidden part outside of parent */
		  overflow-x: visible;
		  display:inline;
      z-index:2147483647;
      position:relative;
      
      text-overflow: clip;
      white-space: normal;
      word-break: break-word;

		  /* and with inner span */
		}
		.overflow-tip:active span, .overflow-tip:hover span {
			display:inline;
      z-index:2147483647;

		  /* allow to overlap siblings */
		  position: relative; 
		  /* make readable design */

      /*
		  border: 1px solid gray;
		  padding: 3px;
		  margin-left: -4px;
      */
      
      text-overflow: clip;
      white-space: normal;
      word-break: break-word;
      display:block;
      margin-left:32px;
      /*line-height: 38px;*/

		}
.site-navbar {
    background-color: transparent !important;
}
	</style>
    
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
  <body class="animsition app-media page-aside-left">
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
    

    <script src="<?php echo $themesurl; ?>/global/vendor/formvalidation/formValidation.js"></script>
    <script src="<?php echo $themesurl; ?>/global/vendor/formvalidation/framework/bootstrap4.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/vendor/jquery.lazy/jquery.lazy.min.js"></script>

	<?php echo $content; ?>

    <script src="<?php echo $themesurl; ?>/global/vendor/popper-js/umd/popper.min.js"></script>
    <script src="<?php echo $themesurl; ?>/global/vendor/bootstrap/bootstrap.js"></script>
    <script src="<?php echo $themesurl; ?>/global/vendor/animsition/animsition.js"></script>
    <script src="<?php echo $themesurl; ?>/global/vendor/mousewheel/jquery.mousewheel.js"></script>
    <script src="<?php echo $themesurl; ?>/global/vendor/asscrollbar/jquery-asScrollbar.js"></script>
    <script src="<?php echo $themesurl; ?>/global/vendor/asscrollable/jquery-asScrollable.js"></script>
    <script src="<?php echo $themesurl; ?>/global/vendor/ashoverscroll/jquery-asHoverScroll.js"></script>

    <!-- Plugins -->
    <script src="<?php echo $themesurl; ?>/global/vendor/switchery/switchery.js"></script>
    <script src="<?php echo $themesurl; ?>/global/vendor/intro-js/intro.js"></script>
    <script src="<?php echo $themesurl; ?>/global/vendor/screenfull/screenfull.js"></script>
    <script src="<?php echo $themesurl; ?>/global/vendor/slidepanel/jquery-slidePanel.js"></script>
        <script src="<?php echo $themesurl; ?>/global/vendor/chartist/chartist.js"></script>
        <script src="<?php echo $themesurl; ?>/global/vendor/raphael/raphael.min.js"></script>
        <script src="<?php echo $themesurl; ?>/global/vendor/morris/morris.min.js"></script>
        <script src="<?php echo $themesurl; ?>/global/vendor/matchheight/jquery.matchHeight-min.js"></script>
        <script src="<?php echo $themesurl; ?>/global/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.js"></script>
        <script src="<?php echo $themesurl; ?>/global/vendor/bootstrap-select/bootstrap-select.js"></script>
        <script src="<?php echo $themesurl; ?>/global/vendor/select2/select2.js"></script>
        <script src="<?php echo $themesurl; ?>/global/vendor/select2/i18n/th.js"></script>
        <script src="<?php echo $themesurl; ?>/global/vendor/bootstrap4-datetimepicker/jquery.datetimepicker.full.js"></script>
        <script src="<?php echo $themesurl; ?>/global/vendor/moment/moment.min.js"></script>
        <script src="<?php echo $themesurl; ?>/global/vendor/jquery-ui/jquery-ui.min.js"></script>
        <script src="<?php echo $themesurl; ?>/global/vendor/dropify/dropify.min.js"></script>
		    <script src="<?php echo $themesurl; ?>/global/vendor/alertify/alertify.js"></script>        
    
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
    
        <script src="<?php echo $themesurl; ?>/global/js/Plugin/matchheight.js"></script> 
        
        <script src="<?php echo $themesurl; ?>/global/js/Plugin/ascolorpicker.js"></script>

        <script src="<?php echo $themesurl; ?>/global/js/Plugin/sticky-header.js"></script>
        <script src="<?php echo $themesurl; ?>/global/js/Plugin/asscrollable.js"></script>
        <script src="<?php echo $themesurl; ?>/global/js/Plugin/animate-list.js"></script>
        <script src="<?php echo $themesurl; ?>/global/js/Plugin/action-btn.js"></script>
        <script src="<?php echo $themesurl; ?>/global/js/Plugin/asselectable.js"></script>
        <script src="<?php echo $themesurl; ?>/global/js/Plugin/selectable.js"></script>
        <script src="<?php echo $themesurl; ?>/assets/js/BaseApp.js"></script>
        <script src="<?php echo $themesurl; ?>/assets/js/App/Media.js"></script>

	
        <script src="<?php echo $themesurl; ?>/assets/examples/js/apps/media.js"></script>

	<!-- Custom -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/custom.js"></script>

	</body>
</html>