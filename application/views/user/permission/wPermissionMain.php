<div class="container-fulid">

	<!--Section บน-->
	<div class="row">
		<div class="col-lg-6 col-md-6"><span class="xCNHeadMenu">กลุ่มสิทธิ์</span></div>
		<div class="col-lg-6 col-md-6"><button class="xCNButtonInsert pull-right" onClick="JSwPermissionCallPageInsert('insert','')">+</button></div>
	</div>

	<!--Section ล่าง-->
	<div class="card" style="margin-top: 10px;">
		<div class="card-body">
			<!--ค้นห่า-->
			<div class="row">
				<div class="col-lg-4">
					<div class="input-group md-form form-sm form-2 pl-0">
						<input class="form-control my-0 py-1 red-border xCNFormSerach" type="text" placeholder="กรุณากรอกคำที่ต้องการค้นหา" id="oetSearch" onkeypress="Javascript:if(event.keyCode==13) JSwLoadTableList(1)">
						<div class="input-group-append">
							<span class="input-group-text red lighten-3" style="cursor:pointer;" onclick="JSwLoadTableList(1);"><i class="fa fa-search" aria-hidden="true"></i></span>
						</div>
					</div>
				</div>

				<div class="col-lg-12">
					<div id="odvContent_Permission" class="xCNContent"></div>
				</div>
			</div>
		</div>
	</div>
<div>

<script>

	//หน้าตารางสินค้า
	JSwLoadTableList(1);
	function JSwLoadTableList(pnPage){
		$.ajax({
			type	: "POST",
			url		: "r_permissionload",
			data 	: {
						'nPage' 		: pnPage,
						'tSearchAll' 	: $('#oetSearch').val()
					  },
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				$('#odvContent_Permission').html(tResult);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert(jqXHR, textStatus, errorThrown);
			}
		});
	}

	//โหลดหน้า เพิ่มข้อมูล
	function JSwPermissionCallPageInsert(ptType,ptCode){
		$.ajax({
			type	: "POST",
			url		: "r_permissioncallpageInsertorEdit",
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

	//กด ผู้ใช้(กลับหน้า main)
	function JSxCallPagePermissionMain(){
		$.ajax({
			type	: "POST",
			url		: "r_permission",
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
