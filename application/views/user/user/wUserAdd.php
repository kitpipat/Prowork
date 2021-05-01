<style>
	.custom-file-input ~ .custom-file-label::after {
		content: "เลือกไฟล์";
	}
</style>

<?php
	$tLevelUser = $this->session->userdata('tSesUserLevel');
	if($tTypePage == 'insert'){
		$tRoute 			= 'r_usereventinsert';
		$tRouteUrl			= 'สร้างผู้ใช้';
		$FNStaUse       	= 1;
	}else if($tTypePage == 'edit'){
		$FTUsrCode 			= $aResult[0]['FTUsrCode'];
		$FTBchCode			= $aResult[0]['FTBchCode'];
		$FTUsrFName			= $aResult[0]['FTUsrFName'];
		$FTUsrLName			= $aResult[0]['FTUsrLName'];
		$FTUsrDep			= $aResult[0]['FTUsrDep'];
		$FTUsrEmail			= $aResult[0]['FTUsrEmail'];
		$FTUsrTel			= $aResult[0]['FTUsrTel'];
		$FTUsrLogin			= $aResult[0]['FTUsrLogin'];
		$FTUsrPwd			= $aResult[0]['FTUsrPwd'];
		$FTUsrImgPath		= $aResult[0]['FTUsrImgPath'];
		$FTUsrRmk			= $aResult[0]['FTUsrRmk'];
		$FNRhdID			= $aResult[0]['FNRhdID'];
		$FTPriGrpID			= $aResult[0]['FTPriGrpID'];
		$FNStaUse			= $aResult[0]['FNStaUse'];
		$FNUsrGrp			= $aResult[0]['FNUsrGrp'];
		$FTUsrPathSignature = $aResult[0]['FTUsrPathSignature'];
		$tRoute 			= 'r_usereventedit';
		$tRouteUrl			= 'แก้ไขผู้ใช้';
	}
?>

<?php
	$aPermission = FCNaPERGetPermissionByPage('r_user');
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

	<form id="ofmUser" class="form-signin" method="post" action="javascript:void(0)">

		<input type="hidden" id="ohdUserCode" name="ohdUserCode" value="<?=@$FTUsrCode;?>">

		<!--Section บน-->
		<div class="row">
			<div class="col-lg-6 col-md-6"><span class="xCNHeadMenuActive" onclick="JSxCallPageUserMain();">ผู้ใช้</span><span class="xCNHeadMenu">  /  <?=$tRouteUrl?></span></div>

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
							if(@$FTUsrImgPath != '' || @$FTUsrImgPath != null){
								$tPathImage = './application/assets/images/user/'.@$FTUsrImgPath;
								if (file_exists($tPathImage)){
									$tPathImage = base_url().'application/assets/images/user/'.@$FTUsrImgPath;
								}else{
									$tPathImage = base_url().'application/assets/images/user/NoImage.png';
								}
							}else{
								$tPathImage = './application/assets/images/user/NoImage.png';
							}
						?>

						<img id="oimImgInsertorEditUser" class="img-responsive xCNImgCenter" src="<?=$tPathImage;?>">
						<input type="hidden" id="oetImgInsertorEditUser" name="oetImgInsertorEditUser" value="<?=@$FTUsrImgPath;?>">
						<button type="button" class="btn btn-outline-secondary xCNChooseImage" onclick="JSxUploadImageUser()">เลือกรูปภาพ</button>
						<input type="file" id="inputfileuploadImage" style="display:none"  name="inputfileuploadImage" accept="image/*" onchange="JSoImagUplodeResize(this,'images/user','ImgInsertorEditUser')">
					</div>

					<!--รายละเอียด-->
					<div class="col-lg-5 col-md-5">

						<!--ชื่อ-->
						<div class="form-group">
							<label><span style="color:red;">*</span> ชื่อ</label>
							<input type="text" class="form-control" maxlength="50" id="oetUserFirstname" name="oetUserFirstname" placeholder="กรุณาระบุชื่อ" autocomplete="off" value="<?=@$FTUsrFName;?>">
						</div>

						<!--นามสกุล-->
						<div class="form-group">
							<label>นามสกุล</label>
							<input type="text" class="form-control" maxlength="50" id="oetUserLastname" name="oetUserLastname" placeholder="กรุณาระบุนามสกุล" autocomplete="off" value="<?=@$FTUsrLName;?>">
						</div>

						<!--อีเมลล์-->
						<div class="form-group">
							<label>อีเมลล์</label>
							<input type="text" class="form-control" maxlength="100" id="oetUserEmail" name="oetUserEmail" placeholder="กรุณาระบุอีเมลล์" autocomplete="off" value="<?=@$FTUsrEmail;?>">
						</div>

						<!--เบอร์โทร-->
						<div class="form-group">
							<label>เบอร์โทรศัพท์</label>
							<input type="text" class="form-control" maxlength="50" id="oetUserTelphone" name="oetUserTelphone" placeholder="กรุณาระบุเบอร์โทรศัพท์" autocomplete="off" value="<?=@$FTUsrTel;?>">
						</div>

						<!--หมายเหตุ-->
						<div class="form-group">
							<label>หมายเหตุ</label>
							<textarea type="text" class="form-control" id="oetUserReason" name="oetUserReason" placeholder="หมายเหตุ" rows="3"><?=@$FTUsrRmk;?></textarea>
						</div>

						<!--แผนก-->
						<div class="form-group">
							<label>แผนก</label>
							<input type="text" class="form-control" id="oetUserDepartment" name="oetUserDepartment" placeholder="กรุณาระบุแผนก" autocomplete="off" value="<?=@$FTUsrDep;?>">
						</div>


						<!--กลุ่มของผู้ใช้จะมองเห็นเฉพาะ แอดมิน-->
						<div class="form-group">
							<label><span style="color:red;">*</span>ตำแหน่ง</label>
							<?php if($tLevelUser == 'HQ'){ ?>
								<select class="form-control" id="oetUserGrp" name="oetUserGrp">
									<option <?=(@$FNUsrGrp == 1)? "selected" : "";?> value="1">พนักงานจัดซื้อ</option>
									<option <?=(@$FNUsrGrp == 2)? "selected" : "";?> value="2">พนักงานขาย</option>
									<option <?=(@$FNUsrGrp == 5)? "selected" : "";?> value="5">พนักงานบัญชี</option>
									<option <?=(@$FNUsrGrp == 3)? "selected" : "";?> value="3">ผู้จัดการ</option>
									<option <?=(@$FNUsrGrp == 4)? "selected" : "";?> value="4">เจ้าของกิจการ</option>
								</select>
							<?php }else{ ?>
								<input type="text" class="form-control" id="oetUserGrpName" name="oetUserGrpName" autocomplete="off" value="พนักงานขาย" readonly>
								<input type="hidden" class="form-control" id="oetUserGrp" name="oetUserGrp" autocomplete="off" value="2">
							<?php } ?>
						</div>

						<!--กลุ่มราคา-->
						<div class="form-group">
							<label><span style="color:red;">*</span> กลุ่มราคา</label>
							<select class="form-control" id="oetUserPriGrp" name="oetUserPriGrp">
								<?php foreach($aPriGrp['raItems'] AS $nKey => $aValue){ ?>
									<option <?=(@$FTPriGrpID == $aValue['FTPriGrpID'])? "selected" : "";?> value="<?=$aValue['FTPriGrpID'];?>"><?=$aValue['FTPriGrpName'];?></option>
								<?php } ?>
							</select>
						</div>

						<div><hr></div>

						<!--ชื่อผู้ใช้งาน-->
						<div class="form-group">
							<label><span style="color:red;">*</span> ชื่อผู้ใช้งาน</label>
							<input type="text" class="form-control" maxlength="20" id="oetUserLogin" name="oetUserLogin" placeholder="กรุณาระบุชื่อผู้ใช้งาน" autocomplete="off" value="<?=@$FTUsrLogin;?>">
						</div>

						<!--หมายเหตุ-->
						<div class="form-group">
							<label><span style="color:red;">*</span> รหัสผ่าน</label>
							<input type="password" class="form-control" maxlength="225" id="oetUserPassword" name="oetUserPassword" placeholder="*********" autocomplete="off"  value="<?=@$FTUsrPwd;?>">
						</div>

						<!--สาขา-->
						<?php if($tLevelUser == 'HQ'){ ?>
							<div class="form-group">
								<label><span style="color:red;">*</span> สาขา</label>
								<select class="form-control" id="oetUserBCH" name="oetUserBCH">
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
								<input type="hidden" id="oetUserBCH" name="oetUserBCH" value="<?=@$tBCHCode?>" autocomplete="off">
							</div>
						<?php } ?>

						<!--กลุ่มสิทธิ์-->
						<div class="form-group">
							<label><span style="color:red;">*</span> กลุ่มสิทธิ์</label>
							<select class="form-control" id="oetUserPermission" name="oetUserPermission">
								<?php foreach($aPermissionList['raItems'] AS $nKey => $aValue){ ?>
									<option <?=(@$FNRhdID == $aValue['FNRhdID'])? "selected" : "";?> value="<?=$aValue['FNRhdID'];?>"><?=$aValue['FTRhdName'];?></option>
								<?php } ?>
							</select>
						</div>

						<!--อัพโหลดรูปภาพ-->
						<div class="form-group">
							<label>รูปภาพลายเซ็นดิจิตอล</label>
							<div id="odvModalCrop" class="form-group custom-file">
								<input type="file" class="custom-file-input" onchange="JSoImagUplodeAndCrop(this, 16 / 9 , 'images/user')" id="inputfile" name="inputfile" accept="image/*">
								<input type="hidden" class="form-control" id="hiddenvalue_signature" name="hiddenvalue_signature" value="<?=@$FTUsrPathSignature; ?>">
								<label class="custom-file-label" for="inputfile" >เลือกไฟล์รูปภาพ</label>
							</div>
						</div>

						<label class="container-checkbox">ใช้งาน
							<input type="checkbox" id="ocmUserStaUse" name="ocmUserStaUse" <?=@$FNStaUse == '1' ? 'checked' : ''; ?>>
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

	if('<?=$tTypePage?>' == 'edit'){
		$('.custom-file-label').html('<?=@$FTUsrPathSignature?>');
	}

	//อัพโหลดรูปภาพ
	function JSxUploadImageUser(){
		$('#inputfileuploadImage').click();
	}

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
					$('.alert-success').find('.xCNTextShow').text('สร้างบัญชีผู้ใช้สำเร็จ');
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

	//กด ผู้ใช้(กลับหน้า main)
	function JSxCallPageUserMain(){
		JSxModalProgress('open');
		$.ajax({
			type	: "POST",
			url		: "r_user",
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				JSxModalProgress('close');
				$('.content').html(tResult);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert(jqXHR, textStatus, errorThrown);
			}
		});
	}

	//image upload
	function JSoImagUplodeAndCrop(poImg,ptRetio,ptPath,paOption = ''){
		var oImgData = poImg.files[0];
		var oImgFrom = new FormData();
		oImgFrom.append('file',oImgData);
		oImgFrom.append('path', ptPath);
		
		$.ajax({
			type 		: "POST",
			url 		: "ImageUpload_andcrop",
			cache 		: false,
			contentType	: false,
			processData	: false,
			data 		: oImgFrom,
			datatype	: "JSON",
			success: function (tResult){
				if(tResult!=""){
					JSxImagCroup(tResult,ptRetio,ptPath,paOption);

					var fileName = poImg.files[0].name;
        			$('.custom-file-label').html(fileName);
				}
			},
			error: function (data){
				console.log(data);
			}
		})
	}

	//image crop
	function JSxImagCroup(poImgData,ptRetion,ptPath,paOption = ''){
		var aImgData = JSON.parse(poImgData);
		if(aImgData.tImgBase64 != ""){
			$('#odvModalCrop')
			.append('<div class="modal fade" id="oModalCropper" aria-labelledby="modalLabel" role="dialog" tabindex="-1">'
					+ '<div class="modal-dialog" role="document" style="z-index:2000; margin-top: 60px;">'
					+ '<div class="modal-content"> <div class="modal-header" style="padding-bottom:10px;"> '
					+ '<h5 class="modal-title" id="modalLabel" style="margin:0px 0px 0px 0px; float:left;">ตัดรูปภาพ (ใช้ลูกลิ้งเมาส์ในการซูมเข้าซูมออก)</h5>'
					+ '<button id="oModalCropperdelete" type="button" class="close" data-dismiss="modal" aria-label="Close" style="float:right; margin: 0px -10px 0px 0px;">'
					+ '<span aria-hidden="true" style="color: #FFF;">&times;</span> </button> </div> <div class="modal-body"> <div> <img id="oImageCropper" style="max-width: 60%;" src="'
					+ aImgData.tImgBase64 + '" alt="Picture"> </div> </div> <div class="modal-footer"> '
					+ '<div class="row" style="margin: 0px; width: 100%;">'
					+ '<div class="col-lg-9">'
					+ '<span style="font-size: 18px;">คำแนะนำ : รูปภาพควรเป็น .png , พื้นหลังโปร่ง , transparent</span>'
					+ '</div>'
					+ '<div class="col-lg-3" style="padding-right: 0px;">'
					+ '<button type="button" class="btn btn-outline-primary pull-right xWBtnCropImage" title="Crop"> <span> ครอบภาพ </span> </button> '
					+ '</div> </div> </div> </div>');
		}
		setTimeout(function(){
			$('#oModalCropper').modal({backdrop: 'static',keyboard: false});
			$('#oModalCropper').modal("show");
			var $image 	= $('#oImageCropper');
			var $button = $('.xWBtnCropImage');
			
			var cropBoxData;
			var canvasData;
			$('#oModalCropper').on('shown.bs.modal', function() {
				$image.cropper({
					width 			: 215,
					height 			: 130,
					viewMode 		: 1,
					dragMode 		: 'move',
					autoCropArea 	: 0.7,
					restore 		: false,
					guides 			: false,
					highlight 		: false,
					cropBoxMovable 	: false,
					cropBoxResizable : false,
					aspectRatio : ptRetion,
					ready : function(){
						$image.cropper('setCanvasData', canvasData);
						$image.cropper('setCropBoxData', cropBoxData);
					}
				});
			}).on('hidden.bs.modal', function(){
				cropBoxData = $image.cropper('getCropBoxData');
				canvasData = $image.cropper('getCanvasData');
				$image.cropper('destroy');
				$('#oModalCropper').remove();
			});

			$button.on('click', function(){
				var croppedCanvas;
				var roundedCanvas;
				croppedCanvas = $image.cropper('getCroppedCanvas');
				roundedCanvas = croppedCanvas.toDataURL();
				$.ajax({
					type 	: "POST",
					url		: "ImageCropper",
					cache 	: false,
					data	:	{
						'tBase64'	: roundedCanvas,
						'tImgName'	: aImgData.tImgName,
						'tImgtype'	: aImgData.tImgType,
						'tImgPath'	: aImgData.tImgFullPath
					} ,
					success: function(tResult){
						if(tResult!=""){
							var aResult		= JSON.parse(tResult);
							var tBaseurl	= aResult.rtBaseurl;
							var	tImgName	= aResult.rtImgName;

							// $('#'+paOption[1]).attr("src",'<?=base_url();?>'+'application/assets/'+ptPath+'/'+tImgName);
							$('#inputfile').val('');
							$('#hiddenvalue_signature').val('/'+tImgName);
							$('#oModalCropper').modal("hide");	
						}
					},
					error: function(data){
						console.log(data);
					}
				});
			});

			$('#oModalCropperdelete').click(function(){
				$('.custom-file-label').html('เลือกไฟล์รูปภาพ');
				$('#inputfile').val('');
				$('#hiddenvalue_signature').val('');
			});
		},500);
	}
</script>
