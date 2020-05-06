<?php
  if($aDocHD["nTotalRes"] > 0 ){

    $tXqhDocNo = $aDocHD['raItems'][0]['FTXqhDocNo'];
    $tCreateBy = $aDocHD['raItems'][0]['FTCreateBy'];
    $tUsrDep = $aDocHD['raItems'][0]['FTUsrDep'];
    $dCreateOn = date('d/m/Y',strtotime( $aDocHD['raItems'][0]['FDCreateOn']));
	 $FTBchCode = $aDocHD['raItems'][0]['FTBchCode'];
  }else{
    $tXqhDocNo = '';
    $tCreateBy = '';
    $tUsrDep = '';
	 $dCreateOn = '';
	 $FTBchCode = '';
  }

  if($tCreateBy != ""){
     $tCreateBy = $tCreateBy;
  }else{
     $tCreateBy = $tWorkerID;
  }

  if($tXqhDocNo != ""){
     $tXqhDocNo = $tXqhDocNo;
  }else{
     $tXqhDocNo = "SQ-##########";
  }

  if($dCreateOn != ""){
     $dCreateOn = $dCreateOn;
  }else{
     $dCreateOn = date("Y/m/d");
  }

 ?>
<div class="col-lg-12" >
      <div class="row">
  				<!--เลขที่เอกสาร-->
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">เลขที่เอกสาร</div>
				<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7" data-docno="<?=$tXqhDocNo?>" id="odvQuoDocNo"><?=$tXqhDocNo?></div>
				  
				<!--วันที่เอกสาร-->
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">วันที่เอกสาร</div>
				<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7"><?=$dCreateOn?></div>
  
				<!--ผู้สร้าง-->
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">ผู้สร้าง</div>
				<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7"><?=$tWorkerName?></div>
				
				<!--แผนก-->
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">แผนก</div>
				<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7"><?=$tUsrDep?></div>
				
				<!--สาขา-->
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">สาขา</div>
				<?php $tLevelUser = $this->session->userdata('tSesUserLevel'); ?>
				<?php if($tLevelUser == 'HQ'){ ?>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-group">
							<select class="form-control" id="oetBCH" name="oetBCH">
								<?php foreach($aBCHList['raItems'] AS $nKey => $aValue){ ?>
									<option <?=(@$FTBchCode == $aValue['FTBchCode'])? "selected" : "";?> value="<?=$aValue['FTBchCode'];?>"><?=$aValue['FTBchName'];?> - (<?=$aValue['FTCmpName'];?>)</option>
								<?php } ?>
							</select>
						</div>
					</div>
				<?php }else{ ?>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-group">
							<?php $tBCHName = $this->session->userdata('tSesBCHName'); ?>
							<?php $tBCHCode = $this->session->userdata('tSesBCHCode'); ?>
							<input type="text" class="form-control" value="<?=@$tBCHName?>" autocomplete="off" readonly>
							<input type="hidden" id="oetBCH" name="oetBCH" value="<?=@$tBCHCode?>" autocomplete="off">
						</div>
					</div>
				<?php } ?>

       </div>
</div>
