<div class="container-fulid">

	<!--Section บน-->
	<div class="row">
		<div class="col-lg-6 col-md-6"><span class="xCNHeadMenu">ผู้ใช้</span></div>
		<div class="col-lg-6 col-md-6"><button class="xCNButtonInsert pull-right">+</button></div>
	</div>

	<!--Section ล่าง-->
	<div class="card" style="margin-top: 10px;">
		<div class="card-body">
			<!--ค้นห่า-->
			<div class="row">
				<div class="col-lg-4">
					<div class="input-group md-form form-sm form-2 pl-0">
						<input class="form-control my-0 py-1 red-border xCNFormSerach" type="text" placeholder="กรุณากรอกคำที่ต้องการค้นหา" >
						<div class="input-group-append">
							<span class="input-group-text red lighten-3" id="basic-text1"><i class="fa fa-search" aria-hidden="true"></i></span>
						</div>
					</div>
				</div>

				<div class="col-lg-12">
					<div id="odvContent_User" class="xCNContent"></div>
				</div>
			</div>
		</div>
	</div>
<div>

<script>

	FSwLoadTableList();
	function FSwLoadTableList(){
		$.ajax({
			type	: "POST",
			url		: "r_loaduser",
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				$('#odvContent_User').html(tResult);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert(jqXHR, textStatus, errorThrown);
			}
		});
	}
</script>
