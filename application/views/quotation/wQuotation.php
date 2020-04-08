<div class="container-fulid">

			<!--Title-->
			<div class="row">
						<div class="col-lg-12 col-md-12"><span class="xCNHeadMenu">สร้างใบเสนอราคา</span></div>
			</div>

			<!--Section ล่าง-->

			<div class="card">
						<div class="card-body">
							<!--ค้นห่า-->
							   <div class="row">
									 		<!--  Filter List-->
											<div class="col-lg-3">
													<div id="odvContent_AdvFilter">
								                <div class="panel panel-default">
								                    <div class="panel-heading">ตัวกรองข้อมูล</div>
								                         <div class="panel-body">
								                              <!-- <label class="radio">Company
								                              <input type="radio" checked="checked" name="is_company">
								                              <span class="checkround"></span>
								                              </label> -->
																							<!--  check empty data-->
																							<?php
                                                         // echo '<pre>';
																												 // var_dump($aFilterList);
																												 // echo '<pre>';
																							 ?>
																							<?php if($aFilterList['rtCode'] == 1){ ?>

																								       <?php
                                                            $tLastFilterCode = '';

																														for($f = 0; $f < $aFilterList['nTotalRes']; $f++){

																																$tFilterGrpCode = $aFilterList['raItems'][$f]['FTFilGrpCode'];
																																$tFilterGrpName = $aFilterList['raItems'][$f]['FTFilGrpName'];

																															  $tFilterCode = $aFilterList['raItems'][$f]['FTFilCode'];
																																$tFilterName = $aFilterList['raItems'][$f]['FTFilName'];

																																if($tLastFilterCode != $tFilterGrpCode){

																																		 echo  "<h5 style='margin-top:10px;'><b>".$tFilterGrpName."</b></h5>";

																																		 $tLastFilterCode = $tFilterGrpCode;
																																}
																												?>


															                              <div style="padding-left:15px;">

															                                  <label class="check "> <?php echo $tFilterName; ?>
															                                      <input type="checkbox" checked="checked" class="ocbFlt<?=$tFilterGrpCode?>" value="<?=$tFilterCode?>">
															                                  <span class="checkmark"></span>
															                                  </label>

															                              </div>

																							          <?php } //End For loop data  ?>

																														<button  class="btn cust-btn " type="button" id="btn-registration"
															                                       style="font-size: 20px;letter-spacing: 1px; width:100%">นำไปใช้
																														</button>

																							<?php } else {
																								      echo '!No Filter Data.';
																							      } //End if check empty data
																							?>
																							<!-- End Filter-->

								                          </div>
								                 </div>
								          </div>
											</div>

										  <div class="col-lg-6 col-md-6 col-sm-12">

				                  <div class="row">
				                      <!-- Input Filter -->
				                      <div class="col-lg-8 col-md-8 col-sm-8">

				                            <div class="input-group md-form form-sm form-2 pl-0">
				                                <input class="form-control my-0 py-1 red-border xCNFormSerach" type="text"
																				       placeholder="ค้นหาจากชื่อสินค้า"
																							 onkeypress="return FSxQUOSearchItem(event,this)" >
				                                <div class="input-group-append">
				                                    <span class="input-group-text red lighten-3" id="basic-text1">
				                                    <i class="fa fa-search" aria-hidden="true"></i>
				                                    </span>
				                                </div>
				                            </div>

				                      </div>
				                       <!-- End Input Filter -->

				                       <!-- Gridview Options -->
				                      <div class="col-lg-4 col-md-4 col-sm-4">
				                            <div class="btn-group float-right" role="group">
				                                <button class="btn-sm"><i class="fa fa-table"></i></button>
				                                &nbsp;
				                                <button class="btn-sm"><i class="fa fa-list"></i></button>
				                            </div>
				                      </div>
				                       <!-- End Gridview Options -->
				                  </div>

				                  <div class="row xCNQuCategoryList" id="odvQuoPdtList">

																	<div class="col-sm-3 col-md-3 col-lg-3">
																			<div class="thumbnail">
																					<img src="<?=base_url('application/assets/images/products/NoImage.png') ?>" alt="...">
																					<div class="caption">
																							<h4>Thumbnail label...</h4>
																							<p>...</p>

																					</div>
																			</div>
																	</div>
                          </div>

													<!--  Pagenation-->
                          <div class="row">
				                      <div class="col-lg-12 text-right">
				                          <nav aria-label="Page navigation example">
				                              <ul class="pagination justify-content-end">
				                                  <li class="page-item">
				                                  <a class="page-link" href="#" aria-label="Previous">
				                                      <span aria-hidden="true">&laquo;</span>
				                                      <span class="sr-only">Previous</span>
				                                  </a>
				                                  </li>
				                                  <li class="page-item"><a class="page-link" href="#">1</a></li>
				                                  <li class="page-item"><a class="page-link" href="#">2</a></li>
				                                  <li class="page-item"><a class="page-link" href="#">3</a></li>
				                                  <li class="page-item">
					                                    <a class="page-link" href="#" aria-label="Next">
					                                        <span aria-hidden="true">&raquo;</span>
					                                        <span class="sr-only">Next</span>
					                                    </a>
				                                  </li>
				                              </ul>
				                          </nav>
				                      </div>
                          </div>
													<!--  End Pagenation-->

										  </div>

											<div class="col-lg-3">
														<div id="odvContent_Detail">

									                        <div class="panel panel-default">
									                            <div class="panel-heading">เอกสาร</div>
									                            <div class="panel-body">
									                                <div class="row" id="odvQuoHeader">

									                                </div>
									                                <!-- <hr> -->
																									<!-- แสดงรายการสินค้าที่เลือกในใบเสนอราคา -->
																									<div class="row" id="odvQuoItemsList">
																										  ....
																									</div>

									                                <hr>
									                                <div class="row">
									                                     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
									                                                <button type="button" class="btn btn-secondary" style="width:100%">ยกเลิก</button>
									                                     </div>
									                                     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
									                                                <button type="button" class="btn btn-secondary" style="width:100%">ถัดไป</button>
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

<?php include ('script/jquotation.php'); ?>
<link rel="stylesheet" href="<?=base_url('application/assets/css/quotation.css') ?>">
<link rel="stylesheet" href="<?=base_url('application/assets/css/check-radio.css') ?>">
