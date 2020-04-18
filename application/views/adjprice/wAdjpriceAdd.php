<?php
	$tLevelUser = $this->session->userdata('tSesUserLevel');
	if($tTypePage == 'insert'){
		$tRoute 			= 'r_adjpriceeventinsert';
		$tRouteUrl			= 'สร้างใบปรับราคาสินค้า';

		$tDocumentNumber	= '-';
		$dDocumentDate		= date('d/m/Y') . ' - ' . date("H:i:s");
		$tDocumentCreate	= $this->session->userdata('tSesFirstname') . ' ' . $this->session->userdata('tSesLastname');
		$tDocumentStaDoc	= '-';
		$tDocumentStaApv	= '-';
	}else if($tTypePage == 'edit'){
		$tRoute 			= 'r_adjpriceeventedit';
		$tRouteUrl			= 'แก้ไขใบปรับราคาสินค้า';

		$tDocumentNumber	= '-';
	}
?>

<div class="container-fulid">
	
	<form id="ofmAJP" class="form-signin" method="post" action="javascript:void(0)">

		<input type="hidden" id="ohdAJPCode" name="ohdAJPCode" value="">

		<!--Section บน-->
		<div class="row">
			<div class="col-lg-6 col-md-6"><span class="xCNHeadMenuActive" onclick="JSxCallPageAJPMain();">ใบปรับราคาสินค้า</span><span class="xCNHeadMenu">  /  <?=$tRouteUrl?></span></div>
			<div class="col-lg-6 col-md-6"><button class="xCNButtonSave pull-right" onclick="JSxEventSaveorEdit('<?=$tRoute?>');">บันทึก</button></div>
		</div>

		<!--Section ล่าง-->
		<div class="row">
			
			<!--section ซ้าย พวกรายละเอียด HD-->
			<div class="col-lg-3 col-md-3">
				<div class="row">
					<!--Panel 1 ข้อมูลเอกสาร-->
					<div class="col-lg-12">
						<div class="card" style="margin-top: 10px;">
							<div class="card-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="xCNHeadFooterINPDT"><span> ข้อมูลเอกสาร </span></div>
									</div>
									<!--รายละเอียด-->
									<div class="col-lg-12 col-md-12">
										<div class="form-group xCNSubPanelDocument">
											<span>เลขที่เอกสาร : </span>
											<span class="pull-right"><?=$tDocumentNumber?></span>
										</div>

										<div class="form-group xCNSubPanelDocument">
											<span>วันที่-เวลาเอกสาร : </span>
											<span class="pull-right"><?=$dDocumentDate?></span>
										</div>

										<div class="form-group xCNSubPanelDocument">
											<span>ผู้สร้างเอกสาร : </span>
											<span class="pull-right"><?=$tDocumentCreate?></span>
										</div>

										<div class="form-group xCNSubPanelDocument">
											<span>สถานะเอกสาร : </span>
											<span class="pull-right"><?=$tDocumentStaDoc?></span>
										</div>

										<div class="form-group xCNSubPanelDocument">
											<span>สถานะอนุมัติเอกสาร : </span>
											<span class="pull-right"><?=$tDocumentStaApv?></span>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>

					<!--Panel 2 เงือนไขการปรับ-->
					<div class="col-lg-12">
						<div class="card" style="margin-top: 10px;">
							<div class="card-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="xCNHeadFooterINPDT"><span> เงือนไขการปรับ </span></div>
									</div>
									<!--รายละเอียด-->
									<div class="col-lg-12 col-md-12">
										<!--กลุ่มราคาที่มีผล-->
										<div class="form-group">
											<label><span style="color:red;">*</span> กลุ่มราคาที่มีผล</label>
											<select class="form-control" id="oetAJPPriGrp" name="oetAJPPriGrp">
												<?php foreach($aPriGrp['raItems'] AS $nKey => $aValue){ ?>
													<option <?=(@$FTPriGrpID == $aValue['FTPriGrpID'])? "selected" : "";?> value="<?=$aValue['FTPriGrpID'];?>"><?=$aValue['FTPriGrpName'];?></option>
												<?php } ?>
											</select>										
										</div>
										<!--หมายเหตุ-->
										<div class="form-group">
											<label>หมายเหตุ</label>
											<textarea type="text" class="form-control" id="oetAJPReason" name="oetAJPReason" placeholder="หมายเหตุ" rows="3"></textarea>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!--section ขวา พวกรายละเอียด DT-->
			<div class="col-lg-9 col-md-9">

				<div class="card" style="margin-top: 10px;">
					<div class="card-body">
						<div class="row">
							<div class="col-lg-12">
								<div class="xCNHeadFooterINPDT"><span> รายการสินค้า </span></div>
							</div>
							<!--รายละเอียด-->
							<div class="col-lg-12 col-md-12">
													
								<!--เพิ่มสินค้า + ค้นหาสินค้า-->
								<div class="row">
									<div class="col-lg-4 col-md-4">
										<div class="input-group md-form form-sm form-2 pl-0">
											<input class="form-control my-0 py-1 red-border xCNFormSerach" autocomplete="off" type="text" placeholder="กรุณากรอกคำที่ต้องการค้นหา" id="oetSearchTmp" onkeypress="Javascript:if(event.keyCode==13) JSwLoadTableList(1)">
											<div class="input-group-append">
												<span class="input-group-text red lighten-3" style="cursor:pointer;" onclick="JSwLoadTableList(1);"><i class="fa fa-search" aria-hidden="true"></i></span>
											</div>
										</div>
									</div>
									<div class="col-lg-8 col-md-8">
										<button class="xCNBrowsePDTinDocument"><span>+</span></button>
									</div>
								</div>

								<!--รายการสินค้า-->
								<div class="row">
									<div class="col-lg-12 col-md-12">
										<div id="odvAJPTableDT" style="margin-top:10px;"></div>		
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
<div>

<script src="<?= base_url('application/assets/js/jFormValidate.js')?>"></script>
<script>	

	//โหลดข้อมูลตารางสินค้า
	JSvLoadTableDTTmp(1);
	function JSvLoadTableDTTmp(pnPage){
		$.ajax({
			type	: "POST",
			url		: "r_adjpriceloadtableDTTmp",
			data 	: {
						'tTypepage'  	: '<?=$tTypePage?>',
						'tCode'	 	 	: '<?=$tDocumentNumber?>',
						'nPage' 		: pnPage,
						'tSearchTmp' 	: $('#oetSearchTmp').val()
					  },
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				$('#odvAJPTableDT').html(tResult);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert(jqXHR, textStatus, errorThrown);
			}
		});
	}

	//อีเวนท์บันทึกข้อมูล
	function JSxEventSaveorEdit(ptRoute){

		// if($('#oetBANName').val() == ''){
		// 	$('#oetBANName').focus();
		// 	return;
		// }

		// $.ajax({
		// 	type	: "POST",
		// 	url		: ptRoute,
		// 	data 	: $('#ofmBrandProduct').serialize(),
		// 	cache	: false,
		// 	timeout	: 0,
		// 	success	: function (tResult) {
		// 		if(tResult == 'pass_insert'){
		// 			$('.alert-success').addClass('show').fadeIn();
		// 			$('.alert-success').find('.badge-success').text('สำเร็จ');
		// 			$('.alert-success').find('.xCNTextShow').text('ลงทะเบียนยี่ห้อสินค้าสำเร็จ');
		// 			JSxCallPageBrandProductMain();
		// 			setTimeout(function(){
		// 				$('.alert-success').find('.close').click();
		// 			}, 3000);
		// 		}else if(tResult == 'pass_update'){
		// 			$('.alert-success').addClass('show').fadeIn();
		// 			$('.alert-success').find('.badge-success').text('สำเร็จ');
		// 			$('.alert-success').find('.xCNTextShow').text('แก้ไขข้อมูลยี่ห้อสินค้าสำเร็จ');
		// 			JSxCallPageBrandProductMain();
		// 			setTimeout(function(){
		// 				$('.alert-success').find('.close').click();
		// 			}, 3000);
		// 		}
		// 	},
		// 	error: function (jqXHR, textStatus, errorThrown) {
		// 		alert(jqXHR, textStatus, errorThrown);
		// 	}
		// });
	}

	//เลือกสินค้า
	$('.xCNBrowsePDTinDocument').on('click',function(){
		var oBrowseTROutToShp = {
            Title   : ['company/shop/shop','tSHPTitle'],
            Table   : {Master:'TCNMShop', PK:'FTShpCode'},
            Join    : {
                Table   : ['TCNMShop_L', 'TCNMBranch_L'],
                On      : [
                    'TCNMShop.FTBchCode = TCNMShop_L.FTBchCode      AND TCNMShop.FTShpCode = TCNMShop_L.FTShpCode AND TCNMShop_L.FNLngID = '+nLangEdits,
                    'TCNMShop.FTBchCode = TCNMBranch_L.FTBchCode    AND TCNMBranch_L.FNLngID = '+nLangEdits
                ]
            },
            Where   : {
                Condition : []
            },
            GrideView:{
                ColumnPathLang	    : 'company/shop/shop',
                ColumnKeyLang	    : ['tSHPTBBranch','tSHPTBCode','tSHPTBName'],
                ColumnsSize         : ['15%','15%','75%'],
                WidthModal          : 50,
                DataColumns		    : ['TCNMBranch_L.FTBchName', 'TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName'],
                DataColumnsFormat   : ['','',''],
                Perpage			    : 10,
                OrderBy			    : ['TCNMShop.FTBchCode ASC,TCNMShop.FTShpCode ASC'],
            },
            CallBack: {
                ReturnType	: 'S',
                Value		: ['oetTROutShpToCode',"TCNMShop.FTShpCode"],
                Text		: ['oetTROutShpToName',"TCNMShop_L.FTShpName"]
            },
            NextFunc:{
                FuncName    :   'JSxSelectTRToFromShp',
                ArgReturn   :   ['FTShpCode'],
            }
		}
		JCNxBrowseData('oBrowseTROutToShp');
	});

</script>
