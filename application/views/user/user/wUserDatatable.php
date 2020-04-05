<table class="table table-striped xCNTableCenter">
  <thead>
    <tr>
		<th style="width:10px; text-align: center;">ลำดับ</th>
		<th style="width:100px; text-align: center;">รูปภาพ</th>
		<th style="text-align: left;">ชื่อ-นามสกุล</th>
		<th style="width:10%; text-align: left;">แผนก</th>
		<th style="width:10%; text-align: left;">กลุ่มสิทธิ์</th>
		<th style="width:10%; text-align: left;">กลุ่มราคา</th>
		<th style="width:7%; text-align: left;">สถานะ</th>
		<th style="width:80px; text-align: center;">แก้ไข</th>
		<th style="width:80px; text-align: center;">ลบ</th>
    </tr>
  </thead>
  <tbody>
		<?php if($aUserList['rtCode'] != 800){ ?>
			<?php foreach($aUserList['raItems'] AS $nKey => $aValue){ ?>
				<tr>
					<th><?= $nKey + 1 ?></th>
					<?php 
						if($aValue['FTUsrImgPath'] != '' || $aValue['FTUsrImgPath'] != null){
							$tPathImage = './application/assets/images/user/'.$aValue['FTUsrImgPath'];
							if (file_exists($tPathImage)){
								$tPathImage = base_url().'application/assets/images/user/'.$aValue['FTUsrImgPath'];
							}else{
								$tPathImage = base_url().'application/assets/images/user/NoImage.png';
							}
						}else{
							$tPathImage = './application/assets/images/user/NoImage.png';
						}
					?>
					<td class="xCNTdHaveImage"><img id="oimImgMasteruser" class="img-responsive xCNImgCenter" src="<?=@$tPathImage;?>"></td>
					<td><?=$aValue['FTUsrFName']?> <?=$aValue['FTUsrLName']?></td>
					<td><?=$aValue['FTUsrDep']?></td>
					<td><?=$aValue['FTRhdName']?></td>
					<td><?=$aValue['FTPriGrpName']?></td>
					
					<?php 
						if($aValue['FNStaUse'] == 1){
							$tIconClassStatus 	= 'xCNIconStatus_open';
							$tTextClassStatus 	= 'xCNTextClassStatus_open';
							$tTextStatus 		= 'ใช้งาน';
						}else{
							$tIconClassStatus 	= 'xCNIconStatus_close';
							$tTextClassStatus 	= 'xCNTextClassStatus_close';
							$tTextStatus 		= 'ไม่ใช้งาน';
						}
					?>
					<td><div class="<?=$tIconClassStatus?>"></div><span class="<?=$tTextClassStatus?>"><?=$tTextStatus?></span></td>
					<td><img class="img-responsive xCNImageEdit" src="<?=base_url().'application/assets/images/icon/edit.png';?>"></td>
					<td><img class="img-responsive xCNImageDelete" src="<?=base_url().'application/assets/images/icon/delete.png';?>"></td>
				</tr>
			<?php } ?>
		<?php }else{ ?>
			<tr><td colspan="99" style="text-align: center;"> - ไม่พบข้อมูล - </td></tr>
		<?php } ?>
  </tbody>
</table>
