<table class="table table-striped xCNTableCenter">
  <thead>
    <tr>
		<th style="width:10px; text-align: center;">ลำดับ</th>
		<th style="width:150px; text-align: center;">รูปภาพ</th>
		<th style="width:100px; text-align: left;">รหัสสินค้า</th>
		<th style="text-align: left;">ชื่อสินค้า</th>
		<th style="width:100px; text-align: left;">หน่วย</th>
		<th style="width:120px; text-align: left;">กลุ่มสินค้า</th>
		<th style="width:120px; text-align: left;">สี</th>
		<th style="width:120px; text-align: left;">รุ่น</th>
		<th style="width:120px; text-align: left;">ยี่ห้อ</th>
		<th style="width:120px; text-align: left;">ผู้จำหน่าย</th>
		<th style="width:100px; text-align: left;">สถานะ</th>
		<th style="width:80px; text-align: center;">แก้ไข</th>
		<th style="width:80px; text-align: center;">ลบ</th>
    </tr>
  </thead>
  <tbody>
		<?php if($aList['rtCode'] != 800){ ?>
			<?php foreach($aList['raItems'] AS $nKey => $aValue){ ?>
				<tr>
					<th><?=$aValue['rtRowID']?></th>
					<?php 
						if($aValue['FTPdtImage'] != '' || $aValue['FTPdtImage'] != null){
							$tPathImage = './application/assets/images/products/'.$aValue['FTPdtImage'];
							if (file_exists($tPathImage)){
								$tPathImage = base_url().'application/assets/images/products/'.$aValue['FTPdtImage'];
							}else{
								$tPathImage = base_url().'application/assets/images/products/NoImage.png';
							}
						}else{
							$tPathImage = './application/assets/images/products/NoImage.png';
						}
					?>
					<td class="xCNTdHaveImage"><img id="oimImgInsertorEditProduct" class="img-responsive xCNImgCenter" src="<?=@$tPathImage;?>"></td>
					<td><label class="xCNLineHeightInTable"><?=($aValue['FTPdtCode'] == '') ? '-' : $aValue['FTPdtCode'];?></label></td>
					<td><label class="xCNLineHeightInTable"><?=($aValue['FTPdtName'] == '') ? '-' : $aValue['FTPdtName'];?></label></td>
					<td><label class="xCNLineHeightInTable"><?=($aValue['FTPunName'] == '') ? '-' : $aValue['FTPunName'];?></label></td>
					<td><label class="xCNLineHeightInTable"><?=($aValue['FTPgpName'] == '') ? '-' : $aValue['FTPgpName'];?></label></td>
					<td><label class="xCNLineHeightInTable"><?=($aValue['FTPClrName'] == '') ? '-' : $aValue['FTPClrName'];?></label></td>
					<td><label class="xCNLineHeightInTable"><?=($aValue['FTMolName'] == '') ? '-' : $aValue['FTMolName'];?></label></td>
					<td><label class="xCNLineHeightInTable"><?=($aValue['FTPbnName'] == '') ? '-' : $aValue['FTPbnName'];?></label></td>
					<td><label class="xCNLineHeightInTable"><?=($aValue['FTSplName'] == '') ? '-' : $aValue['FTSplName'];?></label></td>
					<?php 
						if($aValue['FTPdtStatus'] == 1){
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
					<td><img class="img-responsive xCNImageEdit" src="<?=base_url().'application/assets/images/icon/edit.png';?>" onClick="JSwProductCallPageInsert('edit','<?=$aValue['FTPdtCode']?>');"></td>
					<td><img class="img-responsive xCNImageDelete" src="<?=base_url().'application/assets/images/icon/delete.png';?>" onClick="JSxProduct_Delete('<?=$aValue['FTPdtCode']?>');"></td>
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
					<a class="page-link" aria-label="Previous" onclick="JSvProduct_ClickPage('previous')"><span aria-hidden="true">&laquo;</span></a>
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
					<li class="page-item <?=$tActive;?> " onclick="JSvProduct_ClickPage('<?=$i?>')"><a class="page-link"><?=$i?></a></li>
				<?php } ?>

				<!--ปุ่มไปต่อ-->
				<?php if($nPage >= $aList['rnAllPage']){ $tDisabledRight = 'disabled'; }else{ $tDisabledRight = '-'; } ?>
				<li class="page-item <?=$tDisabledRight?>">
					<a class="page-link" aria-label="Next" onclick="JSvProduct_ClickPage('next')"><span aria-hidden="true">&raquo;</span></a>
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
	function JSvProduct_ClickPage(ptPage) {
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
	function JSxProduct_Delete(ptCode){
		$('#obtModalDelete').click();

		$('.xCNConfirmDelete').off();
		$('.xCNConfirmDelete').on("click",function(){
			$.ajax({
				type	: "POST",
				url		: 'r_producteventdelete',
				data 	: { 'ptCode' : ptCode },
				cache	: false,
				timeout	: 0,
				success	: function (tResult) {
					$('.xCNCloseDelete').click();
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('ลบข้อมูลสำเร็จ');
					JSxCallPageProductMain();
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
