<table class="table table-striped xCNTableCenter">
	<thead>
		<tr>
			<th style="width:10px; text-align: center;">ลำดับ</th>
			<th style="text-align: left;">เลขที่เอกสาร</th>
			<th style="width:130px; text-align: left;">วันที่-เวลาเอกสาร</th>
			<th style="width:130px; text-align: left;">ประเภทชำระ</th>
			<th style="width:150px; text-align: left;">สถานะเอกสาร</th>
			<th style="width:150px; text-align: left;">สถานะอนุมัติ</th>
			<th style="width:150px; text-align: left;">ผู้อนุมัติ</th>
			<th style="width:80px; text-align: center;">ตรวจสอบ</th>
		</tr>
	</thead>
	<tbody>
			<?php if($aHistory['rtCode'] != 800){ ?>
				<?php foreach($aHistory['raItems'] AS $nKey => $aValue){ ?>
					<tr>
						<th><?=$nKey+1?></th>
						<td><?=$aValue['FTXqhDocNo']?></td>
						<td><?=date('d/m/Y',strtotime($aValue['FDXqhDocDate']));?></td>
						
						<!--ประเภทชำระ-->
						<?php 
							if($aValue['FTXqhCshOrCrd'] == 1){
								$tTextCshOrCrd 			= "เงินสด";
							}else{
								$tTextCshOrCrd 			= "เครดิต";
							}
						?>
						<td><?=$tTextCshOrCrd?></td>

						<!--สถานะเอกสาร-->
						<?php 
							if($aValue['FTXqhStaDoc'] == 1){
								$tTextStaDoc 			= "สมบูรณ์";
								$tClassStaDoc 			= 'xCNTextClassStatus_open';
							}else{
								$tTextStaDoc 			= "เอกสารยกเลิก";
								$tClassStaDoc 			= 'xCNTextClassStatus_close';
							}
						?>
						<td><span class="<?=$tClassStaDoc?>"><?=$tTextStaDoc?></span></td>

						<!--สถานะอนุมัติ-->
						<?php 
							if($aValue['FTXqhStaApv'] == 1){
								$tTextStaApv 			= "อนุมัติแล้ว";
								$tClassStaApv 			= 'xCNTextClassStatus_open';
								$tIconClassStaApv 		= 'xCNIconStatus_open';
							}else{
								if($aValue['FTXqhStaDoc'] == 2){
									$tTextStaApv 			= "-";
									$tClassStaApv 			= '';
									$tIconClassStaApv 		= '';
								}else{
									$tTextStaApv 			= "รออนุมัติ";
									$tClassStaApv 			= 'xCNTextClassStatus_close';
									$tIconClassStaApv 		= 'xCNIconStatus_close';
								}
							}
						?>
						<td><div class="<?=$tIconClassStaApv?>"></div><span class="<?=$tClassStaApv?>"><?=$tTextStaApv?></span></td>
						<td><?=($aValue['FTUsrFName'] == '') ? '-' : $aValue['FTUsrFName'];?></td>
						<td><img class="img-responsive xCNImageEdit" src="<?=base_url().'application/assets/images/icon/View201.png';?>" onClick="JSxLoadQutationList('<?=$aValue['FTXqhDocNo']?>');"></td>
					</tr>
				<?php } ?>
			<?php }else{ ?>
				<tr><td colspan="99" style="text-align: center;"> - ไม่พบข้อมูล - </td></tr>
			<?php } ?>
	</tbody>
</table>

<div class="row">
    <div class="col-md-6">
        <label>พบข้อมูลทั้งหมด <?=$aHistory['rnAllRow']?> รายการ แสดงหน้า <?=$aHistory['rnCurrentPage']?> / <?=$aHistory['rnAllPage']?></label>
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
				<?php for($i=max($nPage-2, 1); $i<=max(0, min($aHistory['rnAllPage'],$nPage+2)); $i++){?>
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
				<?php if($nPage >= $aHistory['rnAllPage']){ $tDisabledRight = 'disabled'; }else{ $tDisabledRight = '-'; } ?>
				<li class="page-item <?=$tDisabledRight?>">
					<a class="page-link" aria-label="Next" onclick="JSvPIList_ClickPage('next')"><span aria-hidden="true">&raquo;</span></a>
				</li>
			</ul>
		</nav>
    </div>
</div>

<script>

	//เข้าหน้าแก้ไข ใบเสนอราคา
	function JSxLoadQutationList(ptCode){
		JSxModalProgress('open');
		$.ajax({
			type	: "POST",
			url		: 'r_quotationListPageEdit',
			data 	: { 'ptCode' : ptCode },
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				$('.content').html(tResult);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert(jqXHR, textStatus, errorThrown);
			}
		});
	}

</script>
