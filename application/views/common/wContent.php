<!-- Content -->
<div class="content"></div>

<!-- Modal แสดงข้อผิดพลาด -->
<button id="obtModalErrorCenter" style="display:none;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#odvModalErrorCenter"></button>
<div class="modal fade" id="odvModalErrorCenter" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">แจ้งเตือน</h5>
			</div>
			<div class="modal-body">
				<label>เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง</label>
				<div class="xCNPanelErrorCenter">
					<div class="">
						<div class="">
							<a data-toggle="collapse" href="#collapse1">รายละเอียดข้อผิดพลาด</a>
						</div>
						<div id="collapse1" class="panel-collapse collapse">
							<div class="panel-body"><label id="olbErrorCenter" style="width: 100%;"></label></div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" id="obtModalErrorCenterClose" data-dismiss="modal">ยืนยัน</button>
			</div>
		</div>
	</div>
</div>

<script>
	//โหลดหน้าตา
	JSwLoadInfomation();
	function JSwLoadInfomation(){
		// $('.xCNHomePage img').addClass('ACTIVE');
		$('.xCNHomeFisrt').removeClass('ACTIVE').css('display','none');
		$('.xCNHomeLast').addClass('ACTIVE').css('display','block');
		
		$.ajax({
			type	: "POST",
			url		: "r_information",
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				// var nWidth = $('#left-panel').width();
				// if(nWidth > 70){
				// 	$('#menuToggle').click();
				// }
				$('.content').html(tResult);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				JSxModalErrorCenter(jqXHR.responseText);
			}
		});
	}

	//Modal Center ในการแจ้งปัญหา
	function JSxModalErrorCenter(ptError){
		$('#obtModalErrorCenter').click();
		$('#olbErrorCenter').text('');
		$('#olbErrorCenter').text(ptError);

		//เมื่อ Modal ปิดไป
		$('#odvModalErrorCenter').on('hidden.bs.modal', function () {
			location.reload();
		})
	}
</script>
