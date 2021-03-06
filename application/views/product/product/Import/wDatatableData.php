<div class="container-fulid">
	<!--Section บน-->
	<div class="row">
		<div class="col-lg-6 col-md-6"><span class="xCNHeadMenuActive" onclick="JSxCancleImportExcel();">สินค้า</span><span class="xCNHeadMenu">  /  นำเข้าข้อมูล</span></div>
		<div class="col-lg-6 col-md-6">
			<button class="xCNButtonSave pull-right" onclick="JSxApvImportExcel();">ยืนยันการนำเข้า</button>
			<button class="xCNCalcelImport btn btn-outline-danger pull-right" style="float:right;" onclick="JSxCancleImportExcel();">ยกเลิกการนำเข้า</button>
		</div>
	</div>

	<!--Section ล่าง-->
	<div class="card" style="margin-top: 10px;">
		<div class="card-body">
			<div class="row">
				<span style="color: red;
						text-align: right;
						width: 100%;
						margin-bottom: 15px;
						margin-right: 10px;"> * การนำเข้าสินค้าตัวเดิม (สถานะสินค้ารออัพเดท) จะส่งผลต่อต้นทุนทีมีผลปัจจุบัน </span>
				<table class="table table-striped xCNTableCenter" id="otbConfirmDataPDT">
					<thead>
						<tr>
							<th style="width:5px; text-align: center;">ลำดับ</th>
							<th style="width:100px; text-align: left;">รหัสสินค้า</th>
							<th style="text-align: left;">ชื่อสินค้า</th>
							<th style="text-align: left;">ชื่อกลุ่มสินค้า</th>
							<th style="text-align: left;">ชื่อประเภทสินค้า</th>
							<th style="text-align: left;">ชื่อผู้จำหน่าย</th>
							<th style="text-align: left;">ชื่อยี่ห้อ</th>
							<th style="text-align: left;">ชื่อหน่วยสินค้า</th>
							<th style="text-align: left;">ชื่อสี</th>
							<th style="text-align: left;">ชื่อรุ่น</th>
							<th style="text-align: left;">ชื่อขนาด</th>
							<th style="width:80px; text-align: right;">ราคาตั้ง</th>
							<th style="width:120px; text-align: right;">ส่วนลดราคาตั้ง</th>
							<th style="width:100px; text-align: left;">สถานะขายดี</th>
							<th style="width:200px; text-align: left;">สถานะ</th>
							<th style="width:50px; text-align: center;">ลบ</th>
						</tr>
					</thead>
					<tbody>
						<?php if($aList['rtCode'] != 800){ ?>
							<?php foreach($aList['raItems'] AS $nKey => $aValue){ ?>
								<?php
									//สถานะ
									$tPDTClassStatus		= '';
									switch ($aValue) {
										case strlen($aValue['FTPdtCode']) > 50:
											$tIconClassStatus 	= 'xCNIconStatus_close';
											$tTextClassStatus 	= 'xCNTextClassStatus_close';
											$tTextStatus 		= 'รหัสสินค้าเกิน';
											$tStatusAprove		= 'fail';
											$tPDTClassStatus 	= 'xCNTextClassStatus_close';
											break;
										case $aValue['RealPDT'] != null:
											$tIconClassStatus 	= 'xCNIconStatus_open';
											$tTextClassStatus 	= 'xCNTextClassStatus_open';
											$tTextStatus 		= 'สินค้ารออัพเดท';
											$tStatusAprove		= 'pass';
											break;
										case $aValue['FTPgpName'] == null:
											$tIconClassStatus 	= 'xCNIconStatus_close';
											$tTextClassStatus 	= 'xCNTextClassStatus_close';
											$tTextStatus 		= 'ไม่พบกลุ่มสินค้า';
											$tStatusAprove		= 'fail';
											break;
										case $aValue['FTPtyName'] == null:
											$tIconClassStatus 	= 'xCNIconStatus_close';
											$tTextClassStatus 	= 'xCNTextClassStatus_close';
											$tTextStatus 		= 'ไม่พบประเภทสินค้า';
											$tStatusAprove		= 'fail';
											break;
										case $aValue['FTPbnName'] == null:
											$tIconClassStatus 	= 'xCNIconStatus_close';
											$tTextClassStatus 	= 'xCNTextClassStatus_close';
											$tTextStatus 		= 'ไม่พบยี่ห้อสินค้า';
											$tStatusAprove		= 'fail';
											break;
										case $aValue['FTPunName'] == null:
											$tIconClassStatus 	= 'xCNIconStatus_close';
											$tTextClassStatus 	= 'xCNTextClassStatus_close';
											$tTextStatus 		= 'ไม่พบหน่วยสินค้า';
											$tStatusAprove		= 'fail';
											break;
										case $aValue['FTPClrCode'] == null:
											$tIconClassStatus 	= 'xCNIconStatus_close';
											$tTextClassStatus 	= 'xCNTextClassStatus_close';
											$tTextStatus 		= 'ไม่พบสี';
											$tStatusAprove		= 'fail';
											break;
										case $aValue['FTMolCode'] == null:
											$tIconClassStatus 	= 'xCNIconStatus_close';
											$tTextClassStatus 	= 'xCNTextClassStatus_close';
											$tTextStatus 		= 'ไม่พบรุ่น';
											$tStatusAprove		= 'fail';
											break;
										case $aValue['FTPzeCode'] == null:
											$tIconClassStatus 	= 'xCNIconStatus_close';
											$tTextClassStatus 	= 'xCNTextClassStatus_close';
											$tTextStatus 		= 'ไม่พบขนาด';
											$tStatusAprove		= 'fail';
											break;
										case $aValue['FTSplName'] == null:
											$tIconClassStatus 	= 'xCNIconStatus_close';
											$tTextClassStatus 	= 'xCNTextClassStatus_close';
											$tTextStatus 		= 'ไม่พบผู้จำหน่าย';
											$tStatusAprove		= 'fail';
											break;
										case is_numeric($aValue['FCPdtCostStd']) != 1:
											$tIconClassStatus 	= 'xCNIconStatus_close';
											$tTextClassStatus 	= 'xCNTextClassStatus_close';
											$tTextStatus 		= 'ข้อมูลต้นทุนไม่ถูกต้อง';
											$tStatusAprove		= 'fail';
											break;
										default:
											$tIconClassStatus 	= 'xCNIconStatus_open';
											$tTextClassStatus 	= 'xCNTextClassStatus_open';
											$tTextStatus 		= 'รอยืนยัน';
											$tStatusAprove		= 'pass';
									}

									//เช็คว่าต้นทุน มีอักษรไหม
									if(is_numeric($aValue['FCPdtCostStd']) != 1){
										$tCostSTDDisClassStatus = 'xCNTextClassStatus_close';
									}else{
										$tCostSTDDisClassStatus = '';
									}

									//เช็คว่าส่วนลดต้นทุนมี ภาษาไทยไหม
									if(strripos($aValue['FTPdtCostDis'],"%%") >= 1 || preg_replace('/[^ก-ฮA-Za-z]/u','',$aValue['FTPdtCostDis'])){
										$tIconClassStatus 		= 'xCNIconStatus_close';
										$tTextClassStatus 		= 'xCNTextClassStatus_close';
										$tTextStatus 			= 'ข้อมูลส่วนลดราคาตั้งไม่ถูกต้อง';
										$tStatusAprove			= 'fail';
										$tCostDisClassStatus 	= 'xCNTextClassStatus_close';
									}else{
										$tCostDisClassStatus	= '';
									}

									//รหัสกลุ่มสินค้า
									if($aValue['FTPgpName'] == '' || $aValue['FTPgpName'] == null){
										$tPgpName 			= $aValue['FTPgpCode'];
										if($tPgpName == '' || $tPgpName == null){
											$tPgpName 		= '-';
										}
										$tPgpClassStatus 	= 'xCNTextClassStatus_close';
									}else{
										$tPgpName = $aValue['FTPgpName'];
										$tPgpClassStatus 	= '';
									}

									//รหัสประเภทสินค้า
									if($aValue['FTPtyName'] == '' || $aValue['FTPtyName'] == null){
										$tPtyName 			= $aValue['FTPtyCode'];
										if($tPtyName == '' || $tPtyName == null){
											$tPtyName 		= '-';
										}
										$tPtyClassStatus 	= 'xCNTextClassStatus_close';
									}else{
										$tPtyName 			= $aValue['FTPtyName'];
										$tPtyClassStatus 	= '';
									}

									//รหัสผู้จำหน่าย
									if($aValue['FTSplName'] == '' || $aValue['FTSplName'] == null){
										$tSplName 			= $aValue['FTSplCode'];
										if($tSplName == '' || $tSplName == null){
											$tSplName 		= '-';
										}
										$tSplClassStatus 	= 'xCNTextClassStatus_close';
									}else{
										$tSplName 			= $aValue['FTSplName'];
										$tSplClassStatus	= '';
									}

									//รหัสยี่ห้อ
									if($aValue['FTPbnName'] == '' || $aValue['FTPbnName'] == null){
										$tPbnName 			= $aValue['FTPbnCode'];
										if($tPbnName == '' || $tPbnName == null){
											$tPbnName 		= '-';
										}
										$tPbnClassStatus 	= 'xCNTextClassStatus_close';
									}else{
										$tPbnName 			= $aValue['FTPbnName'];
										$tPbnClassStatus	= '';
									}

									//รหัสสี
									if($aValue['FTPClrName'] == '' || $aValue['FTPClrName'] == null){
										$tClrName 			= $aValue['FTPClrCode'];
										if($tClrName == '' || $tClrName == null){
											$tClrName 		= '-';
										}
										$tClrClassStatus 	= 'xCNTextClassStatus_close';
									}else{
										$tClrName 			= $aValue['FTPClrName'];
										$tClrClassStatus	= '';
									}

									//รหัสรุ่น
									if($aValue['FTMolName'] == '' || $aValue['FTMolName'] == null){
										$tMolName 			= $aValue['FTMolCode'];
										if($tMolName == '' || $tMolName == null){
											$tMolName 		= '-';
										}
										$tMolClassStatus 	= 'xCNTextClassStatus_close';
									}else{
										$tMolName 			= $aValue['FTMolName'];
										$tMolClassStatus	= '';
									}

									//รหัสขนาด
									if($aValue['FTPzeName'] == '' || $aValue['FTPzeName'] == null){
										$tPzeName 			= $aValue['FTPzeCode'];
										if($tPzeName == '' || $tPzeName == null){
											$tPzeName 		= '-';
										}
										$tPzeClassStatus 	= 'xCNTextClassStatus_close';
									}else{
										$tPzeName 			= $aValue['FTPzeName'];
										$tPzeClassStatus	= '';
									}

									//รหัสหน่วย
									if($aValue['FTPunName'] == '' || $aValue['FTPunName'] == null){
										$tPunName 			= $aValue['FTPunCode'];
										if($tPunName == '' || $tPunName == null){
											$tPunName 		= '-';
										}
										$tPunClassStatus 	= 'xCNTextClassStatus_close';
									}else{
										$tPunName 			= $aValue['FTPunName'];
										$tPunClassStatus	= '';
									}

									//สินค้าขายดี
									if($aValue['FTPdtBestsell'] == '1'){
										$tTextBestSell 		= 'ขายดี'; 
									}else{
										$tTextBestSell 		= '-';
									}

								?>

								<tr data-pdtcode="<?=$aValue['FTPdtCode'];?>" data-staapv='<?=$tStatusAprove;?>' class="<?=$tStatusAprove;?>">
									<th><?=$nKey+1?></th>
									<td><label class="xCNLineHeightInTable <?=$tPDTClassStatus;?>"><?=($aValue['FTPdtCode'] == '') ? '-' : $aValue['FTPdtCode'];?></label></td>
									<td><label class="xCNLineHeightInTable"><?=($aValue['FTPdtName'] == '') ? '-' : $aValue['FTPdtName'];?></label></td>
									<td><label class="xCNLineHeightInTable <?=$tPgpClassStatus;?>"><?=$tPgpName;?></label></td>
									<td><label class="xCNLineHeightInTable <?=$tPtyClassStatus;?>"><?=$tPtyName;?></label></td>
									<td><label class="xCNLineHeightInTable <?=$tSplClassStatus;?>"><?=$tSplName;?></label></td>
									<td><label class="xCNLineHeightInTable <?=$tPbnClassStatus;?>"><?=$tPbnName;?></label></td>
									<td><label class="xCNLineHeightInTable <?=$tPunClassStatus;?>"><?=$tPunName;?></label></td>
									<td><label class="xCNLineHeightInTable <?=$tClrClassStatus;?>"><?=$tClrName;?></label></td>
									<td><label class="xCNLineHeightInTable <?=$tMolClassStatus;?>"><?=$tMolName;?></label></td>
									<td><label class="xCNLineHeightInTable <?=$tPzeClassStatus;?>"><?=$tPzeName;?></label></td>
									<td style="text-align: right;"><label class="xCNLineHeightInTable <?=$tCostSTDDisClassStatus;?>"><?=($aValue['FCPdtCostStd'] == '') ? '-' : $aValue['FCPdtCostStd'];?></label></td>
									<td style="text-align: right;"><label class="xCNLineHeightInTable <?=$tCostDisClassStatus;?>"><?=($aValue['FTPdtCostDis'] == '') ? '-' : $aValue['FTPdtCostDis'];?></label></td>
									<td><label class="xCNLineHeightInTable"><?=$tTextBestSell ;?></label></td>
									<td stlye="padding-top: 15px;"><div class="<?=$tIconClassStatus?>"></div><span class="<?=$tTextClassStatus?>"><?=$tTextStatus?></span></td>
									<td><img class="img-responsive xCNImageDelete" src="<?=base_url().'application/assets/images/icon/delete.png';?>" onClick="JSxProductTmp_Delete(this);"></td>
								</tr>
							<?php } ?>
						<?php }else{ ?>
							<tr><td colspan="99" style="text-align: center;"> - ไม่พบข้อมูล - </td></tr>
						<?php } ?>
					</tbody>
				</table>

			</div>
		</div>
	</div>
<div>


<!-- Modal Cancle Import -->
<button id="obtModalCancleImport" style="display:none;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#odvModalCancleImport"></button>
<div class="modal fade" id="odvModalCancleImport" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title">ยกเลิกการนำเข้า</h5>
		</div>
		<div class="modal-body">
			<label>ข้อมูลที่นำเข้าจะหายทั้งหมด ยืนยันการยกเลิกนำเข้า ? </label>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary xCNCloseDelete" data-dismiss="modal" style="width: 100px;">ปิด</button>
			<button type="button" class="btn btn-danger xCNConfirmDelete">ยืนยัน</button>
		</div>
		</div>
	</div>
</div>


<script>

	//ยกเลิกการนำเข้า
	function JSxCancleImportExcel(){
		$('#obtModalCancleImport').click();

		$('.xCNConfirmDelete').off();
		$('.xCNConfirmDelete').on("click",function(){
			$('.xCNCloseDelete').click();
			setTimeout(function(){
				JSxCallPageProductMain();
			}, 1500);
		});
	}

	//ลบข้อมูลการนำเข้า
	function JSxProductTmp_Delete(elem){
		$(elem).parent().parent().remove();
		var nLen = $('#otbConfirmDataPDT > tbody  > tr').length;
		for(var i=0; i<nLen; i++){
			$("#otbConfirmDataPDT tbody tr:eq("+i+") th:eq(0)").text(i + 1);
		}

		var tPDTCode = $(elem).parent().parent().attr('data-pdtcode');
		$.ajax({
			type	: "POST",
			url		: 'r_producteventDeleteInTmp',
			cache	: false,
			async	: false,
			data 	: {'tPDTCode' : tPDTCode},
			timeout	: 0,
			success	: function (tResult) {},
			error: function (jqXHR, textStatus, errorThrown) {
				JSxModalErrorCenter(jqXHR.responseText);
			}
		});
	}

	//ยืนยันการนำเข้า
	function JSxApvImportExcel(){
		JSxModalProgress('open');
		var aPDTFailExcel 	= [];
		var nLenFail 		= $('#otbConfirmDataPDT > tbody  > tr.fail').length;
		for(var i=0; i<nLenFail; i++){
			//เอาตัวที่ไม่ผ่าน
			var nPDTCode = $("#otbConfirmDataPDT > tbody  > tr.fail:eq("+i+")").data('pdtcode');
			aPDTFailExcel.push({'nPDTCode' : nPDTCode});
		}

		var ntbody = $('#otbConfirmDataPDT > tbody  > tr').length;
		if(ntbody == 0){
			JSxCallPageProductMain();
			return;
		}

		//ถ้ามัน pass อย่างน้อย 1 ตัว ถึงจะให้มันวิ่งเข้า controller
		tConfirmToInsert = false;
		for(var j=0; j<ntbody; j++){
			var tCheckStatus = $("#otbConfirmDataPDT > tbody  > tr").hasClass('pass').toString();
			if(tCheckStatus == 'true'){
				tConfirmToInsert = true;
			}
		}

		if(tConfirmToInsert == true){
			$.ajax({
				type	: "POST",
				url		: 'r_producteventAproveDataInTmp',
				cache	: false,
				async	: false,
				data 	: {'aPDTFailExcel' : aPDTFailExcel},
				timeout	: 0,
				success	: function (tResult) {
					console.log(tResult);
					JSxModalProgress('close');
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('นำเข้าข้อมูลสินค้าสำเร็จ');
					JSxCallPageProductMain();
					setTimeout(function(){
						$('.alert-success').find('.close').click();
					}, 3000);
				},
				error: function (jqXHR, textStatus, errorThrown) {
					JSxModalErrorCenter(jqXHR.responseText);
				}
			});
		}else{
			JSxModalProgress('close');
			$('.alert-danger').addClass('show').fadeIn();
			$('.alert-danger').find('.badge-danger').text('ผิดพลาด');
			$('.alert-danger').find('.xCNTextShow').text('ไม่พบรายการสินค้าที่ผ่าน กรุณาลองใหม่อีกครั้ง');
			$('#oetUserLogin').val('');
			$('#oetUserLogin').focus();
			setTimeout(function(){
				$('.alert-danger').find('.close').click();
			}, 3000);
		}
	}

</script>
