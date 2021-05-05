<?php
		$tStaSwhSplCost = '';
		$tStaSwhSpl		= '';
		if ($tSesUserGroup == 4) {
			$tStaSwhSpl 		= "display:table-cell;";
			$tStaSwhSplCost 	= "display:table-cell; font-weight: bold;";
		}else{
			$tStaSwhSpl			= "display:none";
			$tStaSwhSplCost 	= "display:none";
		}
?>
<table class="table table-striped xCNTableCenter" style="margin-bottom: 0rem;">
	<thead>
		<tr>
			<th style="width:10px;">ลำดับ</th>
			<th class="xCNCellDeleteItem" style="width:20px; text-align: center;">ลบ</th>
			<th style="text-align: center;">รูปภาพ</th>
			<th>รายการ</th>
			<th>หน่วย</th>
			<th class="text-nowrap" style="<?=$tStaSwhSpl?>">ผู้จำหน่าย</th>
			<th class="text-nowrap" style="text-align: right;<?=$tStaSwhSplCost?>">ต้นทุน</th>
			<th class="text-nowrap" style="text-align: right;">ราคา/หน่วย</th>
			<th class="text-nowrap" style="text-align: right; width:100px;">จำนวน</th>
			<th class="text-nowrap" style="text-align: right;">จำนวนเงิน</th>
			<th class="text-nowrap" style="text-align: right; width:80px;">ส่วนลด</th>
			<th class="text-nowrap" style="text-align: right;">จำนวนเงินรวม</th>
		</tr>
	</thead>
	<?php if ($aDocItems["nTotalRes"] > 0) { ?>
		<?php
		$nNum			= 1;
		$nTotal 		= 0;
		$nPdtNetTotal 	= 0;
		$nDocNetTotal 	= 0;
		$nXqdDis 		= 0;
		for ($p = 0; $p < $aDocItems["nTotalRes"]; $p++) {

			$nSeq			= $aDocItems["raItems"][$p]['FNXqdSeq'];
			$tPdtCode 		= $aDocItems["raItems"][$p]["FTPdtCode"];
			$tPdtName 		= $aDocItems["raItems"][$p]["FTPdtName"];
			$tPunName 		= $aDocItems["raItems"][$p]["FTPunName"];
			$nXqdUnitPrice 	= $aDocItems["raItems"][$p]["FCXqdUnitPrice"];
			$nXqdQty 		= number_format($aDocItems["raItems"][$p]["FCXqdQty"],0);
			$nTotal 		= str_replace(",","",$nXqdQty) * $nXqdUnitPrice;
			$nXqdDis 		= $aDocItems["raItems"][$p]["FCXqdDis"];
			$nXqdDisText 		= $aDocItems["raItems"][$p]["FTXqdDisTxt"];
			$nXqdCost 		= $aDocItems["raItems"][$p]["FTXqdCost"];
			$tSplName 		= $aDocItems["raItems"][$p]["FTSplName"];
			$FTPdtImage		= $aDocItems["raItems"][$p]["FTPdtImage"];

			$tRowUnitPrice = '';
			if($nXqdUnitPrice < $nXqdCost){
				 $tRowUnitPrice = 'xWarnningPrice';
			}else{
				$tRowUnitPrice = '';
			}

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
			<tr>
				<th class="text-nowrap"><label class="xCNLineHeightInTable"><?=$nNum?></label></th>
				<td class="xCNCellDeleteItem"><img class="img-responsive xCNImageDelete" src="<?=base_url().'application/assets/images/icon/delete.png';?>" onClick="JSxDeleteItemInTempQuotation('<?=$nSeq?>','<?=$tPdtCode?>');"></td>
				<td class="xCNTdHaveImage"><img id="oimImgInsertorEditProduct" class="img-responsive xCNImgCenter" src="<?=@$tPathImage;?>"></td>
				<td class="text-nowrap"><label class="xCNLineHeightInTable" data-pdtcode="<?=$tPdtCode?>" id="olbPdtCode<?=$nSeq?>">
					<span><?=$tPdtCode . " - " . $tPdtName; ?></span>

					<?php if($aDocItems["raItems"][$p]['FTPdtStaEditName'] == 1){  //สินค้าที่สามารถแก้ไขชื่อได้ ?>
						<img class="img-responsive xCNImageEdit" style="display: inline; margin-left: 10px;" src="<?=base_url().'application/assets/images/icon/edit.png';?>" onClick="JSxSetNewName('<?=$nSeq?>','<?=$tPdtCode?>','<?=$tPdtName?>');"></label>
					<?php } ?>
				</td>
				<td class="text-nowrap"><label class="xCNLineHeightInTable"><?=($tPunName == '') ? '-' : $tPunName;?></label></td>
				<td class="text-nowrap" style="<?=$tStaSwhSpl?>">
					<label class="xCNLineHeightInTable"><?=($tSplName == '') ? '-' : $tSplName;?></label>
				</td>
				<td class="text-right text-nowrap" style="<?=$tStaSwhSplCost?>">
					<label class="xCNLineHeightInTable" id="oblPdtCost<?=$nSeq?>"><?=number_format($nXqdCost, 2); ?></label>
				</td>
				<td class="text-right text-nowrap">
					<label class="">
						<div class="input-container">
							<i class="xWBnticon fa fa-info-circle fa-xs"
								style="font-size: 0.5rem;"
								title="กรอกราคาที่ต้องการไม่ต้องกรอกเครื่องหมาย , แล้วกด Enter"
								onclick="alert('กรอกราคาที่ต้องการไม่ต้องกรอกเครื่องหมาย , แล้วกด Enter')"></i>
							<input type="text"
								id="oetPdtUnitPrice<?=$nSeq?>"
								class="text-right xCNEditInline xCNInputNumericWithDecimal <?=$tRowUnitPrice?> xCNPdtUnitPrice"
								value="<?=number_format($nXqdUnitPrice, 2);?>"
								data-seq="<?=$nSeq?>"
								style="width:90px;">
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
							id="oetDocItemQty<?=$nSeq?>"
							value="<?=$nXqdQty ?>"
							data-seq="<?=$nSeq?>"
							style="width:80px;">
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
							value="<?=$nXqdDisText?>"
							data-seq="<?=$nSeq?>"
							style="width:80px;" >
					</div>
				</td>
				<td class="text-right text-nowrap">
					<label class="xCNLineHeightInTable"><?=number_format($nPdtNetTotal, 2);?></label>
				</td>
			</tr>
			<?php $nNum++; ?>
		<?php } ?>
	<?php } else { ?>
		<tr>
			<td colspan="99" style="text-align: center;">-ไม่พบรายการสินค้าในเอกสาร-</td>
		</tr>
	<?php } ?>
</table>

<span id="ospDocNetTotal" style="display:none"><?=$nDocNetTotal;?></span>

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

<script type="text/javascript" src="<?=base_url('application/assets/js/jFormValidate.js')?>"></script>
<script>

	//ส่วนลด
	$('.xCNItemDiscount').on('change keyup', function(event){
		if(event.type == "change"){
			FSxQUODocItemDiscount(this)
		}
		if(event.keyCode == 13) {
			FSxQUODocItemDiscount(this)
		}
	});

	//เปลี่ยนราคา
	$('.xCNPdtUnitPrice').on('change keyup', function(event){
		if(event.type == "change"){
			FSxQUOEditDocItemPri(this)
		}
		if(event.keyCode == 13) {
			FSxQUOEditDocItemPri(this)
		}
	});

	//เปลี่ยนจำนวน
	$('.xCNDocItemQty').on('change keyup', function(event){
		if(event.type == "change"){
				FSxQUOEditDocItemQty(this)
		}
		if(event.keyCode == 13) {
				FSxQUOEditDocItemQty(this)
		}
	});

	//Delete Item
	function JSxDeleteItemInTempQuotation(pnSeq,pnPDTCode){
		if($('#olbDocNo').text() == 'SQ######-#####'){
			tDocumentnumber = '';
		}else{
			tDocumentnumber = $('#olbDocNo').text();
		}

		$('#obtModalDeleteItemForm').click();
		$('.xCNConfirmDeleteItemForm').off();
		$('.xCNConfirmDeleteItemForm').on("click",function(){
			$.ajax({
				type	: "POST",
				url		: 'r_quodeleteItem',
				data	: { 'pnSeq' : pnSeq , 'pnPDTCode' : pnPDTCode , 'ptDocument' : tDocumentnumber },
				cache	: false,
				timeout	: 0,
				success	: function(tResult) {
					$('#obtModalDeleteItemForm').click();
					setTimeout(function(){
						FSvQUODocItems();
					}, 500);
				},
				error: function(jqXHR, textStatus, errorThrown) {
					JSxModalErrorCenter(jqXHR.responseText);
				}
			});
		});
	}

	//เปลี่ยนชื่อสินค้า
	function JSxSetNewName(pnSeq,pnPDTCode,ptPDTName){
		$('#obtModalSetNewName').click();

		//เอาค่าเดิมไปใส่
		$('#oetSetNewName').val(ptPDTName);

		//กดยืนยัน
		$('.xCNConfirmSetNewName').off();
		$('.xCNConfirmSetNewName').on('click',function(){
			$('#olbPdtCode'+pnSeq).find('span').text(pnPDTCode + ' - ' + $('#oetSetNewName').val())
			$('#obtModalSetNewName').click();
		});
	}
</script>
<label id="ospStaWarnning"></label>
