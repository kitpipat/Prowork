<?php $tLevelUser = $this->session->userdata('tSesUserLevel'); ?>

<table class="table table-striped xCNTableCenter">
  <thead>
    <tr>
		<th style="width:10px; text-align: center;">ลำดับ</th>
		<th style="width:100px; text-align: center;">รูปภาพ</th>
		<?php if($tLevelUser == 'HQ'){ ?><th style="width:300px; text-align: left;">สาขา</th><?php } ?>
		<th style="text-align: left;">ชื่อลูกค้า / บริษัท</th>
		<th style="width:15%; text-align: left;">ชื่อผู้ติดต่อ</th>
		<th style="width:10%; text-align: left;">เบอร์โทรศัพท์</th>
		<th style="width:10%; text-align: left;">สถานะ</th>
		<th style="width:80px; text-align: center;">แก้ไข</th>
		<th style="width:80px; text-align: center;">ลบ</th>
    </tr>
  </thead>
  <tbody>
		<?php if($aCustomerList['rtCode'] != 800){ ?>
			<?php foreach($aCustomerList['raItems'] AS $nKey => $aValue){ ?>
				<tr>
					<th><?=$aValue['rtRowID']?></th>
					<?php 
						if($aValue['FTCstPathImg'] != '' || $aValue['FTCstPathImg'] != null){
							$tPathImage = './application/assets/images/customer/'.$aValue['FTCstPathImg'];
							if (file_exists($tPathImage)){
								$tPathImage = base_url().'application/assets/images/customer/'.$aValue['FTCstPathImg'];
							}else{
								$tPathImage = base_url().'application/assets/images/customer/NoImage.png';
							}
						}else{
							$tPathImage = './application/assets/images/customer/NoImage.png';
						}
					?>
					<td class="xCNTdHaveImage"><img id="oimImgMastercustomer" class="img-responsive xCNImgCenter" src="<?=@$tPathImage;?>"></td>
					<?php if($tLevelUser == 'HQ'){ ?><td><?=($aValue['FTBchName'] == '') ? 'สำนักงานใหญ่' : $aValue['FTBchName']?></td><?php } ?>
					<td><?=($aValue['FTCstName'] == '') ? '-' : $aValue['FTCstName']?></td>
					<td><?=($aValue['FTCstContactName'] == '') ? '-' : $aValue['FTCstContactName']?></td>
					<td><?=($aValue['FTCstTel'] == '') ? '-' : $aValue['FTCstTel']?></td>
					
					<?php 
						if($aValue['FTCstStaActive'] == 1){
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
					<td><img class="img-responsive xCNImageEdit" src="<?=base_url().'application/assets/images/icon/edit.png';?>" onClick="JSwCustomerCallPageInsert('edit','<?=$aValue['FTCstCode']?>');"></td>
					<td><img class="img-responsive xCNImageDelete" src="<?=base_url().'application/assets/images/icon/delete.png';?>" onClick="JSxCustomer_Delete('<?=$aValue['FTCstCode']?>');"></td>
				</tr>
			<?php } ?>
		<?php }else{ ?>
			<tr><td colspan="99" style="text-align: center;"> - ไม่พบข้อมูล - </td></tr>
		<?php } ?>
  </tbody>
</table>

<div class="row">
    <div class="col-md-6">
        <label>พบข้อมูลทั้งหมด <?=$aCustomerList['rnAllRow']?> รายการ แสดงหน้า <?=$aCustomerList['rnCurrentPage']?> / <?=$aCustomerList['rnAllPage']?></label>
    </div>
    <div class="col-md-6">
		<nav>
			<ul class="xCNPagenation pagination justify-content-end">
				<!--ปุ่มย้อนกลับ-->
				<?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
				<li class="page-item <?=$tDisabledLeft;?>">
					<a class="page-link" aria-label="Previous" onclick="JSvCustomer_ClickPage('previous')"><span aria-hidden="true">&laquo;</span></a>
				</li>

				<!--ปุ่มจำนวนหน้า-->
				<?php for($i=max($nPage-2, 1); $i<=max(0, min($aCustomerList['rnAllPage'],$nPage+2)); $i++){?>
					<?php 
						if($nPage == $i){ 
							$tActive 		= 'active'; 
							$tDisPageNumber = 'disabled';
						}else{ 
							$tActive 		= '';
							$tDisPageNumber = '';
						}
					?>
					<li class="page-item <?=$tActive;?> " onclick="JSvCustomer_ClickPage('<?=$i?>')"><a class="page-link"><?=$i?></a></li>
				<?php } ?>

				<!--ปุ่มไปต่อ-->
				<?php if($nPage >= $aCustomerList['rnAllPage']){ $tDisabledRight = 'disabled'; }else{ $tDisabledRight = '-'; } ?>
				<li class="page-item <?=$tDisabledRight?>">
					<a class="page-link" aria-label="Next" onclick="JSvCustomer_ClickPage('next')"><span aria-hidden="true">&raquo;</span></a>
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
	function JSvCustomer_ClickPage(ptPage) {
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
	function JSxCustomer_Delete(ptCode){
		$('#obtModalDelete').click();

		$('.xCNConfirmDelete').off();
		$('.xCNConfirmDelete').on("click",function(){
			$.ajax({
				type	: "POST",
				url		: 'r_customereventdelete',
				data 	: { 'ptCode' : ptCode },
				cache	: false,
				timeout	: 0,
				success	: function (tResult) {
					$('.xCNCloseDelete').click();
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('ลบข้อมูลสำเร็จ');
					JSxCallPageCustomerMain();
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
