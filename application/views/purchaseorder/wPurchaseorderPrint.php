
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
	
	function getMBStrSplit($string, $split_length = 1){
		mb_internal_encoding('UTF-8');
		mb_regex_encoding('UTF-8'); 
		
		$split_length = ($split_length <= 0) ? 1 : $split_length;
		$mb_strlen = mb_strlen($string, 'utf-8');
		$array = array();
		$i = 0; 
		
		while($i < $mb_strlen)
		{
			$array[] = mb_substr($string, $i, $split_length);
			$i = $i+$split_length;
		}
		
		return $array;
	}

	function getStrLenTH($string){
		$array = getMBStrSplit($string);
		$count = 0;
		
		foreach($array as $value)
		{
			$ascii = ord(iconv("UTF-8", "TIS-620", $value ));
			
			if( !( $ascii == 209 ||  ($ascii >= 212 && $ascii <= 218 ) || ($ascii >= 231 && $ascii <= 238 )) )
			{
				$count += 1;
			}
		}
		return $count;
	}
?>

<!--ส่วนรายละเอียดของหัวตาราง-->
<table cellpadding="0" cellspacing="3">
  <tbody>
    <tr>
      <td valign="top" class="xCNPanel">
        <table cellpadding="5" cellspacing="5">
          <tr>
            <td class="xWCmpSection"><img src="<?=base_url('application/assets/images/logo.png')?>" style="width:120px;"><br>
				<label style="font-size:22px"><?php echo $aDocHeader['raItems'][0]['FTCmpName'];?></label>
				<br>สาขา <?php echo $aDocHeader['raItems'][0]['FTBchName'];?>
				<br><?php echo $aDocHeader['raItems'][0]['FTAdrName'];?> ถนน<?php echo $aDocHeader['raItems'][0]['FTAdrRoad'];?>่ แขวง/ตำบล <?php echo $aDocHeader['raItems'][0]['FTAdrSubDistric'];?>
				<br>เขต/อำเภอ <?php echo $aDocHeader['raItems'][0]['FTAdrDistric'];?> จังหวัด <?php echo $aDocHeader['raItems'][0]['FTAdrProvince'];?> <?php echo $aDocHeader['raItems'][0]['FTAdrPosCode'];?>
				<br>โทร <?php echo $aDocHeader['raItems'][0]['FTAdrTel'];?>  อีเมลล์ <?php echo $aDocHeader['raItems'][0]['FTAdrEmail'];?>
            </td>
          </tr>
          <tr>
            <td>ผู้จำหน่าย
				<?php echo $aDocSPL['raItems'][0]['FTXpoSplName'];?>
				<br>ที่อยู่ <?php echo $aDocSPL['raItems'][0]['FTXpoAddress'];?>
				<br>ผู้ติดต่อ <?php echo ($aDocSPL['raItems'][0]['FTXpoContact'] == '') ? '-' : $aDocSPL['raItems'][0]['FTXpoContact'];?> 
				อีเมลล์ <?php echo ($aDocSPL['raItems'][0]['FTXpoEmail'] == '') ? '-' : $aDocSPL['raItems'][0]['FTXpoEmail'];?> 
				<br>เบอร์โทรศัพท์  <?php echo ($aDocSPL['raItems'][0]['FTXpoTel'] == '') ? '-' : $aDocSPL['raItems'][0]['FTXpoTel'];?>
				เบอร์โทรสาร <?php echo ($aDocSPL['raItems'][0]['FTXpoFax'] == '') ? '-' : $aDocSPL['raItems'][0]['FTXpoFax'];?>
            </td>
          </tr>
        </table>
      </td>
      <td valign="top">

          <table cellpadding="10">
            <tr>
              <td  class="xWSQDocName">
                ใบสั่งซื้อ<br>
                Purchaseorder
              </td>
            </tr>
          </table>

          <table cellpadding="0" cellspacing="7" style="border-bottom:1px solid #f5f5f5;">
            <tr>
              <th>เลขที่ใบเสนอราคา</th>
              <td><?php echo $aDocHeader['raItems'][0]['FTXpoDocNo'];?></td>
            </tr>
            <tr>
              <th>วันที่เอกสาร</th>
              <td><?php echo $aDocHeader['raItems'][0]['FDXpoDocDate'];?></td>
            </tr>
          </table>
					
          <table cellpadding="0" cellspacing="7" class="xCNPanel">
            <tr>
              <td>จัดส่งวันที่ : <?php echo $aDocHeader['raItems'][0]['FDDeliveryDate'];?> </td>
			  <td></td>
            </tr>
            <tr>
              <td>การชำระเงิน : <?php echo $aDocHeader['raItems'][0]['FTXpoCshOrCrd'];?></td>
              <td>จำนวนวันเครดิต : <?php echo $aDocHeader['raItems'][0]['FNXpoCredit'];?> วัน</td>
            </tr>
          </table>

      </td>
    </tr>
  </tbody>
</table>

<br><br>

<!--ส่วนของรายละเอียดหัวตาราง + ข้อมูล-->
<table cellpadding="4" id="myDIV" >
	<tr>
		<th class="XCNItemTitle" style="width:35px;">ลำดับ</th>
		<th class="XCNItemTitle" style="width:40px;">รูป</th>
		<th class="XCNItemTitle" style="width:465px;">รายการ</th>
		<!-- <th class="XCNItemTitle" style="width:75px;text-align:right;">ราคา/หน่วย</th> -->
		<th class="XCNItemTitle" style="width:40px;text-align:right; ">จำนวน</th>
		<th class="XCNItemTitle" style="width:120px;text-align:left;">หน่วย</th>
		<!-- <th class="XCNItemTitle" style="width:70px;text-align:right;">จำนวนเงิน</th> -->
		<!-- <th class="XCNItemTitle" style="width:70px;text-align:right;">ส่วนลด</th>
		<th class="XCNItemTitle" style="width:130px;text-align:right;">ราคารวม</th> -->
	</tr>
	<?php $nTotal = $aDocDT['rnTotal'];?>
	<?php if($nTotal > 0){ ?>
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
				<td class="xCNTdHaveImage" style="text-align:left;"><img id="oimImgInsertorEditProduct" class="img-responsive xCNImgCenter" src="<?=@$tPathImage;?>" style="width:25px;"></td>

				<?php $nGetCharLen = getStrLenTH($aDocDT['raItems'][$i]['FTPdtCode']."-".$aDocDT['raItems'][$i]['FTPdtName']); ?>
				<?php 
					if($nGetCharLen >= 75){ 
						$tTextCssFontSize = 'font-size:10.50vm;';
					}else{ 
						$tTextCssFontSize = 'font-size:12vm;';
					} 
				?>

				<td style="<?php echo $tTextCssFontSize; ?>"><?php echo mb_substr($aDocDT['raItems'][$i]['FTPdtCode']."-".$aDocDT['raItems'][$i]['FTPdtName'],0,900,"utf-8");?></td>

				<!-- <td style="text-align:right;"><?php echo number_format($aDocDT['raItems'][$i]['FCXpoUnitPrice'],2);?></td> -->
				<td style="text-align:right;"><?php echo number_format($aDocDT['raItems'][$i]['FCXpoQty'],0);?></td>
				<td><?php echo $aDocDT['raItems'][$i]['FTPunName'];?></td>
				<!-- <td style="text-align:right;"><?php echo number_format($aDocDT['raItems'][$i]['FCXpoB4Dis'],2);?></td> -->
				<!-- <td style="text-align:right;"><?php echo $aDocDT['raItems'][$i]['FTXpoDisTxt'];?></td>
				<td style="text-align:right;"><?php echo number_format($aDocDT['raItems'][$i]['FCXpoAfDT'],2);?></td> -->
			</tr>
		<?php } ?>
	<?php }else{ ?>
		<tr><td colspan="9">-ไม่มีรายการสินค้าในเอกสาร-</td></tr>
	<?php } ?>
</table>


<?php 
	$nPageFirstHalf 	= 9;	//หน้าแรกโชว์ครึ่งนึง ถึง แสดงรายละเอียด
	$nPageFirstFull 	= 14;	//หน้าแรกโชว์เต็ม

	$nPageNormalHalf 	= 17;	//หน้าถัดไปโชว์ครึ่งนึง ถึง แสดงรายละเอียด
	$nPageNormalFull 	= 21;	//หน้าถัดไปโชว์เต็ม

	if($nTotal <= $nPageFirstHalf){  //แสดงว่ามีแค่ page เดียวให้ "โชว์เลย"
		$nSplitPage 	= false;
	}else if($nTotal > $nPageFirstHalf){ //มีมากกว่าหนึ่ง page 

		if($nTotal < $nPageFirstFull){ //ถ้ายังไม่ถึง 14 record แสดงว่าอยู่หน้าแรก ให้รายละเอียด "ขึ้นหน้าใหม่"
			$nSplitPage = true;
		}else if($nTotal >= $nPageFirstFull){ 		//ถ้าเกิน 14 recode แสดงว่าขึ้นหน้าสอง
			$nTotal = $nTotal - $nPageFirstFull; 		//จำนวนทั้งหมด แต่มันต้องลบจำนวนหน้าแรกทิ้ง
			$n 			= ($nTotal / $nPageNormalFull); //หนึ่งหน้าจะโชว์ได้ 21 ตัว
			if(floor($n) == 0 && $nTotal < $nPageNormalHalf){  //ถ้าเป็น page แรก ถ้าน้อยกว่า 17 "โชว์เลย"
				$nSplitPage = false;
			}else if(floor($n) >= 1 && (($nTotal) - ($nPageNormalFull * floor($n))) < $nPageNormalHalf){ //ถ้าเป็น page 2 3 4 .. หลังจากลบ 21 ตัว เเละน้อยกว่า 17 "โชว์เลย"
				$nSplitPage = false;
			}else{ //"ขึ้นหน้าใหม่"
				$nSplitPage = true;
			}
		}
	}

	//ขึ้นหน้าใหม่
	if($nSplitPage == true){ ?>
		<br pagebreak="true" />
	<?php }
?>

<!--ส่วนของรายละเอียดสรุปบิล-->
<table cellpadding="0" >
	<tr>
		<!--ส่วนของสรุปยอดเงิน ยอดตัวเลข + หมายเหตุ-->
		<td>
			<table>
				<!-- <tr>
					<td class="xWTextNumber"><?php echo $aDocHeader['raItems'][0]['FTXpoGndText'];?></td>
				</tr> -->
				<tr>
					<td>หมายเหตุ</td>
				</tr>
				<tr>
					<td style="height:76px;border:1px solid #f5f5f5;"><?php echo $aDocHeader['raItems'][0]['FTXpoRmk'];?></td>
				</tr>
			</table>
		</td>

		<!--ส่วนของสรุปยอดเงิน-->
		<!-- <td>
			<table style="border:1px solid #f5f5f5;" cellpadding="2">
				<tr>
					<td style="border-right:1px solid #f5f5f5;border-bottom:1px solid #f5f5f5;">จำนวนเงินรวม</td>
					<td style="text-align:right;border-bottom:1px solid #f5f5f5;"><?php echo number_format($aDocHeader['raItems'][0]['FCXpoB4Dis'],2);?></td>
				</tr>
				<tr>
					<td style="border-right:1px solid #f5f5f5">ส่วนลด</td>
					<td style="text-align:right"><?php echo number_format($aDocHeader['raItems'][0]['FCXpoDis'],2);?></td>
				</tr>
				<tr>
					<td style="border-right:1px solid #f5f5f5">จำนวนเงินหลังหักส่วนลด</td>
					<td style="text-align:right"><?php echo number_format($aDocHeader['raItems'][0]['FCXpoAFDis'],2);?></td>
				</tr>
				<tr>
					<td style="border-right:1px solid #f5f5f5">ภาษีมูลค่าเพิ่ม (7%)</td>
					<td style="text-align:right"><?php echo number_format($aDocHeader['raItems'][0]['FCXpoAmtVat'],2);?></td>
				</tr>
				<tr>
					<td style="border-right:1px solid #f5f5f5;border-top:1px solid #f5f5f5">จำนวนเงินรวมทั้งสิ้น</td>
					<td style="text-align:right;border-top:1px solid #f5f5f5"><?php echo number_format($aDocHeader['raItems'][0]['FCXpoGrand'],2);?></td>
				</tr>
			</table>
		</td> -->
	</tr>
</table>

<!--ส่วนของลายเซ็นดิจิตอล-->
<table>
  	<tr>
		<!--ผู้อนุมัติคำสั่งซื้อ-->
		<td>
			<table style="border:1px solid #f5f5f5;" cellpadding="2">
				<tr>
					<td style="border:1px solid #f5f5f5;">&nbsp;เงื่อนไขอื่นๆ </td>
				</tr>
				<tr>
					<td>&nbsp;(1) โปรดระบุเลขที่ใบสั่งซื้อข้างต้น ในใบส่งของทุกฉบับ </td>
				</tr>
				<tr>
					<td>&nbsp;(2) การวางบิลการรับเช็ค เป็นไปตามกำหนดเวลาที่บริษัทกำหนดไว้ </td>
				</tr>
				<tr>
					<td>&nbsp;(3) ในการวางบิลเพื่อเรียกเก็บ ให้แนบสำเนาใบสั่งซื้อกำกับมาด้วย </td>
				</tr>
			</table>
		</td>

		<!--ผู้จัดการ-->
		<td>
			<table style="border:1px solid #f5f5f5;">
				<tr>
					<?php
						if($aLicense['raItems'][0]['FTUsrPathSignature'] != '' || $aLicense['raItems'][0]['FTUsrPathSignature'] != null){
							$tPathImageSignature = './application/assets/images/user/'.$aLicense['raItems'][0]['FTUsrPathSignature'];
							if (file_exists($tPathImageSignature)){
								$tPathImageSignature = base_url().'application/assets/images/user/'.$aLicense['raItems'][0]['FTUsrPathSignature'];
							}else{
								$tPathImageSignature = base_url().'application/assets/images/user/NoImage.png';
							}
						}else{
							$tPathImageSignature = '';
						}
					?>
					<td style="<?=($tPathImageSignature == '') ? 'height:36px;' : ''?>">&nbsp;ลงชื่อ </td>
				</tr>
				<tr>
					<td style="text-align:center;border-bottom:1px solid #f5f5f5;"><img class="img-responsive" style="width:48px;" src="<?=@$tPathImageSignature;?>"></td>
				</tr>
				<tr>
					<td>&nbsp;ผู้จัดการ<br>
					&nbsp;วันที่ ......... /......... /.........</td>
					<td></td>
				</tr>
			</table>
		</td>
	</tr>
</table>




