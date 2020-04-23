<table class="table table-striped xCNTableCenter">
  <thead>
    <tr>
		<th style="width:10px; text-align: center;">ลำดับ</th>
		<th style="width:150px; text-align: left;">เลขที่เอกสาร</th>
		<th style="width:200px; text-align: left;">วันที่-เวลาเอกสาร</th>
		<th style="text-align: left;">วันที่มีผล</th>
		<th style="width:150px; text-align: left;">สถานะเอกสาร</th>
		<th style="width:150px; text-align: left;">สถานะอนุมัติ</th>
		<th style="width:150px; text-align: left;">ผู้อนุมัติ</th>
		<th style="width:80px; text-align: center;">แก้ไข</th>
		<th style="width:80px; text-align: center;">ลบ</th>
    </tr>
  </thead>
  <tbody>
		<?php if($aList['rtCode'] != 800){ ?>
			<?php foreach($aList['raItems'] AS $nKey => $aValue){ ?>
				<tr>
					<th><?=$aValue['rtRowID']?></th>
					<td><?=$aValue['FTXphDocNo']?></td>
					<td><?=date('d/m/Y',strtotime($aValue['FDXphDocDate'])) . ' - ' . $aValue['FTXphDocTime'];?></td>
					<td><?=date('d/m/Y',strtotime($aValue['FDXphDStart']))?></td>

					<!--สถานะเอกสาร-->
					<?php 
						if($aValue['FTXphStaDoc'] == 1){
							$tTextStaDoc 			= "สมบูรณ์";
							$tClassStaDoc 			= 'xCNTextClassStatus_open';
						}else{
							$tTextStaDoc 			= "เอกสารยกเลิก";
							$tClassStaDoc 			= 'xCNTextClassStatus_close';
						}
					?>
					<td><span class="<?=$tClassStaDoc?>"><?=$tTextStaDoc?></span></td>

					<!--สถานะอนุมัติ-->
					<?php 
						if($aValue['FTXphStaApv'] == 1){
							$tTextStaApv 			= "อนุมัติแล้ว";
							$tClassStaApv 			= 'xCNTextClassStatus_open';
							$tIconClassStaApv 		= 'xCNIconStatus_open';
						}else{
							if($aValue['FTXphStaDoc'] == 2){
								$tTextStaApv 			= "-";
								$tClassStaApv 			= '';
								$tIconClassStaApv 		= '';
							}else{
								$tTextStaApv 			= "รออนุมัติ";
								$tClassStaApv 			= 'xCNTextClassStatus_close';
								$tIconClassStaApv 		= 'xCNIconStatus_close';
							}
						}
					?>
					<td><div class="<?=$tIconClassStaApv?>"></div><span class="<?=$tClassStaApv?>"><?=$tTextStaApv?></span></td>
					<td><?=($aValue['FTUsrFName'] == '') ? '-' : $aValue['FTUsrFName'];?></td>

					<!--ถ้าอนุมัติแล้วจะลบไม่ได้-->
					<?php 
						if($aValue['FTXphStaApv'] != 1 ){
							if($aValue['FTXphStaDoc'] == 2){
								$oEventDelete 			= '';
								$tClassDisabledDelete 	= 'xCNImageDeleteDisabled';
							}else{
								$oEventDelete 			= "JSxAJC_Delete('".$aValue['FTXphDocNo']."')";
								$tClassDisabledDelete 	= '';
							}
						}else{
							$oEventDelete 			= '';
							$tClassDisabledDelete 	= 'xCNImageDeleteDisabled';
						}
					 ?>
					<td><img class="img-responsive xCNImageEdit" src="<?=base_url().'application/assets/images/icon/edit.png';?>" onClick="JSwAJCCallPageInsert('edit','<?=$aValue['FTXphDocNo']?>');"></td>
					<td><img class="img-responsive xCNImageDelete <?=$tClassDisabledDelete;?>" src="<?=base_url().'application/assets/images/icon/delete.png';?>" onClick="<?=$oEventDelete?>"></td>
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
					<a class="page-link" aria-label="Previous" onclick="JSvAJC_ClickPage('previous')"><span aria-hidden="true">&laquo;</span></a>
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
					<li class="page-item <?=$tActive;?> " onclick="JSvAJC_ClickPage('<?=$i?>')"><a class="page-link"><?=$i?></a></li>
				<?php } ?>

				<!--ปุ่มไปต่อ-->
				<?php if($nPage >= $aList['rnAllPage']){ $tDisabledRight = 'disabled'; }else{ $tDisabledRight = '-'; } ?>
				<li class="page-item <?=$tDisabledRight?>">
					<a class="page-link" aria-label="Next" onclick="JSvAJC_ClickPage('next')"><span aria-hidden="true">&raquo;</span></a>
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
	function JSvAJC_ClickPage(ptPage) {
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
	function JSxAJC_Delete(ptCode){
		$('#obtModalDelete').click();

		$('.xCNConfirmDelete').off();
		$('.xCNConfirmDelete').on("click",function(){
			$.ajax({
				type	: "POST",
				url		: 'r_adjcosteventdelete',
				data 	: { 'ptCode' : ptCode },
				cache	: false,
				timeout	: 0,
				success	: function (tResult) {
					$('.xCNCloseDelete').click();
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('ลบข้อมูลสำเร็จ');

					setTimeout(function(){
						JSxCallPageAJCMain();
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
