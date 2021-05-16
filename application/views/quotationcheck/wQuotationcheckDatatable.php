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
			width		: 22%;
			right		: 29%;
		}

		.hard_left_Top_Right4{
			position		: absolute;
			width			: 6.5%;
			right			: 22.5%;
			text-align		: left;
			vertical-align	: middle !important;
			text-align		: center;
			padding-top		: 26px !important;
    		padding-bottom	: 26px !important;
		}

		.hard_left_Top_Right2{
			position	: absolute;
			width		: 16%;
			right		: 6.5%;
		}

		.hard_left_Top_Right3{
			position		: absolute;
			width			: 6.5%;
			right			: 0px;
			text-align		: left;
			vertical-align	: middle !important;
			text-align		: center;
			padding-top		: 26px !important;
    		padding-bottom	: 26px !important;
		}

		.xCNFreezeSection1{
			position	: absolute;
			width		: 7.5%;
			text-align	: center;
			right		: 43.5%;
			text-align: left;
			padding-top: 4px !important;
			/* background-color :green; */
		}

		.xCNFreezeSection2{
			position	: absolute;
			width		: 7.5%;
			text-align	: center;
			right		: 36.5%;
			text-align: right;
			padding-top: 4px !important;
			/* background-color :black; */
		}

		.xCNFreezeSection3{
			position	: absolute;
			width		: 8%;
			text-align	: center;
			right		: 29%;
			text-align: left;
			padding-top: 4px !important;
			/* background-color :pink; */
		}

		.xCNFreezeSection4{
			position	: absolute;
			width		: 7.5%;
			text-align	: center;
			right		: 15%;
			text-align: right;
			padding-top: 4px !important;
			/* background-color :yellow; */

		}

		.xCNFreezeSection5{
			position	: absolute;
			width		: 9%;
			text-align	: center;
			right		: 6.4%;
			text-align: right;
			padding-top: 4px !important;
			/* background-color :red; */
		}


		.xCNFreezeGiveUser{
			position		: absolute;
			width			: 6.5%;
			right			: 0px;
		}

		.xCNFreezeGiveBuyer{
			position		: absolute;
			width			: 6.5%;
			right			: 22.5%;
		}

		.hard_left_Sub_Right{
			width		: 44.5%;
			top			: 34px;
			position	: absolute;
			right		: 6.5%;
			display		: table;
		}

		.outer {position:relative}
		.inner {
			overflow-x:scroll;
			overflow-y:visible;
			width:49%;
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

		.xCNDTCancelInput{
			background: #e6e6e6 !important;
		}

		.checkmarkDTInQuotation{
			margin-top: -3px;
		}

		.container-checkbox input:checked ~ .checkmark {
			background-color: #dc3545;
		}

		.container-checkbox .checkmark:after {
			left: 9px;
			top: 4.5px;
			width: 0px;
			height: 10px;
			border: solid white;
			background: #FFF;
			border-width: 1px;
			-webkit-transform: rotate(90deg);
			-ms-transform: rotate(90deg);
			transform: rotate(90deg);
		}

		::-webkit-scrollbar {
			height : 13px;
		}

		.xCNDTCancelStatus{
			/* text-decoration:line-through; */
			color : #ca0303;
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
					<?php if($this->session->userdata("tSesUserGroup") == 1 || $this->session->userdata("tSesUserGroup") == 5){ ?>
						<!--พนักงานจัดซื้อ || พนักงานบัญชี-->
						<th class="xCNThNormal" rowspan="2" style="width:55px; text-align: left; vertical-align: middle;">ยกเลิก</th>
					<?php } ?>
					<th class="xCNThNormal" rowspan="2" style="width:60px; text-align: left; vertical-align: middle;">จำนวน</th>
					<th class="xCNThNormal" rowspan="2" style="width:150px; text-align: left; vertical-align: middle;">หน่วย</th>
					<th class="xCNThNormal" rowspan="2" style="width:200px; text-align: left; vertical-align: middle;">เลขที่เอกสาร</th>
					<th class="xCNThNormal" rowspan="2" style="width:100px; text-align: left; vertical-align: middle;">วันที่เอกสาร</th>
					<th class="xCNThNormal" rowspan="2" style="width:55px; text-align: left; vertical-align: middle;">ลำดับ</th>
					<th class="xCNThNormal" rowspan="2" style="width:270px; text-align: left; vertical-align: middle;">รายการสินค้า</th>
					<th class="xCNThNormal" rowspan="2" style="width:100px; text-align: left; vertical-align: middle;">สถานะเอกสาร</th>
					<th class="xCNBorderleft hard_left_Top_Right1" colspan="2" style="text-align:center;">จัดซื้อสินค้า</th>
					<th class="xCNBorderleft hard_left_Top_Right4" rowspan="2" style="font-size: 1.15vw;">ผู้สั่งซื้อ</th>
					<th class="xCNBorderleft hard_left_Top_Right2" colspan="2" style="text-align:center;">รับสินค้า</th>
					<th class="xCNBorderleft hard_left_Top_Right3" rowspan="2" style="font-size: 1.15vw;">ผู้รับสินค้า</th>
				</tr>
				<tr class="hard_left_Sub_Right">
					<th class="xCNBorderleft" style="text-align:center; width:16.50%; font-size: 1vw;">วันสั่งสินค้า</th>
					<th style="text-align:center; width:16.50%; font-size: 1vw;">วันส่งของ</th>
					<th style="text-align:center; width:17%; font-size: 1vw;">เลขที่บิลขนส่ง</th>
					<th style="text-align:center; width:14.50%;"></th>
					<th class="xCNBorderleft" style="text-align:center; width:15.50%; font-size: 1vw;">วันรับสินค้า</th>
					<th style="text-align:center; font-size: 1vw;">เลขที่ใบสั่งซื้อ</th>
				</tr>
			</thead>
			<tbody>
					<?php if($aList['rtCode'] != 800){ ?>
						<?php foreach($aList['raItems'] AS $nKey => $aValue){ ?>
							<?php $FTPdtStaCancel = $aValue['FTPdtStaCancel'] ?>
							<tr class="<?=@$FTPdtStaCancel == '1' ? 'xCNDTCancel' : ''; ?>" data-documentnumber='<?=$aValue['FTXqhDocNo']?>' data-seqitem='<?=$aValue['FNXqdSeq']?>' data-pdtcode='<?=$aValue['FTPdtCode']?>'>
								<?php if($this->session->userdata("tSesUserGroup") == 1 || $this->session->userdata("tSesUserGroup") == 5){ ?>
									<!--พนักงานจัดซื้อ || พนักงานบัญชี-->
									<td>
										<label class="container-checkbox" style="display: block; margin: 0px auto;">
											<input type="checkbox" name="ocmDTInQuotationCancel" onclick="JSxDTInQuotationCancel(this)" <?=@$FTPdtStaCancel == '1' ? 'checked' : ''; ?>>
											<span class="checkmark checkmarkDTInQuotation"></span>
										</label>
									</td>
								<?php } ?>
								<td class="text-right xCNTextShowQuotation <?=@$FTPdtStaCancel == '1' ? 'xCNDTCancelStatus' : ''; ?>"><?=($aValue['FCXqdQty'] == '') ? '0' : number_format($aValue['FCXqdQty'])?></td>
								<td class="xCNTextShowQuotation <?=@$FTPdtStaCancel == '1' ? 'xCNDTCancelStatus' : ''; ?>"><?=($aValue['FTPunName'] == '') ? '-' : $aValue['FTPunName'] ?></td>
								<td class="xCNTextShowQuotation <?=@$FTPdtStaCancel == '1' ? 'xCNDTCancelStatus' : ''; ?>"><?=$aValue['FTXqhDocNo']?></td>
								<td class="xCNTextShowQuotation <?=@$FTPdtStaCancel == '1' ? 'xCNDTCancelStatus' : ''; ?>"><?=date('d/m/Y',strtotime($aValue['FDXqhDocDate']));?></td>
								<td class="xCNTextShowQuotation <?=@$FTPdtStaCancel == '1' ? 'xCNDTCancelStatus' : ''; ?>"><?=($aValue['FNXqdSeq'] == '') ? 'x' : $aValue['FNXqdSeq']?></td>
								<td class="xCNTextShowQuotation <?=@$FTPdtStaCancel == '1' ? 'xCNDTCancelStatus' : ''; ?>"><?=($aValue['FTPdtName'] == '')? 'ไม่พบสินค้า' : $aValue['FTPdtName'] ?></td>
								<!-- <td class="text-right"><?=number_format($aValue['FCXqdUnitPrice'],2)?></td> -->
								
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
								<td><span class="<?=$tClassStaApv?> xCNStatusDT <?=@$FTPdtStaCancel == '1' ? 'xCNDTCancelStatus' : ''; ?> "><?=$tTextStaApv?></span></td>


								<!--วันที่สั่งสินค้า-->
								<td class="xCNBorderleft xCNFreezeSection1">
									<?php
										if($aValue['FDXqdPucDate'] != '' || $aValue['FDXqdPucDate'] != null){
											$FDXqdPucDate = date('d/m/Y',strtotime($aValue['FDXqdPucDate']));
										}else{
											$FDXqdPucDate = null;
										}
									?>

									<?php
										//ถ้ามีชื่อผู้สั่งซื้อสินค้าเเล้วไม่สามารถเเก้ไขวันที่ได้
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
										<input <?=$tDisabled?> data-docnumber="<?=$aValue['FTXqhDocNo']?>" data-seq='<?=$aValue['FNXqdSeq']?>' data-pdtcode='<?=$aValue['FTPdtCode']?>' 
												onchange="JSxUpdateInline(this,'PUCDATE');" 
												type="text" <?=$tDisabledKey?> 
												<?=@$FTPdtStaCancel == '1' ? 'disabled' : ''; //สินค้ายกเลิก ?>
												maxlength="10" 
												class="<?=$tClassDisabledInput?> xCNEditInline xCNDatePicker xCNPUCDATE<?=$aValue['FTXqhDocNo']?><?=$aValue['FNXqdSeq']?> <?=@$FTPdtStaCancel == '1' ? 'xCNDTCancelInput' : ''; ?>" 
												style="text-align: left; width:100%;" 
												placeholder="<?=$tPlaceholder?>" 
												value="<?=@$FDXqdPucDate?>">
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
										//ถ้ามีชื่อผู้สั่งซื้อสินค้าเเล้วไม่สามารถเเก้ไขวันที่ได้
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
										<input <?=$tDisabled?> data-docnumber="<?=$aValue['FTXqhDocNo']?>" data-seq='<?=$aValue['FNXqdSeq']?>' data-pdtcode='<?=$aValue['FTPdtCode']?>' 
										onchange="JSxUpdateInline(this,'DLIDATE');" 
										type="text" <?=$tDisabledKey?> 
										<?=@$FTPdtStaCancel == '1' ? 'disabled' : ''; //สินค้ายกเลิก ?>
										maxlength="10" 
										class="<?=$tClassDisabledInput?> xCNEditInline xCNDatePicker xCNDLIDATE<?=$aValue['FTXqhDocNo']?><?=$aValue['FNXqdSeq']?> <?=@$FTPdtStaCancel == '1' ? 'xCNDTCancelInput' : ''; ?>" 
										style="text-align: left; width:100%;" 
										placeholder="<?=$tPlaceholder?>" 
										value="<?=@$FDXqdDliDate?>">
									<?php }else{ ?>
										<label style="text-align: center; display: block; margin-top: 5px;"><?=($FDXqdDliDate == null) ? '-' : $FDXqdDliDate?></label>
									<?php } ?>
								</td>

								<!--เลขที่ใบสั่งซื้อ-->
								<td class="xCNFreezeSection3">
									<?php $FTXqdRefBuyer = $aValue['FTXqdRefBuyer']; ?>
									<!--มีสิทธิแก้ไข-->
									<?php if($tPer_edit == ''){ ?>
										<input 
										data-docnumber="<?=$aValue['FTXqhDocNo']?>" data-seq='<?=$aValue['FNXqdSeq']?>' data-pdtcode='<?=$aValue['FTPdtCode']?>' 
										onchange="JSxUpdateInline(this,'REFBUY');" 
										type="text" <?=$tDisabledKey?> 
										<?=@$FTPdtStaCancel == '1' ? 'disabled' : ''; //สินค้ายกเลิก ?>
										maxlength="20" 
										class="xCNEditInline xCNREFBUY<?=$aValue['FTXqhDocNo']?><?=$aValue['FNXqdSeq']?> <?=@$FTPdtStaCancel == '1' ? 'xCNDTCancelInput' : ''; ?>"
										style="text-align: left; width: 100%;" 
										value="<?=@$FTXqdRefBuyer?>">
									<?php }else{ ?>
										<label style="text-align: center; display: block; margin-top: 5px;"><?=($FTXqdRefBuyer == null) ? '-' : $FTXqdRefBuyer?></label>
									<?php } ?>
								</td>

								<!--ผูสั่ง-->
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

									<?php
										//ถ้ามีเลชที่ใบสั่งซื้อ เเล้วไม่สามารถ รับสินค้า
										if($aValue['namebuy'] == '' || $aValue['namebuy'] == null){
											$tDisabled 				= 'disabled';
											$tClassDisabledInput 	= 'xCNClassDisabledInput';
										}else{
											if($aValue['namecon'] == '' || $aValue['namecon'] == null){
												$tDisabled 				= '';
												$tClassDisabledInput 	= '';
											}else{
												$tDisabled 				= 'disabled';
												$tClassDisabledInput 	= 'xCNClassDisabledInput';
											}
										}
									?>

									<!--มีสิทธิแก้ไข-->
									<?php if($tPer_edit == ''){ ?>
										<input <?=$tDisabled?> 
											<?=@$FTPdtStaCancel == '1' ? 'disabled' : ''; //สินค้ายกเลิก ?>
											data-docnumber="<?=$aValue['FTXqhDocNo']?>" 
											data-seq='<?=$aValue['FNXqdSeq']?>' 
											data-pdtcode='<?=$aValue['FTPdtCode']?>' 
											onchange="JSxUpdateInline(this,'PIKDATE');" 
											type="text" <?=$tDisabledKey?> 
											maxlength="10" 
											class="<?=$tClassDisabledInput?> xCNEditInline xCNDatePicker xCNPIKDATE<?=$aValue['FTXqhDocNo']?><?=$aValue['FNXqdSeq']?> <?=@$FTPdtStaCancel == '1' ? 'xCNDTCancelInput' : ''; ?>"
											style="text-align: left; width:100%;" 
											placeholder="<?=$tPlaceholder?>" 
											value="<?=@$FDXqdPikDate?>">
									<?php }else{ ?>
										<label style="text-align: center; display: block; margin-top: 5px;"><?=($FDXqdPikDate == null) ? '-' : $FDXqdDliDate?></label>
									<?php } ?>
								</td>

								<!--เลขที่บิล-->
								<td class="xCNBorderright xCNFreezeSection5">
									<?php $FTXqdRefInv = $aValue['FTXqdRefInv']; ?>

									<?php
										//ถ้ามีเลชที่ใบสั่งซื้อ เเล้วไม่สามารถ รับสินค้า
										if($aValue['namebuy'] == '' || $aValue['namebuy'] == null){
											$tDisabled 				= 'disabled';
											$tClassDisabledInput 	= 'xCNClassDisabledInput';
										}else{
											if($aValue['namecon'] == '' || $aValue['namecon'] == null){
												$tDisabled 				= '';
												$tClassDisabledInput 	= '';
											}else{
												$tDisabled 				= 'disabled';
												$tClassDisabledInput 	= 'xCNClassDisabledInput';
											}
										}
									?>

									<!--มีสิทธิแก้ไข-->
									<?php if($tPer_edit == ''){ ?>
										<input <?=$tDisabled?> 
										<?=@$FTPdtStaCancel == '1' ? 'disabled' : ''; //สินค้ายกเลิก ?>
										data-docnumber="<?=$aValue['FTXqhDocNo']?>" 
										data-seq='<?=$aValue['FNXqdSeq']?>' 
										data-pdtcode='<?=$aValue['FTPdtCode']?>' 
										onchange="JSxUpdateInline(this,'REFCON');" 
										type="text" <?=$tDisabledKey?> 
										maxlength="20" 
										class="<?=$tClassDisabledInput?> xCNEditInline xCNGetBill<?=$aValue['FTXqhDocNo']?><?=$aValue['FNXqdSeq']?> <?=@$FTPdtStaCancel == '1' ? 'xCNDTCancelInput' : ''; ?>" 
										style="text-align: left; width: 100%;" 
										value="<?=@$FTXqdRefInv?>">
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

		// var nHeight = $(window).height() - 310;
		// $('#odvContent_Check_PI').css('height', nHeight + "px");
		// $('#odvContent_Check_PI').css('overflow', 'auto'); 
		// $('#odvContent_Check_PI').css('overflow-x', 'hidden'); 

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
				alert('กรุณาระบุวันสั่งสินค้า และระบุวันส่งของให้เรียบร้อยก่อน !');
				// $(elem).val('');
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
					if(tValue == '' || tValue == null){
						$('.xCNPIKDATE'+tDocumentNubmer+tSeq).attr('disabled',false).css('background','#FFF');
					}else{
						$('.xCNPIKDATE'+tDocumentNubmer+tSeq).attr('disabled',true).css('background','#e6e6e6');
					}

					$('.xCNGetBill'+tDocumentNubmer+tSeq).attr('disabled',true).css('background','#e6e6e6');
				}else if(ptType == 'REFBUY'){
					//กรณีถ้าเป็นค่าว่าง
					if(tValue == '' || tValue == null){
						//จัดซื้อสินค้า : วันที่สั่งสินค้า - วันส่งของ - เลขที่ใบสั่งซื้อ
						$('.xCNFreezeGiveBuyer'+tDocumentNubmer+tSeq).html('-');
						$('.xCNDLIDATE'+tDocumentNubmer+tSeq).attr('disabled',false).css('background','#FFF');
						$('.xCNPUCDATE'+tDocumentNubmer+tSeq).attr('disabled',false).css('background','#FFF');

						//รับสินค้า : วันรับสินค้า - เลขที่บิล
						$('.xCNPIKDATE'+tDocumentNubmer+tSeq).attr('disabled',true).css('background','#e6e6e6');
						$('.xCNGetBill'+tDocumentNubmer+tSeq).attr('disabled',true).css('background','#e6e6e6');
					}else{
						//จัดซื้อสินค้า : วันที่สั่งสินค้า - วันส่งของ - เลขที่ใบสั่งซื้อ
						$('.xCNFreezeGiveBuyer'+tDocumentNubmer+tSeq).html('<?=$this->session->userdata('tSesFirstname')?>');
						$('.xCNDLIDATE'+tDocumentNubmer+tSeq).attr('disabled',true).css('background','#e6e6e6');
						$('.xCNPUCDATE'+tDocumentNubmer+tSeq).attr('disabled',true).css('background','#e6e6e6');

						//รับสินค้า : วันรับสินค้า - เลขที่บิล 
						$('.xCNPIKDATE'+tDocumentNubmer+tSeq).attr('disabled',false).css('background','#FFF');
						$('.xCNGetBill'+tDocumentNubmer+tSeq).attr('disabled',false).css('background','#FFF');
					}
				}


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
			},
			error: function (jqXHR, textStatus, errorThrown) {
				JSxModalErrorCenter(jqXHR.responseText);
			}
		});

	}

	//ยกเลิกสินค้าใน DT
	function JSxDTInQuotationCancel(elem){
		var bCheckCancel 	= $(elem).parent().parent().parent().hasClass('xCNDTCancel');
		var oElem			= $(elem).parent().parent().parent();
		if(bCheckCancel == true){ //เปลี่ยนใจ เอาสินค้าตัวนั้นกลับมาใช้งาน
			var nUpdateCancel	= 0;
			$(oElem).removeClass('xCNDTCancel');
			$(oElem).find('td:eq(7) .xCNStatusDT').removeClass('xCNDTCancelStatus');
			$(oElem).find('.xCNTextShowQuotation').removeClass('xCNDTCancelStatus');

			if(!$(oElem).find('.xCNFreezeSection1 .xCNEditInline').hasClass('xCNClassDisabledInput')){
				$(oElem).find('.xCNFreezeSection1 .xCNEditInline').attr('disabled',false).removeClass('xCNDTCancelInput');
			}

			if(!$(oElem).find('.xCNFreezeSection2 .xCNEditInline').hasClass('xCNClassDisabledInput')){
				$(oElem).find('.xCNFreezeSection2 .xCNEditInline').attr('disabled',false).removeClass('xCNDTCancelInput');
			}

			if(!$(oElem).find('.xCNFreezeSection3 .xCNEditInline').hasClass('xCNClassDisabledInput')){
				$(oElem).find('.xCNFreezeSection3 .xCNEditInline').attr('disabled',false).removeClass('xCNDTCancelInput');
			}

			if(!$(oElem).find('.xCNFreezeSection4 .xCNEditInline').hasClass('xCNClassDisabledInput')){
				$(oElem).find('.xCNFreezeSection4 .xCNEditInline').attr('disabled',false).removeClass('xCNDTCancelInput');
			}
		
			if(!$(oElem).find('.xCNFreezeSection5 .xCNEditInline').hasClass('xCNClassDisabledInput')){
				$(oElem).find('.xCNFreezeSection5 .xCNEditInline').attr('disabled',false).removeClass('xCNDTCancelInput');
			}

		}else{ //กดยกเลิกสินค้าตัวนั้น
			var nUpdateCancel	= 1;
			$(oElem).addClass('xCNDTCancel');
			$(oElem).find('td:eq(7) .xCNStatusDT').addClass('xCNDTCancelStatus');
			$(oElem).find('.xCNTextShowQuotation').addClass('xCNDTCancelStatus');

			if(!$(oElem).find('.xCNFreezeSection1 .xCNEditInline').hasClass('xCNClassDisabledInput')){
				$(oElem).find('.xCNFreezeSection1 .xCNEditInline').attr('disabled',true).addClass('xCNDTCancelInput');
			}

			if(!$(oElem).find('.xCNFreezeSection2 .xCNEditInline').hasClass('xCNClassDisabledInput')){
				$(oElem).find('.xCNFreezeSection2 .xCNEditInline').attr('disabled',true).addClass('xCNDTCancelInput');
			}

			if(!$(oElem).find('.xCNFreezeSection3 .xCNEditInline').hasClass('xCNClassDisabledInput')){
				$(oElem).find('.xCNFreezeSection3 .xCNEditInline').attr('disabled',true).addClass('xCNDTCancelInput');
			}

			if(!$(oElem).find('.xCNFreezeSection4 .xCNEditInline').hasClass('xCNClassDisabledInput')){
				$(oElem).find('.xCNFreezeSection4 .xCNEditInline').attr('disabled',true).addClass('xCNDTCancelInput');
			}
		
			if(!$(oElem).find('.xCNFreezeSection5 .xCNEditInline').hasClass('xCNClassDisabledInput')){
				$(oElem).find('.xCNFreezeSection5 .xCNEditInline').attr('disabled',true).addClass('xCNDTCancelInput');
			}

		}

		var tDocumentnumber = $(oElem).attr('data-documentnumber');
		var nSeqitem 		= $(oElem).attr('data-seqitem');
		var tPdtCode 		= $(oElem).attr('data-pdtcode');

		//ส่งค่าไปอัพเดท flag ใน DT
		$.ajax({
			type	: "POST",
			url		: 'r_quotationupdateDTCancel',
			data 	: {
				'tDocumentnumber'		: tDocumentnumber,
				'nSeqitem' 				: nSeqitem,
				'tPdtCode'				: tPdtCode,
				'nUpdateCancel'			: nUpdateCancel
			},
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				
			},
			error: function (jqXHR, textStatus, errorThrown) {
				JSxModalErrorCenter(jqXHR.responseText);
			}
		});
	}
</script>
