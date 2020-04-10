<?php
	$tLevelUser = $this->session->userdata('tSesUserLevel');
	if($tTypePage == 'insert'){
		$tRoute 			= 'r_modalproducteventinsert';
		$tRouteUrl			= 'สร้างรุ่นสินค้า';
		$FNStaUse       	= 1;
	}else if($tTypePage == 'edit'){
		$FTMolCode 			= $aResult[0]['FTMolCode'];
		$FTMolName			= $aResult[0]['FTMolName'];
		$tRoute 			= 'r_modalproducteventedit';
		$tRouteUrl			= 'แก้ไขรุ่นสินค้า';
	}
?>

<div class="container-fulid">
	
	<form id="ofmModalProduct" class="form-signin" method="post" action="javascript:void(0)">

		<input type="hidden" id="ohdModalProductCode" name="ohdModalProductCode" value="<?=@$FTMolCode;?>">

		<!--Section บน-->
		<div class="row">
			<div class="col-lg-6 col-md-6"><span class="xCNHeadMenuActive" onclick="JSxCallPageModalProductMain();">รุ่นสินค้า</span><span class="xCNHeadMenu">  /  <?=$tRouteUrl?></span></div>
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
							<label>ชื่อรุ่นสินค้า</label>
							<input type="text" class="form-control" maxlength="100" id="oetMOLName" name="oetMOLName" placeholder="กรุณาระบุชื่อรุ่นสินค้า" autocomplete="off" value="<?=@$FTMolName;?>">
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

		if($('#oetMOLName').val() == ''){
			$('#oetMOLName').focus();
			return;
		}

		$.ajax({
			type	: "POST",
			url		: ptRoute,
			data 	: $('#ofmModalProduct').serialize(),
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				console.log(tResult);
				if(tResult == 'pass_insert'){
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('ลงทะเบียนรุ่นสินค้าสำเร็จ');
					JSxCallPageModalProductMain();
					setTimeout(function(){
						$('.alert-success').find('.close').click();
					}, 3000);
				}else if(tResult == 'pass_update'){
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('แก้ไขข้อมูลรุ่นสินค้าสำเร็จ');
					JSxCallPageModalProductMain();
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
