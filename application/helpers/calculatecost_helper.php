<?php

    function FCNnHCOSCalCost($paPdtInfo){

             //ตรวจสอบว่ามีการส่งค่าสำหรับการคำนวนมาหรือไม่
             if(count($paPdtInfo) > 0){

                 $nStdCost =    $paPdtInfo['nStdCost'];
                 $tDisCost =    $paPdtInfo['tStepDisCost'];

                 //ตรวจสอบว่ามีการส่งต้นทุนสำหรับการคำนวนมาหรือไม่
                 if($nStdCost == '' or $nStdCost == null){
                    $nStdCost = 0;
                 }

                 //ตรวจสอบว่ามีการกรอกส่วนลดมาหรือไม่
                 if($tDisCost !='' or $tDisCost !=0){

                    $aDisCost = explode(",",$tDisCost);
                    $nCostAFDis = $nStdCost;
                    for($i=0;$i<count($aDisCost);$i++){

                        $tDisCost = trim(str_replace("%","",$aDisCost[$i]));

                        //หาว่าเป็นการลดแบบไหน ลดบาท หรือ ลด %
                        $tDisType = substr($aDisCost[$i],strlen($aDisCost[$i]) -1);

                        //ตรวจสอบว่ามีการกรอกส่วนลดที่ถูกต้องตาม Format หรือไม่ ถ้าไม่ถูกระบบจะไม่คำนวนส่วนลดให้
                        if($tDisType !='%' and !is_numeric($tDisType)){

                           $nCostAFDis  = $nCostAFDis;

                        }else{
                                //การกรอกส่วนลดถูกต้องตาม format ให้ทำการคำนวนตามประเภทส่วนลด
                                if($tDisType == '%'){
                                   $nCostAFDis = $nCostAFDis - (($nCostAFDis * $tDisCost)/100); //ลดเป็นเปอร์เซนต์
                                }else{
                                   $nCostAFDis = $nCostAFDis - (-$tDisCost); //ลดเป็นบาท
                                }
                        }

                    }

                      return $nCostAFDis;

                 }else{

                    return $nStdCost;

                 }
             }else{
                  //ไม่มีการส่งค่าสำหรับคำนวนมา
                  return 0;
             }

    }

?>
