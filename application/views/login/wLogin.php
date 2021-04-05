<!doctype html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Prowork</title>
    <link rel="shortcut icon" 	href="<?=base_url('application/assets/images/48x48.png')?>">
	<link rel="shortcut icon" 	href="<?=base_url('application/assets/images/48x48.png')?>">
	<link rel="stylesheet" 		href="<?=base_url('application/assets/css/bootstrap.css')?>">
	<link rel="stylesheet" 		href="<?=base_url('application/assets/css/prowork.common.css')?>">
	<link rel="stylesheet" 		href="<?=base_url('application/assets/css/prowork.login.css')?>">
</head>
<body>
	<div class="container-fluid">
		<div class="row">

			<div class="col-lg-7">
				<div class="card login">

					<div id="odvCheckProgress" style="display:none;">
						<div class="lds-ripple"><div></div><div></div></div>
					</div>

					<div id="odvContentLogin">
						<img id="oimLogin" src="<?=base_url('application/assets/')?>images/logo.jpg">
            			<p style="text-align:center;color:green">Version 0.6.11-05042021</p>
						<form id="ofmLogin" class="form-signin" method="post">
							<div class="input">
								<label class="olbLabelLogin">ชื่อผู้ใช้</label>
								<input type="text" id="oetUserLogin" name="oetUserLogin" placeholder="กรุณากรอกชื่อผู้ใช้งาน" />
							</div>

							<div class="input">
								<label class="olbLabelLogin">รหัสผ่าน</label>
								<input type="password" id="oetPassword" name="oetPassword" placeholder="********" />
							</div>
							<span class="ospUserOrPasswordFail">ํ</span>
							<!-- <span class="ospForgetPassword">ลืมรหัสผ่าน</span> -->
							<div class="clearfix"></div>
							<button class="osmLogin" type="submit">เข้าสู่ระบบ</button>
						</form>
					</div>
				</div>
			</div>

			<div class="d-none d-lg-block col-lg-5" style="padding: 0px;">
				<div id="oimLoginScreenRight">
					<div class="xCNDivSlo-grand">
						<span id="ospSlo-grand1">โปรเวิร์ค</span><br>
						<span id="ospSlo-grand2">รู้จริงเรื่องไฟฟ้า</span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Forget Password -->
	<button id="obtModalForgetPassword" style="display:none;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#odvModalForgetPassword"></button>
	<div class="modal fade" id="odvModalForgetPassword" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">ลืมรหัสผ่าน</h5>
			</div>
			<div class="modal-body">
				<div class="input">
					<label class="olbLabelLoginForgetPassword"><span style="color:red;">*</span> อีเมลล์</label>
					<input type="text" id="oetForgetPasswordMailLogin" maxlength="100" name="oetForgetPasswordMailLogin" placeholder="กรุณากรอกอีเมลล์" />
				</div>
				<div class="input">
					<label class="olbLabelLoginForgetPassword"><span style="color:red;">*</span> ชื่อผู้ใช้งาน</label>
					<input type="text" id="oetForgetPasswordUserLogin" maxlength="20" name="oetForgetPasswordUserLogin" placeholder="กรุณากรอกชื่อผู้ใช้งาน" />
				</div>
				<div class="input">
					<label class="olbLabelLoginForgetPassword"><span style="color:red;">*</span> รหัสผ่านใหม่</label>
					<input type="password" id="oetForgetPasswordPassLogin" maxlength="225" name="oetForgetPasswordPassLogin" placeholder="********" />
				</div>
				<span class="ospUserFail">ํ</span>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary xCNCloseDelete" data-dismiss="modal" style="width: 100px;">ปิด</button>
				<button type="button" class="btn btn-success xCNConfirmDelete xCNConfirmForgetPassword">ยืนยัน</button>
			</div>
			</div>
		</div>
	</div>


	<script src="<?=base_url('application/assets/js/')?>jquery.min.js"></script>
	<script src="<?=base_url('application/assets/js/')?>bootstrap.min.js"></script>
	<script src="<?=base_url('application/assets/js/')?>jquery.validate.min.js"></script>

	<script>
		//กำหนดความสูงให้
		var cHeightScreen = $(window).height();
		$('#oimLoginScreenRight').css('height',cHeightScreen);

		//ทุกครั้งที่ Key ข้อความต้องหาย
		$('#oetUserLogin , #oetPassword').click(function () {
			$('.ospUserOrPasswordFail').removeClass('xCNTextRed');
			$('.ospUserOrPasswordFail').text('ํ');
		});

		//เข้าสู่ระบบ
		$("#ofmLogin").validate({
			rules: {
				oetUserLogin	: "required",
				oetPassword		: "required"
			},
			messages: {
				oetUserLogin 	: "กรุณากรอกชื่อผู้ใช้",
				oetPassword	 	: "กรุณากรอกรหัสผ่าน"
			},
			submitHandler: function(form) {

				$('.ospUserOrPasswordFail').removeClass('xCNTextRed');
				$('.ospUserOrPasswordFail').text('ํ');
				$('#odvCheckProgress').fadeIn("slow");

				setTimeout(() => {
					$.ajax({
						type	: "POST",
						url		: "CheckLogin",
						data	: $('#ofmLogin').serialize(),
						cache	: false,
						timeout	: 0,
						success	: function (tResult) {

							var aReturn = JSON.parse(tResult);
							if(aReturn.rtCode == '800'){
								$('#odvCheckProgress').fadeOut("slow");
								$('.ospUserOrPasswordFail').text('ชื่อผู้ใช้งาน หรือรหัสผ่านผิดพลาดกรุณาลองใหม่อีกครั้ง');
								$('.ospUserOrPasswordFail').addClass('xCNTextRed');
								$('.ospUserOrPasswordFail').fadeIn("slow");
							}else if(aReturn.rtCode == '400'){
								$('#odvCheckProgress').fadeOut("slow");
								$('.ospUserOrPasswordFail').text('ไม่อนุญาติให้เข้าใช้งาน กรุณาติดต่อเจ้าหน้าที่');
								$('.ospUserOrPasswordFail').addClass('xCNTextRed');
								$('.ospUserOrPasswordFail').fadeIn("slow");
							}else{
								$('#oetUserLogin').val('');
								$('#oetPassword').val('');
								window.location.href = '<?=base_url('Mainpage')?>';
							}
						},
						error: function (jqXHR, textStatus, errorThrown) {
							alert(jqXHR, textStatus, errorThrown);
						}
					});
				}, 1000);
			}
		});

		//ทุกครั้งที่ Key ข้อความต้องหาย
		$('#oetForgetPasswordUserLogin , #oetForgetPasswordMailLogin , #oetForgetPasswordPassLogin').click(function () {
			$('.ospUserFail').removeClass('xCNTextRed');
			$('.ospUserFail').text('ํ');
		});

		//ลืมรหัสผ่าน
		$('.ospForgetPassword').click(function () {

			//ล้างค่าก่อนเสมอ
			$('#oetForgetPasswordUserLogin').val('');
			$('#oetForgetPasswordMailLogin').val('');
			$('#oetForgetPasswordPassLogin').val('');
			$('.ospUserFail').removeClass('xCNTextRed');
			$('.ospUserFail').removeClass('xCNTextGreen');

			$('#obtModalForgetPassword').click();
			$('.xCNConfirmForgetPassword').off();
			$('.xCNConfirmForgetPassword').on("click",function(){

				if($('#oetForgetPasswordMailLogin').val() == ''){
					$('#oetForgetPasswordMailLogin').focus();
					return;
				}

				if($('#oetForgetPasswordUserLogin').val() == ''){
					$('#oetForgetPasswordUserLogin').focus();
					return;
				}

				if($('#oetForgetPasswordPassLogin').val() == ''){
					$('#oetForgetPasswordPassLogin').focus();
					return;
				}

				$.ajax({
					type	: "POST",
					url		: "ForgetPassword",
					data	: {
						'tUserLogin' : $('#oetForgetPasswordUserLogin').val(),
						'tEmail'	 : $('#oetForgetPasswordMailLogin').val(),
						'tNewPass'	 : $('#oetForgetPasswordPassLogin').val()
					},
					cache	: false,
					timeout	: 0,
					success	: function (tResult) {
						var aReturn = JSON.parse(tResult);
						if(aReturn.rtCode == '800'){
							$('.ospUserFail').removeClass('xCNTextGreen');
							$('.ospUserFail').text('ไม่พบผู้ใช้งาน กรุณาลองใหม่อีกครั้ง');
							$('.ospUserFail').addClass('xCNTextRed');
							$('.ospUserFail').fadeIn("slow");
						}else{
							$('.ospUserFail').text('แก้ไขรหัสผ่านใหม่สำเร็จแล้ว กรุณาเข้าสู่ระบบใหม่อีกครั้ง');
							$('.ospUserFail').addClass('xCNTextGreen');
							$('.ospUserFail').fadeIn("slow");
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						alert(jqXHR, textStatus, errorThrown);
					}
				});
			});
		});

	</script>

</body>
</html>
