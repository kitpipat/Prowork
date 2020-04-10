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

<div class="container-fulid">
	
	<form id="ofmBrandProduct" class="form-signin" method="post" action="javascript:void(0)">

		<input type="hidden" id="ohdBrandProductCode" name="ohdBrandProductCode" value="<?=@$FTPbnCode;?>">

		<!--Section บน-->
		<div class="row">
			<div class="col-lg-6 col-md-6"><span class="xCNHeadMenuActive" onclick="JSxCallPageBrandProductMain();">ยี่ห้อสินค้า</span><span class="xCNHeadMenu">  /  <?=$tRouteUrl?></span></div>
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

	//อีเวนท์บันทึกข้อมูล
	function JSxEventSaveorEdit(ptRoute){

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
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert(jqXHR, textStatus, errorThrown);
			}
		});
	}
</script>
