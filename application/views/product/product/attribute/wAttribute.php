<style>
	.xCNSelectAttribute{
		cursor: pointer;
		border-bottom: 1px solid #ffffff;
	}

	.xCNSelectAttributeActive{
		background : #51c448 !important;
		color : #FFF;
		border-bottom: 1px solid #ffffff;
		cursor: pointer;
	}

	.xCNSelectAttribute:hover{
		background : #bafdb65c !important;

	}
</style>

<?php 
	switch ($tName) {
		case "brand":
			$tTHCode 	= "รหัสยี่ห้อ";
			$tTHName 	= "ชื่อยี่ห้อ";
			$tFiledCode = "FTPbnCode";
			$tFiledName = "FTPbnName";
			break;
		case "color":
			$tTHCode 	= "รหัสสีสินค้า";
			$tTHName 	= "ชื่อสีสินค้า";
			$tFiledCode = "FTPClrCode";
			$tFiledName = "FTPClrName";
			break;
		case "group":
			$tTHCode 	= "รหัสกลุ่มสินค้า";
			$tTHName 	= "ชื่อกลุ่มสินค้า";
			$tFiledCode = "FTPgpCode";
			$tFiledName = "FTPgpName";
			break;
		case "modal":
			$tTHCode 	= "รหัสรุ่น";
			$tTHName 	= "ชื่อรุ่น";
			$tFiledCode = "FTMolCode";
			$tFiledName = "FTMolName";
			break;
		case "size":
			$tTHCode 	= "รหัสขนาด";
			$tTHName 	= "ชื่อขนาด";
			$tFiledCode = "FTPzeCode";
			$tFiledName = "FTPzeName";
			break;
		case "unit":
			$tTHCode 	= "รหัสหน่วย";
			$tTHName 	= "ชื่อหน่วย";
			$tFiledCode = "FTPunCode";
			$tFiledName = "FTPunName";
			break;
		case "type":
			$tTHCode 	= "รหัสประเภท";
			$tTHName 	= "ชื่อประเภท";
			$tFiledCode = "FTPtyCode";
			$tFiledName = "FTPtyName";
			break;
		case "spl":
			$tTHCode 	= "รหัสผู้จำหน่าย";
			$tTHName 	= "ชื่อผู้จำหน่าย";
			$tFiledCode = "FTSplCode";
			$tFiledName = "FTSplName";
			break;
		default:
			$tTable 	= "";
			$tOrderBy 	= "";
	}
?>


<table class="table table-striped xCNTableCenter">
  <thead>
    <tr>
		<th style="width:20px; text-align: center;">ลำดับ</th>
		<th style="width:150px; text-align: left;"><?=$tTHCode?></th>
		<th style="text-align: left;"><?=$tTHName?></th>
    </tr>
  </thead>
  <tbody>
		<?php if($aListItem['rtCode'] != 800){ ?>
			<?php foreach($aListItem['raItems'] AS $nKey => $aValue){ ?>
				<?php $tClassName = "xCNNameAttr".$aValue[$tFiledCode]; ?>
				<tr class="xCNClickAttribute xCNSelectAttribute <?=$tClassName;?>" data-valuename="<?=$aValue[$tFiledName]?>" data-valuecode="<?=$aValue[$tFiledCode]?>">
					<th><?=$aValue['rtRowID']?></th>
					<td><?=$aValue[$tFiledCode]?></td>
					<td><?=($aValue[$tFiledName] == '' ) ? '-' : $aValue[$tFiledName]?></td>
				</tr>
			<?php } ?>
		<?php }else{ ?>
			<tr><td colspan="99" style="text-align: center;"> - ไม่พบข้อมูล - </td></tr>
		<?php } ?>
  </tbody>
</table>

<div class="row">
    <div class="col-md-6">
        <label>พบข้อมูลทั้งหมด <?=$aListItem['rnAllRow']?> รายการ แสดงหน้า <?=$aListItem['rnCurrentPage']?> / <?=$aListItem['rnAllPage']?></label>
    </div>
    <div class="col-md-6">
		<nav>
			<ul class="xCNPagenation pagination justify-content-end">
				<!--ปุ่มย้อนกลับ-->
				<?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
				<li class="page-item <?=$tDisabledLeft;?>">
					<a class="page-link" aria-label="Previous" onclick="JSvCustomer_ClickPage('previous')"><span aria-hidden="true">&laquo;</span></a>
				</li>

				<!--ปุ่มจำนวนหน้า-->
				<?php for($i=max($nPage-2, 1); $i<=max(0, min($aListItem['rnAllPage'],$nPage+2)); $i++){?>
					<?php 
						if($nPage == $i){ 
							$tActive 		= 'active'; 
							$tDisPageNumber = 'disabled';
						}else{ 
							$tActive 		= '';
							$tDisPageNumber = '';
						}
					?>
					<li class="page-item <?=$tActive;?> " onclick="JSvCustomer_ClickPage('<?=$i?>')"><a class="page-link"><?=$i?></a></li>
				<?php } ?>

				<!--ปุ่มไปต่อ-->
				<?php if($nPage >= $aListItem['rnAllPage']){ $tDisabledRight = 'disabled'; }else{ $tDisabledRight = '-'; } ?>
				<li class="page-item <?=$tDisabledRight?>">
					<a class="page-link" aria-label="Next" onclick="JSvCustomer_ClickPage('next')"><span aria-hidden="true">&raquo;</span></a>
				</li>
			</ul>
		</nav>
    </div>
</div>


<script>

	//เปลี่ยนหน้า
	function JSvCustomer_ClickPage(ptPage) {
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

		JSxSelectAttribute(nPageCurrent);
	}

	//เลือกลูกค้า
	$('.xCNClickAttribute').on('click',function(e){
		var tvaluecode 		= $(this).data('valuecode');
		var tvaluename		= $(this).data('valuename');

		$('.xCNClickAttribute').addClass('xCNSelectAttribute');
		$('.xCNClickAttribute').removeClass('xCNSelectAttributeActive');

		$(this).addClass('xCNSelectAttributeActive');
		$(this).removeClass('xCNSelectAttribute');

		objAttr = [];
		objAttr = [tvaluecode+'##'+tvaluename];
		localStorage.setItem("LocalItemDataAttr",objAttr);
	});
</script>
