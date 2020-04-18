<table class="table table-striped xCNTableCenter">
  <thead>
    <tr>
		<th style="width:20px; text-align: center;">ลำดับ</th>
		<th style="width:200px; text-align: left;">รหัสสินค้า</th>
		<th style="text-align: left;">ชื่อสินค้า</th>
		<th style="width:230px; text-align: left;">ราคาขายบวกเพิ่ม (%)</th>
		<th style="width:80px; text-align: center;">ลบ</th>
    </tr>
  </thead>
  <tbody>
		<?php if($aListTmp['rtCode'] != 800){ ?>
			<?php foreach($aListTmp['raItems'] AS $nKey => $aValue){ ?>
				<tr>
					<th><?=$aValue['rtRowID']?></th>
					<td><?=$aValue['FTPdtCode']?></td>
					<td><?=$aValue['FTPdtName']?></td>
					<td>
						<input type="text" maxlength="5" data-pdtcode="<?=$aValue['FTPdtCode']?>" onkeypress="Javascript:if(event.keyCode==13) JSxUpdatePriceSell(this);" onchange="JSxUpdatePriceSell(this);" class="xCNEditInline xCNInputNumericWithDecimal" style="text-align: right;" id="oetAddPri<?=$aValue['FTPdtCode']?>" value="<?=$aValue['FCXpdAddPri'];?>" >
					</td>
					<?php $oEventDelete = "JSxAJP_DeleteInTmp('".$aValue['FTPdtCode']."')"; ?>
					<td><img class="img-responsive xCNImageDelete" src="<?=base_url().'application/assets/images/icon/delete.png';?>" onClick="<?=$oEventDelete?>"></td>
				</tr>
			<?php } ?>
		<?php }else{ ?>
			<tr><td colspan="99" style="text-align: center;"> - ไม่พบข้อมูล - </td></tr>
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
					<a class="page-link" aria-label="Previous" onclick="JSvAJP_ClickPage('previous')"><span aria-hidden="true">&laquo;</span></a>
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
					<a class="page-link" aria-label="Next" onclick="JSvAJP_ClickPage('next')"><span aria-hidden="true">&raquo;</span></a>
				</li>
			</ul>
		</nav>
    </div>
</div>

<script src="<?= base_url('application/assets/js/jFormValidate.js')?>"></script>
<script>
	//เปลี่ยนหน้า
	function JSvAJP_ClickPage(ptPage) {
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
	function JSxUpdatePriceSell(e){
		var tValueUpdate 	= $(e).val();
		var tPDTCode 		= $(e).data('pdtcode');

		if(tValueUpdate > 100){
			$(e).val(100);
			tValueUpdate = 100;
		}

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
				$('.xCNCloseDelete').click();
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
