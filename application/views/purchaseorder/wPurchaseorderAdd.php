<style>
	#ofmPurchaseorder .form-group {
		margin-bottom: 0.25rem;
	}

	#ofmPurchaseorder label {
		margin-bottom: 0rem;
	}

	#ofmPurchaseorderCSS .form-group {
		margin-bottom: 0.25rem;
	}

	#ofmPurchaseorderCSS label {
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

		//ข้อมูลผู้จำหน่าย
		$FTXpoSplCode		= '';
		$FTXpoSplName		= '';
		$FTXpoAddress		= '';
		$FTXpoTaxNo			= '';
		$FTXpoContact		= '';
		$FTXpoEmail			= '';
		$FTXpoTel			= '';
		$FTXpoFax			= '';

		//ข้อมูลทั่วไป
		$FTBchCode			= '';
		$FDDeliveryDate		= '';
		$FNXpoCredit		= '';
		$FTXpoCshOrCrd		= '';
		$FTXpoRmk			= '';
		$FTXpoVATInOrEx 	= '';
		$FCXpoVatRate 		= '7';
		$APVBY 				= '-';
		$FDApproveDate 		= '-';
		$FTXpoDisTxt 		= '';
	}else if($tTypePage == 'edit'){
		$tRoute 			= 'r_purchaseordereventedit';
		$tRouteUrl			= 'แก้ไขใบสั่งซื้อ';
		$tDocumentNumber	= $aResult[0]['FTXpoDocNo'];
		$dDocumentDate		= date('d/m/Y H:i:s',strtotime($aResult[0]['FDXpoDocDate']));
		$tDocumentCreate	= $aResult[0]['FTUsrFName']; ' - ' . $aResult[0]['FTUsrLName'];
		$tDocumentStaDoc	= $aResult[0]['FTXpoStaDoc'];
		$tDocumentStaApv	= $aResult[0]['FTXpoStaApv'];

		//ข้อมูลผู้จำหน่าย
		$FTXpoSplCode		= $aResult[0]['FTXpoSplCode'];
		$FTXpoSplName		= $aResult[0]['FTXpoSplName'];
		$FTXpoAddress		= ($aResult[0]['FTXpoAddress'] == '') ? '-' : $aResult[0]['FTXpoAddress'];
		$FTXpoTaxNo			= ($aResult[0]['FTXpoTaxNo'] == '') ? '-' : $aResult[0]['FTXpoTaxNo'];
		$FTXpoContact		= ($aResult[0]['FTXpoContact'] == '') ? '-' : $aResult[0]['FTXpoContact'];
		$FTXpoEmail			= ($aResult[0]['FTXpoEmail'] == '') ? '-' : $aResult[0]['FTXpoEmail'];
		$FTXpoTel			= ($aResult[0]['FTXpoTel'] == '') ? '-' : $aResult[0]['FTXpoTel'];
		$FTXpoFax			= ($aResult[0]['FTXpoFax'] == '') ? '-' : $aResult[0]['FTXpoFax'];

		//ข้อมูลทั่วไป
		$FTBchCode			= $aResult[0]['FTBchCode'];
		$FDDeliveryDate		= date('d/m/Y',strtotime($aResult[0]['FDDeliveryDate']));
		$FNXpoCredit		= $aResult[0]['FNXpoCredit'];
		$FTXpoCshOrCrd		= $aResult[0]['FTXpoCshOrCrd'];
		$FTXpoRmk			= $aResult[0]['FTXpoRmk'];
		$FTXpoVATInOrEx 	= $aResult[0]['FTXpoVATInOrEx'];
		$FCXpoVatRate 		= $aResult[0]['FCXpoVatRate'];
		$APVBY 				= $aResult[0]['APVBY'];
		$FDApproveDate 		= date('d/m/Y',strtotime($aResult[0]['FDApproveDate']));
		$FTXpoDisTxt 		= $aResult[0]['FTXpoDisTxt'];
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
					<button class="xCNPrint xCNButtonAprove-outline btn btn-outline-success pull-right <?=$tPer_print?>" style="float:right;" onclick="FSxPOPrintForm()">พิมพ์</button>
				<?php }else{ ?>
					<button class="xCNButtonSave pull-right <?=$tAlwSave?>" onclick="JSxEventSaveorEdit('<?=$tRoute?>');">บันทึก</button>
					<button class="xCNButtonAprove-outline btn btn-outline-success pull-right <?=$tPer_approved?>" style="margin-right:10px; float:right;" onclick="JSxPOEventAproveDocument('<?=$tRoute?>');">อนุมัติ</button>
					<button class="xCNPrint xCNButtonAprove-outline btn btn-outline-success pull-right <?=$tPer_print?>" style="float:right;" onclick="FSxPOPrintForm()">พิมพ์</button>
					<button class="xCNCalcelImport btn btn-outline-danger pull-right <?=$tPer_cancle?>" style="margin-right:10px; float:right;" onclick="JSxPOEventCancelDocument();">ยกเลิกเอกสาร</button>
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
							<form id="ofmPurchaseorderCSS">
								<div class="row">
									<?php
										if($tTypePage == 'edit'){	//เข้ามาแบบ ขา Edit และ สิทธิสามารถแก้ไขได้
											if($tPer_edit == ''){
												$tAlwSPL = '';
											}else{
												$tAlwSPL = 'xCNHide';
											}
										}else if($tTypePage == 'insert'){ //เข้ามาแบบ ขา Insert และ สิทธิสามารถบันทึกได้
											if($tPer_create == ''){
												$tAlwSPL = '';
											}else{
												$tAlwSPL = 'xCNHide';
											}
										}
									?>
									<div class="col-lg-12">
										<label><span style="color:red;">*</span> ผู้จำหน่าย</label>
										<div class="input-group md-form form-sm form-2 pl-0 form-group">
											<input type="hidden" id="oetSplCode" name="oetSplCode" value='<?=$FTXpoSplCode?>' >
											<input <?=$tDisabledInput?> type="text" class="form-control" maxlength="255" id="oetSplName" name="oetSplName" placeholder="กรุณาระบุผู้จำหน่าย" autocomplete="off" value='<?=$FTXpoSplName?>'>
											
											<?php if($tDisabledInput != 'disabled'){ ?>
												<div class="input-group-append <?=$tAlwSPL?> xCNIconFindCustomer">
													<span class="input-group-text red lighten-3" style="cursor:pointer;" onclick="JSxChooseSupplier();" <?=$tDisabledInput?>>
														<img class="xCNIconFind">
													</span>
												</div>
											<?php } ?>
										</div>
									</div>

									<!--ที่อยู่-->
									<div class="col-lg-12">
										<div class="form-group">
											<label>ที่อยู่</label>
											<textarea type="text" class="form-control" id="oetPOAddress" name="oetPOAddress" placeholder="รายละเอียดที่อยู่" rows="3" disabled="disabled"><?=$FTXpoAddress?></textarea>
										</div>
									</div>

									<!--ผู้ติดต่อ-->
									<div class="col-lg-6">
										<div class="form-group">
											<label>ผู้ติดต่อ</label>
											<input type="text" class="form-control" maxlength="50" id="oetPOContact" name="oetPOContact" placeholder="รายละเอียดชื่อผู้ติดต่อ" autocomplete="off" disabled="disabled" value='<?=$FTXpoContact?>'>
										</div>
									</div>

									<!--อีเมลล์-->
									<div class="col-lg-6">
										<div class="form-group">
											<label>อีเมลล์</label>
											<input type="text" class="form-control" maxlength="50" id="oetPOEmail" name="oetPOEmail" placeholder="รายละเอียดอีเมลล์" autocomplete="off" disabled="disabled" value='<?=$FTXpoEmail?>'>
										</div>
									</div>

									<!--เบอร์โทรศัพท์-->
									<div class="col-lg-6">
										<div class="form-group">
											<label>เบอร์โทรศัพท์</label>
											<input type="text" class="form-control" maxlength="20" id="oetPOTel" name="oetPOTel" placeholder="รายละเอียดเบอร์โทรศัพท์" autocomplete="off" disabled="disabled" value='<?=$FTXpoTel?>'>
										</div>
									</div>

									<!--เบอร์โทรสาร-->
									<div class="col-lg-6">
										<div class="form-group">
											<label>เบอร์โทรสาร</label>
											<input type="text" class="form-control xCNInputNumericWithDecimal" maxlength="20" id="oetPOFax" name="oetPOFax" placeholder="รายละเอียดเบอร์โทรสาร" autocomplete="off" disabled="disabled" value='<?=$FTXpoFax?>'>
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
								วันที่เอกสาร : <span id="ospPODocDate"><?=$dDocumentDate?></span>
							</div>
						</div>

						<!--Detail-->
						<div class="col-lg-12">
							<div class="row">
								<div class="col-lg-6">
									<?php //สถานะเอกสาร
										switch ($tDocumentStaDoc) {
											case '':
												$tShowStaDoc = "-";
												break;
											case '1':
												$tShowStaDoc = "สมบูรณ์";
												break;
											case '2':
												$tShowStaDoc = "ยกเลิก";
												break;
											default:
												$tShowStaDoc = "รออนุมัติสั่งสินค้า"; 
										}
									?>
									<span>สถานะเอกสาร : </span><span id="ospPOStaDoc"><?=$tShowStaDoc?></span>
									<input type="hidden" id="ohdPOStaDoc" value="<?=$tDocumentStaDoc?>">
								</div>
								<div class="col-lg-6">
									<?php //สถานะอนุมัติ
										switch ($tDocumentStaApv) {
											case '':
												$tShowStaApv = "รออนุมัติสั่งสินค้า";
												break;
											case '1':
												$tShowStaApv = "อนุมัติแล้ว";
												break;
											default:
												$tShowStaApv = "รออนุมัติสั่งสินค้า";
										}
									?>
									<span>สถานะอนุมัติเอกสาร : </span><span id="ospPOStaDocApv"><?=$tShowStaApv?></span>
									<input type="hidden" id="ohdPOStaApv" value="<?=$tDocumentStaApv?>">
								</div>
							</div>
							<hr  style="margin-bottom: 15px;">
							
							<form id="ofmPurchaseorder">
								<div class="row">

									<!--สาขา-->
									<?php $tLevelUser = $this->session->userdata('tSesUserLevel'); ?>
									<?php if($tLevelUser == 'HQ'){ ?>
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<div class="form-group">
												<label>สาขา</label>
												<select class="form-control" id="oetBCHPO" name="oetBCHPO" <?=$tDisabledInput?>>
													<?php foreach($aBCHList['raItems'] AS $nKey => $aValue){ ?>
														<option <?=(@$FTBchCode == $aValue['FTBchCode'])? "selected" : "";?> value="<?=$aValue['FTBchCode'];?>"><?=$aValue['FTBchName'];?> - (<?=$aValue['FTCmpName'];?>)</option>
													<?php } ?>
												</select>
											</div>
										</div>
									<?php }else{ ?>
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<div class="form-group">
												<label>สาขา</label>
												<?php $tBCHName = $this->session->userdata('tSesBCHName'); ?>
												<?php $tBCHCode = $this->session->userdata('tSesBCHCode'); ?>
												<input type="text" class="form-control" value="<?=@$tBCHName?>" autocomplete="off" readonly>
												<input type="hidden" id="oetBCHPO" name="oetBCHPO" value="<?=@$tBCHCode?>" autocomplete="off">
											</div>
										</div>
									<?php } ?>
									
									<!--จัดส่งวันที่-->
									<div class="col-lg-6">
										<div class="form-group">
											<label>จัดส่งวันที่</label>
											<input type="text" class="form-control xCNDatePicker" maxlength="20" id="odpPOXpoEftTo" name="odpPOXpoEftTo" placeholder="DD/MM/YYYY" autocomplete="off" value="<?=$FDDeliveryDate?>" <?=$tDisabledInput?>>
										</div>
									</div>

									<!--เงื่อนไขการชำระเงิน-->
									<div class="col-lg-6">
										<div class="form-group">
											<label>เงื่อนไขการชำระเงิน</label>
											<select class="form-control" id="osmPOCashorCard" name="osmPOCashorCard" <?=$tDisabledInput?>>
												<option value="">เลือกประเภทการชำระ</option>
												<option <?=(@$FTXpoCshOrCrd == 1)? "selected" : "";?> value="1">เงินสด</option>
												<option <?=(@$FTXpoCshOrCrd == 2)? "selected" : "";?> value="2">เครดิต</option>
											</select>
										</div>
									</div>

									<!--จำนวนวันเครดิต-->
									<div class="col-lg-6">
										<div class="form-group">
											<label>จำนวนวันเครดิต (วัน)</label>
											<input type="text" class="form-control xCNInputNumericWithDecimal text-right" maxlength="20" id="oetPOXpoCredit" name="oetPOXpoCredit" placeholder="0" autocomplete="off" value="<?=$FNXpoCredit?>" <?=$tDisabledInput?>>
										</div>
									</div>

									<!--เงื่อนไขการชำระเงิน-->
									<div class="col-lg-6">
										<div class="form-group">
											<label>ประเภทภาษี</label>
											<select class="form-control" id="ocmPOVatType" name="ocmPOVatType" onchange="JSvLoadTableDTTmp(1)" <?=$tDisabledInput?>>
												<option <?=(@$FTXpoVATInOrEx == 1)? "selected" : "";?> value="1">แยกนอก</option>
												<option <?=(@$FTXpoVATInOrEx == 2)? "selected" : "";?> value="2">รวมใน</option>
											</select>
										</div>
									</div>
								</div>
								<hr  style="margin-bottom: 10px;">
							</form>

							<div class="row">
								<?php 
									//สถานะอนุมัติ
									if($tDocumentStaApv == 1){
										$tUserApvBy = $APVBY;
										$dDateApv   = $FDApproveDate;
									}else{
										$tUserApvBy = '-';
										$dDateApv   = '-';
									}
								?>
										
								<div class="col-lg-4">
									ผู้บันทึก : <span id="ospPOCreateBy"> <?= $tDocumentCreate?> </span>
								</div>

								<div class="col-lg-4">
									ผู้อนุมัติ : <span id="ospPOApprovedBy"> <?= $tUserApvBy?> </span>
								</div>

								<div class="col-lg-4">
									วันที่อนุมัติ : <span id="ospPOApproveDate"> <?= $dDateApv?> </span>
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
								<textarea type="text" class="form-control" id="otaPODocRemark" name="otaPODocRemark" placeholder="หมายเหตุเอกสาร" rows="3"><?=$FTXpoRmk?></textarea>
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
											id="oetPOXpoDisText"
											class="text-right form-control xCNNumberandPercent xCNDiscountFooterBill"
											maxlength="12" onkeyup="FSXPOCheckInputDis(this)"
											value='<?=$FTXpoDisTxt?>'>
									</div>
								</div>
								<div class="col-lg-5">
									<label class="text-right xCNTotal" id="ospPOXpoDis">0.00</label>
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
							<label id="olbPOVatText">ภาษีมูลค่าเพิ่ม (<?=$FCXpoVatRate?>%)</label>
						</div>

						<div class="col-lg-6 text-right">
							<div class="row">
								<div class="col-lg-6">
									<div class="">
										<input type="text" autocomplete="off" id="oetPOVatRate" class="text-right form-control xCNInputNumericWithDecimal" style="display:none" value="<?=$FCXpoVatRate?>">
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
<button id="obtModalCancelDocument" style="display:none;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#odvModalCancelDocument"></button>
<div class="modal fade" id="odvModalCancelDocument" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
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
				<button type="button" class="btn btn-danger xCNConfirmDelete xCNConfirmCancelDocument">ยืนยัน</button>
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
<button id="obtModalPDTIsNull" style="display:none;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#odvModalPDTIsNull"></button>
<div class="modal fade" id="odvModalPDTIsNull" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">กรุณาเลือกสินค้า</h5>
			</div>
			<div class="modal-body">
				<label style="text-align: left; display: block;">ไม่พบสินค้า กรุณาเลือกสินค้าก่อนทำรายการ</label>
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

<!-- Modal แจ้งเตือนต่างๆ -->
<button id="obtModalTextWarning" style="display:none;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#odvModalTextWarning"></button>
<div class="modal fade" id="odvModalTextWarning" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">แจ้งเตือน</h5>
			</div>
			<div class="modal-body">
				<label id="olbModalTextWarning" style="text-align: left; display: block;"></label>
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

		nFooterDis 	= $("#ospPOXpoDis").text()
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

		//ส่วนลดท้ายบิลอีกที่
		$('.xCNDiscountFooterBill').change();

		//ถ้าอนุมัติเเล้วหรือยกเลิก
		if('<?=$tDocumentStaDoc?>' == 2 || '<?=$tDocumentStaApv?>' == 1){
			$('.xCNCellDeleteItem').addClass('xCNHide');
			$('.xCNImageEdit').addClass('xCNHide');
			$('.xCNButtonInsert').addClass('xCNHide');
			$('.xCNEditInline').attr('disabled',true);
			$('.form-control').attr('disabled',true);
		}
	}

	//เพิ่มสินค้า
	function FSxPODocAddDT(){

		//ผู้จำหน่ายต้องเลือกเสมอ
		if($('#oetSplCode').val() == ''){
			$('#obtModalSPLNotNull').click();
			return;
		}

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

	//ใส่ส่วนลดท้ายบิล
	$('.xCNDiscountFooterBill').on('change keyup', function(event){
		if(event.type == "change"){
			FSxPODocFootDis(this)
		}
		if(event.keyCode == 13) {
			FSxPODocFootDis(this)
		}
	});

	//ส่วนท้ายบิล
	function FSxPODocFootDis(poElm) {

		if(poElm == '#oetPOXpoDisText'){
			nDiscount = $('#oetPOXpoDisText').val();
		}else{
			nDiscount = $(poElm).val();
		}

		var tDocNo 		= $("#ospPODocNo").attr("data-docno");
		var nNetB4HD 	= $("#otdPODocNetTotal").text();

		if(nDiscount != ''){
			$.ajax({
				url		: 'r_purchaseorderFootDiscount',
				timeout	: 0,
				type	: 'POST',
				data	: {
					'tDocNo' 	: tDocNo,
					'nDiscount'	: nDiscount,
					'nNetB4HD' 	: nNetB4HD
				},
				datatype: 'json',
				success	: function(tResult) {
					$("#ospPOXpoDis").text(tResult)

					var nFootDiscount 	= parseFloat(tResult)
					nNetB4HD 		= nNetB4HD.replace(/,/g, "");
					nNetAFHD 		= parseFloat(nNetB4HD) - parseFloat(nFootDiscount)

					$("#ospPOXpoDis").text(accounting.formatMoney(nFootDiscount.toFixed(2), ""))
					$("#otdPONetAFHD").text(accounting.formatMoney(nNetAFHD.toFixed(2), ""))

					var nVatType = $("#ocmPOVatType").val()
					var nVatRate = $("#oetPOVatRate").val()
					var nVat 		= 0
					var nGrandTotal = 0

					if (nVatType == "1") { //แยกนอก
						nVat 		= ((nNetAFHD * (100 + parseInt(nVatRate))) / 100) - nNetAFHD
						nGrandTotal = parseFloat(nNetAFHD) + parseFloat(nVat.toFixed(2))
					} else { //รวมใน
						nVat 		= nNetAFHD - ((nNetAFHD * 100) / (100 + parseInt(nVatRate)))
						nGrandTotal = parseFloat(nNetAFHD)
					}

					$("#otdPOVat").text(accounting.formatMoney(nVat.toFixed(2), ""))
					$("#otdPOGrandTotal").text(accounting.formatMoney(nGrandTotal.toFixed(2), ""))

					var tTextTotal 	= $('#otdPOGrandTotal').text();
					var thaibath 	= ArabicNumberToText(tTextTotal);
					$('#ospPOTotalText').text(thaibath);

					// JCNPONumberToCurrency(nGrandTotal.toFixed(2));
				},
				error: function(jqXHR, textStatus, errorThrown) {
					JSxModalErrorCenter(jqXHR.responseText);
				}
			});
		}
	}

	function FSXPOCheckInputDis(elm){
		var tFootDisText = $(elm).val().replace(/,,/gi, ",");
		$(elm).val(tFootDisText);
	}

	//อีเวนท์บันทึกข้อมูล
	function JSxEventSaveorEdit(ptRoute){

		//ผู้จำหน่ายต้องเลือกเสมอ
		if($('#oetSplCode').val() == ''){
			$('#obtModalSPLNotNull').click();
			return;
		}

		if($('#odpPOXpoEftTo').val() == null || $('#odpPOXpoEftTo').val() == ''){
			$('#obtModalTextWarning').click();
			$('#olbModalTextWarning').text('กรุณาเลือกจัดส่งวันที่');

			$('#odvModalTextWarning .xCNCloseDelete').on('click',function(){
				$('#odpPOXpoEftTo').focus();
			});
			return;
		}

		if($('#otbPODTTable tbody tr').hasClass('otrPOTmpEmpty') == true){
			$('#obtModalPDTIsNull').click();
			return;
		}

		$.ajax({
			type	: "POST",
			url		: ptRoute,
			data 	: $('#ofmPurchaseorder').serialize() 
					+ '&tDocNo='   		+ '<?=$tDocumentNumber?>' 
					+ '&tSplCode=' 		+ $('#oetSplCode').val()
					+ '&tRemark='  		+ $('#otaPODocRemark').val()
					+ '&nB4Dis='   		+ $("#otdPODocNetTotal").text()
					+ '&nDis='     		+ $("#ospPOXpoDis").text()
					+ '&tDisText=' 		+ $("#oetPOXpoDisText").val()
					+ '&nAfDis='   		+ $("#otdPONetAFHD").text()
					+ '&nVatRate='   	+ $("#oetPOVatRate").val()
					+ '&nAmtVat='   	+ $("#otdPOVat").text()
					+ '&nGrandTotal='   + $("#otdPOGrandTotal").text(),
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				oResult 			= JSON.parse(tResult);
				var tResult 		= oResult.tStatus;
				var tDocumentNumber = oResult.tDocuementnumber;
				if(tResult == 'pass_insert'){
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('ลงทะเบียนเอกสารใบสั่งซื้อสำเร็จ');
					JSwPOCallPageInsert('edit',tDocumentNumber);
					setTimeout(function(){
						$('.alert-success').find('.close').click();
					}, 3000);
				}else if(tResult == 'pass_update'){
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('แก้ไขข้อเอกสารใบสั่งซื้อสำเร็จ');
					JSwPOCallPageInsert('edit',tDocumentNumber);
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
	function JSxPOEventCancelDocument(){
		$('#obtModalCancelDocument').click();

		$('.xCNConfirmCancelDocument').off();
		$('.xCNConfirmCancelDocument').on("click",function(){
			$.ajax({
				type	: "POST",
				url		: "r_purchaseorderCancelDocument",
				data 	: { 'tCode'	: '<?=$tDocumentNumber?>' },
				cache	: false,
				timeout	: 0,
				success	: function (tResult) {
					$('#obtModalCancelDocument').click();
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('ยกเลิกเอกสารสำเร็จ');

					setTimeout(function(){
						JSxCallPagePOMain();
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
	function JSxPOEventAproveDocument(){
		$('#obtModalAproveDocument').click();

		$('.xCNConfirmDeleteAprove').off();
		$('.xCNConfirmDeleteAprove').on("click",function(){
			$.ajax({
				type	: "POST",
				url		: 'r_purchaseorderAprove',
				data 	: { 'tCode'	: '<?=$tDocumentNumber?>' },
				cache	: false,
				timeout	: 0,
				success	: function (tResult) {
					$('#obtModalAproveDocument').click();
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('เอกสารอนุมัติสำเร็จ');
				
					setTimeout(function(){
						JSxCallPagePOMain();
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

	//พิมพ์เอกสาร
	function FSxPOPrintForm(){
		var tDocNo 			= $("#ospPODocNo").attr('data-docno')
		var aPackData		= '0';
		var Base64			= {_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/++[++^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/\r\n/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}
		var tEncodeText 	= Base64.encode(aPackData);
		window.open("r_purchaseorderPrint/"+tDocNo+"/"+tEncodeText,"_blank")
	}

</script>
