<?php if ($nTotalRecord > 0) { ?>
	<?php if ($tPdtViewType == 1) { ?>
			<?php
			for ($p = 0; $p < $nTotalRecord; $p++) {

				$tPdtCode = $aPdtList['raItems'][$p]['FTPdtCode'];
				$tPdtName = $aPdtList['raItems'][$p]['FTPdtName'];
				$tPunCode = $aPdtList['raItems'][$p]['FTPunCode'];
				$tSplCode = $aPdtList['raItems'][$p]['FTSplCode'];
				$nPdtCost = $aPdtList['raItems'][$p]['FCPdtCostAFDis'];
				$nPdtUnitPri = $aPdtList['raItems'][$p]['FCPdtNetSalPri'];
				$tPunName = $aPdtList['raItems'][$p]['FTPunName'];


				$aItemsInfo = array(
					"tPdtCode" => $tPdtCode,
					"tPdtName" => $tPdtName,
					"tPunCode" => $tPunCode,
					"tPunName" => $tPunName,
					"tSplCode" => $tSplCode,
					"nPdtCost" => $nPdtCost,
					"nPdtUnitPri" => $nPdtUnitPri
				);

				$tItemInfo = json_encode($aItemsInfo);

			?>
			<div class="col-sm-3 col-md-3 col-lg-3">
				<div class="thumbnail" data-iteminfo='<?= $tItemInfo ?>' onclick="FSvQUOAddItemToTemp(this)">
					<img src="<?= base_url('application/assets/images/products/NoImage.png') ?>" alt="...">
					<div class="caption">
						<h4><?php echo $tPdtName; ?></h4>
						<span>&#3647;<?php echo number_format($nPdtUnitPri, 2); ?></span>
					</div>
				</div>
			</div>
			<?php } ?>
		<?php } else { ?>
			<table class="table table-striped xCNTableCenter">
				<thead>
					<tr>
						<th style="width:20px;">ลำดับ</th>
						<th style="width:100px;">รหัสสินค้า</th>
						<th >ชื่อสินค้า</th>
						<th style="width:250px; text-align: right;">ราคา/หน่วย</th>
						<th style="width:100px; text-align: center;">เลือก</th>
					</tr>
				</thead>
				<tbody>
					<?php for($p2 = 0; $p2 < $nTotalRecord; $p2++) {
								$tPdtCode 		= $aPdtList['raItems'][$p2]['FTPdtCode'];
								$tPdtName 		= $aPdtList['raItems'][$p2]['FTPdtName'];
								$tPunCode 		= $aPdtList['raItems'][$p2]['FTPunCode'];
								$tSplCode 		= $aPdtList['raItems'][$p2]['FTSplCode'];
								$nPdtCost 		= $aPdtList['raItems'][$p2]['FCPdtCostAFDis'];
								$nPdtUnitPri 	= $aPdtList['raItems'][$p2]['FCPdtNetSalPri'];
								$tPunName 		= $aPdtList['raItems'][$p2]['FTPunName'];
								$aItemsInfo = array(
									"tPdtCode" 		=> $tPdtCode,
									"tPdtName" 		=> $tPdtName,
									"tPunCode" 		=> $tPunCode,
									"tPunName" 		=> $tPunName,
									"tSplCode" 		=> $tSplCode,
									"nPdtCost" 		=> $nPdtCost,
									"nPdtUnitPri" => $nPdtUnitPri
								);
							$tItemInfo = json_encode($aItemsInfo); ?>
						<tr>
							<td >ลำดับ</td>
							<td ><?=$tPdtCode;?></td>
							<td style="text-align: left;"><?=$tPdtName;?></td>
							<td style="text-align: right;"><?=number_format($nPdtUnitPri,2);?></td>
							<td><button class="sm-button xCNSelectPDTInPI" data-iteminfo='<?= $tItemInfo ?>' onclick="FSvQUOAddItemToTemp(this)">เลือกสินค้า</button></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
	<?php } ?>
<?php } else { ?>
	<?php if ($tPdtViewType == 1) { ?>
		<div class="col-lg-12">
			<lable style="color:red">[การแจ้งเตือน]</label> ไม่พบสินค้าในระบบ.
		</div>
	<?php }else{ ?>
		<table class="table table-striped xCNTableCenter">
				<thead>
					<tr>
						<th style="width:100px;">ชื่อ</th>
						<th style="text-align: left;">ราคา/หน่วย</th>
						<th style="width:100px;">เลือก</th>
					</tr>
				</thead>
				<tbody>
					<tr><td colspan="99" style="text-align: center;"> - ไม่พบข้อมูล - </td></tr>
				</tbody>
		</table>
	<?php } ?>
<?php } ?>

<style media="screen">
	.thumbnail:hover {
		padding: 2px;
		border: 1px solid green !important;
		border-radius: 5px !important;
		cursor: pointer !important;
	}
</style>
