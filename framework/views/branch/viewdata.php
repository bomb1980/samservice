<?php
use yii\helpers\Url;

$this->title  = 'หน่วยงาน' . $data[0]["name"];

$themesurl = Yii::$app->params['prg_ctrl']['url']['themes'];
?>

<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-bs4/dataTables.bootstrap4.css">
<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-fixedheader-bs4/dataTables.fixedheader.bootstrap4.css">
<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-fixedcolumns-bs4/dataTables.fixedcolumns.bootstrap4.css">
<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-rowgroup-bs4/dataTables.rowgroup.bootstrap4.css">
<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-scroller-bs4/dataTables.scroller.bootstrap4.css">
<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-select-bs4/dataTables.select.bootstrap4.css">
<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-responsive-bs4/dataTables.responsive.bootstrap4.css">
<link rel="stylesheet" href="<?php echo $themesurl; ?>/global/vendor/datatables.net-buttons-bs4/dataTables.buttons.bootstrap4.css">
<link rel="stylesheet" href="<?php echo $themesurl; ?>/assets/examples/css/tables/datatable.css">

<script type="text/javascript" src="<?php echo Url::base(true); ?>/vendor/tab/js/modernizr.custom.js"></script>
<script type="text/javascript" src="<?php echo Url::base(true); ?>/vendor/dotdotdot/dotdotdot.js"></script>
<style>
  .ui-widget {
    font-family: Prompt-Regular !important;
    font-size: 1em;
  }

  .page {
    background: white;
  }

  .page-content-table .table>tbody>tr>td {
    cursor: default;
  }

  ul#yiiPager>li>a {}

  .panel-line.panel-info .panel-heading {
    color: #4A7800;
    background: 0 0;
    border-top-color: #4A7800;
  }

  .info-wrap {
    color: #76838f;
    text-align: left;
  }

  .panel-line.panel-info .panel-title {
    color: #4A7800;
    font-size: 30px;
  }

  .image-wrap img {
    height: 200px;
    width: 300px;
    object-fit: cover;
  }

  * {
    transition: all .1s linear 0;
  }

  body {
    font-family: "Lucida Sans Unicode";
  }

  .post {
    position: relative;
    margin: 1.2em;
    padding: 30px 20px;
    border-radius: 0px;
    width: auto;
    border: 0px solid #e8e8e8;
    margin-bottom: 20px;
    text-align: center;
  }

  .tabs-style-bar nav {
    background: rgba(40, 44, 42, 0.05);
  }

  .tabs-style-bar nav ul {
    border: 4px solid transparent;
  }

  .tabs-style-bar nav ul li a {
    margin: 0 2px;
    background-color: #f7f7f7;
    color: #74777b;
    transition: background-color 0.2s, color 0.2s;
    border-radius: 20px;
  }

  .tabs-style-bar nav ul li a:hover,
  .tabs-style-bar nav ul li a:focus {
    color: #4A7800;
  }

  .tabs-style-bar nav ul li a span {
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 500;
    font-size: 0.6em;
  }

  .tabs-style-bar nav ul li.tab-current a {
    background: #005c9e;
    color: #fff;
    border-radius: 20px;
  }

  .tabs-style-bar nav ul li.tab-current h4 {
    color: #fff;
  }

  .tabs nav {
    text-align: center;
  }

  .tabs nav ul {
    position: relative;
    display: flex;
    margin: 0 auto;
    padding: 0;
    max-width: 1200px;
    list-style: none;
    flex-flow: row wrap;
    justify-content: center;
  }

  .tabs nav ul li {
    position: relative;
    z-index: 1;
    display: block;
    margin: 0;
    text-align: center;
    width: 200px;
    radius: 100px;
  }

  .tabs nav a {
    position: relative;
    display: block;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    line-height: 2.5;
  }

  .tabs nav a span {
    vertical-align: middle;
    font-size: 0.75em;
  }

  .tabs nav li.tab-current a {
    color: white;
  }

  .tabs nav a:focus {
    outline: none;
  }

  .content-wrap {
    position: relative;
  }

  .content-wrap section {
    display: none;
    margin: 0 auto;
    padding: 1em;
    max-width: 1200px;
    text-align: center;
  }

  .content-wrap section.content-current {
    display: block;
  }

  .content-wrap section p {
    margin: 0;
    padding: 0.75em 0;
    color: rgba(40, 44, 42, 0.05);
    font-weight: 900;
    font-size: 4em;
    line-height: 1;
  }

  .no-js .content-wrap section {
    display: block;
    padding-bottom: 2em;
    border-bottom: 1px solid rgba(255, 255, 255, 0.6);
  }

  .tabs-style-bar nav ul {
    border: 0px solid transparent;
  }

  .tabs-style-bar nav {
    background: #FFF;
  }

  .app-media .media-list.is-grid .media-item {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 0.286rem;
    border: 1px solid #dcf7b0ad;
    background-color: #dcf7b03b;
    position: relative;
    cursor: pointer;
  }

  .content-wrap section {
    display: none;
    margin: 0 auto;
    padding: 1em;
    max-width: 1200px;
    text-align: left;
  }

  .title {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    height: 4.5em;
    overflow: hidden;
    white-space: normal !important;
  }

  .next {
    color: #4A7800;
    font-weight: bold;
    font-size: 14px;
  }

  .next:hover {
    color: #2F4C00;
    font-weight: bold;
    font-size: 14px;
  }

  <?php /*
	#productTable1_processing {}
	.is-list > .blocks > .animation-fade > .media-item > .info-wrap > .title{
		max-width: 88%;
	}
*/
  ?>.is-list>.blocks>.animation-fade>.media-item>.info-wrap {
    width: 87%;
  }

  .is-list>.blocks>li>.media-item>.info-wrap {
    width: 87%;
  }

  /* show hide */
  .is-grid>.blocks>.animation-scale-up>.media-item>.info-wrap>.title>.metas {
    display: none;
  }

  .is-grid>.blocks>li>.media-item>.info-wrap>.title>.metas {
    display: none;
  }

  .is-list>.blocks>.animation-fade>.media-item>.info-wrap>.title>.metas {
    display: block;
  }

  /**/
  .is-list>.blocks>.animation-scale-up>.media-item>.info-wrap>.metas-grid {
    display: none;
  }

  .is-list>.blocks>li>.media-item>.info-wrap>.metas-grid {
    display: none;
  }

  .is-grid>.blocks>.animation-fade>.media-item>.info-wrap>.metas-grid {
    display: block;
  }

  /* */

  .is-list>.blocks>.animation-fade>.media-item>.image-wrap {
    height: auto;
    margin-right: 0px;
    width: 70px;
  }

  .is-list>.blocks>li>.media-item>.image-wrap {
    height: auto;
    margin-right: 0px;
    width: 70px;
  }

  .is-grid>.blocks>.animation-scale-up>.media-item>.image-wrap {
    height: auto;
  }

  .is-grid>.blocks>li>.media-item>.image-wrap {
    height: auto;
  }

  .is-grid>.blocks>.animation-scale-up>.media-item>.info-wrap>.row>.mr-auto.pl-15>a {
    display: none;
  }

  .is-grid>.blocks>li>.media-item>.info-wrap>.row>.mr-auto.pl-15>a {
    display: none;
  }

  .is-list>.blocks>.animation-fade>.media-item>.info-wrap>.row>.mr-auto.pl-15>a {
    display: inline;
  }


  #section-linemove-2>.is-list>.blocks>.animation-fade>.media-item>.image-wrap {
    text-align: left;
  }

  #section-linemove-2>.is-grid>.blocks>.animation-scale-up>.media-item>.image-wrap {
    text-align: center;
  }

  #section-linemove-1>.is-list>.blocks>.animation-fade>.media-item>.image-wrap>img,
  #section-linemove-2>.is-list>.blocks>.animation-fade>.media-item>.image-wrap>img {
    width: 64px;
    height: 64px;
    margin: 0;
    position: absolute;
    top: 50%;
    -ms-transform: translateY(-50%);
    transform: translateY(-50%);
  }

  #section-linemove-1>.is-list>.blocks>li>.media-item>.image-wrap>img,
  #section-linemove-2>.is-list>.blocks>li>.media-item>.image-wrap>img {
    width: 64px;
    height: 64px;
    margin: 0;
    position: absolute;
    top: 50%;
    -ms-transform: translateY(-50%);
    transform: translateY(-50%);
  }

  #section-linemove-2>.is-grid>.blocks>li>.media-item>.image-wrap>img {
    width: auto;
    height: auto;
  }

  .app-media .media-list.is-list .media-item {
    padding: 5px 5px;
  }

  .page-content-actions {
    padding: 0 30px 5px;
  }

  #accordion p {
    margin: 0 !important;
    display: inline !important;
    all: revert;
  }

  .collapse p,
  h1,
  h2,
  h3,
  h4,
  h5,
  h6 {
    margin: 0;
    display: inline;
  }

  .accordion-menu>a {
    display: block;
    position: relative;
  }

  .accordion-menu>a:after {
    content: "\f078";
    /* fa-chevron-down */
    font-family: 'Font Awesome';
    position: absolute;
    right: 0;
  }

  .accordion-menu>a[aria-expanded="true"]:after {
    content: "\f077";
    /* fa-chevron-up */
  }

  .after {
    content: "\f077";
    /* fa-chevron-up */
  }
</style>

<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net/jquery.dataTables.js"></script>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-bs4/dataTables.bootstrap4.js"></script>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-fixedheader/dataTables.fixedHeader.js"></script>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-fixedcolumns/dataTables.fixedColumns.js"></script>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-rowgroup/dataTables.rowGroup.js"></script>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-scroller/dataTables.scroller.js"></script>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-responsive/dataTables.responsive.js"></script>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-responsive-bs4/responsive.bootstrap4.js"></script>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-buttons/dataTables.buttons.js"></script>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-buttons/buttons.html5.js"></script>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-buttons/buttons.flash.js"></script>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-buttons/buttons.print.js"></script>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-buttons/buttons.colVis.js"></script>
<script src="<?php echo $themesurl; ?>/global/vendor/datatables.net-buttons-bs4/buttons.bootstrap4.js"></script>
<script src="<?php echo Url::base(true); ?>/vendor/jquery-timeago/jquery.timeago.js"></script>
<script src="<?php echo Url::base(true); ?>/vendor/jquery-timeago/jquery.timeago.th.js"></script>


<!-- Include Froala Editor -->
<script src="<?php echo Url::base(true); ?>/vendor/jquery-timeago/jquery.timeago.js"></script>
<script src="<?php echo Url::base(true); ?>/vendor/jquery-timeago/jquery.timeago.th.js"></script>

<!-- Page -->
<div class="page">
  <?php
  //$data = lkup_content::getData($id);
  //$content_category_id = $data[0]["content_category_id"]; 

  $items = (array) $data[0]; //var_dump($data);exit;
  $datassobranch_code = $items["ssobranch_code"]; //echo $isAddmin;exit;

  $btnVisible = false;
  if (($datassobranch_code == $ssobranch_code) && $user_role == 2) { //ถ้าหน่วยงานตรง และมีสิทธิ์เป็น 2
    $btnVisible = true;
  }

  if ($user_role == 1) {  //แอดมินสูงสุดของส่วนงาน
    $btnVisible = true;
  }

  if ($superadmin) { //แอดมินสูงสุดของระบบ
    $btnVisible = true;
  }

 
  if (Yii::$app->request->referrer) {
    $redirect = Yii::$app->request->referrer;
  } else {
    $redirect = Yii::$app->urlManager->createUrl('');
  }

  $fromadmin = false;
  if (strpos($redirect, 'admin') !== false) {
    $fromadmin = true;
  }

  use app\components\CustomWebUser;

  $cwebuser = new CustomWebUser();


  ?>
  <div class="page-header">
    <h1 class="page-title"><?php echo stripslashes($data[0]["branch_name"]);  ?></h1>
    <div class="page-header-actions">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo Yii::$app->urlManager->createAbsoluteUrl(""); ?>">หน้าแรก</a></li>
        <?php
        if ($fromadmin) {
        ?>
          <li class="breadcrumb-item"><a href="<?php echo Yii::$app->urlManager->createAbsoluteUrl("/admin/branch") . '/'; ?>">หน่วยงาน</a></li>
        <?php
        } else {
        ?>
          <li class="breadcrumb-item"><a href="<?php echo Yii::$app->urlManager->createAbsoluteUrl("/branch") . '/'; ?>">หน่วยงาน</a></li>
        <?php
        }
        ?>
        <li class="breadcrumb-item atcitve">รายละเอียด</li>
      </ol>
    </div>
  </div>

  <div class="page-content container-fluid">

    <!-- Panel Basic -->
    <div class="page-main">

      <div class="row row pl-20">

        <div class="col-md-12 col-lg-12">
          <div class="p-20" style="border-radius: 10px; border-color: #eee; border-style: solid; border-width: 1px; box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, .5);">
            <?php

            $datassobranch_code = $data[0]["ssobranch_code"];

            if (count($data) > 0) {
            ?>

              <div style="margin: 0;">
                <div style="display: inline-block ;width:100%">
                  <div class="col-11" style="float:left;padding-left:0px;">
                    <div style="color: #666;font-size:0.8em;">แก้ไขล่าสุด <span style='font-style: italic;'><?php echo \app\components\CommonFnc::DateThai($data[0]["branch_update_date"]);  ?></span> โดย <span style='font-style: italic;'><?php echo $cwebuser->getMemberInfo("displayname", $data[0]["branch_update_by"]); ?></span> </div>
                  </div>
                  <?php
                  if ($btnVisible) {
                  ?>
                    <div class="mr-auto" style="float:right;">
                      <a href='<?php echo Yii::$app->urlManager->createAbsoluteUrl("branch/editdata") . "/" . $data[0]["branch_id"]; ?>' class='' style='margin-left: 5px;text-decoration: none;font-size: 20px;' title='แก้ไข'> <i class='icon fa-edit' aria-hidden='true'></i> </a>
                    </div>
                  <?php
                  }

                  if ($isAddmin) {
                    $ssobranch_code = $cwebuser->getInfo("ssobranch_code");
                    if ($datassobranch_code == $ssobranch_code) {
                    }
                    /*
                  ?>
                    <div class="mr-auto" style="float:right;">
                      <a href='<?php echo Yii::$app->urlManager->createAbsoluteUrl("branch/editdata") . "/" . $data[0]["branch_id"]; ?>' class='' style='margin-left: 5px;text-decoration: none;font-size: 20px;' title='แก้ไข'> <i class='icon fa-edit' aria-hidden='true'></i> </a>
                      <input type="checkbox" class="switch" data-color="#17b3a3" id="input1" name="input1" data-id="<?php echo $data[0]["branch_id"]; ?>" data-status="<?php echo $data[0]["branch_status"]; ?>" data-branchcode="<?php echo $data[0]['branch_code']; ?>" checked="" style="display: none;" data-switchery="true">
                    </div>
                  <?php */
                  }
                  ?>

                </div>


              </div>
              <?php
              if ($data[0]["cover"] != NULL) {
              ?>
                <div class="carousel-item active">
                  <img src="<?php echo  Yii::$app->params['prg_ctrl']['url']['coverbranch'] . "/" . $data[0]['cover']; ?>" style="height:280px;margin:0 auto; display: block !important;" class="img-responsive center-block" title="">
                </div>
              <?php

              }
              ?>
				<div class="list-group-item" style="padding: .75rem 0rem;">
					<?php echo stripslashes($data[0]["description"]);  ?> 
					<?php

          $user_id = Yii::$app->user->getId();

					$app_id = Yii::$app->params['prg_ctrl']['app_permission']['app_id']['admin'];			
          //$rows = lkup_user::getUserPermission(null, $app_id, $ssobranch_code); 

          $sql = "SELECT * FROM mas_user_permission INNER JOIN mas_user ON (mas_user_permission.user_id = mas_user.id) WHERE app_id=:app_id AND mas_user_permission.ssobranch_code=:ssobranch_code AND user_role=2 AND mas_user_permission.status=1";
          $command = Yii::$app->db->createCommand($sql);
          $command->bindValue(":app_id", $app_id);
          $command->bindValue(":ssobranch_code", $datassobranch_code); 
          $rows = $command->queryAll();
      
					?>

					<div class="d-flex align-items-end flex-column">  
            <div >          
              <?php 
              if(count($rows)>0){
                echo'<div class="text-left pb-10" >';
                echo '<h5 class="img-thumbnail badge-outline badge-info">ผู้ดูแลข้อมูลหน่วยงาน :</h5>';
                echo '</div>';
              }
              $i=0;
              $usercount = count($rows);
              foreach ($rows as $users) {
                if($i < 2){
                  if($usercount > 2){
                    echo '<span onclick="sync_data();" style="cursor: pointer;" >' . $users['displayname'] . '</span>, ';
                  }else {
                    if ($i == 1) echo '<span >' . $users['displayname'] . '</span>'; else echo '<span >' . $users['displayname'] . ', </span>';
                  }
                }else{
                  echo '<span onclick="sync_data();" style="cursor:pointer ;font-weight: bolder;font-size: 30px;line-height: 1px;" >...</span>';
                  break 1;
                }             
                $i++; 
              }
              ?>
            </div>
          
          </div>

          <div class="modal fade modal-slide-from-bottom show" id="Announce"  aria-hidden="true" aria-labelledby="Announce" role="dialog" tabindex="-1" data-show="false" data-backdrop="static" data-keyboard="false" >
            <div class="modal-dialog modal-simple modal-center" >
            <div class="modal-content">
              <div class="modal-header" style="justify-content: center; padding: 5px;">
                <h3 class="modal-title ml-auto mr-auto" >ผู้ดูแลข้อมูลหน่วยงาน</h3>
              
              <button type="button" class="close" aria-hidden="true" data-dismiss="modal" style="margin: 0;padding-top: 5px;padding-right: 5px;">
                <i class="icon fa-close" aria-hidden="true"></i>
              </button>

              </div>
              <div class="modal-body" style="min-height: calc(80vh - 240px);">

              <div class="example table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>ชื่อเจ้าหน้าที่</th>

                        </tr>
                      </thead>
                      <tbody>
                      <?php
                      $i=1;
                      foreach ($rows as $users) {
                        echo "<tr>";
                        echo "<td>{$i}</td>";
                        echo "<td>" . $users['displayname'] ."</td>";
                        echo "</tr>";
                        $i++;
                      }
                      ?>

                      </tbody>
                    </table>
                  </div>

              </div>

            </div>
            </div>
          </div>


				</div>

            <?php

            }

            $sql = "SELECT * FROM trn_collection WHERE obj_id=:obj_id order by ordno ASC, id ASC ";
            $rows = Yii::$app->db->createCommand($sql)->bindValue('obj_id', $id)->queryAll();

            ?>

          </div>

          <div class="tabs tabs-style-bar pt-20">
            <nav>
              <ul>
                <li><a href="#section-linemove-1" class="icon icon-home"><span>
                      <h4>ข่าวประชาสัมพันธ์</h4>
                    </span></a></li>
                <li><a href="#section-linemove-2" class="icon icon-box"><span>
                      <h4>หนังสือเวียน</h4>
                    </span></a></li>
                <?php
                if (count($rows) == 0) {
                  if ($isAddmin) {
                    if ( ($datassobranch_code == $ssobranch_code) || $superadmin ) {
                      ?>
                      <a onclick="window.location.href='<?php echo Yii::$app->urlManager->createAbsoluteUrl("/branch/addcollection") . "/" . $id; ?>'" class="icon icon-box pl-10" style="cursor:pointer"><span>
                          <h4><i class="icon md-collection-plus" aria-hidden="true"></i>เพิ่มเมนู</h4>
                        </span></a>
                    <?php
                    }
                  }

                } else {
                  $sql = "SELECT * FROM trn_collection_settings WHERE obj_id=:obj_id AND name='menuname' ";
                  $conn = Yii::$app->db;
                  $command = $conn->createCommand($sql);
                  $command->bindValue(":obj_id", $id);
                  $settings = $command->queryAll();
                  $menuname = "เมนู";
                  if(count($settings)!=0){
                    $menuname = $settings[0]['value'];
                  }
                ?>
                  <li><a href="#section-linemove-3" class="icon" id="tabsection-linemove-3"><span>
                        <h4 title="<?php echo $menuname;?>"><?php echo $menuname;?></h4>
                      </span></a></li>
                <?php
                }
                ?>

              </ul>
            </nav>
            <div class="content-wrap">

              <div class="col-lg-auto" id="secsearh">

                <div class="form-inline">
                  <h4 class="example-title">ค้นหา</h4>
                </div>

                <form class="form-inline" method="post" name="frmSearch" id="frmSearch">
                  <div class="form-group form-material">
                    <input type="text" class="form-control" id="txtSearch" name="txtSearch" placeholder="คำค้น" autocomplete="off" maxlength="100">
                  </div>

                  <div class="form-group form-material">
                    <input type="text" class="form-control" id="starts" name="starts" placeholder="วันที่เริ่มต้น" autocomplete="off">
                  </div>

                  <div class="form-group form-material">
                    <input type="text" class="form-control" id="ends" name="ends" placeholder="วันที่สิ้นสุด" autocomplete="off">
                  </div>

                  <div class="form-group form-material ">
                    <?php

                    $dep = \app\models\lkup_data::getDepartment();

                    ?>
                    <select class="form-control selectpicker show-tick d-none" id="selDepartment" name="selDepartment[]" title="เลือกหน่วยงาน..." data-selected-text-format="count > 2" data-live-search="true" required="">
                      <?php //<option value="0">เลือกทั้งหมด</option> 
                      ?>
                      <?php

                      foreach ($dep as $dataitem) {
                        //echo '<option value="' . $dataitem["ssobranch_code"] . '" > ' . $dataitem["name"] . ' </option>';
                      }
                      echo '<option value="' . $data[0]["branch_code"] . '" > ' . $data[0]["branch_name"] . ' </option>';

                      ?>
                    </select>
                  </div>

                  <div class="form-group form-material">

                    <input type="hidden" value="<?php echo $data[0]["branch_code"] ?>" name="dep" id="dep">
                    <input type="hidden" id="<?= Yii::$app->request->csrfParam ?>" name="<?= Yii::$app->request->csrfParam ?>" value="<?php echo Yii::$app->request->getCsrfToken(); ?>">
                    <button type="submit" class="btn btn-primary waves-effect waves-classic" name="btnSearch" id="btnSearch" title="ค้นหา"><i class="fa fa-search" aria-hidden="true"></i></button>
                  </div>
                </form>


              </div>

              <div class="page-content-actions">
                <div class="float-right">
                  <div class="btn-group media-arrangement btn-group-flat" role="group">
                    <button class="btn btn-default waves-effect waves-classic active" id="arrangement-grid" type="button"><i class="icon md-view-module" aria-hidden="true"></i></button>
                    <button class="btn btn-default waves-effect waves-classic" id="arrangement-list" type="button"><i class="icon md-view-list" aria-hidden="true"></i></button>
                  </div>
                </div>

              </div>

              <section id="section-linemove-1">
                <div class="media-list is-grid pb-50" data-plugin="animateList" data-child="li">

                  <ul id="new-list" class="blocks blocks-100 blocks-xxl-5 blocks-xl-4 blocks-lg-4 blocks-md-3 blocks-sm-3" data-plugin="animateList" data-child=">li">
                    <!--
								<li>
								<div class="media-item">
									<div class="image-wrap">
									<img class="image rounded" src="">
									</div>
									<div class="info-wrap">
					
									<div class="title">หัวข้อ</div>
									<div class="next">อ่านต่อ >></div>
									</div>
								</div>
								</li>
								-->
                  </ul>

                </div>

                <table id="productTable1" class="table table-striped table-hover table-bordered tableUpdated" style="display: none;">
                  <thead>
                    <tr>
                      <th scope="col">ปกหนังสือ</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
                <?php //echo $data[0]["ssobranch_code"]

                if ($datassobranch_code == $ssobranch_code) {
                ?>
                  <div class="site-action" data-plugin="actionBtn">
                    <button type="button" onclick="window.location.href='<?php echo Yii::$app->urlManager->createAbsoluteUrl("/content/adddata") . "/?from=branch&id=" . $id; ?>'" class="site-action-toggle btn-raised btn btn-success btn-floating waves-effect waves-classic">
                      <i class="front-icon md-plus animation-scale-up" aria-hidden="true"></i>
                      <i class="back-icon md-delete animation-scale-up" aria-hidden="true"></i>
                    </button>
                  </div>
                <?php
                }
                ?>

              </section>

              <section id="section-linemove-2">
                <div class="media-list is-list pb-50" data-plugin="animateList" data-child="li">
                  <ul id="new-list2" class="blocks blocks-100 blocks-xxl-5 blocks-xl-4 blocks-lg-4 blocks-md-3 blocks-sm-3" data-plugin="animateList" data-child=">li">


                  </ul>
                </div>
                <table id="productTable2" class="table table-striped table-hover table-bordered tableUpdated" style="display: none;">
                  <thead>
                    <tr>
                      <th scope="col">ปกหนังสือ</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>

                <?php //echo $data[0]["ssobranch_code"]
                if ($datassobranch_code == $ssobranch_code) {
                ?>
                  <div class="site-action" data-plugin="actionBtn">
                    <button type="button" onclick="window.location.href='<?php echo Yii::$app->urlManager->createAbsoluteUrl("/content/adddata") . "/?from=branch&id=" . $id; ?>'" class="site-action-toggle btn-raised btn btn-success btn-floating waves-effect waves-classic">
                      <i class="front-icon md-plus animation-scale-up" aria-hidden="true"></i>
                      <i class="back-icon md-delete animation-scale-up" aria-hidden="true"></i>
                    </button>
                  </div>
                <?php
                }
                ?>

              </section>
              <?php
              if (count($rows) != 0) {
              ?>
                <section id="section-linemove-3">

                  <?php
                  if ($btnVisible) {
                  ?>
                    <div style="margin: 0;">
                      <div style="display: inline-block ;width:100%">

                        <div class="mr-auto" style="float:right;">
                          <a href='<?php echo Yii::$app->urlManager->createAbsoluteUrl("branch/addcollection") . "/" . $id; ?>' class='' style='margin-left: 5px;text-decoration: none;font-size: 20px;' title='แก้ไข'> <i class='icon fa-edit' aria-hidden='true'></i> </a>
                          <?php /*
                      <a href='javascript:void(0)' onClick='ajax_deldata();' class='' style='margin-left: 5px;text-decoration: none;font-size: 20px;' title='ลบ'> <i class='icon fa-remove' aria-hidden='true'></i> </a>
                      */ ?>
                        </div>
                      </div>
                    </div>
                  <?php
                  }
                  ?>


                  <div id="accordion">
                    <div class="card">
                      <?php
                      //var_dump($data);
                      $html = "";

                      if (count($rows) > 0) {

                        $found = 1;
                        foreach ($rows as $dataitem) {
                          $trncreate_by = $dataitem['create_by'];
                          $trnssobranch_code = $dataitem['ssobranch_code'];;
                          switch ($dataitem["read_permission_status"]) {
                            case 1:
                              # เฉพาะฉัน
                              $pericon = '<i class="icon md-lock-outline" aria-hidden="true"></i>';
                              $pertitle = "เฉพาะฉัน";
                              if ($trncreate_by != $user_id) {
                                continue 2;
                              }
                              break;
                            case 2:
                              # เฉพาะกลุ่มงาน...
                              $pericon = '<i class="icon md-accounts-outline" aria-hidden="true"></i>';
                              $pertitle = "เฉพาะกลุ่มงาน";
                              if ($trnssobranch_code != $ssobranch_code) {
                                continue 2;
                              }
                              break;
                            case 3:
                              # เห็นทั้งหมด...
                              $pericon = '<i class="icon fa-globe" aria-hidden="true"></i>';
                              $pertitle = "ทั้งหมด";
                              break;
                            default:
                              # code...
                              break;
                          }
                          $file_object_id = $dataitem['id'];
                          $sql = "
                SELECT *
                FROM
                  `trn_collection_list`              
                WHERE trn_collection_list.status = 1 AND trn_collection_list.obj_id=:obj_id 
                ORDER BY trn_collection_list.ordno ASC
                ";
                          $conn = Yii::$app->db;
                          $command = $conn->createCommand($sql);
                          $command->bindValue(":obj_id", $file_object_id);
                          $rowslist = $command->queryAll();


                          if (count($rowslist) == 0) {
                            continue;
                          }

                      ?>
                          <div class="card-header" style="border: 1px solid #e4eaec;">
                            <h5 class="accordion-menu">
                              <a role="button" style="color: #535a60 !important;" data-toggle="collapse" href="#collapse-<?php echo $file_object_id; ?>" aria-expanded="<?php echo $found == 1 ? "true" : "false" ?>" aria-controls="collapse-<?php echo $file_object_id; ?>" class="collapsed">
                                <?php echo str_replace('\\', '', $dataitem['subject']); ?>
                              </a>
                            </h5>
                          </div>
                          <div id="collapse-<?php echo $file_object_id; ?>" class="collapse<?php echo $found == 1 ? " show" : "" ?>" data-parent="#accordion" style="">
                        <?php
                          echo "<ul style='margin-top:5px;'>";
                          foreach ($rowslist as $datalist) {
                            echo "<li>";
                            echo $datalist['subject'];


                            $sql = "SELECT * FROM trn_file WHERE obj_id=:obj_id AND obj_type=9 ";
                            $command = $conn->createCommand($sql);
                            $command->bindValue(":obj_id", $datalist['id']);
                            $rowsfile = $command->queryAll();
                            $numfile = 1;
                            $countfile = count($rowsfile);
                            foreach ($rowsfile as $datafile) {
                              echo '<div class="col-auto pr-0" style="display: inline;">';
                              if (!is_null($datafile['file_name']) || !empty($datafile['file_name'])) {
                                $data_href = Yii::$app->urlManager->createAbsoluteUrl("content/getfile/") . "/" . $datafile['id'];
                              } else {
                                $data_href = urldecode($datafile['file_web_url']);
                              }
                              if ($countfile > 1) {
                                echo '<a href="' . $data_href . '" target="_blank">ดาวน์โหลด' . $numfile . '</a>';
                              } else {
                                echo '<a href="' . $data_href . '" target="_blank">ดาวน์โหลด</a>';
                              }

                              echo '</div>';
                              $numfile++;
                            }
                            echo "</li>";
                          }
                          echo "</ul>";
                          echo "</div>";
                          $found++;
                        }
                      }


                        ?>
                          </div>
                    </div>
                </section>
              <?php
              }
              ?>
            </div>
          </div>


        </div>

      </div>


    </div>



  </div>
</div>



<script type="text/javascript" src="<?php echo Url::base(true); ?>/vendor/tab/js/cbpFWTabs.js"></script>
<script type="text/javascript">
  (function() {

    [].slice.call(document.querySelectorAll('.tabs')).forEach(function(el) {
      new CBPFWTabs(el);
      el.onclick = function() {
        items = [].slice.call(el.querySelectorAll('.tab-current'));
        itemid = items[0].children[0].id;
        if (itemid == "tabsection-linemove-3") {
          $('.page-content-actions').hide();
          $('#secsearh').hide();
        } else {
          $('.page-content-actions').show();
          $('#secsearh').show();
        }

      };


    });
  })();

  function sync_data(){   

    $('#Announce').modal('show');

  }

</script>

<script type="text/javascript">
  jQuery(document).ready(function($) {
    jQuery("time.timeago").timeago();

    if ($('.accordion-menu > a').attr('aria-expanded') == 'true') {
      $(".accordion-menu > a").after().toggleClass("\f077");
    }

    $("#arrangement-list").click(function() {

    });
    $("#arrangement-list").mouseup(function() {

    });

    //$('#selDepartment').selectpicker({iconBase: 'glyphicon', tickIcon: 'glyphicon-remove'});
    $('#selDepartment').selectpicker({
      iconBase: 'fa',
      tickIcon: 'fa-check'
    });
    $('#selDepartment').on('changed.bs.select', function(e, clickedIndex) {
      if (clickedIndex !== 0) {
        return;
      }

      if (this.value === '0') {
        return $(this).selectpicker('selectAll');
      }

      $(this).selectpicker('deselectAll');
    });

    jQuery("time.timeago").timeago();

    $("#yiiPager").find('>li >a').addClass("page-link");
    $("#yiiPager_").find('>li >a').addClass("page-link");
    $("div.summary").remove();
    $("#list-grid").removeClass("grid-view");
    $("#list-grid_").removeClass("grid-view");

    jQuery.datetimepicker.setLocale('th');
    jQuery('#starts').datetimepicker({
      format: 'd/m/Y',
      lang: 'th',
      step: 10,
      yearStart: 2015,
      timepicker: false,
    });

    jQuery('#ends').datetimepicker({
      format: 'd/m/Y',
      lang: 'th',
      step: 10,
      yearStart: 2015,
      onChangeDateTime: function(dp, $input) {

      },
      timepicker: false,
    });

    //var formDate = moment().format("D/MM/YYYY 00:00");
    //var formDate = moment().subtract(10, 'years').format('DD/MM/YYYY 00:00');

    $('#starts').val('01/01/2020');
    formDate = moment().format("D/MM/YYYY");
    $('#ends').val(formDate);

    $('#selDepartment option').attr("selected", "selected");
    $('#selDepartment').selectpicker('refresh');

    $('.table.is-indent thead').remove();


  });

  <?php /*
  function ajax_deldata() {
    $("#btnadd").prop("disabled", true);
    var result = confirm("ต้องการลบเนื้อหา ?");
    if (!result) {
      $("#btnadd").removeAttr('disabled');
      return;
    }

    $.ajax({
      type: "POST",
      url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl("content/Delete_content"); ?>",
      data: {
        '<?= Yii::$app->request->csrfParam ?>': '<?= Yii::$app->request->getCsrfToken() ?>',
        'content_id': <?php echo $id; ?>
      },
      dataType: "json",
      success: function(data) {
        if (data.msg == 'success') {
          alert('ลบข้อมูลเรียบร้อย');
          window.location.href = '<?php echo Yii::$app->urlManager->createAbsoluteUrl("content/listdata/5"); ?>';
        } else {
          alert(data.msg);
          $("#btnadd").removeAttr('disabled');
        }
      }
    });

  }
*/
  ?>


    (function() {
      // Form Add Event
      jQuery('#frmSearch').formValidation({
        framework: "bootstrap4",
        button: {
          selector: '#btnSearch',
          disabled: 'disabled'
        },
        icon: null,
        fields: {
          /*
	  txtSearch: {
		validators: {
		  notEmpty: {
			message: 'กรุณาป้อนคำค้น'
		  },
		  stringLength: {
			  min: 3,
			  max: 200,
			  message: 'คำค้นต้องไม่น้อยกว่า 3 ตัวอักษร'
		  },
		}
	  },
	  */
          starts: {
            validators: {
              notEmpty: {
                message: 'กรุณาเลือกวันที่เริ่มต้น'
              },
              regexp: {
                //regexp: /^([1-9]|([012][0-9])|(3[01]))\/([0]{0,1}[1-9]|1[012])\/\d\d\d\d\s([0-1]?[0-9]|2?[0-3]):([0-5]\d)$/,
                regexp: /^((0[1-9]|[12][0-9]|3[01])(\/)(0[13578]|1[02]))|((0[1-9]|[12][0-9])(\/)(02))|((0[1-9]|[12][0-9]|3[0])(\/)(0[469]|11))(\/)\d{4}$/,
                message: 'กรุณาป้อนวันที่ในรูปแบบที่ถูกต้อง dd/mm/yyyy'
              }
            }
          },
          ends: {
            validators: {
              notEmpty: {
                message: 'กรุณาเลือกวันที่สิ้นสุด'
              },
              regexp: {
                //regexp: /^([1-9]|([012][0-9])|(3[01]))\/([0]{0,1}[1-9]|1[012])\/\d\d\d\d\s([0-1]?[0-9]|2?[0-3]):([0-5]\d)$/,
                regexp: /^((0[1-9]|[12][0-9]|3[01])(\/)(0[13578]|1[02]))|((0[1-9]|[12][0-9])(\/)(02))|((0[1-9]|[12][0-9]|3[0])(\/)(0[469]|11))(\/)\d{4}$/,
                message: 'กรุณาป้อนวันที่ในรูปแบบที่ถูกต้อง dd/mm/yyyy'
              }
            }
          },
          selDepartment: {
            validators: {
              notEmpty: {
                message: 'กรุณาป้อนคำค้น'
              }
            }
          },

        },
        err: {
          clazz: 'invalid-feedback'
        },
        control: {
          // The CSS class for valid control
          valid: 'is-valid',
          // The CSS class for invalid control
          invalid: 'is-invalid'
        },
        row: {
          invalid: 'has-danger'
        },
        onError: function(e) {
          e.preventDefault();
        },
        onSuccess: function(e) {
          //e.preventDefault();

        }

      }).on('change', '[name="ends"]', function() {
        var isEmpty = $(this).val() == '';
        $('#frmSearch').formValidation('enableFieldValidators', 'ends', !isEmpty)
        // Revalidate the field if not blank
        if ($(this).val().length == 1) {
          $('#frmSearch').formValidation('validateField', 'ends')
        }
      }).on('change', '[name="starts"]', function() {
        var isEmpty = $(this).val() == '';
        $('#frmSearch').formValidation('enableFieldValidators', 'starts', !isEmpty)
        // Revalidate the field if not blank
        if ($(this).val().length == 1) {
          $('#frmSearch').formValidation('validateField', 'starts')
        }
      });
      // End Form Add Event
    })();

  $('#frmSearch').on('success.form.fv', function(e) {
    checkFields(4);
    checkFields2(28);
    /* Prevent form submission */
    e.preventDefault();

  });
  $('#selDepartment').on('refreshed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
    checkFields(4);
    checkFields2(28);
  });


  $(document).ready(function() {

    var elems = Array.prototype.slice.call(document.querySelectorAll('.switch'));
    elems.forEach(function(el) {
      var init = new Switchery(el);
      el.onchange = function() {
        var status = 0;
        if ($(this).is(':checked')) {
          status = 1;
        } else {
          status = 0;
        }

        $.ajax({
          url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl("branch/updatebranchstatus"); ?>",
          method: "POST",
          data: {
            ssobranch_code: $(this).data("branchcode"),
            status: status,
            YII_CSRF_TOKEN: '<?php echo Yii::$app->request->csrfToken; ?>',
          },
          success: function(data) {}
        });
      };
    });


  });


  var dataTable;

  function checkFields(group) {
    <?php
    $brnarr = array();
    $brnarr[0] = $data[0]['ssobranch_code'];
    ?>
    keyword = $('#txtSearch').val();
    dstarts = $('#starts').val();
    dends = $('#ends').val();

    $(".employee-grid-error").html("");
    if (typeof dataTable != 'undefined') {
      dataTable.destroy();
    }
    dataTable = $('#productTable1').DataTable({
      responsive: true,
      "language": {
        "url": "<?php echo $themesurl; ?>/global/vendor/datatables.net/Thai.json"
      },
      "processing": true,
      "serverSide": true,
      "ajax": {
        url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl("content/listadvancesearch"); ?>",
        "data": {
          "keyword": keyword,
          '<?= Yii::$app->request->csrfParam ?>': '<?= Yii::$app->request->getCsrfToken() ?>',
          'dstarts': dstarts + ' 00:00',
          'dends': dends + ' 23:59',
          'dep': $('#dep').val(),
          'group': group,
        },
        type: "post", // method  , by default get
        dataType: "json",
        error: function() { // error handling
          $(".employee-grid-error").html("");
          $("#productTable1").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
          $("#productTable1_processing").css("display", "none");
        }
      },
      searching: false,
      ordering: false,
      "autoWidth": false,
      "bLengthChange": false,
      "iDisplayLength": 5,
      "initComplete": function(settings, json) {
        // show new container for data
        //$('#new-list').insertBefore('#productTable1');
        //$('#new-list').show();		
      },
      "rowCallback": function(row, data) {
        // on each row callback
        var li = $(document.createElement('li'));

        for (var i = 0; i < data.length; i++) {
          //li.append('<p>' + data[i] + '</p>');
          li.append(data[i]);
        }
        li.appendTo('#new-list');
        $("#new-list").css("min-height", '');
        $('#arrangement-grid').focus();
      },
      "preDrawCallback": function(settings) {
        // clear list before draw
        $("#new-list").css("min-height", $('#new-list').height());
        $('#new-list').empty();
      },
      drawCallback: function() {
        $('img.lazy').lazy({
          effect: "fadeIn",
          effectTime: 100,
          threshold: 0
        });
      }

    });
    $('#productTable1_paginate').css("padding-bottom", "10px");
  }

  var dataTable2;

  function checkFields2(group) {

    keyword = $('#txtSearch').val();
    dstarts = $('#starts').val();
    dends = $('#ends').val();

    $(".employee-grid-error").html("");
    if (typeof dataTable2 != 'undefined') {
      dataTable2.destroy();
    }
    dataTable2 = $('#productTable2').DataTable({
      responsive: true,
      "language": {
        "url": "<?php echo $themesurl; ?>/global/vendor/datatables.net/Thai.json"
      },
      "processing": true,
      "serverSide": true,
      "ajax": {
        url: "<?php echo Yii::$app->urlManager->createAbsoluteUrl("content/listadvancesearch"); ?>",
        "data": {
          "keyword": keyword,
          '<?= Yii::$app->request->csrfParam ?>': '<?= Yii::$app->request->getCsrfToken() ?>',
          'dstarts': dstarts + ' 00:00',
          'dends': dends + ' 23:59',
          'dep': $('#dep').val(),
          'group': group,
        },
        type: "post", // method  , by default get
        dataType: "json",
        error: function() { // error handling
          $(".employee-grid-error").html("");
          $("#productTable2").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
          $("#productTable2_processing").css("display", "none");
        }
      },
      searching: false,
      ordering: false,
      "autoWidth": false,
      "bLengthChange": false,
      "iDisplayLength": 5,
      "initComplete": function(settings, json) {
        // show new container for data
        //$('#new-list2').insertBefore('#productTable2');
        //$('#new-list2').show();
      },
      "rowCallback": function(row, data) {
        // on each row callback
        var li = $(document.createElement('li'));

        for (var i = 0; i < data.length; i++) {
          //li.append('<p>' + data[i] + '</p>');
          li.append(data[i]);
        }
        li.appendTo('#new-list2');
        $("#new-list2").css("min-height", '');
        $('#arrangement-grid').focus();
      },
      "preDrawCallback": function(settings) {
        // clear list before draw
        $("#new-list").css("min-height", $('#new-list').height());
        $('#new-list2').empty();
      },
      drawCallback: function() {
        $('img.lazy').lazy({
          effect: "fadeIn",
          effectTime: 100,
          threshold: 0
        });
      }

    });
    $('#productTable2_paginate').css("padding-bottom", "10px");
  }
</script>
<!-- End Page -->