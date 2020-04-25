<?php
	$tLevelUser = $this->session->userdata('tSesUserLevel');
?>

<div class="container-fulid">

	<!--Section บน-->
	<div class="row">
		<div class="col-lg-6 col-md-6"><span class="xCNHeadMenu">ตรวจสอบใบเสนอราคา</span></div>
	</div>

	<!--Section ล่าง-->
	<div class="card" style="margin-top: 10px;">
		<div class="card-body">
			<!--ค้นห่า-->
			<div class="row">

				<!--สาขา-->
				<div class="col-lg-2">
					<?php if($tLevelUser == 'HQ'){ ?>
						<div class="form-group">
							<label> สาขา</label>
							<select class="form-control" id="oetDocBCH" name="oetDocBCH">
								<option value="">สำนักงานใหญ่</option>
								<?php foreach($aBCHList['raItems'] AS $nKey => $aValue){ ?>
									<option value="<?=$aValue['FTBchCode'];?>"><?=$aValue['FTBchName'];?> - (<?=$aValue['FTCmpName'];?>)</option>
								<?php } ?>
							</select>
						</div>
					<?php }else{ ?>
						<div class="form-group">
							<?php $tBCHName = $this->session->userdata('tSesBCHName'); ?>
							<?php $tBCHCode = $this->session->userdata('tSesBCHCode'); ?>
							<label> สาขา</label>
							<input type="text" class="form-control" value="<?=@$tBCHName?>" autocomplete="off" readonly>
							<input type="hidden" id="oetDocBCH" name="oetDocBCH" value="<?=@$tBCHCode?>" autocomplete="off">
						</div>
					<?php } ?>
				</div>

				<!--เลขที่เอกสาร-->
				<div class="col-lg-2">
					<div class="form-group">
						<label>เลขที่เอกสาร</label>
						<input type="text" class="form-control" id="oetDocNumber" name="oetDocNumber" placeholder="กรอกเลขที่เอกสาร" autocomplete="off">
					</div>
				</div>

				<!--สถานะเอกสาร-->
				<div class="col-lg-2">
					<div class="form-group">
					<label>สถานะอนุมัติ</label>
						<select class="form-control" id="oetstaDoc" name="oetstaDoc">
							<option value="">ทั้งหมด</option>
							<option value="1">อนุมัติแล้ว</option>
							<option value="0">ยังไม่อนุมัติ</option>
						</select>
					</div>
				</div>

				<!--สถานะจัดซื้อ-->
				<div class="col-lg-2">
					<div class="form-group">
					<label>สถานะจัดซื้อ</label>
						<select class="form-control" id="oetstaSale" name="oetstaSale">
							<option value="">ทั้งหมด</option>
							<option value="1">จัดซื้อแล้ว</option>
							<option value="">ยังไม่จัดซื้อ</option>
						</select>
					</div>
				</div>

				<!--สถานะจัดส่ง-->
				<div class="col-lg-2">
					<div class="form-group">
						<label>สถานะจัดส่ง</label>
						<select class="form-control" id="oetstaExpress" name="oetstaExpress">
							<option value="">ทั้งหมด</option>
							<option value="1">จัดส่งแล้ว</option>
							<option value="0">ยังไม่จัดส่ง</option>
						</select>
					</div>
				</div>

				<!--ปุ่มค้นหา-->
				<div class="col-lg-2">
					<div class="form-group">
						<label style="color:#FFF;">.</label>
						<button class="xCNButtonSave pull-right" onclick="JSwLoadTableList(1);" style="width: 100%;">กรองข้อมูล</button>
					</div>
				</div>
		

				<div class="col-lg-12">
					<div id="odvContent_Check_PI" class="xCNContent"></div>
				</div>
			</div>
		</div>
	</div>
<div>

<script>
	//หน้าตาราง
	JSwLoadTableList(1);
	function JSwLoadTableList(pnPage){
		$.ajax({
			type	: "POST",
			url		: "r_quotationcheckload",
			data 	: {
						'nPage' 		 : pnPage,
						'BCH'			 : $('#oetDocBCH').val(),
						'DocumentNumber' : $('#oetDocNumber').val(),
						'tStaDoc'		 : $('#oetstaDoc').val(),
						'tStaSale'	 	 : $('#oetstaSale').val(),
						'tStaExpress'	 : $('#oetstaExpress').val(),
					  },
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				$('#odvContent_Check_PI').html(tResult);

				//ซ่อน message
				$('.xCNDialog_Footer').css('display','none');
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert(jqXHR, textStatus, errorThrown);
			}
		});
	}

</script>
