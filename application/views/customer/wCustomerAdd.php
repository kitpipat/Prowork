<?php
	$tLevelUser = $this->session->userdata('tSesUserLevel');
	if($tTypePage == 'insert'){
		$tRoute 			= 'r_customereventinsert';
		$tRouteUrl			= 'สร้างลูกค้า';
		$FTCstStaActive     = 1;
	}else if($tTypePage == 'edit'){
		$FTBchCode			= $aResult[0]['FTBchCode'];
		$FTCstCode			= $aResult[0]['FTCstCode'];
		$FTCstName			= $aResult[0]['FTCstName'];
		$FTCstContactName	= $aResult[0]['FTCstContactName'];
		$FTCstCardID		= $aResult[0]['FTCstCardID'];
		$FTCstTaxNo			= $aResult[0]['FTCstTaxNo'];
		$FTCstSex			= $aResult[0]['FTCstSex'];
		$FDCstDob			= date('Y/m/d',strtotime($aResult[0]['FDCstDob']));
		$FTCstAddress		= $aResult[0]['FTCstAddress'];
		$FTCstTel			= $aResult[0]['FTCstTel'];
		$FTCstFax			= $aResult[0]['FTCstFax'];
		$FTCstEmail			= $aResult[0]['FTCstEmail'];
		$FNCstPostCode		= $aResult[0]['FNCstPostCode'];
		$FTCstWebSite		= $aResult[0]['FTCstWebSite'];
		$FTCstReason		= $aResult[0]['FTCstReason'];
		$FTCstPathImg		= $aResult[0]['FTCstPathImg'];
		$FTCstStaActive		= $aResult[0]['FTCstStaActive'];
		$tRoute 			= 'r_customereventedit';
		$tRouteUrl			= 'แก้ไขลูกค้า';
	}
?>

<?php
	$aPermission = FCNaPERGetPermissionByPage('r_customer');
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
	
	<form id="ofmCutomer" class="form-signin" method="post" action="javascript:void(0)">

		<input type="hidden" id="ohdCustomerCode" name="ohdCustomerCode" value="<?=@$FTCstCode;?>">

		<!--Section บน-->
		<div class="row">
			<div class="col-lg-6 col-md-6"><span class="xCNHeadMenuActive" onclick="JSxCallPageCustomerMain();">ลูกค้า</span><span class="xCNHeadMenu">  /  <?=$tRouteUrl?></span></div>
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
							if(@$FTCstPathImg != '' || @$FTCstPathImg != null){
								$tPathImage = './application/assets/images/customer/'.@$FTCstPathImg;
								if (file_exists($tPathImage)){
									$tPathImage = base_url().'application/assets/images/customer/'.@$FTCstPathImg;
								}else{
									$tPathImage = base_url().'application/assets/images/customer/NoImage.png';
								}
							}else{
								$tPathImage = './application/assets/images/customer/NoImage.png';
							}
						?>

						<img id="oimImgInsertorEditCustomer" class="img-responsive xCNImgCenter" src="<?=$tPathImage;?>">
						<input type="hidden" id="oetImgInsertorEditCustomer" name="oetImgInsertorEditCustomer" value="<?=@$FTCstPathImg;?>">
						<button type="button" class="btn btn-outline-secondary xCNChooseImage" onclick="JSxUploadImageCustomer()">เลือกรูปภาพ</button>
						<input type="file" id="inputfileuploadImage" style="display:none"  name="inputfileuploadImage" accept="image/*" onchange="JSoImagUplodeResize(this,'images/customer','ImgInsertorEditCustomer')">
					</div>

					<!--รายละเอียด-->
					<div class="col-lg-5 col-md-5">
						<!--สาขา-->
						<?php if($tLevelUser == 'HQ'){ ?>
							<div class="form-group">
								<label><span style="color:red;">*</span> สาขา</label>
								<select class="form-control" id="oetCUSBCH" name="oetCUSBCH">
									<option value="0">สำนักงานใหญ่</option>
									<?php foreach($aBCHList['raItems'] AS $nKey => $aValue){ ?>
										<option <?=(@$FTBchCode == $aValue['FTBchCode'])? "selected" : "";?> value="<?=$aValue['FTBchCode'];?>"><?=$aValue['FTBchName'];?> - (<?=$aValue['FTCmpName'];?>)</option>
									<?php } ?>
								</select>
							</div>
						<?php }else{ ?>
							<div class="form-group">
								<?php $tBCHName = $this->session->userdata('tSesBCHName'); ?>
								<?php $tBCHCode = $this->session->userdata('tSesBCHCode'); ?>
								<label><span style="color:red;">*</span> สาขา</label>
								<input type="text" class="form-control" value="<?=@$tBCHName?>" autocomplete="off" readonly>
								<input type="hidden" id="oetCUSBCH" name="oetCUSBCH" value="<?=@$tBCHCode?>" autocomplete="off">
							</div>
						<?php } ?>

						<!--ชื่อลูกค้า / ชื่อบริษัท-->
						<div class="form-group">
							<label><span style="color:red;">*</span> ชื่อลูกค้า / ชื่อบริษัท</label>
							<input type="text" class="form-control" maxlength="225" id="oetCUSName" name="oetCUSName" placeholder="กรุณาระบุชื่อลูกค้า / ชื่อบริษัท" autocomplete="off" value="<?=@$FTCstName;?>">
						</div>

						<!--หมายเลขประจำตัวผู้เสียภาษี-->
						<div class="form-group">
							<label><span style="color:red;">*</span> หมายเลขประจำตัวผู้เสียภาษี</label>
							<input type="text" class="form-control xCNInputNumericWithDecimal" maxlength="225" id="oetCUSTaxNo" name="oetCUSTaxNo" placeholder="กรุณาระบุหมายเลขประจำตัวผู้เสียภาษี" autocomplete="off" value="<?=@$FTCstTaxNo;?>">
						</div>

						<!--ชื่อผู้ติดต่อ-->
						<div class="form-group">
							<label> ชื่อผู้ติดต่อ</label>
							<input type="text" class="form-control" maxlength="225" id="oetCUSContactname" name="oetCUSContactname" placeholder="กรุณาระบุชื่อผู้ติดต่อ" autocomplete="off" value="<?=@$FTCstContactName;?>">
						</div>

						<!--เพศ-->
						<div class="form-group">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="ordRadioOptions" id="ordRadioMale" value="1" checked>
								<label class="form-check-label" for="ordRadioMale">ชาย</label>
							</div>

							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="ordRadioOptions" id="ordRadioFeMale" value="2">
								<label class="form-check-label" for="ordRadioFeMale">หญิง</label>
							</div>
						</div>

						<!--วันเกิด-->
						<div class="form-group">
							<label>วันเกิด</label>
							<input type="text" class="form-control" maxlength="10" id="oetCUSDob" name="oetCUSDob" placeholder="กรุณาระบุวันเกิด 2020/12/31" autocomplete="off" value="<?=@$FDCstDob;?>">
						</div>

						<!--บัตรประชาชน-->
						<div class="form-group">
							<label><span style="color:red;">*</span> หมายเลขบัตรประชาชน</label>
							<input type="text" class="form-control xCNInputNumericWithDecimal" maxlength="20" id="oetCUSCardID" name="oetCUSCardID" placeholder="กรุณาระบุหมายเลขบัตรประชาชน" autocomplete="off" value="<?=@$FTCstCardID;?>">
						</div>

						<!--ที่อยู่-->
						<div class="form-group">
							<label>ที่อยู่</label>
							<textarea type="text" class="form-control" id="oetCUSAddress" name="oetCUSAddress" placeholder="ที่อยู่" rows="3"><?=@$FTCstAddress;?></textarea>
						</div>

						<!--รหัสไปรษณีย์-->
						<div class="form-group">
							<label>รหัสไปรษณีย์</label>
							<input type="text" class="form-control" maxlength="5" id="oetCUSPostCode" name="oetCUSPostCode" placeholder="กรุณาระบุรหัสไปรษณีย์" autocomplete="off" value="<?=@$FNCstPostCode;?>">
						</div>

						<!--โทรศัพท์-->
						<div class="form-group">
							<label>โทรศัพท์</label>
							<input type="text" class="form-control xCNInputNumericWithDecimal" maxlength="20" id="oetCUSTelphone" name="oetCUSTelphone" placeholder="กรุณาระบุเบอร์โทรศัพท์" autocomplete="off" value="<?=@$FTCstTel;?>">
						</div>

						<!--โทรสาร-->
						<div class="form-group">
							<label>เบอร์โทรสาร</label>
							<input type="text" class="form-control xCNInputNumericWithDecimal" maxlength="20" id="oetCUSTelnumber" name="oetCUSTelnumber" placeholder="กรุณาระบุเบอร์โทรสาร" autocomplete="off" value="<?=@$FTCstFax;?>">
						</div>

						<!--อีเมลล์-->
						<div class="form-group">
							<label>อีเมลล์</label>
							<input type="text" class="form-control" maxlength="255" id="oetCUSEmail" name="oetCUSEmail" placeholder="กรุณาระบุอีเมลล์" autocomplete="off" value="<?=@$FTCstEmail;?>">
						</div>

						<!--เว็บไซต์-->
						<div class="form-group">
							<label>เว็บไซต์</label>
							<input type="text" class="form-control" maxlength="255" id="oetCUSWebsite" name="oetCUSWebsite" placeholder="กรุณาระบุเว็บไซต์" autocomplete="off" value="<?=@$FTCstWebSite;?>">
						</div>

						<!--หมายเหตุ-->
						<div class="form-group">
							<label>หมายเหตุ</label>
							<textarea type="text" class="form-control" id="oetCUSReason" name="oetCUSReason" placeholder="หมายเหตุ" rows="3"><?=@$FTCstReason;?></textarea>
						</div>

						<!--ใช้งาน-->
						<label class="container-checkbox">ใช้งาน
							<input type="checkbox" id="ocmCUSStaUse" name="ocmCUSStaUse" <?=@$FTCstStaActive == '1' ? 'checked' : ''; ?>>
							<span class="checkmark"></span>
						</label>

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

	//อัพโหลดรูปภาพ
	function JSxUploadImageCustomer(){
		$('#inputfileuploadImage').click(); 
	}

	//อีเวนท์บันทึกข้อมูล
	function JSxEventSaveorEdit(ptRoute){

		if($('#oetCUSName').val() == ''){
			$('#oetCUSName').focus();
			return;
		}

		if($('#oetCUSTaxNo').val() == ''){
			$('#oetCUSTaxNo').focus();
			return;
		}

		if($('#oetCUSCardID').val() == ''){
			$('#oetCUSCardID').focus();
			return;
		}


		$.ajax({
			type	: "POST",
			url		: ptRoute,
			data 	: $('#ofmCutomer').serialize(),
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				console.log(tResult);
				if(tResult == 'pass_insert'){
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('ลงทะเบียนลูกค้าสำเร็จ');
					JSxCallPageCustomerMain();
					setTimeout(function(){
						$('.alert-success').find('.close').click();
					}, 3000);
				}else if(tResult == 'pass_update'){
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('แก้ไขข้อมูลลูกค้าสำเร็จ');
					JSxCallPageCustomerMain();
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
