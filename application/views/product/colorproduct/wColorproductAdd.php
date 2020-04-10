<?php
	$tLevelUser = $this->session->userdata('tSesUserLevel');
	if($tTypePage == 'insert'){
		$tRoute 			= 'r_colorproducteventinsert';
		$tRouteUrl			= 'สร้างสีสินค้า';
		$FNStaUse       	= 1;
	}else if($tTypePage == 'edit'){
		$FTPClrCode 		= $aResult[0]['FTPClrCode'];
		$FTPClrName			= $aResult[0]['FTPClrName'];
		$tRoute 			= 'r_colorproducteventedit';
		$tRouteUrl			= 'แก้ไขสีสินค้า';
	}
?>

<div class="container-fulid">
	
	<form id="ofmColorProduct" class="form-signin" method="post" action="javascript:void(0)">

		<input type="hidden" id="ohdColorProductCode" name="ohdColorProductCode" value="<?=@$FTPClrCode;?>">

		<!--Section บน-->
		<div class="row">
			<div class="col-lg-6 col-md-6"><span class="xCNHeadMenuActive" onclick="JSxCallPageColorProductMain();">สีสินค้า</span><span class="xCNHeadMenu">  /  <?=$tRouteUrl?></span></div>
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
							<label>ชื่อสีสินค้า</label>
							<input type="text" class="form-control" maxlength="100" id="oetCOPName" name="oetCOPName" placeholder="กรุณาระบุชื่อสีสินค้า" autocomplete="off" value="<?=@$FTPClrName;?>">
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

		if($('#oetCOPName').val() == ''){
			$('#oetCOPName').focus();
			return;
		}

		$.ajax({
			type	: "POST",
			url		: ptRoute,
			data 	: $('#ofmColorProduct').serialize(),
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				if(tResult == 'pass_insert'){
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('ลงทะเบียนสีสินค้าสำเร็จ');
					JSxCallPageColorProductMain();
					setTimeout(function(){
						$('.alert-success').find('.close').click();
					}, 3000);
				}else if(tResult == 'pass_update'){
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('แก้ไขข้อมูลสีสินค้าสำเร็จ');
					JSxCallPageColorProductMain();
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
