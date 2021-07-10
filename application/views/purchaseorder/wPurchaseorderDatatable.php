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

<table class="table table-striped xCNTableCenter">
  <thead>
    <tr>
		<th style="width:10px; text-align: center;">ลำดับ</th>
		<th style="width:230px; text-align: left;">สาขา</th>
		<th style="width:210px; text-align: left;">เลขที่เอกสาร</th>
		<th style="width:350px; text-align: left;">ผู้จำหน่าย</th>
		<th style="width:150px; text-align: left;">วันที่</th>
		<th style="width:130px; text-align: left;">สถานะเอกสาร</th>
		<th style="width:120px; text-align: left;">ผู้อนุมัติ</th>
		<th style="width:70px; text-align: center;">แก้ไข</th>
		<th style="width:70px; text-align: center;" class='<?=$tPer_delete?>'>ลบ</th>
    </tr>
  </thead>
  <tbody>
		<?php if($aList['rtCode'] != 800){ ?>
			<?php foreach($aList['raItems'] AS $nKey => $aValue){ ?>
				<tr>
					<th><?=$aValue['rtRowID']?></th>
					<td><?=$aValue['FTBchName']?></td>
					<td><?=$aValue['FTXpoDocNo']?></td>
					<td><?=$aValue['FTXpoSplName']?></td>
					<td><?=date('d/m/Y H:i:s',strtotime($aValue['FDXpoDocDate']))?></td>

					<!--สถานะเอกสาร-->
					<?php 
						if($aValue['FTXpoStaDoc'] != 1){
							$tTextStaDoc 			= "ยกเลิก";
							$tClassStaDoc 			= 'xCNTextClassStatus_close';
						}else{
							if($aValue['FTXpoStaApv'] == 1){
								$tTextStaDoc 			= "อนุมัติแล้ว";
								$tClassStaDoc 			= 'xCNTextClassStatus_open';
								$tIconClassStaApv 		= 'xCNIconStatus_open';
							}else{
								if($aValue['FTXpoStaDoc'] == 2){
									$tTextStaDoc 			= "-";
									$tClassStaDoc 			= '';
									$tIconClassStaApv 		= '';
								}else{
									$tTextStaDoc 			= "รออนุมัติ";
									$tClassStaDoc 			= 'xCNTextClassStatus_wait';
									$tIconClassStaApv 		= 'xCNIconStatus_close';
								}
							}
						}
					?>
					<td><span class="<?=$tClassStaDoc?>"><?=$tTextStaDoc?></span></td>

					<td class="text-nowrap"><?=($aValue['FTUsrFName'] == '') ? '-' : $aValue['FTUsrFName'];?></td>

					<!--ถ้าอนุมัติแล้วจะลบไม่ได้-->
					<?php 
						if($aValue['FTXpoStaApv'] != 1 ){
							if($aValue['FTXpoStaDoc'] == 2){
								$oEventDelete 			= '';
								$tClassDisabledDelete 	= 'xCNImageDeleteDisabled';
							}else{
								$oEventDelete 			= "JSxPO_Delete('".$aValue['FTXpoDocNo']."')";
								$tClassDisabledDelete 	= '';
							}
						}else{
							$oEventDelete 			= '';
							$tClassDisabledDelete 	= 'xCNImageDeleteDisabled';
						}
					 ?>
					<td><img class="img-responsive xCNImageEdit" src="<?=base_url().'application/assets/images/icon/edit.png';?>" onClick="JSwPOCallPageInsert('edit','<?=$aValue['FTXpoDocNo']?>');"></td>
					<td class='<?=$tPer_delete?>'><img class="img-responsive xCNImageDelete <?=$tClassDisabledDelete;?>" src="<?=base_url().'application/assets/images/icon/delete.png';?>" onClick="<?=$oEventDelete?>"></td>
				</tr>
			<?php } ?>
		<?php }else{ ?>
			<tr><td colspan="99" style="text-align: center;"> - ไม่พบข้อมูล - </td></tr>
		<?php } ?>
  </tbody>
</table>

<div class="row">
    <div class="col-md-6">
        <label>พบข้อมูลทั้งหมด <?=$aList['rnAllRow']?> รายการ แสดงหน้า <?=$aList['rnCurrentPage']?> / <?=$aList['rnAllPage']?></label>
    </div>
    <div class="col-md-6">
		<nav>
			<ul class="xCNPagenation pagination justify-content-end">

				<!--ปุ่มย้อนกลับ-->
				<?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
				<li class="page-item <?=$tDisabledLeft;?>">
					<a class="page-link" aria-label="Previous" onclick="JSvPO_ClickPage('Fisrt')"><span aria-hidden="true">&laquo;</span></a>
				</li>

				<li class="page-item <?=$tDisabledLeft;?>">
					<a class="page-link" aria-label="Previous" onclick="JSvPO_ClickPage('previous')"><span aria-hidden="true">&lsaquo;</span></a>
				</li>

				<!--ปุ่มจำนวนหน้า-->
				<?php for($i=max($nPage-2, 1); $i<=max(0, min($aList['rnAllPage'],$nPage+2)); $i++){?>
					<?php 
						if($nPage == $i){ 
							$tActive 		= 'active'; 
							$tDisPageNumber = 'disabled';
						}else{ 
							$tActive 		= '';
							$tDisPageNumber = '';
						}
					?>
					<li class="page-item <?=$tActive;?> " onclick="JSvPO_ClickPage('<?=$i?>')"><a class="page-link"><?=$i?></a></li>
				<?php } ?>

				<!--ปุ่มไปต่อ-->
				<?php if($nPage >= $aList['rnAllPage']){ $tDisabledRight = 'disabled'; }else{ $tDisabledRight = '-'; } ?>
				<li class="page-item <?=$tDisabledRight?>">
					<a class="page-link" aria-label="Next" onclick="JSvPO_ClickPage('next')"><span aria-hidden="true">&rsaquo;</span></a>
				</li>

				<li class="page-item <?=$tDisabledRight?>">
					<a class="page-link" aria-label="Next" onclick="JSvPO_ClickPage('Last')"><span aria-hidden="true">&raquo;</span></a>
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
	function JSvPO_ClickPage(ptPage) {
		var nPageCurrent = '';
		switch (ptPage) {
			case 'Fisrt': //กดหน้าแรก
				nPageCurrent 	= 1;
			break;
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
			case 'Last': //กดหน้าสุดท้าย
				nPageCurrent 	= '<?=$aList['rnAllPage']?>';
			break;
			default:
				nPageCurrent = ptPage
		}

		JSwLoadTableList(nPageCurrent);
	}

	//ลบข้อมูล
	function JSxPO_Delete(ptCode){
		$('#obtModalDelete').click();

		$('.xCNConfirmDelete').off();
		$('.xCNConfirmDelete').on("click",function(){
			$.ajax({
				type	: "POST",
				url		: 'r_purchaseordereventdelete',
				data 	: { 'ptCode' : ptCode },
				cache	: false,
				timeout	: 0,
				success	: function (tResult) {
					$('.xCNCloseDelete').click();
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('ลบข้อมูลสำเร็จ');

					setTimeout(function(){
						JSxCallPagePOMain();
					}, 500);

					setTimeout(function(){
						$('.alert-success').find('.close').click();
					}, 3000);
				},
				error: function (jqXHR, textStatus, errorThrown) {
					JSxModalErrorCenter(jqXHR.responseText);
				}
			});
		});
	}

</script>
