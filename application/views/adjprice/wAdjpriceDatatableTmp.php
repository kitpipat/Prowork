
<?php
	$aPermission = FCNaPERGetPermissionByPage('r_adjprice');
	$aPermission = $aPermission[0];
	if($aPermission['P_read'] != 1){ 		$tPer_read 		= 'xCNHide'; }else{ $tPer_read = ''; }
	if($aPermission['P_create'] != 1){ 		$tPer_create 	= 'xCNHide'; }else{ $tPer_create = ''; }
	if($aPermission['P_delete'] != 1){ 		$tPer_delete 	= 'xCNHide'; }else{ $tPer_delete = ''; }
	if($aPermission['P_edit'] != 1){ 		$tPer_edit 		= 'xCNHide'; }else{ $tPer_edit = ''; }
	if($aPermission['P_cancel'] != 1){ 		$tPer_cancle 	= 'xCNHide'; }else{ $tPer_cancle = ''; }
	if($aPermission['P_approved'] != 1){ 	$tPer_approved 	= 'xCNHide'; }else{ $tPer_approved = ''; }
	if($aPermission['P_print'] != 1){ 		$tPer_print 	= 'xCNHide'; }else{ $tPer_print = ''; }
?> 

<table class="table table-striped xCNTableCenter" id="otbAJPTable">
  <thead>
    <tr>
		<th style="width:20px; text-align: center;">ลำดับ</th>
		<th style="width:200px; text-align: left;">รหัสสินค้า</th>
		<th style="text-align: left;">ชื่อสินค้า</th>
		<th style="width:100px; text-align: left;">หน่วยสินค้า</th>
		<th style="width:150px; text-align: right;">ราคาต้นทุนตั้งต้น</th>
		<th style="width:150px; text-align: right;">ส่วนลดต้นทุน</th>
		<th style="width:230px; text-align: right;">ราคาขายบวกเพิ่ม (%)</th>
		<?php if($tControlWhenAprOrCan != 'disabled'){ ?>
			<th style="width:80px; text-align: center;" class='<?=$tPer_delete?>'>ลบ</th>
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

					<td><label class="xCNLineHeightInTable <?=$tTextClassStatus;?>"><?=($aValue['FTPunName'] =='') ? '-' : $aValue['FTPunName'];?></label></td>
					<td><label  style="text-align: right; width: 100%;" class="xCNLineHeightInTable <?=$tTextClassStatus;?>"><?=number_format($aValue['FCPdtCostStd'],2)?></label></td>
					<td><label  style="text-align: right; width: 100%;" class="xCNLineHeightInTable <?=$tTextClassStatus;?>">xxxxx</label></td>
					
					<?php if($tControlWhenAprOrCan != 'disabled'){ ?>
						<td>
							<input <?=$tDisabledBTN?> type="text" maxlength="5" data-pdtcode="<?=$aValue['FTPdtCode']?>" onkeypress="Javascript:if(event.keyCode==13) JSxUpdatePriceSell(this);" onchange="JSxUpdatePriceSell(this);" class="xCNEditInline xCNInputNumericWithDecimal" style="text-align: right; width: 100%;" id="oetAddPri<?=$aValue['FTPdtCode']?>" value="<?=$aValue['FCXpdAddPri'];?>" >
						</td>
					<?php }else{ ?>
						<td>
							<label style="text-align: right; width: 100%;" class="xCNLineHeightInTable"><?=$aValue['FCXpdAddPri'];?></label>
						</td>
					<?php } ?>

					<?php if($tControlWhenAprOrCan != 'disabled'){ ?>
						<?php $oEventDelete = "JSxAJP_DeleteInTmp('".$aValue['FTPdtCode']."')"; ?>
						<td class='<?=$tPer_delete?>'><img class="img-responsive xCNImageDelete" src="<?=base_url().'application/assets/images/icon/delete.png';?>" onClick="<?=$oEventDelete?>"></td>
					<?php } ?>
				</tr>
			<?php } ?>
		<?php }else{ ?>
			<tr class="otrAJPTmpEmpty"><td colspan="99" style="text-align: center;"> - ไม่พบข้อมูล - </td></tr>
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
					<a class="page-link" aria-label="Previous" onclick="JSvAJP_ClickPage('Fisrt')"><span aria-hidden="true">&laquo;</span></a>
				</li>

				<li class="page-item <?=$tDisabledLeft;?>">
					<a class="page-link" aria-label="Previous" onclick="JSvAJP_ClickPage('previous')"><span aria-hidden="true">&lsaquo;</span></a>
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
					<li class="page-item <?=$tActive;?> " onclick="JSvAJP_ClickPage('<?=$i?>')"><a class="page-link"><?=$i?></a></li>
				<?php } ?>

				<!--ปุ่มไปต่อ-->
				<?php if($nPage >= $aListTmp['rnAllPage']){ $tDisabledRight = 'disabled'; }else{ $tDisabledRight = '-'; } ?>
				<li class="page-item <?=$tDisabledRight?>">
					<a class="page-link" aria-label="Next" onclick="JSvAJP_ClickPage('next')"><span aria-hidden="true">&rsaquo;</span></a>
				</li>

				<li class="page-item <?=$tDisabledRight?>">
					<a class="page-link" aria-label="Next" onclick="JSvAJP_ClickPage('Last')"><span aria-hidden="true">&raquo;</span></a>
				</li>
			</ul>
		</nav>
    </div>
</div>

<script src="<?= base_url('application/assets/js/jFormValidate.js')?>"></script>
<script>
	//ถ้าเข้ามาแบบแก้ไข แต่ ไม่มีสิทธิ์ในการแก้ไข
	if('<?=$tPer_edit?>' != ''){
		$('.xCNEditInline').attr('disabled',true);
	}

	//เปลี่ยนหน้า
	function JSvAJP_ClickPage(ptPage) {
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
				nPageCurrent 	= '<?=$aListTmp['rnAllPage']?>';
			break;
			default:
				nPageCurrent = ptPage
		}

		JSvLoadTableDTTmp(nPageCurrent);
	}

	//ลบข้อมูล
	function JSxAJP_DeleteInTmp(tPDTCode){
		$.ajax({
			type	: "POST",
			url		: 'r_adjpricePDTDeleteInTmp',
			data 	: { 
						'tPdtCode' : tPDTCode,
						'tCode'	   : $('#ohdDocumentNumber').val()
					},
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
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
	function JSxUpdatePriceSell(e){
		var tValueUpdate 	= $(e).val();
		var tPDTCode 		= $(e).data('pdtcode');

		// if(tValueUpdate > 100){
		// 	$(e).val(100);
		// 	tValueUpdate = 100;
		// }

		$.ajax({
			type	: "POST",
			url		: 'r_adjpricePDTUpdateInlineInTmp',
			data 	: { 
						'tPdtCode' 		: tPDTCode,
						'tValueUpdate' 	: tValueUpdate,
						'tCode'	   		: $('#ohdDocumentNumber').val()
					},
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				$('.alert-success').addClass('show').fadeIn();
				$('.alert-success').find('.badge-success').text('สำเร็จ');
				$('.alert-success').find('.xCNTextShow').text('แก้ไขข้อมูลสำเร็จ');
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

</script>
