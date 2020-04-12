
      <div class="col-lg-12">
           <div class="xWQuotationTtems-Title">
                 <div class="row">
                      <div class="col-lg-7">รายการสินค้า</div>
                      <div class="col-lg-5 text-right"><?php echo $aQuoItemsList['nTotalRes'];?> รายการ</div>
                 </div>
           </div>
      </div>

<?php
  // echo "<pre>";
  // var_dump($aQuoItemsList);
  // echo "</pre>";
?>
<?php if($aQuoItemsList['nTotalRes'] > 0){ ?>

      <?php
            $nTotal = 0;
            for($i=0;$i<$aQuoItemsList['nTotalRes'];$i++){
            $nQty = $aQuoItemsList['raItems'][$i]['FCXqdQty'];
            $nItemSeq = $aQuoItemsList['raItems'][$i]['FNXqdSeq'];
            $nPdtUnitPri = $aQuoItemsList['raItems'][$i]['FCXqdUnitPrice'];
            $nItemPrice = $nQty * $nPdtUnitPri;
            $nTotal = $nTotal + $nItemPrice;
      ?>

          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
          <img src="<?=base_url('application/assets/images/products/NoImage.png') ?>" alt="...">
          </div>
          <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
              <span style="color:red;cursor:pointer" data-seq="<?=$nItemSeq?>" onclick="FSxQUODelItem(this)">[x]</span>
              <span class="ospItemInDoc"><?php echo $aQuoItemsList['raItems'][$i]['FTPdtName'];?></span><br>
              ราคา / หน่วย :   &#3647; <?php echo number_format($nPdtUnitPri,2);?> <br>
              <div class="row">
                  <div class="col-lg-6">จำนวน</div>
                  <div class="col-lg-6">
                      <input class="text-right" type="text" style="width:100%" value="<?=$nQty?>"
                             data-seq="<?=$nItemSeq?>"
                             data-unitpri = "<?=$nPdtUnitPri?>"
                             onkeypress="return FSxQUOEditItemQty(event,this)" >
                  </div>
              </div>

          </div>

      <?php } ?>

<?php } //End if
      else{
        $nTotal = 0;
?>
        <div class="col-lg-12">[การแจ้งเตือน] ยังไม่มีรายการสินค้าในเอกสารนี้ </div>
<?php }   ?>



<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">จำนวนเงินรวม</div>
<div class="col-lg-5 col-md-5 col-md-5 col-xs-5 text-right"> &#3647; <?php echo number_format($nTotal,2);?></div>

<style media="screen">
     .xWQuotationTtems-Title{
       border-top:1px solid #cccccc;
       border-bottom:1px solid #cccccc;
       margin-bottom: 15px;
       background : #67717d!important;
       color: #FFFFFF;
       padding-left: 5px;
     }
</style>
