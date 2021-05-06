<table class="table table-striped xCNTableCenter">
  <thead>
    <tr>
		<th style="width:20px; text-align: center;">ลำดับ</th>
		<th style="width:150px; text-align: left;">รหัสผู้จำหน่าย</th>
		<th style="text-align: left;">ชื่อผู้จำหน่าย</th>
    </tr>
  </thead>
  <tbody>
		<?php if($aListSupplier['rtCode'] != 800){ ?>
			<?php foreach($aListSupplier['raItems'] AS $nKey => $aValue){ ?>
				<?php $tClassName = "xCNNamePDT".$aValue['FTSplCode']; ?>
				<tr class="xCNClickSupplier xCNSelectPDT <?=$tClassName;?>" 
					data-splname="<?=$aValue['FTSplName']?>"
					data-splcode="<?=$aValue['FTSplCode']?>"
					>
					<th><?=$aValue['rtRowID']?></th>
					<td><?=$aValue['FTSplCode']?></td>
					<td><?=($aValue['FTSplName'] == '' ) ? '-' : $aValue['FTSplName']?></td>
				</tr>
			<?php } ?>
		<?php }else{ ?>
			<tr><td colspan="99" style="text-align: center;"> - ไม่พบข้อมูล - </td></tr>
		<?php } ?>
  </tbody>
</table>

<div class="row">
    <div class="col-md-6">
        <label>พบข้อมูลทั้งหมด <?=$aListSupplier['rnAllRow']?> รายการ แสดงหน้า <?=$aListSupplier['rnCurrentPage']?> / <?=$aListSupplier['rnAllPage']?></label>
    </div>
    <div class="col-md-6">
		<nav>
			<ul class="xCNPagenation pagination justify-content-end">
				<!--ปุ่มย้อนกลับ-->
				<?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
				<li class="page-item <?=$tDisabledLeft;?>">
					<a class="page-link" aria-label="Previous" onclick="JSvSupplier_ClickPage('previous')"><span aria-hidden="true">&laquo;</span></a>
				</li>

				<!--ปุ่มจำนวนหน้า-->
				<?php for($i=max($nPage-2, 1); $i<=max(0, min($aListSupplier['rnAllPage'],$nPage+2)); $i++){?>
					<?php 
						if($nPage == $i){ 
							$tActive 		= 'active'; 
							$tDisPageNumber = 'disabled';
						}else{ 
							$tActive 		= '';
							$tDisPageNumber = '';
						}
					?>
					<li class="page-item <?=$tActive;?> " onclick="JSvSupplier_ClickPage('<?=$i?>')"><a class="page-link"><?=$i?></a></li>
				<?php } ?>

				<!--ปุ่มไปต่อ-->
				<?php if($nPage >= $aListSupplier['rnAllPage']){ $tDisabledRight = 'disabled'; }else{ $tDisabledRight = '-'; } ?>
				<li class="page-item <?=$tDisabledRight?>">
					<a class="page-link" aria-label="Next" onclick="JSvSupplier_ClickPage('next')"><span aria-hidden="true">&raquo;</span></a>
				</li>
			</ul>
		</nav>
    </div>
</div>


<script>

	//เปลี่ยนหน้า
	function JSvSupplier_ClickPage(ptPage) {
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

		JSxSelectSupplier(nPageCurrent);
	}

	//เลือกลูกค้า
	$('.xCNClickSupplier').on('click',function(e){
		var tSplname 		= $(this).data('splname');
		var tSplcode		= $(this).data('splcode');

		$('.xCNClickSupplier').addClass('xCNSelectPDT');
		$('.xCNClickSupplier').removeClass('xCNSelectPDTActive');

		$(this).addClass('xCNSelectPDTActive');
		$(this).removeClass('xCNSelectPDT');

		obj = [];
		obj = [tSplname,tSplcode];
		localStorage.setItem("LocalItemData",obj);
	});
</script>
