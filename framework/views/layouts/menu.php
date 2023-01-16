<div class="site-menubar site-menubar-light">
  <div class="site-menubar-body">
    <div>
      <div>
        <ul class="site-menu" data-plugin="menu">
          <li class="site-menu-category"></li>
          <li class="site-menu-item">
            <a href="<?php echo Yii::$app->urlManager->createUrl('/dashboard'); ?>">
              <i class="site-menu-icon fas fa-home" aria-hidden="true"></i>
              <span class="site-menu-title">หน้าแรก</span>
            </a>
          </li>

          <?php
          //<li class="site-menu-category">APP</li>
          /*
                $portal = lkup_data::getPortal(); 
                $datalv1 = array();
                foreach($portal as $dataitem) {
                 if($dataitem['category_level'] == 1){
                   $datalv1[] = $dataitem;
                 }                      
                }

                $datalv2 = array();
                foreach($portal as $dataitem) {
                 if($dataitem['category_level'] == 2){
                   $datalv2[] = $dataitem;
                 }                      
                }

                $datalv3 = array();
                foreach($portal as $dataitem) {
                 if($dataitem['category_level'] == 3){
                   $datalv3[] = $dataitem;
                 }                      
                }

                foreach($datalv1 as $dataitemlv1) {
                       
                  if($dataitemlv1['hassub'] == 1 ){
                    ?>
                    <li class="site-menu-item has-sub">
                    <a href="javascript:void(0)">
                        <i class="site-menu-icon <?php echo $dataitemlv1['icon_code']; ?>" aria-hidden="true"></i>
                        <span class="site-menu-title"><?php echo $dataitemlv1['name']; ?></span>
                        <span class="site-menu-arrow"></span>
                    </a>

                    <?php 
                    foreach($datalv2 as $dataitemlv2) { 

                      if( $dataitemlv1['id'] === $dataitemlv2['parent_lv1_id'] ){
                        echo '<ul class="site-menu-sub">';  
                        if($dataitemlv2['hassub'] == 1 ){
                          ?>
                           <li class="site-menu-item has-sub">
                            <a href="javascript:void(0)">
                              <span class="site-menu-title"><?php echo $dataitemlv2['name']; ?></span>
                              <span class="site-menu-arrow"></span>
                            </a>
                            <ul class="site-menu-sub">
                              <?php
                              foreach($datalv3 as $dataitemlv3) { 
                                if( $dataitemlv2['id'] === $dataitemlv3['parent_lv2_id'] ){
                                  echo '<li class="site-menu-item"><a class="animsition-link" href="'.$dataitemlv3['url_link'].'"><div class="overflow-tip"><span class="site-menu-title">'.$dataitemlv3['name'].'</span></div></a></li>';
                                }
                              }
                              ?>
                            </ul>
                          </li>		
                          <?php
                        }else { 
                          echo '<li class="site-menu-item"><a class="animsition-link" href="' .$dataitemlv2['url_link']. '"><div  class="overflow-tip"><span class="site-menu-title">'.$dataitemlv2['name'].'</span></div></a></li>'; 
                        }  
                        echo '</ul>';
                        
                      }
                      
                    }
                    echo "</li>";
                  }else{
                    ?>
                    <li class="site-menu-item has-sub">
                    <a href="javascript:void(0)">
                        <i class="site-menu-icon <?php echo $dataitemlv1['icon_code']; ?>" aria-hidden="true"></i>
                        <span class="site-menu-title"><?php echo $dataitemlv1['name']; ?></span>
                    </a>
                    </li>
                    <?php 
                  }

                }
              */
          ?>
          <li class="site-menu-category">จัดการข้อมูล</li>
          <?php /*
              <li class="site-menu-item has-sub">
                <a href="javascript:void(0)">
                    <i class="site-menu-icon fa-bank" aria-hidden="true"></i>
                    <span class="site-menu-title">เกี่ยวกับองค์กร</span>
					          <span class="site-menu-arrow"></span>
                </a>
                <ul class="site-menu-sub">
                  <li class="site-menu-item"><a class="animsition-link" href="<?php echo Yii::app()->createUrl(''); ?>"><span class="site-menu-title">ผู้บริหารสำนักงานประกันสังคม</span></a></li>
                  <li class="site-menu-item"><a class="animsition-link" href="<?php echo Yii::app()->createUrl(''); ?>"><span class="site-menu-title">ทำเนียบผู้บริหารสำนักงานประกันสังคม</span></a></li>                  			  
                </ul>
              </li>

              <li class="site-menu-item has-sub">
                <a href="javascript:void(0)">
                    <i class="site-menu-icon fa-bullhorn" aria-hidden="true"></i>
                    <span class="site-menu-title">ข่าวประชาสัมพันธ์</span>
					          <span class="site-menu-arrow"></span>
                </a>
                <ul class="site-menu-sub">
                  <li class="site-menu-item"><a class="animsition-link" href="<?php echo Yii::app()->createUrl('/content/listdata/1'); ?>"><span class="site-menu-title">ข่าวประกาศ</span></a></li>
                  <li class="site-menu-item"><a class="animsition-link" href="<?php echo Yii::app()->createUrl(''); ?>"><span class="site-menu-title">ข่าวการเสียชีวิต บุคลากร / บิดา-มารดา บุคลากร</span></a></li>                  			  
					        <li class="site-menu-item has-sub">
						        <a href="javascript:void(0)">
							        <span class="site-menu-title">ข่าวสารบุคลากร</span>
							        <span class="site-menu-arrow"></span>
						        </a>
                    <ul class="site-menu-sub">
                      <li class="site-menu-item"><a class="animsition-link" href="<?php echo Yii::app()->createUrl(''); ?>"><span class="site-menu-title">เครื่องราชอิสริยาภรณ์</span></a></li>
                      <li class="site-menu-item"><a class="animsition-link" href="<?php echo Yii::app()->createUrl(''); ?>"><span class="site-menu-title">การทดลองปฏิบัติราชการ</span></a></li>                  			  
                      <li class="site-menu-item"><a class="animsition-link" href="<?php echo Yii::app()->createUrl(''); ?>"><span class="site-menu-title">การประเมินผลการปฏิบัติราชการ</span></a></li>                  			  
                      <li class="site-menu-item"><a class="animsition-link" href="<?php echo Yii::app()->createUrl(''); ?>"><span class="site-menu-title">การเลื่อนระดับ</span></a></li>                  			  
                      <li class="site-menu-item"><a class="animsition-link" href="<?php echo Yii::app()->createUrl(''); ?>"><span class="site-menu-title">วินัยและการรักษาวินัย</span></a></li>                  			  
                    </ul>
                  </li>				  
				        </ul>
              </li>
			  
              <li class="site-menu-item has-sub">
                <a href="<?php echo Yii::app()->createUrl(''); ?>">
                    <i class="site-menu-icon fa-calendar" aria-hidden="true"></i>
                    <span class="site-menu-title">กำหนดการนัดหมายผู้บริหาร</span>
                </a>
              </li>			  
			  
              <li class="site-menu-item has-sub">
                <a href="javascript:void(0)">
                    <i class="site-menu-icon fa-gavel" aria-hidden="true"></i>
                    <span class="site-menu-title">กฎหมาย ระเบียบ</span>
					          <span class="site-menu-arrow"></span>
                </a>
                <ul class="site-menu-sub">
                  <li class="site-menu-item"><a class="animsition-link" href="<?php echo Yii::app()->createUrl(''); ?>"><span class="site-menu-title">พระราชบัญญัติ</span></a></li>
                  <li class="site-menu-item"><a class="animsition-link" href="<?php echo Yii::app()->createUrl(''); ?>"><span class="site-menu-title">กฎกระทรวง บุคลากร / บิดา-มารดา บุคลากร</span></a></li>                  			  
                  <li class="site-menu-item"><a class="animsition-link" href="<?php echo Yii::app()->createUrl(''); ?>"><span class="site-menu-title">ประกาศ</span></a></li>                  			  
                  <li class="site-menu-item"><a class="animsition-link" href="<?php echo Yii::app()->createUrl(''); ?>"><span class="site-menu-title">ระเบียบ</span></a></li>
                  <li class="site-menu-item"><a class="animsition-link" href="<?php echo Yii::app()->createUrl(''); ?>"><span class="site-menu-title">แนวปฏิบัติ บุคลากร / บิดา-มารดา บุคลากร</span></a></li>                  			  
                  <li class="site-menu-item"><a class="animsition-link" href="<?php echo Yii::app()->createUrl(''); ?>"><span class="site-menu-title">พระราชกฤษฎีกา</span></a></li>                  			  
				        </ul>
              </li>

              <li class="site-menu-item has-sub">
                <a href="javascript:void(0)">
                    <i class="site-menu-icon fa-map-o" aria-hidden="true"></i>
                    <span class="site-menu-title">สื่อประชาสัมพันธ์</span>
					          <span class="site-menu-arrow"></span>
                </a>
                <ul class="site-menu-sub">
                  <li class="site-menu-item"><a class="animsition-link" href="<?php echo Yii::app()->createUrl(''); ?>"><span class="site-menu-title">แผ่นพับ</span></a></li>
                  <li class="site-menu-item"><a class="animsition-link" href="<?php echo Yii::app()->createUrl(''); ?>"><span class="site-menu-title">วารสาร บุคลากร / บิดา-มารดา บุคลากร</span></a></li>                  			  
                  <li class="site-menu-item"><a class="animsition-link" href="<?php echo Yii::app()->createUrl(''); ?>"><span class="site-menu-title">อินโฟกราฟิก</span></a></li>                  			  
                  <li class="site-menu-item"><a class="animsition-link" href="<?php echo Yii::app()->createUrl(''); ?>"><span class="site-menu-title">สถิติ</span></a></li>
				        </ul>
              </li>

              <li class="site-menu-item has-sub">
                <a href="javascript:void(0)">
                    <i class="site-menu-icon fa-newspaper-o" aria-hidden="true"></i>
                    <span class="site-menu-title">หนังสือเวียน</span>
					          <span class="site-menu-arrow"></span>
                </a>
                <ul class="site-menu-sub">
                  <li class="site-menu-item"><a class="animsition-link" href="<?php echo Yii::app()->createUrl('/content/listdata/3'); ?>"><span class="site-menu-title">สำนัก</span></a></li>
                  <li class="site-menu-item"><a class="animsition-link" href="<?php echo Yii::app()->createUrl(''); ?>"><span class="site-menu-title">กอง</span></a></li>                  			  
                  <li class="site-menu-item"><a class="animsition-link" href="<?php echo Yii::app()->createUrl(''); ?>"><span class="site-menu-title">กลุ่ม</span></a></li>                  			  
				        </ul>
              </li>

              <li class="site-menu-item has-sub">
                <a href="javascript:void(0)">
                    <i class="site-menu-icon fa-download" aria-hidden="true"></i>
                    <span class="site-menu-title">ดาวน์โหลด</span>
					          <span class="site-menu-arrow"></span>
                </a>
                <ul class="site-menu-sub">
                    <li class="site-menu-item"><a class="animsition-link" href="<?php echo Yii::app()->createUrl(''); ?>"><span class="site-menu-title">แบบฟอร์มต่างๆ</span></a></li>
                    <li class="site-menu-item"><a class="animsition-link" href="<?php echo Yii::app()->createUrl(''); ?>"><span class="site-menu-title">โปรแกรมต่างๆ</span></a></li>                  			  
                </ul>
              </li>

              <li class="site-menu-item has-sub">
                <a href="javascript:void(0)">
                    <i class="site-menu-icon fa-book" aria-hidden="true"></i>
                    <span class="site-menu-title">คลังความรู้</span>
					          <span class="site-menu-arrow"></span>
                </a>
                <ul class="site-menu-sub">
                  <li class="site-menu-item"><a class="animsition-link" href="<?php echo Yii::app()->createUrl(''); ?>"><span class="site-menu-title">คู่มือ</span></a></li>
                  <li class="site-menu-item"><a class="animsition-link" href="<?php echo Yii::app()->createUrl(''); ?>"><span class="site-menu-title">Presentation ระบบงานต่างๆ</span></a></li>                  			  
                  <li class="site-menu-item"><a class="animsition-link" href="<?php echo Yii::app()->createUrl(''); ?>"><span class="site-menu-title">เอกสารอบรม</span></a></li>
                </ul>
              </li>

              <li class="site-menu-item has-sub">
                <a href="<?php echo Yii::app()->createUrl(''); ?>">
                    <i class="site-menu-icon fa-male" aria-hidden="true"></i>
                    <span class="site-menu-title">นโยบายความเป็นส่วนตัว (Privacy Policy)</span>
                </a>
              </li>	
              */
          ?>
          <?php
          /*
                $user_id = Yii::app()->user->getInfo("id"); 
                $ssobranch_code = Yii::app()->user->getInfo("ssobranch_code");
                $app_id = Yii::app()->params['prg_ctrl']['app_permission']['app_id']['cms']; 

                $data = lkup_user::getUserPermission($user_id,$app_id);
                $user_role = $data[0]["user_role"];
                $masterdata = lkup_content::getCategoryByUser($user_role, $ssobranch_code) ; //var_dump($user_role);  
                */
          $model = new app\models\lkup_content;
          $masterdata = $model->getContent_category(); //var_dump($masterdata);

          //$masterdata = lkup_content::getContent_category(); //var_dump($masterdata);

          $datalv1 = array();
          foreach ($masterdata as $dataitem) {
            if ($dataitem['category_level'] == 1) {
              $datalv1[] = $dataitem;
            }
          }

          $datalv2 = array();
          foreach ($masterdata as $dataitem) {
            if ($dataitem['category_level'] == 2) {
              $datalv2[] = $dataitem;
            }
          }

          $datalv3 = array();
          foreach ($masterdata as $dataitem) {
            if ($dataitem['category_level'] == 3) {
              $datalv3[] = $dataitem;
            }
          }

          foreach ($datalv1 as $dataitemlv1) {

            if ($dataitemlv1['hassub'] == 1) {
          ?>
              <li class="site-menu-item has-sub">
                <a href="javascript:void(0)">
                  <i class="site-menu-icon <?php echo $dataitemlv1['icon_code']; ?>" aria-hidden="true"></i>
                  <span class="site-menu-title"><?php echo $dataitemlv1['name']; ?></span>
                  <span class="site-menu-arrow"></span>
                </a>

                <?php
                foreach ($datalv2 as $dataitemlv2) {

                  if ($dataitemlv1['id'] === $dataitemlv2['parent_lv1_id']) {
                    echo '<ul class="site-menu-sub">';
                    if ($dataitemlv2['hassub'] == 1) {
                ?>
              <li class="site-menu-item has-sub">
                <a href="javascript:void(0)">
                  <span class="site-menu-title"><?php echo $dataitemlv2['name']; ?></span>
                  <span class="site-menu-arrow"></span>
                </a>
                <ul class="site-menu-sub">
                  <?php
                      foreach ($datalv3 as $dataitemlv3) {
                        if ($dataitemlv2['id'] === $dataitemlv3['parent_lv2_id']) {
                          echo '<li class="site-menu-item"><a class="animsition-link" href="' . Yii::$app->urlManager->createUrl('/content/listdata') . '/' . $dataitemlv3['id'] . '"><div class="overflow-tip"><span class="site-menu-title">' . $dataitemlv3['name'] . '</span></div></a></li>';
                        }
                      }
                  ?>
                </ul>
              </li>
        <?php
                    } else {
                      echo '<li class="site-menu-item"><a class="animsition-link" href="' . Yii::$app->urlManager->createUrl('/content/listdata') . '/' . $dataitemlv2['id'] . '"><div class="overflow-tip"><span class="site-menu-title">' . $dataitemlv2['name'] . '</span></div></a></li>';
                    }
                    echo '</ul>';
                  }
                }
                echo "</li>";
              } else {
        ?>
        <li class="site-menu-item has-sub">
          <a href="javascript:void(0)">
            <i class="site-menu-icon <?php echo $dataitemlv1['icon_code']; ?>" aria-hidden="true"></i>
            <span class="site-menu-title"><?php echo $dataitemlv1['name']; ?></span>
          </a>
        </li>
    <?php
              }
            }

    ?>
    <?php
    $user_id = Yii::$app->user->getId();
    $ssobranch_code = $cwebuser->getInfo("ssobranch_code");

    $rows = \app\models\lkup_user::getUserPermission($user_id, 1, $ssobranch_code);
    $user_role = $rows[0]['user_role'];

    if (\app\models\lkup_data::chkPermission($user_role, 1)) {
    ?>

      <li class="site-menu-item">
        <a href="<?php echo Yii::$app->urlManager->createUrl('/empdata/syndata'); ?>">
          <i class="site-menu-icon icon fas fa-people-arrows" aria-hidden="true"></i>
          <span class="site-menu-title">ข้อมูลเจ้าหน้าที่</span>
        </a>
      </li>

    <?php
    }

    ?>

    <?php


    $rows = \app\models\lkup_user::getUserPermission($user_id, 5, $ssobranch_code);
    $user_role = $rows[0]['user_role'];

    if (\app\models\lkup_data::chkPermission($user_role, 5)) {
    ?>
      <li class="site-menu-category">ตั้งค่าข้อมูล</li>


      <li class="site-menu-item">
        <a href="<?php echo Yii::$app->urlManager->createUrl('admin/user_permission'); ?>">
		  <i class="site-menu-icon fas fa-user-cog" aria-hidden="true"></i>
          <span class="site-menu-title">สิทธิ์ผู้ใช้งาน</span>
        </a>
      </li>

      <li class="site-menu-item">
        <a href="<?php echo Yii::$app->urlManager->createUrl('admin/datamanagement'); ?>">
          <i class="site-menu-icon fas fa-database" aria-hidden="true"></i>
          <span class="site-menu-title">จัดการข้อมูล</span>
        </a>
      </li>

      <li class="site-menu-item">
        <a href="<?php echo Yii::$app->urlManager->createUrl('register'); ?>">
		  <i class="site-menu-icon fas fa-user-plus" aria-hidden="true"></i>
          <span class="site-menu-title">เพิ่มผู้ใช้งาน</span>
        </a>
      </li>


    <?php
    }


    ?>

        </ul>

      </div>
    </div>
  </div>

</div>


<?php /*
	<div class="site-gridmenu">
      <div>
        <div>
          <ul>
            <li>
              <a href="../apps/mailbox/mailbox.html">
                <i class="icon wb-envelope"></i>
                <span>Mailbox</span>
              </a>
            </li>
            <li>
              <a href="../apps/calendar/calendar.html">
                <i class="icon wb-calendar"></i>
                <span>Calendar</span>
              </a>
            </li>
            <li>
              <a href="../apps/contacts/contacts.html">
                <i class="icon wb-user"></i>
                <span>Contacts</span>
              </a>
            </li>
            <li>
              <a href="../apps/media/overview.html">
                <i class="icon wb-camera"></i>
                <span>Media</span>
              </a>
            </li>
            <li>
              <a href="../apps/documents/categories.html">
                <i class="icon wb-order"></i>
                <span>Documents</span>
              </a>
            </li>
            <li>
              <a href="../apps/projects/projects.html">
                <i class="icon wb-image"></i>
                <span>Project</span>
              </a>
            </li>
            <li>
              <a href="../apps/forum/forum.html">
                <i class="icon wb-chat-group"></i>
                <span>Forum</span>
              </a>
            </li>
            <li>
              <a href="<?php echo Yii::app()->createUrl('dashboard'); ?>">
                <i class="icon wb-dashboard"></i>
                <span>Dashboard</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
	*/ ?>
<script type="text/javascript">
  jQuery(document).ready(function($) {
    $(".site-menu-title").hover(function() {
      //alert($(this).height()); //38
      //console.log($(this).width());

      if ($(this).css("text-overflow") == "ellipsis") {
        $(this).addClass("site-menu-title-overflow");
      } else {
        $(this).removeClass("site-menu-title-overflow");
      }

      if ($(this).height() > 38) {
        $(this).addClass("site-menu-title-overflow");
      }


    }, function() {
      //mouseout
      $(this).removeClass("site-menu-title-overflow");
    });



  });

  var activePage;

  function checkEllipsis(el) {
    const styles = getComputedStyle(el);
    const widthEl = parseFloat(styles.width);
    const ctx = document.createElement('canvas').getContext('2d');
    console.log(ctx);
    ctx.font = `${styles.fontSize} ${styles.fontFamily}`;
    const text = ctx.measureText(el.innerText);
    return text.width > widthEl;
  }

  $(function() {

    function stripTrailingSlash(str) {
      if (str.substr(-1) == '/') {
        return str.substr(0, str.length - 1);
      }
      return str;
    }

    var url = window.location.pathname;
    activePage = stripTrailingSlash(url);

    $('ul.site-menu li a').each(function() {
      var currentPage = stripTrailingSlash($(this).attr('href'));
      var curpath = currentPage.replace(/^.*\/\/[^\/]+/, '');

      if (activePage == curpath) {
        $(this).parent().addClass('active');
        $(this).parent().parent().addClass('open active');
        $(this).parent().parent().parent().addClass('open active');
        $(this).parent().parent().parent().parent().addClass('open active');
      }


    });

    $('ul.site-menu li').each(function() {
      //console.log(this);
      if ($(this).hasClass('open')) {
        //console.log('changed');
        $(this).addClass('open active');
      }

    });


  });
</script>