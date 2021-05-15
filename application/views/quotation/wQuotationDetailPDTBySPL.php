<table class="table table-striped xCNTableCenter">
  <thead>
    <tr>
		<th style="width:20px; text-align: left;">เลือก</th>
		<th style="width:300px; text-align: left;">รหัสสินค้า - ชื่อสินค้า</th>
		<th style="width:150px; text-align: right;">จำนวน</th>
		<th style="width:150px; text-align: left;">หน่วย</th>
		<th style="width:120px; text-align: right;">ราคา</th>
		<th style="width:80px; text-align: center;">ลบ</th>
    </tr>
  </thead>
  <tbody>
		<?php if($aItem['rtCode'] != 800){ ?>
			<?php $nSPL = ''; ?>
			<?php foreach($aItem['raItems'] AS $nKey => $aValue){ ?>
				<?php if($nSPL != $aValue['FTSplCode']){ ?>
				<?php } ?>
				<tr><?=$aValue['FTSplName']?></tr>
				<tr>
					<td class="text-center">
						<label class="container-checkbox" style="display: block; margin: 0px auto;">
							<input type="checkbox" name="ocmDTInCreatePOSeleted" onclick="JSxDTInCreatePOSeleted(this)" checked>
							<span class="checkmark"></span>
						</label>
					</td>
					<td><?=$aValue['FTPdtCode']?> - <?=$aValue['FTPdtName']?></td>
					<td class="text-right"><?=number_format($aValue['FCXqdQty'])?></td>
					<td><?=$aValue['FTPunName']?></td>
					<td class="text-right"><?=number_format($aValue['FCXqdNetAfHD'],2)?></td>
					<td><img class="img-responsive xCNImageDelete" src="<?=base_url().'application/assets/images/icon/delete.png';?>" onClick=""></td>
				</tr>
			<?php } ?>
		<?php }else{ ?>
			<tr><td colspan="99" style="text-align: center;"> - ไม่พบข้อมูล - </td></tr>
		<?php } ?>
  </tbody>
</table>
