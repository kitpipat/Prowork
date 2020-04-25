<?php
	$tLevelUser = $this->session->userdata('tSesUserLevel');
	if($tTypePage == 'insert'){
		$tRoute 		= 'r_permissioneventinsert';
		$tRouteUrl		= 'สร้างกลุ่มสิทธิ์';
	}else if($tTypePage == 'edit'){
		$FNRhdID		= $aResult[0]['FNRhdID'];
		$FTRhdName		= $aResult[0]['FTRhdName'];
		$FTRhdRmk		= $aResult[0]['FTRhdRmk'];
		$tRoute 		= 'r_permissioneventedit';
		$tRouteUrl		= 'แก้ไขกลุ่มสิทธิ์';
	}
?>

<?php
	$aPermission = FCNaPERGetPermissionByPage('r_permission');
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
	
	<form id="ofmPermission" method="post" action="javascript:void(0)">

		<input type="hidden" id="ohdPermissionCode" name="ohdPermissionCode" value="<?=@$FNRhdID;?>">

		<!--Section บน-->
		<div class="row">
			<div class="col-lg-6 col-md-6"><span class="xCNHeadMenuActive" onclick="JSxCallPagePermissionMain();">กลุ่มสิทธิ์</span><span class="xCNHeadMenu">  /  <?=$tRouteUrl?></span></div>
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
					<!--รูปภาพ-->
					<div class="col-lg-4 col-md-4">
						<!--ชื่อกลุ่มสิทธิ์-->
						<div class="form-group">
							<label>ชื่อกลุ่มสิทธิ์</label>
							<input type="text" class="form-control" maxlength="50" id="oetPermissionName" name="oetPermissionName" placeholder="กรุณาระบุชื่อกลุ่มสิทธิ์" autocomplete="off" value="<?=@$FTRhdName;?>">
						</div>

						<!--หมายเหตุ-->
						<div class="form-group">
							<label>หมายเหตุ</label>
							<textarea type="text" class="form-control" id="oetPermissionReason" name="oetPermissionReason" placeholder="หมายเหตุ" rows="3"><?=@$FTRhdRmk;?></textarea>
						</div>
					</div>

					<!--รายละเอียด-->
					<div class="col-lg-8 col-md-8">
						<!--สิทธิ์การใช้งานระบบ-->
						<div class="form-group">
							<label>สิทธิ์การใช้งานระบบ</label>
							<label class="container-checkbox pull-right" style="display: inline;">เลือกทั้งหมด
								<input type="checkbox" id="ocmPermission_All" name="ocmPermission_All" <?=($tTypePage == 'insert') ? 'checked' : '' ?>>
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
														$tTextShowGrp 	= 'ข้อมูลหลัก';
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
													<input type="checkbox" name="ocmPermission_Read<?=$aValue['FNMenID']?>" class="xCNOCMPer xCNOCM<?=$tDisRead?>" 			<?=$tTypePage == 'insert' && $tDisRead == 'open' ? 'checked' :(@$aResult[$nKey]['FTRdtAlwRead'] == '1') ? 'checked' : $tDisRead;?>>
													<span class="checkmark  xCNButtonCheckbox<?=$tDisRead?>"></span>
												</label>
											</td>
											<td><label class="container-checkbox">
													<input type="checkbox" name="ocmPermission_Create<?=$aValue['FNMenID']?>" class="xCNOCMPer xCNOCM<?=$tDisCreate?>" 		<?=$tTypePage == 'insert' && $tDisCreate == 'open' ? 'checked' :(@$aResult[$nKey]['FTRdtAlwCreate'] == '1') ? 'checked' : $tDisCreate;?>>
													<span class="checkmark xCNButtonCheckbox<?=$tDisCreate?>"></span>
												</label>
											</td>
											<td><label class="container-checkbox">
													<input type="checkbox"  name="ocmPermission_Edit<?=$aValue['FNMenID']?>" class="xCNOCMPer xCNOCM<?=$tDisEdit?>"	 		<?=$tTypePage == 'insert' && $tDisEdit == 'open' ? 'checked' : (@$aResult[$nKey]['FTRdtAlwEdit'] == '1') ? 'checked' : $tDisEdit;?>>
													<span class="checkmark xCNButtonCheckbox<?=$tDisEdit?>"></span>
												</label>
											</td>
											<td><label class="container-checkbox">
													<input type="checkbox" name="ocmPermission_Delete<?=$aValue['FNMenID']?>" class="xCNOCMPer xCNOCM<?=$tDisDelete?>" 		<?=$tTypePage == 'insert' && $tDisDelete == 'open' ? 'checked' : (@$aResult[$nKey]['FTRdtAlwDel'] == '1') ? 'checked' : $tDisDelete;?>>
													<span class="checkmark xCNButtonCheckbox<?=$tDisDelete?>"></span>
												</label>
											</td>
											<td><label class="container-checkbox">
													<input type="checkbox"  name="ocmPermission_Cancle<?=$aValue['FNMenID']?>" class="xCNOCMPer xCNOCM<?=$tDisCancle?>" 	<?=$tTypePage == 'insert' && $tDisCancle == 'open' ? 'checked' :(@$aResult[$nKey]['FTRdtAlwCancel'] == '1') ? 'checked' : $tDisCancle;?>>
													<span class="checkmark xCNButtonCheckbox<?=$tDisCancle?>"></span>
												</label>
											</td>
											<td><label class="container-checkbox">
													<input type="checkbox" name="ocmPermission_Approve<?=$aValue['FNMenID']?>" class="xCNOCMPer xCNOCM<?=$tDisAprove?>" 	<?=$tTypePage == 'insert' && $tDisAprove == 'open' ? 'checked' :(@$aResult[$nKey]['FTRdtAlwApv'] == '1') ? 'checked' : $tDisAprove;?>>
													<span class="checkmark xCNButtonCheckbox<?=$tDisAprove?>"></span>
												</label>
											</td>
											<td><label class="container-checkbox">
													<input type="checkbox"  name="ocmPermission_Print<?=$aValue['FNMenID']?>"  class="xCNOCMPer xCNOCM<?=$tDisPrint?>" 		<?=$tTypePage == 'insert' && $tDisPrint == 'open' ? 'checked' :(@$aResult[$nKey]['FTRdtAlwPrint'] == '1') ? 'checked' : $tDisPrint;?>>
													<span class="checkmark xCNButtonCheckbox<?=$tDisPrint?>"></span>
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

	//ถ้าเข้ามาแบบแก้ไข แต่ ไม่มีสิทธิ์ในการแก้ไข
	if('<?=$tTypePage?>' == 'edit' && '<?=$tPer_edit?>' != ''){
		$('.form-control').attr('disabled',true);
		$('.xCNChooseImage').hide();
	}

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
				'read' 		: ($('input[name=ocmPermission_Read'+nCodemenu+']:checked').val() == 'on') ? 1 : 0,
				'create' 	: ($('input[name=ocmPermission_Create'+nCodemenu+']:checked').val()  == 'on') ? 1 : 0,
				'edit' 		: ($('input[name=ocmPermission_Edit'+nCodemenu+']:checked').val()  == 'on') ? 1 : 0,
				'delete' 	: ($('input[name=ocmPermission_Delete'+nCodemenu+']:checked').val() == 'on') ? 1 : 0,
				'cancle' 	: ($('input[name=ocmPermission_Cancle'+nCodemenu+']:checked').val() == 'on') ? 1 : 0,
				'approve' 	: ($('input[name=ocmPermission_Approve'+nCodemenu+']:checked').val() == 'on') ? 1 : 0,
				'print' 	: ($('input[name=ocmPermission_Print'+nCodemenu+']:checked').val() == 'on') ? 1 : 0,
			}
			aMenu.push(tMenu);
		});

		$.ajax({
			type	: "POST",
			url		: ptRoute,
			data 	: {
					'nRoleID' 		: $('#ohdPermissionCode').val(),
					'tRoleName' 	: $('#oetPermissionName').val(),
					'tRoleReason' 	: $('#oetPermissionReason').val(),
					'aMenu' 		: aMenu
				},
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				if(tResult == 'pass_insert'){
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('เพิ่มข้อมูลกลุ่มสิทธิ์สำเร็จ');
					JSxCallPagePermissionMain();
					setTimeout(function(){
						$('.alert-success').find('.close').click();
					}, 3000);
				}else if(tResult == 'pass_update'){
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('แก้ไขข้อมูลกลุ่มสิทธิ์สำเร็จ');
					JSxCallPagePermissionMain();
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
