<?php
	$tLevelUser = $this->session->userdata('tSesUserLevel');
	if($tTypePage == 'insert'){
		$tRoute 			= 'r_purchaseordereventinsert';
		$tRouteUrl			= 'สร้างใบสั้งซื้อ';
		$tDocumentNumber	= '';
		$dDocumentDate		= date('d/m/Y') . ' - ' . date("H:i:s");
		$tDocumentCreate	= $this->session->userdata('tSesFirstname') . ' ' . $this->session->userdata('tSesLastname');
		$tDocumentStaDoc	= '-';
		$tDocumentStaApv	= '-';
	}else if($tTypePage == 'edit'){
		$tRoute 			= 'r_purchaseordereventedit';
		$tRouteUrl			= 'แก้ไขใบสั้งซื้อ';
		$tDocumentNumber	= $aResult[0]['FTXphDocNo'];
		$dDocumentDate		= date('d/m/Y',strtotime($aResult[0]['FDXphDocDate'])) . ' - ' . $aResult[0]['FTXphDocTime'];
		$tDocumentCreate	= $aResult[0]['FTUsrFName']; ' - ' . $aResult[0]['FTUsrLName'];
		$tDocumentStaDoc	= '-';
		$tDocumentStaApv	= '-';
	}

	//ถ้าเอกสารถูกยกเลิก หรือ อนุมัติแล้ว
	if($tDocumentStaDoc == 2 || $tDocumentStaApv == 1){
		$tDisabledInput = 'disabled';
	}else{
		$tDisabledInput = '';
	}
?>

<?php
	$aPermission = FCNaPERGetPermissionByPage('r_purchaseorder');
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
	<!--Section บน-->
	<div class="row">
		<div class="col-lg-6 col-md-6"><span class="xCNHeadMenuActive" onclick="JSxCallPagePOMain();">ใบสั้งซื้อ</span><span class="xCNHeadMenu">  /  <?=$tRouteUrl?></span></div>
		<div class="col-lg-6 col-md-6">	

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

			<?php if($tTypePage == 'edit'){ ?>
				<?php if($tDocumentStaDoc == 2 || $tDocumentStaApv == 1){ ?>
					<!--ไม่โชว์สักเมนู ถ้ามันอนุมัติเเล้ว-->
				<?php }else{ ?>
					<button class="xCNButtonSave pull-right <?=$tAlwSave?>" onclick="JSxEventSaveorEdit('<?=$tRoute?>');">บันทึก</button>
					<button class="xCNButtonAprove-outline btn btn-outline-success pull-right <?=$tPer_approved?>" style="margin-right:10px; float:right;" onclick="JSxEventAproveDocument('<?=$tRoute?>');">อนุมัติ</button>
					<button class="xCNCalcelImport btn btn-outline-danger pull-right <?=$tPer_cancle?>" style="margin-right:10px; float:right;" onclick="JSxEventCancleDocument('<?=$tRoute?>');">ยกเลิกเอกสาร</button>
				<?php } ?>
			<?php }else{ ?> 
				<button class="xCNButtonSave pull-right <?=$tAlwSave?>" onclick="JSxEventSaveorEdit('<?=$tRoute?>');">บันทึก</button>
			<?php } ?>

		</div>
	</div>

	<form id="ofmPO" class="form-signin" method="post" action="javascript:void(0)">
		<div class="row" style="margin-top: 10px;">
				
			<!--ข้อมูลผู้จำหน่าย-->	
			<div class="col-lg-6">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<!--Head-->
							<div class="col-lg-12">
								<div class="xCNHeadFooterINPDT"><span>ข้อมูลผู้จำหน่าย</span></div>
							</div>

							<!--Detail-->
							<div class="col-lg-12">
								<form id="ofmQuotationCst">
									<div class="row">
										<?php
											if($tTypePage == 'edit'){	//เข้ามาแบบ ขา Edit และ สิทธิสามารถแก้ไขได้
												if($tPer_edit == ''){
													$tAlwCustomer = '';
												}else{
													$tAlwCustomer = 'xCNHide';
												}
											}else if($tTypePage == 'insert'){ //เข้ามาแบบ ขา Insert และ สิทธิสามารถบันทึกได้
												if($tPer_create == ''){
													$tAlwCustomer = '';
												}else{
													$tAlwCustomer = 'xCNHide';
												}
											}
										?>
										<div class="col-lg-12">
											<label><span style="color:red;">*</span> ผู้จำหน่าย</label>
											<div class="input-group md-form form-sm form-2 pl-0 form-group">
												<input type="text" class="form-control" maxlength="255" id="oetSplName" name="oetSplName" placeholder="กรุณาระบุผู้จำหน่าย" autocomplete="off" value="">
												<div class="input-group-append <?=$tAlwCustomer?> xCNIconFindCustomer">
													<span class="input-group-text red lighten-3" style="cursor:pointer;" onclick="JSxChooseSupplier();">
														<img class="xCNIconFind">
													</span>
												</div>
											</div>
										</div>
									</div>
								</form>

							</div>
						</div>
					</div>
				</div>
			</div>

			<!--ข้อมูลผู้ติดต่อ-->
			<div class="col-lg-6">
				<div class="card">
					<div class="card-body">
						<div class="row">

							<!--Head-->
							<div class="col-lg-6">
								<div class="xCNHeadFooterINPDT" style="background-color:#a3e69e; color:#000;">
									เลขที่เอกสาร : <span id="ospDocNo" data-docno="<?= $tDocumentNumber ?>">
										<?php
										if ($tDocumentNumber == "") {
											echo "<lable id='olbDocNo'> PO########## </lable>";
										} else {
											echo " <lable id='olbDocNo'> " . $tDocumentNumber . " </label> ";
										}
										?>
									</span>
								</div>
							</div>

							<!--Head-->
							<div class="col-lg-6">
								<div class="xCNHeadFooterINPDT" style="background-color:#a3e69e; color:#000;">
									วันที่เอกสาร : <span id="ospDocDate"></span>
								</div>
							</div>

							<!--Detail-->
							<div class="col-lg-12">
								<div class="row">
									<div class="col-lg-6">
										<span>สถานะเอกสาร : </span><span id="ospStaDoc"></span>
										<input type="hidden" id="ohdStaDoc">
									</div>
									<div class="col-lg-6">
										<span>สถานะอนุมัติเอกสาร : </span><span id="ospStaDocApv"></span>
										<input type="hidden" id="ohdStaApv">
									</div>
								</div>
								<hr>
							</div>

						</div>
					</div>
				</div>
			</div>

		</div>
	</form>
<div>

<!-- Modal ให้เลือกผู้จำหน่าย -->
<button id="obtModalSelectSupplier" style="display:none;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#odvModalSelectSupplier"></button>
<div class="modal fade" id="odvModalSelectSupplier" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<h5 class="modal-title">เลือกผู้จำหน่าย</h5>
					</div>
					<div class="col-lg-6 col-md-6"></div>
				</div>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<div class="input-group md-form form-sm form-2 pl-0">
							<input class="form-control my-0 py-1 red-border xCNFormSerach" autocomplete="off" type="text" placeholder="กรุณากรอกคำที่ต้องการค้นหา" id="oetSearchSupplier" onkeypress="Javascript:if(event.keyCode==13) JSxSelectSupplier(1)">
							<div class="input-group-append">
								<span class="input-group-text red lighten-3" style="cursor:pointer;" onclick="JSxSelectSupplier(1);">
									<?php $tMenuBar = base_url().'application/assets/images/icon/search.png'; ?>
									<img class="menu-icon xCNMenuSearch" src="<?=$tMenuBar?>">
								</span>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6">
						<button type="button" class="btn  btn-success xCNConfirmCustomer" onclick="JSxInsSupplierToForm();" style="float: right;">ยืนยัน</button>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12 col-md-12">
						<div id="odvContentSelectSupplier" style="margin-top:10px;"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--Modal ยกเลิกเอกสาร-->
<button id="obtModalCancleDocument" style="display:none;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#odvModalCancleDocument"></button>
<div class="modal fade" id="odvModalCancleDocument" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">ยกเลิกเอกสาร</h5>
			</div>
			<div class="modal-body">
				<label style="text-align: left; display: block;">เอกสารยกเลิก จะไม่สามารถแก้ไขได้ คุณต้องการที่จะยกเลิกเอกสารนี้หรือไม่?</label>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary xCNCloseDelete" data-dismiss="modal" style="width: 100px;">ปิด</button>
				<button type="button" class="btn btn-danger xCNConfirmDelete xCNConfirmCancleDocument">ยืนยัน</button>
			</div>
		</div>
	</div>
</div>

<!--Modal อนุมัติเอกสาร-->
<button id="obtModalAproveDocument" style="display:none;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#odvModalAproveDocument"></button>
<div class="modal fade" id="odvModalAproveDocument" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">อนุมัติเอกสาร</h5>
			</div>
			<div class="modal-body">
				<label style="text-align: left; display: block;">คำเตือน : การอนุมัติจะมีผลดังนี้</label>
				<label style="text-align: left; display: block; margin: 0px;">1. เอกสาร จะถูกปรับสถานะว่ามีการอนุมัติแล้ว</label>
				<label style="text-align: left; display: block; margin: 0px;">2. เอกสารจะไม่สามารถ แก้ไข, ยกเลิก, หรือลบได้อีก</label>
				<label style="text-align: left; display: block; margin: 0px;">3. เอกสารสามารถค้นหา และแสดงข้อมูล เพื่อตรวจสอบข้อมูลได้</label>
				<label style="text-align: left; display: block; margin: 0px;">4. สินค้าในเอกสารจะถูกนำไปปรับราคา</label>
				<label style="text-align: left; display: block;">ดังนั้น ควรตรวจเช็คความถูกต้อง ของเอกสารให้เรียบร้อย ก่อนการอนุมัติ</label>
				<label style="text-align: left; display: block;">คุณต้องการยืนยัน การอนุมัติเอกสารหรือไม่?</label>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary xCNCloseDelete" data-dismiss="modal" style="width: 100px;">ปิด</button>
				<button type="button" class="btn btn-danger xCNConfirmDelete xCNConfirmDeleteAprove">ยืนยัน</button>
			</div>
		</div>
	</div>
</div>

<!--Modal กรุณาให้เลือกสินค้า-->
<button id="obtModalPlzSelectPDT" style="display:none;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#odvModalPlzSeletePDT"></button>
<div class="modal fade" id="odvModalPlzSeletePDT" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">กรุณาเลือกสินค้า</h5>
			</div>
			<div class="modal-body">
				<label style="text-align: left; display: block;">ไม่พบสินค้า กรุณาเลือกสินค้า เพื่อทำการปรับราคา</label>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary xCNCloseDelete" data-dismiss="modal" style="width: 100px;">ยืนยัน</button>
			</div>
		</div>
	</div>
</div>

<!--Modal กำลังประมวลผล-->
<button id="obtModalProcess" style="display:none;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#odvModalProcess"></button>
<div class="modal fade" id="odvModalProcess" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title">อัพโหลดไฟล์</h5>
		</div>
		<div class="modal-body">
			<label style="text-align: center; display: block;" id="olbModalProcessText">กรุณารอสักครู่ กำลังตรวจสอบไฟล์ข้อมูล</label>
			<label style="text-align: center; display: block; font-size: 17px;">โปรดอย่าปิดหน้าจอขณะอัพโหลดไฟล์</label>	
			<div class="progress" style="height: 25px; width: 100%;">
				<div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
			</div>
		</div>
		</div>
	</div>
</div>

<!-- Modal ให้เลือกสินค้า -->
<button id="obtModalSelectPDT" style="display:none;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#odvModalSelectPDT"></button>
<div class="modal fade" id="odvModalSelectPDT" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<h5 class="modal-title">เลือกสินค้า</h5>
					</div>
					<div class="col-lg-6 col-md-6">
						<!-- <button type="button" class="btn  btn-success xCNConfirmPDT" style="float: right;">ยืนยัน</button> -->
					</div>
				</div>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<div class="input-group md-form form-sm form-2 pl-0">
							<input class="form-control my-0 py-1 red-border xCNFormSerach" autocomplete="off" type="text" placeholder="กรุณากรอกคำที่ต้องการค้นหา" id="oetSearchPDTToTmp" onkeypress="Javascript:if(event.keyCode==13) JSxSelectPDTToTmp(1)">
							<div class="input-group-append">
								<span class="input-group-text red lighten-3" style="cursor:pointer;" onclick="JSxSelectPDTToTmp(1);">
									<?php $tMenuBar = base_url().'application/assets/images/icon/search.png'; ?>
									<img class="menu-icon xCNMenuSearch" src="<?=$tMenuBar?>">
								</span>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6">
						<button type="button" class="btn  btn-success xCNConfirmPDT" onclick="JSxInsPDTToTmp();" style="float: right;">ยืนยัน</button>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12 col-md-12">
						<div id="odvContentSelectPDT" style="margin-top:10px;"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--Modal กรุณาเลือกวันที่เริ่มต้น-->
<button id="obtModalPlzDateStart" style="display:none;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#odvModalPlzDateStart"></button>
<div class="modal fade" id="odvModalPlzDateStart" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">กรุณากรอกข้อมูลให้ครบถ้วน</h5>
			</div>
			<div class="modal-body">
				<label style="text-align: left; display: block;">กรุณากรอกข้อมูลวันที่มีผล ของเอกสารปรับราคาขาย</label>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary xCNCloseDelete xCNConfirmDateActive" data-dismiss="modal" style="width: 100px;">ยืนยัน</button>
			</div>
		</div>
	</div>
</div>

<script src="<?= base_url('application/assets/js/jFormValidate.js')?>"></script>

<script>	

	$('ducument').ready(function(){ 
		//ถ้าเข้ามาแบบแก้ไข แต่ ไม่มีสิทธิ์ในการแก้ไข
		if('<?=$tTypePage?>' == 'edit' && '<?=$tPer_edit?>' != ''){
			$('.form-control').attr('disabled',true);
			$('.xCNFormSerach').attr('disabled',false);
		}

		$('.xCNDatePicker').datepicker({ 
			format          : 'dd/mm/yyyy',
			autoclose       : true,
			todayHighlight  : true,
			orientation		: "top right"
		});
	});

	//เลือกผู้จำหน่าย
	function JSxChooseSupplier(){
		$('#obtModalSelectSupplier').click();
		JSxSelectSupplier(1);
	}

	//เลือกผู้จำหน่าย
	function JSxSelectSupplier(pnPage){
		$.ajax({
			type	: "POST",
			url		: "r_selectSupplier",
			data 	: { 'nPage' : pnPage , 'tSearchSupplier' : $('#oetSearchSupplier').val() },
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				$('#odvContentSelectSupplier').html(tResult);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				JSxModalErrorCenter(jqXHR.responseText);
			}
		});
	}

	//กดยืนยันเลือกผู้จำหน่าย
	function JSxInsSupplierToForm(){
		var LocalItemSelect = localStorage.getItem("LocalItemData");
		if(LocalItemSelect !== null){
			var aResult = LocalItemSelect.split(",");

			// var tCusname			= aResult[0];
			// var tCustomercode 		= aResult[1];
			// var tAddress 			= aResult[2];
			// var tTaxno 				= aResult[3];
			// var tContactname 		= aResult[4];
			// var tEmail 				= aResult[5];
			// var tTel 				= aResult[6];
			// var tFax 				= aResult[7];

			// $('#oetCstName').val(tCusname);
			// $('#oetAddress').text(tAddress);
			// $('#oetTaxNo').val(tTaxno);
			// $('#oetContact').val(tContactname);
			// $('#oetEmail').val(tEmail);
			// $('#oetTel').val(tTel);
			// $('#oetFax').val(tFax);
			// $('#ohdCustomerCode').val(tCustomercode);

			obj = [];
			localStorage.clear();
			$('#obtModalSelectSupplier').click();
		}else{

		}
	}

	//โหลดข้อมูลตารางสินค้า
	JSvLoadTableDTTmp(1);
	function JSvLoadTableDTTmp(pnPage){
		$.ajax({
			type	: "POST",
			url		: "r_adjpriceloadtableDTTmp",
			data 	: {
						'tTypepage'  			: '<?=$tTypePage?>',
						'tCode'	 	 			: '<?=$tDocumentNumber?>',
						'nPage' 				: pnPage,
						'tSearchTmp' 			: $('#oetSearchTmp').val(),
						'tControlWhenAprOrCan' 	: '<?=$tDisabledInput?>'
					  },
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				JSxModalProgress('close');
				$('#odvAJPTableDT').html(tResult);

				//ตัวถัดไปจะต้อง curros
				var oPDTLast = localStorage.getItem('ADJ_Price_PDTLast');
				if(oPDTLast != null || oPDTLast != ''){
					$('#oetAddPri' + oPDTLast).focus();
					$('#oetAddPri' + oPDTLast).select();
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				JSxModalErrorCenter(jqXHR.responseText);
			}
		});
	}

	//อีเวนท์บันทึกข้อมูล
	function JSxEventSaveorEdit(ptRoute){

		if($('#oetDateActive').val() == null || $('#oetDateActive').val() == ''){
			$('#obtModalPlzDateStart').click();

			$('.xCNConfirmDateActive').on('click',function(){
				$('#oetDateActive').focus();
			});
			return;
		}

		if($('#otbAJPTable tbody tr').hasClass('otrAJPTmpEmpty') == true){
			$('#obtModalPlzSelectPDT').click();
			return;
		}


		$.ajax({
			type	: "POST",
			url		: ptRoute,
			data 	: $('#ofmAJP').serialize(),
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				oResult 			= JSON.parse(tResult);
				var tResult 		= oResult.tStatus;
				var tDocumentNumber = oResult.tDocuementnumber;
				if(tResult == 'pass_insert'){
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('ลงทะเบียนเอกสารปรับราคาสำเร็จ');
					JSwAJPCallPageInsert('edit',tDocumentNumber);
					setTimeout(function(){
						$('.alert-success').find('.close').click();
					}, 3000);
				}else if(tResult == 'pass_update'){
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('แก้ไขข้อเอกสารปรับราคาสำเร็จ');
					JSwAJPCallPageInsert('edit',tDocumentNumber);
					setTimeout(function(){
						$('.alert-success').find('.close').click();
					}, 3000);
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				JSxModalErrorCenter(jqXHR.responseText);
			}
		});
	}

	//เลือกสินค้า
	function JSxBrowsePDTInDocument(){
		$('#obtModalSelectPDT').click();
		JSxSelectPDTToTmp(1);
	}

	//บันทึกข้อมูลสินค้าลงตาราง Tmp
	function JSxInsPDTToTmp(){
		var LocalItemSelect = localStorage.getItem("LocalItemData");
		if(LocalItemSelect !== null){
			$.ajax({
				type	: "POST",
				url		: "r_adjpriceInsPDTToTmp",
				data 	: {
							'tTypepage'  	: '<?=$tTypePage?>',
							'tCode'	 	 	: '<?=$tDocumentNumber?>',
							'aData'			: LocalItemSelect,
							'nAdjPriceALL'  : $('#oetADJPriceALL').val(),
						},
				cache	: false,
				timeout	: 0,
				success	: function (tResult) {
					obj = [];
					localStorage.clear();
					$('#obtModalSelectPDT').click();
					JSvLoadTableDTTmp(1);
				},
				error: function (jqXHR, textStatus, errorThrown) {
					JSxModalErrorCenter(jqXHR.responseText);
				}
			});
		}else{
			$('#obtModalSelectPDT').click();
		}
	}

	//ยกเลิกเอกสาร
	function JSxEventCancleDocument(){
		$('#obtModalCancleDocument').click();

		$('.xCNConfirmCancleDocument').off();
		$('.xCNConfirmCancleDocument').on("click",function(){
			$.ajax({
				type	: "POST",
				url		: "r_adjpriceCancleDocument",
				data 	: { 'tCode'	: '<?=$tDocumentNumber?>' },
				cache	: false,
				timeout	: 0,
				success	: function (tResult) {
					$('#obtModalCancleDocument').click();
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('ยกเลิกเอกสารสำเร็จ');

					setTimeout(function(){
						JSxCallPageAJPMain();
					}, 500);

					setTimeout(function(){
						$('.alert-success').find('.close').click();
					}, 3000);
				},
				error: function (jqXHR, textStatus, errorThrown) {
					JSxModalErrorCenter(jqXHR.responseText);
				}
			});
		});
	}

	//อนุมัติเอกสาร
	function JSxEventAproveDocument(){
		$('#obtModalAproveDocument').click();

		$('.xCNConfirmDeleteAprove').off();
		$('.xCNConfirmDeleteAprove').on("click",function(){
			$.ajax({
				type	: "POST",
				url		: 'r_adjpriceAprove',
				data 	: { 'tCode'	: '<?=$tDocumentNumber?>' },
				cache	: false,
				timeout	: 0,
				success	: function (tResult) {
					$('#obtModalAproveDocument').click();
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('เอกสารอนุมัติสำเร็จ');
				
					setTimeout(function(){
						JSxCallPageAJPMain();
					}, 500);

					setTimeout(function(){
						$('.alert-success').find('.close').click();
					}, 3000);
				},
				error: function (jqXHR, textStatus, errorThrown) {
					JSxModalErrorCenter(jqXHR.responseText);
				}
			});
		});
	}

</script>
