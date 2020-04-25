<table class="table table-striped xCNTableCenter">
	<thead>
		<tr>
			<th style="width:10px;">ลำดับ</th>
			<th class="xCNCellDeleteItem" style="width:20px; text-align: center;">ลบ</th>
			<th style="text-align: center;">รูปภาพ</th>
			<th>รายการ</th>
			<th>หน่วย</th>
			<?php
			if ($tSesUserGroup == 4) { ?>
				<th>ผู้จำหน่าย</th>
				<th style="text-align: right;">ต้นทุน</th>
			<?php } ?>
			<th style="text-align: right;">ราคา/หน่วย</th>
			<th style="text-align: right; width:80px;">จำนวน</th>
			<th style="text-align: right;">จำนวนเงิน</th>
			<th style="text-align: right; width:80px;">ส่วนลด</th>
			<th style="text-align: right;">จำนวนเงินรวม</th>
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
			$nXqdQty 		= $aDocItems["raItems"][$p]["FCXqdQty"];
			$nTotal 		= $nXqdQty * $nXqdUnitPrice;
			$nXqdDis 		= $aDocItems["raItems"][$p]["FCXqdDis"];
			$nXqdCost 		= $aDocItems["raItems"][$p]["FTXqdCost"];
			$tSplName 		= $aDocItems["raItems"][$p]["FTSplName"];
			$FTPdtImage		= $aDocItems["raItems"][$p]["FTPdtImage"];

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
				<th><label class="xCNLineHeightInTable"><?=$nNum?></label></th>
				<td class="xCNCellDeleteItem"><img class="img-responsive xCNImageDelete" src="<?=base_url().'application/assets/images/icon/delete.png';?>" onClick="JSxDeleteItemInTempQuotation('<?=$nSeq?>','<?=$tPdtCode?>');"></td>
				<td class="xCNTdHaveImage"><img id="oimImgInsertorEditProduct" class="img-responsive xCNImgCenter" src="<?=@$tPathImage;?>"></td>
				<td><label class="xCNLineHeightInTable" data-pdtcode="<?=$tPdtCode?>" id="olbPdtCode<?=$nSeq?>">
					  <?=$tPdtCode . " - " . $tPdtName; ?> </label>
				</td>
				<td><label class="xCNLineHeightInTable"><?=($tPunName == '') ? '-' : $tPunName;?></label></td>
				<?php if ($tSesUserGroup == 4) { ?>
					<td><label class="xCNLineHeightInTable"><?=($tSplName == '') ? '-' : $tSplName;?></label></td>
					<td class="text-right"><label class="xCNLineHeightInTable"><?=number_format($nXqdCost, 2); ?></label></td>
				<?php } ?>
				<td class="text-right">
					<label class="xCNLineHeightInTable">
						      <input type="text"
									       id="oetPdtUnitPrice<?=$nSeq?>"
									       class="text-right xCNEditInline xCNInputNumericWithDecimal"
									       value="<?=number_format($nXqdUnitPrice, 2);?>"
												 style="width:90px;">
          </label>
				</td>
				<td>
					  <input type="text"
						       class="text-right xCNEditInline xCNInputNumericWithDecimal"
									 value="<?= $nXqdQty ?>"
									 data-seq="<?=$nSeq?>"
									 style="width:80px;"
									 onkeypress="return FSxQUOEditDocItemQty(event,this)">
				</td>
				<td class="text-right"><label class="xCNLineHeightInTable"><?=number_format($nTotal, 2); ?></label></td>
				<td> <input type="text" class="text-right xCNEditInline xCNInputNumericWithDecimal" value="<?= $nXqdDis ?>" style="width:80px;"> </td>
				<td class="text-right"><label class="xCNLineHeightInTable"><?=number_format($nPdtNetTotal, 2);?></label></td>
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

<script type="text/javascript" src="<?=base_url('application/assets/js/jFormValidate.js')?>"></script>
<script>
	//Delete Item
	function JSxDeleteItemInTempQuotation(pnSeq,pnPDTCode){
		if($('#olbDocNo').text() == 'SQ######-#####'){
			tDocumentnumber = '';
		}else{
			tDocumentnumber = $('#olbDocNo').text();
		}
		$.ajax({
			type	: "POST",
			url		: 'r_quodeleteItem',
			data	: { 'pnSeq' : pnSeq , 'pnPDTCode' : pnPDTCode , 'ptDocument' : tDocumentnumber },
			cache	: false,
			timeout	: 0,
			success	: function(tResult) {
				FSvQUODocItems();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert(jqXHR, textStatus, errorThrown);
			}
		});
	}
</script>
