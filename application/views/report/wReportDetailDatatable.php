<table class="table table-striped xCNTableCenter">
  <thead>
    <tr>
		<th style="width:10px; text-align: center;">ลำดับ</th>
		<th style="width:100px; text-align: center;">รูปภาพ</th>
		<th style="text-align: left;">ชื่อ-นามสกุล</th>
		<th style="width:10%; text-align: left;">แผนก</th>
		<th style="width:10%; text-align: left;">ตำแหน่ง</th>
		<th style="width:10%; text-align: left;">กลุ่มสิทธิ์</th>
		<th style="width:10%; text-align: left;">กลุ่มราคา</th>
		<th style="width:10%; text-align: left;">สถานะ</th>
		<th style="width:80px; text-align: center;">ส่งออก</th>
    </tr>
  </thead>
  <tbody>
		<?php if($aDetailList['rtCode'] != 800){ ?>
			<?php foreach($aDetailList['raItems'] AS $nKey => $aValue){ ?>
				<tr>
					<th><?=$aValue['rtRowID']?></th>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>
						<a href="r_reportExcel">
							<img class="img-responsive xCNImageEdit" src="<?=base_url().'application/assets/images/icon/export.png';?>">
						</a>
					</td>
				</tr>
			<?php } ?>
		<?php }else{ ?>
			<tr><td colspan="99" style="text-align: center;"> - ไม่พบข้อมูล - </td></tr>
		<?php } ?>
  </tbody>
</table>

<div class="row">
    <div class="col-md-6">
        <label>พบข้อมูลทั้งหมด <?=$aDetailList['rnAllRow']?> รายการ แสดงหน้า <?=$aDetailList['rnCurrentPage']?> / <?=$aDetailList['rnAllPage']?></label>
    </div>
    <div class="col-md-6">
		<nav>
			<ul class="xCNPagenation pagination justify-content-end">
				<!--ปุ่มย้อนกลับ-->
				<?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
				<li class="page-item <?=$tDisabledLeft;?>">
					<a class="page-link" aria-label="Previous" onclick="JSvUser_ClickPage('previous')"><span aria-hidden="true">&laquo;</span></a>
				</li>

				<!--ปุ่มจำนวนหน้า-->
				<?php for($i=max($nPage-2, 1); $i<=max(0, min($aDetailList['rnAllPage'],$nPage+2)); $i++){?>
					<?php
						if($nPage == $i){
							$tActive 		= 'active';
							$tDisPageNumber = 'disabled';
						}else{
							$tActive 		= '';
							$tDisPageNumber = '';
						}
					?>
					<li class="page-item <?=$tActive;?> " onclick="JSvUser_ClickPage('<?=$i?>')"><a class="page-link"><?=$i?></a></li>
				<?php } ?>

				<!--ปุ่มไปต่อ-->
				<?php if($nPage >= $aDetailList['rnAllPage']){ $tDisabledRight = 'disabled'; }else{ $tDisabledRight = '-'; } ?>
				<li class="page-item <?=$tDisabledRight?>">
					<a class="page-link" aria-label="Next" onclick="JSvUser_ClickPage('next')"><span aria-hidden="true">&raquo;</span></a>
				</li>
			</ul>
		</nav>
    </div>
</div>


<script>
	//เปลี่ยนหน้า
	function JSvUser_ClickPage(ptPage) {
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

	//ส่งออก
	function JSwRPTExport(){
		$.ajax({
			type	: "POST",
			url		: "r_reportExcel",
			data 	: { 'tRptCode' : ptReport , 'tRptName' : ptRptName },
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				JSxModalProgress('close');
				$('.content').html(tResult);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				JSxModalErrorCenter(jqXHR.responseText);
			}
		});
	}
</script>
