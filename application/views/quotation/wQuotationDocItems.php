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
			<th style="text-align: right; width:100px;">จำนวน</th>
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
			$nXqdQty 		= number_format($aDocItems["raItems"][$p]["FCXqdQty"],0);
			$nTotal 		= $nXqdQty * $nXqdUnitPrice;
			$nXqdDis 		= $aDocItems["raItems"][$p]["FCXqdDis"];
			$nXqdDisText 		= $aDocItems["raItems"][$p]["FTXqdDisTxt"];
			$nXqdCost 		= $aDocItems["raItems"][$p]["FTXqdCost"];
			$tSplName 		= $aDocItems["raItems"][$p]["FTSplName"];
			$FTPdtImage		= $aDocItems["raItems"][$p]["FTPdtImage"];

			$tRowUnitPrice = '';
			if(number_format($nXqdUnitPrice,0) < number_format($nXqdCost,0)){
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
				<th><label class="xCNLineHeightInTable"><?=$nNum?></label></th>
				<td class="xCNCellDeleteItem"><img class="img-responsive xCNImageDelete" src="<?=base_url().'application/assets/images/icon/delete.png';?>" onClick="JSxDeleteItemInTempQuotation('<?=$nSeq?>','<?=$tPdtCode?>');"></td>
				<td class="xCNTdHaveImage"><img id="oimImgInsertorEditProduct" class="img-responsive xCNImgCenter" src="<?=@$tPathImage;?>"></td>
				<td><label class="xCNLineHeightInTable" data-pdtcode="<?=$tPdtCode?>" id="olbPdtCode<?=$nSeq?>">
					  <?=$tPdtCode . " - " . $tPdtName; ?> </label>
				</td>
				<td><label class="xCNLineHeightInTable"><?=($tPunName == '') ? '-' : $tPunName;?></label></td>
				<?php
        $tStaSwhSplCost = '';
				if ($tSesUserGroup == 4) {
            $tStaSwhSplCost = "display:block";
				}else{
					  $tStaSwhSplCost = "display:none";
				}
				?>
					<td style="<?=$tStaSwhSplCost?>"><label class="xCNLineHeightInTable"><?=($tSplName == '') ? '-' : $tSplName;?></label></td>
					<td class="text-right" style="<?=$tStaSwhSplCost?>">
						  <label class="xCNLineHeightInTable" id="oblPdtCost<?=$nSeq?>"><?=number_format($nXqdCost, 2); ?></label></td>

				<td class="text-right">
					<label class="xCNLineHeightInTable">
						      <div class="input-container">
											<i class="xWBnticon fa fa-info-circle fa-xs"
												 style="font-size: 0.5rem;"
												 title="กรอกราคาที่ต้องการไม่ต้องกรอกเครื่องหมาย , แล้วกด Enter"
												 onclick="alert('กรอกราคาที่ต้องการไม่ต้องกรอกเครื่องหมาย , แล้วกด Enter')"></i>
								      <input type="text"
											       id="oetPdtUnitPrice<?=$nSeq?>"
											       class="text-right xCNEditInline xCNInputNumericWithDecimal <?=$tRowUnitPrice?>"
											       value="<?=number_format($nXqdUnitPrice, 2);?>"
														 data-seq="<?=$nSeq?>"
														 style="width:90px;"
														 onkeypress="return FSxQUOEditDocItemPri(event,this)">
									</div>
          </label>
				</td>
				<td>
					  <!-- <input type="text"
						       class="text-right xCNEditInline xCNInputNumericWithDecimal"
									 value="<?= $nXqdQty ?>"
									 data-seq="<?=$nSeq?>"
									 style="width:80px;"
									 onkeypress="return FSxQUOEditDocItemQty(event,this)">
									 <img src="<?=base_url('application/assets/images/icon/info-16.png')?>" > -->

									 <div class="input-container">
										    <i class="xWBnticon fa fa-info-circle fa-xs"
												   style="font-size: 0.5rem;"
													 title="กรอกจำนวนที่ต้องการแล้วกด Enter"
													 onclick="alert('กรอกจำนวนที่ต้องการแล้วกด Enter')"></i>
										    <input type="text"
												       class="text-right xCNEditInline xCNInputNumericWithDecimal"
															 id="oetDocItemQty<?=$nSeq?>"
															 value="<?=$nXqdQty ?>"
															 data-seq="<?=$nSeq?>"
															 style="width:80px;"
															 onkeypress="return FSxQUOEditDocItemQty(event,this)" >
									  </div>
				</td>
				<td class="text-right"><label class="xCNLineHeightInTable" id="olbItemNet<?=$nSeq?>"><?=number_format($nTotal, 2); ?></label></td>
				<td>
					    <div class="input-container">
								  <i class="xWBnticon fa fa-info-circle"
									   style="font-size: 0.5rem;"
									   title="กรอกส่วนลดเช่น 10% หรือ 100 แล้วกดปุ่ม Enter"
									   onclick="alert('กรอกส่วนลดเช่น 10% หรือ 100 แล้วกดปุ่ม Enter')"></i>
							    <input type="text"
									       id="oetItemDiscount<?=$nSeq?>"
									       class="text-right xCNEditInline xCNNumberandPercent"
												 value="<?=$nXqdDisText?>"
												 data-seq="<?=$nSeq?>"
												 style="width:80px;"
												 onkeypress="return FSxQUODocItemDiscount(event,this)">
						  </div>
				</td>
				<td class="text-right">
					  <label class="xCNLineHeightInTable">
							     <?=number_format($nPdtNetTotal, 2);?>
						</label>
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
        <h5 class="modal-title">ลบข้อมูล</h5>
      </div>
      <div class="modal-body">
        <label>ยืนยันการลบข้อมูล ? </label>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary xCNCloseDelete" data-dismiss="modal" style="width: 100px;">ปิด</button>
        <button type="button" class="btn btn-danger xCNConfirmDelete xCNConfirmDeleteItemForm">ยืนยัน</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?=base_url('application/assets/js/jFormValidate.js')?>"></script>
<script>

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
					alert(jqXHR, textStatus, errorThrown);
				}
			});
		});
	}
</script>
