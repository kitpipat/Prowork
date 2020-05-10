<!doctype html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Prowork</title>
    <link rel="shortcut icon" 	href="<?=base_url('application/assets/images/48x48.png')?>">
	<link rel="shortcut icon" 	href="<?=base_url('application/assets/images/48x48.png')?>">
	<link rel="stylesheet" 		href="<?=base_url('application/assets/css/bootstrap.css')?>">
    <link rel="stylesheet" 		href="<?=base_url('application/assets/css/cs-skin-elastic.css')?>">
	<link rel="stylesheet" 		href="<?=base_url('application/assets/css/style.css')?>">
	<link rel="stylesheet" 		href="<?=base_url('application/assets/css/prowork.menu.css')?>">
	<link rel="stylesheet" 		href="<?=base_url('application/assets/css/prowork.common.css')?>">
	<link rel="stylesheet" 		href="<?=base_url('application/assets/css/prowork.checkbox.css')?>">
	<link rel="stylesheet" 		href="<?=base_url('application/assets/css/bootstrap-datepicker.css')?>">

</head>
<body style="background: #f1f2f7;">

	<div id="odvCheckProgress" style="display:none;">
		<div class="lds-ripple">
			<div></div>
			<div></div>
		</div>
		<span id="ospLoadProgress">กำลังโหลดข้อมูล กรุณารอสักครู่</span>
	</div>

	<!-- เมนู -->
	<aside id="left-panel" class="left-panel">
		<nav class="navbar navbar-expand-sm navbar-default xCNWidthFull">
			<div id="main-menu" class="main-menu collapse navbar-collapse xCNWidthFull">
				<ul class="nav navbar-nav xCNWidthFull">
					<li class="xCNLiRow">
						<a href="Mainpage" class="xCNHomePage">
							<?php
								$tPathImage = './application/assets/images/icon/menu_home.png';
								if (file_exists($tPathImage)){
									$tPathImage = base_url().'application/assets/images/icon/menu_home.png';
								}else{
									$tPathImage = base_url().'application/assets/images/icon/NoImage.png';
								}
							?>
							<img class="menu-icon xCNSizeIconSubMenu xCNHomeFisrt" src="<?=$tPathImage?>">
							<img class="menu-icon xCNSizeIconSubMenu xCNHomeLast"  src="<?=base_url().'application/assets/images/icon/last_menu_home.png'?>">
						หน้าหลัก </a>
					</li>
					<?php if($aMenuList['rtCode'] == 800){ ?>

					<?php }else{ ?>
						<?php $nGroupOld = ''; ?>
						<?php foreach($aMenuList['raItems'] AS $nKey => $nValue){ ?>
							<?php if($nValue['CodeGroup'] == 0){ ?>
								<li class="xCNLiRow">	
									<a data-menuname="<?=$nValue['PathRoute']?>" class="JSxCallContentMenu dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<?php
											$tPathImage = './application/assets/images/icon/'.$nValue['MenuIcon'];
											if (file_exists($tPathImage)){
												$tPathImage = base_url().'application/assets/images/icon/'.$nValue['MenuIcon'];
											}else{
												$tPathImage = base_url().'application/assets/images/icon/NoImage.png';
											}
										?>
										<img class="menu-icon xCNSizeIconSubMenu xCNMainIcon" src="<?=$tPathImage?>">
										<img class="menu-icon xCNSizeIconSubMenu" src="<?=base_url().'application/assets/images/icon/last_'.$nValue['MenuIcon'].''?>">
										<?=$nValue['FTMenName'];?>
									</a>
								</li>
								<?php if($nValue['CodeMenu'] == 3){ ?><div id="odvLineGroupMenu"></div><?php } ?>
							<?php }else{ ?>
								<?php if($nGroupOld != $nValue['CodeGroup']){ ?>
									<li class="menu-item-has-children dropdown xCNLiRow">

										<?php $tPathImage = base_url().'application/assets/images/icon/'.$nValue['GroupIcon']; ?>
										<a href="#" class="dropdown-toggle xCNMenuImage" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-namesubmenu='<?=$nValue['NameGroup'];?>'>
											<?php
												$tPathImage = './application/assets/images/icon/'.$nValue['GroupIcon'];
												if (file_exists($tPathImage)){
													$tPathImage = base_url().'application/assets/images/icon/'.$nValue['GroupIcon'];
												}else{
													$tPathImage = base_url().'application/assets/images/icon/NoImage.png';
												}
											?>
											<img class="menu-icon xCNSizeIconSubMenu xCNMainIcon" src="<?=$tPathImage?>">
											<img class="menu-icon xCNSizeIconSubMenu" src="<?=base_url().'application/assets/images/icon/last_'.$nValue['GroupIcon'].''?>">
											<?=$nValue['NameGroup'];?>
										</a>

										<ul class="sub-menu children dropdown-menu">
											<?php foreach($aMenuList['raItems'] AS $nKey => $nValueSubMenu){ ?>
												<?php if($nValue['CodeGroup'] == $nValueSubMenu['CodeGroup']){ ?>
													<li><a class='JSxCallContentMenu xCNSub' data-menuname="<?=$nValueSubMenu['PathRoute']?>" ><?=$nValueSubMenu['FTMenName'];?></a></li>
												<?php } ?>
											<?php } ?>
										</ul>
									</li>

								<?php } ?>
								<?php $nGroupOld = $nValue['CodeGroup'];?>
							<?php } ?>
						<?php } ?>
					<?php } ?>
				</ul>
			</div>
		</nav>
	</aside>

	<!--บาร์เมนู-->
	<div id="right-panel" class="right-panel">
		<header id="header" class="header">
			<div class="top-left">
				<div class="navbar-header">
					<a id="menuToggle" class="menutoggle">
						<?php $tMenuBar = base_url().'application/assets/images/icon/listmenu.png'; ?>
						<img class="menu-icon xCNMenuBar" src="<?=$tMenuBar?>">
					</a>
					<a class="navbar-brand" href="./"><img src="<?=base_url('application/assets/')?>images/logo.jpg" alt="Logo"></a>
					<?php if($this->session->userdata('tSesBCHName') == ''){
						$tShowBCH = '';
					}else{
						$tShowBCH = '(' . $this->session->userdata('tSesBCHName') . ')';
					}
					?>
					<span class="xCNNameCompanyAndBCH"> <?=$this->session->userdata('tSesCMPName')?> <?=$tShowBCH?> </span>
				</div>
			</div>
			<div class="top-right">
				<div class="header-menu">
					<div class="user-area dropdown float-right">
						<a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span style="margin-right: 15px;"><?=$this->session->userdata('tSesFirstname')?> <?=$this->session->userdata('tSesLastname')?> (<?=$this->session->userdata('tSesDepartment')?>)</span>
						
						<?php
							$FTUsrImgPath = $this->session->userdata('tSesUsrImg');
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
                  		<img class="user-avatar rounded-circle" src="<?=$tPathImage?>">
						</a>
						<div class="user-menu dropdown-menu">
							<a class="nav-link xCNMenuProfile" href="Mainpage">บัญชีส่วนตัว</a>
							<a class="nav-link xCNMenuProfile" href="Logout">ออกจากระบบ</a>
						</div>
					</div>
				</div>
			</div>
		</header>


<!-- Scripts -->

<script src="<?=base_url('application/assets/js/')?>jquery-3.5.0.min.js"></script>
<script src="<?=base_url('application/assets/js/')?>jquery-ui.min.js"></script>
<script src="<?=base_url('application/assets/js/')?>popper.min.js"></script>
<script src="<?=base_url('application/assets/js/')?>bootstrap.min.js"></script>
<script src="<?=base_url('application/assets/js/')?>jquery.validate.min.js"></script>
<script src="<?=base_url('application/assets/js/')?>jquery.matchHeight.min.js"></script>
<script src="<?=base_url('application/assets/js/')?>main.js"></script>
<script src="<?=base_url('application/assets/js/')?>bootstrap-datepicker.js"></script>
<script src="<?=base_url('application/assets/js/')?>xlsx.full.min.js"></script>
<!-- <script src="https://kit.fontawesome.com/a65b409245.js" crossorigin="anonymous"></script> -->
