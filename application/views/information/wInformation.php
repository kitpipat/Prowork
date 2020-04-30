<style>

	.tab_container {
		margin		: 0 auto;
		position	: relative;
	}

	input, section {
		clear		: both;
		padding-top	: 10px;
		display		: none;
	}

	label {
		display	: block;
		float	: left;
		width	: 15%;
		padding	: 0.65em;
		color	: #757575;
		cursor	: pointer;
		text-decoration: none;
		text-align		: center;
		background	: #f0f0f0;
	}

	#tab1:checked ~ #content1,
	#tab2:checked ~ #content2,
	#tab3:checked ~ #content3 {
		display			: block;
		padding			: 20px;
		background		: #fff;
		border-bottom	: 2px solid #f0f0f0;
	}

	.tab_container .tab-content h3  {
		text-align	: center;
	}

	.tab_container [id^="tab"]:checked + label {
		background	: #fff;
		box-shadow	: inset 0 3px #51c448;
	}

	.tab_container [id^="tab"]:checked + label .fa {
		color		: #51c448;
	}

	label .fa {
		font-size	: 12.5px;
		margin		: 0 0.6em 0 0;
	}

	.xCNImgCenter{
		width	:	200px !important;
		height	:	200px !important;
	}

	.ospValue{
		color: #5a5a5a;
	}

</style>

<div class="container-fulid">

	<!--Section บน-->
	<div class="row">
		<div class="col-lg-6 col-md-6"><span class="xCNHeadMenu">บัญชีส่วนตัว</span></div>
	</div>

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
			<div class="card">
				<div class="card-body">

					<!--tab-->
					<div class="row">
						<div class="col-lg-12">
							<div id="odvContent_Information" class="xCNContent">

								<div class="tab_container">
									<input id="tab1" type="radio" name="tabs" checked>
									<label for="tab1"><i class="fa fa-info"></i><span>รายละเอียด</span></label>

									<input id="tab2" type="radio" name="tabs">
									<label for="tab2"><i class="fa fa-cog"></i><span>เปลี่ยนรหัสผ่าน</span></label>

									<input id="tab3" type="radio" name="tabs">
									<label for="tab3"><i class="fa fa-file-text-o"></i><span>ประวัติเอกสาร</span></label>

									<!--รายละเอียด-->
									<section id="content1" class="tab-content">
										<div class="row">

											<div class="col-lg-3">
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
												<img id="oimImgInsertorEditUser" class="img-responsive xCNImgCenter" src="<?=$tPathImage;?>">
											</div>
											<div class="col-lg-6">
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
													
													<div class="col-lg-12" style="margin-top: 25px;">
														<button class="xCNButtonSave" onclick="JSxEventSaveorEdit('r_adjcosteventinsert');">แก้ไขข้อมูล</button>
													</div>
												</div>
											</div>
										</div>
										
									</section>

									<!--เปลี่ยนรหัสผ่าน-->
									<section id="content2" class="tab-content">
										<h3>Headline 2</h3>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
										tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
										quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo.</p>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
										tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
										quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
										consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
										cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
										proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
									</section>

									<!--ประวัติเอกสาร-->
									<section id="content3" class="tab-content">
										
									</section>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
<div>

<script>  
	//ตัวเลขวิ่งเอง
	JSxModalProgress('close');
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
