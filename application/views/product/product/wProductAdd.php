<?php
	$tLevelUser = $this->session->userdata('tSesUserLevel');
	if($tTypePage == 'insert'){
		$tRoute 			= 'r_producteventinsert';
		$tRouteUrl			= 'สร้างสินค้า';
		$FTPdtStatus       	= 1;
		$FCPdtCostStd		= 0;
		$FTPdtCostDis		= 0;
		$FCPdtSalPrice		= 0;
	}else if($tTypePage == 'edit'){
		$FTPdtCode			= $aResult[0]['FTPdtCode'];
		$FTBchCode 			= $aResult[0]['FTBchCode'];
		$FTPdtName 			= $aResult[0]['FTPdtName'];
		$FTPdtNameOth 		= $aResult[0]['FTPdtNameOth'];
		$FTPdtDesc 			= $aResult[0]['FTPdtDesc'];
		$FTPunCode 			= $aResult[0]['FTPunCode'];
		$FTPgpCode 			= $aResult[0]['FTPgpCode'];
		$FTPtyCode 			= $aResult[0]['FTPtyCode'];
		$FTPbnCode 			= $aResult[0]['FTPbnCode'];
		$FTPzeCode 			= $aResult[0]['FTPzeCode'];
		$FTPClrCode 		= $aResult[0]['FTPClrCode'];
		$FTSplCode 			= $aResult[0]['FTSplCode'];
		$FTMolCode 			= $aResult[0]['FTMolCode'];
		$FCPdtCostStd	 	= $aResult[0]['FCPdtCostStd'];
		$FTPdtCostDis 		= $aResult[0]['FTPdtCostDis'];
		$FCPdtSalPrice 		= $aResult[0]['FCPdtSalPrice'];
		$FTPdtImage 		= $aResult[0]['FTPdtImage'];
		$FTPdtStatus		= $aResult[0]['FTPdtStatus'];
		$FTPdtReason		= $aResult[0]['FTPdtReason'];
		$FDCreateOn			= date('d/m/Y',strtotime($aResult[0]['FDCreateOn']));
		$FDUpdateOn			= date('d/m/Y',strtotime($aResult[0]['FDUpdateOn']));
		$tRoute 			= 'r_producteventedit';
		$tRouteUrl			= 'แก้ไขสินค้า';
	}
?>

<?php
	$aPermission = FCNaPERGetPermissionByPage('r_product');
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
	
	<form id="ofmProduct" class="form-signin" method="post" action="javascript:void(0)">

		<input type="hidden" id="ohdProductCode" name="ohdProductCode" value="<?=@$FTPdtCode;?>">

		<!--Section บน-->
		<div class="row">
			<div class="col-lg-6 col-md-6"><span class="xCNHeadMenuActive" onclick="JSxCallPageProductMain();">สินค้า</span><span class="xCNHeadMenu">  /  <?=$tRouteUrl?></span></div>
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
						<?php 
							if(@$FTPdtImage != '' || @$FTPdtImage != null){
								$tPathImage = './application/assets/images/products/'.@$FTPdtImage;
								if (file_exists($tPathImage)){
									$tPathImage = base_url().'application/assets/images/products/'.@$FTPdtImage;
								}else{
									$tPathImage = base_url().'application/assets/images/products/NoImage.png';
								}
							}else{
								$tPathImage = './application/assets/images/products/NoImage.png';
							}
						?>

						<img id="oimImgInsertorEditproducts" class="img-responsive xCNImgCenter" src="<?=$tPathImage;?>">
						<input type="hidden" id="oetImgInsertorEditproducts" name="oetImgInsertorEditproducts" value="<?=@$FTPdtImage;?>">
						<button type="button" class="btn btn-outline-secondary xCNChooseImage" onclick="JSxUploadImageproducts()">เลือกรูปภาพ</button>
						<input type="file" id="inputfileuploadImage" style="display:none"  name="inputfileuploadImage" accept="image/*" onchange="JSoImagUplodeResize(this,'images/products','ImgInsertorEditproducts')">
					</div>

					<!--รายละเอียด-->
					<div class="col-lg-5 col-md-5">

						<?php if($tTypePage == 'insert'){ ?>
							<div style="display: block; text-align: right;"><span> วันที่สร้างข้อมูล : <?=date('d/m/Y')?> </span></div>
						<?php }else{ ?>
							<div style="display: block; text-align: right;"><span> วันที่สร้างข้อมูล : <?=@$FDCreateOn?> </span> <span> ปรับปรุงล่าสุด : <?=@$FDUpdateOn?> </span></div>
						<?php } ?>

						
						<!--รหัสสินค้า-->
						<div class="form-group">
							<label><span style="color:red;">*</span> รหัสสินค้า</label>
							<input type="text" class="form-control" maxlength="50" id="oetPDTCode" name="oetPDTCode" placeholder="กรุณาระบุรหัสสินค้า" autocomplete="off" value="<?=@$FTPdtCode;?>"  <?=($tTypePage != 'insert') ? 'readonly' : '' ?> >
						</div>

						<!--ชื่อสินค้า-->
						<div class="form-group">
							<label><span style="color:red;">*</span> ชื่อสินค้า</label>
							<input type="text" class="form-control" maxlength="255" id="oetPDTName" name="oetPDTName" placeholder="กรุณาระบุชื่อสินค้า" autocomplete="off" value="<?=@$FTPdtName;?>">
						</div>

						<!--ชื่ออื่น-->
						<div class="form-group">
							<label>ชื่ออื่น</label>
							<input type="text" class="form-control" maxlength="255" id="oetPDTNameOther" name="oetPDTNameOther" placeholder="กรุณาระบุชื่อสินค้าอื่น" autocomplete="off" value="<?=@$FTPdtNameOth;?>">
						</div>

						<!--รายละเอียด-->
						<div class="form-group">
							<label>รายละเอียด</label>
							<textarea type="text" class="form-control" id="oetPDTDetail" name="oetPDTDetail" placeholder="รายละเอียด" rows="3"><?=@$FTPdtDesc;?></textarea>
						</div>

						<!--สถานะการติดต่อ-->
						<label class="container-checkbox">สถานะการใช้งาน
							<input type="checkbox" id="ocmPDTStaUse" name="ocmPDTStaUse" <?=@$FTPdtStatus == '1' ? 'checked' : ''; ?>>
							<span class="checkmark"></span>
						</label>
					</div>
				</div>
			</div>
		</div>


		<!--Section ล่าง-->
		<div class="row">

			<!--ข้อมูลอื่นๆ-->
			<div class="col-lg-6">
				<div class="card">
					<div class="card-body" style="padding-bottom: 65px;">
						<div class="row">
							<div class="col-lg-12">
								<div class="xCNHeadFooterINPDT"><span> ข้อมูลอื่นๆ </span></div>
							</div>

							<div class="col-lg-6">

								<!--ยี่ห้อ-->
								<div class="form-group">
									<label>ยี่ห้อ</label>
									<select class="form-control" id="oetPDTBrand" name="oetPDTBrand">
										<option selected disabled>กรุณาเลือกข้อมูล</option>
										<?php if($aFilter_Brand['rtCode'] == 800){ ?>
											<option value="0">ไม่ระบุข้อมูล</option>	
										<?php }else{ ?> 
											<option value="0">ไม่ระบุข้อมูล</option>	
											<?php foreach($aFilter_Brand['raItems'] AS $nKey => $aValue){ ?>
												<option <?=(@$FTPbnCode == $aValue['FTPbnCode'])? "selected" : "";?> value="<?=$aValue['FTPbnCode'];?>"><?=$aValue['FTPbnName'];?></option>
											<?php } ?>
										<?php } ?>
									</select>
								</div>

							</div>

							<div class="col-lg-6">
								<!--สี-->
								<div class="form-group">
									<label>สี</label>
									<select class="form-control" id="oetPDTColor" name="oetPDTColor">
										<option selected disabled>กรุณาเลือกข้อมูล</option>
										<?php if($aFilter_Color['rtCode'] == 800){ ?>
											<option value="0">ไม่ระบุข้อมูล</option>
										<?php }else{ ?> 
											<option value="0">ไม่ระบุข้อมูล</option>
											<?php foreach($aFilter_Color['raItems'] AS $nKey => $aValue){ ?>
												<option <?=(@$FTPClrCode == $aValue['FTPClrCode'])? "selected" : "";?> value="<?=$aValue['FTPClrCode'];?>"><?=$aValue['FTPClrName'];?></option>
											<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>
											
							<div class="col-lg-6">
								<!--กลุ่ม-->
								<div class="form-group">
									<label>กลุ่มสินค้า</label>
									<select class="form-control" id="oetPDTGroup" name="oetPDTGroup">
										<option selected disabled>กรุณาเลือกข้อมูล</option>
										<?php if($aFilter_Group['rtCode'] == 800){ ?>
											<option value="0">ไม่ระบุข้อมูล</option>
										<?php }else{ ?> 
											<option value="0">ไม่ระบุข้อมูล</option>
											<?php foreach($aFilter_Group['raItems'] AS $nKey => $aValue){ ?>
												<option <?=(@$FTPgpCode == $aValue['FTPgpCode'])? "selected" : "";?> value="<?=$aValue['FTPgpCode'];?>"><?=$aValue['FTPgpName'];?></option>
											<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>

							<div class="col-lg-6">
								<!--รุ่น-->
								<div class="form-group">
									<label>รุ่น</label>
									<select class="form-control" id="oetPDTModal" name="oetPDTModal">
										<option selected disabled>กรุณาเลือกข้อมูล</option>
										<?php if($aFilter_Modal['rtCode'] == 800){ ?>
											<option value="0">ไม่ระบุข้อมูล</option>
										<?php }else{ ?> 
											<option value="0">ไม่ระบุข้อมูล</option>
											<?php foreach($aFilter_Modal['raItems'] AS $nKey => $aValue){ ?>
												<option <?=(@$FTMolCode == $aValue['FTMolCode'])? "selected" : "";?> value="<?=$aValue['FTMolCode'];?>"><?=$aValue['FTMolName'];?></option>
											<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>

							<div class="col-lg-6">
								<!--ขนาด-->
								<div class="form-group">
									<label>ขนาด</label>
									<select class="form-control" id="oetPDTSize" name="oetPDTSize">
										<option selected disabled>กรุณาเลือกข้อมูล</option>
										<?php if($aFilter_Size['rtCode'] == 800){ ?>
											<option value="0">ไม่ระบุข้อมูล</option>
										<?php }else{ ?> 
											<option value="0">ไม่ระบุข้อมูล</option>
											<?php foreach($aFilter_Size['raItems'] AS $nKey => $aValue){ ?>
												<option <?=(@$FTPzeCode == $aValue['FTPzeCode'])? "selected" : "";?> value="<?=$aValue['FTPzeCode'];?>"><?=$aValue['FTPzeName'];?></option>
											<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>

							<div class="col-lg-6">
								<!--หน่วย-->
								<div class="form-group">
									<label>หน่วย</label>
									<select class="form-control" id="oetPDTPunCode" name="oetPDTPunCode">
										<option selected disabled>กรุณาเลือกข้อมูล</option>
										<?php if($aFilter_Unit['rtCode'] == 800){ ?>
											<option value="0">ไม่ระบุข้อมูล</option>
										<?php }else{ ?> 
											<option value="0">ไม่ระบุข้อมูล</option>
											<?php foreach($aFilter_Unit['raItems'] AS $nKey => $aValue){ ?>
												<option <?=(@$FTPunCode == $aValue['FTPunCode'])? "selected" : "";?> value="<?=$aValue['FTPunCode'];?>"><?=$aValue['FTPunName'];?></option>
											<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>

							<div class="col-lg-6">
								<!--ประเภท-->
								<div class="form-group">
									<label>ประเภท</label>
									<select class="form-control" id="oetPDTType" name="oetPDTType">
										<option selected disabled>กรุณาเลือกข้อมูล</option>
										<?php if($aFilter_Type['rtCode'] == 800){ ?>
											<option value="0">ไม่ระบุข้อมูล</option>
										<?php }else{ ?> 
											<option value="0">ไม่ระบุข้อมูล</option>
											<?php foreach($aFilter_Type['raItems'] AS $nKey => $aValue){ ?>
												<option <?=(@$FTPtyCode == $aValue['FTPtyCode'])? "selected" : "";?> value="<?=$aValue['FTPtyCode'];?>"><?=$aValue['FTPtyName'];?></option>
											<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>

			<div class="col-lg-6">
				<div class="row">
					<!--ต้นทุนสินค้า และราคาขาย-->
					<div class="col-lg-12">
						<div class="card">
							<div class="card-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="xCNHeadFooterINPDT"><span> ต้นทุนสินค้า และราคาขาย </span></div>
									</div>
									<div class="col-lg-12">

										<!--ผู้จำหน่าย-->
										<div class="form-group">
											<label>ผู้จำหน่าย</label>
											<select class="form-control" id="oetPDTSPL" name="oetPDTSPL">
												<option selected disabled>กรุณาเลือกข้อมูล</option>
												<?php if($aFilter_Spl['rtCode'] == 800){ ?>
													<option value="0">ไม่ระบุข้อมูล</option>
												<?php }else{ ?> 
													<option value="0">ไม่ระบุข้อมูล</option>
													<?php foreach($aFilter_Spl['raItems'] AS $nKey => $aValue){ ?>
														<option <?=(@$FTSplCode == $aValue['FTSplCode'])? "selected" : "";?> value="<?=$aValue['FTSplCode'];?>"><?=$aValue['FTSplName'];?></option>
													<?php } ?>
												<?php } ?>
											</select>
										</div>			
														
										<div class="row">
											<div class="col-lg-12"> 
												<!--ต้นทุนมาตราฐาน-->
												<div class="form-group">
													<label><span style="color:red;">*</span> ต้นทุนมาตราฐาน</label>
													<input type="text" class="form-control xCNInputNumericWithDecimal text-right" maxlength="50" id="oetPDTCost" name="oetPDTCost" placeholder="0.00" autocomplete="off" value="<?=@$FCPdtCostStd?>">
												</div>
											</div>

											<div class="col-lg-6" style="display:block;"> 
												<!--ส่วนลดต้นทุน %-->
												<div class="form-group">
													<label>ส่วนลดต้นทุน </label>
													<input type="text" class="form-control text-right xCNNumberandPercent" readonly maxlength="50" id="oetPDTCostPercent" name="oetPDTCostPercent" placeholder="10%,20,30" autocomplete="off" value="<?=($nDiscountCost == 'x') ? $FTPdtCostDis : $nDiscountCost?>">
												</div>
											</div>

											<div class="col-lg-6"  style="display:block;"> 
												<!--ขายบวกเพิ่มจากต้นทุน %-->
												<div class="form-group">
													<label> ขายบวกเพิ่มจากต้นทุน (%)</label>
													<input type="text" class="form-control xCNInputNumericWithDecimal text-right" readonly maxlength="5" id="oetPDTPriceSellPercent" name="oetPDTPriceSellPercent" placeholder="0 - 100" autocomplete="off" value="<?=($nAddPri == 'x') ? $FCPdtSalPrice : $nAddPri?>%">
												</div>
											</div>
										</div>
										
									</div>

								</div>
							</div>
						</div>
					</div>

					<!--หมายเหตุ-->
					<div class="col-lg-12">
						<div class="card">
							<div class="card-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="xCNHeadFooterINPDT"><span> หมายเหตุ </span></div>
									</div>
									<div class="col-lg-12">
										<!--หมายเหตุ-->
										<div class="form-group" style="margin-bottom: 0.75rem;">
											<label>หมายเหตุ</label>
											<textarea type="text" class="form-control" id="oetPDTReason" name="oetPDTReason" placeholder="หมายเหตุ" rows="2"><?=@$FTPdtReason;?></textarea>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>

	</form>
<div>

<script src="<?= base_url('application/assets/js/jFormValidate.js')?>"></script>
<script>

	$( document ).ready(function() {
		//ถ้าเข้ามาแบบแก้ไข แต่ ไม่มีสิทธิ์ในการแก้ไข
		if('<?=$tTypePage?>' == 'edit' && '<?=$tPer_edit?>' != ''){
			$('.form-control').attr('disabled',true);
			$('.xCNChooseImage').hide();
		}	
	});

	//อัพโหลดรูปภาพ
	function JSxUploadImageproducts(){
		$('#inputfileuploadImage').click(); 
	}

	//อีเวนท์บันทึกข้อมูล
	function JSxEventSaveorEdit(ptRoute){

		if($('#oetPDTCode').val() == ''){
			$('#oetPDTCode').focus();
			return;
		}

		if($('#oetPDTName').val() == ''){
			$('#oetPDTName').focus();
			return;
		}

		if($('#oetPDTCost').val() == ''){
			$('#oetPDTCost').focus();
			return;
		}

		$.ajax({
			type	: "POST",
			url		: ptRoute,
			data 	: $('#ofmProduct').serialize(),
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				if(tResult == 'Duplicate'){
					$('.alert-danger').addClass('show').fadeIn();
					$('.alert-danger').find('.badge-danger').text('ผิดพลาด');
					$('.alert-danger').find('.xCNTextShow').text('รหัสสินค้านี้มีอยู่แล้วในระบบ กรุณาใส่ชื่อรหัสสินค้าใหม่อีกครั้ง');
					$('#oetPDTCode').val('');
					$('#oetPDTCode').focus();
					setTimeout(function(){
						$('.alert-danger').find('.close').click();
					}, 3000);
				}else if(tResult == 'pass_insert'){
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('ลงทะเบียนสินค้าสำเร็จ');
					JSxCallPageProductMain();
					setTimeout(function(){
						$('.alert-success').find('.close').click();
					}, 3000);
				}else if(tResult == 'pass_update'){
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('แก้ไขข้อมูลสินค้าสำเร็จ');
					JSxCallPageProductMain();
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
