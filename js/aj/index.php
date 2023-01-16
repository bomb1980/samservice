<?php
// Start the session.
session_start();
?>
<!DOCTYPE html>
<html>

<head>
  <title>Progress Bar</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

  <!-- Stylesheets -->
  <link rel="stylesheet" href="http://127.0.0.1:92/ihc/themes/remark_base/global/css/bootstrap.min.css">
  <link rel="stylesheet" href="http://127.0.0.1:92/ihc/themes/remark_base/global/css/bootstrap-extend.min.css">

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="./waterTank.js"></script>
  <style>
    #progress {
      width: 500px;
      border: 1px solid #aaa;
      height: 20px;
    }

    #progress .bar {
      background-color: #ccc;
      height: 20px;
    }

    .progress {
      position: relative;
    }

    .progress-bar-title {
      position: absolute;
      text-align: center;

      /* line-height should be equal to bar height */
      overflow: hidden;
      color: #fff;
      right: 0;
      left: 0;
      top: 0;
    }

    .tank {
      margin: 0 50px;
      display: inline-block;
    }
  </style>
</head>

<body>

  <div class="progress progress-lg">
    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
    <div class="progress-bar-title">0%</div>
  </div>


  <div id="progress" style="text-align: center;"></div>
  <div id="message"></div>

  <div class="tank waterTankHere1"></div>

  <script>
    var timer;

    // The function to refresh the progress bar.
    function refreshProgress() {
      // We use Ajax again to check the progress by calling the checker script.
      // Also pass the session id to read the file because the file which storing the progress is placed in a file per session.
      // If the call was success, display the progress bar.
      $.ajax({
        url: "checker.php?file=<?php echo session_id() ?>" + new Date().getTime(),
        cache: false,
        success: function(data) {
          console.log(data);
          $(".progress-bar").css("width", data.percent + "%");
          $(".progress-bar-title").html(data.percent + "%");

          $("#progress").html('<div class="bar" style="width:' + data.percent + '%">' + data.percent + '%</div>');
          $("#message").html(data.message);
          $('.waterTankHere1').waterTank(data.percent)
          // If the process is completed, we should stop the checking process.
          if (data.percent == 100) {
            window.clearInterval(timer);
            timer = window.setInterval(completed, 1000);
          }
        }
      });
    }

    function completed() {
      $("#message").html("Completed");
      window.clearInterval(timer);
    }

    // When the document is ready
    $(document).ready(function() {
      // Trigger the process in web server.
      $.ajax({
        url: "process.php"
      });
      // Refresh the progress bar every 1 second.
      timer = window.setInterval(refreshProgress, 1000);
    });
  </script>

  <script>
    $(document).ready(function() {

      $('.waterTankHere1').waterTank({
        width: 420,
        height: 360,
        color: '#8bd0ec',
        level: 0
      }).on('click', function(event) {
        $(this).waterTank(Math.floor(Math.random() * 100) + 0);
      });

    });
  </script>

</body>

</html>