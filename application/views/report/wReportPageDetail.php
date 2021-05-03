<?php
	$tLevelUser = $this->session->userdata('tSesUserLevel');
	$tRptCode = $tRptCode;
	$tRptCode = $tRptName;
?>

<div class="container-fulid">

	<!--Section บน-->
	<div class="row">
		<div class="col-lg-6 col-md-6"><span class="xCNHeadMenuActive" onclick="JSxCallPageReport();">รายงาน</span><span class="xCNHeadMenu">  /  <?=$tRptName?></span></div>
	</div>

	<!--Section ล่าง-->
	<div class="card" style="margin-top: 10px;">
		<div class="card-body">
			<div class="row">
				<!--รายละเอียด-->
				<div class="col-lg-12 col-md-12">
					<div class="row"> 

						<div class="col-lg-3">
							<!--สาขา-->
							<?php if($tLevelUser == 'HQ'){ ?>
								<div class="form-group">
									<label> สาขา</label>
									<select class="form-control" id="oetRptBCH" name="oetRptBCH">
										<option value="0">สำนักงานใหญ่</option>
										<?php foreach($aBCHList['raItems'] AS $nKey => $aValue){ ?>
											<option <?=(@$FTBchCode == $aValue['FTBchCode'])? "selected" : "";?> value="<?=$aValue['FTBchCode'];?>"><?=$aValue['FTBchName'];?> - (<?=$aValue['FTCmpName'];?>)</option>
										<?php } ?>
									</select>
								</div>
							<?php }else{ ?>
								<div class="form-group">
									<?php $tBCHName = $this->session->userdata('tSesBCHName'); ?>
									<?php $tBCHCode = $this->session->userdata('tSesBCHCode'); ?>
									<label> สาขา</label>
									<input type="text" class="form-control" value="<?=@$tBCHName?>" autocomplete="off" readonly>
									<input type="hidden" id="oetRptBCH" name="oetRptBCH" value="<?=@$tBCHCode?>" autocomplete="off">
								</div>
							<?php } ?>
						</div>

						<div class="col-lg-2">
							<label> วันที่ </label>
							<input id="oetRptDateStart" name="oetRptDateStart" type="text" class="form-control xCNDatePicker" value="" autocomplete="off" placeholder="DD/MM/YYYY">
						</div>

						<div class="col-lg-2">
							<label> ถึงวันที่ </label>
							<input id="oetRptDateEnd" name="oetRptDateEnd" type="text" class="form-control xCNDatePicker" value="" autocomplete="off" placeholder="DD/MM/YYYY">
						</div>

						<div class="col-lg-2">
							<div class="form-group">
								<label style="color:#FFF;">.</label>
								<button class="xCNButtonSave pull-right" onclick="JSwLoadTableList(1);" style="width: 100%;">กรองข้อมูล</button>
							</div>
						</div>

					</div>
				</div>

				<!--รายละเอียด-->
				<div class="col-lg-12 col-md-12">
					<div id="odvReportTable"></div>
				</div>
			</div>
		</div>
	</div>
<div>

<script src="<?= base_url('application/assets/js/jFormValidate.js')?>"></script>
<script>

	$('ducument').ready(function(){ 
		$('.xCNDatePicker').datepicker({ 
			format          : 'dd/mm/yyyy',
			autoclose       : true,
			todayHighlight  : true,
			orientation		: "bottom right"
		});
	});

	//กดกลับไปหน้า report
	function JSxCallPageReport(){
		JSxModalProgress('open');
		$.ajax({
			type	: "POST",
			url		: "r_report",
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

	//หน้าตาราง
	JSwLoadReportTableList(1);
	function JSwLoadReportTableList(pnPage){
		JSxModalProgress('open');
		$.ajax({
			type	: "POST",
			url		: "r_reportTable",
			data 	: {
						'nPage' 		: pnPage,
						'tBCHCode'		: $('#oetRptBCH').val(),
						'tDateStart'	: $('#oetRptDateStart').val(),
						'tDateEnd'		: $('#oetRptDateEnd').val()
					},
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				JSxModalProgress('close');
				$('#odvReportTable').html(tResult);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				JSxModalErrorCenter(jqXHR.responseText);
			}
		});
	}
		
</script>
