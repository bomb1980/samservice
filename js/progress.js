

$('document').ready(function () {
    
    $('#startProgress').click(function () {
        getProgress();
        console.log('startProgress');
        $.ajax({
            url: "progress.php",
            type: "POST",
            data: {
                'startProgress': 'yes'
            },
            async: true,
            contentType: false,
            processData: false,
            success: function(data){
                if(data!==''){
                    alert(data);
                }
                return false;
            }
        });
        return false;
    });

});

function getProgress() {
    console.log('getProgress');
    $.ajax({
        url: "getProgress.php",
        type: "GET",
        contentType: false,
        processData: false,
        async: false,
		dataType: "json",
        success: function (data) {
            console.log(data);
            $('#progressbar').css('width', data.percent+'%').children('.sr-only').html(data.percent+"% Complete");
            if(data.percent !== '100'){
                setTimeout('getProgress()', 1000);
            }
        }
    });
}