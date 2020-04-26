<?php
	$aPermission = FCNaPERGetPermissionByPage('r_quotationcheck');
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
		<th rowspan="2" style="width:150px; text-align: left; vertical-align: middle;">เลขที่เอกสาร</th>
		<th rowspan="2" style="width:100px; text-align: left; vertical-align: middle;">วันที่เอกสาร</th>
		<th rowspan="2" style="width:10px; text-align: left; vertical-align: middle;">ลำดับ</th>
		<th rowspan="2" style="text-align: left; vertical-align: middle;">รายการสินค้า</th>
		<th rowspan="2" style="width:80px; text-align: right; vertical-align: middle;">ราคาขาย</th>
		<th rowspan="2" style="width:80px; text-align: right; vertical-align: middle;">จำนวน</th>
		<th rowspan="2" style="width:100px; text-align: left; vertical-align: middle;">หน่วยสินค้า</th>
		<th rowspan="2" style="width:100px; text-align: left; vertical-align: middle;">สถานะเอกสาร</th>
		<th class="xCNBorderleft" colspan="2" style="text-align:center;">จัดซื้อสินค้า</th>
		<th class="xCNBorderleft xCNBorderright" colspan="2" style="text-align:center;">สถานะสั้งสินค้าและบิล</th>
		<th rowspan="2" style="width:80px; text-align: left; vertical-align: middle;">ผู้รับ</th>
	</tr>
	<tr>
		<th class="xCNBorderleft" style="text-align:center; width:110px;">วันที่สั้งสินค้า</th>
		<th style="text-align:center; width:110px;">วันกำหนดส่งของ</th>
		<th class="xCNBorderleft" style="text-align:center; width:110px;">วันที่รับสินค้า</th>
		<th class="xCNBorderright" style="text-align:center; width:110px;">เลขที่บิล</th>
	</tr>
  </thead>
  <tbody>
		<?php if($aList['rtCode'] != 800){ ?>
			<?php foreach($aList['raItems'] AS $nKey => $aValue){ ?>
				<tr>
					<td><?=$aValue['FTXqhDocNo']?></td>
					<td><?=date('d/m/Y',strtotime($aValue['FDXqhDocDate']));?></td>
					<td><?=($aValue['FNXqdSeq'] == '') ? 'x' : $aValue['FNXqdSeq']?></td>
					<td><?=($aValue['FTPdtName'] == '')? 'ไม่พบสินค้า' : $aValue['FTPdtName'] ?></td>
					<td class="text-right"><?=number_format($aValue['FCXqdUnitPrice'],2)?></td>
					<td class="text-right"><?=($aValue['FCXqdQty'] == '') ? '0.00' : $aValue['FCXqdQty']?></td>
					<td><?=($aValue['FTPunName'] == '') ? '-' : $aValue['FTPunName'] ?></td>

					<!--สถานะอนุมัติ-->
					<?php 
						if($aValue['FTXqhStaApv'] == 1){
							$tTextStaApv 			= "อนุมัติแล้ว";
							$tClassStaApv 			= 'xCNTextClassStatus_open';
							$tIconClassStaApv 		= 'xCNIconStatus_open';
							$tDisabledKey			= '';
							$tPlaceholder			= 'DD/MM/YYYY';
						}else{
							$tTextStaApv 			= "รออนุมัติ";
							$tClassStaApv 			= 'xCNTextClassStatus_close';
							$tIconClassStaApv 		= 'xCNIconStatus_close';
							$tDisabledKey			= 'disabled';
							$tPlaceholder			= '-';
						}
					?>
					<td><span class="<?=$tClassStaApv?>"><?=$tTextStaApv?></span></td>

					<!--วันที่สั้งสินค้า-->
					<td class="xCNBorderleft">
						<?php 
							if($aValue['FDXqdPucDate'] != '' || $aValue['FDXqdPucDate'] != null){
								$FDXqdPucDate = date('d/m/Y',strtotime($aValue['FDXqdPucDate']));
							}else{
								$FDXqdPucDate = null;
							}
						?>

						<!--มีสิทธิแก้ไข-->
						<?php if($tPer_edit == ''){ ?>
							<input data-docnumber="<?=$aValue['FTXqhDocNo']?>" data-seq='<?=$aValue['FNXqdSeq']?>' data-pdtcode='<?=$aValue['FTPdtCode']?>' onchange="JSxUpdateInline(this,'PUCDATE');" type="text" <?=$tDisabledKey?> maxlength="10" class="xCNEditInline xCNDatePicker" style="text-align: left; width: 100%;" placeholder="<?=$tPlaceholder?>" value="<?=@$FDXqdPucDate?>">
						<?php }else{ ?>
							<label style="text-align: center; display: block;"><?=($FDXqdPucDate == null) ? '-' : $FDXqdPucDate?></label>
						<?php } ?>
					</td>
					<td>
						<?php 
							if($aValue['FDXqdDliDate'] != '' || $aValue['FDXqdDliDate'] != null){
								$FDXqdDliDate = date('d/m/Y',strtotime($aValue['FDXqdDliDate']));
							}else{
								$FDXqdDliDate = null;
							}
						?>
						<!--มีสิทธิแก้ไข-->
						<?php if($tPer_edit == ''){ ?>
							<input data-docnumber="<?=$aValue['FTXqhDocNo']?>" data-seq='<?=$aValue['FNXqdSeq']?>' data-pdtcode='<?=$aValue['FTPdtCode']?>' onchange="JSxUpdateInline(this,'DLIDATE');" type="text" <?=$tDisabledKey?> maxlength="10" class="xCNEditInline xCNDatePicker" style="text-align: left; width: 100%;" placeholder="<?=$tPlaceholder?>" value="<?=@$FDXqdDliDate?>">
						<?php }else{ ?>
							<label style="text-align: center; display: block;"><?=($FDXqdDliDate == null) ? '-' : $FDXqdDliDate?></label>
						<?php } ?>
					</td>

					<!--วันที่รับสินค้า-->
					<td class="xCNBorderleft">
						<?php 
							if($aValue['FDXqdPikDate'] != '' || $aValue['FDXqdPikDate'] != null){
								$FDXqdPikDate = date('d/m/Y',strtotime($aValue['FDXqdPikDate']));
							}else{
								$FDXqdPikDate = null;
							}
						?>
						<!--มีสิทธิแก้ไข-->
						<?php if($tPer_edit == ''){ ?>
							<input data-docnumber="<?=$aValue['FTXqhDocNo']?>" data-seq='<?=$aValue['FNXqdSeq']?>' data-pdtcode='<?=$aValue['FTPdtCode']?>' onchange="JSxUpdateInline(this,'PIKDATE');" type="text" <?=$tDisabledKey?> maxlength="10" class="xCNEditInline xCNDatePicker" style="text-align: left; width: 100%;" placeholder="<?=$tPlaceholder?>" value="<?=@$FDXqdPikDate?>">
						<?php }else{ ?>
							<label style="text-align: center; display: block;"><?=($FDXqdPikDate == null) ? '-' : $FDXqdDliDate?></label>
						<?php } ?>
					</td>
					<td class="xCNBorderright">
						<?php $FTXqdRefInv = $aValue['FTXqdRefInv']; ?>
						<!--มีสิทธิแก้ไข-->
						<?php if($tPer_edit == ''){ ?>
							<input data-docnumber="<?=$aValue['FTXqhDocNo']?>" data-seq='<?=$aValue['FNXqdSeq']?>' data-pdtcode='<?=$aValue['FTPdtCode']?>' onchange="JSxUpdateInline(this,'REF');" type="text" <?=$tDisabledKey?> maxlength="20" class="xCNEditInline" style="text-align: left; width: 100%;" value="<?=@$FTXqdRefInv?>">
						<?php }else{ ?>
							<label style="text-align: center; display: block;"><?=($FTXqdRefInv == null) ? '-' : $FTXqdRefInv?></label>
						<?php } ?>
					
					</td>
					<td><?=($aValue['FTUsrFName'] == '' ) ? '-' : $aValue['FTUsrFName'];?></td>
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
					<a class="page-link" aria-label="Previous" onclick="JSvPIList_ClickPage('previous')"><span aria-hidden="true">&laquo;</span></a>
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
					<li class="page-item <?=$tActive;?> " onclick="JSvPIList_ClickPage('<?=$i?>')"><a class="page-link"><?=$i?></a></li>
				<?php } ?>

				<!--ปุ่มไปต่อ-->
				<?php if($nPage >= $aList['rnAllPage']){ $tDisabledRight = 'disabled'; }else{ $tDisabledRight = '-'; } ?>
				<li class="page-item <?=$tDisabledRight?>">
					<a class="page-link" aria-label="Next" onclick="JSvPIList_ClickPage('next')"><span aria-hidden="true">&raquo;</span></a>
				</li>
			</ul>
		</nav>
    </div>
</div>

<script>

	$('ducument').ready(function(){ 
		$('.xCNDatePicker').datepicker({ 
			format          : 'dd/mm/yyyy',
			autoclose       : true,
			todayHighlight  : true,
			orientation		: "top right"
		});
	});

	//เปลี่ยนหน้า
	function JSvPIList_ClickPage(ptPage) {
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

	//แก้ไขข้อมูล
	function JSxUpdateInline(elem,ptType){
		var tDocumentNubmer = $(elem).attr('data-docnumber');
		var tSeq 			= $(elem).attr('data-seq');
		var tPdtcode 		= $(elem).attr('data-pdtcode');
		var tValue			= $(elem).val();

		$.ajax({
			type	: "POST",
			url		: 'r_quotationcheckUpdate',
			data 	: {
				'tType'				: ptType,
				'tDocumentNubmer' 	: tDocumentNubmer,
				'tSeq'				: tSeq,
				'tPdtcode'			: tPdtcode,
				'tValue'			: tValue
			},
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				//เปิด message
				$('.xCNDialog_Footer').css('display','block');

				$('.alert-success').addClass('show').fadeIn();
				$('.alert-success').find('.badge-success').text('สำเร็จ');
				$('.alert-success').find('.xCNTextShow').text('แก้ไขข้อมูลสำเร็จ');
				setTimeout(function(){
					$('.alert-success').find('.close').click();
					$('.xCNDialog_Footer').css('display','none');
				}, 3000);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert(jqXHR, textStatus, errorThrown);
			}
		});

	}
</script>
