<script type="text/javascript">
	$(document).ready(function() {
		FSvQUODocHeader();
	});

	//โหลดรายละเอียดเอกสาร
	function FSvQUODocHeader() {

		tDocNo = $("#ospDocNo").attr("data-docno");
		$.ajax({
				url	: 'r_quodocgetdocheader',
				timeout: 0,
				type: 'GET',
				data: { tDocNo: tDocNo },
				datatype: 'json'
			})
			.done(function(data) {
				aDocHD 			= JSON.parse(data)
				tBchCode 		= aDocHD["raItems"][0]["FTBchCode"]
				tXqhDocNo 		= aDocHD["raItems"][0]["FTXqhDocNo"]
				dXqhDocDate 	= aDocHD["raItems"][0]["FDXqhDocDate"]
				tXqhCshOrCrd 	= aDocHD["raItems"][0]["FTXqhCshOrCrd"]
				nXqhCredit 		= aDocHD["raItems"][0]["FNXqhCredit"]
				tXqhVATInOrEx 	= aDocHD["raItems"][0]["FTXqhVATInOrEx"]
				nXqhSmpDay 		= aDocHD["raItems"][0]["FNXqhSmpDay"]
				dXqhEftTo 		= aDocHD["raItems"][0]["FDXqhEftTo"]
				dDeliveryDate 	= aDocHD["raItems"][0]["FDDeliveryDate"]
				tXqhStaExpress 	= aDocHD["raItems"][0]["FTXqhStaExpress"]
				tXqhStaDoc 		= aDocHD["raItems"][0]["FTXqhStaDoc"]
				FTXqhStaApv 	= aDocHD["raItems"][0]["FTXqhStaApv"]
				tXqhStaActive 	= aDocHD["raItems"][0]["FTXqhStaActive"]
				tXqhPrjName 	= aDocHD["raItems"][0]["FTXqhPrjName"]
				tXqhPrjCodeRef 	= aDocHD["raItems"][0]["FTXqhPrjCodeRef"]
				tUsrDep 		= aDocHD["raItems"][0]["FTUsrDep"]
				tApprovedBy 	= aDocHD["raItems"][0]["FTApprovedBy"]
				tCreateBy 		= aDocHD["raItems"][0]["FTCreateBy"]
				tUsrDep 		= aDocHD["raItems"][0]["FTUsrDep"]
				dCreateOn 		= aDocHD["raItems"][0]["FDCreateOn"]
				tUsrApvNameBy 	= aDocHD["raItems"][0]["FTUsrFName"]
				dApproveDate 	= aDocHD["raItems"][0]["FDApproveDate"]
				tXqhStaDeli 	= aDocHD["raItems"][0]["FTXqhStaDeli"]
				tXqhRmk 		= aDocHD["raItems"][0]["FTXqhRmk"]
				tVatRate 		= aDocHD["raItems"][0]["FCXqhVatRate"]
				tXqhDisTxt 		= aDocHD["raItems"][0]["FTXqhDisTxt"]
				nXqhDis 		= aDocHD["raItems"][0]["FCXqhDis"]

				//เลขที่เอกสาร
				if (tXqhDocNo == "") {
					tXqhDocNo = "SQ######-#####"
					$("#ospDocNo").attr("data-docno", '')
				} else {
					tXqhDocNo = tXqhDocNo
					$("#ospDocNo").attr("data-docno", tXqhDocNo)
				}

				$("#olbDocNo").text(tXqhDocNo);

				//เวลาเอกสาร
				if (dXqhDocDate == "") {
					dXqhDocDate = moment().format('YYYY-MM-DD, h:mm:ss')
				} else {
					dXqhDocDate = dXqhDocDate
				}
				$("#ospDocDate").text(dXqhDocDate)

				//สถานะเอกสาร
				switch (tXqhStaDoc) {
					case '':
						$("#ospStaDoc").text("รออนุมัติ")
						break;
					case '1':
						$("#ospStaDoc").text("สมบูรณ์")
						break;
					case '2':
						$("#ospStaDoc").text("ยกเลิก")
						break;
					default:
						$("#ospStaDoc").text("รออนุมัติ")
				}
				$('#ohdStaDoc').val(tXqhStaDoc);

				//สถานะอนุมัติ
				switch (FTXqhStaApv) {
					case '':
						$("#ospStaDocApv").text("รออนุมัติ")
						break;
					case '1':
						$("#ospStaDocApv").text("อนุมัติแล้ว")
						break;
					default:
						$("#ospStaDocApv").text("รออนุมัติ")
				}
				$('#ohdStaApv').val(FTXqhStaApv);

				//ค่าต่างๆ
				$("#oetXqhSmpDay").val(nXqhSmpDay);
				$("#oetXqhCredit").val(nXqhCredit);
				$("#odpXqhEftTo").val(dXqhEftTo);
				$("#odpDeliveryDate").val(dDeliveryDate);
				$('#ocmXqhCshOrCrd option[value="' + tXqhCshOrCrd + '"]').attr("selected", "selected");
				$("#ospCreateBy").text(tUsrApvNameBy);
				$("#ospApproveDate").text('-');
				$("#ospApprovedBy").text('-');

				//เอกสารด่วน
				if (tXqhStaExpress == '') {
					$("#ocbStaExpress").prop("checked", false);
				} else {
					$("#ocbStaExpress").prop("checked", true);
				}

				//เคลื่อนไหว
				if (tXqhStaActive == '') {
					$("#ocbtStaDocActive").prop("checked", false);
				} else {
					$("#ocbtStaDocActive").prop("checked", true);
				}

				//จัดส่งสินค้าแล้ว
				if (tXqhStaDeli == '') {
					$("#ocbStaDeli").prop("checked", false);
				} else {
					$("#ocbStaDeli").prop("checked", true);
				}

				$("#oetPrjName").val(tXqhPrjName)
				$("#oetPrjCodeRef").val(tXqhPrjCodeRef)
				$('#ocmVatType option[value="' + tXqhVATInOrEx + '"]').attr("selected", "selected");
				$("#otaDocRemark").text(tXqhRmk)

				if (tVatRate == 0) {
					tVatRate = 7
				} else {
					tVatRate = tVatRate
				}
				$("#oetVatRate").val(tVatRate)
				$("#oetXqhDisText").val(tXqhDisTxt)

				//ส่วนลดท้ายบิล
				nXqhDis = parseFloat(nXqhDis)
				nXqhDis = accounting.formatMoney(nXqhDis.toFixed(2), "")
				$("#ospXqhDis").text(nXqhDis);

				FSoQUODocCst();
				FSvQUODocItems();

				//เอกสารถูกยกเลิก หรือ อนุมัติแล้วจะทำงานไม่ได้
				if(tXqhStaDoc == 2 || FTXqhStaApv == 1){
					$('.xCNButtonSave').addClass('xCNHide');
					$('.xCNAprove').addClass('xCNHide');
					$('.xCNCancel').addClass('xCNHide');
					$('.xCNPrint').addClass('xCNHide');
					$('.form-control').attr('disabled',true);
					$('#odvMoreItem').addClass('xCNHide');
				}

				//ถ้าเอกสารที่อนุมัติแล้วถึงจะพิมพ์ได้
				if(FTXqhStaApv == 1){
					$('.xCNPrint').removeClass('xCNHide');
					$("#ospApprovedBy").text(tUsrApvNameBy);
					$("#ospApproveDate").text(dApproveDate);
				}
			})
			.fail(function(jqXHR, textStatus, errorThrown) {
				//serrorFunction();
			});
	}

	function FSoQUODocCst() {

		tDocNo = $("#ospDocNo").attr("data-docno");
		tDocNo = $("#ospDocNo").attr("data-docno");
		$.ajax({
				url: 'r_quodocgetdoccst',
				timeout: 0,
				type: 'GET',
				data: {
					tDocNo: tDocNo
				},
				datatype: 'json'
			})
			.done(function(data) {

				aDocHD = JSON.parse(data)
				//console.log(aDocHD["raItems"])
				tXqcCstName = aDocHD["raItems"][0]["FTXqcCstName"]
				tXqcAddress = aDocHD["raItems"][0]["FTXqcAddress"]
				tXqhTaxNo = aDocHD["raItems"][0]["FTXqhTaxNo"]
				tXqhContact = aDocHD["raItems"][0]["FTXqhContact"]
				tXqhEmail = aDocHD["raItems"][0]["FTXqhEmail"]
				tXqhTel = aDocHD["raItems"][0]["FTXqhTel"]
				tXqhFax = aDocHD["raItems"][0]["FTXqhFax"]

				$("#oetCstName").val(tXqcCstName)
				$("#oetAddress").text(tXqcAddress)
				$("#oetTaxNo").val(tXqhTaxNo)
				$("#oetContact").val(tXqhContact)
				$("#oetEmail").val(tXqhEmail)
				$("#oetTel").val(tXqhTel)
				$("#oetFax").val(tXqhFax)

			})
			.fail(function(jqXHR, textStatus, errorThrown) {
				//serrorFunction();
			});

	}

	function FSvQUODocItems() {

		tDocNo = $("#ospDocNo").attr("data-docno");
		$.ajax({
				url: 'r_quodoccallitems',
				timeout: 0,
				type: 'GET',
				data: {
					tDocNo: tDocNo
				},
				datatype: 'json'
			})
			.done(function(data) {
				$("#odvQuoDocItems").html(data);
				nDocNetTotal = parseFloat($("#ospDocNetTotal").text())

				$("#otdDocNetTotal").text(accounting.formatMoney(nDocNetTotal.toFixed(2), ""))
				nFooterDis 	= $("#ospXqhDis").text()
				nFooterDis 	= parseFloat(nFooterDis.replace(',', ' ').replace(' ', ''))
				nNetAFHD 	= nDocNetTotal - (nFooterDis);

				$("#otdNetAFHD").text(accounting.formatMoney(nNetAFHD.toFixed(2), ""))
				nVatType = $("#ocmVatType").val()
				nVatRate = $("#oetVatRate").val()
				nVat 		= 0
				nGrandTotal = 0

				if (nVatType == "1") {
					nVat = ((nNetAFHD * (100 + parseInt(nVatRate))) / 100) - nNetAFHD
					nGrandTotal = parseFloat(nNetAFHD) + parseFloat(nVat.toFixed(2))
				} else {
					nVat = nNetAFHD - ((nNetAFHD * 100) / (100 + parseInt(nVatRate)))
					nGrandTotal = parseFloat(nNetAFHD)
				}

				$("#otdVat").text(accounting.formatMoney(nVat.toFixed(2), ""))

				$("#otdGrandTotal").text(accounting.formatMoney(nGrandTotal.toFixed(2), ""))


				//ถ้าเอกสารยกเลิก หรือ อนุมัติแล้วจะทำงานไม่ได้
				var nStaDoc = $('#ohdStaDoc').val();
				var nStaApv = $('#ohdStaApv').val();
				if(nStaDoc == 2 || nStaApv == 1 ){
					$('.xCNCellDeleteItem').addClass('xCNHide');
					$('.xCNEditInline').attr('disabled',true);
				}

				//สรุปบิล เป็น TEXT
				var tTextTotal 	= $('#otdGrandTotal').text();
				var thaibath 	= ArabicNumberToText(tTextTotal);
				$('#ospTotalText').text(thaibath);

				JSxModalProgress('close');
			})
			.fail(function(jqXHR, textStatus, errorThrown) {
				//serrorFunction();
			});

	}

	//บันทึกเอกสาร
	function FSxQUOSaveDoc() {

		oDocCstInfo 		= $("#ofmQuotationCst").serializeArray()
		oDocHeaderInfo 		= $("#ofmQuotationHeader").serializeArray()

		if ($('#ocbStaExpress:checked').val() == 'on') {
			nStaExpress = 1
		} else {
			nStaExpress = 0
		}
		if ($('#ocbtStaDocActive:checked').val() == 'on') {
			nStaDocActive = 1
		} else {
			nStaDocActive = 0
		}
		if ($('#ocbStaDeli:checked').val() == 'on') {
			nStaDeli = 1
		} else {
			nStaDeli = 0
		}

		tDocNo 			= $("#ospDocNo").attr("data-docno");
		nB4Dis 			= $("#otdDocNetTotal").text();
		nDis 			= $("#ospXqhDis").text();
		tDisText 		= $("#oetXqhDisText").val();
		nAfDis 			= $("#otdNetAFHD").text();
		nVatRate 		= $("#oetVatRate").val();
		nAmtVat 		= $("#otdVat").text();
		nGrandTotal 	= $("#otdGrandTotal").text();
		tDocRemark 		= $("#otaDocRemark").val();

		$.ajax({
			url		: 'r_quodocsavedoc',
			timeout: 0,
			type	: 'POST',
			data	: {
				oDocHeaderInfo	: oDocHeaderInfo,
				oDocCstInfo		: oDocCstInfo,
				tDocNo			: tDocNo,
				nStaExpress		: nStaExpress,
				nStaDocActive	: nStaDocActive,
				nStaDeli		: nStaDeli,
				nB4Dis			: nB4Dis,
				nDis			: nDis,
				nAfDis			: nAfDis,
				tDisText		: tDisText,
				nVatRate		: nVatRate,
				nAmtVat			: nAmtVat,
				nGrandTotal		: nGrandTotal,
				tDocRemark		: tDocRemark
			},
			datatype : 'json'
		})
		.done(function(data) {
			alert('DOCNO : ' + tDocNo);
			if(data == 'expired'){
				alert('เซสชั่นของคุณหมดอายุ กรุณาเข้าสู่ระบบและทำรายการใหม่อีกครั้ง');
				window.location('<?=base_url('Login')?>')
			}else{

				$('.xCNDialog_Footer').css('display','block');
				$('.alert-success').addClass('show').fadeIn();
				$('.alert-success').find('.badge-success').text('สำเร็จ');
				$('.alert-success').find('.xCNTextShow').text('บันทึกข้อมูลใบเสนอราคาสำเร็จ');
				setTimeout(function(){
					$('.alert-success').find('.close').click();
					$('.xCNDialog_Footer').css('display','none');
				}, 3000);
				
				aDocInfo = JSON.parse(data)
		 			if (aDocInfo['nStaRender'] == 1) {

		 				$('#olbDocNo').text(aDocInfo['tXqhDocNo']);
		 				$('#olbDocNo').attr("data-docno", aDocInfo['tXqhDocNo']);
		 				$('#ospDocDate').text(aDocInfo['dDocDate']);

		 				//บันทึกผ่านเเล้ว จะมีปุ่ม อนุมัติ ยกเลิก
		 				$('.xCNCancel').removeClass('xCNHide');
		 				$('.xCNAprove').removeClass('xCNHide');

		 			}
			}

		})
		.fail(function(jqXHR, textStatus, errorThrown) {
			//serrorFunction();
		});

	}

	//ยกเลิกเอกสาร
	function FSxQUOCancleDocument(){
		tDocNo 	= $("#ospDocNo").attr("data-docno");
		$('#obtModalCancleDocument').click();

		$('.xCNConfirmCancleDocument').off();
		$('.xCNConfirmCancleDocument').on("click",function(){
			$.ajax({
				url		: 'r_quoCancleDocument',
				timeout: 0,
				type	: 'POST',
				data	: { tDocNo	: tDocNo },
				datatype: 'json'
			})
			.done(function(data) {
				$('#obtModalCancleDocument').click();
				$('.xCNDialog_Footer').css('display','block');
				$('.alert-success').addClass('show').fadeIn();
				$('.alert-success').find('.badge-success').text('สำเร็จ');
				$('.alert-success').find('.xCNTextShow').text('ยกเลิกเอกสารสำเร็จ');

				setTimeout(function(){
					FSvCallPageBackStep('r_quotationList');
				}, 500);

				setTimeout(function(){
					$('.alert-success').find('.close').click();
					$('.xCNDialog_Footer').css('display','none');
				}, 3000);

			})
			.fail(function(jqXHR, textStatus, errorThrown) {
				//serrorFunction();
			});
		});
	}

	//อนุมัติเอกสาร
	function FSxQUOAproveDocument(){
		tDocNo 	= $("#ospDocNo").attr("data-docno");
		$('#obtModalAproveDocument').click();

		$('.xCNConfirmDeleteAprove').off();
		$('.xCNConfirmDeleteAprove').on("click",function(){
			$.ajax({
				type	: "POST",
				url		: 'r_quoApproveDocument',
				timeout: 0,
				data 	: { tDocNo: tDocNo },
				cache	: false,
				timeout	: 0,
				success	: function (tResult) {
					$('#obtModalAproveDocument').click();
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('เอกสารอนุมัติสำเร็จ');

					setTimeout(function(){
						FSvCallPageBackStep('r_quotationList');
					}, 500);

					setTimeout(function(){
						$('.alert-success').find('.close').click();
						$('.xCNDialog_Footer').css('display','none');
					}, 3000);
				},
				error: function (jqXHR, textStatus, errorThrown) {
					alert(jqXHR, textStatus, errorThrown);
				}
			});
		});
	}

	//แก้ไขจำนวนสินค้าในหน้าเอกสาร
	function FSxQUOEditDocItemQty(e, poElm) {
		//See notes about 'which' and 'key'
		if (e.keyCode == 13) {

					nItemQTY = $(poElm).val();
					tQuoDocNo = $("#ospDocNo").attr("data-docno");
					nItemSeq = $(poElm).attr("data-seq");
					tPdtCode = $("#olbPdtCode"+nItemSeq).attr("data-pdtcode");
					nPdtUnitPrice = $("#oetPdtUnitPrice"+nItemSeq).val()
					nItemDiscount = $("#oetItemDiscount"+nItemSeq).val()

					//console.log(nItemQTY+'+'+tQuoDocNo+'+'+nItemSeq+'+'+nUnitPrice);


					$.ajax({
							url: 'r_quoEditItemQty',
							timeout: 0,
							type: 'POST',
							data: {
								tQuoDocNo: tQuoDocNo,
								nItemSeq: nItemSeq,
								nItemQTY: nItemQTY,
								tPdtCode : tPdtCode,
								nPdtUnitPrice : nPdtUnitPrice,
								nItemDiscount : nItemDiscount
							},
							datatype: 'json'
						})
						.done(function(data) {
               //console.log(data)
						   FSvQUODocItems();

						})
						.fail(function(jqXHR, textStatus, errorThrown) {
							//serrorFunction();
						});

					return false;
		}
	}

	//แก้ไขราคาขายต่อหน่วยในหน้าเอกสาร
	function FSxQUOEditDocItemPri(e, poElm) {
		//See notes about 'which' and 'key'
		if (e.keyCode == 13) {

					nPdtUnitPrice = $(poElm).val();
					tQuoDocNo = $("#ospDocNo").attr("data-docno");
					nItemSeq = $(poElm).attr("data-seq");
					tPdtCode = $("#olbPdtCode"+nItemSeq).attr("data-pdtcode");
					nItemDiscount = $("#oetItemDiscount"+nItemSeq).val()
          nItemQTY = $("#oetDocItemQty"+nItemSeq).val()
					//console.log(nPdtUnitPrice+'+'+tQuoDocNo+'+'+nItemSeq+'+'+tPdtCode+'+'+nItemDiscount);

          nPdtCost = $("#oblPdtCost"+nItemSeq).text()
					nPdtUnitPriceCng = nPdtUnitPrice.replace(/,/g, "");
          nPdtCost = nPdtCost.replace(/,/g, "");

					if(parseFloat(nPdtUnitPriceCng) < parseFloat(nPdtCost) && parseFloat(nPdtUnitPriceCng) !=0){

									alert("ไม่อนุญาติขายต่ำกว่าราคาต้นทุน");

									FSvQUODocItems();

					}else{
							$.ajax({
								 url: 'r_quoEditItemPrice',
								 timeout: 0,
								 type: 'POST',
								 data: {
									 tQuoDocNo: tQuoDocNo,
									 nItemSeq: nItemSeq,
									 nItemQTY: nItemQTY,
									 tPdtCode : tPdtCode,
									 nPdtUnitPrice : nPdtUnitPrice,
									 nItemDiscount : nItemDiscount
								 },
								 datatype: 'json'
							 })
							 .done(function(data) {
									 //console.log(data)
									FSvQUODocItems();

							 })
							 .fail(function(jqXHR, textStatus, errorThrown) {
								 //serrorFunction();
							 });
					}
					return false;
		}
	}

  	//ส่วนลดรายการ
	function FSxQUODocItemDiscount(e, poElm) {
		//See notes about 'which' and 'key'
		if (e.keyCode == 13) {

					nItemDiscount = $(poElm).val();
					tQuoDocNo = $("#ospDocNo").attr("data-docno");
					nItemSeq = $(poElm).attr("data-seq");
					tPdtCode = $("#olbPdtCode"+nItemSeq).attr("data-pdtcode");
          nItemNet = $("#olbItemNet"+nItemSeq).text()
					//console.log(nItemDiscount+'+'+tQuoDocNo+'+'+nItemSeq+'+'+nUnitPrice);
          if($(poElm).val() != ''){
								$.ajax({
										url: 'r_quoItemDiscount',
										timeout: 0,
										type: 'POST',
										data: {
											tQuoDocNo: tQuoDocNo,
											nItemSeq: nItemSeq,
											nItemDiscount: nItemDiscount,
											tPdtCode : tPdtCode,
											nItemNet : nItemNet
										},
										datatype: 'json'
									})
									.done(function(data) {
										 //console.log(data)
										 FSvQUODocItems();

									})
									.fail(function(jqXHR, textStatus, errorThrown) {
										//serrorFunction();
									});

								return false;
					}
		}
	}

	//ส่วนท้ายบิล
	function FSxQUODocFootDis(e, poElm) {
		//See notes about 'which' and 'key'
		if (e.keyCode == 13) {

					nDiscount = $(poElm).val();
					tQuoDocNo = $("#ospDocNo").attr("data-docno");
          nNetฺฺB4HD = $("#otdDocNetTotal").text()

					//console.log(nDiscount+'+'+tQuoDocNo+'+'+nNetฺฺB4HD);
          if($(poElm).val() != ''){

								$.ajax({
										url: 'r_quoDocFootDiscount',
										timeout: 0,
										type: 'POST',
										data: {
											tQuoDocNo: tQuoDocNo,
											nDiscount: nDiscount,
											nNetฺฺB4HD : nNetฺฺB4HD
										},
										datatype: 'json'
									})
									.done(function(data) {
										 $("#ospXqhDis").text(data)

										 nFootDiscount = parseFloat(data)
										 nNetฺฺB4HD = nNetฺฺB4HD.replace(/,/g, "");
										 nNetAFHD = parseFloat(nNetฺฺB4HD) - parseFloat(nFootDiscount)

										 $("#ospXqhDis").text(accounting.formatMoney(nFootDiscount.toFixed(2), ""))
										 $("#otdNetAFHD").text(accounting.formatMoney(nNetAFHD.toFixed(2), ""))

										nVatType = $("#ocmVatType").val()
						 				nVatRate = $("#oetVatRate").val()
						 				nVat 		= 0
						 				nGrandTotal = 0

						 				if (nVatType == "1") {

						 					nVat = ((nNetAFHD * (100 + parseInt(nVatRate))) / 100) - nNetAFHD
						 					nGrandTotal = parseFloat(nNetAFHD) + parseFloat(nVat.toFixed(2))

						 				} else {
						 					nVat = nNetAFHD - ((nNetAFHD * 100) / (100 + parseInt(nVatRate)))
						 					nGrandTotal = parseFloat(nNetAFHD)
						 				}

						 				$("#otdVat").text(accounting.formatMoney(nVat.toFixed(2), ""))
										$("#otdGrandTotal").text(accounting.formatMoney(nGrandTotal.toFixed(2), ""))



									})
									.fail(function(jqXHR, textStatus, errorThrown) {
										//serrorFunction();
									});

								return false;
					}
		}
	}

  	//กลับไปหน้าเพิ่มสินค้าเข้าเอกสาร
	function FSxQUOBackToCart(){

		$.ajax({
				url: 'r_quotation/2',
				timeout: 0,
				type: 'GET',
				data: {},
				datatype: 'json'
			})
			.done(function(data) {
           $('.content').html(data);
			})
			.fail(function(jqXHR, textStatus, errorThrown) {
				//serrorFunction();
			});
	}

</script>
