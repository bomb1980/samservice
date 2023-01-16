<?php
// Start the session.
//session_start();

?>
<!DOCTYPE html>
<html>

<head>
  <title>Progress Bar</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

  <script src="<?php echo Yii::app()->baseUrl ?>/vendor/waterTank/waterTank.js"></script>
  <style>

    .tank {
      margin: 0 50px;
      display: inline-block;
    }
  </style>
</head>

<body>  

  <div class="tank waterTankHere1"></div>
  <div id="message"></div>

  <script>
    var timer;

    // The function to refresh the progress bar.
    function refreshProgress() {
      // We use Ajax again to check the progress by calling the checker script.
      // Also pass the session id to read the file because the file which storing the progress is placed in a file per session.
      // If the call was success, display the progress bar.
      $.ajax({
        url: "<?php echo Yii::app()->createAbsoluteUrl('partial/checker_sync_ldap', array('rand' => session_id() . time()) ); ?>",
        cache: false,
        success: function(data) {
          //console.log(data.message);
          $(".progress-bar").css("width", data.percent + "%");
          $(".progress-bar-title").html(data.percent + "%");

          $("#progress").html('<div class="bar" style="width:' + data.percent + '%">' + data.percent + '%</div>');
          $("#message").html(data.message);
          $('.waterTankHere1').waterTank(data.percent)
          // If the process is completed, we should stop the checking process.
          if (data.percent == 100) {
            window.clearInterval(timer);
            timer = window.setInterval(completed(data.message), 1000);
            $('.ui-dialog-titlebar-close').css("display", "block");
          }
        }
      });
    }

    function completed(seconds) {
      $("#message").html("Completed");
      $("#message").html("Completed <br/>" + seconds);
      window.clearInterval(timer);
    }

    // When the document is ready
    $(document).ready(function() {
      // Trigger the process in web server.
      $.ajax({
        url:"<?php echo Yii::app()->createAbsoluteUrl("partial/process_sync_ldap"); ?>",
      });
      // Refresh the progress bar every 1 second.
      timer = window.setInterval(refreshProgress, 1000);
    });
  </script>

  <script>
    $(document).ready(function() {

      $('.waterTankHere1').waterTank({
        width: 220,
        height: 180,
        color: '#8bd0ec',
        level: 0
      }).on('click', function(event) {
        //$(this).waterTank(Math.floor(Math.random() * 100) + 0);
      });

    });
  </script>

</body>

</html>