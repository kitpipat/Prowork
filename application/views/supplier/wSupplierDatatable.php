<table class="table table-striped xCNTableCenter">
  <thead>
    <tr>
		<th style="width:10px; text-align: center;">ลำดับ</th>
		<th style="width:80px; text-align: center;">รูปภาพ</th>
		<th style="text-align: left;">ชื่อผู้จำหน่าย</th>
		<th style="width:15%; text-align: left;">ชื่อผู้ติดต่อ</th>
		<th style="width:10%; text-align: left;">เบอร์โทรศัพท์</th>
		<th style="width:10%; text-align: left;">อีเมลล์</th>
		<th style="width:10%; text-align: left;">สถานะติดต่อ</th>
		<th style="width:80px; text-align: center;">แก้ไข</th>
		<th style="width:80px; text-align: center;">ลบ</th>
    </tr>
  </thead>
  <tbody>
		<?php if($aSUPList['rtCode'] != 800){ ?>
			<?php foreach($aSUPList['raItems'] AS $nKey => $aValue){ ?>
				<tr>
					<th><?=$aValue['rtRowID']?></th>
					<?php 
						if($aValue['FTSplPathImg'] != '' || $aValue['FTSplPathImg'] != null){
							$tPathImage = './application/assets/images/supplier/'.$aValue['FTSplPathImg'];
							if (file_exists($tPathImage)){
								$tPathImage = base_url().'application/assets/images/supplier/'.$aValue['FTSplPathImg'];
							}else{
								$tPathImage = base_url().'application/assets/images/supplier/NoImage.png';
							}
						}else{
							$tPathImage = './application/assets/images/supplier/NoImage.png';
						}
					?>
					<td class="xCNTdHaveImage"><img id="oimImgMastersupplier" class="img-responsive xCNImgCenter" src="<?=@$tPathImage;?>"></td>
					<td><?=$aValue['FTSplName']?></td>
					<td><?=($aValue['FTSplContact'] == '') ? '-' : $aValue['FTSplContact'] ?></td>
					<td><?=($aValue['FTSplTel']  == '') ? '-' : $aValue['FTSplTel'] ?></td>
					<td><?=($aValue['FTSplEmail']  == '') ? '-' : $aValue['FTSplEmail'] ?></td>
					
					<?php 
						if($aValue['FTSplStaActive'] == 1){
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
					<td><img class="img-responsive xCNImageEdit" src="<?=base_url().'application/assets/images/icon/edit.png';?>" onClick="JSwSupplierCallPageInsert('edit','<?=$aValue['FTSplCode']?>');"></td>
					<td><img class="img-responsive xCNImageDelete" src="<?=base_url().'application/assets/images/icon/delete.png';?>" onClick="JSxSupplier_Delete('<?=$aValue['FTSplCode']?>');"></td>
				</tr>
			<?php } ?>
		<?php }else{ ?>
			<tr><td colspan="99" style="text-align: center;"> - ไม่พบข้อมูล - </td></tr>
		<?php } ?>
  </tbody>
</table>

<div class="row">
    <div class="col-md-6">
        <label>พบข้อมูลทั้งหมด <?=$aSUPList['rnAllRow']?> รายการ แสดงหน้า <?=$aSUPList['rnCurrentPage']?> / <?=$aSUPList['rnAllPage']?></label>
    </div>
    <div class="col-md-6">
		<nav>
			<ul class="xCNPagenation pagination justify-content-end">
				<!--ปุ่มย้อนกลับ-->
				<?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
				<li class="page-item <?=$tDisabledLeft;?>">
					<a class="page-link" aria-label="Previous" onclick="JSvSupplier_ClickPage('previous')"><span aria-hidden="true">&laquo;</span></a>
				</li>

				<!--ปุ่มจำนวนหน้า-->
				<?php for($i=max($nPage-2, 1); $i<=max(0, min($aSUPList['rnAllPage'],$nPage+2)); $i++){?>
					<?php 
						if($nPage == $i){ 
							$tActive 		= 'active'; 
							$tDisPageNumber = 'disabled';
						}else{ 
							$tActive 		= '';
							$tDisPageNumber = '';
						}
					?>
					<li class="page-item <?=$tActive;?> " onclick="JSvSupplier_ClickPage('<?=$i?>')"><a class="page-link"><?=$i?></a></li>
				<?php } ?>

				<!--ปุ่มไปต่อ-->
				<?php if($nPage >= $aSUPList['rnAllPage']){ $tDisabledRight = 'disabled'; }else{ $tDisabledRight = '-'; } ?>
				<li class="page-item <?=$tDisabledRight?>">
					<a class="page-link" aria-label="Next" onclick="JSvSupplier_ClickPage('next')"><span aria-hidden="true">&raquo;</span></a>
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
	function JSvSupplier_ClickPage(ptPage) {
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
	function JSxSupplier_Delete(ptCode){
		$('#obtModalDelete').click();

		$('.xCNConfirmDelete').off();
		$('.xCNConfirmDelete').on("click",function(){
			$.ajax({
				type	: "POST",
				url		: 'r_suppliereventdelete',
				data 	: { 'ptCode' : ptCode },
				cache	: false,
				timeout	: 0,
				success	: function (tResult) {
					$('.xCNCloseDelete').click();
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('ลบข้อมูลสำเร็จ');
					JSxCallPageSupplierMain();
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
