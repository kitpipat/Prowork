<div class="container-fulid">

	<!--Section บน-->
	<div class="row">
		<div class="col-lg-6 col-md-6"><span class="xCNHeadMenu">รายงาน</span></div>
	</div>

	<!--Section ล่าง-->
	<div class="card" style="margin-top: 10px;">
		<div class="card-body">
			<!--ค้นห่า-->
			<div class="row">
				<div class="col-lg-12">
					<div id="odvContent_report" class="xCNContent"></div>
				</div>
			</div>
		</div>
	</div>
<div>
<script src="<?= base_url('application/assets/js/jFormValidate.js')?>"></script>

<script>

	//หน้าตาราง
	JSwLoadTableList(1);
	function JSwLoadTableList(pnPage){
		$.ajax({
			type	: "POST",
			url		: "r_reportListLoad",
			data 	: { },
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				JSxModalProgress('close');
				$('#odvContent_report').html(tResult);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				JSxModalErrorCenter(jqXHR.responseText);
			}
		});
	}

	//โหลดหน้า เพิ่มข้อมูล
	function JSwCallDetailReport(ptReport,ptRptName){
		JSxModalProgress('open');
		$.ajax({
			type	: "POST",
			url		: "r_reportPageDetail",
			data 	: { 'tRptCode' : ptReport , 'tRptName' : ptRptName },
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
</script>
