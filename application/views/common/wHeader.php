<!doctype html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Prowork</title>
    <link rel="shortcut icon" 	href="<?=base_url('application/assets/images/48x48.png')?>">
	<link rel="shortcut icon" 	href="<?=base_url('application/assets/images/48x48.png')?>">
	<link rel="stylesheet" 		href="<?=base_url('application/assets/css/bootstrap.css')?>">
    <link rel="stylesheet" 		href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" 		href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" 		href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
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
					<li class="active xCNMenuActive">
						<a href="Mainpage" class=""><i class="menu-icon fa fa-laptop"></i>บัญชีส่วนตัว </a>
					</li>
					<?php if($aMenuList['rtCode'] == 800){ ?> 

					<?php }else{ ?>
						<?php $nGroupOld = ''; ?>
						<?php foreach($aMenuList['raItems'] AS $nKey => $nValue){ ?>
							<?php if($nValue['CodeGroup'] == 0){ ?>
								<li>
									<a class='JSxCallContentMenu' data-menuname="<?=$nValue['PathRoute']?>" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
										<i class="menu-icon <?=$nValue['MenuIcon']?>"></i><?=$nValue['FTMenName'];?>
									</a>
								</li>
								<?php if($nValue['CodeMenu'] == 3){ ?><div id="odvLineGroupMenu"></div><?php } ?>
							<?php }else{ ?>
								<?php if($nGroupOld != $nValue['CodeGroup']){ ?>
									<li class="menu-item-has-children dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
											<i class="menu-icon <?=$nValue['GroupIcon']?>"></i>
										<?=$nValue['NameGroup'];?></a>
										<ul class="sub-menu children dropdown-menu">
											<?php foreach($aMenuList['raItems'] AS $nKey => $nValueSubMenu){ ?>
												<?php if($nValue['CodeGroup'] == $nValueSubMenu['CodeGroup']){ ?>
													<li><i class=""></i><a class='JSxCallContentMenu' data-menuname="<?=$nValueSubMenu['PathRoute']?>" ><?=$nValueSubMenu['FTMenName'];?></a></li>
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
					<a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
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
							<!-- <img class="user-avatar rounded-circle" src="<?=base_url('application/assets/')?>images/admin.jpg"> -->
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.14.3/xlsx.full.min.js"></script>

