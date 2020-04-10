<div class="container-fulid">

	<!--Section บน-->
	<div class="row">
		<div class="col-lg-6 col-md-6"><span class="xCNHeadMenu">สีสินค้า</span></div>
		<div class="col-lg-6 col-md-6"><button class="xCNButtonInsert pull-right" onClick="JSwColorProductCallPageInsert('insert','')">+</button></div>
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
					<div id="odvContent_ColorProduct" class="xCNContent"></div>
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
			url		: "r_colorproductload",
			data 	: {
						'nPage' 		: pnPage,
						'tSearchAll' 	: $('#oetSearch').val()
					  },
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				$('#odvContent_ColorProduct').html(tResult);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert(jqXHR, textStatus, errorThrown);
			}
		});
	}

	//โหลดหน้า เพิ่มข้อมูล
	function JSwColorProductCallPageInsert(ptType,ptCode){
		$.ajax({
			type	: "POST",
			url		: "r_colorproductcallpageInsertorEdit",
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
	function JSxCallPageColorProductMain(){
		$.ajax({
			type	: "POST",
			url		: "r_colorproduct",
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
