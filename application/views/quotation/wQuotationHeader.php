<?php
  if($aDocHD["nTotalRes"] > 0 ){

    $tXqhDocNo = $aDocHD['raItems'][0]['FTXqhDocNo'];
    $tCreateBy = $aDocHD['raItems'][0]['FTCreateBy'];
    $tUsrDep = $aDocHD['raItems'][0]['FTUsrDep'];
    $dCreateOn = $aDocHD['raItems'][0]['FDCreateOn'];

  }else{
    $tXqhDocNo = '';
    $tCreateBy = '';
    $tUsrDep = '';
    $dCreateOn = '';
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
     $dCreateOn = date("Y-m-d H:i:s");
  }


 ?>
<div class="col-lg-12">
      <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">เลขที่เอกสาร</div>
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7" data-docno="" id="odvQuoDocNo"><?=$tXqhDocNo?></div>
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">วันที่เอกสาร</div>
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7"><?=$dCreateOn?></div>
            <!-- <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">สาขา</div>
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">00001</div> -->
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">ผู้สร้าง</div>
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7"><?=$tWorkerName?></div>
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">แผนก</div>
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7"><?=$tUsrDep?></div>
       </div>
</div>
