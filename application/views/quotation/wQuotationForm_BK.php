
<style>
  .red{
    background-color: green;
  }
  div{
    border: none;
  }
  .xCNPanel{
    background-color: #ffffff;
    border: 1px solid #f5f5f5;
  }
  .xWSQDocName{
    background-color: #B0DAA7;
    border: 1px solid #f5f5f5;
    height: 15px;
    text-align: center;
    font-size: 25px;
    border-radius: 50%;
  }
  .xWCmpSection{
    padding-top:10;
    border-bottom:1px solid #f5f5f5;
  }
  .xCNTitle{
    font-weight: 700;
    font-size: 22px;
  }
  .XCNItemTitle{
    border-bottom:1px solid #f5f5f5;
    border-top:1px solid #f5f5f5;
  }
  .xWTextNumber{
    background-color: #B0DAA7;
    border: 1px solid #f5f5f5;
    height: 15px;
    text-align: center;
    font-size: 18px;
    border-radius: 50%;
  }
</style>

<?php 
	$aContactAddress = base64_decode($aContact); 
	$aContactAddress = explode("/n",$aContactAddress);
	$tCstName 			= $aContactAddress[0];
	$tAddress 			= $aContactAddress[1];
	$tTexNo					= $aContactAddress[2];
	$tContact  			= $aContactAddress[3];
	$tEmail 				= $aContactAddress[4];
	$tTel 					= $aContactAddress[5];
	$tFax 					= $aContactAddress[6];
	$tPrjName 			= $aContactAddress[7];
	$tCodeRef 			= $aContactAddress[8];
?>

<table cellpadding="0" cellspacing="3">
  <tbody>
    <tr>
      <td valign="top" class="xCNPanel">
        <table cellpadding="5" cellspacing="5">
          <tr>
            <td class="xWCmpSection"><img src="<?=base_url('application/assets/images/logo.png')?>" style="width:120px;"><br><label style="font-size:22px"><?php echo $aDocHeader['raItems'][0]['FTCmpName'];?></label><br>สาขา <?php echo $aDocHeader['raItems'][0]['FTBchName'];?><br><?php echo $aDocHeader['raItems'][0]['FTAdrName'];?> ถนน<?php echo $aDocHeader['raItems'][0]['FTAdrRoad'];?>่ แขวง/ตำบล <?php echo $aDocHeader['raItems'][0]['FTAdrSubDistric'];?><br>เขต/อำเภอ <?php echo $aDocHeader['raItems'][0]['FTAdrDistric'];?> จังหวัด <?php echo $aDocHeader['raItems'][0]['FTAdrProvince'];?> <?php echo $aDocHeader['raItems'][0]['FTAdrPosCode'];?><br>โทร <?php echo $aDocHeader['raItems'][0]['FTAdrTel'];?>  อีเมลล์ <?php echo $aDocHeader['raItems'][0]['FTAdrEmail'];?>
            </td>
          </tr>
          <tr>
            <td>ลูกค้า
							<?php echo ($tCstName != "" ? $tCstName : "ไม่ระบุลูกค้า");?><br>
							<span><?php echo ($tAddress != "" ? $tAddress : "-")?></span><br>
							โทร <?php echo ($tTel != "" ? $tTel : "-");?><br>
							เลขประจำตัวผู้เสียภาษี <?php echo ($tTexNo != "" ? $tTexNo : "-");?>
            </td>
          </tr>
        </table>
      </td>
      <td valign="top">

          <table cellpadding="10">
            <tr>
              <td  class="xWSQDocName">
                ใบเสนอราคา<br>
                Quotation
              </td>
            </tr>
          </table>

          <table cellpadding="0" cellspacing="7" style="border-bottom:1px solid #f5f5f5;">
            <tr>
              <th>เลขที่ใบเสนอราคา</th>
              <td><?php echo $aDocHeader['raItems'][0]['FTXqhDocNo'];?></td>
            </tr>
            <tr>
              <th>วันที่เอกสาร</th>
              <td><?php echo $aDocHeader['raItems'][0]['FDXqhDocDate'];?></td>
            </tr>
          </table>
					
          <table cellpadding="0" cellspacing="7" class="xCNPanel">
            <tr>
              <td>ยื่นราคาภายใน : <?php echo $aDocHeader['raItems'][0]['FNXqhSmpDay'];?> วัน</td>
              <td>มีผลถึง : <?php echo $aDocHeader['raItems'][0]['FDXqhEftTo'];?></td>
            </tr>
            <tr>
              <td>การชำระเงิน : <?php echo $aDocHeader['raItems'][0]['FTXqhCshOrCrd'];?></td>
              <td>จำนวนวันเครดิต : <?php echo $aDocHeader['raItems'][0]['FNXqhCredit'];?> วัน</td>
            </tr>
            <tr>
              <td>วันกำหนดส่งของ : <?php echo $aDocHeader['raItems'][0]['FDDeliveryDate'];?></td>
              <td>ผู้ติดต่อ : <?php echo ($tContact != "" ? $tContact : "-");?> <br><br></td>
            </tr>
          </table>

      </td>
    </tr>
  </tbody>
</table>

<br>
<br>
<table cellpadding="7" cellspacing="0" style="width:695px;">
    <tr>
      <th class="XCNItemTitle" style="width:40px;">ลำดับ</th>
      <th class="XCNItemTitle" style="width:55px;">รูปสินค้า</th>
      <th class="XCNItemTitle" style="width:170px;">รายการ</th>
      <th class="XCNItemTitle" style="width:80px; text-align:right;">ราคา/หน่วย</th>
      <th class="XCNItemTitle" style="width:50px;text-align:right;">จำนวน</th>
      <th class="XCNItemTitle" style="width:50px;">หน่วย</th>
      <th class="XCNItemTitle" style="width:80px;text-align:right;">ราคา</th>
      <th class="XCNItemTitle" style="width:70px;text-align:right;">ส่วนลด</th>
      <th class="XCNItemTitle" style="width:100px;text-align:right;">ราคารวม</th>
    </tr>
    <?php $nTotal = $aDocDT['rnTotal'];?>
    <?php if($nTotal > 0){?>
		<?php for($i=0;$i<$nTotal;$i++){?>
    <tr>
			<td><?=$i+1?></td>
			<?php
				if($aDocDT['raItems'][$i]['FTPdtImage'] != '' || $aDocDT['raItems'][$i]['FTPdtImage'] != null){
					$tPathImage = './application/assets/images/products/'.$aDocDT['raItems'][$i]['FTPdtImage'];
					if (file_exists($tPathImage)){
						$tPathImage = base_url().'application/assets/images/products/'.$aDocDT['raItems'][$i]['FTPdtImage'];
					}else{
						$tPathImage = base_url().'application/assets/images/products/NoImage.png';
					}
				}else{
					$tPathImage = './application/assets/images/products/NoImage.png';
				}
			?>
			<td class="xCNTdHaveImage"><img id="oimImgInsertorEditProduct" class="img-responsive xCNImgCenter" src="<?=@$tPathImage;?>" style="width:25px;"></td>
      <td><?php echo mb_substr($aDocDT['raItems'][$i]['FTPdtCode']."-".$aDocDT['raItems'][$i]['FTPdtName'],0,900,"utf-8");?></td>
      <td style="text-align:right;"><?php echo number_format($aDocDT['raItems'][$i]['FCXqdUnitPrice'],2);?></td>
      <td style="text-align:right;"><?php echo number_format($aDocDT['raItems'][$i]['FCXqdQty'],0);?></td>
      <td><?php echo $aDocDT['raItems'][$i]['FTPunName'];?></td>
      <td style="text-align:right;"><?php echo number_format($aDocDT['raItems'][$i]['FCXqdB4Dis'],2);?></td>
      <td style="text-align:right;"><?php echo $aDocDT['raItems'][$i]['FTXqdDisTxt'];?></td>
      <td style="text-align:right;"><?php echo number_format($aDocDT['raItems'][$i]['FCXqdAfDT'],2);?></td>
    </tr>
    <?php } ?>
  <?php }else{ ?>
    <tr><td colspan="9">--ไม่มีรายการสินค้าในเอกสาร--</td></tr>
  <?php } ?>
  </table>
  <?php if($nTotal == 10){?>
  <br><br><br><br><br><br><br><br><br>
  <?php } ?>
  <?php if($nTotal == 11){?>
  <br><br><br><br><br><br>
  <?php } ?>
  <?php if($nTotal == 12){?>
  <br><br><br><br>
  <?php } ?>
  <?php if($nTotal == 13){?>
  <br><br>
  <?php } ?>
  <?php if($nTotal == 29){?>
  <br><br><br><br><br><br><br><br><br>
  <?php } ?>
  <?php if($nTotal == 30){?>
  <br><br><br><br><br><br>
  <?php } ?>
  <?php if($nTotal == 31){?>
  <br><br><br><br><br>
  <?php } ?>
  <?php if($nTotal == 32){?>
  <br><br>
  <?php } ?>
  <?php if($nTotal == 33){?>
  <br>
  <?php } ?>
<table cellpadding="5" cellspacing="0">
<tr>
<td>
<table cellpadding="7" cellspacing="0">
  <tr>
    <td class="xWTextNumber"><?php echo $aDocHeader['raItems'][0]['FTXqhGndText'];?></td>
  </tr>
  <tr>
    <td>หมายเหตุ</td>
  </tr>
  <tr>
    <td style="height:100px;border:1px solid #f5f5f5;"><?php echo $aDocHeader['raItems'][0]['FTXqhRmk'];?></td>
  </tr>
</table>
</td>
      <td>
            <table style="border:1px solid #f5f5f5;" cellpadding="7" cellspacing="0">
              <tr>
                <td style="border-right:1px solid #f5f5f5;border-bottom:1px solid #f5f5f5;">จำนวนเงินรวม</td>
                <td style="text-align:right;border-bottom:1px solid #f5f5f5;"><?php echo number_format($aDocHeader['raItems'][0]['FCXqhB4Dis'],2);?></td>
              </tr>
              <tr>
                <td style="border-right:1px solid #f5f5f5">ส่วนลด</td>
                <td style="text-align:right"><?php echo number_format($aDocHeader['raItems'][0]['FCXqhDis'],2);?></td>
              </tr>
              <tr>
                <td style="border-right:1px solid #f5f5f5">จำนวนเงินหลังหักส่วนลด</td>
                <td style="text-align:right"><?php echo number_format($aDocHeader['raItems'][0]['FCXqhAFDis'],2);?></td>
              </tr>
              <tr>
                <td style="border-right:1px solid #f5f5f5">ภาษีมูลค่าเพิ่ม (7%)</td>
                <td style="text-align:right"><?php echo number_format($aDocHeader['raItems'][0]['FCXqhAmtVat'],2);?></td>
              </tr>
              <tr>
                <td style="border-right:1px solid #f5f5f5;border-top:1px solid #f5f5f5">จำนวนเงินรวมทั้งสิ้น</td>
                <td style="text-align:right;border-top:1px solid #f5f5f5"><?php echo number_format($aDocHeader['raItems'][0]['FCXqhGrand'],2);?></td>
              </tr>
            </table>
      </td>
    </tr>
  </table>

<table>
  <tr>
    <td>
 <table cellpadding="7" cellspacing="0" style="height:100px;border:1px solid #f5f5f5;">
      <tr>
        <td style="height:100px;border-bottom:1px solid #f5f5f5;">ลงชื่อ</td>
      </tr>
      <tr>
        <td>ผู้อนุมัติคำสั่งซื้อ</td>
      </tr>
      <tr>
        <td>วันที่ ......./......./.........</td>
      </tr>
    </table>
    </td>
      <td>
        <table cellpadding="7" cellspacing="0" style="height:100px;border:1px solid #f5f5f5;">
          <tr>
            <td style="height:100px;border-bottom:1px solid #f5f5f5;">ลงชื่อ</td>
          </tr>
          <tr>
            <td>พนักงานขาย</td>
          </tr>
          <tr>
            <td>วันที่ ......./......./.........</td>
          </tr>
        </table>
      </td>
      <td>
        <table cellpadding="7" cellspacing="0" style="height:100px;width:220px;border:1px solid #f5f5f5;">
          <tr>
            <td style="height:100px;border-bottom:1px solid #f5f5f5;">ลงชื่อ</td>
          </tr>
          <tr>
            <td>พนักงานทั่วไป</td>
          </tr>
          <tr>
            <td>วันที่ ......./......./.........</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>




