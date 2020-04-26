<script type="text/javascript">
	$(document).ready(function() {
		FSvQUOGetPdtList(1,'');
		FSvQUOCallDocHeader();
		FSvQUOCallItemList();
	});

	function FSvQUOSwitView(ptViewType) {

		$('.btn-group > button ').removeClass("wxBntPdtVTypeActive")
		if (ptViewType == 1) {
			$('#odvPdtTableView').addClass("wxBntPdtVTypeActive")
		} else {
			$('#odvPdtListView').addClass("wxBntPdtVTypeActive")
		}

		FSvQUOGetPdtList(1,'')
	}

	//หน้า list สินค้า
	function FSvQUOGetPdtList(pnPage,paFilterAdv) {
		tPdtViewType = $('.wxBntPdtVTypeActive').attr("data-viewtype");

		if(paFilterAdv == '' || paFilterAdv == null){
			paFilterAdv = '';
		}else{
			paFilterAdv = paFilterAdv;
		}

		if(pnPage == '' || pnPage == null){ pnPage = 1; }
		$.ajax({
			url: 'r_quotationeventGetPdtList',
			timeout: 0,
			type: 'GET',
			data: {
				'pnPage'			: pnPage,
				'tSearchAll'		:  $('#oetSearchPI').val(),
				'tPdtViewType'		: tPdtViewType,
				'aFilterAdv'		: paFilterAdv
			},
			datatype: 'json'
		})
		.done(function(data) {
			$("#odvQuoPdtList").html(data);
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
			//serrorFunction();
		});
	}


	function FSvQUOCallDocHeader() {

		tQuoDocNo = $("#odvQuoDocNo").text();
		$.ajax({
				url: 'r_quotationcalldocheader',
				timeout: 0,
				type: 'GET',
				data: {
					tQuoDocNo: tQuoDocNo
				},
				datatype: 'json'
			})
			.done(function(data) {
				$("#odvQuoHeader").html(data);
			})
			.fail(function(jqXHR, textStatus, errorThrown) {
				//serrorFunction();
			});
	}

	function FSvQUOCallItemList() {
		$.ajax({
				url: 'r_quotationeventcallitemslist',
				type: 'GET',
				timeout: 0,
				data: {},
				datatype: 'json'
			})
			.done(function(data) {
				$("#odvQuoItemsList").html(data);
			})
			.fail(function(jqXHR, textStatus, errorThrown) {
				//serrorFunction();
			});
	}

	//เลือกสินค้า เข้าตะกร้า
	function FSvQUOAddItemToTemp(ptElm) {
		$("#odvQuoItemsList").html('<div style="padding:5px;font-size:16px">กำลังเพิ่มสินค้าในเอกสารกรุณารอซักครู่...</div>');
		tQuoDocNo = $("#odvQuoDocNo").text();
		
		tDataItem = $(ptElm).attr("data-iteminfo");
		$.ajax({
			url: 'r_quotationeventAddItems',
			timeout: 0,
			type: 'POST',
			data: {
				tQuoDocNo: tQuoDocNo,
				Item: tDataItem
			},
			datatype: 'json'
		})
		.done(function(data) {
			FSvQUOCallItemList()
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
			//serrorFunction();
		});

		//ซ่อน dialog แจ้งเตือนของวัด
		$('.xCNDialog_Footer').css('display','none');
	}

	//ลบสินค้าใน ตะกร้า
	function FSxQUODelItem(ptElm) {
		tQuoDocNo = $("#odvQuoDocNo").text();
		nItemSeq = $(ptElm).attr("data-seq");

		$('#obtModalDeleteItemPI').click();

		$('.xCNConfirmDelete').off();
		$('.xCNConfirmDelete').on("click",function(){
			$.ajax({
				url: 'r_quotationeventDelItems',
				timeout: 0,
				type: 'POST',
				data: {
					tQuoDocNo: tQuoDocNo,
					nItemSeq: nItemSeq
				},
				datatype: 'json'
			})
			.done(function(data) {
				$('#obtModalDeleteItemPI').click();
				setTimeout(function(){
					FSvQUOCallItemList();
				}, 500);
			})
			.fail(function(jqXHR, textStatus, errorThrown) {
				//serrorFunction();
			});
		});
	}

	function FSxQUOEditItemQty(e, poElm) {
		//See notes about 'which' and 'key'
		if (e.keyCode == 13) {

			var nItemQTY = $(poElm).val();
			tQuoDocNo = $("#odvQuoDocNo").text();
			nItemSeq = $(poElm).attr("data-seq");
			nUnitPrice = $(poElm).attr("data-unitpri");


			$.ajax({
					url: 'r_quotationeventEditItemsQty',
					timeout: 0,
					type: 'POST',
					data: {
						tQuoDocNo: tQuoDocNo,
						nItemSeq: nItemSeq,
						nItemQTY: nItemQTY,
						nUnitPrice: nUnitPrice
					},
					datatype: 'json'
				})
				.done(function(data) {

					FSvQUOCallItemList()

				})
				.fail(function(jqXHR, textStatus, errorThrown) {
					//serrorFunction();
				});
			return false;

		}
	}

	//กดถัดไป เลือกสินค้าในตะกร้าพร้อมแล้ว
	function FSvQUOCallDocument() {

		if ($(".ospItemInDoc").length == 0) {
			$('#obtModalItemEmpty').click();
			return;
		}

		tQuoDocNo = $("#odvQuoDocNo").text()
		$.ajax({
			url: 'r_quotationcallsqdoc',
			timeout: 0,
			type: 'GET',
			data: {
				tQuoDocNo: tQuoDocNo
			},
			datatype: 'json'
		})
		.done(function(data) {
			$(".content").html(data)
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
			//serrorFunction();
		});
	}

</script>
