<div class="container-fulid">
	<!--Section บน-->
	<div class="row">
		<div class="col-lg-6 col-md-6"><span class="xCNHeadMenuActive" onclick="JSxCancleImportExcel();">สินค้า</span><span class="xCNHeadMenu">  /  นำเข้าข้อมูล</span></div>
		<div class="col-lg-6 col-md-6">
			<button class="xCNButtonSave pull-right" onclick="JSxApvImportExcel();">ยืนยันการนำเข้า</button>
			<button class="xCNCalcelImport btn btn-outline-danger pull-right" onclick="JSxCancleImportExcel();">ยกเลิกการนำเข้า</button>
		</div>
	</div>

	<!--Section ล่าง-->
	<div class="card" style="margin-top: 10px;">
		<div class="card-body">
			<div class="row">
				
				<table class="table table-striped xCNTableCenter" id="otbConfirmImgPDT">
					<thead>
						<tr>
							<th style="width:5px; text-align: center;">ลำดับ</th>
							<th style="width:100px; text-align: left;">รหัสสินค้า</th>
							<th style="text-align: left;">ชื่อสินค้า</th>
							<th style="text-align: left;">ชื่อกลุ่มสินค้า</th>
							<th style="text-align: left;">ชื่อประเภทสินค้า</th>
							<th style="text-align: left;">ชื่อผู้จำหน่าย</th>
							<th style="width:80px; text-align: left;">ต้นทุน</th>
							<th style="width:100px; text-align: left;">ส่วนลดต้นทุน</th>
							<th style="width:300px; text-align: left;">สถานะ</th>
							<th style="width:50px; text-align: center;">ลบ</th>
						</tr>
					</thead>
					<tbody>
						<?php if($aList['rtCode'] != 800){ ?>
							<?php foreach($aList['raItems'] AS $nKey => $aValue){ ?>
								<?php 
									//สถานะ
									$tPDTClassStatus	= '';
									switch ($aValue) {
										case strlen($aValue['FTPdtCode']) > 50:
											$tIconClassStatus 	= 'xCNIconStatus_close';
											$tTextClassStatus 	= 'xCNTextClassStatus_close';
											$tTextStatus 		= 'รหัสสินค้าเกิน';
											$tStatusAprove		= 'fail';
											$tPDTClassStatus 	= 'xCNTextClassStatus_close';
											break;
										case $aValue['RealPDT'] != null:
											$tIconClassStatus 	= 'xCNIconStatus_close';
											$tTextClassStatus 	= 'xCNTextClassStatus_close';
											$tTextStatus 		= 'สินค้ามีอยู่แล้วในระบบ';
											$tStatusAprove		= 'fail';
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

									//รหัสกลุ่มสินค้า
									if($aValue['FTPgpName'] == '' || $aValue['FTPgpName'] == null){
										$tPgpName 			= $aValue['FTPgpCode'];
										$tPgpClassStatus 	= 'xCNTextClassStatus_close';
									}else{
										$tPgpName = $aValue['FTPgpName'];
										$tPgpClassStatus 	= '';
									}

									//รหัสประเภทสินค้า
									if($aValue['FTPtyName'] == '' || $aValue['FTPtyName'] == null){
										$tPtyName 			= $aValue['FTPtyCode'];
										$tPtyClassStatus 	= 'xCNTextClassStatus_close';
									}else{
										$tPtyName 			= $aValue['FTPtyName'];
										$tPtyClassStatus 	= '';
									}

									//รหัสผู้จำหน่าย
									if($aValue['FTSplName'] == '' || $aValue['FTSplName'] == null){
										$tSplName 			= $aValue['FTSplCode'];
										$tSplClassStatus 	= 'xCNTextClassStatus_close';
									}else{
										$tSplName 			= $aValue['FTSplName'];
										$tSplClassStatus	= '';
									}
								
								?>

								<tr data-pdtcode="<?=$aValue['FTPdtCode'];?>" data-staapv='<?=$tStatusAprove;?>'>
									<th><?=$nKey+1?></th>
									<td><label class="xCNLineHeightInTable <?=$tPDTClassStatus;?>"><?=($aValue['FTPdtCode'] == '') ? '-' : $aValue['FTPdtCode'];?></label></td>
									<td><label class="xCNLineHeightInTable"><?=($aValue['FTPdtName'] == '') ? '-' : $aValue['FTPdtName'];?></label></td>
									<td><label class="xCNLineHeightInTable <?=$tPgpClassStatus;?>"><?=$tPgpName;?></label></td>
									<td><label class="xCNLineHeightInTable <?=$tPtyClassStatus;?>"><?=$tPtyName;?></label></td>
									<td><label class="xCNLineHeightInTable <?=$tSplClassStatus;?>"><?=$tSplName;?></label></td>
									<td style="text-align: right;"><label class="xCNLineHeightInTable"><?=($aValue['FCPdtCostStd'] == '') ? '-' : $aValue['FCPdtCostStd'];?></label></td>
									<td style="text-align: right;"><label class="xCNLineHeightInTable"><?=($aValue['FTPdtCostDis'] == '') ? '-' : $aValue['FTPdtCostDis'];?></label></td>
									<td><div class="<?=$tIconClassStatus?>"></div><span class="<?=$tTextClassStatus?>"><?=$tTextStatus?></span></td>
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
			<label>ข้อมูลรูปภาพที่นำเข้าจะหายทั้งหมด ยืนยันการยกเลิกนำเข้า ? </label>
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
	function JSxCancleImportImg(){
		$('#obtModalCancleImport').click();

		$('.xCNConfirmDelete').off();
		$('.xCNConfirmDelete').on("click",function(){
			$.ajax({
				type	: "POST",
				url		: 'r_producteventDeleteImgInTmp',
				cache	: false,
				timeout	: 0,
				success	: function (tResult) {
					$('.xCNCloseDelete').click();
					setTimeout(function(){
						JSxCallPageProductMain();
					}, 1500);
				},
				error: function (jqXHR, textStatus, errorThrown) {
					alert(jqXHR, textStatus, errorThrown);
				}
			});
		});
	}

	//ลบข้อมูลการนำเข้า
	function JSxProductTmp_Delete(elem){
		$(elem).parent().parent().remove();
		var nLen = $('#otbConfirmImgPDT > tbody  > tr').length;
		for(var i=0; i<nLen; i++){
			$("#otbConfirmImgPDT tbody tr:eq("+i+") th:eq(0)").text(i + 1);
		}
	}

	//ยืนยันการนำเข้า
	function JSxApvImportImg(){
		var aUpdateImg = [];
		var nLen = $('#otbConfirmImgPDT > tbody  > tr').length;
		for(var i=0; i<nLen; i++){
			var nPDTCode = $("#otbConfirmImgPDT tbody tr:eq("+i+")").data('pdtcode');
			var tStaApv	 = $("#otbConfirmImgPDT tbody tr:eq("+i+")").data('staapv');
			var tPathImg = $("#otbConfirmImgPDT tbody tr:eq("+i+")").data('pathimg');
			if(tStaApv == 'pass'){
				var tResult = {'nPDTCode' : nPDTCode , 'tStaApv' : tStaApv , 'tPathImg' : tPathImg}
				aUpdateImg.push(tResult);
			}
		}

		if(aUpdateImg.length == 0){
			console.log('empty');
		}else{
			$.ajax({
				type	: "POST",
				url		: 'r_producteventAproveImgInTmp',
				cache	: false,
				data 	: {'aData' : aUpdateImg},
				timeout	: 0,
				success	: function (tResult) {
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('นำเข้ารูปภาพสินค้าสำเร็จ');
					JSxCallPageProductMain();
					setTimeout(function(){
						$('.alert-success').find('.close').click();
					}, 3000);
				},
				error: function (jqXHR, textStatus, errorThrown) {
					alert(jqXHR, textStatus, errorThrown);
				}
			});
		}
	}

</script>
