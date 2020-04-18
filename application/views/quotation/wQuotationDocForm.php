<div class="container-fulid">

  <div class="row" style="margin-bottom:15px;">
        <div class="col-lg-8 col-md-8"><span class="xCNHeadMenu">ใบเสนอราคา / รายละเอียด</span></div>
        <div class="col-lg-4 col-md-4 text-right">
            <button type="button" class="button">ยกเลิก</button>
            <button type="button" class="button">พิมพ์</button>
            <button type="button" class="button">อนุมัติ</button>
            <button type="button" class="button" onclick="FSxQUOSaveDoc()">บันทึก</button>
        </div>
  </div>

  <div class="row">
       <div class="col-lg-6">
             <div class="row">
                   <div class="col-lg-12">
                        <div style="background:#e8e6e6;padding:5px;">
                             ข้อมูลลูกค้า
                        </div>
                   </div>
                   <div class="col-lg-12">
                         <!-- form customer section -->
                         <div class="card">
                              <div class="card-body xWCardHead">
                                   <form id="ofmQuotationCst">
                                         <table style="width:100%">
                                           <tr>
                                             <td colspan="2">ลูกค้า <br>
                                                <input type="text" id="oetCstName" name="oetCstName">
                                             </td>
                                           </tr>
                                           <tr>
                                             <td colspan="2">ที่อยู่ <br>
                                                 <textarea id="oetAddress" name="oetAddress"></textarea>
                                              </td>
                                           </tr>
                                           <tr>
                                             <td colspan="2">เลขที่ประจำตัวผู้เสียภาษี <br>
                                                 <input type="text" id="oetTaxNo" name="oetTaxNo">
                                              </td>
                                           </tr>
                                           <tr>
                                             <td>ผู้ติดต่อ <br>
                                                <input type="text" id="oetContact" name="oetContact">
                                              </td>
                                              <td>อีเมลล์ <br>
                                                 <input type="text" id="oetEmail" name="oetEmail">
                                              </td>
                                           </tr>
                                           <tr>
                                             <td>เบอร์โทรศัพท์ <br>
                                                <input type="text" id="oetTel" name="oetTel">
                                             </td>
                                             <td>เบอร์โทรสาร <br>
                                                 <input type="text" id="oetFax" name="oetFax">
                                             </td>
                                           </tr>
                                           <tr>
                                               <td>
                                                   ชื่อโครงการ <br>
                                                   <input type="text" id="oetPrjName" name="oetPrjName">
                                               </td>
                                               <td>
                                                    หมายเลขอ้างอิง <br>
                                                    <input type="text" id="oetPrjCodeRef" name="oetPrjCodeRef">
                                               </td>
                                           </tr>
                                         </table>
                                   </form>
                              </div>
                         </div>
                         <!-- end form customer section -->
                   </div>
             </div>
       </div>
       <div class="col-lg-6">
             <div class="row" id="odvQuoDocHeader">
                 <div class="col-lg-6" style="padding-right:0px;margin-right:0px">
                       <div style="background:#beecbb;padding:5px;">
                            เลขที่เอกสาร :
                            <span id="ospDocNo" data-docno="<?=$tDocNo?>">
                            <?php
                                    if($tDocNo == ""){
                                        echo "<lable id='olbDocNo'> SQ########## </lable>";
                                    }else{
                                        echo " <lable id='olbDocNo'> ".$tDocNo." </label> ";
                                    }
                            ?>
                            </span>
                       </div>
                 </div>
                 <div class="col-lg-6" style="padding-left:0px;margin-left:0px">
                      <div style="background:#beecbb;padding:5px;">วันที่เอกสาร : <span id="ospDocDate"></span> </div>
                 </div>
                 <div class="col-lg-12">
                       <!-- form document header -->
                       <div class="card">

                                    <div class="card-body xWCardHead">
                                          สถานะเอกสาร : <span id="ospStaDoc"></span>
                                          <hr>
                                          <form id="ofmQuotationHeader">
                                                <table style="width:100%">
                                                  <tr>
                                                    <td style="width:50%">
                                                          ยื่นราคาภายใน (วัน) <br>
                                                          <input type="text" class="text-right" id="oetXqhSmpDay" name="oetXqhSmpDay">
                                                    </td>
                                                    <td>
                                                          มีผลถึงวันที่ <br>
                                                          <input type="date" id="odpXqhEftTo" name="odpXqhEftTo">
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td>
                                                          เงื่อนไขการชำระเงิน <br>
                                                          <select  name="ocmXqhCshOrCrd" id="ocmXqhCshOrCrd">
                                                                  <option value="">เลือกประเภทการชำระ</option>
                                                                  <option value="1">เงินสด</option>
                                                                  <option value="2">เครดิต</option>
                                                          </select>
                                                    </td>
                                                    <td>
                                                          จำนวนวันเครดิต (วัน) <br>
                                                          <input type="text" class="text-right" id="oetXqhCredit" name="oetXqhCredit">
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                    <td>
                                                          กำหนดส่งของ <br>
                                                          <input type="date" id="odpDeliveryDate" name="odpDeliveryDate">
                                                    </td>
                                                    <td>
                                                           ประเภทภาษี <br>
                                                            <select name="ocmVatType" id="ocmVatType">
                                                                  <option value="1">แยกนอก</option>
                                                                  <option value="2">รวมใน</option>
                                                            </select>
                                                    </td>
                                                  </tr>
                                                </table>
                                          </form>
                                          <hr>
                                          <table style="width:100%">
                                            <tr>
                                              <td style="width:50%">
                                                  <input type="checkbox" id="ocbStaExpress" name="ocbStaExpress" value="1"> เอกสารด่วน
                                              </td>
                                              <td>ผู้บันทึก : <span id="ospCreateBy"></span></td>
                                            </tr>
                                            <tr>
                                              <td>
                                                  <input type="checkbox" id="ocbtStaDocActive" name="ocbtStaDocActive" value="1"> เคลื่อนไหว
                                              </td>
                                              <td>ผู้อนุมัติ : <span id="ospApprovedBy"></span> </td>
                                            </tr>
                                            <tr>
                                              <td>
                                                  <input type="checkbox" id="ocbStaDeli" name="ocbStaDeli" value="1"> จัดส่งสินค้าแล้ว
                                              </td>
                                              <td>วันที่อนุมัติ : <span id="ospApproveDate"></span></td>
                                            </tr>
                                          </table>

                                    </div>

                       </div>
                       <!-- end form document header -->
                 </div>

             </div>
       </div>
  </div>

  <div class="card">
       <div class="card-body" style="height:auto">
            <div class="row">
                <div class="col-lg-12" id="odvQuoDocItems">

                </div>
                <div class="col-lg-12">
                     <div class="text-left">[+] เพิ่มรายการ</div>
                </div>
            </div>
       </div>
  </div>

  <div class="row">
       <div class="col-lg-7">
            <div class="card">
                 <div class="card-body" style="height:auto">
                      <p>หมายเหตุ</p>
                      หมายเหตุ <br>
                      <textarea rows="6" id="otaDocRemark"></textarea>
                 </div>
            </div>
       </div>
       <div class="col-lg-5">
            <div class="card">
                 <div class="card-body" style="height:auto">
                      <table class="table">
                        <tr>
                          <td style="width:50%">จำนวนเงินรวม</td>
                          <td style="width:20%"></td>
                          <td style="width:30%" class="text-right" id="otdDocNetTotal">100.00</td>
                        </tr>
                        <tr>
                          <td>ส่วนลด</td>
                          <td> <input type="text" id="oetXqhDisText" class="text-right"> </td>
                          <td class="text-right"><span id="ospXqhDis">0</span></td>
                        </tr>
                        <tr>
                          <td>จำนวนเงินหลังหักส่วนลด</td>
                          <td></td>
                          <td class="text-right" id="otdNetAFHD">100.00</td>
                        </tr>
                        <tr>
                          <td>ภาษีมูลค่าเพิ่ม (%)</td>
                          <td> <input type="text" class="text-right" id="oetVatRate"> </td>
                          <td class="text-right" id="otdVat">100.00</td>
                        </tr>
                        <tr>
                          <td>จำนวนเงินรวมทั้งสิ้น</td>
                          <td></td>
                          <td class="text-right" id="otdGrandTotal">100.00</td>
                        </tr>
                      </table>
                 </div>
            </div>
       </div>
  </div>

</div>

<style media="screen">
   input[type=text],input[type=date],select,textarea{
     width: 100%;
   }
   .xWCardHead{
     min-height: 488px;
   }
</style>

<script type="text/javascript" src="<?=base_url('application/assets/js/account.js') ?>"></script>
<script type="text/javascript" src="<?=base_url('application/assets/js/moment.js') ?>"></script>
<?php include ('script/jquotation_doc.php'); ?>
<link rel="stylesheet" href="<?=base_url('application/assets/css/quotation.css') ?>">
<link rel="stylesheet" href="<?=base_url('application/assets/css/check-radio.css') ?>">
