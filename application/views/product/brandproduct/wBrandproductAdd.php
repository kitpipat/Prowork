<?php
	$tLevelUser = $this->session->userdata('tSesUserLevel');
	if($tTypePage == 'insert'){
		$tRoute 			= 'r_brandproducteventinsert';
		$tRouteUrl			= 'สร้างยี่ห้อสินค้า';
		$FNStaUse       	= 1;
	}else if($tTypePage == 'edit'){
		$FTPbnCode 			= $aResult[0]['FTPbnCode'];
		$FTPbnName			= $aResult[0]['FTPbnName'];
		$tRoute 			= 'r_brandproducteventedit';
		$tRouteUrl			= 'แก้ไขยี่ห้อสินค้า';
	}
?>

<?php
	$aPermission = FCNaPERGetPermissionByPage('r_brandproduct');
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
	
	<form id="ofmBrandProduct" class="form-signin" method="post" action="javascript:void(0)">

		<input type="hidden" id="ohdBrandProductCode" name="ohdBrandProductCode" value="<?=@$FTPbnCode;?>">

		<!--Section บน-->
		<div class="row">
			<div class="col-lg-6 col-md-6"><span class="xCNHeadMenuActive" onclick="JSxCallPageBrandProductMain();">ยี่ห้อสินค้า</span><span class="xCNHeadMenu">  /  <?=$tRouteUrl?></span></div>
			
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
							<label><span style="color:red;">*</span> รหัสยี่ห้อสินค้า</label>
							<input <?=($tTypePage == 'edit') ? 'disabled' : '' ?> type="text" class="form-control" maxlength="5" id="oetCodeBANName" name="oetCodeBANName" placeholder="กรุณาระบุรหัสยี่ห้อสินค้า" autocomplete="off" value="<?=@$FTPbnCode;?>">
							<span id="oetCodeBANName_Dup" style="color:red; text-align: right; display: none;"><em>พบรหัสยี่ห้อสินค้าซ้ำ กรุณาลองใหม่อีกครั้ง</em></span>
						</div>

						<!--ชื่อยี่ห้อสินค้า-->
						<div class="form-group">
							<label>ชื่อยี่ห้อสินค้า</label>
							<input type="text" class="form-control" maxlength="100" id="oetBANName" name="oetBANName" placeholder="กรุณาระบุชื่อยี่ห้อสินค้า" autocomplete="off" value="<?=@$FTPbnName;?>">
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
	$('#oetCodeBANName').click(function() {
		$('#oetCodeBANName_Dup').css('display','none');
	});

	//ถ้าเข้ามาแบบแก้ไข แต่ ไม่มีสิทธิ์ในการแก้ไข
	if('<?=$tTypePage?>' == 'edit' && '<?=$tPer_edit?>' != ''){
		$('.form-control').attr('disabled',true);
	}

	//อีเวนท์บันทึกข้อมูล
	function JSxEventSaveorEdit(ptRoute){

		if($('#oetCodeBANName').val() == ''){
			$('#oetCodeBANName').focus();
			return;
		}
		
		if($('#oetBANName').val() == ''){
			$('#oetBANName').focus();
			return;
		}

		$.ajax({
			type	: "POST",
			url		: ptRoute,
			data 	: $('#ofmBrandProduct').serialize(),
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				if(tResult == 'pass_insert'){
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('ลงทะเบียนยี่ห้อสินค้าสำเร็จ');
					JSxCallPageBrandProductMain();
					setTimeout(function(){
						$('.alert-success').find('.close').click();
					}, 3000);
				}else if(tResult == 'pass_update'){
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('แก้ไขข้อมูลยี่ห้อสินค้าสำเร็จ');
					JSxCallPageBrandProductMain();
					setTimeout(function(){
						$('.alert-success').find('.close').click();
					}, 3000);
				}else if(tResult == 'duplicate'){
					$('#oetCodeBANName_Dup').css('display','block');
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				JSxModalErrorCenter(jqXHR.responseText);
			}
		});
	}
</script>
