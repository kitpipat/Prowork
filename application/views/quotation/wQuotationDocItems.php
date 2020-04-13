
<table class="table table-striped">
  <tr>
    <th>ลำดับ</th>
    <th>ลบ</th>
    <th>รูปภาพ</th>
    <th>รายการ</th>
    <th>หน่วย</th>
    <th>ราคา/หน่วย</th>
    <th>จำนวน</th>
    <th>จำนวนเงิน</th>
    <th>ส่วนลด</th>
    <th>จำนวนเงินรวม</th>
  </tr>
  <?php
      if($aDocItems["nTotalRes"] > 0) {
  ?>
  <?php

       $nTotal = 0;
       $nPdtNetTotal = 0;
       $nDocNetTotal = 0;
       $nXqdDis = 0;
       for($p = 0;$p< $aDocItems["nTotalRes"] ;$p++){
            $tPdtCode = $aDocItems["raItems"][$p]["FTPdtCode"];
            $tPdtName = $aDocItems["raItems"][$p]["FTPdtName"];
            $tPunName = $aDocItems["raItems"][$p]["FTPunName"];
            $nXqdUnitPrice = $aDocItems["raItems"][$p]["FCXqdUnitPrice"];
            $nXqdQty = $aDocItems["raItems"][$p]["FCXqdQty"];
            $nTotal = $nXqdQty * $nXqdUnitPrice;
            $nXqdDis = $aDocItems["raItems"][$p]["FCXqdDis"];
            if($nXqdDis == ""){
               $nXqdDis = 0;
            }else{
               $nXqdDis = $nXqdDis;
            }

            $tDisType = substr($nXqdDis,strlen($nXqdDis)-1);

            if($tDisType == ""){

               $nPdtNetTotal = $nTotal;

            }else if($tDisType == "%"){

                $nPdtNetTotal = $nTotal - (($nTotal * substr($nXqdDis,0,strlen($nXqdDis)-1))/100);

            }else{

                $nPdtNetTotal = $nTotal - $nXqdDis;
            }

            $nDocNetTotal = $nDocNetTotal + $nPdtNetTotal;


  ?>
  <tr>
    <td><?=$p?></td>
    <td>[x]</td>
    <td><img src='<img src="<?=base_url('application/assets/images/products/NoImage.png') ?>" alt="...">'></td>
    <td> <?php echo $tPdtCode." - ".$tPdtName; ?> </td>
    <td> <?php echo $tPunName;?> </td>
    <td class="text-right"> <?php echo number_format($nXqdUnitPrice,2); ?> </td>
    <td><input type="text" class="text-right" name="" value="<?=$nXqdQty?>"></td>
    <td class="text-right"> <?php echo number_format($nTotal,2); ?> </td>
    <td> <input type="text"class="text-right" name="" value="<?=$nXqdDis?>"> </td>
    <td class="text-right"><?php echo number_format($nPdtNetTotal,2);?></td>
  </tr>
  <?php } ?>
<?php }else{ ?>
   <tr><td colspan="10">-ไม่พบรายการสินค้าในเอกสาร-</td></tr>
<?php } ?>
</table>

<span id="ospDocNetTotal" style="display:none"><?php echo $nDocNetTotal;?></span>
