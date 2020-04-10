<?php
	$tLevelUser = $this->session->userdata('tSesUserLevel');
	if($tTypePage == 'insert'){
		$tRoute 			= 'r_sizeproducteventinsert';
		$tRouteUrl			= 'สร้างขนาดสินค้า';
		$FNStaUse       	= 1;
	}else if($tTypePage == 'edit'){
		$FTPzeCode 			= $aResult[0]['FTPzeCode'];
		$FTPzeName			= $aResult[0]['FTPzeName'];
		$tRoute 			= 'r_sizeproducteventedit';
		$tRouteUrl			= 'แก้ไขขนาดสินค้า';
	}
?>

<div class="container-fulid">
	
	<form id="ofmSizeProduct" class="form-signin" method="post" action="javascript:void(0)">

		<input type="hidden" id="ohdSizeProductCode" name="ohdSizeProductCode" value="<?=@$FTPzeCode;?>">

		<!--Section บน-->
		<div class="row">
			<div class="col-lg-6 col-md-6"><span class="xCNHeadMenuActive" onclick="JSxCallPageSizeProductMain();">ขนาดสินค้า</span><span class="xCNHeadMenu">  /  <?=$tRouteUrl?></span></div>
			<div class="col-lg-6 col-md-6"><button class="xCNButtonSave pull-right" onclick="JSxEventSaveorEdit('<?=$tRoute?>');">บันทึก</button></div>
		</div>

		<!--Section ล่าง-->
		<div class="card" style="margin-top: 10px;">
			<div class="card-body">
				<div class="row">
					<!--รายละเอียด-->
					<div class="col-lg-4 col-md-4">
						<!--แผนก-->
						<div class="form-group">
							<label>ชื่อขนาดสินค้า</label>
							<input type="text" class="form-control" maxlength="100" id="oetSIZName" name="oetSIZName" placeholder="กรุณาระบุชื่อขนาดสินค้า" autocomplete="off" value="<?=@$FTPzeName;?>">
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
<div>

<script src="<?= base_url('application/assets/js/jFormValidate.js')?>"></script>
<script>

	//อีเวนท์บันทึกข้อมูล
	function JSxEventSaveorEdit(ptRoute){

		if($('#oetSIZName').val() == ''){
			$('#oetSIZName').focus();
			return;
		}

		$.ajax({
			type	: "POST",
			url		: ptRoute,
			data 	: $('#ofmSizeProduct').serialize(),
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				if(tResult == 'pass_insert'){
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('ลงทะเบียนขนาดสินค้าสำเร็จ');
					JSxCallPageSizeProductMain();
					setTimeout(function(){
						$('.alert-success').find('.close').click();
					}, 3000);
				}else if(tResult == 'pass_update'){
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('แก้ไขข้อมูลขนาดสินค้าสำเร็จ');
					JSxCallPageSizeProductMain();
					setTimeout(function(){
						$('.alert-success').find('.close').click();
					}, 3000);
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert(jqXHR, textStatus, errorThrown);
			}
		});
	}
</script>
