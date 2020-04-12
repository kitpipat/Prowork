<?php
	$tLevelUser = $this->session->userdata('tSesUserLevel');
	if($tTypePage == 'insert'){
		$tRoute 			= 'r_producteventinsert';
		$tRouteUrl			= 'สร้างสินค้า';
		$FTPdtStatus       	= 1;
	}else if($tTypePage == 'edit'){
		$FTPdtCode			= $aResult[0]['FTPdtCode'];
		$FTBchCode 			= $aResult[0]['FTBchCode'];
		$FTPdtName 			= $aResult[0]['FTPdtName'];
		$FTPdtNameOth 		= $aResult[0]['FTPdtNameOth'];
		$FTPdtDesc 			= $aResult[0]['FTPdtDesc'];
		$FTPunCode 			= $aResult[0]['FTPunCode'];
		$FTPgpCode 			= $aResult[0]['FTPgpCode'];
		$FTPtyCode 			= $aResult[0]['FTPtyCode'];
		$FTPbnCode 			= $aResult[0]['FTPbnCode'];
		$FTPzeCode 			= $aResult[0]['FTPzeCode'];
		$FTPClrCode 		= $aResult[0]['FTPClrCode'];
		$FTSplCode 			= $aResult[0]['FTSplCode'];
		$FTMolCode 			= $aResult[0]['FTMolCode'];
		$FCPdtCostStd	 	= $aResult[0]['FCPdtCostStd'];
		$FTPdtCostDis 		= $aResult[0]['FTPdtCostDis'];
		$FCPdtSalPrice 		= $aResult[0]['FCPdtSalPrice'];
		$FTPdtImage 		= $aResult[0]['FTPdtImage'];
		$FTPdtStatus		= $aResult[0]['FTPdtStatus'];
		$tRoute 			= 'r_producteventedit';
		$tRouteUrl			= 'แก้ไขสินค้า';
	}
?>

<div class="container-fulid">
	
	<form id="ofmProduct" class="form-signin" method="post" action="javascript:void(0)">

		<input type="hidden" id="ohdProductCode" name="ohdProductCode" value="<?=@$FTPdtCode;?>">

		<!--Section บน-->
		<div class="row">
			<div class="col-lg-6 col-md-6"><span class="xCNHeadMenuActive" onclick="JSxCallPageProductMain();">สินค้า</span><span class="xCNHeadMenu">  /  <?=$tRouteUrl?></span></div>
			<div class="col-lg-6 col-md-6"><button class="xCNButtonSave pull-right" onclick="JSxEventSaveorEdit('<?=$tRoute?>');">บันทึก</button></div>
		</div>

		<!--Section ล่าง-->
		<div class="card" style="margin-top: 10px;">
			<div class="card-body">
				<div class="row">

					<!--รูปภาพ-->
					<div class="col-lg-4 col-md-4">
						<?php 
							if(@$FTPdtImage != '' || @$FTPdtImage != null){
								$tPathImage = './application/assets/images/products/'.@$FTPdtImage;
								if (file_exists($tPathImage)){
									$tPathImage = base_url().'application/assets/images/products/'.@$FTPdtImage;
								}else{
									$tPathImage = base_url().'application/assets/images/products/NoImage.png';
								}
							}else{
								$tPathImage = './application/assets/images/products/NoImage.png';
							}
						?>

						<img id="oimImgInsertorEditproducts" class="img-responsive xCNImgCenter" src="<?=$tPathImage;?>">
						<input type="hidden" id="oetImgInsertorEditproducts" name="oetImgInsertorEditproducts" value="<?=@$FTPdtImage;?>">
						<button type="button" class="btn btn-outline-secondary xCNChooseImage" onclick="JSxUploadImageproducts()">เลือกรูปภาพ</button>
						<input type="file" id="inputfileuploadImage" style="display:none"  name="inputfileuploadImage" accept="image/*" onchange="JSoImagUplodeResize(this,'images/products','ImgInsertorEditproducts')">
					</div>

					<!--รายละเอียด-->
					<div class="col-lg-8 col-md-8">
						<div style="display: block; text-align: right;"><span> วันที่สร้างข้อมูล : <?=date('d/m/Y')?> </span> <span> ปรับปรุงล่าสุด : N/A </span></div>
						
						<!--ชื่อสินค้า-->
						<div class="form-group">
							<label>ชื่อสินค้า</label>
							<input type="text" class="form-control" maxlength="100" id="oetPDTName" name="oetPDTName" placeholder="กรุณาระบุชื่อสินค้า" autocomplete="off" value="<?=@$FTPdtCode;?>">
						</div>
					</div>



				</div>
			</div>
		</div>
	</form>
<div>

<script src="<?= base_url('application/assets/js/jFormValidate.js')?>"></script>
<script>

	//อีเวนท์บันทึกข้อมูล
	function JSxEventSaveorEdit(ptRoute){

		if($('#oetBANName').val() == ''){
			$('#oetBANName').focus();
			return;
		}

		$.ajax({
			type	: "POST",
			url		: ptRoute,
			data 	: $('#ofmProduct').serialize(),
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				if(tResult == 'pass_insert'){
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('ลงทะเบียนสินค้าสำเร็จ');
					JSxCallPageProductMain();
					setTimeout(function(){
						$('.alert-success').find('.close').click();
					}, 3000);
				}else if(tResult == 'pass_update'){
					$('.alert-success').addClass('show').fadeIn();
					$('.alert-success').find('.badge-success').text('สำเร็จ');
					$('.alert-success').find('.xCNTextShow').text('แก้ไขข้อมูลสินค้าสำเร็จ');
					JSxCallPageProductMain();
					setTimeout(function(){
						$('.alert-success').find('.close').click();
					}, 3000);
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert(jqXHR, textStatus, errorThrown);
			}
		});
	}
</script>
