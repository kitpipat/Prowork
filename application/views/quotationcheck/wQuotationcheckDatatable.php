<style>
       table {
			table-layout: fixed;
			width: 100%;
		}

		.xCNThNormal{
			padding-top: 26px !important;
    		padding-bottom: 26px !important;
		}

		.hard_left {
			position:absolute;
			right:0;
			width:100px;
		}

		.hard_left_Top_Right1{
			position	: absolute;
			width		: 24%;
			right		: 38%;
		}

		.hard_left_Top_Right4{
			position		: absolute;
			width			: 10%;
			right			: 28%;
			text-align		: left;
			vertical-align	: middle !important;
			text-align		: center;
			padding-top		: 26px !important;
    		padding-bottom	: 26px !important;
		}

		.hard_left_Top_Right2{
			position	: absolute;
			width		: 17%;
			right		: 10%;
		}

		.hard_left_Top_Right3{
			position		: absolute;
			width			: 10%;
			right			: 0px;
			text-align		: left;
			vertical-align	: middle !important;
			text-align		: center;
			padding-top		: 26px !important;
    		padding-bottom	: 26px !important;
		}

		.xCNFreezeSection1{
			position	: absolute;
			width		: 8%;
			text-align	: center;
			right		: 54%;
			text-align: left;
			padding-top: 4px !important;
			/* background-color :green; */
		}

		.xCNFreezeSection2{
			position	: absolute;
			width		: 8%;
			text-align	: center;
			right		: 46%;
			text-align: right;
			padding-top: 4px !important;
			/* background-color :black; */
		}

		.xCNFreezeSection3{
			position	: absolute;
			width		: 8%;
			text-align	: center;
			right		: 38%;
			text-align: left;
			padding-top: 4px !important;
			/* background-color :pink; */
		}

		.xCNFreezeSection4{
			position	: absolute;
			width		: 8%;
			text-align	: center;
			right		: 19%;
			text-align: right;
			padding-top: 4px !important;
			/* background-color :yellow; */

		}

		.xCNFreezeSection5{
			position	: absolute;
			width		: 9%;
			text-align	: center;
			right		: 10%;
			text-align: right;
			padding-top: 4px !important;
			/* background-color :red; */
		}


		.xCNFreezeGiveUser{
			position		: absolute;
			width			: 10%;
			right			: 0px;
		}

		.xCNFreezeGiveBuyer{
			position		: absolute;
			width			: 11%;
			right			: 27%;
		}

		.hard_left_Sub_Right{
			width		: 52%;
			top			: 34px;
			position	: absolute;
			right		: 10%;
			display		: table;
		}

		.outer {position:relative}
		.inner {
			overflow-x:scroll;
			overflow-y:visible;
			width:38%;
		}

		.datepicker{
			width : 100px;
		}

		.xCNEditInline{
			height: 25px;
			margin-top: 2.5px;
		}

		.xCNClassDisabledInput{
			background : #e6e6e6;
		}
</style>

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

<div class="outer">
  	<div class="inner">
		<table class="table table-striped xCNTableCenter">
			<thead>
				<tr>
					<th class="xCNThNormal" rowspan="2" style="width:200px; text-align: left; vertical-align: middle;">เลขที่เอกสาร</th>
					<th class="xCNThNormal" rowspan="2" style="width:100px; text-align: left; vertical-align: middle;">วันที่เอกสาร</th>
					<th class="xCNThNormal" rowspan="2" style="width:80px; text-align: left; vertical-align: middle;">ลำดับ</th>
					<th class="xCNThNormal" rowspan="2" style="width:270px; text-align: left; vertical-align: middle;">รายการสินค้า</th>
					<th class="xCNThNormal" rowspan="2" style="width:120px; text-align: right; vertical-align: middle;">ราคาขาย</th>
					<th class="xCNThNormal" rowspan="2" style="width:120px; text-align: right; vertical-align: middle;">จำนวน</th>
					<th class="xCNThNormal" rowspan="2" style="width:100px; text-align: left; vertical-align: middle;">หน่วยสินค้า</th>
					<th class="xCNThNormal" rowspan="2" style="width:100px; text-align: left; vertical-align: middle;">สถานะเอกสาร</th>
					<th class="xCNBorderleft hard_left_Top_Right1" colspan="2" style="text-align:center;">จัดซื้อสินค้า</th>
					<th class="xCNBorderleft hard_left_Top_Right4" rowspan="2">ผู้สั้งซื้อ</th>
					<th class="xCNBorderleft hard_left_Top_Right2" colspan="2" style="text-align:center;">รับสินค้า</th>
					<th class="xCNBorderleft hard_left_Top_Right3" rowspan="2">ผู้รับสินค้า</th>
				</tr>
				<tr class="hard_left_Sub_Right">
					<th class="xCNBorderleft" style="text-align:center; width:15.50%;">วันสั่งสินค้า</th>
					<th style="text-align:center; width:15.50%;">วันส่งของ</th>
					<th style="text-align:center; width:15.50%;">อ้างอิง</th>
					<th style="text-align:center; width:21.10%;"></th>
					<th class="xCNBorderleft" style="text-align:center; width:15.50%;">วันรับสินค้า</th>
					<th style="text-align:center;">เลขที่บิล</th>
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
								<td class="xCNBorderleft xCNFreezeSection1">
									<?php
										if($aValue['FDXqdPucDate'] != '' || $aValue['FDXqdPucDate'] != null){
											$FDXqdPucDate = date('d/m/Y',strtotime($aValue['FDXqdPucDate']));
										}else{
											$FDXqdPucDate = null;
										}
									?>

									<?php 
										//ถ้ามีชื่อผู้สั้งซื้อสินค้าเเล้วไม่สามารถเเก้ไขวันที่ได้
										if($aValue['namebuy'] != '' || $aValue['namebuy'] != null){
											$tDisabled 				= 'disabled';
											$tClassDisabledInput 	= 'xCNClassDisabledInput';
										}else{
											$tDisabled 				= '';
											$tClassDisabledInput 	= '';
										}
									?>

									<!--มีสิทธิแก้ไข-->
									<?php if($tPer_edit == ''){ ?>
										<input <?=$tDisabled?> data-docnumber="<?=$aValue['FTXqhDocNo']?>" data-seq='<?=$aValue['FNXqdSeq']?>' data-pdtcode='<?=$aValue['FTPdtCode']?>' onchange="JSxUpdateInline(this,'PUCDATE');" type="text" <?=$tDisabledKey?> maxlength="10" class="<?=$tClassDisabledInput?> xCNEditInline xCNDatePicker xCNPUCDATE<?=$aValue['FTXqhDocNo']?><?=$aValue['FNXqdSeq']?>" style="text-align: left; width:100%;" placeholder="<?=$tPlaceholder?>" value="<?=@$FDXqdPucDate?>">
									<?php }else{ ?>
										<label style="text-align: center; display: block; margin-top: 5px;"><?=($FDXqdPucDate == null) ? '-' : $FDXqdPucDate?></label>
									<?php } ?>
								</td>

								<td class="xCNFreezeSection2">
									<?php
										if($aValue['FDXqdDliDate'] != '' || $aValue['FDXqdDliDate'] != null){
											$FDXqdDliDate = date('d/m/Y',strtotime($aValue['FDXqdDliDate']));
										}else{
											$FDXqdDliDate = null;
										}
									?>

									<?php 
										//ถ้ามีชื่อผู้สั้งซื้อสินค้าเเล้วไม่สามารถเเก้ไขวันที่ได้
										if($aValue['namebuy'] != '' || $aValue['namebuy'] != null){
											$tDisabled 				= 'disabled';
											$tClassDisabledInput 	= 'xCNClassDisabledInput';
										}else{
											$tDisabled 				= '';
											$tClassDisabledInput 	= '';
										}
									?>

									<!--มีสิทธิแก้ไข-->
									<?php if($tPer_edit == ''){ ?>
										<input <?=$tDisabled?> data-docnumber="<?=$aValue['FTXqhDocNo']?>" data-seq='<?=$aValue['FNXqdSeq']?>' data-pdtcode='<?=$aValue['FTPdtCode']?>' onchange="JSxUpdateInline(this,'DLIDATE');" type="text" <?=$tDisabledKey?> maxlength="10" class="<?=$tClassDisabledInput?> xCNEditInline xCNDatePicker xCNDLIDATE<?=$aValue['FTXqhDocNo']?><?=$aValue['FNXqdSeq']?>" style="text-align: left; width:100%;" placeholder="<?=$tPlaceholder?>" value="<?=@$FDXqdDliDate?>">
									<?php }else{ ?>
										<label style="text-align: center; display: block; margin-top: 5px;"><?=($FDXqdDliDate == null) ? '-' : $FDXqdDliDate?></label>
									<?php } ?>
								</td>

								<!--อ้างอิง-->
								<td class="xCNFreezeSection3">
									<?php $FTXqdRefBuyer = $aValue['FTXqdRefBuyer']; ?>
									<!--มีสิทธิแก้ไข-->
									<?php if($tPer_edit == ''){ ?>
										<input data-docnumber="<?=$aValue['FTXqhDocNo']?>" data-seq='<?=$aValue['FNXqdSeq']?>' data-pdtcode='<?=$aValue['FTPdtCode']?>' onchange="JSxUpdateInline(this,'REFBUY');" type="text" <?=$tDisabledKey?> maxlength="20" class="xCNEditInline xCNREFBUY<?=$aValue['FTXqhDocNo']?><?=$aValue['FNXqdSeq']?>" style="text-align: left; width: 100%;" value="<?=@$FTXqdRefBuyer?>">
									<?php }else{ ?>
										<label style="text-align: center; display: block; margin-top: 5px;"><?=($FTXqdRefBuyer == null) ? '-' : $FTXqdRefBuyer?></label>
									<?php } ?>
								</td>

								<!--ผูสั้ง-->
								<td class="xCNBorderleft xCNFreezeGiveBuyer xCNFreezeGiveBuyer<?=$aValue['FTXqhDocNo']?><?=$aValue['FNXqdSeq']?>">
									<?=($aValue['namebuy'] == '' ) ? '-' : $aValue['namebuy'];?>
								</td>

								<!---------------------------------------------------------->

								<!--วันที่รับสินค้า-->
								<td class="xCNBorderleft xCNFreezeSection4">
									<?php
										if($aValue['FDXqdPikDate'] != '' || $aValue['FDXqdPikDate'] != null){
											$FDXqdPikDate = date('d/m/Y',strtotime($aValue['FDXqdPikDate']));
										}else{
											$FDXqdPikDate = null;
										}
									?>

									<!--มีสิทธิแก้ไข-->
									<?php if($tPer_edit == ''){ ?>
										<input data-docnumber="<?=$aValue['FTXqhDocNo']?>" data-seq='<?=$aValue['FNXqdSeq']?>' data-pdtcode='<?=$aValue['FTPdtCode']?>' onchange="JSxUpdateInline(this,'PIKDATE');" type="text" <?=$tDisabledKey?> maxlength="10" class="xCNEditInline xCNDatePicker xCNPIKDATE<?=$aValue['FTXqhDocNo']?><?=$aValue['FNXqdSeq']?>" style="text-align: left; width:100%;" placeholder="<?=$tPlaceholder?>" value="<?=@$FDXqdPikDate?>">
									<?php }else{ ?>
										<label style="text-align: center; display: block; margin-top: 5px;"><?=($FDXqdPikDate == null) ? '-' : $FDXqdDliDate?></label>
									<?php } ?>
								</td>
								<td class="xCNBorderright xCNFreezeSection5">
									<?php $FTXqdRefInv = $aValue['FTXqdRefInv']; ?>
									<!--มีสิทธิแก้ไข-->
									<?php if($tPer_edit == ''){ ?>
										<input data-docnumber="<?=$aValue['FTXqhDocNo']?>" data-seq='<?=$aValue['FNXqdSeq']?>' data-pdtcode='<?=$aValue['FTPdtCode']?>' onchange="JSxUpdateInline(this,'REFCON');" type="text" <?=$tDisabledKey?> maxlength="20" class="xCNEditInline" style="text-align: left; width: 100%;" value="<?=@$FTXqdRefInv?>">
									<?php }else{ ?>
										<label style="text-align: center; display: block; margin-top: 5px;"><?=($FTXqdRefInv == null) ? '-' : $FTXqdRefInv?></label>
									<?php } ?>
								</td>

								<!--ผู้รับ-->
								<td class="xCNFreezeGiveUser xCNFreezeGiveUser<?=$aValue['FTXqhDocNo']?><?=$aValue['FNXqdSeq']?>">
									<?=($aValue['namecon'] == '' ) ? '-' : $aValue['namecon'];?>
								</td>
							</tr>
						<?php } ?>
					<?php }else{ ?>
						<tr><td colspan="99" style="text-align: center;"> - ไม่พบข้อมูล - </td></tr>
					<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<div class="row" style="margin-top: 15px;">
    <div class="col-md-6">
        <label>พบข้อมูลทั้งหมด <?=$aList['rnAllRow']?> รายการ แสดงหน้า <?=$aList['rnCurrentPage']?> / <?=$aList['rnAllPage']?></label>
    </div>
    <div class="col-md-6">
		<nav>
			<ul class="xCNPagenation pagination justify-content-end">
				<!--ปุ่มย้อนกลับ-->
				<?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
				<li class="page-item <?=$tDisabledLeft;?>">
					<a class="page-link" aria-label="Previous" onclick="JSvPIList_ClickPage('Fisrt')"><span aria-hidden="true">&laquo;</span></a>
				</li>

				<li class="page-item <?=$tDisabledLeft;?>">
					<a class="page-link" aria-label="Previous" onclick="JSvPIList_ClickPage('previous')"><span aria-hidden="true">&lsaquo;</span></a>
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
					<a class="page-link" aria-label="Next" onclick="JSvPIList_ClickPage('next')"><span aria-hidden="true">&rsaquo;</span></a>
				</li>

				<li class="page-item <?=$tDisabledRight?>">
					<a class="page-link" aria-label="Next" onclick="JSvPIList_ClickPage('Last')"><span aria-hidden="true">&raquo;</span></a>
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

		

		//ฝ่ายจัดซื้อ = 1 จะใช้งานช่อง รับสินค้า ไม่ได้
		if('<?=$this->session->userdata("tSesUserGroup")?>' == 1){
			$('.xCNFreezeSection4').find('.xCNEditInline').attr('disabled',true).css('background','#e6e6e6');
			$('.xCNFreezeSection5').find('.xCNEditInline').attr('disabled',true).css('background','#e6e6e6');
		}	

		//ฝ่ายขาย = 1 จะใช้งานช่อง จัดซื้อ ไม่ได้
		if('<?=$this->session->userdata("tSesUserGroup")?>' == 2){
			$('.xCNFreezeSection1').find('.xCNEditInline').attr('disabled',true).css('background','#e6e6e6');
			$('.xCNFreezeSection2').find('.xCNEditInline').attr('disabled',true).css('background','#e6e6e6');
			$('.xCNFreezeSection3').find('.xCNEditInline').attr('disabled',true).css('background','#e6e6e6');
		}	
	});

	//เปลี่ยนหน้า
	function JSvPIList_ClickPage(ptPage) {
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

	//แก้ไขข้อมูล
	function JSxUpdateInline(elem,ptType){
		var tDocumentNubmer = $(elem).attr('data-docnumber');
		var tSeq 			= $(elem).attr('data-seq');
		var tPdtcode 		= $(elem).attr('data-pdtcode');
		var tValue			= $(elem).val();

		if(ptType == 'REFBUY'){
			var dDLIDATE = $('.xCNDLIDATE'+tDocumentNubmer+tSeq).val();
			var dPUCDATE = $('.xCNPUCDATE'+tDocumentNubmer+tSeq).val();

			if((dDLIDATE == '' || dDLIDATE == null) && (dPUCDATE == '' || dPUCDATE == null)){
				alert('กรุณากรอกวันสั่งสินค้า และวันส่งของให้เรียบร้อยก่อน !');
				$(elem).val('');
				return;
			}
		}


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
				$('.alert-success').find('.xCNTextShow').text('ข้อมูลมีการเปลี่ยนแปลง');
				setTimeout(function(){
					$('.alert-success').find('.close').click();
					$('.xCNDialog_Footer').css('display','none');
				}, 3000);


				//ถ้ากรอกเลขที่บิล จะเอาต้อง อัพเดท ผู้รับให้เห็น
				if(ptType == 'REFCON'){
					$('.xCNFreezeGiveUser'+tDocumentNubmer+tSeq).html('<?=$this->session->userdata('tSesFirstname')?>');
					//$('.xCNPIKDATE'+tDocumentNubmer+tSeq).attr('disabled',true).css('background','#e6e6e6');
				}else if(ptType == 'REFBUY'){
					$('.xCNFreezeGiveBuyer'+tDocumentNubmer+tSeq).html('<?=$this->session->userdata('tSesFirstname')?>');
					$('.xCNDLIDATE'+tDocumentNubmer+tSeq).attr('disabled',true).css('background','#e6e6e6');
					$('.xCNPUCDATE'+tDocumentNubmer+tSeq).attr('disabled',true).css('background','#e6e6e6');
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert(jqXHR, textStatus, errorThrown);
			}
		});

	}
</script>
