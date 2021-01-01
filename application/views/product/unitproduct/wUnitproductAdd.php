<?php
	$tLevelUser = $this->session->userdata('tSesUserLevel');
	if($tTypePage == 'insert'){
		$tRoute 			= 'r_unitproducteventinsert';
		$tRouteUrl			= 'สร้างหน่วยสินค้า';
		$FNStaUse       	= 1;
	}else if($tTypePage == 'edit'){
		$FTPunCode 			= $aResult[0]['FTPunCode'];
		$FTPunName			= $aResult[0]['FTPunName'];
		$tRoute 			= 'r_unitproducteventedit';
		$tRouteUrl			= 'แก้ไขหน่วยสินค้า';
	}
?>

<?php
	$aPermission = FCNaPERGetPermissionByPage('r_unit');
	$aPermission = $aPermission[0];
	if($aPermission['P_read'] != 1){ 		$tPer_read 		= 'xCNHide'; }else{ $tPer_read = ''; }
	if($aPermission['P_create'] != 1){ 		$tPer_create 	= 'xCNHide'; }else{ $tPer_create = ''; }
	if($aPermission['P_delete'] != 1){ 		$tPer_delete 	= 'xCNHide'; }else{ $tPer_delete = ''; }
	if($aPermission['P_edit'] != 1){ 		$tPer_edit 		= 'xCNHide'; }else{ $tPer_edit = ''; }
	if($aPermission['P_cancel'] != 1){ 		$tPer_cancle 	= 'xCNHide'; }else{ $tPer_cancle = ''; }
	if($aPermission['P_approved'] != 1){ 	$tPer_approved 	= 'xCNHide'; }else{ $tPer_approved = ''; }
	if($aPermission['P_print'] != 1){ 		$tPer_print 	= 'xCNHide'; }else{ $tPer_print = ''; }
?> 

<div class="container-fulid">
	
	<form id="ofmunitProduct" class="form-signin" method="post" action="javascript:void(0)">

		<input type="hidden" id="ohdunitProductCode" name="ohdunitProductCode" value="<?=@$FTPunCode;?>">

		<!--Section บน-->
		<div class="row">
			<div class="col-lg-6 col-md-6"><span class="xCNHeadMenuActive" onclick="JSxCallPageunitProductMain();">หน่วยสินค้า</span><span class="xCNHeadMenu">  /  <?=$tRouteUrl?></span></div>
			
			<?php 
				if($tTypePage == 'edit'){	//เข้ามาแบบ ขา Edit และ สิทธิสามารถแก้ไขได้
					if($tPer_edit == ''){
						$tAlwSave = '';
					}else{
						$tAlwSave = 'xCNHide';
					}
				}else if($tTypePage == 'insert'){ //เข้ามาแบบ ขา Insert และ สิทธิสามารถบันทึกได้
					if($tPer_create == ''){
						$tAlwSave = '';
					}else{
						$tAlwSave = 'xCNHide';
					}
				}
			?>
			<div class="col-lg-6 col-md-6 <?=$tAlwSave?>"><button class="xCNButtonSave pull-right" onclick="JSxEventSaveorEdit('<?=$tRoute?>');">บันทึก</button></div>
		</div>

		<!--Section ล่าง-->
		<div class="card" style="margin-top: 10px;">
			<div class="card-body">
				<div class="row">
					<!--รายละเอียด-->
					<div class="col-lg-4 col-md-4">
						<!--รหัส-->
						<div class="form-group">
							<label><span style="color:red;">*</span> รหัสหน่วยสินค้า</label>
							<input <?=($tTypePage == 'edit') ? 'disabled' : '' ?> type="text" class="form-control" maxlength="5" id="oetCodeUNIName" name="oetCodeUNIName" placeholder="กรุณาระบุรหัสหน่วยสินค้า" autocomplete="off" value="<?=@$FTPunCode;?>">
							<span id="oetCodeUNIName_Dup" style="color:red; text-align: right; display: none;"><em>พบรหัสหน่วยสินค้าซ้ำ กรุณาลองใหม่อีกครั้ง</em></span>
						</div>

						<!--ชื่อหน่วยสินค้า-->
						<div class="form-group">
							<label>ชื่อหน่วยสินค้า</label>
							<input type="text" class="form-control" maxlength="100" id="oetUNIName" name="oetUNIName" placeholder="กรุณาระบุชื่อหน่วยสินค้า" autocomplete="off" value="<?=@$FTPunName;?>">
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
<div>

<script src="<?= base_url('application/assets/js/jFormValidate.js')?>"></script>
<script>

	//เมื่อกด ข้อความ dup ต้องหาย
	$('#oetCodeUNIName').click(function() {
		$('#oetCodeUNIName_Dup').css('display','none');
	});

	//ถ้าเข้ามาแบบแก้ไข แต่ ไม่มีสิทธิ์ในการแก้ไข
	if('<?=$tTypePage?>' == 'edit' && '<?=$tPer_edit?>' != ''){
		$('.form-control').attr('disabled',true);
	}

	//อีเวนท์บันทึกข้อมูล
	function JSxEventSaveorEdit(ptRoute){

		if($('#oetCodeUNIName').val() == ''){
			$('#oetCodeUNIName').focus();
			return;
		}
		
		if($('#oetUNIName').val() == ''){
			$('#oetUNIName').focus();
			return;
		}

		$.ajax({
			type	: "POST",
			url		: ptRoute,
			data 	: $('#ofmunitProduct').serialize(),
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				if(tResult == 'pass_insert'){
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('ลงทะเบียนหน่วยสินค้าสำเร็จ');
					JSxCallPageunitProductMain();
					setTimeout(function(){
						$('.alert-success').find('.close').click();
					}, 3000);
				}else if(tResult == 'pass_update'){
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('แก้ไขข้อมูลหน่วยสินค้าสำเร็จ');
					JSxCallPageunitProductMain();
					setTimeout(function(){
						$('.alert-success').find('.close').click();
					}, 3000);
				}else if(tResult == 'duplicate'){
					$('#oetCodeUNIName_Dup').css('display','block');
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert(jqXHR, textStatus, errorThrown);
			}
		});
	}
</script>