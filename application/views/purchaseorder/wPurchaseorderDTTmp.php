
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

<table class="table table-striped xCNTableCenter" id="otbPODTTable">
  <thead>
	<tr>
		<th style="width:10px;">ลำดับ</th>
		<th class="xCNCellDeleteItem" style="width:20px; text-align: center;">ลบ</th>
		<th style="text-align: center; width:140px;">รูปภาพ</th>
		<th>รายการ</th>
		<th>หน่วย</th>
		<th class="text-nowrap" style="text-align: right; width:150px;">ราคา/หน่วย</th>
		<th class="text-nowrap" style="text-align: right; width:150px;">จำนวน</th>
		<th class="text-nowrap" style="text-align: right; width:180px;">จำนวนเงิน</th>
		<th class="text-nowrap" style="text-align: right; width:150px;">ส่วนลด</th>
		<th class="text-nowrap" style="text-align: right; width:180px;">จำนวนเงินรวม</th>
	</tr>
  </thead>
  <tbody>
	  	<?php $nDocNetTotal = 0; ?>
		<?php if($aListTmp['rtCode'] != 800){ ?>
			<?php foreach($aListTmp['raItems'] AS $nKey => $aValue){ ?>
				<tr>
					<?php 
						$nSeq 			= $aValue['FNXpoSeq'];
						$FTPdtImage		= $aValue["FTPdtImage"];
						$tPdtCode		= $aValue["FTPdtCode"];
						$tPdtName		= $aValue["FTPdtName"];
						$tSetNewName	= $aValue["FTPdtStaEditName"];
						$tPunName		= $aValue["FTPunName"];
						$nXpoCost		= $aValue["FTXpoCost"];
						$nXpoUnitPrice  = $aValue["FCXpoUnitPrice"];
						$nXpoDisText 	= $aValue["FTXpoDisTxt"];
						$nXpoQty  		= number_format($aValue["FCXpoQty"],0);
						$nTotal			= str_replace(",","",$nXpoQty) * $aValue["FCXpoUnitPrice"];
						$nXqdDis		= $aValue["FCXpoDis"];

						if ($nXqdDis == "") {
							$nXqdDis = 0;
						} else {
							$nXqdDis = $nXqdDis;
						}
			
						$tDisType = substr($nXqdDis, strlen($nXqdDis) - 1);
						if ($tDisType == "") {
							$nPdtNetTotal = $nTotal;
						} else if ($tDisType == "%") {
							$nPdtNetTotal = $nTotal - (($nTotal * substr($nXqdDis, 0, strlen($nXqdDis) - 1)) / 100);
						} else {
							$nPdtNetTotal = $nTotal - $nXqdDis;
						}
						$nDocNetTotal = $nDocNetTotal + $nPdtNetTotal;

						if(@$FTPdtImage != '' || @$FTPdtImage != null){
							$tPathImage = './application/assets/images/products/'.@$FTPdtImage;
							if (file_exists($tPathImage)){
								$tPathImage = base_url().'application/assets/images/products/'.@$FTPdtImage;
							}else{
								$tPathImage = base_url().'application/assets/images/products/NoImage.png';
							}
						}else{
							$tPathImage = './application/assets/images/products/NoImage.png';
						}
					?>
					<th class="text-nowrap"><label class="xCNLineHeightInTable"><?=$nKey + 1?></label></th>
					<td class="xCNCellDeleteItem"><img class="img-responsive xCNImageDelete" src="<?=base_url().'application/assets/images/icon/delete.png';?>" onClick="JSxDeleteItemInTempPO('<?=$nSeq?>','<?=$tPdtCode?>');"></td>
					<td class="xCNTdHaveImage"><img id="oimImgInsertorEditProduct" class="img-responsive xCNImgCenter" src="<?=@$tPathImage;?>"></td>
					<td class="text-nowrap"><label class="xCNLineHeightInTable" data-pdtcode="<?=$tPdtCode?>" id="olbPdtCode<?=$nSeq?>">
						<span><?=$tPdtCode . " - " . $tPdtName; ?></span>
						<?php if($tSetNewName == 1){  //สินค้าที่สามารถแก้ไขชื่อได้ ?>
							<input type="hidden" id="ohdNameItem<?=$nSeq?>" value="<?=$tPdtName?>">
							<img class="img-responsive xCNImageEdit" style="display: inline; margin-left: 10px;" src="<?=base_url().'application/assets/images/icon/edit.png';?>" onClick="JSxSetNewName('<?=$nSeq?>','<?=$tPdtCode?>');"></label>
						<?php } ?>
					</td>
					<td class="text-nowrap"><label class="xCNLineHeightInTable"><?=($tPunName == '') ? '-' : $tPunName;?></label></td>
					<td class="text-right text-nowrap">
						<label class="">
							<div class="input-container">
								<i class="xWBnticon fa fa-info-circle fa-xs"
									style="font-size: 0.5rem;"
									title="กรอกราคาที่ต้องการไม่ต้องกรอกเครื่องหมาย , แล้วกด Enter"
									onclick="alert('กรอกราคาที่ต้องการไม่ต้องกรอกเครื่องหมาย , แล้วกด Enter')"></i>
								<input type="text"
									id="oetPdtUnitPrice<?=$nSeq?>"
									class="text-right xCNEditInline xCNInputNumericWithDecimal xCNPdtUnitPrice"
									maxlength="9"
									value="<?=number_format($nXpoUnitPrice, 2);?>"
									data-seq="<?=$nSeq?>"
									style="width:100%;">
							</div>
						</label>
					</td>
					<td class="text-nowrap">
						<div class="input-container">
							<i class="xWBnticon fa fa-info-circle fa-xs"
								style="font-size: 0.5rem;"
								title="กรอกจำนวนที่ต้องการแล้วกด Enter"
								onclick="alert('กรอกจำนวนที่ต้องการแล้วกด Enter')"></i>
							<input type="text"
								class="text-right xCNEditInline xCNInputNumericWithDecimal xCNDocItemQty"
								maxlength="6"
								autocomplete="off"
								id="oetDocItemQty<?=$nSeq?>"
								value="<?=$nXpoQty ?>"
								data-seq="<?=$nSeq?>"
								style="width:100%;">
						</div>
					</td>
					<td class="text-right text-nowrap">
						<label class="xCNLineHeightInTable" id="olbItemNet<?=$nSeq?>"><?=number_format($nTotal, 2); ?></label>
					</td>
					<td class="text-nowrap">
						<div class="input-container">
							<i class="xWBnticon fa fa-info-circle"
								style="font-size: 0.5rem;"
								title="กรอกส่วนลดเช่น 10% หรือ 100 แล้วกดปุ่ม Enter"
								onclick="alert('กรอกส่วนลดเช่น 10% หรือ 100 แล้วกดปุ่ม Enter')"></i>
							<input type="text"
								id="oetItemDiscount<?=$nSeq?>"
								class="text-right xCNEditInline xCNNumberandPercent xCNItemDiscount"
								maxlength="15"
								autocomplete="off"
								value="<?=$nXpoDisText?>"
								data-seq="<?=$nSeq?>"
								style="width:100%;" >
						</div>
					</td>
					<td class="text-right text-nowrap">
						<label class="xCNLineHeightInTable"><?=number_format($nPdtNetTotal, 2);?></label>
					</td>
				</tr>
			<?php } ?>
		<?php }else{ ?>
			<tr class="otrPOTmpEmpty"><td colspan="99" style="text-align: center;"> - ไม่พบข้อมูล - </td></tr>
		<?php } ?>
		<span id="ospPODocNetTotal" style="display:none;"><?=$nDocNetTotal;?></span>
  </tbody>
</table>

<!-- Modal กดลบสินค้าในตะกร้า -->
<button id="obtModalDeleteItemForm" style="display:none;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#odvModalDeleteItemItemForm"></button>
<div class="modal fade" id="odvModalDeleteItemItemForm" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">การแจ้งยืนยัน</h5>
      </div>
      <div class="modal-body">
        <label>คุณต้องการลบรายการสินค้านี้ออกจากเอกสารใช่หรือไม่ ? <br>-กดปุ่ม "ยืนยัน" เพื่อลบรายการ <br>-กดปุ่ม "ปิด" เพื่อยกเลิกการลบรายการ</label>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary xCNCloseDelete" data-dismiss="modal" style="width: 100px;">ปิด</button>
        <button type="button" class="btn btn-danger xCNConfirmDelete xCNConfirmDeleteItemForm">ยืนยัน</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal เปลี่ยนชื่อสินค้า -->
<button id="obtModalSetNewName" style="display:none;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#odvModalSetNewName"></button>
<div class="modal fade" id="odvModalSetNewName" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">เปลี่ยนชื่อสินค้า</h5>
      </div>
      <div class="modal-body">
	  	<div class="form-group">
		  	<label>ชื่อสินค้า</label>
			<input type="text" class="form-control" maxlength="200" id="oetSetNewName" name="oetSetNewName" 
			placeholder="กรุณาระบุชื่อสินค้าใหม่" autocomplete="off" value="">
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary xCNCloseDelete" data-dismiss="modal" style="width: 100px;">ปิด</button>
        <button type="button" class="btn btn-danger xCNConfirmDelete xCNConfirmSetNewName">ยืนยัน</button>
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url('application/assets/js/jFormValidate.js')?>"></script>
<script>
	//ถ้าเข้ามาแบบแก้ไข แต่ ไม่มีสิทธิ์ในการแก้ไข
	if('<?=$tPer_edit?>' != ''){
		$('.xCNEditInline').attr('disabled',true);
	}

	//เปลี่ยนราคา
	$('.xCNPdtUnitPrice').on('change keyup', function(event){
		if(event.type == "change"){
			FSxPOEditDocItemPri(this)
		}
		if(event.keyCode == 13) {
			FSxPOEditDocItemPri(this)
		}
	});

	//แก้ไขราคาขายต่อหน่วยในหน้าเอกสาร
	function FSxPOEditDocItemPri(poElm) {
		var nPdtUnitPrice 		= $(poElm).val();
		var tDocNo 				= $("#ospPODocNo").attr("data-docno");
		var nItemSeq 			= $(poElm).attr("data-seq");
		var tPdtCode 			= $("#olbPdtCode"+nItemSeq).attr("data-pdtcode");
		var nItemDiscount 		= $("#oetItemDiscount"+nItemSeq).val()
		var nItemQTY 			= $("#oetDocItemQty"+nItemSeq).val()
		var nPdtUnitPriceCng 	= nPdtUnitPrice.replace(/,/g, "");

		$.ajax({
			url		: 'r_purchaseorderEditItemPrice',
			timeout	: 0,
			type	: 'POST',
			data	: {
				'tDocNo'		: tDocNo,
				'nItemSeq'		: nItemSeq,
				'nItemQTY'		: nItemQTY,
				'tPdtCode' 		: tPdtCode,
				'nPdtUnitPrice' : nPdtUnitPrice,
				'nItemDiscount' : nItemDiscount
			},
			success	: function(tResult) {
				JSvLoadTableDTTmp(1);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				JSxModalErrorCenter(jqXHR.responseText);
			}
		});
	}

	//###############################################################################################

	//เปลี่ยนจำนวน
	$('.xCNDocItemQty').on('change keyup', function(event){
		if(event.type == "change"){
			FSxPOEditDocItemQty(this)
		}
		if(event.keyCode == 13) {
			FSxPOEditDocItemQty(this)
		}
	});

	//แก้ไขจำนวนสินค้าในหน้าเอกสาร
	function FSxPOEditDocItemQty(poElm) {
		var nItemQTY 		= $(poElm).val();
		var tDocNo 			= $("#ospPODocNo").attr("data-docno");
		var nItemSeq 		= $(poElm).attr("data-seq");
		var tPdtCode 		= $("#olbPdtCode"+nItemSeq).attr("data-pdtcode");
		var nPdtUnitPrice 	= $("#oetPdtUnitPrice"+nItemSeq).val()
		var nItemDiscount 	= $("#oetItemDiscount"+nItemSeq).val()

		$('#oetItemDiscount'+nItemSeq).val('')

		$.ajax({
			url		: 'r_purchaseorderEditItemQty',
			timeout	: 0,
			type	: 'POST',
			data	: {
				'tDocNo'		: tDocNo,
				'nItemSeq'		: nItemSeq,
				'nItemQTY'		: nItemQTY,
				'tPdtCode '		: tPdtCode,
				'nPdtUnitPrice' : nPdtUnitPrice,
				'nItemDiscount' : nItemDiscount
			},
			datatype: 'json',
			success	: function(tResult) {
				JSvLoadTableDTTmp(1);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				JSxModalErrorCenter(jqXHR.responseText);
			}
		});
	}

	//###############################################################################################

	//ส่วนลด
	$('.xCNItemDiscount').on('change keyup', function(event){
		if(event.type == "change"){
			FSxPODocItemDiscount(this)
		}
		if(event.keyCode == 13) {
			FSxPODocItemDiscount(this)
		}
	});

	//ส่วนลดรายการ
	function FSxPODocItemDiscount(poElm) {
		var nItemDiscount 		= $(poElm).val();
		var tDocNo 				= $("#ospPODocNo").attr("data-docno");
		var nItemSeq 			= $(poElm).attr("data-seq");
		var tPdtCode 			= $("#olbPdtCode"+nItemSeq).attr("data-pdtcode");
		var nItemNet 			= $("#olbItemNet"+nItemSeq).text();

		if($(poElm).val() != ''){
			$.ajax({
				url		: 'r_purchaseorderDiscount',
				timeout	: 0,
				type	: 'POST',
				data	:	 {
					'tDocNo'			: tDocNo,
					'nItemSeq'			: nItemSeq,
					'nItemDiscount'		: nItemDiscount,
					'tPdtCode' 			: tPdtCode,
					'nItemNet' 			: nItemNet,
				},
				datatype: 'json',
				success	: function(tResult) {
					JSvLoadTableDTTmp(1);
				},
				error: function(jqXHR, textStatus, errorThrown) {
					JSxModalErrorCenter(jqXHR.responseText);
				}
			});
		}
	}

	//###############################################################################################

	function JCNPONumberToCurrency(nNumber){
		// $.ajax({
		// 	url		: 'r_NumberToCurrency',
		// 	timeout	: 0,
		// 	type	: 'GET',
		// 	data	: {nNumber: nNumber},
		// 	datatype: 'json'
		// })
		// .done(function(data) {
		// 	$('#ospPOTotalText').text(data);
		// })
		// .fail(function(jqXHR, textStatus, errorThrown) {
		// 	//serrorFunction();
		// });
	}

	//ลบสินค้า
	function JSxDeleteItemInTempPO(pnSeq,pnPDTCode){
		if($('#olbPODocNo').text() == 'PO##########'){
			tDocumentnumber = 'PO##########';
		}else{
			tDocumentnumber = $('#olbPODocNo').text();
		}

		$('#obtModalDeleteItemForm').click();
		$('.xCNConfirmDeleteItemForm').off();
		$('.xCNConfirmDeleteItemForm').on("click",function(){
			$.ajax({
				type	: "POST",
				url		: 'r_purchaseorderDeleteTmp',
				data	: { 'pnSeq' : pnSeq , 'pnPDTCode' : pnPDTCode , 'ptDocument' : tDocumentnumber },
				cache	: false,
				timeout	: 0,
				success	: function(tResult) {
					$('#obtModalDeleteItemForm').click();
					setTimeout(function(){
						JSvLoadTableDTTmp(1);
					}, 500);
				},
				error: function(jqXHR, textStatus, errorThrown) {
					JSxModalErrorCenter(jqXHR.responseText);
				}
			});
		});
	}

	//เปลี่ยนชื่อสินค้า
	function JSxSetNewName(pnSeq,pnPDTCode){
		$('#obtModalSetNewName').click();

		//เอาค่าเดิมไปใส่
		var tNameOld = $('#ohdNameItem'+pnSeq).val();
		$('#oetSetNewName').val(tNameOld);

		//กดยืนยัน
		$('.xCNConfirmSetNewName').off();
		$('.xCNConfirmSetNewName').on('click',function(){
			//เปลี่ยนชื่อสินค้า
			$.ajax({
				type	: "POST",
				url		: 'r_purchaseorderChangenameindt',
				data	: { 'pnSeq' : pnSeq , 'pnPDTCode' : pnPDTCode , 'ptPDTName' : $('#oetSetNewName').val() },
				cache	: false,
				timeout	: 0,
				success	: function(tResult) {
					$('#olbPdtCode'+pnSeq).find('span').text(pnPDTCode + ' - ' + $('#oetSetNewName').val())
					$('#obtModalSetNewName').click();
					$('#ohdNameItem'+pnSeq).val($('#oetSetNewName').val());
				},
				error: function(jqXHR, textStatus, errorThrown) {
					JSxModalErrorCenter(jqXHR.responseText);
				}
			});
		});
	}

</script>
