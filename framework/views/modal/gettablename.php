<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<title>Table name</title>
	<script>
		$(document).ready(function() {
			// DataTable
			//var table = $('#tbntb').DataTable({
			//"scrollX": true,
			//"order": [[ 3, "desc" ]],	
			//});
		});

		function showcolumns(tbn1, tbn, rn, counttb) {
			var data1 = 'action=getfieldname&tbn1=' + tbn1 + '&tbn=' + tbn;
			var dtn1 = ' ' + tbn1;
			for (i = 0; i <= counttb; i++) {
				$("#spn" + i).css("background-color", "");
			}
			$("#spn" + rn).css("background-color", "#E6E9FD");
			$("#sqlcommand").val("select * from " + tbn1);
			$("#dtn").html(dtn1);

			executesql(); //เรียกใช้ฟังก์ชั่น run sql
		}
	</script>
</head>

<body>
	<?php

	$counttb = count($ListTB);

	if ($counttb <= 15) {
	?>
		<script>
			$("#tbn").css("height", "auto");
		</script>
	<?php
	} else {
	?>
		<script>
			$("#tbn").css("height", "450px");
		</script>
	<?php
	}
	?>
	<table id="tbntb">
		<!--<thead>
    	<tr>
        	<th>TB Name</th>
        </tr>
    </thead>-->
		<tbody>
			<?php
			$headcol = "Tables_in_". $tbn;
			$rowno = 1;
			foreach ($ListTB as $tables) {
			?>
				<tr>
					<td id="spn<?= $rowno ?>" style="color:#039; cursor:pointer;" onClick="javascript:showcolumns('<?= $tables[$headcol] ?>','<?= $tbn ?>',<?= $rowno ?>,<?= $counttb ?>);"><i class="fa fa-table"></i> <?= $tables[$headcol] ?></td>
				</tr>
			<?php
				$rowno += 1;
			}
		
			?>
		</tbody>
	</table>

</body>

</html>