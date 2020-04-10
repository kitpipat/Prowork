<?php
	$tLevelUser = $this->session->userdata('tSesUserLevel');
	if($tTypePage == 'insert'){
		$tRoute 			= 'r_typeproducteventinsert';
		$tRouteUrl			= 'สร้างประเภทสินค้า';
		$FNStaUse       	= 1;
	}else if($tTypePage == 'edit'){
		$FTPtyCode 			= $aResult[0]['FTPtyCode'];
		$FTPtyName			= $aResult[0]['FTPtyName'];
		$tRoute 			= 'r_typeproducteventedit';
		$tRouteUrl			= 'แก้ไขประเภทสินค้า';
	}
?>

<div class="container-fulid">
	
	<form id="ofmTypeProduct" class="form-signin" method="post" action="javascript:void(0)">

		<input type="hidden" id="ohdTypeProductCode" name="ohdTypeProductCode" value="<?=@$FTPtyCode;?>">

		<!--Section บน-->
		<div class="row">
			<div class="col-lg-6 col-md-6"><span class="xCNHeadMenuActive" onclick="JSxCallPageTypeProductMain();">ประเภทสินค้า</span><span class="xCNHeadMenu">  /  <?=$tRouteUrl?></span></div>
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
							<label>ชื่อประเภทสินค้า</label>
							<input type="text" class="form-control" maxlength="100" id="oetTYPName" name="oetTYPName" placeholder="กรุณาระบุชื่อประเภทสินค้า" autocomplete="off" value="<?=@$FTPtyName;?>">
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

		if($('#oetTYPName').val() == ''){
			$('#oetTYPName').focus();
			return;
		}

		$.ajax({
			type	: "POST",
			url		: ptRoute,
			data 	: $('#ofmTypeProduct').serialize(),
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				if(tResult == 'pass_insert'){
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('ลงทะเบียนประเภทสินค้าสำเร็จ');
					JSxCallPageTypeProductMain();
					setTimeout(function(){
						$('.alert-success').find('.close').click();
					}, 3000);
				}else if(tResult == 'pass_update'){
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('แก้ไขข้อมูลประเภทสินค้าสำเร็จ');
					JSxCallPageTypeProductMain();
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
