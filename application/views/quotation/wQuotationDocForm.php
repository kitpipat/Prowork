<div class="container-fulid">

  <div class="row">
        <div class="col-lg-12 col-md-12"><span class="xCNHeadMenu">ใบเสนอราคา / รายละเอียด</span></div>
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
                         <div class="card">
                              <div class="card-body xWCardHead">
                                   <table style="width:100%">
                                     <tr>
                                       <td>ลูกค้า <br>
                                          <input type="text" id="oetCstName" value="">
                                       </td>
                                     </tr>
                                     <tr>
                                       <td>ที่อยู่ <br>
                                           <input type="text" id="oetAddress" value="">
                                        </td>
                                     </tr>
                                     <tr>
                                       <td>เลขที่ประจำตัวผู้เสียภาษี <br>
                                           <input type="text" id="oetTaxNo" name="" value="">
                                        </td>
                                     </tr>
                                     <tr>
                                       <td>ผู้ติดต่อ <br>
                                          <input type="text" id="oetContact" value="">
                                        </td>
                                     </tr>
                                     <tr>
                                       <td>อีเมลล์ <br>
                                          <input type="text" id="oetEmail" value="">
                                       </td>
                                     </tr>
                                     <tr>
                                       <td>เบอร์โทรศัพท์ <br>
                                          <input type="text" id="oetTel" value="">
                                       </td>
                                     </tr>
                                     <tr>
                                       <td>เบอร์โทรสาร <br>
                                           <input type="text" id="oetFax" value="">
                                       </td>
                                     </tr>
                                   </table>
                              </div>
                         </div>
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
                       <div class="card">
                            <div class="card-body xWCardHead">
                                  สถานะเอกสาร : <span id="ospStaDoc"></span>
                                  <hr>
                                  <table style="width:100%">
                                    <tr>
                                      <td style="width:50%">
                                            ยื่นราคาภายใน (วัน) <br>
                                            <input type="text" class="text-right" id="oetXqhSmpDay" name="" value="">
                                      </td>
                                      <td>
                                            มีผลถึงวันที่ <br>
                                            <input type="date" id="odpXqhEftTo" name="" value="">
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                            เงื่อนไขการชำระเงิน <br>
                                            <select class="" name="" id="ocmXqhCshOrCrd">
                                                    <option value="">เลือกประเภทการชำระ</option>
                                                    <option value="1">เงินสด</option>
                                                    <option value="2">เครดิต</option>
                                            </select>
                                      </td>
                                      <td>
                                            จำนวนวันเครดิต (วัน) <br>
                                            <input type="text" class="text-right" id="oetXqhCredit" name="" value="">
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                            กำหนดส่งของ <br>
                                            <input type="date" id="odpDeliveryDate" name="" value="">
                                      </td>
                                      <td></td>
                                    </tr>
                                  </table>
                                  <hr>
                                  <table style="width:100%">
                                    <tr>
                                      <td style="width:50%">
                                          <input type="checkbox" id="ocbStaExpress" value=""> เอกสารด่วน
                                      </td>
                                      <td>ผู้บันทึก : <span id="ospCreateBy"></span></td>
                                    </tr>
                                    <tr>
                                      <td>
                                          <input type="checkbox" id="ocbtStaDocActive" value=""> เคลื่อนไหว
                                      </td>
                                      <td>ผู้อนุมัติ : <span id="ospApprovedBy"></span> </td>
                                    </tr>
                                    <tr>
                                      <td>
                                          <input type="checkbox" id="ocbStaDeli" value=""> จัดส่งสินค้าแล้ว
                                      </td>
                                      <td>วันที่อนุมัติ : <span id="ospApproveDate"></span></td>
                                    </tr>
                                  </table>

                            </div>
                       </div>
                 </div>

             </div>
       </div>

  </div>

  <div class="card">
       <div class="card-body" style="height:auto">
              <div class="row">

                   <div class="col-lg-6">
                        <div >
                             ชื่อโครงการ <input type="text" id="oetPrjName" value="" style="width:80%">
                        </div>
                   </div>
                   <div class="col-lg-6">
                        <div>
                          หมายเลขอ้างอิง <input type="text" id="oetPrjCodeRef" value="" style="width:30%">
                          ประเภทภาษี
                                      <select class="" style="width:30%" id="ocmVatType">
                                            <option value="1">แยกนอก</option>
                                            <option value="2">รวมใน</option>
                                      </select>
                        </div>
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
                          <td> <input type="text" name="" value=""> </td>
                          <td class="text-right">0</td>
                        </tr>
                        <tr>
                          <td>จำนวนเงินหลังหักส่วนลด</td>
                          <td></td>
                          <td class="text-right" id="otdNetAFHD">100.00</td>
                        </tr>
                        <tr>
                          <td>ภาษีมูลค่าเพิ่ม (%)</td>
                          <td> <input type="text" value="" id="oetVatRate"> </td>
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
     min-height: 530px;
   }
</style>

<script type="text/javascript" src="<?=base_url('application/assets/js/account.js') ?>"></script>
<script type="text/javascript" src="<?=base_url('application/assets/js/moment.js') ?>"></script>
<?php include ('script/jquotation_doc.php'); ?>
<link rel="stylesheet" href="<?=base_url('application/assets/css/quotation.css') ?>">
<link rel="stylesheet" href="<?=base_url('application/assets/css/check-radio.css') ?>">
