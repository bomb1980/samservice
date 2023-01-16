
<?php //$this->beginContent('//layouts/web_skeleton'); ?>
<?php //require_once("header.php"); ?>
<?php //require_once("menu.php"); ?>
<?php //echo $content; ?>
<?php //require_once("footer.php"); ?>
<?php //$this->endContent(); ?>

<?php
$themesurl = Yii::$app->params['prg_ctrl']['url']['themes'];
/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

$cwebuser = new \app\components\CustomWebUser();

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="SSO Inhouse Communications">
    <meta name="author" content="SSO">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php require_once("headtag.php"); ?>
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
    <script src="<?php echo Yii::$app->request->baseUrl; ?>/vendor/jquery.lazy/jquery.lazy.min.js"></script>

<?php $this->beginBody() ?>

<?php require_once("header.php"); ?>
<?php require_once("menu.php"); ?>
<?php echo $content ?>
<?php require_once("footer.php"); ?>
<?php require_once("endpage.php"); ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

