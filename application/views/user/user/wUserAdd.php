<?php
	$tLevelUser = $this->session->userdata('tSesUserLevel');
?>

<div class="container-fulid">

	<!--Section บน-->
	<div class="row">
		<div class="col-lg-6 col-md-6"><span class="xCNHeadMenuActive" onclick="JSxCallPageUserMain();">ผู้ใช้</span><span class="xCNHeadMenu">  /  สร้างผู้ใช้</span></div>
		<div class="col-lg-6 col-md-6"><button class="xCNButtonSave pull-right" onClick='xxxx()'>บันทึก</button></div>
	</div>

	<!--Section ล่าง-->
	<div class="card" style="margin-top: 10px;">
		<div class="card-body">
			<form>
				<div class="row">
					<!--รูปภาพ-->
					<div class="col-lg-3 col-md-3">
						<?php $tPathImage = './application/assets/images/user/NoImage.png'; ?>
						<img id="oimImgInsertorEditUser" class="img-responsive xCNImgCenter" src="<?=$tPathImage?>">
						<button type="button" class="btn btn-outline-secondary xCNChooseImage">เลือกรูปภาพ</button>
					</div>

					<!--รายละเอียด-->
					<div class="col-lg-4 col-md-4">
						<!--สาขา-->
						<?php if($tLevelUser == 'HQ'){ ?>
							<div class="form-group">
								<label>สาขา</label>
								<select class="form-control" id="oetUserBCH" name="oetUserBCH">
									<option value="0">ไม่ระบุสาขา</option>
									<?php foreach($aBCHList['raItems'] AS $nKey => $aValue){ ?>
										<option value="<?=$aValue['FTBchCode'];?>"><?=$aValue['FTBchName'];?> - (<?=$aValue['FTCmpName'];?>)</option>
									<?php } ?>
								</select>
							</div>
						<?php }else{ ?>
							<div class="form-group">
								<label>สาขา</label>
								<input type="text" class="form-control" id="oetUserBCH" name="oetUserBCH" value="">
							</div>
						<?php } ?>

						<!--กลุ่มสิทธิ์-->
						<div class="form-group">
							<label>กลุ่มสิทธิ์</label>
							<select class="form-control" id="oetUserPermission" name="oetUserPermission">
								<?php foreach($aPermissionList['raItems'] AS $nKey => $aValue){ ?>
									<option value="<?=$aValue['FNRhdID'];?>"><?=$aValue['FTRhdName'];?></option>
								<?php } ?>
							</select>
						</div>

						<!--แผนก-->
						<div class="form-group">
							<label>แผนก</label>
							<input type="text" class="form-control" id="oetUserDepartment" name="oetUserDepartment" placeholder="กรุณาระบุแผนก">
						</div>

						<!--กลุ่มราคา-->
						<div class="form-group">
							<label>กลุ่มราคา</label>
							<select class="form-control" id="oetUserPriGrp" name="oetUserPriGrp">
								<?php foreach($aPriGrp['raItems'] AS $nKey => $aValue){ ?>
									<option value="<?=$aValue['FTPriGrpID'];?>"><?=$aValue['FTPriGrpName'];?></option>
								<?php } ?>
							</select>
						</div>

						<!--ชื่อ-->
						<div class="form-group">
							<label>ชื่อ</label>
							<input type="text" class="form-control" maxlength="50" id="oetUserFirstname" name="oetUserFirstname" placeholder="กรุณาระบุชื่อ">
						</div>

						<!--นามสกุล-->
						<div class="form-group">
							<label>นามสกุล</label>
							<input type="text" class="form-control" maxlength="50" id="oetUserLastname" name="oetUserLastname" placeholder="กรุณาระบุนามสกุล">
						</div>

						<!--อีเมลล์-->
						<div class="form-group">
							<label>อีเมลล์</label>
							<input type="text" class="form-control" maxlength="100" id="oetUserEmail" name="oetUserEmail" placeholder="กรุณาระบุอีเมลล์">
						</div>


						
						<div class="form-group">
							<label for="exampleFormControlSelect2">Example multiple select</label>
							<select multiple class="form-control" id="exampleFormControlSelect2">
							<option>1</option>
							<option>2</option>
							<option>3</option>
							<option>4</option>
							<option>5</option>
							</select>
						</div>
						<div class="form-group">
							<label for="exampleFormControlTextarea1">Example textarea</label>
							<textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
<div>
