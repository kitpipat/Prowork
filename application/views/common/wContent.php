<!-- Content -->
<div class="content"></div>

<script>
	//โหลดหน้าตา
	JSwLoadInfomation();
	function JSwLoadInfomation(){
		$.ajax({
			type	: "POST",
			url		: "r_information",
			cache	: false,
			timeout	: 0,
			success	: function (tResult) {
				var nWidth = $('#left-panel').width();
				if(nWidth > 70){
					$('#menuToggle').click();
				}
				$('.content').html(tResult);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert(jqXHR, textStatus, errorThrown);
			}
		});
	}
</script>
