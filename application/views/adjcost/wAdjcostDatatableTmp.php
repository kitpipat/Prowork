
<table class="table table-striped xCNTableCenter" id="otbAJCTable">
  <thead>
    <tr>
		<th style="width:20px; text-align: center;">ลำดับ</th>
		<th style="width:200px; text-align: left;">รหัสสินค้า</th>
		<th style="text-align: left;">ชื่อสินค้า</th>
		<th style="width:230px; text-align: left;">ส่วนลดต้นทุน</th>
		<?php if($tControlWhenAprOrCan != 'disabled'){ ?>
			<th style="width:80px; text-align: center;">ลบ</th>
		<?php } ?>
    </tr>
  </thead>
  <tbody>
		<?php if($aListTmp['rtCode'] != 800){ ?>
			<?php foreach($aListTmp['raItems'] AS $nKey => $aValue){ ?>
				<tr>
					<?php if($aValue['FTPdtName'] == null){
						$tTextClassStatus 	= 'xCNTextClassStatus_close';
						$tDisabledBTN		= 'disabled';
						$tPDTName			= 'รหัสสินค้าไม่ถูกต้อง';
					}else{
						$tTextClassStatus 	= '';
						$tDisabledBTN		= '';
						$tPDTName			= $aValue['FTPdtName'];
					} ?>

					<th><label class="xCNLineHeightInTable"><?=$aValue['rtRowID']?></label></th>
					<td><label class="xCNLineHeightInTable <?=$tTextClassStatus;?>"><?=$aValue['FTPdtCode']?></label></td>
					<td><label class="xCNLineHeightInTable <?=$tTextClassStatus;?>"><?=$tPDTName;?></label></td>
					
					<?php if($tControlWhenAprOrCan != 'disabled'){ ?>
						<td>
							<input <?=$tDisabledBTN?> type="text" maxlength="250" data-pdtcode="<?=$aValue['FTPdtCode']?>" onkeypress="Javascript:if(event.keyCode==13) JSxUpdateCost(this);" onchange="JSxUpdateCost(this);" class="xCNEditInline xCNNumberandPercent" style="text-align: left; width: 100%;" id="oetAddCost<?=$aValue['FTPdtCode']?>" value="<?=$aValue['FTXpdDisCost'];?>" >
						</td>
					<?php }else{ ?>
						<td>
							<label style="text-align: left; width: 100%;" class="xCNLineHeightInTable"><?=$aValue['FTXpdDisCost'];?></label>
						</td>
					<?php } ?>

					<?php if($tControlWhenAprOrCan != 'disabled'){ ?>
						<?php $oEventDelete = "JSxAJC_DeleteInTmp('".$aValue['FTPdtCode']."')"; ?>
						<td><img class="img-responsive xCNImageDelete" src="<?=base_url().'application/assets/images/icon/delete.png';?>" onClick="<?=$oEventDelete?>"></td>
					<?php } ?>
				</tr>
			<?php } ?>
		<?php }else{ ?>
			<tr class="otrAJCTmpEmpty"><td colspan="99" style="text-align: center;"> - ไม่พบข้อมูล - </td></tr>
		<?php } ?>
  </tbody>
</table>

<div class="row">
    <div class="col-md-6">
        <label>พบข้อมูลทั้งหมด <?=$aListTmp['rnAllRow']?> รายการ แสดงหน้า <?=$aListTmp['rnCurrentPage']?> / <?=$aListTmp['rnAllPage']?></label>
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
				<?php for($i=max($nPage-2, 1); $i<=max(0, min($aListTmp['rnAllPage'],$nPage+2)); $i++){?>
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
				<?php if($nPage >= $aListTmp['rnAllPage']){ $tDisabledRight = 'disabled'; }else{ $tDisabledRight = '-'; } ?>
				<li class="page-item <?=$tDisabledRight?>">
					<a class="page-link" aria-label="Next" onclick="JSvAJC_ClickPage('next')"><span aria-hidden="true">&raquo;</span></a>
				</li>
			</ul>
		</nav>
    </div>
</div>

<script src="<?= base_url('application/assets/js/jFormValidate.js')?>"></script>
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

		JSvLoadTableDTTmp(nPageCurrent);
	}

	//ลบข้อมูล
	function JSxAJC_DeleteInTmp(tPDTCode){
		$.ajax({
			type	: "POST",
			url		: 'r_adjcostPDTDeleteInTmp',
			data 	: { 
						'tPdtCode' : tPDTCode,
						'tCode'	   : $('#ohdDocumentNumber').val()
					},
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				$('.xCNCloseDelete').click();
				$('.alert-success').addClass('show').fadeIn();
				$('.alert-success').find('.badge-success').text('สำเร็จ');
				$('.alert-success').find('.xCNTextShow').text('ลบข้อมูลสำเร็จ');
				JSvLoadTableDTTmp(1);
				setTimeout(function(){
					$('.alert-success').find('.close').click();
				}, 800);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert(jqXHR, textStatus, errorThrown);
			}
		});
	}

	//อัพเดทข้อมูล
	function JSxUpdateCost(e){
		var tValueUpdate 	= $(e).val();
		var tPDTCode 		= $(e).data('pdtcode');

		$.ajax({
			type	: "POST",
			url		: 'r_adjcostPDTUpdateInlineInTmp',
			data 	: { 
						'tPdtCode' 		: tPDTCode,
						'tValueUpdate' 	: tValueUpdate,
						'tCode'	   		: $('#ohdDocumentNumber').val()
					},
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				$('.xCNCloseDelete').click();
				$('.alert-success').addClass('show').fadeIn();
				$('.alert-success').find('.badge-success').text('สำเร็จ');
				$('.alert-success').find('.xCNTextShow').text('แก้ไขข้อมูลสำเร็จ');
				// JSvLoadTableDTTmp(1);
				setTimeout(function(){
					$('.alert-success').find('.close').click();
				}, 800);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert(jqXHR, textStatus, errorThrown);
			}
		});
	}

</script>
