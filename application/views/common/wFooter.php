	<!-- เคีลย์พวกค่า float -->
	<div class="clearfix"></div>
	</div>
	<!-- ปิด -->

	<script>
		//อัพโหลดรูปภาพ - ใช้ทั้งระบบ
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
	</script>
	</body>
</html>

