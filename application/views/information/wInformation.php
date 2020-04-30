

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
			<div class="card">
				<div class="card-body">

					<div class="container demo">

						<div class="accordion" id="accordionExample">
							<div class="card">
								<div class="card-header" id="headingOne">
								<h2 class="mb-0">
									<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
									Collapsible Group Item #1
									</button>
								</h2>
								</div>

								<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
								<div class="card-body">
									Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
								</div>
								</div>
							</div>
							<div class="card">
								<div class="card-header" id="headingTwo">
								<h2 class="mb-0">
									<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
									Collapsible Group Item #2
									</button>
								</h2>
								</div>
								<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
								<div class="card-body">
									Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
								</div>
								</div>
							</div>
							<div class="card">
								<div class="card-header" id="headingThree">
								<h2 class="mb-0">
									<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
									Collapsible Group Item #3
									</button>
								</h2>
								</div>
								<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
								<div class="card-body">
									Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
								</div>
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
</script>
