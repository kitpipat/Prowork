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
				                                <input class="form-control my-0 py-1 red-border xCNFormSerach" type="text" placeholder="ค้นหาสินค้า" >
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
									                                <div class="row">

									                                    <div class="col-lg-12">
									                                          <div class="row">
									                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">เลขที่เอกสาร</div>
									                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">#############</div>
									                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">วันที่เอกสาร</div>
									                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">04/04/2020 15:00:00</div>
									                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">สาขา</div>
									                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">00001</div>
									                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">ผู้สร้าง</div>
									                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">สุภาพร อ่อนละมุล</div>
									                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">แผนก</div>
									                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">ฝ่ายขาย</div>
									                                           </div>
									                                          <hr>
									                                            <div class="row">
									                                                <div class="col-lg-6">รายการสินค้า</div>
									                                                <div class="col-lg-6 text-right">10 รายการ</div>
									                                            </div>
									                                          <hr>
									                                    </div>
									                                    <?php for($i=0;$i<3;$i++){?>
									                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
									                                        <img src="<?=base_url('application/assets/images/products/NoImage.png') ?>" alt="...">
									                                        </div>
									                                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
									                                            Tracklight L73 LED (Warmwhite) 12W <br>
									                                            ราคา  300.00 <br>
									                                            <div class="row">
									                                                <div class="col-lg-6">จำนวน</div>
									                                                <div class="col-lg-6">
									                                                    <input class="text-right" type="text" style="width:100%" value="1" >
									                                                </div>
									                                            </div>

									                                        </div>
									                                    <?php } ?>
									                                </div>
									                                <hr>
									                                <div class="row">
									                                     <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">จำนวนเงินรวม</div>
									                                     <div class="col-lg-5 col-md-5 col-md-5 col-xs-5 text-right">100.00</div>
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
