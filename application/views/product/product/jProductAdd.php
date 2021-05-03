<script>
	//เลือกลูกค้า
	function JSxChooseAttribute(ptName){
		var tName = ptName.toLowerCase();
		switch(tName) {
			case 'brand':
				var tTextName = 'เลือกยี่ห้อสินค้า';
				break;
			case 'color':
				var tTextName = 'เลือกสีสินค้า';
				break;
			case 'group':
				var tTextName = 'เลือกกลุ่มสินค้า';
				break;
			case 'modal':
				var tTextName = 'เลือกรุ่นสินค้า';
				break;
			case 'size':
				var tTextName = 'เลือกขนาดสินค้า';
				break;
			case 'unit':
				var tTextName = 'เลือกหน่วยสินค้า';
				break;
			case 'type':
				var tTextName = 'เลือกประเภทสินค้า';
				break;
			case 'spl':
				var tTextName = 'เลือกผู้จำหน่าย';
				break;
			default:
		}

		$('#ohdNameAttribute').val(tName);
		$('#ospNameSelectAttribute').text(tTextName)

		$('#obtModalSelectAttribute').click();
		$('#oetSearchAttribute').val('');
		JSxSelectAttribute(1);
	}

	//เลือกลูกค้า
	function JSxSelectAttribute(pnPage){
		$.ajax({
			type	: "POST",
			url		: "r_selectAttribute",
			data 	: { 'nPage' : pnPage , 'tSearchAttribute' : $('#oetSearchAttribute').val() , 'tName' : $('#ohdNameAttribute').val() },
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				$('#odvContentAttribute').html(tResult);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				JSxModalErrorCenter(jqXHR.responseText);
			}
		});
	}

	//ยืนยัน
	function JSxConfirmAttribute(){
		var LocalItemSelect = localStorage.getItem("LocalItemDataAttr");
		var tName 			= $('#ohdNameAttribute').val();
		switch(tName.toLowerCase()) {
			case 'brand':
				var tIDElemName = 'oetPDTBrand_Name';
				var tIDElemCode = 'oetPDTBrand';
				break;
			case 'color':
				var tIDElemName = 'oetPDTColor_Name';
				var tIDElemCode = 'oetPDTColor';
				break;
			case 'group':
				var tIDElemName = 'oetPDTGroup_Name';
				var tIDElemCode = 'oetPDTGroup';
				break;
			case 'modal':
				var tIDElemName = 'oetPDTModal_Name';
				var tIDElemCode = 'oetPDTModal';
				break;
			case 'size':
				var tIDElemName = 'oetPDTSize_Name';
				var tIDElemCode = 'oetPDTSize';
				break;
			case 'unit':
				var tIDElemName = 'oetPDTPunCode_Name';
				var tIDElemCode = 'oetPDTPunCode';
				break;
			case 'type':
				var tIDElemName = 'oetPDTType_Name';
				var tIDElemCode = 'oetPDTType';
				break;
			case 'spl':
				var tIDElemName = 'oetPDTSPL_Name';
				var tIDElemCode = 'oetPDTSPL';
				break;
			default:
		}

		if(LocalItemSelect !== null){
			var aResult = LocalItemSelect.split("##");

			var tvaluecode 		= aResult[0];
			var tvaluename 		= aResult[1];
			

			$('#'+tIDElemCode).val(tvaluecode);
			$('#'+tIDElemName).val(tvaluename);

			objAttr = [];
			localStorage.clear();
			$('#obtModalSelectAttribute').click();
		}else{
			$('#'+tIDElemCode).val('');
			$('#'+tIDElemName).val('');
			$('#obtModalSelectAttribute').click();
		}
	}


</script>
