<?php
	$aPermission = FCNaPERGetPermissionByPage('r_user');
	$aPermission = $aPermission[0];
	if($aPermission['P_read'] != 1){ 		$tPer_read 		= 'xCNHide'; }else{ $tPer_read = ''; }
	if($aPermission['P_create'] != 1){ 		$tPer_create 	= 'xCNHide'; }else{ $tPer_create = ''; }
	if($aPermission['P_delete'] != 1){ 		$tPer_delete 	= 'xCNHide'; }else{ $tPer_delete = ''; }
	if($aPermission['P_edit'] != 1){ 		$tPer_edit 		= 'xCNHide'; }else{ $tPer_edit = ''; }
	if($aPermission['P_cancel'] != 1){ 		$tPer_cancle 	= 'xCNHide'; }else{ $tPer_cancle = ''; }
	if($aPermission['P_approved'] != 1){ 	$tPer_approved 	= 'xCNHide'; }else{ $tPer_approved = ''; }
	if($aPermission['P_print'] != 1){ 		$tPer_print 	= 'xCNHide'; }else{ $tPer_print = ''; }
?> 

<table class="table table-striped xCNTableCenter">
  <thead>
    <tr>
		<th style="width:10px; text-align: center;">ลำดับ</th>
		<th style="width:100px; text-align: center;">รูปภาพ</th>
		<th style="text-align: left;">ชื่อ-นามสกุล</th>
		<th style="width:10%; text-align: left;">แผนก</th>
		<th style="width:10%; text-align: left;">กลุ่มผู้ใช้</th>
		<th style="width:10%; text-align: left;">กลุ่มสิทธิ์</th>
		<th style="width:10%; text-align: left;">กลุ่มราคา</th>
		<th style="width:10%; text-align: left;">สถานะ</th>
		<th style="width:80px; text-align: center;">แก้ไข</th>
		<th style="width:80px; text-align: center;" class='<?=$tPer_delete?>'>ลบ</th>
    </tr>
  </thead>
  <tbody>
		<?php if($aUserList['rtCode'] != 800){ ?>
			<?php foreach($aUserList['raItems'] AS $nKey => $aValue){ ?>
				<tr>
					<th><?=$aValue['rtRowID']?></th>
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
					<td><?=($aValue['FTUsrDep'] == '') ? '-' : $aValue['FTUsrDep']?></td>

					<?php 
						switch($aValue['FNUsrGrp']){
							case 1:
								$tNameUserGroup = 'พนักงานจัดซื้อ';
								break;
							case 2:
								$tNameUserGroup = 'พนักงานขาย';
								break;
							case 3:
								$tNameUserGroup = 'ผู้จัดการ';
								break;
							case 4:
								$tNameUserGroup = 'เจ้าของกิจการ';
								break;
							default:
								$tNameUserGroup = 'N/A';
						}
					?>
					<td><?=$tNameUserGroup;?></td>
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
					<td><img class="img-responsive xCNImageEdit" src="<?=base_url().'application/assets/images/icon/edit.png';?>" onClick="JSwUserCallPageInsert('edit','<?=$aValue['FTUsrCode']?>');"></td>
					<td class='<?=$tPer_delete?>'><img class="img-responsive xCNImageDelete" src="<?=base_url().'application/assets/images/icon/delete.png';?>" onClick="JSxUser_Delete('<?=$aValue['FTUsrCode']?>');"></td>
				</tr>
			<?php } ?>
		<?php }else{ ?>
			<tr><td colspan="99" style="text-align: center;"> - ไม่พบข้อมูล - </td></tr>
		<?php } ?>
  </tbody>
</table>

<div class="row">
    <div class="col-md-6">
        <label>พบข้อมูลทั้งหมด <?=$aUserList['rnAllRow']?> รายการ แสดงหน้า <?=$aUserList['rnCurrentPage']?> / <?=$aUserList['rnAllPage']?></label>
    </div>
    <div class="col-md-6">
		<nav>
			<ul class="xCNPagenation pagination justify-content-end">
				<!--ปุ่มย้อนกลับ-->
				<?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
				<li class="page-item <?=$tDisabledLeft;?>">
					<a class="page-link" aria-label="Previous" onclick="JSvUser_ClickPage('previous')"><span aria-hidden="true">&laquo;</span></a>
				</li>

				<!--ปุ่มจำนวนหน้า-->
				<?php for($i=max($nPage-2, 1); $i<=max(0, min($aUserList['rnAllPage'],$nPage+2)); $i++){?>
					<?php 
						if($nPage == $i){ 
							$tActive 		= 'active'; 
							$tDisPageNumber = 'disabled';
						}else{ 
							$tActive 		= '';
							$tDisPageNumber = '';
						}
					?>
					<li class="page-item <?=$tActive;?> " onclick="JSvUser_ClickPage('<?=$i?>')"><a class="page-link"><?=$i?></a></li>
				<?php } ?>

				<!--ปุ่มไปต่อ-->
				<?php if($nPage >= $aUserList['rnAllPage']){ $tDisabledRight = 'disabled'; }else{ $tDisabledRight = '-'; } ?>
				<li class="page-item <?=$tDisabledRight?>">
					<a class="page-link" aria-label="Next" onclick="JSvUser_ClickPage('next')"><span aria-hidden="true">&raquo;</span></a>
				</li>
			</ul>
		</nav>
    </div>
</div>


<!-- Modal Delete -->
<button id="obtModalDelete" style="display:none;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#odvModalDelete"></button>
<div class="modal fade" id="odvModalDelete" tabindex="-1" role="dialog" aria-hidden="true">
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
        <button type="button" class="btn btn-danger xCNConfirmDelete">ยืนยัน</button>
      </div>
    </div>
  </div>
</div>

<script>
	//เปลี่ยนหน้า
	function JSvUser_ClickPage(ptPage) {
		var nPageCurrent = '';
		switch (ptPage) {
			case 'next': //กดปุ่ม Next
				nPageOld 		= $('.xCNPagenation .active').text(); 
				nPageNew 		= parseInt(nPageOld, 10) + 1; 
				nPageCurrent 	= nPageNew
			break;
			case 'previous': //กดปุ่ม Previous
				nPageOld 		= $('.xCNPagenation .active').text(); 
				nPageNew 		= parseInt(nPageOld, 10) - 1; 
				nPageCurrent 	= nPageNew
			break;
			default:
				nPageCurrent = ptPage
		}

		JSwLoadTableList(nPageCurrent);
	}

	//ลบข้อมูล
	function JSxUser_Delete(ptCode){
		$('#obtModalDelete').click();

		$('.xCNConfirmDelete').off();
		$('.xCNConfirmDelete').on("click",function(){
			$.ajax({
				type	: "POST",
				url		: 'r_usereventdelete',
				data 	: { 'ptCode' : ptCode },
				cache	: false,
				timeout	: 0,
				success	: function (tResult) {
					$('.xCNCloseDelete').click();
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('ลบข้อมูลสำเร็จ');

					setTimeout(function(){
						JSxCallPageUserMain();
					}, 500);

					setTimeout(function(){
						$('.alert-success').find('.close').click();
					}, 3000);
				},
				error: function (jqXHR, textStatus, errorThrown) {
					alert(jqXHR, textStatus, errorThrown);
				}
			});
		});
	}

</script>
