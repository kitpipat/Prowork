<div class="container-fulid">
	<div class="row">

		<!--Filter ค้นหาขั้นสูง-->
		<div class="col-lg-3 xCNFilterAdvParent">
			<!--ตัวกรองค้นหา-->
			<div class="xCNFilterSearch xCNFilterBlockHide">
				<div class="row">

					<div class="xCNFilterAdvSub">
						<div class="xCNHeadFilter xCNLineBarFilter"> ตัวกรองค้นหา </div>
					</div>
					
					<div class="xCNFilterAdvSub">
						<div class="xCNSubFilter">
							<!--ยี่ห้อ-->
							<?php if($aFilter_Brand['rtCode'] != 800){ ?>
								<div class="form-group xCNFilterMarginBottom">
									<label><b>ยี่ห้อ</b></label>
									<?php foreach($aFilter_Brand['raItems'] AS $nKey => $aValue){ ?>
										<label class="container-checkbox xCNCheckboxFilter">
											<input class="xCNFilterAdv" type="checkbox" data-filter="PBN" value="<?=$aValue['FTPbnCode']?>"><?=$aValue['FTPbnName']?>
											<span class="checkmark"></span>
										</label>							
									<?php } ?>
								</div>
							<?php } ?> 

							<!--สี-->
							<?php if($aFilter_Color['rtCode'] != 800){ ?>
								<div class="form-group xCNFilterMarginBottom">
									<label><b>สี</b></label>
									<?php foreach($aFilter_Color['raItems'] AS $nKey => $aValue){ ?>
										<label class="container-checkbox xCNCheckboxFilter">
											<input class="xCNFilterAdv" type="checkbox" data-filter="CLR" value="<?=$aValue['FTPClrCode']?>"><?=$aValue['FTPClrName']?>
											<span class="checkmark"></span>
										</label>							
									<?php } ?>
								</div>
							<?php } ?> 

							<!--กลุ่ม-->
							<?php if($aFilter_Group['rtCode'] != 800){ ?>
								<div class="form-group xCNFilterMarginBottom">
									<label><b>กลุ่ม</b></label>
									<?php foreach($aFilter_Group['raItems'] AS $nKey => $aValue){ ?>
										<label class="container-checkbox xCNCheckboxFilter">
											<input class="xCNFilterAdv" type="checkbox" data-filter="PGP" value="<?=$aValue['FTPgpCode']?>"><?=$aValue['FTPgpName']?>
											<span class="checkmark"></span>
										</label>							
									<?php } ?>
								</div>
							<?php } ?> 

							<!--รุ่น-->
							<?php if($aFilter_Modal['rtCode'] != 800){ ?>
								<div class="form-group xCNFilterMarginBottom">
									<label><b>รุ่น</b></label>
									<?php foreach($aFilter_Modal['raItems'] AS $nKey => $aValue){ ?>
										<label class="container-checkbox xCNCheckboxFilter">
											<input class="xCNFilterAdv" type="checkbox" data-filter="MOL" value="<?=$aValue['FTMolCode']?>"><?=$aValue['FTMolName']?>
											<span class="checkmark"></span>
										</label>							
									<?php } ?>
								</div>
							<?php } ?> 

							<!--ขนาด-->
							<?php if($aFilter_Size['rtCode'] != 800){ ?>
								<div class="form-group xCNFilterMarginBottom">
									<label><b>ขนาด</b></label>
									<?php foreach($aFilter_Size['raItems'] AS $nKey => $aValue){ ?>
										<label class="container-checkbox xCNCheckboxFilter">
											<input class="xCNFilterAdv" type="checkbox" data-filter="PZE" value="<?=$aValue['FTPzeCode']?>"><?=$aValue['FTPzeName']?>
											<span class="checkmark"></span>
										</label>							
									<?php } ?>
								</div>
							<?php } ?> 

							<!--ประเภท-->
							<?php if($aFilter_Type['rtCode'] != 800){ ?>
								<div class="form-group xCNFilterMarginBottom">
									<label><b>ประเภท</b></label>
									<?php foreach($aFilter_Type['raItems'] AS $nKey => $aValue){ ?>
										<label class="container-checkbox xCNCheckboxFilter">
											<input class="xCNFilterAdv" type="checkbox" data-filter="PTY" value="<?=$aValue['FTPtyCode']?>"><?=$aValue['FTPtyName']?>
											<span class="checkmark"></span>
										</label>							
									<?php } ?>
								</div>
							<?php } ?>

							<!--หน่วย-->
							<?php if($aFilter_Unit['rtCode'] != 800){ ?>
								<div class="form-group xCNFilterMarginBottom">
									<label><b>หน่วย</b></label>
									<?php foreach($aFilter_Unit['raItems'] AS $nKey => $aValue){ ?>
										<label class="container-checkbox xCNCheckboxFilter">
											<input class="xCNFilterAdv" type="checkbox"  data-filter="PUN" value="<?=$aValue['FTPunCode']?>"><?=$aValue['FTPunName']?>
											<span class="checkmark"></span>
										</label>							
									<?php } ?>
								</div>
							<?php } ?>

							<!--ผู้จำหน่าย-->
							<?php if($aFilter_Spl['rtCode'] != 800){ ?>
								<div class="form-group xCNFilterMarginBottom">
									<label><b>ผู้จำหน่าย</b></label>
									<?php foreach($aFilter_Spl['raItems'] AS $nKey => $aValue){ ?>
										<label class="container-checkbox xCNCheckboxFilter">
											<input class="xCNFilterAdv" type="checkbox" data-filter="SPL" value="<?=$aValue['FTSplCode']?>"><?=$aValue['FTSplName']?>
											<span class="checkmark"></span>
										</label>							
									<?php } ?>
								</div>
							<?php } ?>

						</div>
						<button class="btn btn-outline-success xCNUseFilterAdv" type="button" onclick="JSxPDTFilterAdv();">นำไปใช้</button>
					</div>
				</div>
			</div>
		</div>

		<!--แสดงข้อมูลสินค้า-->
		<div class="col-lg-12 xCNContentProduct">

			<!--Section บน-->
			<div class="row">
				<div class="col-lg-12 col-md-12"><span class="xCNHeadMenu">สร้างใบเสนอราคา</span></div>
			</div>

			<div class="row">

				<div class="col-lg-9 col-md-9 col-sm-9">
					<div class="card">
						<div class="card-body">
							<!--ค้นหา-->
							<div class="row">

								<!-- Input Filter -->
								<div class="col-lg-7 col-md-7 col-sm-7">
									<div class="input-group md-form form-sm form-2 pl-0">
										<input class="form-control my-0 py-1 red-border xCNFormSerach" type="text" placeholder="กรุณากรอกคำที่ต้องการค้นหา" onkeypress="return FSxQUOSearchItem(event,this)">
										<div class="input-group-append">
											<span class="input-group-text red lighten-3" id="basic-text1">
												<i class="fa fa-search" aria-hidden="true"></i>
											</span>
										</div>
									</div>
								</div>
								<!-- End Input Filter -->

								<!--ตัวกรองค้นหาขั้นสูง-->
								<div class="col-lg-1">
									<div class="xCNFilter">
										<i class="fa fa-filter xCNIconFilter" aria-hidden="true"></i>
									</div>
								</div>

								<!-- Gridview Options -->
								<div class="col-lg-4 col-md-4 col-sm-4">
									<div class="btn-group float-right" role="group">
										<button id="odvPdtTableView" data-viewtype="1" class="wxBntPdtVTypeActive xCNSelectMenuTableOrList" onclick="FSvQUOSwitView(1)">
											<i class="fa fa-table xCNIconFilterTableOrList"></i>
										</button>
										<button id="odvPdtListView" data-viewtype="2" class="xCNSelectMenuTableOrList" onclick="FSvQUOSwitView(2)">
											<i class="fa fa-list xCNIconFilterTableOrList"></i>
										</button>
									</div>
								</div>
								<!-- End Gridview Options -->
							</div>

							<!--content-->
							<div class="row xCNQuCategoryList" id="odvQuoPdtList"></div>
						</div>
					</div>
				</div>

				<div class="col-lg-3 col-md-3 col-sm-3">
					<div class="card">
						<div class="card-body">
							<div class="row">

								<div class="col-lg-12">
									<div class="xCNHeadFooterINPDT">
										<span>เอกสาร</span>
									</div>
								</div>

								<div class="col-lg-12">

									<!--รายละเอียดหัวตาราง-->
									<div class="row" id="odvQuoHeader"></div>

									<!-- แสดงรายการสินค้าที่เลือกในใบเสนอราคา -->
									<div class="row" id="odvQuoItemsList"></div><hr>

									<!--สรุปบิล-->
									<div class="row">
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
											<button type="button" class="xCNCalcelImport btn btn-outline-danger pull-right" style="width:100%">ยกเลิก</button>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
											<button type="button" class="xCNButtonSave pull-right" style="width:100%" onclick="FSvQUOCallDocument()">ถัดไป</button>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

<?php include('script/jquotation.php'); ?>
<link rel="stylesheet" href="<?= base_url('application/assets/css/quotation.css') ?>">

<script>
	//คำนวณหน้าจอ
	JSxCalculateWidthFilterAdv();
	function JSxCalculateWidthFilterAdv(){

		//โหลดครั้งเเรก
		var nWidth = $('.xCNFilterAdvParent').width();
		$('.xCNFilterSearch').css('width', nWidth +'px');

		//ทุกครั้งที่กดเมนู
		$('#menuToggle').click(function() {
			var nWidth = $('.xCNFilterAdvParent').width();
			$('.xCNFilterSearch').css('width', nWidth +'px');
		});

		//กำหนดขนาดของตารางค้นหา
		var tHeightContent = $(window).height() - 160;
		$('.xCNSubFilter').css('height',tHeightContent+'px');
	}
	
	$('.xCNFilter').click(function() {
		var tCheck = $('.xCNFilterSearch').hasClass('xCNFilterBlockHide');
		if(tCheck == false){
			//Filter
			$('.xCNFilterSearch').removeClass("xCNFilterBlockShow");
			$('.xCNFilterSearch').addClass("xCNFilterBlockHide");

			//Content
			$('.xCNContentProduct').addClass('xCNUseFilter12');
			$('.xCNContentProduct').addClass('col-lg-12');
		}else{
			//Filter
			$('.xCNFilterSearch').removeClass("xCNFilterBlockHide");
			$('.xCNFilterSearch').addClass("xCNFilterBlockShow");

			//Content
			$('.xCNContentProduct').removeClass('xCNUseFilter12 col-lg-12');
			$('.xCNContentProduct').addClass('col-lg-9');
		}
	});
</script>
