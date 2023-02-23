<?php if (Yii::$app->user->identity->role_id == 1) { ?>
  <div class="site-menubar site-menubar-light">
    <div class="site-menubar-body">
      <div>
        <div>
          <ul class="site-menu" data-plugin="menu">
            <li class="site-menu-category"></li>
            <li class="site-menu-item">
              <a href="dashboard">
                <i class="site-menu-icon fas fa-home" aria-hidden="true"></i>
                <span class="site-menu-title">หน้าแรก</span>
              </a>
            </li>


            <li class="site-menu-category">จัดการข้อมูล</li>

            <li class="site-menu-item">
              <a href="empdata/syndata">
                <i class="site-menu-icon icon fas fa-people-arrows" aria-hidden="true"></i>
                <span class="site-menu-title">ข้อมูลบุคลากร (per_personal)</span>
              </a>
            </li>
            <li class="site-menu-item">
              <a href="empdata/updateline">
                <i class="site-menu-icon icon fas fa-people-arrows" aria-hidden="true"></i>
                <span class="site-menu-title">ตำแหน่งในสายงาน (tb_line)</span>
              </a>
            </li>
            <li class="site-menu-item">
              <a href="empdata/updatelevel">
                <i class="site-menu-icon icon fas fa-people-arrows" aria-hidden="true"></i>
                <span class="site-menu-title">ระดับตำแหน่ง (tb_level)</span>
              </a>
            </li>
            <li class="site-menu-item">
              <a href="empdata/updateoganize">
                <i class="site-menu-icon icon fas fa-people-arrows" aria-hidden="true"></i>
                <span class="site-menu-title">โครงสร้างส่วนราชการ (organize)</span>
              </a>
            </li>

            <li class="site-menu-item">
              <a href="empdata/updatepertype">
                <i class="site-menu-icon icon fas fa-people-arrows" aria-hidden="true"></i>
                <span class="site-menu-title">ประเภทบุคลากร (tb_pertype)</span>
              </a>
            </li>



            <li class="site-menu-item">
              <a href="empdata/updateposition">
                <i class="site-menu-icon icon fas fa-people-arrows" aria-hidden="true"></i>
                <span class="site-menu-title">ตำแหน่ง (pos_position)</span>
              </a>
            </li>

            
            
            
            
            <li class="site-menu-category">ดึงข้อมูลมาลง SQL</li>
            <li class="site-menu-item">
              <a href="empdata/personalotosql">
                <i class="site-menu-icon icon fas fa-people-arrows" aria-hidden="true"></i>
                <span class="site-menu-title">ข้อมูลบุคลากร</span>
              </a>
            </li>


            <li class="site-menu-category">ตั้งค่าข้อมูล</li>

            <li class="site-menu-item">
              <a href="empdata/user_list">
                <i class="site-menu-icon fas fa-user-cog" aria-hidden="true"></i>
                <span class="site-menu-title">สิทธิ์ผู้ใช้งาน</span>
              </a>
            </li>

            <li class="site-menu-item">
              <a href="empdata/user_register">
                <i class="site-menu-icon fas fa-user-plus" aria-hidden="true"></i>
                <span class="site-menu-title">เพิ่มผู้ใช้งาน</span>
              </a>
            </li>

            <li class="site-menu-item">
              <a href="admin/datamanagement">
                <i class="site-menu-icon fas fa-database" aria-hidden="true"></i>
                <span class="site-menu-title">ดูฐานข้อมูลระบบ</span>
              </a>
            </li>

          </ul>

        </div>
      </div>
    </div>

  </div>

<?php } else { ?>
  <div class="site-menubar site-menubar-light">
    <div class="site-menubar-body">
      <div>
        <div>
          <ul class="site-menu" data-plugin="menu">
            <li class="site-menu-category"></li>
            <li class="site-menu-item">
              <a href="dashboard">
                <i class="site-menu-icon fas fa-home" aria-hidden="true"></i>
                <span class="site-menu-title">หน้าแรก</span>
              </a>
            </li>


            <li class="site-menu-category">จัดการข้อมูล</li>


            <li class="site-menu-item">
              <a href="empdata/syndata">
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