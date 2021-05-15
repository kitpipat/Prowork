<?php

	$aPermission = FCNaPERGetPermissionByPage('r_quotationList');
	$aPermission = $aPermission[0];
	if($aPermission['P_read'] != 1){ 		$tPer_read 		= 'xCNHide'; }else{ $tPer_read = ''; }
	if($aPermission['P_create'] != 1){ 		$tPer_create 	= 'xCNHide'; }else{ $tPer_create = ''; }
	if($aPermission['P_delete'] != 1){ 		$tPer_delete 	= 'xCNHide'; }else{ $tPer_delete = ''; }
	if($aPermission['P_edit'] != 1){ 		$tPer_edit 		= 'xCNHide'; }else{ $tPer_edit = ''; }
	if($aPermission['P_cancel'] != 1){ 		$tPer_cancle 	= 'xCNHide'; }else{ $tPer_cancle = ''; }
	if($aPermission['P_approved'] != 1){ 	$tPer_approved 	= 'xCNHide'; }else{ $tPer_approved = ''; }
	if($aPermission['P_print'] != 1){ 		$tPer_print 	= 'xCNHide'; }else{ $tPer_print = ''; }
	$tLevelUser = $this->session->userdata('tSesUserLevel');

?>

<div class="container-fulid">

	<!--Section บน-->
	<div class="row">
		<div class="col-lg-6 col-md-6"><span class="xCNHeadMenu">ข้อมูลใบเสนอราคา</span></div>
		<?php if($tPer_create == ''){ ?>
			<div class="col-lg-6 col-md-6"><button class="xCNButtonInsert pull-right" onClick="JSwQuotationPageInsert()">+</button></div>
		<?php } ?>
	</div>

	<!--Section ล่าง-->
	<div class="card" style="margin-top: 10px;">
		<div class="card-body">
			<!--ค้นหา-->
			<div class="row">

				<!--สาขา-->
				<div class="col-lg-3">
					<?php if($tLevelUser == 'HQ'){ ?>
						<div class="form-group">
							<label> สาขา</label>
							<select class="form-control" id="oetDocBCH" name="oetDocBCH">
								<option value="">ทั้งหมด</option>
								<?php foreach($aBCHList['raItems'] AS $nKey => $aValue){ ?>
									<option value="<?=$aValue['FTBchCode'];?>"><?=$aValue['FTBchName'];?> - (<?=$aValue['FTCmpName'];?>)</option>
								<?php } ?>
							</select>
						</div>
					<?php }else{ ?>
						<div class="form-group">
							<?php $tBCHName = $this->session->userdata('tSesBCHName'); ?>
							<?php $tBCHCode = $this->session->userdata('tSesBCHCode'); ?>
							<label> สาขา</label>
							<input type="text" class="form-control" value="<?=@$tBCHName?>" autocomplete="off" readonly>
							<input type="hidden" id="oetDocBCH" name="oetDocBCH" value="<?=@$tBCHCode?>" autocomplete="off">
						</div>
					<?php } ?>
				</div>

				<!--เลขที่เอกสาร-->
				<div class="col-lg-3">
					<div class="form-group">
						<label>เลขที่เอกสาร</label>
						<input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetDocNumber" name="oetDocNumber" placeholder="กรอกเลขที่เอกสาร" autocomplete="off">
					</div>
				</div>

				<!--สถานะเอกสาร-->
				<div class="col-lg-2">
					<div class="form-group">
						<label>สถานะเอกสาร</label>
						<select class="form-control" id="oetstaDocument" name="oetstaDocument">
							<option value="0">ทั้งหมด</option>
							<option value="1">อนุมัติแล้ว</option>
							<option value="3">รออนุมัติสั่งซื้อ	</option>
							<option value="2">ยกเลิก </option>
						</select>
					</div>
				</div>

				<!--ปุ่มค้นหา-->
				<div class="col-lg-2">
					<div class="form-group">
						<label style="color:#FFF; width: 100%;">.</label>
						<button class="xCNButtonSave" onclick="JSwLoadTableList(1);" style="width: 100%;">กรองข้อมูล</button>
					</div>
				</div>

				<!--ล้างข้อมูล-->
				<div class="col-lg-2">
					<div class="form-group">
						<label style="color:#FFF; width: 100%;">.</label>
						<button class="xCNCalcelImport btn btn-outline-danger" onclick="JSwClearValueTable();" style="width: 100%;">ล้างข้อมูล</button>
					</div>
				</div>

				<div class="col-lg-12">
					<div id="odvContent_Detail_PI" class="xCNContent"></div>
				</div>
			</div>
		</div>
	</div>
<div>
<script src="<?= base_url('application/assets/js/jFormValidate.js')?>"></script>
<script>

	//หน้าตาราง
	JSwLoadTableList(1);
	function JSwLoadTableList(pnPage){
		$.ajax({
			type	: "POST",
			url		: "r_quotationListload",
			data 	: {
						'nPage' 		: pnPage,
						//'tSearchAll' 	: $('#oetSearch').val(),

						'BCH'			 : $('#oetDocBCH').val(),
						'DocumentNumber' : $('#oetDocNumber').val(),
						'tStaDoc'		 : $('#oetstaDocument').val()
					  },
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				JSxModalProgress('close');
				$('#odvContent_Detail_PI').html(tResult);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				JSxModalErrorCenter(jqXHR.responseText);
			}
		});
	}

	//โหลดหน้า สร้างเอกสารใบเสนอราคา
	function JSwQuotationPageInsert(){
		JSxModalProgress('open');
		$.ajax({
			type	: "POST",
			url		: "r_quotation/1",
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				JSxModalProgress('close');
				$('.content').html(tResult);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				JSxModalErrorCenter(jqXHR.responseText);
			}
		});
	}

	//กดกลับหน้า main
	function JSxCallPagePIListMain(){
		JSxModalProgress('open');
		$.ajax({
			type	: "POST",
			url		: "r_quotationList",
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				JSxModalProgress('close');
				$('.content').html(tResult);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				JSxModalErrorCenter(jqXHR.responseText);
			}
		});
	}

	//ล้างค่า
	function JSwClearValueTable(){
		$("#oetDocBCH").val($("#oetDocBCH option:first").val());
		$('#oetDocNumber').val('');
		$("#oetstaDocument").val($("#oetstaDocument option:first").val());
		JSwLoadTableList(1)
	}

</script>
