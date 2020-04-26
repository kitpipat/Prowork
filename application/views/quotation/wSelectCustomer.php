<table class="table table-striped xCNTableCenter">
  <thead>
    <tr>
		<th style="width:20px; text-align: center;">ลำดับ</th>
		<th style="width:150px; text-align: left;">รหัสลูกค้า</th>
		<th style="text-align: left;">ชื่อลูกค้า</th>
		<th style="text-align: left;">ชื่อผู้ติดต่อ</th>
		<th style="width:200px; text-align: left;">เบอร์โทร</th>
		<th style="width:200px; text-align: left;">หมายเลขผู้เสียภาษี</th>
    </tr>
  </thead>
  <tbody>
		<?php if($aListCustomer['rtCode'] != 800){ ?>
			<?php foreach($aListCustomer['raItems'] AS $nKey => $aValue){ ?>
				<?php $tClassName = "xCNNamePDT".$aValue['FTCstCode']; ?>
				<tr class="xCNClickCustomer xCNSelectPDT <?=$tClassName;?>" 
					data-cusname="<?=$aValue['FTCstName']?>"
					data-cuscode="<?=$aValue['FTCstCode']?>"
					data-address="<?=$aValue['FTCstAddress']?>"
					data-taxno="<?=$aValue['FTCstTaxNo']?>"
					data-contactname="<?=$aValue['FTCstContactName']?>"
					data-email="<?=$aValue['FTCstEmail']?>"
					data-tel="<?=$aValue['FTCstTel']?>"
					data-fax="<?=$aValue['FTCstFax']?>"
					>
					<th><?=$aValue['rtRowID']?></th>
					<td><?=$aValue['FTCstCode']?></td>
					<td><?=($aValue['FTCstName'] == '' ) ? '-' : $aValue['FTCstName']?></td>
					<td><?=($aValue['FTCstContactName'] == '' ) ? '-' : $aValue['FTCstContactName']?></td>
					<td><?=($aValue['FTCstTel'] == '' ) ? '-' : $aValue['FTCstTel']?></td>
					<td><?=($aValue['FTCstTaxNo'] == '' ) ? '-' : $aValue['FTCstTaxNo']?></td>
				</tr>
			<?php } ?>
		<?php }else{ ?>
			<tr><td colspan="99" style="text-align: center;"> - ไม่พบข้อมูล - </td></tr>
		<?php } ?>
  </tbody>
</table>

<div class="row">
    <div class="col-md-6">
        <label>พบข้อมูลทั้งหมด <?=$aListCustomer['rnAllRow']?> รายการ แสดงหน้า <?=$aListCustomer['rnCurrentPage']?> / <?=$aListCustomer['rnAllPage']?></label>
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
				<?php for($i=max($nPage-2, 1); $i<=max(0, min($aListCustomer['rnAllPage'],$nPage+2)); $i++){?>
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
				<?php if($nPage >= $aListCustomer['rnAllPage']){ $tDisabledRight = 'disabled'; }else{ $tDisabledRight = '-'; } ?>
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

		JSxSelectCustomer(nPageCurrent);
	}

	//เลือกลูกค้า
	$('.xCNClickCustomer').on('click',function(e){
		var tCustomercode 		= $(this).data('cuscode');
		var tCusname			= $(this).data('cusname');
		var tAddress 			= $(this).data('address');
		var tTaxno 				= $(this).data('taxno');
		var tContactname 		= $(this).data('contactname');
		var tEmail 				= $(this).data('email');
		var tTel 				= $(this).data('tel');
		var tFax 				= $(this).data('fax');

		$('.xCNClickCustomer').addClass('xCNSelectPDT');
		$('.xCNClickCustomer').removeClass('xCNSelectPDTActive');

		$(this).addClass('xCNSelectPDTActive');
		$(this).removeClass('xCNSelectPDT');
		obj = [];
		obj = [tCusname,tCustomercode,tAddress,tTaxno,tContactname,tEmail,tTel,tFax];
		localStorage.setItem("LocalItemData",obj);
	});
</script>
