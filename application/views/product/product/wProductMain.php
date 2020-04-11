<div class="container-fulid">

	<!--Section บน-->
	<div class="row">
		<div class="col-lg-6 col-md-6"><span class="xCNHeadMenu">สินค้า</span></div>
		<div class="col-lg-6 col-md-6"><button class="xCNButtonInsert pull-right" onClick="JSwProductCallPageInsert('insert','')">+</button></div>
	</div>

	<!--Section ล่าง-->
	<div class="card" style="margin-top: 10px;">
		<div class="card-body">
			<div class="row">

				<!--ตัวกรองค้นหา-->
				<div class="col-lg-3 xCNFilterSearch">
					<div class="row">
						<div class="col-lg-12">
							<div class="xCNHeadFilter"> ตัวกรองค้นหา </div>
						</div>

						<div class="col-lg-12">
							<div class="xCNSubFilter">
								<!--ยี่ห้อ-->
								<?php if($aFilter_Brand['rtCode'] != 800){ ?>
									<div class="form-group">
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
									<div class="form-group">
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
									<div class="form-group">
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
									<div class="form-group">
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
									<div class="form-group">
										<label><b>ขนาด</b></label>
										<?php foreach($aFilter_Size['raItems'] AS $nKey => $aValue){ ?>
											<label class="container-checkbox xCNCheckboxFilter">
												<input class="xCNFilterAdv" type="checkbox" data-filter="PZE" value="<?=$aValue['FTPzeCode']?>"><?=$aValue['FTPzeName']?>
												<span class="checkmark"></span>
											</label>							
										<?php } ?>
									</div>
								<?php } ?> 

								<!--ขนาด-->
								<?php if($aFilter_Type['rtCode'] != 800){ ?>
									<div class="form-group">
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
									<div class="form-group">
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
									<div class="form-group">
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

				<!--รายละเอียด-->
				<div class="col-lg-9 xCNContentProduct">
					<div class="row">
						<div class="col-lg-4">
							<div class="input-group md-form form-sm form-2 pl-0">
								<input class="form-control my-0 py-1 red-border xCNFormSerach" type="text" placeholder="กรุณากรอกคำที่ต้องการค้นหา" id="oetSearch" onkeypress="Javascript:if(event.keyCode==13) JSwLoadTableList(1)">
								<div class="input-group-append">
									<span class="input-group-text red lighten-3" style="cursor:pointer;" onclick="JSwLoadTableList(1);"><i class="fa fa-search" aria-hidden="true"></i></span>
								</div>
							</div>
						</div>

						<div class="col-lg-1">
							<div class="xCNFilter">
								<i class="fa fa-filter xCNIconFilter" aria-hidden="true"></i>
							</div>
						</div>

						<div class="col-lg-12">
							<div id="odvContent_Product" class="xCNContent"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<div>

<script>	

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


	//กดนำไปใช้ หรือ ค้นหาขั้นสูง
	var aFilter 		= [];
	var tFilterOld 		= '';
	function JSxPDTFilterAdv(){
		$('.xCNFilterAdv:checked').each(function() {
			var tFilter 	= $(this).data('filter');
			var tValue 		= $(this).val();

			if(tFilterOld != tFilter){
				aFilter.push(tFilter);
			}

			tFilterOld == tFilter;
		});


		console.log(aFilter);
	}

	//หน้าตาราง
	JSwLoadTableList(1);
	function JSwLoadTableList(pnPage){
		$.ajax({
			type	: "POST",
			url		: "r_productload",
			data 	: {
						'nPage' 		: pnPage,
						'tSearchAll' 	: $('#oetSearch').val()
					  },
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				$('#odvContent_Product').html(tResult);

				// //กำหนดขนาดของตารางค้นหา จะเท่ากับ ตารางสินค้าเสมอ
				var tHeightContent = $('.xCNContentProduct').height() - 50;
				$('.xCNSubFilter').css('height',tHeightContent+'px');
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert(jqXHR, textStatus, errorThrown);
			}
		});
	}

	//โหลดหน้า เพิ่มข้อมูล
	function JSwProductCallPageInsert(ptType,ptCode){
		$.ajax({
			type	: "POST",
			url		: "r_productcallpageInsertorEdit",
			data 	: {
						'tTypepage'  : ptType,
						'tCode'	 	 : ptCode
					  },
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

	//กด ย้อนกลับ(กลับหน้า main)
	function JSxCallPageProductMain(){
		$.ajax({
			type	: "POST",
			url		: "r_product",
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
