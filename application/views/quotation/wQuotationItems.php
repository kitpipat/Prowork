<div class="col-lg-12">
	<div class="xWQuotationTtems-Title">
		<div class="row">
			<div class="col-lg-7">รายการสินค้า</div>
			<div class="col-lg-5 text-right"><?php echo $aQuoItemsList['nTotalRes']; ?> รายการ</div>
		</div>
	</div>
</div>

<?php if ($aQuoItemsList['nTotalRes'] > 0) { ?>
	<?php
		$nTotal = 0;
		for ($i = 0; $i < $aQuoItemsList['nTotalRes']; $i++) {
			$nQty 			= $aQuoItemsList['raItems'][$i]['FCXqdQty'];
			$nItemSeq 		= $aQuoItemsList['raItems'][$i]['FNXqdSeq'];
			$nPdtUnitPri 	= $aQuoItemsList['raItems'][$i]['FCXqdUnitPrice'];
			$FTPdtImage		= $aQuoItemsList['raItems'][$i]['FTPdtImage'];
			$nItemPrice 	= $nQty * $nPdtUnitPri;
			$nTotal 		= $nTotal + $nItemPrice;
		?>

		<?php 
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

		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
			<img src="<?=$tPathImage;?>">
		</div>
		<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
			<span style="color:red;cursor:pointer" data-seq="<?= $nItemSeq ?>" onclick="FSxQUODelItem(this)">[x]</span>
			<span class="ospItemInDoc"><?=$aQuoItemsList['raItems'][$i]['FTPdtName']; ?></span><br>
			ราคา / หน่วย : &#3647; <?=number_format($nPdtUnitPri, 2); ?> <br>
			<div class="row">
				<div class="col-lg-6">จำนวน</div>
				<div class="col-lg-6">
					<div class="form-group">
						<input class="text-right form-control xCNNumberandPercent xCNFormSerach" type="text" style="width:100%" value="<?= $nQty ?>" data-seq="<?= $nItemSeq ?>" data-unitpri="<?= $nPdtUnitPri ?>" onkeypress="return FSxQUOEditItemQty(event,this)">
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
<?php }else { ?>
	<?php $nTotal = 0; ?>
	<div class="col-lg-12"><span class="xCNWaringEmptyPDT">[การแจ้งเตือน] ยังไม่มีรายการสินค้าในเอกสารนี้</span></div>
<?php } ?>


<?php if ($aQuoItemsList['nTotalRes'] > 0) { ?>
	<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">จำนวนเงินรวม</div>
	<div class="col-lg-5 col-md-5 col-md-5 col-xs-5 text-right"> &#3647; <?php echo number_format($nTotal, 2); ?></div>
<?php } ?>

<script src="<?= base_url('application/assets/js/jFormValidate.js')?>"></script>
