<style>
	.card-header{
		background-color: #67717d;
		height: 40px;
		padding: 0rem 0.75rem;
	}

	.xCNIconDocument{
		width: 35px;
		text-align: center;
		display: block;
		margin: 10px;
	}

	.count{
		font-weight: bold;
	}
</style>

<?php
	$aPermission = FCNaPERGetPermissionByPage('r_user');
	$aPermission = $aPermission[0];
	if($aPermission['P_edit'] != 1){ $tPer_edit = 'xCNHide'; }else{ $tPer_edit = ''; }
?> 

<div class="container-fulid">
	<!--Section ล่าง-->
	<div class="row">

		<div class="col-lg-3" style="margin-top: 10px;">
			<!--ตัวเลขเอกสาร-->
			<div class="animated fadeIn">
				<!-- Widgets  -->
				<div class="row">
					
					<!--จำนวนสินค้าทั้งหมดในระบบ-->
					<div class="col-lg-12 col-md-6">
						<div class="card">
							<div class="card-body">
								<div class="stat-widget-five">
								<div class="stat-icon dib flat-color-1">
										<?php $tPathImage = './application/assets/images/icon/Cart.png';?>
										<img class="img-responsive xCNImgCenter xCNIconDocument" src="<?=$tPathImage;?>" style="width: 45px;">
									</div>
									<div class="stat-content">
										<div class="text-left dib">
											<div><span class="count"><?=(float)$aCountProductAll?></span> ชิ้น</div>
											<div><span>จำนวนสินค้าทั้งหมดในระบบ</span></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>	

					<!--เอกสารทั้งหมดตามสาขา-->
					<div class="col-lg-12 col-md-6">
						<div class="card">
							<div class="card-body">
								<div class="stat-widget-five">
									<div class="stat-icon dib flat-color-1">
										<?php $tPathImage = './application/assets/images/icon/DocAll.png';?>
										<img class="img-responsive xCNImgCenter xCNIconDocument" src="<?=$tPathImage;?>" >
									</div>
									<div class="stat-content">
										<div class="text-left dib">
											<div><span class="count"><?=(float)$aCountQutationAll?></span> รายการ</div>
											<div><span>ใบเสนอราคาทั้งหมด</span></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!--เอกสารที่อนุมัติแล้ว-->
					<div class="col-lg-12 col-md-6">
						<div class="card">
							<div class="card-body">
								<div class="stat-widget-five">
									<div class="stat-icon dib flat-color-3">
										<?php $tPathImage = './application/assets/images/icon/DocApv.png';?>
										<img class="img-responsive xCNImgCenter xCNIconDocument" src="<?=$tPathImage;?>">
									</div>
									<div class="stat-content">
										<div class="text-left dib">
											<div><span class="count"><?=(float)$aCountQutationAprove?></span> รายการ</div>
											<div><span>ใบเสนอราคาที่ผ่านอนุมัติ</span></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!--เอกสารที่ถูกยกเลิก-->
					<div class="col-lg-12 col-md-6">
						<div class="card">
							<div class="card-body">
								<div class="stat-widget-five">
									<div class="stat-icon dib flat-color-4">
										<?php $tPathImage = './application/assets/images/icon/DocCan.png';?>
										<img class="img-responsive xCNImgCenter xCNIconDocument" src="<?=$tPathImage;?>">
									</div>
									<div class="stat-content">
										<div class="text-left dib">
											<div><span class="count"><?=(float)$aCountQutationCancle?></span> รายการ</div>
											<div><span>ใบเสนอราคาที่ถูกยกเลิก</span></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-9" style="margin-top: 10px;">
			<div class="accordion" id="accordionExample">
				
				<!--ข้อมูลผู้ใช้-->
				<div class="card">
					<div class="card-header">
						<h2 class="mb-0">
							<button style="margin-top: -8px; color: #FFF;" class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
								ข้อมูลผู้ใช้
							</button>
						</h2>
					</div>

					<div id="collapseOne" class="collapse show" data-parent="#accordionExample">
						<div class="card-body">
							<div class="row">
									
								<div class="col-lg-12" style="margin-top: -10px; margin-bottom: 10px;">
									<?php if($tPer_edit != 'xCNHide'){
										if($this->session->userdata('tSesUsercode') != 1){ ?> <!--ถ้าเป็น useradmin แก้ไขไม่ได้-->
											<button class="xCNButtonSave pull-right" onclick="JSwUserCallPageInsert('edit','<?=$this->session->userdata('tSesUsercode')?>');">แก้ไขข้อมูล</button>
										<?php } ?>
									<?php } ?>
								</div>

								<div class="col-lg-4">
									<?php 
										$FTUsrImgPath = $aGetInfomation[0]['FTUsrImgPath'];
										if(@$FTUsrImgPath != '' || @$FTUsrImgPath != null){
											$tPathImage = './application/assets/images/user/'.@$FTUsrImgPath;
											if (file_exists($tPathImage)){
												$tPathImage = base_url().'application/assets/images/user/'.@$FTUsrImgPath;
											}else{
												$tPathImage = base_url().'application/assets/images/user/NoImage.png';
											}
										}else{
											$tPathImage = './application/assets/images/user/NoImage.png';
										}
									?>
									<img id="oimImgInformation" class="img-responsive xCNImgCenter" src="<?=$tPathImage;?>">
								</div>
								<div class="col-lg-8">
									<table class="table table-striped xCNTableCenter" id="otbConfirmImgPDT">
										<tbody>
											<tr style="font-weight: bold;">
												<td colspan='2'> ยินดีต้อนรับ คุณ <span><?=$aGetInfomation[0]['FTUsrFName'] . ' ' . $aGetInfomation[0]['FTUsrLName'];?></span></td> 
											</tr>
											<tr>
												<td> สาขา : </td> 
												<td> <span class="ospValue"><?=($aGetInfomation[0]['FTBchName'] == '') ? 'ไม่ระบุสาขา' : $aGetInfomation[0]['FTBchName'];?></span> </td>
											</tr>
											<tr>
												<td> แผนก : </td> 
												<td> <span class="ospValue"><?=($aGetInfomation[0]['FTUsrDep'] == '') ? 'ไม่พบแผนก' : $aGetInfomation[0]['FTUsrDep'];?></span> </td>
											</tr>
											<tr>
												<td> กลุ่มสิทธิ์ : </td> 
												<td> <span class="ospValue"><?=($aGetInfomation[0]['FTRhdName'] == '') ? 'ไม่พบกลุ่มสิทธิ์' : $aGetInfomation[0]['FTRhdName'];?></span> </td>
											</tr>
											<tr>
												<td> กลุ่มราคา : </td> 
												<td> <span class="ospValue"><?=($aGetInfomation[0]['FTPriGrpName'] == '') ? 'ไม่พบกลุ่มราคา' : $aGetInfomation[0]['FTPriGrpName'];?></span> </td>
											</tr>
											<tr>
												<td> หมายเหตุ : </td> 
												<td> <span class="ospValue"><?=($aGetInfomation[0]['FTUsrRmk'] == '') ? '-' : $aGetInfomation[0]['FTUsrRmk'];?></span> </td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!--ประวัติการทำการเอกสาร-->
				<div class="card">
					<div class="card-header">
					<h2 class="mb-0">
						<button style="margin-top: -8px; color: #FFF;" class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
							ประวัติการทำเอกสารใบเสนอราคา 
						</button>
					</h2>
					</div>
					<div id="collapseTwo" class="collapse" data-parent="#accordionExample">
						<div class="card-body">
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
									<div id="odvContentHistoryDocQuotation" style="margin-top: 10px;"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>	
</div>

<script>  
	//ตัวเลขวิ่งเอง
	$('.count').each(function() {
        $(this).prop('Counter', 0).animate({
            Counter: $(this).text()
        }, {
            duration: 3000,
            easing: 'swing',
            step: function(now) {
                $(this).text(Math.ceil(now));
            }
        });
    });

	//หน้าตาราง เอกสารใบเสนอราคา ของผู้ใช้
	JSwLoadTableList(1);
	function JSwLoadTableList(pnPage){
		$.ajax({
			type	: "POST",
			url		: "r_informationquotationListByUser",
			data 	: {
						'nPage' 		: pnPage,
						'tSearchAll' 	: $('#oetSearch').val()
					  },
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				JSxModalProgress('close');
				$('#odvContentHistoryDocQuotation').html(tResult);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert(jqXHR, textStatus, errorThrown);
			}
		});
	}

	//เข้าหน้าแก้ไขผู้ใช้
	function JSwUserCallPageInsert(ptType,ptCode){
		JSxModalProgress('open');
		$.ajax({
			type	: "POST",
			url		: "r_usercallpageInsertorEdit",
			data 	: {
						'tTypepage'  : 'edit',
						'tCode'	 	 : ptCode
					  },
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				JSxModalProgress('close');
				$('.content').html(tResult);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert(jqXHR, textStatus, errorThrown);
			}
		});
	}
</script>
