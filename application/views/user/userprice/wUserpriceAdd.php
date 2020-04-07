<?php
	$tLevelUser = $this->session->userdata('tSesUserLevel');
	if($tTypePage == 'insert'){
		$tRoute 			= 'r_userpriceeventinsert';
		$tRouteUrl			= 'สร้างกลุ่มราคา';
		$FNStaUse       	= 1;
	}else if($tTypePage == 'edit'){
		$FTPriGrpID 		= $aResult[0]['FTPriGrpID'];
		$FTPriGrpName		= $aResult[0]['FTPriGrpName'];
		$FTPriGrpReason		= $aResult[0]['FTPriGrpReason'];
		$tRoute 			= 'r_userpriceeventedit';
		$tRouteUrl			= 'แก้ไขกลุ่มราคา';
	}
?>

<div class="container-fulid">
	
	<form id="ofmPriceGroup" class="form-signin" method="post" action="javascript:void(0)">

		<input type="hidden" id="ohdPriceGroupCode" name="ohdPriceGroupCode" value="<?=@$FTPriGrpID;?>">

		<!--Section บน-->
		<div class="row">
			<div class="col-lg-6 col-md-6"><span class="xCNHeadMenuActive" onclick="JSxCallPagePriceGroupMain();">กลุ่มราคา</span><span class="xCNHeadMenu">  /  <?=$tRouteUrl?></span></div>
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
							<label>ชื่อกลุ่มราคา</label>
							<input type="text" class="form-control" maxlength="20" id="oetUPIName" name="oetUPIName" placeholder="กรุณาระบุชื่อกลุ่มราคา" autocomplete="off" value="<?=@$FTPriGrpName;?>">
						</div>

						<!--หมายเหตุ-->
						<div class="form-group">
							<label>หมายเหตุ</label>
							<textarea type="text" class="form-control" id="oetUPIReason" name="oetUPIReason" placeholder="หมายเหตุ" rows="3"><?=@$FTPriGrpReason;?></textarea>
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

		if($('#oetUPIName').val() == ''){
			$('#oetUPIName').focus();
			return;
		}

		$.ajax({
			type	: "POST",
			url		: ptRoute,
			data 	: $('#ofmPriceGroup').serialize(),
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				if(tResult == 'pass_insert'){
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('ลงทะเบียนกลุ่มราคาสำเร็จ');
					JSxCallPagePriceGroupMain();
					setTimeout(function(){
						$('.alert-success').find('.close').click();
					}, 3000);
				}else if(tResult == 'pass_update'){
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('แก้ไขข้อมูลกลุ่มราคาสำเร็จ');
					JSxCallPagePriceGroupMain();
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
