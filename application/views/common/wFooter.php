	
			<!-- เคีลย์พวกค่า float -->
			<div class="clearfix"></div>
		</div>

		<!--อัพโหลดรูปภาพ-->
		<script>
			//อัพโหลดรูปภาพ ไฟล์เดียว - ใช้ทั้งระบบ
			function JSoImagUplodeResize(poImg,ptPath,ptIDelem){
				var oImgData = poImg.files[0];
				var oImgFrom = new FormData();
				oImgFrom.append('file',oImgData);
				oImgFrom.append('path', ptPath);
				
				$.ajax({
					type 			: "POST",
					url 			: "ImageUpload",
					cache 			: false,
					contentType		: false,
					processData		: false,
					data 			: oImgFrom,
					datatype		: "JSON",
					success: function (tResult){
						if(tResult!=""){
							var aResult 	= JSON.parse(tResult);
							var tImageName 	= aResult.tImgName;
							var tFullPath   = '<?=base_url('application/assets/')?>' + ptPath + '/' + tImageName;
							$('#oim' + ptIDelem).attr('src',tFullPath);
							$('#oet' + ptIDelem).val(tImageName);
						}
					},
					error: function (data){
						console.log(data);
					}
				});
			}

			//อัพโหลดรูปภาพแบบ Zip 
			function JSoExtractImageResize(poImg,ptPath){
				var oImgData 	= poImg.files[0];
				var oImgFromZip = new FormData();
				oImgFromZip.append('file',oImgData);
				oImgFromZip.append('path', ptPath);

				$('#olbModalProcessText').text('กรุณารอสักครู่ กำลังตรวจสอบไฟล์รูปภาพ');
				$('#obtModalProcess').click();

				//อัพโหลดรูปภาพแบบ Zip 
				$.ajax({
					type 			: "POST",
					url 			: "ImageUpload_zip",
					cache 			: true,
					contentType		: false,
					processData		: false,
					async			: true,
					data 			: oImgFromZip,
					datatype		: "JSON",
					complete		: function(xhr) {
						if(xhr == '1'){
							setTimeout(function(){
								return window['JSxFailUpLoadImage']();
							}, 1000);
						}else{
							setTimeout(function(){
								return window['JSxReturnExtractFileImage']();
							}, 1000);
						}
					},
					error: function (data){
						console.log(data);
					}
				});
			}

			//ฟังก์ชั่น modal progress
			function JSxModalProgress(ptEvent){
				if(ptEvent == 'open'){
					$('#odvCheckProgress').css('display','block');
				}else{
					$('#odvCheckProgress').css('display','none');
				}
			}
		</script>

		<!--แจ้งเตือนข้อความ-->
		<div class="xCNDialog_Footer"> 

			<!--สีแดง แจ้งเตือนข้อผิดพลาด-->
			<div class="sufee-alert alert with-close alert-danger alert-dismissible fade" >
				<span class="badge badge-pill badge-danger"></span>
				<span class="xCNTextShow"></span>
				<button type="button" class="close xCNCloseDialog">
					<span aria-hidden="true">×</span>
				</button>
			</div> 

			<!--สีเขียว สำเร็จ-->
			<div class="sufee-alert alert with-close alert-success alert-dismissible fade" >
				<span class="badge badge-pill badge-success"></span>
				<span class="xCNTextShow"></span>
				<button type="button" class="close xCNCloseDialog">
					<span aria-hidden="true">×</span>
				</button>
			</div>

			<script> 
				$(document).ready(function() {
					$('.xCNCloseDialog').click(function() { $(this).parent().removeClass('show'); }); 
				});
			</script>

		</div>
	</body>
</html>

