<style>
	.FontColorClick{
		text-decoration	: underline;
		cursor			: pointer;
		color			: #43ac3a;
	}
</style>
<?php
	$aPermission = FCNaPERGetPermissionByPage('r_quotationList');
	$aPermission = $aPermission[0];
	if($aPermission['P_read'] != 1){ 		$tPer_read 		= 'xCNHide'; }else{ $tPer_read = ''; }
	if($aPermission['P_create'] != 1){ 		$tPer_create 	= 'xCNHide'; }else{ $tPer_create = ''; }
	if($aPermission['P_delete'] != 1){ 		$tPer_delete 	= 'xCNHide'; }else{ $tPer_delete = ''; }
	if($aPermission['P_edit'] != 1){ 		$tPer_edit 		= 'xCNHide'; }else{ $tPer_edit = ''; }
	if($aPermission['P_cancel'] != 1){ 		$tPer_cancle 	= 'xCNHide'; }else{ $tPer_cancle = ''; }
	if($aPermission['P_approved'] != 1){ 	$tPer_approved 	= 'xCNHide'; }else{ $tPer_approved = ''; }
	if($aPermission['P_print'] != 1){ 		$tPer_print 	= 'xCNHide'; }else{ $tPer_print = ''; }
?>

<div class="container-fulid">
	<div class="row">

		<!--Filter ค้นหาขั้นสูง-->
		<div class="col-lg-2 xCNFilterAdvParent">
			<!--ตัวกรองค้นหา-->
			<div class="xCNFilterSearch xCNFilterBlockHide">
				<div class="row">

					<div class="xCNFilterAdvSub">
						<div class="xCNHeadFilter xCNLineBarFilter" style="width:80%;"> ตัวกรองค้นหา </div>
						<div class="xCNHeadFilter xCNLineBarFilter xCNCloseAdv" style="width:20%;">
							<?php $tIconClose = base_url().'application/assets/images/icon/close.png'; ?>
							<img class="menu-icon xCNMenuSearch" src="<?=$tIconClose?>">
						</div>

					</div>

					<div class="xCNFilterAdvSub">
						<div class="xCNSubFilter">
							<!--ยี่ห้อ-->
							<?php if($aFilter_Brand['rtCode'] != 800){ ?>
								<div class="form-group xCNFilterMarginBottom">
									<label class="xCNFindClick FontColorClick" data-find="Brand"><b>ยี่ห้อ</b></label>
									<div class="xCNFindBrand xCNFindFilter" style="display:none;">
										<?php foreach($aFilter_Brand['raItems'] AS $nKey => $aValue){ ?>
											<label class="container-checkbox xCNCheckboxFilter" >
												<input class="xCNFilterAdv xCNFilterAdvBrand" type="checkbox" data-filter="PBN" value="<?=$aValue['FTPbnCode']?>"><?=$aValue['FTPbnName']?>
												<span class="checkmark"></span>
											</label>
										<?php } ?>
									</div>
								</div>
							<?php } ?>

							<!--กลุ่ม-->
							<?php if($aFilter_Group['rtCode'] != 800){ ?>
								<div class="form-group xCNFilterMarginBottom">
									<label class="xCNFindClick FontColorClick" data-find="Group" onclick="JSxClickGroupSearchspecial()"><b>กลุ่ม</b></label>
									<div class="xCNFindGroup xCNFindFilter" style="display:none;">
										<?php foreach($aFilter_Group['raItems'] AS $nKey => $aValue){ ?>
											<label class="container-checkbox xCNCheckboxFilter">
												<input class="xCNFilterAdv xCNFilterAdvGroup" type="checkbox" data-filter="PGP" value="<?=$aValue['FTPgpCode']?>"><?=$aValue['FTPgpName']?>
												<span class="checkmark"></span>
											</label>
										<?php } ?>
									</div>
								</div>
							<?php } ?>

							<!--รุ่น-->
							<?php if($aFilter_Modal['rtCode'] != 800){ ?>
								<div class="form-group xCNFilterMarginBottom">
									<label class="xCNFindClick FontColorClick" data-find="Modal" onclick="JSxClickGroupSearchspecialFindModal()"><b>รุ่น</b></label>
									<div class="xCNFindModal xCNFindFilter" style="display:none;">
										<?php foreach($aFilter_Modal['raItems'] AS $nKey => $aValue){ ?>
											<label class="container-checkbox xCNCheckboxFilter">
												<input class="xCNFilterAdv" type="checkbox" data-filter="MOL" value="<?=$aValue['FTMolCode']?>"><?=$aValue['FTMolName']?>
												<span class="checkmark"></span>
											</label>
										<?php } ?>
									</div>
								</div>
							<?php } ?>

							<!--สี-->
							<?php if($aFilter_Color['rtCode'] != 800){ ?>
								<div class="form-group xCNFilterMarginBottom">
									<label class="xCNFindClick FontColorClick" data-find="Color"><b>สี</b></label>
									<div class="xCNFindColor xCNFindFilter" style="display:none;">
										<?php foreach($aFilter_Color['raItems'] AS $nKey => $aValue){ ?>
											<label class="container-checkbox xCNCheckboxFilter">
												<input class="xCNFilterAdv" type="checkbox" data-filter="CLR" value="<?=$aValue['FTPClrCode']?>"><?=$aValue['FTPClrName']?>
												<span class="checkmark"></span>
											</label>
										<?php } ?>
									</div>
								</div>
							<?php } ?>

							<!--ขนาด-->
							<?php if($aFilter_Size['rtCode'] != 800){ ?>
								<div class="form-group xCNFilterMarginBottom">
									<label class="xCNFindClick FontColorClick" data-find="Size"><b>ขนาด</b></label>
									<div class="xCNFindSize xCNFindFilter" style="display:none;">
										<?php foreach($aFilter_Size['raItems'] AS $nKey => $aValue){ ?>
											<label class="container-checkbox xCNCheckboxFilter">
												<input class="xCNFilterAdv" type="checkbox" data-filter="PZE" value="<?=$aValue['FTPzeCode']?>"><?=$aValue['FTPzeName']?>
												<span class="checkmark"></span>
											</label>
										<?php } ?>
									</div>
								</div>
							<?php } ?>

							<!--ประเภท-->
							<?php if($aFilter_Type['rtCode'] != 800){ ?>
								<div class="form-group xCNFilterMarginBottom">
									<label class="xCNFindClick FontColorClick" data-find="Type"><b>ประเภท</b></label>
									<div class="xCNFindType xCNFindFilter" style="display:none;">
										<?php foreach($aFilter_Type['raItems'] AS $nKey => $aValue){ ?>
											<label class="container-checkbox xCNCheckboxFilter">
												<input class="xCNFilterAdv" type="checkbox" data-filter="PTY" value="<?=$aValue['FTPtyCode']?>"><?=$aValue['FTPtyName']?>
												<span class="checkmark"></span>
											</label>
										<?php } ?>
									</div>
								</div>
							<?php } ?>

							<!--หน่วย-->
							<?php if($aFilter_Unit['rtCode'] != 800){ ?>
								<div class="form-group xCNFilterMarginBottom">
									<label class="xCNFindClick FontColorClick" data-find="Unit"><b>หน่วย</b></label>
									<div class="xCNFindUnit xCNFindFilter" style="display:none;">
										<?php foreach($aFilter_Unit['raItems'] AS $nKey => $aValue){ ?>
											<label class="container-checkbox xCNCheckboxFilter">
												<input class="xCNFilterAdv" type="checkbox"  data-filter="PUN" value="<?=$aValue['FTPunCode']?>"><?=$aValue['FTPunName']?>
												<span class="checkmark"></span>
											</label>
										<?php } ?>
									</div>
								</div>
							<?php } ?>

							<!--ผู้จำหน่าย-->
							<?php if($aFilter_Spl['rtCode'] != 800){ ?>
								<!-- <div class="form-group xCNFilterMarginBottom">
									<label><b>ผู้จำหน่าย</b></label>
									<?php //foreach($aFilter_Spl['raItems'] AS $nKey => $aValue){ ?>
										<label class="container-checkbox xCNCheckboxFilter">
											<input class="xCNFilterAdv" type="checkbox" data-filter="SPL" value="<?//=$aValue['FTSplCode']?>"><?//=$aValue['FTSplName']?>
											<span class="checkmark"></span>
										</label>
									<?php //} ?>
								</div> -->
							<?php } ?>

						</div>
						<button class="btn btn-outline-success xCNUseFilterAdv" type="button" onclick="JSxPDTFilterAdv(1);">นำไปใช้</button>
						<button class="btn btn-outline-danger xCNUseFilterAdv" type="button" onclick="JSxPDTRemoveFilterAdv(1);">ล้างตัวกรองขั้นสูง</button>
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

				<div class="col-lg-9 col-md-9 col-sm-9" id="odvItem">
					<div class="card">
						<div class="card-body">
							<!--ค้นหา-->
							<div class="row">

								<!-- Input Filter -->
								<div class="col-lg-7 col-md-7 col-sm-7">
									<div class="input-group md-form form-sm form-2 pl-0">
										<input class="form-control my-0 py-1 red-border xCNFormSerach" type="text" placeholder="กรุณากรอกคำที่ต้องการค้นหา เช่น รหัส/ชื่อสินค้า" id="oetSearchPI" onkeypress="Javascript:if(event.keyCode==13) JSxPDTFilterAdv(1)">
										<div class="input-group-append">
											<span class="input-group-text red lighten-3" style="cursor:pointer;" onclick="JSxPDTFilterAdv(1);">
												<?php $tMenuBar = base_url().'application/assets/images/icon/search.png'; ?>
												<img class="menu-icon xCNMenuSearch" src="<?=$tMenuBar?>">
											</span>
										</div>
									</div>
								</div>
								<!-- End Input Filter -->

								<!--ตัวกรองค้นหาขั้นสูง-->
								<div class="col-lg-1">
									<div class="xCNFilter">
										<?php $tIconfilter = base_url().'application/assets/images/icon/filterNew.png'; ?>
										<img class="menu-icon xCNMenuSearch xCNIconFilter" src="<?=$tIconfilter?>">
									</div>
								</div>

								<!-- Gridview Options -->
								<div class="col-lg-4 col-md-4 col-sm-4">
									<div class="btn-group float-right" role="group">
										<button id="odvPdtTableView" data-viewtype="1" class="wxBntPdtVTypeActive xCNSelectMenuTableOrList" onclick="FSvQUOSwitView(1)">
											<?php $tIconfilter = base_url().'application/assets/images/icon/find_Table.png'; ?>
											<img class="menu-icon xCNMenuSearch xCNIconFilter" src="<?=$tIconfilter?>">
										</button>
										<button id="odvPdtListView" data-viewtype="2" class="xCNSelectMenuTableOrList" onclick="FSvQUOSwitView(2)">
											<?php $tIconfilter = base_url().'application/assets/images/icon/find_List.png'; ?>
											<img class="menu-icon xCNMenuSearch xCNIconFilter" src="<?=$tIconfilter?>">
										</button>
									</div>
								</div>
								<!-- End Gridview Options -->
							</div>

							<!--content-->
							<div class="xCNQuCategoryList" id="odvQuoPdtList"></div>
						</div>
					</div>
				</div>

				<div class="col-lg-3 col-md-3 col-sm-3" id="odvResultBill">
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
										<?php
											//ไม่อนุญาติให้สร้าง
											if($tPer_create == ''){
												$tClassRow = "col-lg-6 col-md-6 col-sm-6 col-xs-6";
											}else{
												$tClassRow = "col-lg-12 col-md-12 col-sm-12 col-xs-12";
											}
										?>

										<div class="<?=$tClassRow?>">
											<button type="button" class="xCNCalcelImport btn btn-outline-danger pull-right" onclick="FSvQUOCancleDocumentItem()" style="width:100%; margin-right:0px !important;">ยกเลิก</button>
										</div>

										<?php if($tPer_create == ''){ ?>
											<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
												<button type="button" class="xCNButtonSave pull-right" style="width:100%" onclick="FSvQUOCallDocument()">ถัดไป</button>
											</div>
										<?php } ?>
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

<!--Modal ยกเลิกการทำรายการ-->
<button id="obtModalCancleDocumentItem" style="display:none;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#odvModalCancleDocumentItem"></button>
<div class="modal fade" id="odvModalCancleDocumentItem" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">ยกเลิกการทำรายการ</h5>
			</div>
			<div class="modal-body">
				<label style="text-align: left; display: block;">สินค้าทั้งหมดจะถูกยกเลิก และทำรายการใหม่อีกครั้ง คุณต้องการที่จะยกเลิกการทำรายการหรือไม่?</label>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary xCNCloseDelete" data-dismiss="modal" style="width: 100px;">ปิด</button>
				<button type="button" class="btn btn-danger xCNConfirmDelete xCNConfirmCancleDocument">ยืนยัน</button>
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
		var tHeightContent = $(window).height() - 210;
		$('.xCNSubFilter').css('height',tHeightContent+'px');
	}

	//กดให้โชว์ช่องค้นหา
	$('.xCNFindClick').click(function(e) {
		$('.xCNFindFilter').hide("fast");

		var tTextFind = $(this).data('find');
		var tTextOpenFilter = $(this).hasClass('openFilter');
		if(tTextOpenFilter == true){
			$('.xCNFind' + tTextFind).parent().find('.xCNFindClick').removeClass('openFilter');
			$('.xCNFind' + tTextFind).hide("fast");
		}else{
			$('.xCNFindFilter').parent().find('.xCNFindClick').removeClass('openFilter');
			$('.xCNFind' + tTextFind).parent().find('.xCNFindClick').addClass('openFilter');
			$('.xCNFind' + tTextFind).toggle('fast');
		}
	});

	$('.xCNFilter , .xCNCloseAdv').click(function() {
		var tCheck = $('.xCNFilterSearch').hasClass('xCNFilterBlockHide');
		if(tCheck == false){
			//Filter
			$('.xCNFilterSearch').removeClass("xCNFilterBlockShow");
			$('.xCNFilterSearch').addClass("xCNFilterBlockHide");

			//Content
			$('.xCNContentProduct').addClass('xCNUseFilter12');
			$('.xCNContentProduct').addClass('col-lg-12');

			//หน้าต่างสินค้า
			$('#odvItem').removeClass('col-lg-8').addClass('col-lg-9');

			//หน้าต่างสรุปบิล
			$('#odvResultBill').removeClass('col-lg-3').addClass('col-lg-3');
			$('#odvQuoPdtList').css('overflow-x','hidden');
			$('#odvContentScroll').css('min-width','0px');
		}else{
			//Filter
			$('.xCNFilterSearch').removeClass("xCNFilterBlockHide");
			$('.xCNFilterSearch').addClass("xCNFilterBlockShow");

			//Content
			$('.xCNContentProduct').removeClass('xCNUseFilter12 col-lg-12');
			$('.xCNContentProduct').addClass('col-lg-10');

			//หน้าต่างสินค้า
			$('#odvItem').removeClass('col-lg-9').addClass('col-lg-9');

			//หน้าต่างสรุปบิล
			$('#odvResultBill').removeClass('col-lg-3').addClass('col-lg-3');
			$('#odvQuoPdtList').css('overflow-x','auto');
			$('#odvContentScroll').css('min-width','1100px');

		}
	});

	//กดนำไปใช้ หรือ ค้นหาขั้นสูง
	var aFilter 		= [];
	function JSxPDTFilterAdv(nPage){
		$('.xCNFilterAdv:checked').each(function() {
			var tFilter 	= $(this).data('filter');
			var tValue 		= $(this).val();
			aFilter.push({'tFilter' : tFilter , 'tValue' : tValue});
		});

		var aFilterAdv = aFilter;
		FSvQUOGetPdtList(nPage,aFilterAdv)
		aFilter = [];
	}

	//กดล้างตัวกรองขั้นสูง
	function JSxPDTRemoveFilterAdv(nPage){
		$(".xCNFilterAdv").prop("checked", false);
		aFilterBrand = [];
		aFilterGroup = [];
		FSvQUOGetPdtList(nPage,'');

		$('.xCNFindBrand').hide();
		$('.xCNFindColor').hide();
		$('.xCNFindModal').hide();
		$('.xCNFindSize').hide();
		$('.xCNFindType').hide();
		$('.xCNFindUnit').hide();
		$('.xCNFindGroup').hide();
	}

	//กดยกเลิก
	function FSvQUOCancleDocumentItem(){
		$('#obtModalCancleDocumentItem').click();

		$('.xCNConfirmCancleDocument').off();
		$('.xCNConfirmCancleDocument').on("click",function(){
			$.ajax({
				type	: "POST",
				url		: 'r_quotation/1',
				cache	: false,
				timeout	: 0,
				success	: function(tResult) {
					$('#obtModalCancleDocumentItem').click();

					setTimeout(function(){
						$('.content').html(tResult);
					}, 500);
				},
				error: function(jqXHR, textStatus, errorThrown) {
					JSxModalErrorCenter(jqXHR.responseText);
				}
			});
		});
	}

	//กดที่กลุ่ม
	var aFilterBrand 		= [];
	function JSxClickGroupSearchspecial(){
		if(!$('.xCNFindGroup').is(':visible')){ //ถ้าปิดอยู่

			aFilterBrand = [];
			$('.xCNFilterAdvBrand:checked').each(function() {
				var tValue 		= $(this).val();
				aFilterBrand.push({'tFilter' : 'Brand' , 'tValue' : tValue});
			});	

			if(aFilterBrand.length > 0){ //ถ้ามีการเลือกยี่ห้อใหม่ต้องโหลดใหม่ 

				$.ajax({
					type	: "POST",
					url		: 'r_searchProductFromBrand',
					data	: { 'data' : aFilterBrand },
					cache	: false,
					timeout	: 0,
					success	: function(oResult) {
						var jResult = JSON.parse(oResult);
						if(jResult.rtCode == '800'){
							$('.xCNFindGroup').html('');
							$('.xCNFindGroup').append('- ไม่พบข้อมูล -');
						}else{
							var aItem	= jResult.raItems;
							var tHTML	= '';
							for(var i=0; i<aItem.length; i++){
								tHTML += '<label class="container-checkbox xCNCheckboxFilter">';
								tHTML += '<input class="xCNFilterAdv xCNFilterAdvGroup" type="checkbox" data-filter="PGP" value="'+aItem[i].FTPgpCode+'">'+aItem[i].FTPgpName+'';
								tHTML += '<span class="checkmark"></span>';
								tHTML += '</label>';
							}

							$('.xCNFindGroup').html('');
							$('.xCNFindGroup').append(tHTML);
						}
					},
					error: function(jqXHR, textStatus, errorThrown) {
						JSxModalErrorCenter(jqXHR.responseText);
					}
				});
			}
			
		}
	}

	//กดที่รุ่น
	var aFilterGroup 		= [];
	function JSxClickGroupSearchspecialFindModal(){
		aFilterGroup = [];
		$('.xCNFilterAdvGroup:checked').each(function() {
			var tValue 		= $(this).val();
			aFilterGroup.push({'tFilter' : 'Group' , 'tValue' : tValue});
		});	
		
		// if(aFilterGroup.length != 0){

			$.ajax({
				type	: "POST",
				url		: 'r_searchProductFromModal',
				data	: { 'data' : aFilterGroup },
				cache	: false,
				timeout	: 0,
				success	: function(oResult) {
					var jResult = JSON.parse(oResult);
					if(jResult.rtCode == '800'){
						$('.xCNFindModal').html('');
						$('.xCNFindModal').append('- ไม่พบข้อมูล -');
					}else{
						var aItem	= jResult.raItems;
						var tHTML	= '';
						for(var i=0; i<aItem.length; i++){
							tHTML += '<label class="container-checkbox xCNCheckboxFilter">';
							tHTML += '<input class="xCNFilterAdv" type="checkbox" data-filter="MOL" value="'+aItem[i].FTMolCode+'">'+aItem[i].FTMolName+'';
							tHTML += '<span class="checkmark"></span>';
							tHTML += '</label>';
						}

						$('.xCNFindModal').html('');
						$('.xCNFindModal').append(tHTML);
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					JSxModalErrorCenter(jqXHR.responseText);
				}
			});
		// }
	}
</script>
