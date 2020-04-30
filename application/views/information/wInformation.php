<style>
	.card-header{
		background-color: #67717d;
		height: 40px;
		padding: 0rem 0.75rem;
	}
</style>

<div class="container-fulid">
	<!--Section ล่าง-->
	<div class="row">

		<div class="col-lg-3" style="margin-top: 10px;">
			<!--ตัวเลขเอกสาร-->
			<div class="animated fadeIn">
				<!-- Widgets  -->
				<div class="row">
					<div class="col-lg-12 col-md-6">
						<div class="card">
							<div class="card-body">
								<div class="stat-widget-five">
									<div class="stat-icon dib flat-color-1">
										<i class="pe-7s-cash"></i>
									</div>
									<div class="stat-content">
										<div class="text-left dib">
											<div class="stat-text">$<span class="count">23569</span></div>
											<div class="stat-heading">Revenue</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-12 col-md-6">
						<div class="card">
							<div class="card-body">
								<div class="stat-widget-five">
									<div class="stat-icon dib flat-color-2">
										<i class="pe-7s-cart"></i>
									</div>
									<div class="stat-content">
										<div class="text-left dib">
											<div class="stat-text"><span class="count">3435</span></div>
											<div class="stat-heading">Sales</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-12 col-md-6">
						<div class="card">
							<div class="card-body">
								<div class="stat-widget-five">
									<div class="stat-icon dib flat-color-3">
										<i class="pe-7s-browser"></i>
									</div>
									<div class="stat-content">
										<div class="text-left dib">
											<div class="stat-text"><span class="count">349</span></div>
											<div class="stat-heading">Templates</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-12 col-md-6">
						<div class="card">
							<div class="card-body">
								<div class="stat-widget-five">
									<div class="stat-icon dib flat-color-4">
										<i class="pe-7s-users"></i>
									</div>
									<div class="stat-content">
										<div class="text-left dib">
											<div class="stat-text"><span class="count">2986</span></div>
											<div class="stat-heading">Clients</div>
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
									
								<div class="col-lg-12" style="margin-top: 0px;">
									<button class="xCNButtonSave pull-right" onclick="JSxEventSaveorEdit('r_adjcosteventinsert');">แก้ไขข้อมูล</button>
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
									<span>คุณ </span><span><?=$aGetInfomation[0]['FTUsrFName'] . ' ' . $aGetInfomation[0]['FTUsrLName'];?></span><br>
									<div class="row">
										<div class="col-lg-2"><span>สาขา : </span></div>
										<div class="col-lg-9"><span class="ospValue"><?=($aGetInfomation[0]['FTBchName'] == '') ? 'ไม่ระบุสาขา' : $aGetInfomation[0]['FTBchName'];?></span></div>

										<div class="col-lg-2"><span>แผนก : </span></div>
										<div class="col-lg-9"><span class="ospValue"><?=($aGetInfomation[0]['FTUsrDep'] == '') ? 'ไม่พบแผนก' : $aGetInfomation[0]['FTUsrDep'];?></span></div>

										<div class="col-lg-2"><span>กลุ่มสิทธิ์ : </span></div>
										<div class="col-lg-9"><span class="ospValue"><?=($aGetInfomation[0]['FTRhdName'] == '') ? 'ไม่พบกลุ่มสิทธิ์' : $aGetInfomation[0]['FTRhdName'];?></span></div>

										<div class="col-lg-2"><span>กลุ่มราคา : </span></div>
										<div class="col-lg-9"><span class="ospValue"><?=($aGetInfomation[0]['FTPriGrpName'] == '') ? 'ไม่พบกลุ่มราคา' : $aGetInfomation[0]['FTPriGrpName'];?></span></div>

										<div class="col-lg-2"><span>หมายเหตุ : </span></div>
										<div class="col-lg-9"><span class="ospValue"><?=($aGetInfomation[0]['FTUsrRmk'] == '') ? '-' : $aGetInfomation[0]['FTUsrRmk'];?></span></div>
									</div>
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
							ประวัติการทำเอกสาร
						</button>
					</h2>
					</div>
					<div id="collapseTwo" class="collapse" data-parent="#accordionExample">
					<div class="card-body">
						S
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
</script>
