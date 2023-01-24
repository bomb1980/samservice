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


          <li class="site-menu-category">จัดการข้อมูล</li>

          <?php

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
              <li class="site-menu-item has-sub">adddddsdsds
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
              <li class="site-menu-item has-sub">a;djdfkdasfj;dk
                <a href="javascript:void(0)">
                  <span class="site-menu-title"><?php echo $dataitemlv2['name']; ?></span>
                  <span class="site-menu-arrow"></span>
                </a>
                <ul class="site-menu-sub">
                  <?php
                      foreach ($datalv3 as $dataitemlv3) {
                        if ($dataitemlv2['id'] === $dataitemlv3['parent_lv2_id']) {
                          echo '<li class="site-menu-item"><a class="animsition-link" href="' . Yii::$app->urlManager->createUrl('/content/listdata') . '/' . $dataitemlv3['id'] . '"><div class="overflow-tip"><span class="site-menu-title">' . $dataitemlv3['name'] . '</span></div></a>kkkkkkkkk</li>';
                        }
                      }
                  ?>
                </ul>
              </li>
        <?php
                    } else {
                      echo '<li class="site-menu-item">ggggggg<a class="animsition-link" href="' . Yii::$app->urlManager->createUrl('/content/listdata') . '/' . $dataitemlv2['id'] . '"><div class="overflow-tip"><span class="site-menu-title">' . $dataitemlv2['name'] . '</span></div></a>gggggggggg</li>';
                    }
                    echo '</ul>';
                  }
                }
                echo "</li>";
              } else {
        ?>
        <li class="site-menu-item has-sub">fdasdfdfsdsf
          <a href="javascript:void(0)">
            <i class="site-menu-icon <?php echo $dataitemlv1['icon_code']; ?>" aria-hidden="true"></i>
            <span class="site-menu-title"><?php echo $dataitemlv1['name']; ?></span>
          </a>
        </li>
      <?php
              }
            }


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


      <!-- <li class="site-menu-item">
        <a href="<?php echo Yii::$app->urlManager->createUrl('admin/user_permission'); ?>">
          <i class="site-menu-icon fas fa-user-cog" aria-hidden="true"></i>
          <span class="site-menu-title">สิทธิ์ผู้ใช้งาน</span>
        </a>
      </li> -->
      <li class="site-menu-item">
        <a href="<?php echo Yii::$app->urlManager->createUrl('empdata/user_permission'); ?>">
          <i class="site-menu-icon fas fa-user-cog" aria-hidden="true"></i>
          <span class="site-menu-title">สิทธิ์ผู้ใช้งาน</span>
        </a>
      </li>

      <li class="site-menu-item">
        <a href="<?php echo Yii::$app->urlManager->createUrl('admin/datamanagement'); ?>">
          <i class="site-menu-icon fas fa-database" aria-hidden="true"></i>
          <span class="site-menu-title">ดูฐานข้อมูลระบบ</span>
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


<script type="text/javascript">
  jQuery(document).ready(function($) {
    $(".site-menu-title").hover(function() {


      if ($(this).css("text-overflow") == "ellipsis") {
        $(this).addClass("site-menu-title-overflow");
      } else {
        $(this).removeClass("site-menu-title-overflow");
      }

      if ($(this).height() > 38) {
        $(this).addClass("site-menu-title-overflow");
      }


    }, function() {

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