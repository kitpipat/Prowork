<style>
	#ofmPurchaseorderSPL .form-group {
		margin-bottom: 0.25rem;
	}

	#ofmPurchaseorderSPL label {
		margin-bottom: 0rem;
	}

	#ofmPurchaseorderHeader .form-group {
		margin-bottom: 0.25rem;
	}

	#ofmPurchaseorderHeader label {
		margin-bottom: 0rem;
	}
</style>

<?php
	$tLevelUser = $this->session->userdata('tSesUserLevel');
	if($tTypePage == 'insert'){
		$tRoute 			= 'r_purchaseordereventinsert';
		$tRouteUrl			= 'สร้างใบสั่งซื้อ';
		$tDocumentNumber	= 'PO##########';
		$dDocumentDate		= date('d/m/Y') . ' - ' . date("H:i:s");
		$tDocumentCreate	= $this->session->userdata('tSesFirstname') . ' ' . $this->session->userdata('tSesLastname');
		$tDocumentStaDoc	= '-';
		$tDocumentStaApv	= '-';
	}else if($tTypePage == 'edit'){
		$tRoute 			= 'r_purchaseordereventedit';
		$tRouteUrl			= 'แก้ไขใบสั่งซื้อ';
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
		<div class="col-lg-6 col-md-6"><span class="xCNHeadMenuActive" onclick="JSxCallPagePOMain();">ใบสั่งซื้อ</span><span class="xCNHeadMenu">  /  <?=$tRouteUrl?></span></div>
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
							<form id="ofmPurchaseorderSPL">
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
											<input type="hidden" id="oetSplCode" name="oetSplCode" >
											<input type="text" class="form-control" maxlength="255" id="oetSplName" name="oetSplName" placeholder="กรุณาระบุผู้จำหน่าย" autocomplete="off" value="">
											<div class="input-group-append <?=$tAlwCustomer?> xCNIconFindCustomer">
												<span class="input-group-text red lighten-3" style="cursor:pointer;" onclick="JSxChooseSupplier();">
													<img class="xCNIconFind">
												</span>
											</div>
										</div>
									</div>

									<!--ที่อยู่-->
									<div class="col-lg-12">
										<div class="form-group">
											<label>ที่อยู่</label>
											<textarea type="text" class="form-control" id="oetPOAddress" name="oetPOAddress" placeholder="รายละเอียดที่อยู่" rows="4" disabled="disabled"></textarea>
										</div>
									</div>

									<!--ผู้ติดต่อ-->
									<div class="col-lg-6">
										<div class="form-group">
											<label>ผู้ติดต่อ</label>
											<input type="text" class="form-control" maxlength="50" id="oetPOContact" name="oetPOContact" placeholder="รายละเอียดชื่อผู้ติดต่อ" autocomplete="off" value="" disabled="disabled">
										</div>
									</div>

									<!--อีเมลล์-->
									<div class="col-lg-6">
										<div class="form-group">
											<label>อีเมลล์</label>
											<input type="text" class="form-control" maxlength="50" id="oetPOEmail" name="oetPOEmail" placeholder="รายละเอียดอีเมลล์" autocomplete="off" value="" disabled="disabled">
										</div>
									</div>

									<!--เบอร์โทรศัพท์-->
									<div class="col-lg-6">
										<div class="form-group">
											<label>เบอร์โทรศัพท์</label>
											<input type="text" class="form-control" maxlength="20" id="oetPOTel" name="oetPOTel" placeholder="รายละเอียดเบอร์โทรศัพท์" autocomplete="off" value="" disabled="disabled">
										</div>
									</div>

									<!--เบอร์โทรสาร-->
									<div class="col-lg-6">
										<div class="form-group">
											<label>เบอร์โทรสาร</label>
											<input type="text" class="form-control xCNInputNumericWithDecimal" maxlength="20" id="oetPOFax" name="oetPOFax" placeholder="รายละเอียดเบอร์โทรสาร" autocomplete="off" value="" disabled="disabled">
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
								เลขที่เอกสาร : <span id="ospPODocNo" data-docno="<?=$tDocumentNumber ?>"><lable id='olbPODocNo'><?=$tDocumentNumber?></lable></span>
							</div>
						</div>

						<!--Head-->
						<div class="col-lg-6">
							<div class="xCNHeadFooterINPDT" style="background-color:#a3e69e; color:#000;">
								วันที่เอกสาร : <span id="ospPODocDate"></span>
							</div>
						</div>

						<!--Detail-->
						<div class="col-lg-12">
							<div class="row">
								<div class="col-lg-6">
									<span>สถานะเอกสาร : </span><span id="ospPOStaDoc"></span>
									<input type="hidden" id="ohdPOStaDoc">
								</div>
								<div class="col-lg-6">
									<span>สถานะอนุมัติเอกสาร : </span><span id="ospPOStaDocApv"></span>
									<input type="hidden" id="ohdPOStaApv">
								</div>
							</div>
							<hr>

							<form id="ofmPurchaseorderHeader">
								<div class="row">

									<!--จัดส่งวันที่-->
									<div class="col-lg-6">
										<div class="form-group">
											<label>จัดส่งวันที่</label>
											<input type="text" class="form-control xCNDatePicker" maxlength="20" id="odpPOXqhEftTo" name="odpPOXqhEftTo" placeholder="DD/MM/YYYY" autocomplete="off">
										</div>
									</div>

									<!--เงื่อนไขการชำระเงิน-->
									<div class="col-lg-6">
										<div class="form-group">
											<label>เงื่อนไขการชำระเงิน</label>
											<select class="form-control" id="osmPOCashorCard" name="osmPOCashorCard">
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
											<input type="text" class="form-control xCNInputNumericWithDecimal text-right" maxlength="20" id="oetPOXqhCredit" name="oetPOXqhCredit" placeholder="0" autocomplete="off">
										</div>
									</div>

									<!--เงื่อนไขการชำระเงิน-->
									<div class="col-lg-6">
										<div class="form-group">
											<label>ประเภทภาษี</label>
											<select class="form-control" id="ocmPOVatType" name="ocmPOVatType" onchange="JSvLoadTableDTTmp(1)">
												<option value="1">แยกนอก</option>
												<option value="2">รวมใน</option>
											</select>
										</div>
									</div>

									<!--เงื่อนไขการชำระ-->
									<div class="col-lg-12">
										<div class="form-group">
											<label>เงื่อนไขการชำระ</label>
											<textarea type="text" class="form-control" id="oetPORemark" name="oetPORemark" placeholder="เงื่อนไขการชำระ" rows="2" disabled="disabled"></textarea>
										</div>
										<hr style="margin-bottom: 13px;">
									</div>
								</div>
							</form>

							<div class="row">
								<div class="col-lg-4">
									ผู้บันทึก : <span id="ospPOCreateBy"> - </span>
								</div>

								<div class="col-lg-4">
									ผู้อนุมัติ : <span id="ospPOApprovedBy"> - </span>
								</div>

								<div class="col-lg-4">
									วันที่อนุมัติ : <span id="ospPOApproveDate"> - </span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!--รายการสินค้า-->
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body" style="height:auto">
					<div class="row">
						<div class="col-lg-12" id="odvMoreItem">
							<button class="xCNButtonInsert pull-right" onclick="FSxPODocAddDT()">+</button>
						</div>
						<div class="col-lg-12" id="odvPODocDTItems" style="overflow: auto; width: 900px; margin-bottom: 1rem;"></div>
					</div>
				</div>
			</div>
		</div>

		<!--ส่วนสรุปราคา-->
		<div class="col-lg-7">
			<div class="card">
				<div class="card-body" style="height:auto">
					<div class="row">
						<!--ราคาสรุปบิล-->
						<div class="col-lg-12">
							<div class="xCNSpanTotalText">
								<span id="ospPOTotalText"></span>
							</div>
						</div>

						<!--หมายเหตุ-->
						<div class="col-lg-12" style="margin-top:10px;">
							<div class="form-group">
								<label>หมายเหตุเอกสาร</label>
								<textarea type="text" class="form-control" id="otaPODocRemark" name="otaPODocRemark" placeholder="หมายเหตุเอกสาร" rows="3"></textarea>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!--ส่วนลดท้ายบิล-->
		<div class="col-lg-5">
			<div class="card">
				<div class="card-body" style="height:auto">
					<div class="row">
						<!--จำนวนเงินรวม-->
						<div class="col-lg-6">
							<label>จำนวนเงินรวม</label>
						</div>

						<div class="col-lg-6 text-right">
							<label class="text-right xCNTotal" id="otdPODocNetTotal">0.00</label>
						</div>

						<!--ส่วนลด-->
						<div class="col-lg-5">
							<label>ส่วนลด</label>
						</div>

						<div class="col-lg-7 text-right">
							<div class="row">
								<div class="col-lg-7">
									<div class="input-container" style="margin-bottom:0px;">
										<i class="xWBnticon fa fa-info-circle fa-xs"
										   style="font-size: 0.5rem;"
										   title="กรอกส่วนลดเช่น 10% หรือ 100 แล้วกดปุ่ม Enter"
										   onclick="alert('กรอกส่วนลดเช่น 10% หรือ 100 แล้วกดปุ่ม Enter')"></i>
										<input type="text"
										       autocomplete="off"
													id="oetPOXqhDisText"
													class="text-right form-control xCNNumberandPercent xCNXqhDisText"
													maxlength="20" onkeyup="FSXQUOCheckInputDis(this)">
									</div>
								</div>
								<div class="col-lg-5">
									<label class="text-right xCNTotal" id="ospPOXqhDis">0.00</label>
								</div>
							</div>
						</div>

						<!--จำนวนเงินหลังหักส่วนลด-->
						<div class="col-lg-6">
							<label>จำนวนเงินหลังหักส่วนลด</label>
						</div>

						<div class="col-lg-6 text-right">
							<label class="text-right xCNTotal" id="otdPONetAFHD">0.00</label>
						</div>

						<!--ภาษีมูลค่าเพิ่ม-->
						<div class="col-lg-6">
							<label id="olbPOVatText">ภาษีมูลค่าเพิ่ม (7%)</label>
						</div>

						<div class="col-lg-6 text-right">
							<div class="row">
								<div class="col-lg-6">
									<div class="">
										<input type="text" autocomplete="off" id="oetPOVatRate" class="text-right form-control xCNInputNumericWithDecimal" style="display:none" value="7">
									</div>
								</div>
								<div class="col-lg-6">
									<label class="text-right xCNTotal" id="otdPOVat">0.00</label>
								</div>
							</div>
						</div>

						<!--จำนวนเงินรวมทั้งสิ้น-->
						<div class="col-lg-6">
							<label>จำนวนเงินรวมทั้งสิ้น</label>
						</div>

						<div class="col-lg-6 text-right">
							<label class="text-right xCNTotal" id="otdPOGrandTotal">0.00</label>
						</div>

					</div>
				</div>
			</div>
		</div>

	</div>
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
				</div>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<div class="input-group md-form form-sm form-2 pl-0">
							<input class="form-control my-0 py-1 red-border xCNFormSerach" autocomplete="off" type="text" placeholder="กรุณากรอกคำที่ต้องการค้นหา" id="oetSearchPDTToTmp" onkeypress="Javascript:if(event.keyCode==13) JSxSelectPDTToTmp_PO(1)">
							<div class="input-group-append">
								<span class="input-group-text red lighten-3" style="cursor:pointer;" onclick="JSxSelectPDTToTmp_PO(1);">
									<?php $tMenuBar = base_url().'application/assets/images/icon/search.png'; ?>
									<img class="menu-icon xCNMenuSearch" src="<?=$tMenuBar?>">
								</span>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6">
						<button type="button" class="btn  btn-success xCNConfirmPDT" onclick="JSxInsPDTToTmp_PO();" style="float: right;">ยืนยัน</button>
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

<!--Modal ต้องเลือกผู้จำหน่าย-->
<button id="obtModalSPLNotNull" style="display:none;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#odvModalSPLNotNull"></button>
<div class="modal fade" id="odvModalSPLNotNull" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">แจ้งเตือน</h5>
			</div>
			<div class="modal-body">
				<label style="text-align: left; display: block;">กรุณาเลือกผู้จำหน่ายก่อนทำรายการ</label>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary xCNCloseDelete" data-dismiss="modal" style="width: 100px;">ยืนยัน</button>
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
			orientation		: "bottom right"
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
			var aResult = LocalItemSelect.split("##");
			tSplname,tSplcode,tSpladdress,tContact,tTel,tFax,tEmail,nSplvattype,nSplvat
			
			var tSplname 		= aResult[0];
			var tSplcode		= aResult[1];
			var tSpladdress		= (aResult[2]) == '' ? '-' : aResult[2] ;
			var tContact		= (aResult[3]) == '' ? '-' : aResult[3] ;
			var tTel			= (aResult[4]) == '' ? '-' : aResult[4] ;
			var tFax			= (aResult[5]) == '' ? '-' : aResult[5] ;
			var tEmail			= (aResult[6]) == '' ? '-' : aResult[6] ;
			var nSplvattype		= (aResult[7]) == '' ? '1' : aResult[7] ;
			var nSplvat			= (aResult[8]) == '' ? '7' : aResult[8] ;

			$('#oetSplCode').val(tSplcode);
			$('#oetSplName').val(tSplname);
			$('#oetPOAddress').val(tSpladdress);
			$('#oetPOContact').val(tContact);
			$('#oetPOEmail').val(tEmail);
			$('#oetPOTel').val(tTel);
			$('#oetPOFax').val(tFax);

			//มูลค่าภาษี
			$('#olbPOVatText').text('ภาษีมูลค่าเพิ่ม ('+nSplvat+'%)')
			$("#oetPOVatRate").val(nSplvat);

			//ประเภทภาษี
			$('#ocmPOVatType').val(nSplvattype);

			obj = [];
			localStorage.clear();
			$('#obtModalSelectSupplier').click();
		}else{

		}
	}

	//โหลดข้อมูลตารางสินค้า DT
	JSvLoadTableDTTmp(1);
	function JSvLoadTableDTTmp(pnPage){
		$.ajax({
			type	: "POST",
			url		: "r_purchaseorderLoadItem",
			data 	: {
						'tTypepage'  			: '<?=$tTypePage?>',
						'tCode'	 	 			: '<?=$tDocumentNumber?>',
						'nPage' 				: pnPage
					  },
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				JSxModalProgress('close');
				$('#odvPODocDTItems').html(tResult);
				JSxPOCalculateFooter();
			},
			error: function (jqXHR, textStatus, errorThrown) {
				JSxModalErrorCenter(jqXHR.responseText);
			}
		});
	}

	//คำนวณส่วนลดท้ายบิล
	function JSxPOCalculateFooter(){
		nDocNetTotal = parseFloat($("#ospPODocNetTotal").text())
		$("#otdPODocNetTotal").text(accounting.formatMoney(nDocNetTotal.toFixed(2), ""))

		nFooterDis 	= $("#ospPOXqhDis").text()
		nFooterDis 	= parseFloat(nFooterDis.replace(',', ' ').replace(' ', ''))
		nNetAFHD 	= nDocNetTotal - (nFooterDis);

		$("#otdPONetAFHD").text(accounting.formatMoney(nNetAFHD.toFixed(2), ""))

		nVatType 	= $("#ocmPOVatType").val()
		nVatRate 	= $("#oetPOVatRate").val()
		nVat 		= 0
		nGrandTotal = 0

		if (nVatType == "1") {
			nVat = ((nNetAFHD * (100 + parseInt(nVatRate))) / 100) - nNetAFHD
			nGrandTotal = parseFloat(nNetAFHD) + parseFloat(nVat.toFixed(2))
		} else {
			nVat = nNetAFHD - ((nNetAFHD * 100) / (100 + parseInt(nVatRate)))
			nGrandTotal = parseFloat(nNetAFHD)
		}

		$("#otdPOVat").text(accounting.formatMoney(nVat.toFixed(2), ""))
		$("#otdPOGrandTotal").text(accounting.formatMoney(nGrandTotal.toFixed(2), ""))

		//สรุปบิล เป็น TEXT
		var tTextTotal 	= $('#otdPOGrandTotal').text();
		var thaibath 	= ArabicNumberToText(tTextTotal);
		$('#ospPOTotalText').text(thaibath);
	}

	//เพิ่มสินค้า
	function FSxPODocAddDT(){

		//ผู้จำหน่ายต้องเลือกเสมอ
		// if($('#oetSplCode').val() == ''){
		// 	$('#obtModalSPLNotNull').click();
		// 	return;
		// }

		$('#obtModalSelectPDT').click();
		JSxSelectPDTToTmp_PO(1);
	}

	//เลือกสินค้า
	var obj = [];
	function JSxSelectPDTToTmp_PO(pnPage){
		$.ajax({
			type	: "POST",
			url		: "r_purchaseorderloadPDT",
			data 	: {
						'tTypepage'  	: '<?=$tTypePage?>',
						'nPage' 		: pnPage,
						'tSearchPDT'	: $('#oetSearchPDTToTmp').val(),
						'tSPL'			: $('#oetSplCode').val()
					  },
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				$('#odvContentSelectPDT').html(tResult);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				JSxModalErrorCenter(jqXHR.responseText);
			}
		});
	}

	//บันทึกข้อมูลสินค้าลงตาราง Tmp
	function JSxInsPDTToTmp_PO(){
		var LocalItemSelect = localStorage.getItem("LocalItemData");
		if(LocalItemSelect !== null){
			$.ajax({
				type	: "POST",
				url		: "r_purchaseorderInsPDTToTmp",
				data 	: {
							'tTypepage'  	: '<?=$tTypePage?>',
							'tCode'	 	 	: '<?=$tDocumentNumber?>',
							'aData'			: LocalItemSelect
						},
				cache	: false,
				timeout	: 0,
				success	: function (tResult) {
					console.log(tResult);
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
