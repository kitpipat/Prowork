<?php
	$tLevelUser = $this->session->userdata('tSesUserLevel');
	if($tTypePage == 'insert'){
		$tRoute 			= 'r_adjpriceeventinsert';
		$tRouteUrl			= 'สร้างใบปรับราคาสินค้า';

		$tDocumentNumber	= '-';
		$dDocumentDate		= date('d/m/Y') . ' - ' . date("H:i:s");
		$tDocumentCreate	= $this->session->userdata('tSesFirstname') . ' ' . $this->session->userdata('tSesLastname');
		$tDocumentStaDoc	= '-';
		$tDocumentStaApv	= '-';
	}else if($tTypePage == 'edit'){
		$tRoute 			= 'r_adjpriceeventedit';
		$tRouteUrl			= 'แก้ไขใบปรับราคาสินค้า';

		$tDocumentNumber	= $aResult[0]['FTXphDocNo'];
		$dDocumentDate		= date('d/m/Y',strtotime($aResult[0]['FDXphDocDate'])) . ' - ' . $aResult[0]['FTXphDocTime'];
		$tDocumentCreate	= $aResult[0]['FTUsrFName']; ' - ' . $aResult[0]['FTUsrLName'];
		$tDocumentStaDoc	= $aResult[0]['FTXphStaDoc'];
		$tDocumentStaApv	= $aResult[0]['FTXphStaApv'];
		$FTPriGrpID			= $aResult[0]['FTPriGrpID'];
		$FTXphRmk			= $aResult[0]['FTXphRmk'];
	}

	//ถ้าเอกสารถูกยกเลิก หรือ อนุมัติแล้ว
	if($tDocumentStaDoc == 2 || $tDocumentStaApv == 1){
		$tDisabledInput = 'disabled';
	}else{
		$tDisabledInput = '';
	}
?>

<div class="container-fulid">
	<!--Section บน-->
	<div class="row">
		<div class="col-lg-6 col-md-6"><span class="xCNHeadMenuActive" onclick="JSxCallPageAJPMain();">ใบปรับราคาสินค้า</span><span class="xCNHeadMenu">  /  <?=$tRouteUrl?></span></div>
		<div class="col-lg-6 col-md-6">

			<?php if($tTypePage == 'edit'){ ?>
				<?php if($tDocumentStaDoc == 2 || $tDocumentStaApv == 1){ ?>
					<!--ไม่โชว์สักเมนู ถ้ามันอนุมัติเเล้ว-->
				<?php }else{ ?>
					<button class="xCNButtonSave pull-right" onclick="JSxEventSaveorEdit('<?=$tRoute?>');">บันทึก</button>
					<button class="xCNButtonAprove-outline btn btn-outline-success pull-right" style="margin-right:10px;" onclick="JSxEventAproveDocument('<?=$tRoute?>');">อนุมัติ</button>
					<button class="xCNCalcelImport btn btn-outline-danger pull-right" style="margin-right:10px;" onclick="JSxEventCancleDocument('<?=$tRoute?>');">ยกเลิกเอกสาร</button>
				<?php } ?>
			<?php }else{ ?>
				<button class="xCNButtonSave pull-right" onclick="JSxEventSaveorEdit('<?=$tRoute?>');">บันทึก</button>
			<?php } ?>

		</div>
	</div>

	<form id="ofmAJP" class="form-signin" method="post" action="javascript:void(0)">

		<!--Section ล่าง-->
		<div class="row">
			<!--section ซ้าย พวกรายละเอียด HD-->
			<div class="col-lg-3 col-md-3">
				<div class="row">
					<!--Panel 1 ข้อมูลเอกสาร-->
					<div class="col-lg-12">
						<div class="card" style="margin-top: 10px;">
							<div class="card-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="xCNHeadFooterINPDT"><span> ข้อมูลเอกสาร </span></div>
									</div>
									<!--รายละเอียด-->
									<div class="col-lg-12 col-md-12">
										<div class="form-group xCNSubPanelDocument">
											<span>เลขที่เอกสาร : </span>
											<span class="pull-right"><?=$tDocumentNumber?></span>
											<input type="hidden" id="ohdDocumentNumber" name="ohdDocumentNumber" value="<?=$tDocumentNumber?>" >
										</div>

										<div class="form-group xCNSubPanelDocument">
											<span>วันที่-เวลาเอกสาร : </span>
											<span class="pull-right"><?=$dDocumentDate?></span>
										</div>

										<div class="form-group xCNSubPanelDocument">
											<span>ผู้สร้างเอกสาร : </span>
											<span class="pull-right"><?=$tDocumentCreate?></span>
										</div>

										<div class="form-group xCNSubPanelDocument">
											<span>สถานะเอกสาร : </span>
											<?php if($tDocumentStaDoc == '1'){
												$tDocumentStaDoc = 'สมบูรณ์';
											}else if($tDocumentStaDoc == '2'){
												$tDocumentStaDoc = 'ยกเลิก';
											}else{
												$tDocumentStaDoc = '-';
											}?>
											<span class="pull-right"><?=$tDocumentStaDoc?></span>
										</div>

										<div class="form-group xCNSubPanelDocument">
											<span>สถานะอนุมัติเอกสาร : </span>
											<?php if($tDocumentStaApv == '1'){
												$tDocumentStaApv = 'อนุมัติแล้ว';
											}else if($tDocumentStaApv == null && $tDocumentStaDoc == 1){
												$tDocumentStaApv = 'รออนุมัติ';
											}else{
												$tDocumentStaApv = '-';
											}?>
											<span class="pull-right"><?=$tDocumentStaApv?></span>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>

					<!--Panel 2 เงือนไขการปรับ-->
					<div class="col-lg-12">
						<div class="card" style="margin-top: 10px;">
							<div class="card-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="xCNHeadFooterINPDT"><span> เงือนไขการปรับ </span></div>
									</div>
									<!--รายละเอียด-->
									<div class="col-lg-12 col-md-12">
										<!--กลุ่มราคาที่มีผล-->
										<div class="form-group">
											<label><span style="color:red;">*</span> กลุ่มราคาที่มีผล</label>
											<select <?=$tDisabledInput?> class="form-control" id="oetAJPPriGrp" name="oetAJPPriGrp">
												<?php foreach($aPriGrp['raItems'] AS $nKey => $aValue){ ?>
													<option <?=(@$FTPriGrpID == $aValue['FTPriGrpID'])? "selected" : "";?> value="<?=$aValue['FTPriGrpID'];?>"><?=$aValue['FTPriGrpName'];?></option>
												<?php } ?>
											</select>										
										</div>
										<!--หมายเหตุ-->
										<div class="form-group">
											<label>หมายเหตุ</label>
											<textarea <?=$tDisabledInput?> type="text" class="form-control" id="oetAJPReason" name="oetAJPReason" placeholder="หมายเหตุ" rows="3"><?=@$FTXphRmk?></textarea>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!--section ขวา พวกรายละเอียด DT-->
			<div class="col-lg-9 col-md-9">

				<div class="card" style="margin-top: 10px;">
					<div class="card-body">
						<div class="row">
							<div class="col-lg-12">
								<div class="xCNHeadFooterINPDT"><span> รายการสินค้า </span></div>
							</div>
							<!--รายละเอียด-->
							<div class="col-lg-12 col-md-12">
													
								<!--เพิ่มสินค้า + ค้นหาสินค้า-->
								<div class="row">
									<div class="col-lg-4 col-md-4">
										<div class="input-group md-form form-sm form-2 pl-0">
											<input class="form-control my-0 py-1 red-border xCNFormSerach" autocomplete="off" type="text" placeholder="กรุณากรอกคำที่ต้องการค้นหา" id="oetSearchTmp" onkeypress="Javascript:if(event.keyCode==13) JSvLoadTableDTTmp(1)">
											<div class="input-group-append">
												<span class="input-group-text red lighten-3" style="cursor:pointer;" onclick="JSvLoadTableDTTmp(1);"><i class="fa fa-search" aria-hidden="true"></i></span>
											</div>
										</div>
									</div>

									<!--นำเข้าข้อมูล-->
									<div class="col-lg-4 col-md-4">
										<div class="btn-group pull-left xCNImportBTN">
											<?php if($tDisabledInput != "disabled"){ ?>
												<button type="button" class="btn btn-secondary dropdown-toggle xCNImport" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">นำเข้าข้อมูล</button>
											<?php } ?>
											<div class="dropdown-menu dropdown-menu-left xCNDropdown">
												<?php if($tDisabledInput != "disabled"){ ?>
													<button class="dropdown-item xCNDropdownSub" type="button"><a style="color:#000000;" href="<?=base_url('application/assets/templates/Priceadjustment_Import_Template.xlsx');?>">ดาวน์โหลดแม่แบบ</a></button>
													<button class="dropdown-item xCNDropdownSub" type="button" onclick="JSxImportDataExcel();">นำเข้าข้อมูล ไฟล์</button>
												<?php } ?>
												<input style="display:none;" type="file" id="ofeImportExcel" accept=".csv,application/vnd.ms-excel,.xlt,application/vnd.ms-excel,.xla,application/vnd.ms-excel,.xlsx,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,.xltx,application/vnd.openxmlformats-officedocument.spreadsheetml.template,.xlsm,application/vnd.ms-excel.sheet.macroEnabled.12,.xltm,application/vnd.ms-excel.template.macroEnabled.12,.xlam,application/vnd.ms-excel.addin.macroEnabled.12,.xlsb,application/vnd.ms-excel.sheet.binary.macroEnabled.12">
											</div>
										</div>
									</div>

									<?php if($tDisabledInput != "disabled"){ ?>
										<div class="col-lg-4 col-md-4">
											<button class="xCNBrowsePDTinDocument" type="button" onclick="JSxBrowsePDTInDocument();"><span>+</span></button>
										</div>
									<?php } ?>
								</div>

								<!--รายการสินค้า-->
								<div class="row">
									<div class="col-lg-12 col-md-12">
										<div id="odvAJPTableDT" style="margin-top:10px;"></div>		
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
				<label style="text-align: left; display: block;" id="olbModalProcessText">ไม่พบสินค้า กรุณาเลือกสินค้า เพื่อทำการปรับราคา</label>
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
								<span class="input-group-text red lighten-3" style="cursor:pointer;" onclick="JSxSelectPDTToTmp(1);"><i class="fa fa-search" aria-hidden="true"></i></span>
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

<script src="<?= base_url('application/assets/js/jFormValidate.js')?>"></script>

<!--อัพโหลดไฟล์ excel-->
<script>
	//อัพโหลดไฟล์ excel
	function JSxImportDataExcel(){
		$('#ofeImportExcel').click(); 
	}

	//Import Excel
	var file = $('#ofeImportExcel')[0];
	file.addEventListener('change', importFile);

	function importFile(evt) {
		var f = evt.target.files[0];
		if (f) {
			var r = new FileReader();
			r.onload = e => {
				var contents = processExcel(e.target.result);
				var aJSON = JSON.parse(contents);

					$('#olbModalProcessText').text('กรุณารอสักครู่ กำลังตรวจสอบไฟล์ข้อมูล');
					$('#obtModalProcess').click();

					$.ajax({
						type	: "POST",
						url		: "r_adjpricePDTCallpageUplodeFile",
						data	: { 'aPackdata' : aJSON , 'tCode' : '<?=$tDocumentNumber?>' },
						cache	: true,
						async	: false,
						timeout	: 0,
						success	: function (tResult) {
							// console.log(tResult);
							if(tResult == 'Fail'){
								setTimeout(function(){
									$('#obtModalProcess').click();
								}, 800);

								setTimeout(function(){
									$('.alert-danger').addClass('show').fadeIn();
									$('.alert-danger').find('.badge-danger').text('ผิดพลาด');
									$('.alert-danger').find('.xCNTextShow').text('รูปแบบไฟล์ไม่ถูกต้อง');
									$('#oetUserLogin').val('');
									$('#oetUserLogin').focus();
								}, 1000);

								setTimeout(function(){
									$('.alert-danger').find('.close').click();
								}, 3000);
							}else{
								setTimeout(function(){
									$('#obtModalProcess').click();
									JSvLoadTableDTTmp(1);
								}, 2000);
							}
						},
						error: function (jqXHR, textStatus, errorThrown) {
							alert(jqXHR, textStatus, errorThrown);
						}
					});

			}
			r.readAsBinaryString(f);
		} else {
			console.log("Failed to load file");
		}
	}

	function processExcel(data) {
		var workbook = XLSX.read(data, {
			type: 'binary'
		});

		var firstSheet = workbook.SheetNames[0];
		var data = to_json(workbook);
		return data
	};

	function to_json(workbook) {
		var result = {};
		workbook.SheetNames.forEach(function(sheetName) {
			var roa = XLSX.utils.sheet_to_json(workbook.Sheets[sheetName], {
				header: 1
			});
			if (roa.length) result[sheetName] = roa;
		});
		return JSON.stringify(result, 2, 2);
	};
</script>

<script>	

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
				$('#odvAJPTableDT').html(tResult);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert(jqXHR, textStatus, errorThrown);
			}
		});
	}

	//อีเวนท์บันทึกข้อมูล
	function JSxEventSaveorEdit(ptRoute){

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
				console.log(oResult);
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
				alert(jqXHR, textStatus, errorThrown);
			}
		});
	}

	//เลือกสินค้า
	function JSxBrowsePDTInDocument(){
		$('#obtModalSelectPDT').click();
		JSxSelectPDTToTmp(1);
	}

	//เลือกสินค้า
	var obj = [];
	function JSxSelectPDTToTmp(pnPage){
		$.ajax({
			type	: "POST",
			url		: "r_adjpriceloadPDT",
			data 	: {
						'tTypepage'  	: '<?=$tTypePage?>',
						'tCode'	 	 	: '<?=$tDocumentNumber?>',
						'nPage' 		: pnPage,
						'tSearchPDT'	: $('#oetSearchPDTToTmp').val()
					  },
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				$('#odvContentSelectPDT').html(tResult);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert(jqXHR, textStatus, errorThrown);
			}
		});
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
							'aData'			: LocalItemSelect
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
					alert(jqXHR, textStatus, errorThrown);
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
					JSxCallPageAJPMain();
					setTimeout(function(){
						$('.alert-success').find('.close').click();
					}, 3000);
				},
				error: function (jqXHR, textStatus, errorThrown) {
					alert(jqXHR, textStatus, errorThrown);
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
					JSxCallPageAJPMain();
					setTimeout(function(){
						$('.alert-success').find('.close').click();
					}, 3000);
				},
				error: function (jqXHR, textStatus, errorThrown) {
					alert(jqXHR, textStatus, errorThrown);
				}
			});
		});
	}

</script>
