<?php
	$tLevelUser = $this->session->userdata('tSesUserLevel');
	if($tTypePage == 'insert'){
		$tRoute 			= 'r_groupproducteventinsert';
		$tRouteUrl			= 'สร้างกลุ่มสินค้า';
		$FNStaUse       	= 1;
	}else if($tTypePage == 'edit'){
		$FTPgpCode 			= $aResult[0]['FTPgpCode'];
		$FTPgpName			= $aResult[0]['FTPgpName'];
		$FTPbnCode			= $aResult[0]['FTPbnCode'];
		$FTPbnName			= $aResult[0]['FTPbnName'];
		$tRoute 			= 'r_groupproducteventedit';
		$tRouteUrl			= 'แก้ไขกลุ่มสินค้า';
	}
?>

<style>
	.nav-link{
		padding: 10px 20px !important;
		font-family: cordia;
		font-size: 20px !important;
	}

</style>

<?php
	$aPermission = FCNaPERGetPermissionByPage('r_groupproduct');
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
	
	<form id="ofmGroupProduct" class="form-signin" method="post" action="javascript:void(0)">

		<input type="hidden" id="ohdGroupProductCode" name="ohdGroupProductCode" value="<?=@$FTPgpCode;?>">

		<!--Section บน-->
		<div class="row">
			<div class="col-lg-6 col-md-6"><span class="xCNHeadMenuActive" onclick="JSxCallPageGroupProductMain();">กลุ่มสินค้า</span><span class="xCNHeadMenu">  /  <?=$tRouteUrl?></span></div>
			
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

					<div class="col-lg-12 col-md-12">
						<ul class="nav nav-tabs" id="myTab" role="tablist">
							<li class="nav-item" role="presentation">
								<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">ข้อมูลกลุ่มสินค้า</a>
							</li>
							<?php 
								if($tTypePage == 'edit'){
									$tDisabledBrand = '';
								}else if($tTypePage == 'insert'){ 
									$tDisabledBrand = 'disabled';
								}
							?>
							
							<li class="nav-item" role="presentation">
								<a class="nav-link <?=$tDisabledBrand?>" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">ข้อมูลยี่ห้อของกลุ่มสินค้า</a>
							</li>
						</ul>
						<div class="tab-content">

							<!--ข้อมูลกลุ่มสินค้า-->
							<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
								<div class="row">
									<div class="col-lg-4 col-md-4" style="margin-top:20px;">
										<!--รหัส-->
										<div class="form-group">
											<label><span style="color:red;">*</span> รหัสกลุ่มสินค้า</label>
											<input <?=($tTypePage == 'edit') ? 'disabled' : '' ?> type="text" class="form-control" maxlength="5" id="oetCodeGRPName" name="oetCodeGRPName" placeholder="กรุณาระบุรหัสกลุ่มสินค้า" autocomplete="off" value="<?=@$FTPgpCode;?>">
											<span id="oetCodeGRPName_Dup" style="color:red; text-align: right; display: none;"><em>พบรหัสกลุ่มสินค้าซ้ำ กรุณาลองใหม่อีกครั้ง</em></span>
										</div>

										<!--ชื่อกลุ่มสินค้า-->
										<div class="form-group">
											<label>ชื่อกลุ่มสินค้า</label>
											<input type="text" class="form-control" maxlength="100" id="oetGRPName" name="oetGRPName" placeholder="กรุณาระบุชื่อกลุ่มสินค้า" autocomplete="off" value="<?=@$FTPgpName;?>">
										</div>
									</div>
								</div>
							
							</div>

							<!--ข้อมูลยี่ห้อ-->
							<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
								<div class="row" style="margin-top:20px;">
									<div class="col-lg-6 col-md-6"><lable>กลุ่มสินค้า : <?=@$FTPgpName;?></lable></div> 
									<div class="col-lg-6 col-md-6 <?=$tPer_create?>"><button class="xCNButtonInsert pull-right" onClick="JSxSelectBrandInGroupClick('add','');">+</button></div>
									<div class="col-lg-12 col-md-12">
										<div id="odvContent_BrandInGroup" class="xCNContent"></div>
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

<!-- Modal ให้เลือกยี่ห้อ -->
<button id="obtModalSelectAttribute" style="display:none;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#odvModalBrand"></button>
<div class="modal fade" id="odvModalBrand" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<h5 class="modal-title">เลือกยี่ห้อสินค้า</h5>
					</div>
					<div class="col-lg-6 col-md-6"></div>
				</div>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<div class="input-group md-form form-sm form-2 pl-0">
							<input class="form-control my-0 py-1 red-border xCNFormSerach" autocomplete="off" type="text" placeholder="กรุณากรอกคำที่ต้องการค้นหา" id="oetSearchAttribute" onkeypress="Javascript:if(event.keyCode==13) JSxSelectAttribute(1)">
							<div class="input-group-append">
								<span class="input-group-text red lighten-3" style="cursor:pointer;" onclick="JSxSelectBrandInGroup(1);">
									<?php $tMenuBar = base_url().'application/assets/images/icon/search.png'; ?>
									<img class="menu-icon xCNMenuSearch" src="<?=$tMenuBar?>">
								</span>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6">
						<button type="button" class="btn btn-secondary xCNCloseDelete" data-dismiss="modal" style="width: 60px;float: right;margin-left: 10px;">ปิด</button>
						<input type="hidden" id="ohdInsOrUpdateBrandInGroup" name="ohdInsOrUpdateBrandInGroup">
						<input type="hidden" id="ohdInsOrUpdateBrandInGroupValue" name="ohdInsOrUpdateBrandInGroupValue">
						<button type="button" class="btn  btn-success xCNConfirmCustomer" onclick="JSxConfirmBrandInGroup();" style="float: right;">ยืนยัน</button>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12 col-md-12">
						<div id="odvContentPopUpBrand" style="margin-top:10px;"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="<?= base_url('application/assets/js/jFormValidate.js')?>"></script>
<script>

	//เมื่อกด ข้อความ dup ต้องหาย
	$('#oetCodeGRPName').click(function() {
		$('#oetCodeGRPName_Dup').css('display','none');
	});

	//ถ้าเข้ามาแบบแก้ไข แต่ ไม่มีสิทธิ์ในการแก้ไข
	if('<?=$tTypePage?>' == 'edit' && '<?=$tPer_edit?>' != ''){
		$('.form-control').attr('disabled',true);
	}

	//อีเวนท์บันทึกข้อมูล
	function JSxEventSaveorEdit(ptRoute){

		if($('#oetCodeGRPName').val() == ''){
			$('#oetCodeGRPName').focus();
			return;
		}

		if($('#oetGRPName').val() == ''){
			$('#oetGRPName').focus();
			return;
		}

		$.ajax({
			type	: "POST",
			url		: ptRoute,
			data 	: $('#ofmGroupProduct').serialize(),
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				if(tResult == 'pass_insert'){
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('ลงทะเบียนกลุ่มสินค้าสำเร็จ');
					JSxCallPageGroupProductMain();
					setTimeout(function(){
						$('.alert-success').find('.close').click();
					}, 3000);
				}else if(tResult == 'pass_update'){
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('แก้ไขข้อมูลกลุ่มสินค้าสำเร็จ');
					JSxCallPageGroupProductMain();
					setTimeout(function(){
						$('.alert-success').find('.close').click();
					}, 3000);
				}else if(tResult == 'duplicate'){
					$('#oetCodeGRPName_Dup').css('display','block');
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				JSxModalErrorCenter(jqXHR.responseText);
			}
		});
	}

	//กดปุ่ม brwose ยี่ห้อ
	function JSxSelectBrandInGroupClick(ptType,pnValue){
		$('#obtModalSelectAttribute').click();
		JSxSelectAttribute(1);

		//เก็บว่าเป็น insert หรือ update
		$('#ohdInsOrUpdateBrandInGroup').val(ptType);
		$('#ohdInsOrUpdateBrandInGroupValue').val(pnValue);
	}

	//เลือกยี่ห้อ
	function JSxSelectAttribute(pnPage){
		$.ajax({
			type	: "POST",
			url		: "r_selectAttributeBrandInGroup",
			data 	: { 'nPage' : pnPage , 'tSearchAttribute' : $('#oetSearchAttribute').val() , 'tName' : 'Brand' , 'tGroupCode' : '<?=@$FTPgpCode;?>' },
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				$('#odvContentPopUpBrand').html(tResult);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				JSxModalErrorCenter(jqXHR.responseText);
			}
		});
	}

	//กดยืนยันที่เลือก ยี่ห้อ
	function JSxConfirmBrandInGroup(){
		var LocalItemSelect = localStorage.getItem("LocalItemDataAttr");
		if(LocalItemSelect !== null){
			var aResult = LocalItemSelect.split("##");

			var tvaluecode 		= aResult[0];
			var tvaluename 		= aResult[1];
			
			$.ajax({
				type	: "POST",
				url		: "r_InsertBrandInGroup",
				data 	: { 
					'tvaluecode' 	: tvaluecode , 
					'tGroupCode' 	: '<?=@$FTPgpCode;?>' , 
					'tTypePage' 	: $('#ohdInsOrUpdateBrandInGroup').val(),
					'nCodePK'		: $('#ohdInsOrUpdateBrandInGroupValue').val()
				},
				cache	: false,
				timeout	: 0,
				success	: function (tResult) {
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');

					if($('#ohdInsOrUpdateBrandInGroup').val() == 'add'){
						$('.alert-success').find('.xCNTextShow').text('เพิ่มยี่ห้อในกลุ่มสินค้าสำเร็จ');
					}else if($('#ohdInsOrUpdateBrandInGroup').val() == 'edit'){
						$('.alert-success').find('.xCNTextShow').text('แก้ไขยี่ห้อในกลุ่มสินค้าสำเร็จ');
					}
					
					JSxLoadBrandInGroup();

					setTimeout(function(){
						$('.alert-success').find('.close').click();
					}, 3000);
				},
				error: function (jqXHR, textStatus, errorThrown) {
					JSxModalErrorCenter(jqXHR.responseText);
				}
			});

			objAttr = [];
			localStorage.clear();
			$('#obtModalSelectAttribute').click();
		}else{
			$('#obtModalSelectAttribute').click();
		}
	}

	//โหลดยี่ห้อในหน้าจอกลุ่มสินค้า
	JSxLoadBrandInGroup();
	function JSxLoadBrandInGroup(){
		$.ajax({
			type	: "POST",
			url		: "r_LoadBrandInGroup",
			data 	: { 'tGroupCode' : '<?=@$FTPgpCode;?>'},
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				$('#odvContent_BrandInGroup').html(tResult);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				JSxModalErrorCenter(jqXHR.responseText);
			}
		});
	}
</script>
