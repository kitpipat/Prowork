<table class="table table-striped xCNTableCenter">
  <thead>
    <tr>
		<th style="width:20px; text-align: center;">ลำดับ</th>
		<th style="width:150px; text-align: left;">รหัสสินค้า</th>
		<th style="text-align: left;">ชื่อสินค้า</th>
		<th style="width:200px; text-align: left;">กลุ่มสินค้า</th>
		<th style="width:200px; text-align: left;">ผู้จำหน่าย</th>
    </tr>
  </thead>
  <tbody>
		<?php if($aListPDT['rtCode'] != 800){ ?>
			<?php foreach($aListPDT['raItems'] AS $nKey => $aValue){ ?>
				<?php $tClassName = "xCNNamePDT".$aValue['FTPdtCode']; ?>
				<tr class="xCNClickPDT xCNSelectPDT <?=$tClassName;?>" data-pdtcode="<?=$aValue['FTPdtCode']?>">
					<th><?=$aValue['rtRowID']?></th>
					<td><?=$aValue['FTPdtCode']?></td>
					<td><?=$aValue['FTPdtName']?></td>
					<td><?=$aValue['FTPgpName']?></td>
					<td><?=$aValue['FTSplName']?></td>
				</tr>
			<?php } ?>
		<?php }else{ ?>
			<tr><td colspan="99" style="text-align: center;"> - ไม่พบข้อมูล - </td></tr>
		<?php } ?>
  </tbody>
</table>

<div class="row">
    <div class="col-md-6">
        <label>พบข้อมูลทั้งหมด <?=$aListPDT['rnAllRow']?> รายการ แสดงหน้า <?=$aListPDT['rnCurrentPage']?> / <?=$aListPDT['rnAllPage']?></label>
    </div>
    <div class="col-md-6">
		<nav>
			<ul class="xCNPagenation pagination justify-content-end">
				<!--ปุ่มย้อนกลับ-->
				<?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
				<li class="page-item <?=$tDisabledLeft;?>">
					<a class="page-link" aria-label="Previous" onclick="JSvAJPPDT_ClickPage('previous')"><span aria-hidden="true">&laquo;</span></a>
				</li>

				<!--ปุ่มจำนวนหน้า-->
				<?php for($i=max($nPage-2, 1); $i<=max(0, min($aListPDT['rnAllPage'],$nPage+2)); $i++){?>
					<?php 
						if($nPage == $i){ 
							$tActive 		= 'active'; 
							$tDisPageNumber = 'disabled';
						}else{ 
							$tActive 		= '';
							$tDisPageNumber = '';
						}
					?>
					<li class="page-item <?=$tActive;?> " onclick="JSvAJPPDT_ClickPage('<?=$i?>')"><a class="page-link"><?=$i?></a></li>
				<?php } ?>

				<!--ปุ่มไปต่อ-->
				<?php if($nPage >= $aListPDT['rnAllPage']){ $tDisabledRight = 'disabled'; }else{ $tDisabledRight = '-'; } ?>
				<li class="page-item <?=$tDisabledRight?>">
					<a class="page-link" aria-label="Next" onclick="JSvAJPPDT_ClickPage('next')"><span aria-hidden="true">&raquo;</span></a>
				</li>
			</ul>
		</nav>
    </div>
</div>


<script>

	//สินค้าที่เคยเลือกไว้จะถูก hightlight
	var LocalItemSelect = localStorage.getItem("LocalItemData");
	if(LocalItemSelect !== null){
		var aSplitItemSlect = LocalItemSelect.split(",");
		for(var i=0; i<aSplitItemSlect.length; i++){
			if(aSplitItemSlect[i] != ''){
				$('.xCNNamePDT'+aSplitItemSlect[i]).addClass('xCNSelectPDTActive');
				$('.xCNNamePDT'+aSplitItemSlect[i]).removeClass('xCNSelectPDT');
			}
		}
	}

	//เปลี่ยนหน้า
	function JSvAJPPDT_ClickPage(ptPage) {
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

		JSxSelectPDTToTmp(nPageCurrent);
	}

	//เลือกสินค้า
	$('.xCNClickPDT').on('click',function(e){
		var tCheckClassActive 	= $(this).hasClass('xCNSelectPDTActive');
		var tValuePDT 			= $(this).data('pdtcode');
		if(tCheckClassActive == true){
			$(this).removeClass('xCNSelectPDTActive');
			$(this).addClass('xCNSelectPDT');
			var tStaType = 'remove';
		}else{
			$(this).addClass('xCNSelectPDTActive');
			$(this).removeClass('xCNSelectPDT');
			var tStaType = 'add';
		}

		if(tStaType == 'add'){
			obj.push(tValuePDT);
		}else{
			obj = [];
			var LocalItemData = localStorage.getItem("LocalItemData");
			if(LocalItemData !== null){
				var tItemInLocal  = LocalItemData;
				var tResult       = tItemInLocal.replace(tValuePDT, "");
				var aResult 	  = tResult.split(",");
				for(var i=0; i<aResult.length; i++){
					if(aResult[i] != ''){
						obj.push(aResult[i]);
					}
				}
			}
		}

		localStorage.setItem("LocalItemData",obj);
	});
</script>
