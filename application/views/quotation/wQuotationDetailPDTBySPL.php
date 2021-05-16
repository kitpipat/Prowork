<?php if($aItem['rtCode'] != 800){ ?>
	<table class="table table-striped xCNTableCenter">
		<thead>
			<tr>
				<th style="width:20px; text-align: left;">เลือก</th>
				<th style="width:300px; text-align: left;">รายการ</th>
				<th style="width:150px; text-align: right;">จำนวน</th>
				<th style="width:150px; text-align: left;">หน่วย</th>
				<th style="width:120px; text-align: right;">ราคา</th>
				<!-- <th style="width:80px; text-align: center;">ลบ</th> -->
			</tr>
		</thead>
		<tbody>
				<?php if($aItem['rtCode'] != 800){ ?>
					<?php $nSPL = ''; ?>
					<?php foreach($aItem['raItems'] AS $nKey => $oValue){ ?>
						<?php if($nSPL != $oValue['FTSplCode']){ ?>
							<tr class="xCNSPLBy<?=$oValue['FTSplCode']?>"><th colspan="6" style="padding: 20px 10px !important;">[PO<?=$this->session->userdata('tSesBCHCode')?><?=date('Ymd')?>-#####] <?=$oValue['FTSplName']?></th></tr>
							<?php foreach($aItem['raItems'] AS $nKey => $aValue){ ?>
								<?php if($oValue['FTSplCode'] == $aValue['FTSplCode']){ ?>
									<tr class="otrItemSPL otrItemBySPLCode<?=$oValue['FTSplCode']?>" data-spl="<?=$oValue['FTSplCode']?>">
										<td class="text-center">
											<label class="container-checkbox" style="display: block; margin: 0px auto;">
												<input 
													data-pdtcode="<?=$aValue['FTPdtCode']?>" 
													data-splcode="<?=$aValue['FTSplCode']?>"
													data-price="<?=$aValue['FCXqdNetAfHD']?>"
													data-pdtname="<?=$aValue['FTPdtName']?>"
													class="xCNItemDT" type="checkbox" name="ocmDTInCreatePOSeleted" checked>
												<span class="checkmark"></span>
											</label>
										</td>
										<td><?=$aValue['FTPdtCode']?> - <?=$aValue['FTPdtName']?></td>
										<td class="text-right"><?=number_format($aValue['FCXqdQty'])?></td>
										<td><?=$aValue['FTPunName']?></td>
										<td class="text-right"><?=number_format($aValue['FCXqdNetAfHD'],2)?></td>
										<!-- <td><img class="img-responsive xCNImageDelete" src="<?=base_url().'application/assets/images/icon/delete.png';?>" onClick="JSxRemovePDTInTempBySPL(this)"></td> -->
									</tr>
								<?php } ?>
							<?php } ?>
							<?php $nSPL = $oValue['FTSplCode'] ?>
						<?php } ?>
					<?php } ?>

				<?php }else{ ?>
					<tr><td colspan="99" style="text-align: center;"> - ไม่พบข้อมูล - </td></tr>
				<?php } ?>
		</tbody>
	</table>
<?php }else{ ?>
	<label>รายการสินค้าทั้งหมดในใบเสนอราคานี้ได้ทำการสั่งซื้อครบแล้ว</label>
<?php } ?>
<script>

	$('.xCNConfirmCreatePO').show();
	if('<?=$aItem['rtCode']?>' == 800){
		$('.xCNConfirmCreatePO').hide();
	}

	//ลบข้อมูล
	function JSxRemovePDTInTempBySPL(elem){
		$(elem).closest('tr').remove();
		var nSPLCode = $(elem).closest('tr').attr('data-spl');
		var nLength 	 = $('.otrItemBySPLCode'+nSPLCode).length;
		if(nLength == 0){
			$('.xCNSPLBy'+nSPLCode).after("<tr><td colspan='99' style='text-align: center;'> - ไม่พบข้อมูล - </td></tr>");
		}
	}

	$('.xCNConfirmCreatePO').off();
	$('.xCNConfirmCreatePO').on("click",function(){

		var aItem 			= [];
		var tDocumentNumber = $('#ospDocNo').attr('data-docno');
		$('.xCNItemDT:checked').each(function() {
			var tPDTCode 	= $(this).data('pdtcode');
			var tSPLCode 	= $(this).data('splcode'); 
			var nPrice  	= $(this).data('price');
			var tPDTName  	= $(this).data('pdtname'); 
			aItem.push({'tPDTCode' : tPDTCode , 'tSPLCode' : tSPLCode , 'nPrice' : nPrice , 'tPDTName' : tPDTName });
		});

		
		if(aItem.length != 0){
			$.ajax({
				type	: "POST",
				url		: "r_quotationItemGenPO",
				data 	: { 'tDocumentNumber' : tDocumentNumber , 'aItem' : aItem },
				cache	: false,
				timeout	: 0,
				success	: function (tResult) {
					oResult 			= JSON.parse(tResult);
					var nCountDocument  = oResult.nCountSPL;
					var tHTMLPO = '';
						tHTMLPO += 'สร้างเอกสารใบสั่งซื้อสำเร็จ สามารถตรวจสอบ และอนุมัติเอกสารของคุณได้ที่หน้าจอใบสั่งซื้อ';
						tHTMLPO += '<br>';
						tHTMLPO += '<table class="table table-striped">';
						tHTMLPO += '<thead>';
						tHTMLPO += '<tr>';
						tHTMLPO += '<th>' + 'ผู้จำหน่าย' + '</th>';
						tHTMLPO += '<th>' + 'เลขที่ใบสั่งซื้อ' + '</th>';
						tHTMLPO += '</tr>';
						tHTMLPO += '</thead>';
						tHTMLPO += '</tbody>';
						for(var i=0; i<nCountDocument; i++){
							tHTMLPO += '<tr>';
							tHTMLPO += '<td>' + oResult.aResultToView[i].SPLNAME + '</td>';
							tHTMLPO += '<td>' + oResult.aResultToView[i].DOCNO  + '</td>';
							tHTMLPO += '</tr>';
						}
						tHTMLPO += '</tbody>';
						tHTMLPO += '</table>';
					$('#odvContentModalCreatePO').html(tHTMLPO);

					$('#odvModalCreatePO .xCNConfirmCreatePO').hide();
					$('#odvModalCreatePO .xCNCloseDelete').click(function(e) {
						setTimeout(function(){
							JSxCallPagePIListMain();
						}, 500);
					});
				},
				error: function (jqXHR, textStatus, errorThrown) {
					JSxModalErrorCenter(jqXHR.responseText);
				}
			});
		}
	});

	

</script>
