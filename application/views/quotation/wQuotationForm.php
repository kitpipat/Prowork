<table cellpadding="0" cellspacing="3">
  <tbody>
    <tr>
      <td valign="top" class="xCNPanel">
        <table cellpadding="5" cellspacing="5">
          <tr>
            <td class="xWCmpSection">
              <img src="<?=base_url('application/assets/images/logo.png')?>" style="width:120px;"> <br>
              <label style="font-size:22px">บริษัท โปรเวิร์ค รีเทล จำกัด </label>  <br>
              เลขที่ 2044/1 ถนนเพชรบุรีตัดใหม่ แขวงบางกะปิ<br>
              เขตห้วยขวาง จังหวัดกรุงเทพๆ 10310<br>
              Tel : 098-257-5229  Email: Prowork.lamp@gmail.com
            </td>
          </tr>
          <tr>
            <td>
              ลูกค้า <br>
              นายกิตติ์พิภัทร์  แก้วเขียว<br>
              99/9  ถนนลาดพร้าว แขวงคลองเจ้าคุณสิงห์<br>
              เขตวังทองหลาง กรุงเทพมหานคร 10310 โทร 099-6549870 <br>
              เลขประจำตัวผู้เสียภาษี
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

          <table cellpadding="0" cellspacing="7" style="border-bottom:1px solid #f4f4f4;">

            <tr>
              <th>เลขที่ใบเสนอราคา</th>
              <td>SQ00001202004-0001s</td>
            </tr>
            <tr>
              <th>วันที่เอกสาร</th>
              <td>26/04/2020</td>
            </tr>
          </table>
          <table cellpadding="0" cellspacing="7" class="xCNPanel">
            <tr>
              <td>ยื่นราคาภายใน : 30 วัน</td>
              <td>มีผลถึง : 30/05/2020</td>
            </tr>
            <tr>
              <td>การชำระเงิน : เงินสด</td>
              <td>จำนวนวันเครดิต : 30 วัน</td>
            </tr>
            <tr>
              <td>วันกำหนดส่งของ : 30/05/2020</td>
              <td>ผู้ติดต่อ : คุณรันต์ <br><br></td>
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
      <th class="XCNItemTitle" style="width:160px;">รายการ</th>
      <th class="XCNItemTitle" style="width:80px; text-align:right;">ราคา/หน่วย</th>
      <th class="XCNItemTitle" style="width:50px;text-align:right;">จำนวน</th>
      <th class="XCNItemTitle" style="width:50px;">หน่วย</th>
      <th class="XCNItemTitle" style="width:80px;text-align:right;">ราคา</th>
      <th class="XCNItemTitle" style="width:80px;text-align:right;">ส่วนลด</th>
      <th class="XCNItemTitle" style="width:100px;text-align:right;">ราคารวม</th>
    </tr>
    <?php $nTotal = 7;?>
    <?php for($i=1;$i<$nTotal;$i++){?>
    <tr>
      <td><?=$i?></td>
      <td><img src="<?=base_url('application/assets/images/products/Img7E3Y1VZ8M620200425.png')?>" style="width:25px;"></td>
      <td><?php echo mb_substr("P38-โคมไฟห้อยเพดาน Q245",0,28,"utf-8");?></td>
      <td style="text-align:right;">12,500.00</td>
      <td style="text-align:right;">1</td>
      <td>ชิ้น</td>
      <td style="text-align:right;">12,500.00</td>
      <td style="text-align:right;">500.00</td>
      <td style="text-align:right;">12,000.00</td>
    </tr>
    <?php } ?>
  </table>
  <?php if($nTotal == 12){?>
  <br><br><br><br><br><br><br><br><br><br>
  <?php } ?>
  <?php if($nTotal == 13){?>
  <br><br><br><br><br><br><br><br>
  <?php } ?>
  <?php if($nTotal == 14){?>
  <br><br><br><br><br><br>
  <?php } ?>
  <?php if($nTotal == 15){?>
  <br><br><br><br>
  <?php } ?>

<table cellpadding="5" cellspacing="0">
<tr>
<td>
<table cellpadding="7" cellspacing="0">
  <tr>
    <td class="xWTextNumber">หนึ่งพันบาทถ้วน</td>
  </tr>
  <tr>
    <td>หมายเหตุ</td>
  </tr>
  <tr>
    <td style="height:100px;border:1px solid #f4f4f4;">-</td>
  </tr>
</table>
</td>
      <td>
            <table style="border:1px solid #f4f4f4;" cellpadding="7" cellspacing="0">
              <tr>
                <td style="border-right:1px solid #f4f4f4;border-bottom:1px solid #f4f4f4;">จำนวนเงินรวม</td>
                <td style="text-align:right;border-bottom:1px solid #f4f4f4;">100.00</td>
              </tr>
              <tr>
                <td style="border-right:1px solid #f4f4f4">ส่วนลด</td>
                <td style="text-align:right">100.00</td>
              </tr>
              <tr>
                <td style="border-right:1px solid #f4f4f4">จำนวนเงินหลังหักส่วนลด</td>
                <td style="text-align:right">100.00</td>
              </tr>
              <tr>
                <td style="border-right:1px solid #f4f4f4">ภาษีมูลค่าเพิ่ม (7%)</td>
                <td style="text-align:right">100.00</td>
              </tr>
              <tr>
                <td style="border-right:1px solid #f4f4f4;border-top:1px solid #f4f4f4">จำนวนเงินรวมทั้งสิ้น</td>
                <td style="text-align:right;border-top:1px solid #f4f4f4">100.00</td>
              </tr>
            </table>
      </td>
    </tr>
  </table>

  <?php if($nTotal == 8){?>
  <br><br><br><br><br><br><br><br><br><br>
  <?php } ?>
  <?php if($nTotal == 9){?>
  <br><br><br><br><br><br><br><br>
  <?php } ?>
  <?php if($nTotal == 10){?>
  <br><br><br><br><br>
  <?php } ?>
  <?php if($nTotal == 11){?>
  <br><br><br>
  <?php } ?>
  <?php if($nTotal == 30){?>
  <br><br><br><br><br><br><br><br><br>
  <?php } ?>
  <?php if($nTotal == 31){?>
  <br><br><br><br><br><br><br>
  <?php } ?>
<table>
  <tr>
    <td>
 <table cellpadding="7" cellspacing="0" style="height:100px;border:1px solid #f4f4f4;">
      <tr>
        <td style="height:100px;border-bottom:1px solid #f4f4f4;">ลงชื่อ</td>
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
        <table cellpadding="7" cellspacing="0" style="height:100px;border:1px solid #f4f4f4;">
          <tr>
            <td style="height:100px;border-bottom:1px solid #f4f4f4;">ลงชื่อ</td>
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
        <table cellpadding="7" cellspacing="0" style="height:100px;width:220px;border:1px solid #f4f4f4;">
          <tr>
            <td style="height:100px;border-bottom:1px solid #f4f4f4;">ลงชื่อ</td>
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



<style>
  .red{
    background-color: green;
  }
  div{
    border: none;
  }
  .xCNPanel{
    background-color: #ffffff;
    border: 1px solid #f4f4f4;
  }
  .xWSQDocName{
    background-color: #B0DAA7;
    border: 1px solid #f4f4f4;
    height: 15px;
    text-align: center;
    font-size: 25px;
    border-radius: 50%;
  }
  .xWCmpSection{
    padding-top:10;
    border-bottom:1px solid #f4f4f4;
  }
  .xCNTitle{
    font-weight: 700;
    font-size: 22px;
  }
  .XCNItemTitle{
    border-bottom:1px solid #f4f4f4;
    border-top:1px solid #f4f4f4;
  }
  .xWTextNumber{
    background-color: #B0DAA7;
    border: 1px solid #f4f4f4;
    height: 15px;
    text-align: center;
    font-size: 18px;
    border-radius: 50%;
  }
</style>
