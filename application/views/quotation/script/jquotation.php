<script type="text/javascript">
	$(document).ready(function() {
		FSvQUOGetPdtList(1);
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

		FSvQUOGetPdtList()
	}

	//หน้า list สินค้า
	function FSvQUOGetPdtList(pnPage) {
		tPdtViewType = $('.wxBntPdtVTypeActive').attr("data-viewtype");
		if(pnPage == '' || pnPage == null){ pnPage = 1; }
		$.ajax({
			url: 'r_quotationeventGetPdtList',
			type: 'GET',
			data: {
				pnPage			: pnPage,
				paFilter		: '',
				tPdtViewType	: tPdtViewType,
				aFilterAdv		: ''
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

		tQuoDocNo = $("#odvQuoDocNo").attr("data-docno");
		$.ajax({
				url: 'r_quotationcalldocheader',
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
		tQuoDocNo = $("#odvQuoDocNo").attr("data-docno");
		tDataItem = $(ptElm).attr("data-iteminfo");
		$.ajax({
			url: 'r_quotationeventAddItems',
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
	}

	function FSxQUODelItem(ptElm) {

		tQuoDocNo = $("#odvQuoDocNo").attr("data-docno");
		nItemSeq = $(ptElm).attr("data-seq");
		// alert(tQuoDocNo+'-'+nItemSeq);
		if (confirm('ยืนยันการลบสินค้านี้ออกจากเอกสาร')) {
			$.ajax({
					url: 'r_quotationeventDelItems',
					type: 'POST',
					data: {
						tQuoDocNo: tQuoDocNo,
						nItemSeq: nItemSeq
					},
					datatype: 'json'
				})
				.done(function(data) {

					FSvQUOCallItemList()

				})
				.fail(function(jqXHR, textStatus, errorThrown) {
					//serrorFunction();
				});
		}

	}

	function FSxQUOEditItemQty(e, poElm) {
		//See notes about 'which' and 'key'
		if (e.keyCode == 13) {

			var nItemQTY = $(poElm).val();
			tQuoDocNo = $("#odvQuoDocNo").attr("data-docno");
			nItemSeq = $(poElm).attr("data-seq");
			nUnitPrice = $(poElm).attr("data-unitpri");


			$.ajax({
					url: 'r_quotationeventEditItemsQty',
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

	function FSxQUOSearchItem(e, poElm) {

		if (e.keyCode == 13) {
			tKeySearch = $(poElm).val();

			$.ajax({
					url: 'r_quotationeventGetPdtList',
					type: 'GET',
					data: {
						tKeySearch: tKeySearch
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
	}

	function FSvQUOCallDocument() {

		if ($(".ospItemInDoc").length == 0) {

			alert("this document is empty product,please select either one ");

		} else {

			tQuoDocNo = $("#odvQuoDocNo").attr("data-docno")

			$.ajax({
					url: 'r_quotationcallsqdoc',
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

	}
</script>
