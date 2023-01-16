<?php
use  yii\web\Session;
$session = Yii::$app->session;

$pageTitle  = 'เข้าสู่ระบบ' . Yii::$app->params['prg_ctrl']['pagetitle'];
//$folder = Yii::$app->params['prg_ctrl']['url']['thumbnail'];
$themesurl = Yii::$app->params['prg_ctrl']['url']['themes'];
$encryption_key = Yii::$app->params['auth']['crypter']['encryption_key'];
$method = Yii::$app->params['auth']['crypter']['method'];

$UserName = "";
$Password = "";
$checked = "";

if (isset($_COOKIE['UserName']) && isset($_COOKIE['Password'])) {
    $UserName = $_COOKIE['UserName'];

    $crypter = new \app\components\Crypter($encryption_key, $method);
    $Password = $crypter->decrypt($_COOKIE['Password']);
    $checked =  $_COOKIE['checked'];
}

?>
<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="bootstrap material admin template">
    <meta name="author" content="SSO">
    <?php $this->registerCsrfMetaTags() ?>

    <title><?php echo $pageTitle  ?></title>

    <link rel="shortcut icon" href="<?php echo Yii::$app->params['prg_ctrl']['favicon']; ?>">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/css/bootstrap-extend.min.css" />
    <link rel="stylesheet" href="<?php echo $themesurl; ?>/assets/css/site.min.css" />

    <!-- Plugins -->
    <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/animsition/animsition.css" />
    <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/asscrollable/asScrollable.css" />
    <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/switchery/switchery.css" />
    <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/intro-js/introjs.css" />
    <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/slidepanel/slidePanel.css" />
    <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/flag-icon-css/flag-icon.css" />
    <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/waves/waves.css" />
    <link rel="stylesheet" href="<?php echo $themesurl; ?>/assets/examples/css/pages/login-v3.css" />

    <!-- Fonts -->
    <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/fonts/web-icons/web-icons.min.css" />
    <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/fonts/material-design/material-design.min.css" />
    <link rel="stylesheet" href="<?php echo $themesurl; ?>/global/fonts/brand-icons/brand-icons.min.css" />
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic' />

    <!--[if lt IE 9]>
    <script src="<?php echo $themesurl; ?>/global/vendor/html5shiv/html5shiv.min.js" ></script>
    <![endif]-->

    <!--[if lt IE 10]>
    <script src="<?php echo $themesurl; ?>/global/vendor/media-match/media.match.min.js" ></script>
    <script src="<?php echo $themesurl; ?>/global/vendor/respond/respond.min.js" ></script>
    <![endif]-->

    <script src="<?php echo $themesurl; ?>/global/vendor/jquery/jquery.js"></script>
    <script type="text/javascript" src="<?php echo Yii::$app->request->baseUrl; ?>/assets/js/validate.js"></script>

    <!-- Scripts -->
    <script src="<?php echo $themesurl; ?>/global/vendor/breakpoints/breakpoints.js"></script>
    <script>
        Breakpoints();
    </script>


    <script type="text/javascript">
        function checkFields() {
            missinginfo = "";
            if (document.loginform.username.value == "") {
                missinginfo += "\n -  กรุณากรอก Username ";
            }
            if (document.loginform.password.value == "") {
                missinginfo += "\n -  กรุณากรอก Password";
            }
            if (missinginfo != "") {
                missinginfo = "ท่านกรอกข้อมูลไม่ถูกต้องในช่องต่อไปนี้\n" +
                    //"ท่านกรอกข้อมูลไม่ถูกต้องในช่องต่อไปนี้ :\n" +
                    missinginfo + "\n_____________________________" +
                    "\nกรุณากลับไปกรอกอีกครั้ง ";
                alert(missinginfo);
                return false;
            }
        }

        function ajax_auth() {

            missinginfo = "";
            if (document.loginform.username.value == "") {
                missinginfo += "\n -  กรุณากรอก Username ";
            }
            if (document.loginform.password.value == "") {
                missinginfo += "\n -  กรุณากรอก Password";
            }
            if (missinginfo != "") {
                missinginfo = "ท่านกรอกข้อมูลไม่ถูกต้องในช่องต่อไปนี้\n" +
                    //"ท่านกรอกข้อมูลไม่ถูกต้องในช่องต่อไปนี้ :\n" +
                    missinginfo + "\n_____________________________" +
                    "\nกรุณากลับไปกรอกอีกครั้ง ";
                alert(missinginfo);
                return;
            }

            var data = {
                'YII_CSRF_TOKEN': '<?php echo Yii::$app->request->csrfToken; ?>',
                '<?=Yii::$app->request->csrfParam?>': '<?=Yii::$app->request->getCsrfToken()?>',
                'username': $('#username').val(),
                'password': $('#password').val(),
                'chk_remember': $('#chk_remember').is(":checked"),
                'LoginForm[password]': $('#password').val(),
                'LoginForm[username]': $('#username').val(),
                //'LoginForm[rememberMe]': +$('#chk_remember').is(":checked"),
            };

            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::$app->request->baseUrl; ?>/login/auth',
                data: data,
                dataType: 'json',
                success: success_auth,
                error: error_auth,
            });
        }
        var success_auth = function(data) {

            if (data.status == 'success') {
                location.href = '<?php echo Yii::$app->request->baseUrl; ?>';
            } else if (data.status == 'error') {
                alert(data.msg);
            } else {
                alert('Invalid Exception.');
            }
        }
        var error_auth = function(data) {
            alert('Invalid Exception.');
        }
        jQuery(document).ready(function($) {
            $("#password").keyup(function(e) {
                if (e.keyCode == 13) {
                    if (!$.trim($('#username').val()) == '') {
                        ajax_auth();
                    }
                }
            });

        });
    </script>
    <style>
        body {
            background: transparent;
        }
    </style>
</head>

<body class="animsition page-login-v3 layout-full">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <?php if ( !$session->has('sub') ) {   ?>
        <!-- Page -->
        <div class="page vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out">
            <div class="page-content vertical-align-middle">
                <div class="panel">
                    <div class="panel-body">
                        <div class="brand">
                            <img class="brand-img" src="<?php echo Yii::$app->request->baseUrl; ?>/images/common/logo.png" alt="ประกันสังคม" style="height: 78px;">
                            <img class="brand-img" src="<?php echo Yii::$app->request->baseUrl; ?>/images/common/hrms-3.png" alt="ไลน์" style="height: 78px;">
                            <h2 class="brand-text font-size-18"><?php echo Yii::$app->params['prg_ctrl']['name'];?> เข้าใช้งานระบบ</h2>
                        </div>
                        <form role="form" method="post" name="loginform" id="loginform" autocomplete="off">
                            <div class="form-group form-material floating" data-plugin="formMaterial">
                                <input class="form-control" name="username" type="text" value="<?php echo $UserName; ?>" autofocus id="username" required="" maxlength="20"  />
                                <label class="floating-label">Username</label>
                            </div>
                            <div class="form-group form-material floating" data-plugin="formMaterial">
                                <input class="form-control" name="password" type="password" value="<?php echo $Password ?>" id="password" required="" maxlength="20"  />
                                <label class="floating-label">Password</label>
                            </div>
                            <div class="form-group clearfix">
                                <div class="checkbox-custom checkbox-inline checkbox-primary checkbox-lg float-left">
                                    <input type="checkbox" id="chk_remember" name="chk_remember" <?php echo $checked; ?>>
                                    <label for="inputCheckbox">Remember me</label>
                                </div>

                            </div>
                            <input type="hidden" name="Redirect" value="<%=Redirect%>" />
                            <input type="hidden" name="process" value="Login" />
                            <button type="button" class="btn btn-primary btn-block btn-lg mt-40" onClick="ajax_auth();">Login</button>
                        </form>

                    </div>
                </div>

                <?php /* <footer class="page-copyright page-copyright-inverse">
          <p>WEBSITE BY Creation Studio</p>
          <p>© 2018. All RIGHT RESERVED.</p>
          <div class="social">
            <a class="btn btn-icon btn-pure" href="javascript:void(0)">
            <i class="icon bd-twitter" aria-hidden="true"></i>
          </a>
            <a class="btn btn-icon btn-pure" href="javascript:void(0)">
            <i class="icon bd-facebook" aria-hidden="true"></i>
          </a>
            <a class="btn btn-icon btn-pure" href="javascript:void(0)">
            <i class="icon bd-google-plus" aria-hidden="true"></i>
          </a>
          </div>
        </footer> */ ?>
            </div>
        </div>
        <!-- End Page -->
    <?php   }  ?>


    <!-- Core  -->
    <script src="<?php echo $themesurl; ?>/global/vendor/babel-external-helpers/babel-external-helpers.js"></script>

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
    <script src="<?php echo $themesurl; ?>/global/vendor/jquery-placeholder/jquery.placeholder.js"></script>

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
    <script>
        Config.set('assets', '<?php echo $themesurl; ?>/assets');
    </script>

    <!-- Page -->
    <script src="<?php echo $themesurl; ?>/assets/js/Site.js"></script>
    <script src="<?php echo $themesurl; ?>/global/js/Plugin/asscrollable.js"></script>
    <script src="<?php echo $themesurl; ?>/global/js/Plugin/slidepanel.js"></script>
    <script src="<?php echo $themesurl; ?>/global/js/Plugin/switchery.js"></script>
    <script src="<?php echo $themesurl; ?>/global/js/Plugin/jquery-placeholder.js"></script>
    <script src="<?php echo $themesurl; ?>/global/js/Plugin/animate-list.js"></script>
    <script src="<?php echo $themesurl; ?>/global/js/Plugin/material.js"></script>

    <script>
        (function(document, window, $) {
            'use strict';

            var Site = window.Site;
            $(document).ready(function() {
                Site.run();
            });
        })(document, window, jQuery);
    </script>

</body>

</html>