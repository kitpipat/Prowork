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
	$tLevelUser = $this->session->userdata('tSesUserLevel');
?> 

<div class="container-fulid">

	<!--Section บน-->
	<div class="row">
		<div class="col-lg-6 col-md-6"><span class="xCNHeadMenu">ใบสั่งซื้อ</span></div>
		<div class="col-lg-6 col-md-6 <?=$tPer_create?>"><button class="xCNButtonInsert pull-right" onClick="JSwPOCallPageInsert('insert','')">+</button></div>
	</div>

	<!--Section ล่าง-->
	<div class="card" style="margin-top: 10px;">
		<div class="card-body">

			<!--ค้นหา-->
			<div class="row">

				<!--สาขา-->
				<div class="col-lg-4">
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
				<div class="col-lg-2">
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
							<option value="3">รออนุมัติเอกสาร</option>
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
						<button class="xCNCalcelImport btn btn-outline-danger" onclick="JSwClearValueTable();" style="width: 100%;">ล้างตัวกรอง</button>
					</div>
				</div>

				<!-- <div class="col-lg-4">
					<div class="input-group md-form form-sm form-2 pl-0">
						<input class="form-control my-0 py-1 red-border xCNFormSerach xCNInputWithoutSingleQuote" type="text" placeholder="กรุณากรอกคำที่ต้องการค้นหา" id="oetSearch" onkeypress="Javascript:if(event.keyCode==13) JSwLoadTableList(1)">
						<div class="input-group-append">
							<span class="input-group-text red lighten-3" style="cursor:pointer;" onclick="JSwLoadTableList(1);">
								<?php $tMenuBar = base_url().'application/assets/images/icon/search.png'; ?>
								<img class="menu-icon xCNMenuSearch" src="<?=$tMenuBar?>">
							</span>
						</div>
					</div>
				</div> -->

				<div class="col-lg-12">
					<div id="odvContent_PO" class="xCNContent"></div>
				</div>
			</div>
		</div>
	</div>
<div>
<script type="text/javascript" src="<?= base_url('application/assets/js/jFormValidate.js')?>"></script>
<script type="text/javascript" src="<?= base_url('application/assets/js/account.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('application/assets/js/moment.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('application/assets/js/jThaiBath.js') ?>"></script>

<script>

	//หน้าตาราง
	JSwLoadTableList(1);
	function JSwLoadTableList(pnPage){
		$.ajax({
			type	: "POST",
			url		: "r_purchaseorderload",
			data 	: {
						'nPage' 		 : pnPage,
						'BCH'			 : $('#oetDocBCH').val(),
						'DocumentNumber' : $('#oetDocNumber').val(),
						'tStaDoc'		 : $('#oetstaDocument').val()
					  },
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				JSxModalProgress('close');
				$('#odvContent_PO').html(tResult);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				JSxModalErrorCenter(jqXHR.responseText);
			}
		});
	}

	//โหลดหน้า เพิ่มข้อมูล
	function JSwPOCallPageInsert(ptType,ptCode){
		JSxModalProgress('open');
		$.ajax({
			type	: "POST",
			url		: "r_purchaseordercallpageInsertorEdit",
			data 	: {
						'tTypepage'  : ptType,
						'tCode'	 	 : ptCode
					  },
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				localStorage.clear();
				$('.content').html(tResult);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				JSxModalErrorCenter(jqXHR.responseText);
			}
		});
	}

	//กด ย้อนกลับ(กลับหน้า main)
	function JSxCallPagePOMain(){
		JSxModalProgress('open');
		$.ajax({
			type	: "POST",
			url		: "r_purchaseorder",
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
