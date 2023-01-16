<?php
    ?>
    	<table class="table table-hover dataTable table-striped w-full" id="Rightlist" role="grid" style="width: 100%;" >
			<thead style="">
				<tr>
					<th scope="col" style="width:45% !important;text-align: center;">APP</th>
					<th scope="col" style="width:50% !important;text-align: center;">สิทธิ์การใช้งาน</th>					
				</tr>
			</thead>
            <tbody>
            <?php
				//var_dump($permis);
                foreach($data as $dataitem) {
                    echo "<tr>";
                    echo "<td>" . $dataitem['name'] . "</td>";
					$right = 0;
					foreach($permis as $per) {
						
						if($per['app_id'] == $dataitem['id'] ){
							$right = $per['user_role']; 
						}
					}
                    //echo "<td>{$right}</td>";
					echo "<td>";
					echo "<div class='pl-5 inline'><input type='radio' id='rdoright".$dataitem['id']."' data-id='" . $dataitem['id'] . "' name='rdoright".$dataitem['id']."' value='1' " . ($right == 1 ? "checked" : "") . "> 1 </div>";
					echo "<div class='pl-5 inline'><input type='radio' id='rdoright".$dataitem['id']."' data-id='" . $dataitem['id'] . "' name='rdoright".$dataitem['id']."' value='2' " . ($right == 2 ? "checked" : "") . "> 2 </div>";
					echo "<div class='pl-5 inline'><input type='radio' id='rdoright".$dataitem['id']."' data-id='" . $dataitem['id'] . "' name='rdoright".$dataitem['id']."' value='3' " . ($right == 3 ? "checked" : "") . "> 3 </div>";
					echo "<div class='pl-5 inline'><input type='radio' id='rdoright".$dataitem['id']."' data-id='" . $dataitem['id'] . "' name='rdoright".$dataitem['id']."' value='4' " . ($right == 4 ? "checked" : "") . "> 4 </div>";
					echo "<input type='hidden' id='hd". $dataitem['id'] ."' value='" . $right . "' >";
					echo "</td>";
					echo "<td>";
					echo"
					<div class='btn-group' role='group'>
						<button type='button' id='btn". $dataitem['id'] ."' class='btn btn-icon btn-info waves-effect waves-classic' data-id='" . $dataitem['id'] . "'  ><i class='icon md-edit' aria-hidden='true' title='บันทึกการแก้ไข'></i></button>
					</div>
					";
					echo "</td>";
                    echo "</tr>";       
                }
            ?>
            </tbody>
		</table>

    <?php
	$sql = "select * from mas_userrole where status=1	";
	$command = Yii::$app->db->createCommand($sql);	
	$rows= $command->queryAll();
	foreach($rows as $dataitem) {
		echo "<span class='badge badge-pill badge-info'>" . $dataitem['id'] . "</span>  " . $dataitem['name'] . "<br/>";
	}


?>
<script type="text/javascript">

     jQuery(document).ready(function ($) {	

		$('input[type="radio"]').change(function(){
			//alert($('#hd'+$(this).data("id")).val());
			//alert($(this).data("id"));
			//alert($(this).val());
		});

		$('button[id^="btn"]').click(function(){
			var currentval = $('#hd'+$(this).data("id")).val();
			var rdoname = 'rdoright' + $(this).data("id");
			var newval = $("input[name='"+ rdoname +"']:checked").val();
	
			if (newval != currentval ){
				
				var result = confirm("ต้องการแก้ไขสิทธิ์ผู้ใช้งาน ?"); 
					if (!result) {
					  return;
					}
					$.ajax({
					  url:"<?php echo Yii::$app->urlManager->createAbsoluteUrl("admin/updateuserapppermission"); ?>",
					  method:"POST",
					  data:{
						user_id: <?php echo $user_id; ?>,
						app_id: $(this).data("id"),
						user_role: newval ,
						current_role: currentval ,
						'<?= Yii::$app->request->csrfParam ?>': '<?= Yii::$app->request->getCsrfToken() ?>',
						ssobranch_code: <?php echo $ssobranch_code;?>
					  },
					  success:function(data)
					  {
						alert('แก้ไขสิทธิ์ผู้ใช้งานเรียบร้อย');
					  }
				});

			}else{
				alert('สิทธิ์ที่เลือกยังเป็นค่าเดิม');
			}
		});

     });


</script>