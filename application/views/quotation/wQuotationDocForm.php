<style>
	#ofmQuotationCst .form-group {
		margin-bottom: 0.25rem;
	}

	#ofmQuotationCst label {
		margin-bottom: 0rem;
	}

	#ofmQuotationHeader .form-group {
		margin-bottom: 0.25rem;
	}

	#ofmQuotationHeader label {
		margin-bottom: 0rem;
	}
</style>

<?php
	if($tRouteFrom == 'List'){
		//ถ้ากดเช้ามาจากหน้า list เวลาย้อนกลับต้องย้อนกลับไปหน้า list
		$tRoute 			= 'r_quotationList';
		$tEvent 			= 'Edit';
		$tEventHide 		= '';
		$tEventHidePrint 	= 'xCNHide';
	}else{
		//ถ้ากดเช้ามาจากหน้า create เวลาย้อนกลับต้องย้อนกลับไปหน้า create
		$tRoute 			= 'r_quotation/1';
		$tEvent 			= 'Insert';
		$tEventHide 		= 'xCNHide';
		$tEventHidePrint 	= 'xCNHide';
	}
?>

<div class="container-fulid">

	<!--Section บน-->
	<div class="row">
		<div class="col-lg-6 col-md-6"><span class="xCNHeadMenuActive" onclick="FSvCallPageBackStep('<?=$tRoute?>');">ใบเสนอราคา</span><span class="xCNHeadMenu"> / รายละเอียด</span></div>

		<div class="col-lg-6 col-md-6 text-right">
			<button type="button" class="xCNButtonSave pull-right" onclick="FSxQUOSaveDoc()">บันทึก</button>
			<button type="button" class="<?=$tEventHide?> xCNAprove xCNButtonAprove-outline btn btn-outline-success pull-right" style="margin-right:10px;" onclick="FSxQUOAproveDocument()">อนุมัติ</button>
			<button type="button" class="<?=$tEventHide?> xCNCancel xCNCalcelImport btn btn-outline-danger pull-right" style="margin-right:10px;" onclick="FSxQUOCancleDocument()">ยกเลิก</button>
			<button type="button" class="<?=$tEventHidePrint?> xCNPrint xCNButtonAprove-outline btn btn-outline-success pull-right" >พิมพ์</button>
		</div>
	</div>

	<div class="row" style="margin-top: 10px;">

		<!--ข้อมูลลูกค้า-->
		<div class="col-lg-6">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<!--Head-->
						<div class="col-lg-12">
							<div class="xCNHeadFooterINPDT"><span>ข้อมูลลูกค้า</span></div>
						</div>

						<!--Detail-->
						<div class="col-lg-12">
							<form id="ofmQuotationCst">
								<div class="row">

									<!--รหัสลูกค้า-->
									<input type="hidden" id="ohdCustomerCode" name="ohdCustomerCode" >

									<!--ลูกค้า-->
									<div class="col-lg-12">
										<label><span style="color:red;">*</span> ชื่อลูกค้า</label>
										<div class="input-group md-form form-sm form-2 pl-0 form-group">
											<input type="text" class="form-control" maxlength="255" id="oetCstName" name="oetCstName" placeholder="กรุณาระบุชื่อลูกค้า" autocomplete="off" value="">
											<div class="input-group-append">
												<span class="input-group-text red lighten-3" style="cursor:pointer;" onclick="JSxChooseCustomer();"><i class="fa fa-search" aria-hidden="true"></i></span>
											</div>
										</div>
									</div>

									<!--ที่อยู่-->
									<div class="col-lg-12">
										<div class="form-group">
											<label>ที่อยู่</label>
											<textarea type="text" class="form-control" id="oetAddress" name="oetAddress" placeholder="ที่อยู่" rows="2"></textarea>
										</div>
									</div>

									<!--เลขที่ประจำตัวผู้เสียภาษี-->
									<div class="col-lg-12">
										<div class="form-group">
											<label>เลขที่ประจำตัวผู้เสียภาษี</label>
											<input type="text" class="form-control xCNInputNumericWithDecimal" maxlength="20" id="oetTaxNo" name="oetTaxNo" placeholder="กรุณาระบุเลขที่ประจำตัวผู้เสียภาษี" autocomplete="off" value="">
										</div>
									</div>

									<!--ผู้ติดต่อ-->
									<div class="col-lg-6">
										<div class="form-group">
											<label>ผู้ติดต่อ</label>
											<input type="text" class="form-control" maxlength="50" id="oetContact" name="oetContact" placeholder="กรุณาระบุชื่อผู้ติดต่อ" autocomplete="off" value="">
										</div>
									</div>

									<!--อีเมลล์-->
									<div class="col-lg-6">
										<div class="form-group">
											<label>อีเมลล์</label>
											<input type="text" class="form-control" maxlength="50" id="oetEmail" name="oetEmail" placeholder="กรุณาระบุอีเมลล์" autocomplete="off" value="">
										</div>
									</div>

									<!--เบอร์โทรศัพท์-->
									<div class="col-lg-6">
										<div class="form-group">
											<label>เบอร์โทรศัพท์</label>
											<input type="text" class="form-control" maxlength="20" id="oetTel" name="oetTel" placeholder="กรุณาระบุเบอร์โทรศัพท์" autocomplete="off" value="">
										</div>
									</div>

									<!--เบอร์โทรศัพท์-->
									<div class="col-lg-6">
										<div class="form-group">
											<label>เบอร์โทรสาร</label>
											<input type="text" class="form-control xCNInputNumericWithDecimal" maxlength="20" id="oetFax" name="oetFax" placeholder="กรุณาระบุเบอร์โทรสาร" autocomplete="off" value="">
										</div>
									</div>

									<!--เบอร์โทรศัพท์-->
									<div class="col-lg-6">
										<div class="form-group">
											<label>ชื่อโครงการ</label>
											<input type="text" class="form-control" maxlength="100" id="oetPrjName" name="oetPrjName" placeholder="กรุณาระบุชื่อโครงการ" autocomplete="off" value="">
										</div>
									</div>

									<!--หมายเลขอ้างอิง-->
									<div class="col-lg-6">
										<div class="form-group">
											<label>หมายเลขอ้างอิง</label>
											<input type="text" class="form-control" maxlength="20" id="oetPrjCodeRef" name="oetPrjCodeRef" placeholder="กรุณาระบุหมายเลขอ้างอิง" autocomplete="off" value="">
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!--ข้อมูลเอกสาร-->
		<div class="col-lg-6">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<!--Head-->
						<div class="col-lg-6">
							<div class="xCNHeadFooterINPDT" style="background-color:#a3e69e; color:#000;">
								เลขที่เอกสาร : <span id="ospDocNo" data-docno="<?= $tDocNo ?>">
									<?php
									if ($tDocNo == "") {
										echo "<lable id='olbDocNo'> SQ########## </lable>";
									} else {
										echo " <lable id='olbDocNo'> " . $tDocNo . " </label> ";
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
							<form id="ofmQuotationHeader">
								<div class="row">

									<!--ยื่นราคาภายใน-->
									<div class="col-lg-6">
										<div class="form-group">
											<label>ยื่นราคาภายใน (วัน)</label>
											<input type="text" class="form-control xCNInputNumericWithDecimal text-right" maxlength="20" id="oetXqhSmpDay" name="oetXqhSmpDay" placeholder="1" autocomplete="off">
										</div>
									</div>

									<!--มีผลถึงวันที่-->
									<div class="col-lg-6">
										<div class="form-group">
											<label>มีผลถึงวันที่</label>
											<input type="text" class="form-control xCNDatePicker" maxlength="20" id="odpXqhEftTo" name="odpXqhEftTo" placeholder="DD/MM/YYYY" autocomplete="off">
										</div>
									</div>

									<!--เงื่อนไขการชำระเงิน-->
									<div class="col-lg-6">
										<div class="form-group">
											<label>เงื่อนไขการชำระเงิน</label>
											<select class="form-control" id="osmCashorCard" name="osmCashorCard">
												<option value="">เลือกประเภทการชำระ</option>
												<option value="1">เงินสด</option>
												<option value="2">เครดิต</option>
											</select>
										</div>
									</div>

									<!--จำนวนวันเครดิต-->
									<div class="col-lg-6">
										<div class="form-group">
											<label>จำนวนวันเครดิต (วัน)</label>
											<input type="text" class="form-control xCNInputNumericWithDecimal text-right" maxlength="20" id="oetXqhCredit" name="oetXqhCredit" placeholder="1" autocomplete="off">
										</div>
									</div>

									<!--กำหนดส่งของ-->
									<div class="col-lg-6">
										<div class="form-group">
											<label>กำหนดส่งของ</label>
											<input type="text" class="form-control xCNDatePicker" maxlength="20" id="odpDeliveryDate" name="odpDeliveryDate" placeholder="DD/MM/YYYY" autocomplete="off">
										</div>
									</div>

									<!--เงื่อนไขการชำระเงิน-->
									<div class="col-lg-6">
										<div class="form-group">
											<label>ประเภทภาษี</label>
											<select class="form-control" id="ocmVatType" name="ocmVatType" onchange="FSvQUODocItems()">
												<option value="1">แยกนอก</option>
												<option value="2">รวมใน</option>
											</select>
										</div>
									</div>
								</div>
							</form>

							<div>
								<hr>
							</div>

							<div class="row">
								<div class="col-lg-6">
									<label class="container-checkbox">เอกสารด่วน
										<input type="checkbox" id="ocbStaExpress" name="ocbStaExpress">
										<span class="checkmark"></span>
									</label>
								</div>
								<div class="col-lg-6">
									ผู้บันทึก : <span id="ospCreateBy"></span>
								</div>

								<div class="col-lg-6">
									<label class="container-checkbox">เคลื่อนไหว
										<input type="checkbox" id="ocbtStaDocActive" name="ocbtStaDocActive">
										<span class="checkmark"></span>
									</label>
								</div>
								<div class="col-lg-6">
									ผู้อนุมัติ : <span id="ospApprovedBy"></span>
								</div>

								<div class="col-lg-6">
									<label class="container-checkbox">จัดส่งสินค้าแล้ว
										<input type="checkbox" id="ocbStaDeli" name="ocbStaDeli" >
										<span class="checkmark"></span>
									</label>
								</div>
								<div class="col-lg-6">
									วันที่อนุมัติ : <span id="ospApproveDate"></span>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

	<div class="card">
		<div class="card-body" style="height:auto">
			<div class="row">
				<div class="col-lg-12" id="odvQuoDocItems"></div>
				<div class="col-lg-12" id="odvMoreItem">
					<button class="xCNButtonInsert pull-left" onclick="xxxxx()">+</button><span id="ospmorePDT">เพิ่มเติมรายการสินค้า</span>
				</div>
			</div>
		</div>
	</div>

	<div class="row">

		<div class="col-lg-7">
			<div class="card">
				<div class="card-body" style="height:auto">
					<div class="row">
						<!--ราคาสรุปบิล-->
						<div class="col-lg-12">
							<div class="xCNSpanTotalText">
								<span id="ospTotalText"></span>
							</div>
						</div>

						<!--หมายเหตุ-->
						<div class="col-lg-12" style="margin-top:10px;">
							<div class="form-group">
								<label>หมายเหตุเอกสาร</label>
								<textarea type="text" class="form-control" id="otaDocRemark" name="otaDocRemark" placeholder="หมายเหตุเอกสาร" rows="3"></textarea>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-5">
			<div class="card">
				<div class="card-body" style="height:auto">
					<div class="row">
						<!--จำนวนเงินรวม-->
						<div class="col-lg-6">
							<label>จำนวนเงินรวม</label>
						</div>

						<div class="col-lg-6 text-right">
							<label class="text-right xCNTotal" id="otdDocNetTotal">0.00</label>
						</div>

						<!--ส่วนลด-->
						<div class="col-lg-6">
							<label>ส่วนลด</label>
						</div>

						<div class="col-lg-6 text-right">
							<div class="row">
								<div class="col-lg-6">
									<div class="input-container">
										<i class="xWBnticon fa fa-info-circle fa-xs"
										   style="font-size: 0.5rem;"
										   title="กรอกส่วนลดเช่น 10% หรือ 100 แล้วกดปุ่ม Enter"
										   onclick="alert('กรอกส่วนลดเช่น 10% หรือ 100 แล้วกดปุ่ม Enter')"></i>
										<input type="text"
										       autocomplete="off"
													 id="oetXqhDisText"
													 class="text-right form-control xCNNumberandPercent"
													 onkeypress="return FSxQUODocFootDis(event,this)">
									</div>
								</div>
								<div class="col-lg-6">
									<label class="text-right xCNTotal" id="ospXqhDis">0.00</label>
								</div>
							</div>
						</div>

						<!--จำนวนเงินหลังหักส่วนลด-->
						<div class="col-lg-6">
							<label>จำนวนเงินหลังหักส่วนลด</label>
						</div>

						<div class="col-lg-6 text-right">
							<label class="text-right xCNTotal" id="otdNetAFHD">0.00</label>
						</div>

						<!--ภาษีมูลค่าเพิ่ม-->
						<div class="col-lg-6">
							<label>ภาษีมูลค่าเพิ่ม (7%)</label>
						</div>

						<div class="col-lg-6 text-right">
							<div class="row">
								<div class="col-lg-6">
									<div class="">
										<input type="text" autocomplete="off" id="oetVatRate" class="text-right form-control xCNInputNumericWithDecimal" style="display:none">
									</div>
								</div>
								<div class="col-lg-6">
									<label class="text-right xCNTotal" id="otdVat">0.00</label>
								</div>
							</div>
						</div>

						<!--จำนวนเงินรวมทั้งสิ้น-->
						<div class="col-lg-6">
							<label>จำนวนเงินรวมทั้งสิ้น</label>
						</div>

						<div class="col-lg-6 text-right">
							<label class="text-right xCNTotal" id="otdGrandTotal">0.00</label>
						</div>

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
				<label style="text-align: left; display: block; margin: 0px;">4. สินค้าในเอกสารจะถูกนำไปทำรายการ</label>
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

<!-- Modal ให้เลือกลูกค้า -->
<button id="obtModalSelectCustomer" style="display:none;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#odvModalSelectCustomer"></button>
<div class="modal fade" id="odvModalSelectCustomer" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<h5 class="modal-title">เลือกลูกค้า</h5>
					</div>
					<div class="col-lg-6 col-md-6"></div>
				</div>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<div class="input-group md-form form-sm form-2 pl-0">
							<input class="form-control my-0 py-1 red-border xCNFormSerach" autocomplete="off" type="text" placeholder="กรุณากรอกคำที่ต้องการค้นหา" id="oetSearchCustomer" onkeypress="Javascript:if(event.keyCode==13) JSxSelectCustomer(1)">
							<div class="input-group-append">
								<span class="input-group-text red lighten-3" style="cursor:pointer;" onclick="JSxSelectCustomer(1);"><i class="fa fa-search" aria-hidden="true"></i></span>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6">
						<button type="button" class="btn  btn-success xCNConfirmCustomer" onclick="JSxInsCustomerToForm();" style="float: right;">ยืนยัน</button>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12 col-md-12">
						<div id="odvContentSelectCustomer" style="margin-top:10px;"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<link rel="stylesheet" href="<?= base_url('application/assets/css/quotation.css') ?>">
<script type="text/javascript" src="<?= base_url('application/assets/js/jFormValidate.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('application/assets/js/account.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('application/assets/js/moment.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('application/assets/js/jThaiBath.js') ?>"></script>

<?php include('script/jquotation_doc.php'); ?>

<script>
	$('ducument').ready(function() {
		$('.xCNDatePicker').datepicker({
			format: 'dd/mm/yyyy',
			autoclose: true,
			todayHighlight: true,
			orientation: "bottom right"
		});

	});

	//กดย้อนกลับ
	function FSvCallPageBackStep(ptRoute) {
		$.ajax({
			type	: "POST",
			url		: ptRoute,
			cache	: false,
			timeout	: 0,
			success	: function(tResult) {
				$('.content').html(tResult);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert(jqXHR, textStatus, errorThrown);
			}
		});
	}

	//เลือกลูกค้า
	function JSxChooseCustomer(){
		$('#obtModalSelectCustomer').click();
		JSxSelectCustomer(1);
	}

	//เลือกลูกค้า
	function JSxSelectCustomer(pnPage){
		$.ajax({
			type	: "POST",
			url		: "r_selectCustomer",
			data 	: { 'nPage' : pnPage , 'tSearchCustomer' : $('#oetSearchCustomer').val() },
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				$('#odvContentSelectCustomer').html(tResult);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert(jqXHR, textStatus, errorThrown);
			}
		});
	}

	//กดยืนยันเลือกลูกค้า
	function JSxInsCustomerToForm(){
		var LocalItemSelect = localStorage.getItem("LocalItemData");
		if(LocalItemSelect !== null){
			var aResult = LocalItemSelect.split(",");

			var tCusname			= aResult[0];
			var tCustomercode 		= aResult[1];
			var tAddress 			= aResult[2];
			var tTaxno 				= aResult[3];
			var tContactname 		= aResult[4];
			var tEmail 				= aResult[5];
			var tTel 				= aResult[6];
			var tFax 				= aResult[7];

			$('#oetCstName').val(tCusname);
			$('#oetAddress').text(tAddress);
			$('#oetTaxNo').val(tTaxno);
			$('#oetContact').val(tContactname);
			$('#oetEmail').val(tEmail);
			$('#oetTel').val(tTel);
			$('#oetFax').val(tFax);
			$('#ohdCustomerCode').val(tCustomercode);

			obj = [];
			localStorage.clear();
			$('#obtModalSelectCustomer').click();
		}else{

		}
	}
</script>
