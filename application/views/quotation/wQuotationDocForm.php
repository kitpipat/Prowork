<style>
	#ofmQuotationCst .form-group{
		margin-bottom : 0.25rem;
	}

	#ofmQuotationCst label{
		margin-bottom : 0rem;
	}

	#ofmQuotationHeader .form-group{
		margin-bottom : 0.25rem;
	}

	#ofmQuotationHeader label{
		margin-bottom : 0rem;
	}
</style>


<div class="container-fulid">

	<!--Section บน-->
	<div class="row">
		<div class="col-lg-6 col-md-6"><span class="xCNHeadMenuActive" onclick="FSvCallPageBackStep();">ใบเสนอราคา</span><span class="xCNHeadMenu">  /  รายละเอียด</span></div>

		<div class="col-lg-6 col-md-6 text-right">
					<button type="button" class="xCNButtonSave pull-right" onclick="FSxQUOSaveDoc()">บันทึก</button>
					<button type="button" class="xCNCalcelImport btn btn-outline-danger pull-right" style="margin-left:10px;">ยกเลิก</button>
					<button type="button" class="xCNButtonAprove-outline btn btn-outline-success pull-right" style="margin-left:10px;">พิมพ์</button>
					<button type="button" class="xCNButtonAprove-outline btn btn-outline-success pull-right" style="margin-left:10px;">อนุมัติ</button>
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
													<!--ลูกค้า-->
													<div class="col-lg-12">
														<div class="form-group">
															<label><span style="color:red;">*</span> ชื่อลูกค้า</label>
															<input type="text" class="form-control" maxlength="255" id="oetCstName" name="oetCstName" placeholder="กรุณาระบุชื่อลูกค้า" autocomplete="off" value="">
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
                            เลขที่เอกสาร : <span id="ospDocNo" data-docno="<?=$tDocNo?>">
                            <?php
																if($tDocNo == ""){
																		echo "<lable id='olbDocNo'> SQ########## </lable>";
																}else{
																		echo " <lable id='olbDocNo'> ".$tDocNo." </label> ";
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
										สถานะเอกสาร : <span id="ospStaDoc"></span>
										<hr>
										<form id="ofmQuotationHeader">
											<div class="row">

												<!--ยื่นราคาภายใน-->
												<div class="col-lg-6">
													<div class="form-group">
														<label>ยื่นราคาภายใน (วัน)</label>
														<input type="text" class="form-control xCNInputNumericWithDecimal text-right" maxlength="20" id="oetXqhSmpDay" name="oetXqhSmpDay" placeholder="1" autocomplete="off" value="">
													</div>
												</div>

												<!--มีผลถึงวันที่-->
												<div class="col-lg-6">
													<div class="form-group">
														<label>มีผลถึงวันที่</label>
														<input type="text" class="form-control xCNDatePicker" maxlength="20" id="odpXqhEftTo" name="odpXqhEftTo" placeholder="DD/MM/YYYY" autocomplete="off" value="">
													</div>
												</div>

												<!--เงื่อนไขการชำระเงิน-->
												<div class="col-lg-6">
													<div class="form-group">
														<label>เงื่อนไขการชำระเงิน</label>
														<select class="form-control" id="odpXqhEftTo" name="odpXqhEftTo">
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
														<input type="text" class="form-control xCNInputNumericWithDecimal text-right" maxlength="20" id="oetXqhCredit" name="oetXqhCredit" placeholder="1" autocomplete="off" value="">
													</div>
												</div>

												<!--กำหนดส่งของ-->
												<div class="col-lg-6">
													<div class="form-group">
														<label>กำหนดส่งของ</label>
														<input type="text" class="form-control xCNDatePicker" maxlength="20" id="odpDeliveryDate" name="odpDeliveryDate" placeholder="DD/MM/YYYY" autocomplete="off" value="">
													</div>
												</div>

												<!--เงื่อนไขการชำระเงิน-->
												<div class="col-lg-6">
													<div class="form-group">
														<label>ประเภทภาษี</label>
														<select class="form-control" id="ocmVatType" name="ocmVatType">
																<option value="1">แยกนอก</option>
																<option value="2">รวมใน</option>
														</select>
													</div>
												</div>
											</div>
										</form>

										<div><hr></div>

										<div class="row">
												<div class="col-lg-6">
													<label class="container-checkbox">เอกสารด่วน
														<input type="checkbox" id="ocbStaExpress" name="ocbStaExpress" value="1">
														<span class="checkmark"></span>
													</label>
												</div>
												<div class="col-lg-6">
													ผู้บันทึก : <span id="ospCreateBy"></span>
												</div>

												<div class="col-lg-6">
													<label class="container-checkbox">เคลื่อนไหว
														<input type="checkbox" id="ocbtStaDocActive" name="ocbtStaDocActive" value="1">
														<span class="checkmark"></span>
													</label>
												</div>
												<div class="col-lg-6">
													ผู้อนุมัติ : <span id="ospApprovedBy"></span>
												</div>

												<div class="col-lg-6">
													<label class="container-checkbox">จัดส่งสินค้าแล้ว
														<input type="checkbox" id="ocbStaDeli" name="ocbStaDeli" value="1">
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
                <div class="col-lg-12">
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
																<div class="">
																	<input type="text" autocomplete="off"  id="oetXqhDisText"  class="text-right form-control xCNInputNumericWithDecimal">
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
														<label>ภาษีมูลค่าเพิ่ม (%)</label>
													</div>

													<div class="col-lg-6 text-right">
														<div class="row">
															<div class="col-lg-6">
																<div class="">
																	<input type="text" autocomplete="off" id="oetVatRate"  class="text-right form-control xCNInputNumericWithDecimal">
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

<link rel="stylesheet" href="<?=base_url('application/assets/css/quotation.css') ?>">
<script type="text/javascript" src="<?=base_url('application/assets/js/jFormValidate.js')?>"></script>
<script type="text/javascript" src="<?=base_url('application/assets/js/account.js') ?>"></script>
<script type="text/javascript" src="<?=base_url('application/assets/js/moment.js') ?>"></script>
<script type="text/javascript" src="<?=base_url('application/assets/js/jThaiBath.js') ?>"></script>

<?php include ('script/jquotation_doc.php'); ?>

<script>

	$('ducument').ready(function(){ 
			$('.xCNDatePicker').datepicker({ 
				format          : 'dd/mm/yyyy',
				autoclose       : true,
				todayHighlight  : true,
				orientation		: "bottom right"
			});

		});
		
	function FSvCallPageBackStep(){
		$.ajax({
			type	: "POST",
			url		: "r_quotation/1",
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				$('.content').html(tResult);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert(jqXHR, textStatus, errorThrown);
			}
		});
	}
</script>
