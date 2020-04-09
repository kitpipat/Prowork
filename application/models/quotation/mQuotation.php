<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mQuotation extends CI_Model {

	/*
	Create On : 05/04/2020
	Create By : Kitpipat Kaewkieo
	Update On : -
	Update By : -

	เกี่ยวกับฟังก์ชั่น
	----------------------------------------------
	แสดงข้อมูลสำหรับการกรองข้อมูลสินค้า
	ข้อมูลที่สามารถกรองได้
	ผู้จำหน่าย,กลุ่มสินค้า,ประเภทสินค้า,ยี่ห้อ,ขนาด,สี
	*/
	public function FSaMQUOGetFilterList(){

         $tSQL = "SELECT F.* FROM (
                                       SELECT 'FGSPL' AS FTFilGrpCode,
                                               'ผู้จำหน่าย'  AS FTFilGrpName ,
                                               FTSplCode  AS FTFilCode ,
                                               FTSplName  AS FTFilName
                                        FROM TCNMSpl

                                        UNION ALL

                                        SELECT 'FGPBN' AS FTFilGrpCode,
                                               'ยี่ห้อ' AS FTFilGrpName ,
                                               FTPbnCode AS FTFilCode ,
                                               FTPbnName AS FTFilName
                                        FROM TCNMPdtBrand

                                        UNION ALL

                                        SELECT 'FGPGP' AS FTFilGrpCode,
                                               'กลุ่มสินค้า' AS FTFilGrpName ,
                                               FTPgpCode AS FTFilCode,
                                               FTPgpName AS FTFilName
                                        FROM TCNMPdtGrp

                                        UNION ALL

                                        SELECT 'FGPTY' AS FTFilGrpCode,
                                               'ประเภทสินค้า' AS FTFilGrpName ,
                                               FTPtyCode AS FTFilCode,
                                               FTPtyName  AS FTFilName
                                        FROM TCNMPdtType
                                        UNION ALL

                                        SELECT 'FGPZE' AS FTFilGrpCode,
                                              'ขนาด' AS FTFilGrpName ,
                                              FTPzeCode AS FTFilCode,
                                              FTPzeName  AS FTFilName
                                        FROM TCNMPdtSize

                                        UNION ALL

                                        SELECT 'FGCLR' AS FTFilGrpCode,
                                               'สี' AS FTFilGrpName ,
                                               FTPClrCode AS FTFilCode,
                                               FTPClrName  AS FTFilName
                                        FROM TCNMPdtColor

                  ) F
                  --WHERE FTFilCode = 'xxx'";

                  $oQuery = $this->db->query($tSQL);
                  $nCountRows = $oQuery->num_rows();
                  if($nCountRows > 0){
                      $aResult = array(
                          'raItems'  => $oQuery->result_array(),
                          'nTotalRes' => $nCountRows,
                          'rtCode'   => '1',
                          'rtDesc'   => 'success',
                      );
                  }else{
                      $aResult = array(
                          'rtCode' => '800',
                          'rtDesc' => 'data not found',
                      );
                  }
                  return $aResult;

	}

	/*
	Create On : 05/04/2020
	Create By : Kitpipat Kaewkieo
	Update On : -
	Update By : -

	เกี่ยวกับฟังก์ชั่น
	----------------------------------------------
	ข้อมูลสินค้าและราคาขาย
	เงื่อนไข
	1.คำนวนส่วนลดต้นทุนแล้ว
	2.คำนวนราคาขายแล้ว
	3.ราคานี้เป็นราคาตามกลุ่มราคาที่ผูกกับผู้ใช้ที่กำลังทำรายการ
	*/
  public function FSaMQUPdtList($paFilter){

			  $tKeySearch = $paFilter["tKeySearch"];
				$tPriceGrp = $paFilter["tPriceGrp"];

        $tSQL = "SELECT P.* FROM (
                 SELECT ROW_NUMBER() OVER(ORDER BY PDT.FTPdtCode) AS RowID,
                         PDT.FTPdtCode,
                         PDT.FTPdtName,
                         PGP.FTPgpName,
                         PDT.FTPdtImage ,
                         PDT.FCPdtCostStd,
												 PDT.FTPunCode,
												 PDT.FTSplCode,
                         PDT.FCPdtCostAFDis,
                         PDT.FCPdtSalPrice AS FCPdtStdSalPri ,
                         SP.FCXpdAddPri AS FCPdtUsrSalPri,
                         CASE WHEN ISNULL(PDT.FCPdtSalPrice,0) = 0 AND  ISNULL(SP.FCXpdAddPri,0) = 0
                              THEN ISNULL(PDT.FCPdtCostAFDis,0)

                              WHEN ISNULL(PDT.FCPdtSalPrice,0) <> 0 AND  ISNULL(SP.FCXpdAddPri,0) = 0
                              THEN ISNULL(PDT.FCPdtCostAFDis,0) + (ISNULL(PDT.FCPdtCostAFDis,0) * ISNULL(PDT.FCPdtSalPrice,0))/100

                              WHEN ISNULL(PDT.FCPdtSalPrice,0) = 0 AND  ISNULL(SP.FCXpdAddPri,0) <> 0
                              THEN ISNULL(PDT.FCPdtCostAFDis,0) + (ISNULL(PDT.FCPdtCostAFDis,0) * ISNULL(SP.FCXpdAddPri,0))/100

                              ELSE 0
                              END AS FCPdtNetSalPri
                  FROM VCN_Products PDT
                  LEFT JOIN (
                     SELECT * FROM VCN_AdjSalePriActive WHERE FTPriGrpID = '".$tPriceGrp."'
                  )SP ON PDT.FTPdtCode = SP.FTPdtCode
                  LEFT JOIN TCNMPdtGrp PGP ON PDT.FTPgpCode = PGP.FTPgpCode ) P
                  WHERE  1=1 ";


									if($tKeySearch != ""){
										 $tSQL.= " AND P.FTPdtName LIKE '%".$tKeySearch."%'";
										 $tSQL.= " OR P.FTPdtCode LIKE '%".$tKeySearch."%'";
									}


									$tSQL.=" AND    P.RowID >=1 AND P.RowID <=10 ";



                  $oQuery = $this->db->query($tSQL);
                  $aResult = array(
                      'raItems'  => $oQuery->result_array(),
                      'rtCode'   => '1',
                      'rtDesc'   => 'success'
                  );

                  return $aResult;

  }

	/*
	Create On : 06/04/2020 14:03:00
	Create By : Kitpipat Kaewkieo
	Update On : -
	Update By : -

	เกี่ยวกับฟังก์ชั่น
	----------------------------------------------
	หาจำนวนข้อมูลสินค้าตามเงื่อนไขการกรอง
	*/
	public function FSaMQUOPdtCountRow($paFilter){

         $tKeySearch = $paFilter["tKeySearch"];

		     $tSQL = "SELECT FTPDTCode
				          FROM   TCNMPdt
									WHERE  FTPdtStatus = 1

									--AND    FTPdtCode='9999'
									";

        if($tKeySearch !=""){
					  $tSQL.=" AND FTPdtName LIKE '%".$tKeySearch."%'";
						$tSQL.=" OR FTPdtName LIKE '%".$tKeySearch."%'";
				}

									$oQuery = $this->db->query($tSQL);
									return $oQuery->num_rows();
	}

	/*
	Create On : 06/04/2020 14:03:00
	Create By : Kitpipat Kaewkieo
	Update On : -
	Update By : -

	เกี่ยวกับฟังก์ชั่น
	----------------------------------------------
	หาจำนวนข้อมูลสินค้าในใบเสนอราคา จากตาราง Temp DT
	กรณี create จะหาจาก tWorkerID
	กรณี edit จะหาจาก Docno
	*/
	public function FCaMQUOGetItemsList($paFilter){

				 $tDocNo = $paFilter['tDocNo'];
		     $tWorkerID = $paFilter['tWorkerID'];
				 $nMode = $paFilter['nMode'];

         $tSQL = "SELECT D.FNXqdSeq,
									       D.FTPdtCode,
									       D.FTPdtName,
									       D.FCXqdUnitPrice,
									       D.FCXqdQty,
												 D.FCXqdB4Dis,
									       P.FTPdtImage
									FROM TARTSqDTTmp D
									LEFT JOIN TCNMPdt P ON D.FTPdtCode = P.FTPdtCode
									WHERE 1 = 1 ";

									if($nMode == 1){
										 $tSQL.=" AND D.FTWorkerID = '".$tWorkerID."'";
									}else{
										 $tSQL.=" AND D.FTXqhDocNo = '".$tDocNo."'";
									}

									$oQuery = $this->db->query($tSQL);
									$nCountRows = $oQuery->num_rows();

									if($nCountRows > 0){
                      $aResult = array(
                          'raItems'  => $oQuery->result_array(),
                          'nTotalRes' => $nCountRows,
                          'rtCode'   => '1',
                          'rtDesc'   => 'success',
                      );
                  }else{
                      $aResult = array(
                          'rtCode' => '800',
													'nTotalRes' => 0,
                          'rtDesc' => 'data not found',
                      );
                  }
                  return $aResult;

	}

  public function FCnMQUExitingItem($paFilter){

				 if(isset($paFilter['tDocNo'])){
					  $tDocNo = $paFilter['tDocNo'];
				 }else{
					 $tDocNo = '';
				 }

				 $tWorkerID = $paFilter['tWorkerID'];
				 $tPdtCode = $paFilter['tPdtCode'];

         $tSQL = "SELECT FCXqdQty
				         FROM   TARTSqDTTmp
								 WHERE  FTPdtCode  = '$tPdtCode'
								 AND    FTWorkerID = '$tWorkerID' ";

				 if($tDocNo != ""){
					  $tSQL.=" AND FTXqhDocNo = '$tDocNo' ";
				 }

				 $oQuery = $this->db->query($tSQL);
				 $nCountRows = $oQuery->num_rows();

				 if($nCountRows > 0){
						 $aResult = $oQuery->result_array();
						 return $aResult[0]["FCXqdQty"] + 1;
				 }else{
						 return 1; //Not Exiting
				 }
	}

	public function FCaMQUOGetItemLastSeq($paFilter){

         $tDocNo = $paFilter['tDocNo'];
		     $tWorkerID = $paFilter['tWorkerID'];

         $tSQL = "SELECT TOP 1 FNXqdSeq
									FROM TARTSqDTTmp
									WHERE 1=1 ";

									if($tDocNo != ""){
										 $tSQL.=" AND FTXqhDocNo = '".$tDocNo."'";
									}else{
										 $tSQL.=" AND FTWorkerID = '".$tWorkerID."'";
									}

									$tSQL.="  ORDER BY FNXqdSeq DESC ";

									$oQuery = $this->db->query($tSQL);
									$nCountRows = $oQuery->num_rows();

									if($nCountRows > 0){
                      $aResult = $oQuery->result_array();
											return $aResult[0]["FNXqdSeq"] + 1;
                  }else{
                      return 1;
                  }


	}

	public function FCaMQUOAddItem2Temp($paItemData){
		     $this->db->insert('TARTSqDTTmp',$paItemData);
	}

  public function FCxMQUOUpdateItem($paItemData){

         $tSQL = "UPDATE TARTSqDTTmp
				          SET   FCXqdQty = '".$paItemData['FCXqdQty']."',
									      FCXqdB4Dis = '".$paItemData['FCXqdB4Dis']."'
									WHERE FTPdtCode  = '".$paItemData['FTPdtCode']."'
									AND   FTWorkerID = '".$paItemData['FTWorkerID']."'";

									if($paItemData['FTXqhDocNo'] != ""){
										 $tSQL.= " AND FTXqhDocNo = '".$paItemData['FTXqhDocNo']."'";
									}

									$this->db->query($tSQL);
	}

	public function FCxMQUODeleteItem($paItemData){

		     $tQuoDocNo = $paItemData['tQuoDocNo'];
				 $tWorkerID = $paItemData['tWorkerID'];
				 $nItemSeq = $paItemData['nItemSeq'];

		     $tSQL = "DELETE FROM TARTSqDTTmp
				          WHERE  FNXqdSeq = '$nItemSeq'
									AND    FTWorkerID = '$tWorkerID' ";

									if($tQuoDocNo !=""){
										$tSQL.= " AND FTXqhDocNo = '$tQuoDocNo' ";
									}

				 $this->db->query($tSQL);
	}

	public function FCxMQUOEditItemQty($paItemData){

		     $tQuoDocNo = $paItemData['tQuoDocNo'];
				 $tWorkerID = $paItemData['tWorkerID'];
				 $nItemSeq = $paItemData['nItemSeq'];
				 $nItemQTY = $paItemData['nItemQTY'];
				 $nPriB4Dis = $paItemData['nPriB4Dis'];

		     $tSQL = "UPDATE TARTSqDTTmp
				          SET    FCXqdQty = '$nItemQTY' , FCXqdB4Dis = '$nPriB4Dis'
				          WHERE  FNXqdSeq = '$nItemSeq'
									AND    FTWorkerID = '$tWorkerID' ";

									if($tQuoDocNo !=""){
										$tSQL.= " AND FTXqhDocNo = '$tQuoDocNo' ";
									}

				 $this->db->query($tSQL);
	}
}
