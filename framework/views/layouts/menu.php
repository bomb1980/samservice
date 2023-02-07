<?php if (Yii::$app->user->identity->role_id == 1) { ?>
  <div class="site-menubar site-menubar-light">
    <div class="site-menubar-body">
      <div>
        <div>
          <ul class="site-menu" data-plugin="menu">
            <li class="site-menu-category"></li>
            <li class="site-menu-item">
              <a href="<?php echo Yii::$app->urlManager->createUrl('dashboard'); ?>">
                <i class="site-menu-icon fas fa-home" aria-hidden="true"></i>
                <span class="site-menu-title">หน้าแรก</span>
              </a>
            </li>

            
            <li class="site-menu-category">จัดการข้อมูล</li>


            <li class="site-menu-item">
              <a href="<?php echo Yii::$app->urlManager->createUrl('empdata/syndata'); ?>">
                <i class="site-menu-icon icon fas fa-people-arrows" aria-hidden="true"></i>
                <span class="site-menu-title">ข้อมูลเจ้าหน้าที่</span>
              </a>
            </li>


            <li class="site-menu-category">ตั้งค่าข้อมูล</li>

            <li class="site-menu-item">
              <a href="<?php echo Yii::$app->urlManager->createUrl('empdata/user_list'); ?>">
                <i class="site-menu-icon fas fa-user-cog" aria-hidden="true"></i>
                <span class="site-menu-title">สิทธิ์ผู้ใช้งาน</span>
              </a>
            </li>

            <li class="site-menu-item">
              <a href="<?php echo Yii::$app->urlManager->createUrl('empdata/user_register'); ?>">
                <i class="site-menu-icon fas fa-user-plus" aria-hidden="true"></i>
                <span class="site-menu-title">เพิ่มผู้ใช้งาน</span>
              </a>
            </li>

            <li class="site-menu-item">
              <a href="<?php echo Yii::$app->urlManager->createUrl('admin/datamanagement'); ?>">
                <i class="site-menu-icon fas fa-database" aria-hidden="true"></i>
                <span class="site-menu-title">ดูฐานข้อมูลระบบ</span>
              </a>
            </li>

          </ul>

        </div>
      </div>
    </div>

  </div>

<?php } else {?>
  
  
  <div class="site-menubar site-menubar-light">
    <div class="site-menubar-body">
      <div>
        <div>
          <ul class="site-menu" data-plugin="menu">
            <li class="site-menu-category"></li>
            <li class="site-menu-item">
              <a href="<?php echo Yii::$app->urlManager->createUrl('dashboard'); ?>">
                <i class="site-menu-icon fas fa-home" aria-hidden="true"></i>
                <span class="site-menu-title">หน้าแรก</span>
              </a>
            </li>

            
            <li class="site-menu-category">จัดการข้อมูล</li>


            <li class="site-menu-item">
              <a href="<?php echo Yii::$app->urlManager->createUrl('empdata/syndata'); ?>">
                <i class="site-menu-icon icon fas fa-people-arrows" aria-hidden="true"></i>
                <span class="site-menu-title">ข้อมูลเจ้าหน้าที่</span>
              </a>
            </li>


            

            

            

           

          </ul>

        </div>
      </div>
    </div>

  </div>
  <?php } ?>

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