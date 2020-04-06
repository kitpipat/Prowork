<?php
	$tLevelUser = $this->session->userdata('tSesUserLevel');
	if($tTypePage == 'insert'){
		$tRoute 		= 'r_permissioneventinsert';
		$tRouteUrl		= 'สร้างกลุ่มสิทธิ์';
	}else if($tTypePage == 'edit'){
		$tRoute 		= 'r_permissioneventedit';
		$tRouteUrl		= 'แก้ไขกลุ่มสิทธิ์';
	}
?>

<div class="container-fulid">
	
	<form id="ofmPermission" class="form-signin" method="post" action="javascript:void(0)">

		<input type="hidden" id="ohdPermissionCode" name="ohdPermissionCode" value="<?=@$FTUsrCode;?>">

		<!--Section บน-->
		<div class="row">
			<div class="col-lg-6 col-md-6"><span class="xCNHeadMenuActive" onclick="JSxCallPagePermissionMain();">กลุ่มสิทธิ์</span><span class="xCNHeadMenu">  /  <?=$tRouteUrl?></span></div>
			<div class="col-lg-6 col-md-6"><button class="xCNButtonSave pull-right" onclick="JSxEventSaveorEdit('<?=$tRoute?>');">บันทึก</button></div>
		</div>

		<!--Section ล่าง-->
		<div class="card" style="margin-top: 10px;">
			<div class="card-body">
				<div class="row">
					<!--รูปภาพ-->
					<div class="col-lg-4 col-md-4">
						<!--ชื่อกลุ่มสิทธิ์-->
						<div class="form-group">
							<label>ชื่อกลุ่มสิทธิ์</label>
							<input type="text" class="form-control" maxlength="50" id="oetPermissionName" name="oetPermissionName" placeholder="กรุณาระบุชื่อกลุ่มสิทธิ์" autocomplete="off" value="<?=@$FTUsrTel;?>">
						</div>

						<!--หมายเหตุ-->
						<div class="form-group">
							<label>หมายเหตุ</label>
							<textarea type="text" class="form-control" id="oetPermissionReason" name="oetPermissionReason" placeholder="หมายเหตุ" rows="3"><?=@$FTUsrRmk;?></textarea>
						</div>
					</div>

					<!--รายละเอียด-->
					<div class="col-lg-6 col-md-6">
						<!--สิทธิ์การใช้งานระบบ-->
						<div class="form-group">
							<label>สิทธิ์การใช้งานระบบ</label>
							<table class="table table-striped xCNTableCenter">
							<thead>
								<tr>
									<th style="width:10px; text-align: left;">ลำดับ</th>
									<th style="text-align: left;">ชื่อเมนู</th>
									<th style="width:80px; text-align: center;">สร้าง</th>
									<th style="width:80px; text-align: center;">แก้ไข</th>
									<th style="width:80px; text-align: center;">ลบ</th>
									<th style="width:80px; text-align: center;">ยกเลิก</th>
									<th style="width:80px; text-align: center;">อนุมัติ</th>
									<th style="width:80px; text-align: center;">พิมพ์</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($aMenuAll['raItems'] AS $nKey => $aValue){ ?>
									<tr>	
										<?php 
											switch ($aValue['FTMenType']) {
												case "document":
													$tDisCreate = 'open';
													$tDisEdit 	= 'open';
													$tDisDelete = 'open';
													$tDisCancle = 'open';
													$tDisAprove = 'open';
													$tDisPrint 	= 'open';
													break;
												case "master":
													$tDisCreate = 'open';
													$tDisEdit 	= 'open';
													$tDisDelete = 'open';
													$tDisCancle = 'disabled';
													$tDisAprove = 'disabled';
													$tDisPrint 	= 'disabled';
													break;
												case "report":
													$tDisCreate = 'disabled';
													$tDisEdit 	= 'disabled';
													$tDisDelete = 'disabled';
													$tDisCancle = 'disabled';
													$tDisAprove = 'disabled';
													$tDisPrint 	= 'open';
													break;
												default:
											}
										?>

										<th><?=$nKey + 1 ?></th>
										<td><?=$aValue['FTMenName'];?></td>
										<td><label class="container-checkbox">
												<input type="checkbox" id="ocmUserStaUse" name="ocmUserStaUse" checked>
												<span class="checkmark"></span>
											</label>
										</td>
										<td><label class="container-checkbox">
												<input type="checkbox" id="ocmUserStaUse" name="ocmUserStaUse" checked>
												<span class="checkmark"></span>
											</label>
										</td>
										<td><label class="container-checkbox">
												<input type="checkbox" id="ocmUserStaUse" name="ocmUserStaUse" checked>
												<span class="checkmark"></span>
											</label>
										</td>
										<td><label class="container-checkbox">
												<input type="checkbox" id="ocmUserStaUse" name="ocmUserStaUse" checked>
												<span class="checkmark"></span>
											</label>
										</td>
										<td><label class="container-checkbox">
												<input type="checkbox" id="ocmUserStaUse" name="ocmUserStaUse" checked>
												<span class="checkmark"></span>
											</label>
										</td>
										<td><label class="container-checkbox">
												<input type="checkbox" id="ocmUserStaUse" name="ocmUserStaUse" checked>
												<span class="checkmark"></span>
											</label>
										</td>
									</tr>	
								<?php } ?>
							</tbody>
							</table>
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

		if($('#oetUserFirstname').val() == ''){
			$('#oetUserFirstname').focus();
			return;
		}

		if($('#oetUserLogin').val() == ''){
			$('#oetUserLogin').focus();
			return;
		}

		if($('#oetUserPassword').val() == ''){
			$('#oetUserPassword').focus();
			return;
		}

		$.ajax({
			type	: "POST",
			url		: ptRoute,
			data 	: $('#ofmUser').serialize(),
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				if(tResult == 'Duplicate'){
					$('.alert-danger').addClass('show').fadeIn();
					$('.alert-danger').find('.badge-danger').text('ผิดพลาด');
					$('.alert-danger').find('.xCNTextShow').text('ชื่อผู้ใช้นี้มีอยู่แล้วในระบบ กรุณาป้อนชื่อผู้ใช้งานใหม่อีกครั้ง');
					$('#oetUserLogin').val('');
					$('#oetUserLogin').focus();
					setTimeout(function(){
						$('.alert-danger').find('.close').click();
					}, 3000);
				}else if(tResult == 'pass_insert'){
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('ลงทะเบียนผู้ใช้สำเร็จ');
					JSxCallPageUserMain();
					setTimeout(function(){
						$('.alert-success').find('.close').click();
					}, 3000);
				}else if(tResult == 'pass_update'){
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('แก้ไขข้อมูลผู้ใช้สำเร็จ');
					JSxCallPageUserMain();
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
