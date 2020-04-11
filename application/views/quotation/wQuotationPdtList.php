<?php
if($nTotalRecord > 0){
    if($tPdtViewType == 1) {
?>
                <?php for($p=0;$p<$nTotalRecord;$p++){
                      $tPdtCode = $aPdtList['raItems'][$p]['FTPdtCode'];
                      $tPdtName = $aPdtList['raItems'][$p]['FTPdtName'];
                      $tPunCode = $aPdtList['raItems'][$p]['FTPunCode'];
                      $tSplCode = $aPdtList['raItems'][$p]['FTSplCode'];
                      $nPdtCost = $aPdtList['raItems'][$p]['FCPdtCostAFDis'];
                      $nPdtUnitPri = $aPdtList['raItems'][$p]['FCPdtNetSalPri'];
                      $tPunName = $aPdtList['raItems'][$p]['FTPunName'];


                      $aItemsInfo = array("tPdtCode"=>$tPdtCode,
                                          "tPdtName"=>$tPdtName,
                                          "tPunCode"=>$tPunCode,
                                          "tPunName"=>$tPunName,
                                          "tSplCode"=>$tSplCode,
                                          "nPdtCost"=>$nPdtCost,
                                          "nPdtUnitPri"=>$nPdtUnitPri);

                      $tItemInfo = json_encode($aItemsInfo);

                ?>
                <div class="col-sm-3 col-md-3 col-lg-3">
                    <div class="thumbnail" data-iteminfo='<?=$tItemInfo?>' onclick="FSvQUOAddItemToTemp(this)">
                        <img src="<?=base_url('application/assets/images/products/NoImage.png') ?>" alt="...">
                        <div class="caption">
                            <h4><?php echo $tPdtName;?></h4>
                            <span>&#3647;<?php echo number_format($nPdtUnitPri,2);?></span>
                        </div>
                    </div>
                </div>
                <?php } //End for?>
<?php } else { ?>
 <table class="table table-striped">
   <tr>
     <th>ชื่อ</th>
     <th>ราคา/หน่วย</th>
     <th>เลือก</th>
   </tr>
   <?php for($p2 = 0 ;$p2 < $nTotalRecord; $p2++){
         $tPdtCode = $aPdtList['raItems'][$p2]['FTPdtCode'];
         $tPdtName = $aPdtList['raItems'][$p2]['FTPdtName'];
         $tPunCode = $aPdtList['raItems'][$p2]['FTPunCode'];
         $tSplCode = $aPdtList['raItems'][$p2]['FTSplCode'];
         $nPdtCost = $aPdtList['raItems'][$p2]['FCPdtCostAFDis'];
         $nPdtUnitPri = $aPdtList['raItems'][$p2]['FCPdtNetSalPri'];
         $tPunName = $aPdtList['raItems'][$p2]['FTPunName'];

         $aItemsInfo = array("tPdtCode"=>$tPdtCode,
                             "tPdtName"=>$tPdtName,
                             "tPunCode"=>$tPunCode,
                             "tPunName"=>$tPunName,
                             "tSplCode"=>$tSplCode,
                             "nPdtCost"=>$nPdtCost,
                             "nPdtUnitPri"=>$nPdtUnitPri);

         $tItemInfo = json_encode($aItemsInfo);
   ?>
   <tr>
     <td><?=$tPdtName?></td>
     <td>฿ 3,955.00</td>
     <td><button class="sm-button" data-iteminfo='<?=$tItemInfo?>' onclick="FSvQUOAddItemToTemp(this)">เลือก</button></td>
   </tr>
   <?php }?>
 </table>
<?php } ?>
<?php }else {?>
       <div class="col-lg-12"><lable style="color:red">[การแจ้งเตือน]</label> ไม่พบสินค้าในระบบ.</div>
<?php } //end main if?>

<style media="screen">
.thumbnail:hover {
  padding: 2px;
  border : 1px solid green !important;
  border-radius: 5px !important;
  cursor: pointer !important;
}
</style>
