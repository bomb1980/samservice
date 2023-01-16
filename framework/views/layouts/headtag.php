<script src="<?php echo $themesurl; ?>/global/vendor/jquery/jquery.min.js"></script>
  <!--<link rel="apple-touch-icon" href="<?php echo Yii::$app->params['prg_ctrl']['appleicon']; ?>"> -->
  <link rel="apple-touch-icon" href="<?php echo Yii::$app->request->baseUrl; ?>/images/common/apple-touch-icon-iphone-60x60.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?php echo Yii::$app->request->baseUrl; ?>/images/common/apple-touch-icon-ipad-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo Yii::$app->request->baseUrl; ?>/images/common/apple-touch-icon-iphone-retina-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo Yii::$app->request->baseUrl; ?>/images/common/apple-touch-icon-ipad-retina-152x152.png">
			
    <link rel="shortcut icon" href="<?php echo Yii::$app->params['prg_ctrl']['favicon']; ?>">
    
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

    <link rel="stylesheet" href="<?php echo Yii::$app->request->baseUrl; ?>/vendor/fontawesome5/css/all.css"> 
    <link rel="stylesheet" href="<?php echo Yii::$app->request->baseUrl; ?>/vendor/fontawesome5/css/v4-shims.css"> 
	<!-- Custom -->
    <link rel="stylesheet" href="<?php echo Yii::$app->request->baseUrl; ?>/css/custom.css">   
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