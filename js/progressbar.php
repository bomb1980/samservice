<!DOCTYPE html>
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script type="text/javascript" src="jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="progress.js"></script>
    </head>
    <body>
        <form action="progress.php" method="POST" >
            <input id="startProgress" type="submit" name="startProgress" value="start progress"/>
        </form>
        <div class="progress" style="margin-top:100px">
            <div class="progress-bar active" id="progressbar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%; background-color: #399;">
                <span class="sr-only">0% Complete</span>
            </div>
        </div>
    </body>
</html>
