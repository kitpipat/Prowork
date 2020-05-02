<?php
	$aPermission = FCNaPERGetPermissionByPage('r_adjprice');
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
		<div class="col-lg-6 col-md-6"><span class="xCNHeadMenu">ใบปรับราคาสินค้า</span></div>
		<div class="col-lg-6 col-md-6 <?=$tPer_create?>"><button class="xCNButtonInsert pull-right" onClick="JSwAJPCallPageInsert('insert','')">+</button></div>
	</div>

	<!--Section ล่าง-->
	<div class="card" style="margin-top: 10px;">
		<div class="card-body">
			<!--ค้นห่า-->
			<div class="row">
				<div class="col-lg-4">
					<div class="input-group md-form form-sm form-2 pl-0">
						<input class="form-control my-0 py-1 red-border xCNFormSerach xCNInputWithoutSingleQuote" type="text" placeholder="กรุณากรอกคำที่ต้องการค้นหา" id="oetSearch" onkeypress="Javascript:if(event.keyCode==13) JSwLoadTableList(1)">
						<div class="input-group-append">
							<span class="input-group-text red lighten-3" style="cursor:pointer;" onclick="JSwLoadTableList(1);"><i class="fa fa-search" aria-hidden="true"></i></span>
						</div>
					</div>
				</div>

				<div class="col-lg-12">
					<div id="odvContent_AJP" class="xCNContent"></div>
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
			url		: "r_adjpriceload",
			data 	: {
						'nPage' 		: pnPage,
						'tSearchAll' 	: $('#oetSearch').val()
					  },
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				JSxModalProgress('close');
				$('#odvContent_AJP').html(tResult);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert(jqXHR, textStatus, errorThrown);
			}
		});
	}

	//โหลดหน้า เพิ่มข้อมูล
	function JSwAJPCallPageInsert(ptType,ptCode){
		JSxModalProgress('open');
		$.ajax({
			type	: "POST",
			url		: "r_adjpricecallpageInsertorEdit",
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
				alert(jqXHR, textStatus, errorThrown);
			}
		});
	}

	//กด ย้อนกลับ(กลับหน้า main)
	function JSxCallPageAJPMain(){
		JSxModalProgress('open');
		$.ajax({
			type	: "POST",
			url		: "r_adjprice",
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
