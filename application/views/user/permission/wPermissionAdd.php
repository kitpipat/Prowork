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
					<div class="col-lg-8 col-md-8">
						<!--สิทธิ์การใช้งานระบบ-->
						<div class="form-group">
							<label>สิทธิ์การใช้งานระบบ</label>
							<label class="container-checkbox pull-right" style="display: inline;">เลือกทั้งหมด
								<input type="checkbox" id="ocmPermission_All" name="ocmPermission_All" checked>
								<span class="checkmark"></span>
							</label>

							<table class="table table-striped xCNTableCenter" id="otbMenuValue">
								<thead>
									<tr>
										<th style="width:10px; text-align: left;">ลำดับ</th>
										<th style="text-align: left;">ชื่อเมนู</th>
										<th style="width:80px; text-align: center;">อ่าน</th>
										<th style="width:80px; text-align: center;">สร้าง</th>
										<th style="width:80px; text-align: center;">แก้ไข</th>
										<th style="width:80px; text-align: center;">ลบ</th>
										<th style="width:80px; text-align: center;">ยกเลิก</th>
										<th style="width:80px; text-align: center;">อนุมัติ</th>
										<th style="width:80px; text-align: center;">พิมพ์</th>
									</tr>
								</thead>
								<tbody>
									<?php $tGroupOld = '';?>
									<?php foreach($aMenuAll['raItems'] AS $nKey => $aValue){ ?>

										<?php if($tGroupOld != $aValue['FTMenType']){  ?>
											<?php switch ($aValue['FTMenType']) {
													case "document":
														$tTextShowGrp 	= 'เอกสาร';
														break;
													case "master":
														$tTextShowGrp 	= 'ทั่วไป';
														break;
													case "report":
														$tTextShowGrp 	= 'รายงาน';
														break;
													default:
												} 
											?>
											<tr class="xCNTableGroupMenu"><th colspan="99"><?=$tTextShowGrp?></th></tr>
										<?php } ?>

										<tr class="xCNMenuValue" data-menucode="<?=$aValue['FNMenID']?>">	
											<?php 
												switch ($aValue['FTMenType']) {
													case "document":
														$tDisRead 	= 'open';
														$tDisCreate = 'open';
														$tDisEdit 	= 'open';
														$tDisDelete = 'open';
														$tDisCancle = 'open';
														$tDisAprove = 'open';
														$tDisPrint 	= 'open';
														break;
													case "master":
														$tDisRead 	= 'open';
														$tDisCreate = 'open';
														$tDisEdit 	= 'open';
														$tDisDelete = 'open';
														$tDisCancle = 'disabled';
														$tDisAprove = 'disabled';
														$tDisPrint 	= 'disabled';
														break;
													case "report":
														$tDisRead 	= 'open';
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
													<input type="checkbox" name="ocmPermission_Read<?=$aValue['FNMenID']?>" class="xCNOCMPer xCNOCM<?=$tDisRead?>" <?=$tDisRead == 'open' ? 'checked' : $tDisRead; ?> >
													<span class="checkmark"></span>
												</label>
											</td>
											<td><label class="container-checkbox">
													<input type="checkbox" name="ocmPermission_Create<?=$aValue['FNMenID']?>" class="xCNOCMPer xCNOCM<?=$tDisCreate?>" <?=$tDisCreate == 'open' ? 'checked' : $tDisCreate; ?> >
													<span class="checkmark"></span>
												</label>
											</td>
											<td><label class="container-checkbox">
													<input type="checkbox"  name="ocmPermission_Edit<?=$aValue['FNMenID']?>" class="xCNOCMPer xCNOCM<?=$tDisEdit?>" <?=$tDisEdit == 'open' ? 'checked' : $tDisEdit; ?>>
													<span class="checkmark"></span>
												</label>
											</td>
											<td><label class="container-checkbox">
													<input type="checkbox" name="ocmPermission_Delete<?=$aValue['FNMenID']?>" class="xCNOCMPer xCNOCM<?=$tDisDelete?>"<?=$tDisDelete == 'open' ? 'checked' : $tDisDelete; ?>>
													<span class="checkmark"></span>
												</label>
											</td>
											<td><label class="container-checkbox">
													<input type="checkbox"  name="ocmPermission_Cancle<?=$aValue['FNMenID']?>" class="xCNOCMPer xCNOCM<?=$tDisCancle?>" <?=$tDisCancle == 'open' ? 'checked' : $tDisCancle; ?>>
													<span class="checkmark"></span>
												</label>
											</td>
											<td><label class="container-checkbox">
													<input type="checkbox" name="ocmPermission_Approve<?=$aValue['FNMenID']?>" class="xCNOCMPer xCNOCM<?=$tDisAprove?>" <?=$tDisAprove == 'open' ? 'checked' : $tDisAprove; ?>>
													<span class="checkmark"></span>
												</label>
											</td>
											<td><label class="container-checkbox">
													<input type="checkbox"  name="ocmPermission_Print<?=$aValue['FNMenID']?>"  class="xCNOCMPer xCNOCM<?=$tDisPrint?>" <?=$tDisPrint?> <?=$tDisPrint == 'open' ? 'checked' : ''; ?>>
													<span class="checkmark"></span>
												</label>
											</td>
										</tr>	
									<?php $tGroupOld = $aValue['FTMenType']; ?> 
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

	//เลือกทั้งหมด
	$('#ocmPermission_All').on('click',function(){
		$('.xCNOCMopen').prop('checked', this.checked);
	});

	//เลือก checkbox
	$('.xCNOCMPer').on('click',function(){
		var nCheckAll = $('.xCNOCMopen').length;
		var nUnCheck  = $('.xCNOCMopen:checked').length;
		if(nCheckAll == nUnCheck){
			$('#ocmPermission_All').prop('checked',true);
		}else{
			$('#ocmPermission_All').prop('checked',false);
		}
	});

	//อีเวนท์บันทึกข้อมูล
	function JSxEventSaveorEdit(ptRoute){

		if($('#oetPermissionName').val() == ''){
			$('#oetPermissionName').focus();
			return;
		}


		var aMenu = [];
		$('#otbMenuValue > tbody > .xCNMenuValue').each(function(){
			var nCodemenu 	= $(this).data('menucode');
			var tMenu = {
				'menu' 		: nCodemenu,
				'read' 		: $('input[name=ocmPermission_Read'+nCodemenu+']:checked').val(),
				'create' 	: $('input[name=ocmPermission_Create'+nCodemenu+']:checked').val(),
				'edit' 		: $('input[name=ocmPermission_Edit'+nCodemenu+']:checked').val(),
				'delete' 	: $('input[name=ocmPermission_Delete'+nCodemenu+']:checked').val(),
				'cancle' 	: $('input[name=ocmPermission_Cancle'+nCodemenu+']:checked').val(),
				'approve' 	: $('input[name=ocmPermission_Approve'+nCodemenu+']:checked').val(),
				'print' 	: $('input[name=ocmPermission_Print'+nCodemenu+']:checked').val()
			}
			aMenu.push(tMenu);
		});

		console.log(aMenu);

		// $('#otbMenuValue > tbody .xCNMenuValue').each(function(){
		// 	var t = $(this);
		// 	console.log(t);
		// });


		// $.ajax({
		// 	type	: "POST",
		// 	url		: ptRoute,
		// 	data 	: $('#ofmPermission').serialize(),
		// 	cache	: false,
		// 	timeout	: 0,
		// 	success	: function (tResult) {
		// 		console.log(tResult);
		// 		// if(tResult == 'Duplicate'){
		// 		// 	$('.alert-danger').addClass('show').fadeIn();
		// 		// 	$('.alert-danger').find('.badge-danger').text('ผิดพลาด');
		// 		// 	$('.alert-danger').find('.xCNTextShow').text('ชื่อผู้ใช้นี้มีอยู่แล้วในระบบ กรุณาป้อนชื่อผู้ใช้งานใหม่อีกครั้ง');
		// 		// 	$('#oetUserLogin').val('');
		// 		// 	$('#oetUserLogin').focus();
		// 		// 	setTimeout(function(){
		// 		// 		$('.alert-danger').find('.close').click();
		// 		// 	}, 3000);
		// 		// }else if(tResult == 'pass_insert'){
		// 		// 	$('.alert-success').addClass('show').fadeIn();
		// 		// 	$('.alert-success').find('.badge-success').text('สำเร็จ');
		// 		// 	$('.alert-success').find('.xCNTextShow').text('ลงทะเบียนผู้ใช้สำเร็จ');
		// 		// 	JSxCallPagePermissionMain();
		// 		// 	setTimeout(function(){
		// 		// 		$('.alert-success').find('.close').click();
		// 		// 	}, 3000);
		// 		// }else if(tResult == 'pass_update'){
		// 		// 	$('.alert-success').addClass('show').fadeIn();
		// 		// 	$('.alert-success').find('.badge-success').text('สำเร็จ');
		// 		// 	$('.alert-success').find('.xCNTextShow').text('แก้ไขข้อมูลผู้ใช้สำเร็จ');
		// 		// 	JSxCallPagePermissionMain();
		// 		// 	setTimeout(function(){
		// 		// 		$('.alert-success').find('.close').click();
		// 		// 	}, 3000);
		// 		// }
		// 	},
		// 	error: function (jqXHR, textStatus, errorThrown) {
		// 		alert(jqXHR, textStatus, errorThrown);
		// 	}
		// });
	}

</script>