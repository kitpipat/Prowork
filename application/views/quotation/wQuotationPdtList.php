
<div class="row">

	<div class="col-lg-12">
		<div class="row">
			<!--เลือกการมองเห็นแบบรูปภาพ-->
			<?php if ($tPdtViewType == 1) { ?>
					<?php if($aPdtList['rtCode'] != 800){ ?>
						<?php foreach($aPdtList['raItems'] AS $nKey => $aValue){ 
									$tPdtCode 		= $aValue['FTPdtCode'];
									$tPdtName 		= $aValue['FTPdtName'];
									$tPunCode 		= $aValue['FTPunCode'];
									$tSplCode 		= $aValue['FTSplCode'];
									$nPdtCost 		= $aValue['FCPdtCostAFDis'];
									$nPdtUnitPri 	= $aValue['FCPdtNetSalPri'];
									$tPunName 		= $aValue['FTPunName'];
									$FTPdtImage   = $aValue['FTPdtImage'];
									$aItemsInfo = array(
										"tPdtCode" 		=> $tPdtCode,
										"tPdtName" 		=> $tPdtName,
										"tPunCode" 		=> $tPunCode,
										"tPunName" 		=> $tPunName,
										"tSplCode" 		=> $tSplCode,
										"nPdtCost" 		=> $nPdtCost,
										"nPdtUnitPri" => $nPdtUnitPri
									);
									$tItemInfo = json_encode($aItemsInfo);
							?>
							<div class="col-sm-3 col-md-3 col-lg-3">
								<div class="xCNImageCardPDT" data-iteminfo='<?=$tItemInfo?>' onclick="FSvQUOAddItemToTemp(this)">

									<?php 
										if(@$FTPdtImage != '' || @$FTPdtImage != null){
											$tPathImage = './application/assets/images/products/'.@$FTPdtImage;
											if (file_exists($tPathImage)){
												$tPathImage = base_url().'application/assets/images/products/'.@$FTPdtImage;
											}else{
												$tPathImage = base_url().'application/assets/images/products/NoImage.png';
											}
										}else{
											$tPathImage = './application/assets/images/products/NoImage.png';
										}
									?>
									<div class="xCNImageItem" style="background-image:url('<?=$tPathImage;?>')" ></div>
									<div class="caption">
										<span class="xCNPIPDTCode"><?=$tPdtCode;?></span>
										<span class="xCNPIPDTName"><?=$tPdtName;?></span>
										<span class="xCNPIPDTPrice">&#3647;<?php echo number_format($nPdtUnitPri, 2); ?></span>
									</div>
								</div>
							</div>
						<?php } ?>
					<?php } else{ ?>
						<div class="col-lg-12">
							<span style="text-align: center; text-align: center; display: block;
    								border: 1px solid #ced4da; padding: 100px; ">- ไม่พบข้อมูล - </span>
						</div>
					<?php } ?>
			<?php } else { ?>
					<!--เลือกการมองเห็นแบบรายการ-->
					<div class="col-lg-12">
						<table class="table table-striped xCNTableCenter">
							<thead>
								<tr>
									<th style="width:20px;">ลำดับ</th>
									<th style="width:100px;">รหัสสินค้า</th>
									<th >ชื่อสินค้า</th>
									<th style="width:250px; text-align: right;">ราคา/หน่วย</th>
									<th style="width:100px; text-align: center;">เลือก</th>
								</tr>
							</thead>
							<tbody>
								<?php if($aPdtList['rtCode'] != 800){ ?>
									<?php foreach($aPdtList['raItems'] AS $nKey => $aValue){ 
												$tPdtCode 		= $aValue['FTPdtCode'];
												$tPdtName 		= $aValue['FTPdtName'];
												$tPunCode 		= $aValue['FTPunCode'];
												$tSplCode 		= $aValue['FTSplCode'];
												$nPdtCost 		= $aValue['FCPdtCostAFDis'];
												$nPdtUnitPri 	= $aValue['FCPdtNetSalPri'];
												$tPunName 		= $aValue['FTPunName'];
												$aItemsInfo 	= array(
													"tPdtCode" 		=> $tPdtCode,
													"tPdtName" 		=> $tPdtName,
													"tPunCode" 		=> $tPunCode,
													"tPunName" 		=> $tPunName,
													"tSplCode" 		=> $tSplCode,
													"nPdtCost" 		=> $nPdtCost,
													"nPdtUnitPri" => $nPdtUnitPri
												);
												$tItemInfo = json_encode($aItemsInfo); ?>
										<tr>
											<th ><?=$aValue['RowID']?></th>
											<td ><?=$tPdtCode;?></td>
											<td style="text-align: left;"><?=$tPdtName;?></td>
											<td style="text-align: right;"><?=number_format($nPdtUnitPri,2);?></td>
											<td><button class="sm-button xCNSelectPDTInPI" data-iteminfo='<?= $tItemInfo ?>' onclick="FSvQUOAddItemToTemp(this)">เลือกสินค้า</button></td>
										</tr>
									<?php } ?>
								<?php }else{ ?>
									<tbody>
										<tr><td colspan="99" style="text-align: center;"> - ไม่พบข้อมูล - </td></tr>
									</tbody>
								<?php } ?>
							</tbody>
						</table>
					</div>
			<?php } ?>
		</div>
	</div>

</div>

<!--หน้าของข้อมูล-->
<?php if($aPdtList['rtCode'] != 800){ ?>
	<div class="row" style="margin-top:10px;">
		<div class="col-md-6">
			<label>พบข้อมูลทั้งหมด <?=$aPdtList['rnAllRow']?> รายการ แสดงหน้า <?=$aPdtList['rnCurrentPage']?> / <?=$aPdtList['rnAllPage']?></label>
		</div>
		<?php if($aPdtList['rnAllPage'] > 1){ ?>
			<div class="col-md-6">
				<nav>
					<ul class="xCNPagenation pagination justify-content-end">
						<!--ปุ่มย้อนกลับ-->
						<?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
						<li class="page-item <?=$tDisabledLeft;?>">
							<a class="page-link" aria-label="Previous" onclick="JSvPI_ClickPage('previous')"><span aria-hidden="true">&laquo;</span></a>
						</li>

						<!--ปุ่มจำนวนหน้า-->
						<?php for($i=max($nPage-2, 1); $i<=max(0, min($aPdtList['rnAllPage'],$nPage+2)); $i++){?>
							<?php 
								if($nPage == $i){ 
									$tActive 		= 'active'; 
									$tDisPageNumber = 'disabled';
								}else{ 
									$tActive 		= '';
									$tDisPageNumber = '';
								}
							?>
							<li class="page-item <?=$tActive;?> " onclick="JSvPI_ClickPage('<?=$i?>')"><a class="page-link"><?=$i?></a></li>
						<?php } ?>

						<!--ปุ่มไปต่อ-->
						<?php if($nPage >= $aPdtList['rnAllPage']){ $tDisabledRight = 'disabled'; }else{ $tDisabledRight = '-'; } ?>
						<li class="page-item <?=$tDisabledRight?>">
							<a class="page-link" aria-label="Next" onclick="JSvPI_ClickPage('next')"><span aria-hidden="true">&raquo;</span></a>
						</li>
					</ul>
				</nav>
			</div>
		<?php } ?>
	</div>
<?php } ?>

<script>
	//เปลี่ยนหน้า
	function JSvPI_ClickPage(ptPage) {
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

		FSvQUOGetPdtList(nPageCurrent);
	}

	//เลือกสินค้า css
	$('.xCNImageCardPDT').on('click', function () {
			var cart = $('#odvQuoItemsList');
			var imgtodrag = $(this).eq(0);
			if (imgtodrag) {
					var imgclone = imgtodrag.clone().offset({
							top: imgtodrag.offset().top,
							left: imgtodrag.offset().left
					}).css({
									'opacity'		: '0.5',
									'position'	: 'absolute',
									'height'		: '200px',
									'width'			: '200px',
									'z-index'		: '100'
					}).appendTo($('body')).animate({
									'top': cart.offset().top,
									'left': cart.offset().left,
									'width': 75,
									'height': 75
					}, 1000, 'easeInOutExpo');
					
					imgclone.animate({
							'width': 0,
							'height': 0
					}, function () {
							$(this).detach()
					});
			}
	});

</script>

