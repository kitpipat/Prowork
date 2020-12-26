<style>
	.FontColorClick{
		text-decoration	: underline; 
		cursor			: pointer; 
		color			: #43ac3a;
	}
</style>
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
	<div class="row">

		<!--Filter ค้นหาขั้นสูง-->
		<div class="col-lg-3 xCNFilterAdvParent">
			<!--ตัวกรองค้นหา-->
			<div class="xCNFilterSearch xCNFilterBlockHide">
				<div class="row">

					<div class="xCNFilterAdvSub">
						<div class="xCNHeadFilter xCNLineBarFilter" style="width:80%;"> ตัวกรองค้นหา </div>
						<div class="xCNHeadFilter xCNLineBarFilter xCNCloseAdv" style="width:20%;">
							<?php $tIconClose = base_url().'application/assets/images/icon/close.png'; ?>
							<img class="menu-icon xCNMenuSearch" src="<?=$tIconClose?>">
						</div>
					</div>

					<div class="xCNFilterAdvSub">
						<div class="xCNSubFilter">
							<!--ยี่ห้อ-->
							<?php if($aFilter_Brand['rtCode'] != 800){ ?>
								<div class="form-group xCNFilterMarginBottom">
									<label class="xCNFindClick FontColorClick" data-find="Brand"><b>ยี่ห้อ</b></label>
									<div class="xCNFindBrand" style="display:none;">
										<?php foreach($aFilter_Brand['raItems'] AS $nKey => $aValue){ ?>
											<label class="container-checkbox xCNCheckboxFilter">
												<input class="xCNFilterAdv" type="checkbox" data-filter="PBN" value="<?=$aValue['FTPbnCode']?>"><?=$aValue['FTPbnName']?>
												<span class="checkmark"></span>
											</label>
										<?php } ?>
									</div>
								</div>
							<?php } ?>

							<!--สี-->
							<?php if($aFilter_Color['rtCode'] != 800){ ?>
								<div class="form-group xCNFilterMarginBottom">
									<label class="xCNFindClick FontColorClick" data-find="Color"><b>สี</b></label>
									<div class="xCNFindColor" style="display:none;">
										<?php foreach($aFilter_Color['raItems'] AS $nKey => $aValue){ ?>
											<label class="container-checkbox xCNCheckboxFilter">
												<input class="xCNFilterAdv" type="checkbox" data-filter="CLR" value="<?=$aValue['FTPClrCode']?>"><?=$aValue['FTPClrName']?>
												<span class="checkmark"></span>
											</label>
										<?php } ?>
									</div>
								</div>
							<?php } ?>

							<!--กลุ่ม-->
							<?php if($aFilter_Group['rtCode'] != 800){ ?>
								<div class="form-group xCNFilterMarginBottom">
									<label class="xCNFindClick FontColorClick" data-find="Group"><b>กลุ่ม</b></label>
									<div class="xCNFindGroup" style="display:none;">
										<?php foreach($aFilter_Group['raItems'] AS $nKey => $aValue){ ?>
											<label class="container-checkbox xCNCheckboxFilter">
												<input class="xCNFilterAdv" type="checkbox" data-filter="PGP" value="<?=$aValue['FTPgpCode']?>"><?=$aValue['FTPgpName']?>
												<span class="checkmark"></span>
											</label>
										<?php } ?>
									</div>
								</div>
							<?php } ?>

							<!--รุ่น-->
							<?php if($aFilter_Modal['rtCode'] != 800){ ?>
								<div class="form-group xCNFilterMarginBottom">
									<label class="xCNFindClick FontColorClick" data-find="Modal"><b>รุ่น</b></label>
									<div class="xCNFindModal" style="display:none;">
										<?php foreach($aFilter_Modal['raItems'] AS $nKey => $aValue){ ?>
											<label class="container-checkbox xCNCheckboxFilter">
												<input class="xCNFilterAdv" type="checkbox" data-filter="MOL" value="<?=$aValue['FTMolCode']?>"><?=$aValue['FTMolName']?>
												<span class="checkmark"></span>
											</label>
										<?php } ?>
									</div>
								</div>
							<?php } ?>

							<!--ขนาด-->
							<?php if($aFilter_Size['rtCode'] != 800){ ?>
								<div class="form-group xCNFilterMarginBottom">
									<label class="xCNFindClick FontColorClick" data-find="Size"><b>ขนาด</b></label>
									<div class="xCNFindSize" style="display:none;">
										<?php foreach($aFilter_Size['raItems'] AS $nKey => $aValue){ ?>
											<label class="container-checkbox xCNCheckboxFilter">
												<input class="xCNFilterAdv" type="checkbox" data-filter="PZE" value="<?=$aValue['FTPzeCode']?>"><?=$aValue['FTPzeName']?>
												<span class="checkmark"></span>
											</label>
										<?php } ?>
									</div>
								</div>
							<?php } ?>

							<!--ประเภท-->
							<?php if($aFilter_Type['rtCode'] != 800){ ?>
								<div class="form-group xCNFilterMarginBottom">
									<label class="xCNFindClick FontColorClick" data-find="Type"><b>ประเภท</b></label>
									<div class="xCNFindType" style="display:none;">
										<?php foreach($aFilter_Type['raItems'] AS $nKey => $aValue){ ?>
											<label class="container-checkbox xCNCheckboxFilter">
												<input class="xCNFilterAdv" type="checkbox" data-filter="PTY" value="<?=$aValue['FTPtyCode']?>"><?=$aValue['FTPtyName']?>
												<span class="checkmark"></span>
											</label>
										<?php } ?>
									</div>
								</div>
							<?php } ?>

							<!--หน่วย-->
							<?php if($aFilter_Unit['rtCode'] != 800){ ?>
								<div class="form-group xCNFilterMarginBottom">
									<label class="xCNFindClick FontColorClick" data-find="Unit"><b>หน่วย</b></label>
									<div class="xCNFindUnit" style="display:none;">
										<?php foreach($aFilter_Unit['raItems'] AS $nKey => $aValue){ ?>
											<label class="container-checkbox xCNCheckboxFilter">
												<input class="xCNFilterAdv" type="checkbox"  data-filter="PUN" value="<?=$aValue['FTPunCode']?>"><?=$aValue['FTPunName']?>
												<span class="checkmark"></span>
											</label>
										<?php } ?>
									</div>
								</div>
							<?php } ?>

							<!--ผู้จำหน่าย-->
							<?php if($aFilter_Spl['rtCode'] != 800){ ?>
								<!-- <div class="form-group xCNFilterMarginBottom">
									<label><b>ผู้จำหน่าย</b></label>
									<?php //foreach($aFilter_Spl['raItems'] AS $nKey => $aValue){ ?>
										<label class="container-checkbox xCNCheckboxFilter">
											<input class="xCNFilterAdv" type="checkbox" data-filter="SPL" value="<?//=$aValue['FTSplCode']?>"><?//=$aValue['FTSplName']?>
											<span class="checkmark"></span>
										</label>
									<?php //} ?>
								</div> -->
							<?php } ?>

						</div>
						<button class="btn btn-outline-success xCNUseFilterAdv" type="button" onclick="JSxPDTFilterAdv();">นำไปใช้</button>
					</div>
				</div>
			</div>
		</div>

		<!--แสดงข้อมูลสินค้า-->
		<div class="col-lg-12 xCNContentProduct">
			<!--Section บน-->
			<div class="row">
				<div class="col-lg-6 col-md-6"><span class="xCNHeadMenu">สินค้า</span></div>
				<div class="col-lg-6 col-md-6 <?=$tPer_create?>"><button class="xCNButtonInsert pull-right" onClick="JSwProductCallPageInsert('insert','')">+</button></div>
			</div>

			<!--Section ล่าง-->
			<div class="row">
				<div class="col-lg-12">
					<div class="card" style="margin-top: 10px;">
						<div class="card-body">
							<div class="row">
								<!--รายละเอียด-->
								<div class="col-lg-12">
									<div class="row">

										<!--ค้นหา-->
										<div class="col-lg-4">
											<div class="input-group md-form form-sm form-2 pl-0">
												<input class="form-control my-0 py-1 red-border xCNFormSerach xCNInputWithoutSingleQuote" type="text" placeholder="กรุณากรอกคำที่ต้องการค้นหา" id="oetSearch" onkeypress="Javascript:if(event.keyCode==13) JSwLoadTableList(1)">
												<div class="input-group-append">
													<span class="input-group-text red lighten-3" style="cursor:pointer;" onclick="JSwLoadTableList(1);">
														<?php $tMenuBar = base_url().'application/assets/images/icon/search.png'; ?>
														<img class="menu-icon xCNMenuSearch" src="<?=$tMenuBar?>">
													</span>
												</div>
											</div>
										</div>

										<!--ตัวกรองค้นหาขั้นสูง-->
										<div class="col-lg-1">
											<div class="xCNFilter">
												<?php $tIconfilter = base_url().'application/assets/images/icon/filterNew.png'; ?>
												<img class="menu-icon xCNMenuSearch xCNIconFilter" src="<?=$tIconfilter?>">
											</div>
										</div>

										<!--นำเข้าข้อมูล-->
										<div class="col-lg-7">
											<div class="btn-group pull-right xCNImportBTN" style="float:right;">
												<button type="button" class="btn btn-secondary dropdown-toggle xCNImport" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													นำเข้าข้อมูล
												</button>
												<div class="dropdown-menu dropdown-menu-left xCNDropdown">
													<button class="dropdown-item xCNDropdownSub" type="button"><a style="color:#000000;" href='<?=base_url('application/assets/templates/Product_Import_Template.xlsx')?>'>ดาวน์โหลดไฟล์แม่แบบ</a></button>
													<button class="dropdown-item xCNDropdownSub <?=$tPer_create?>" type="button" onclick="JSxImportDataExcel()">นำเข้าข้อมูล ไฟล์</button>
													<input style="display:none;" type="file" id="ofeImportExcel" accept=".csv,application/vnd.ms-excel,.xlt,application/vnd.ms-excel,.xla,application/vnd.ms-excel,.xlsx,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,.xltx,application/vnd.openxmlformats-officedocument.spreadsheetml.template,.xlsm,application/vnd.ms-excel.sheet.macroEnabled.12,.xltm,application/vnd.ms-excel.template.macroEnabled.12,.xlam,application/vnd.ms-excel.addin.macroEnabled.12,.xlsb,application/vnd.ms-excel.sheet.binary.macroEnabled.12">
													<button class="dropdown-item xCNDropdownSub <?=$tPer_create?>" type="button" onclick="JSxExtractImage()">นำเข้าข้อมูล รูปภาพ</button>
													<input type="file" id="inputfileuploadImagePDT" style="display:none;" name="inputfileuploadImagePDT" accept=".zip" onchange="JSoExtractImageResize(this,'images/products_temp')">

												</div>
											</div>
										</div>

										<!--ตารางสินค้า-->
										<div class="col-lg-12">
											<div id="odvContent_Product" class="xCNContent"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<div>

<!--Modal กำลังประมวลผล-->
<button id="obtModalProcess" style="display:none;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#odvModalProcess"></button>
<div class="modal fade" id="odvModalProcess" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title">อัพโหลดไฟล์</h5>
		</div>
		<div class="modal-body">
			<label style="text-align: center; display: block;" id="olbModalProcessText">กรุณารอสักครู่ กำลังตรวจสอบไฟล์รูปภาพ</label>
			<label style="text-align: center; display: block; font-size: 17px;">โปรดอย่าปิดหน้าจอขณะอัพโหลดไฟล์</label>
			<div class="progress" style="height: 25px; width: 100%;">
				<div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
			</div>
		</div>
		</div>
	</div>
</div>

<script src="<?= base_url('application/assets/js/jFormValidate.js')?>"></script>

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

					$('#olbModalProcessText').text('กรุณารอสักครู่ กำลังตรวจสอบไฟล์');
					$('#obtModalProcess').click();

					$.ajax({
						type	: "POST",
						url		: "r_productCallpageUplodeFile",
						data	: { 'aPackdata' : aJSON },
						cache	: true,
						async	: true,
						timeout	: 0,
						success	: function (tResult) {
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
								}, 2000);

								setTimeout(function(){
									$('.content').html(tResult);
								}, 2500);
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
	//คำนวณหน้าจอ
	JSxCalculateWidthFilterAdv();
	function JSxCalculateWidthFilterAdv(){

		//โหลดครั้งเเรก
		var nWidth = $('.xCNFilterAdvParent').width();
		$('.xCNFilterSearch').css('width', nWidth +'px');

		//ทุกครั้งที่กดเมนู
		$('#menuToggle').click(function() {
			var nWidth = $('.xCNFilterAdvParent').width();
			$('.xCNFilterSearch').css('width', nWidth +'px');
		});

		//กำหนดขนาดของตารางค้นหา
		var tHeightContent = $(window).height() - 160;
		$('.xCNSubFilter').css('height',tHeightContent+'px');
	}

	$('.xCNFilter , .xCNCloseAdv').click(function() {
		var tCheck = $('.xCNFilterSearch').hasClass('xCNFilterBlockHide');
		if(tCheck == false){
			//Filter
			$('.xCNFilterSearch').removeClass("xCNFilterBlockShow");
			$('.xCNFilterSearch').addClass("xCNFilterBlockHide");

			//Content
			$('.xCNContentProduct').addClass('xCNUseFilter12');
			$('.xCNContentProduct').addClass('col-lg-12');
		}else{
			//Filter
			$('.xCNFilterSearch').removeClass("xCNFilterBlockHide");
			$('.xCNFilterSearch').addClass("xCNFilterBlockShow");

			//Content
			$('.xCNContentProduct').removeClass('xCNUseFilter12 col-lg-12');
			$('.xCNContentProduct').addClass('col-lg-9');
		}
	});

	//กดให้โชว์ช่องค้นหา
	$('.xCNFindClick').click(function(e) {
		var tTextFind = $(this).data('find');
		$('.xCNFind' + tTextFind).toggle('fast');
	});

	/************************************************************************************/ /*UPLOAD IMG*/

	//อัพโหลดไฟล์ zip
	function JSxExtractImage(){
		$('#inputfileuploadImagePDT').click();
	}

	//หลังจากอัพโหลด zip
	function JSxReturnExtractFileImage(){
		$('#obtModalProcess').click();
		$.ajax({
			type	: "POST",
			url		: "r_productCallpageUplodeImage",
			cache	: true,
			async	: false,
			timeout	: 0,
			success	: function (tResult) {
				JSxModalProgress('hide');
				setTimeout(function(){
					$('.content').html(tResult);
				}, 1000);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert(jqXHR, textStatus, errorThrown);
			}
		});
	}

	//อัพโหลดไม่ผ่าน
	function JSxFailUpLoadImage(){
		alert('รูปแบบไฟล์ไม่ถูกต้อง');
		$('#obtModalProcess').click();
		setTimeout(function(){
			JSxCallPageProductMain();
		}, 1000);
	}

	/*************************************************************************************/

	//กดนำไปใช้ หรือ ค้นหาขั้นสูง
	var aFilter 		= [];
	function JSxPDTFilterAdv(){
		$('.xCNFilterAdv:checked').each(function() {
			var tFilter 	= $(this).data('filter');
			var tValue 		= $(this).val();
			aFilter.push({'tFilter' : tFilter , 'tValue' : tValue});
		});

		var nPage = 1;
		var aFilterAdv = aFilter;
		JSwLoadTableList(nPage,aFilterAdv)
		aFilter = [];
	}

	//หน้าตาราง
	JSwLoadTableList(1);
	function JSwLoadTableList(pnPage,paFilterAdv){
		if(paFilterAdv == '' || paFilterAdv == null){
			paFilterAdv = '';
		}else{
			paFilterAdv = paFilterAdv;
		}

		$.ajax({
			type	: "POST",
			url		: "r_productload",
			data 	: {
						'nPage' 		: pnPage,
						'tSearchAll' 	: $('#oetSearch').val(),
						'aFilterAdv'	: paFilterAdv
					  },
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				JSxModalProgress('close');
				$('#odvContent_Product').html(tResult);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert(jqXHR, textStatus, errorThrown);
			}
		});
	}

	//โหลดหน้า เพิ่มข้อมูล
	function JSwProductCallPageInsert(ptType,ptCode){
		JSxModalProgress('open');
		$.ajax({
			type	: "POST",
			url		: "r_productcallpageInsertorEdit",
			data 	: {
						'tTypepage'  : ptType,
						'tCode'	 	 : ptCode
					  },
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

	//กด ย้อนกลับ(กลับหน้า main)
	function JSxCallPageProductMain(){
		JSxModalProgress('open');
		$.ajax({
			type	: "POST",
			url		: "r_product",
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
</script>
