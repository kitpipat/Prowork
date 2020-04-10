<?php
	$tLevelUser = $this->session->userdata('tSesUserLevel');
	if($tTypePage == 'insert'){
		$tRoute 			= 'r_groupproducteventinsert';
		$tRouteUrl			= 'สร้างกลุ่มสินค้า';
		$FNStaUse       	= 1;
	}else if($tTypePage == 'edit'){
		$FTPgpCode 			= $aResult[0]['FTPgpCode'];
		$FTPgpName			= $aResult[0]['FTPgpName'];
		$tRoute 			= 'r_groupproducteventedit';
		$tRouteUrl			= 'แก้ไขกลุ่มสินค้า';
	}
?>

<div class="container-fulid">
	
	<form id="ofmGroupProduct" class="form-signin" method="post" action="javascript:void(0)">

		<input type="hidden" id="ohdGroupProductCode" name="ohdGroupProductCode" value="<?=@$FTPgpCode;?>">

		<!--Section บน-->
		<div class="row">
			<div class="col-lg-6 col-md-6"><span class="xCNHeadMenuActive" onclick="JSxCallPageGroupProductMain();">กลุ่มสินค้า</span><span class="xCNHeadMenu">  /  <?=$tRouteUrl?></span></div>
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
							<label>ชื่อกลุ่มสินค้า</label>
							<input type="text" class="form-control" maxlength="100" id="oetGRPName" name="oetGRPName" placeholder="กรุณาระบุชื่อกลุ่มสินค้า" autocomplete="off" value="<?=@$FTPgpName;?>">
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

		if($('#oetGRPName').val() == ''){
			$('#oetGRPName').focus();
			return;
		}

		$.ajax({
			type	: "POST",
			url		: ptRoute,
			data 	: $('#ofmGroupProduct').serialize(),
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				if(tResult == 'pass_insert'){
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('ลงทะเบียนกลุ่มสินค้าสำเร็จ');
					JSxCallPageGroupProductMain();
					setTimeout(function(){
						$('.alert-success').find('.close').click();
					}, 3000);
				}else if(tResult == 'pass_update'){
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('แก้ไขข้อมูลกลุ่มสินค้าสำเร็จ');
					JSxCallPageGroupProductMain();
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
