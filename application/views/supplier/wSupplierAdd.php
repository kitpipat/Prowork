<?php
	$tLevelUser = $this->session->userdata('tSesUserLevel');
	if($tTypePage == 'insert'){
		$tRoute 		= 'r_suppliereventinsert';
		$tRouteUrl		= 'สร้างผู้จำหน่าย';
		$FNStaUse       = 1;
		$FTSplStaActive = 1;
	}else if($tTypePage == 'edit'){
		$FTSplCode 		= $aResult[0]['FTSplCode'];
		$FTSplName		= $aResult[0]['FTSplName'];
		$FTSplContact	= $aResult[0]['FTSplContact'];
		$FTSplTel		= $aResult[0]['FTSplTel'];
		$FTSplFax		= $aResult[0]['FTSplFax'];
		$FTSplEmail		= $aResult[0]['FTSplEmail'];
		$FNSplVat		= $aResult[0]['FNSplVat'];
		$FTSplVatType	= $aResult[0]['FTSplVatType'];
		$FTSplReason	= $aResult[0]['FTSplReason'];
		$FTSplPathImg	= $aResult[0]['FTSplPathImg'];
		$FTSplAddress	= $aResult[0]['FTSplAddress'];
		$FTSplStaActive	= $aResult[0]['FTSplStaActive'];
		$tRoute 		= 'r_suppliereventedit';
		$tRouteUrl		= 'แก้ไขผู้จำหน่าย';
	}
?>

<?php
	$aPermission = FCNaPERGetPermissionByPage('r_supplier');
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
	
	<form id="ofmSupplier" class="form-signin" method="post" action="javascript:void(0)">

		<input type="hidden" id="ohdSupplierCode" name="ohdSupplierCode" value="<?=@$FTSplCode;?>">

		<!--Section บน-->
		<div class="row">
			<div class="col-lg-6 col-md-6"><span class="xCNHeadMenuActive" onclick="JSxCallPageSupplierMain();">ผู้จำหน่าย</span><span class="xCNHeadMenu">  /  <?=$tRouteUrl?></span></div>
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
							if(@$FTSplPathImg != '' || @$FTSplPathImg != null){
								$tPathImage = './application/assets/images/supplier/'.@$FTSplPathImg;
								if (file_exists($tPathImage)){
									$tPathImage = base_url().'application/assets/images/supplier/'.@$FTSplPathImg;
								}else{
									$tPathImage = base_url().'application/assets/images/supplier/NoImage.png';
								}
							}else{
								$tPathImage = './application/assets/images/supplier/NoImage.png';
							}
						?>

						<img id="oimImgInsertorEditsupplier" class="img-responsive xCNImgCenter" src="<?=$tPathImage;?>">
						<input type="hidden" id="oetImgInsertorEditsupplier" name="oetImgInsertorEditsupplier" value="<?=@$FTSplPathImg;?>">
						<button type="button" class="btn btn-outline-secondary xCNChooseImage" onclick="JSxUploadImagesupplier()">เลือกรูปภาพ</button>
						<input type="file" id="inputfileuploadImage" style="display:none"  name="inputfileuploadImage" accept="image/*" onchange="JSoImagUplodeResize(this,'images/supplier','ImgInsertorEditsupplier')">
					</div>

					<!--รายละเอียด-->
					<div class="col-lg-5 col-md-5">

						<!--รหัส-->
						<div class="form-group">
							<label><span style="color:red;">*</span> รหัสผู้จำหน่าย</label>
							<input <?=($tTypePage == 'edit') ? 'disabled' : '' ?> type="text" class="form-control" maxlength="5" id="oetCodeSupplier" name="oetCodeSupplier" placeholder="กรุณาระบุรหัสผู้จำหน่าย" autocomplete="off" value="<?=@$FTSplCode;?>">
							<span id="oetCodeSupplier_Dup" style="color:red; text-align: right; display: none;"><em>พบรหัสผู้จำหน่ายซ้ำ กรุณาลองใหม่อีกครั้ง</em></span>
						</div>
							
						<!--ชื่อผู้จำหน่าย-->
						<div class="form-group">
							<label><span style="color:red;">*</span> ชื่อผู้จำหน่าย</label>
							<input type="text" class="form-control" maxlength="255" id="oetSupplierName" name="oetSupplierName" placeholder="กรุณาระบุชื่อผู้จำหน่าย" autocomplete="off" value="<?=@$FTSplName;?>">
						</div>

						<!--ผู้ติดต่อ-->
						<div class="form-group">
							<label>ผู้ติดต่อ</label>
							<input type="text" class="form-control" maxlength="255" id="oetSupplierContact" name="oetSupplierContact" placeholder="กรุณาระบุชื่อผู้ติดต่อ" autocomplete="off" value="<?=@$FTSplContact;?>">
						</div>

						<!--โทรศัพท์-->
						<div class="form-group">
							<label>โทรศัพท์</label>
							<input type="text" class="form-control xCNInputNumericWithDecimal" maxlength="50" id="oetSupplierTel" name="oetSupplierTel" placeholder="กรุณาระบุหมายเลขโทรศัพท์" autocomplete="off" value="<?=@$FTSplTel;?>">
						</div>

						<!--โทรสาร-->
						<div class="form-group">
							<label>โทรสาร</label>
							<input type="text" class="form-control xCNInputNumericWithDecimal" maxlength="50" id="oetSupplierTelNumber" name="oetSupplierTelNumber" placeholder="กรุณาระบุหมายเลขโทรสาร" autocomplete="off" value="<?=@$FTSplFax;?>">
						</div>

						<!--อีเมลล์-->
						<div class="form-group">
							<label>อีเมลล์</label>
							<input type="text" class="form-control" maxlength="50" id="oetSupplierEmail" name="oetSupplierEmail" placeholder="กรุณาระบุอีเมลล์" autocomplete="off" value="<?=@$FTSplEmail;?>">
						</div>

						<!--อัตราภาษี-->
						<div class="form-group">
							<label><span style="color:red;">*</span> อัตราภาษี (%)</label>
							<input type="text" class="form-control xCNInputNumericWithDecimal" style="text-align: right;" maxlength="3" id="oetSupplierVat" name="oetSupplierVat" placeholder="กรุณาระบุอัตราภาษี (%)" autocomplete="off" value="<?=@$FNSplVat;?>">
						</div>

						<!--ภาษีมูลค่าเพิ่ม-->
						<div class="form-group">
							<label><span style="color:red;">*</span> ภาษีมูลค่าเพิ่ม</label>
							<select class="form-control" id="oetSupplierVatType" name="oetSupplierVatType">
									<option <?=(@$FTSplVatType == 1)? "selected" : "";?> value="1">ภาษีรวมใน</option>
									<option <?=(@$FTSplVatType == 2)? "selected" : "";?> value="2">ภาษีแยกนอก</option>
							</select>
						</div>

						<!--หมายเหตุ-->
						<div class="form-group">
							<label>หมายเหตุ</label>
							<textarea type="text" class="form-control" id="oetSupplierReason" name="oetSupplierReason" placeholder="หมายเหตุ" rows="3"><?=@$FTSplReason;?></textarea>
						</div>

						<!--ที่อยู่-->
						<div class="form-group">
							<label>ที่อยู่</label>
							<textarea type="text" class="form-control" id="oetSupplierAddress" name="oetSupplierAddress" placeholder="ที่อยู่" rows="3"><?=@$FTSplAddress;?></textarea>
						</div>

						<!--สถานะการติดต่อ-->
						<label class="container-checkbox">ใช้งาน
							<input type="checkbox" id="ocmSupplierStaUse" name="ocmSupplierStaUse" <?=@$FTSplStaActive == '1' ? 'checked' : ''; ?>>
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

	$( document ).ready(function() {

		//เมื่อกด ข้อความ dup ต้องหาย
		$('#oetCodeSupplier').click(function() {
			$('#oetCodeSupplier_Dup').css('display','none');
		});

		//ห้ามคีย์เกิน 100
		$('#oetSupplierVat').change(function(e) {
			var tSUPVat = $(this).val();
			if(tSUPVat > 100){
				$(this).val(100);
			}
		});		

		//ถ้าเข้ามาแบบแก้ไข แต่ ไม่มีสิทธิ์ในการแก้ไข
		if('<?=$tTypePage?>' == 'edit' && '<?=$tPer_edit?>' != ''){
			$('.form-control').attr('disabled',true);
			$('.xCNChooseImage').hide();
		}			
	});

	//อัพโหลดรูปภาพ
	function JSxUploadImagesupplier(){
		$('#inputfileuploadImage').click(); 
	}

	//อีเวนท์บันทึกข้อมูล
	function JSxEventSaveorEdit(ptRoute){

		if($('#oetCodeSupplier').val() == ''){
			$('#oetCodeSupplier').focus();
			return;
		}

		if($('#oetSupplierName').val() == ''){
			$('#oetSupplierName').focus();
			return;
		}

		if($('#oetSupplierVat').val() == ''){
			$('#oetSupplierVat').focus();
			return;
		}

		$.ajax({
			type	: "POST",
			url		: ptRoute,
			data 	: $('#ofmSupplier').serialize(),
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				if(tResult == 'pass_insert'){
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('ลงทะเบียนผู้จำหน่ายสำเร็จ');
					JSxCallPageSupplierMain();
					setTimeout(function(){
						$('.alert-success').find('.close').click();
					}, 3000);
				}else if(tResult == 'pass_update'){
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('แก้ไขข้อมูลผู้จำหน่ายสำเร็จ');
					JSxCallPageSupplierMain();
					setTimeout(function(){
						$('.alert-success').find('.close').click();
					}, 3000);
				}else if(tResult == 'duplicate'){
					$('#oetCodeSupplier_Dup').css('display','block');
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				JSxModalErrorCenter(jqXHR.responseText);
			}
		});
	}
</script>
