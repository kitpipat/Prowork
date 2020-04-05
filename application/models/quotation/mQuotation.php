<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mQuotation extends CI_Model {
  // get filter data
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

  public function FSaMQUPdtList(){

        $tSQL = "SELECT P.* FROM (
                 SELECT ROW_NUMBER() OVER(ORDER BY PDT.FTPdtCode) AS RowID,
                         PDT.FTPdtCode,
                         PDT.FTPdtName,
                         PGP.FTPgpName,
                         PDT.FTPdtImage ,
                         PDT.FCPdtCostStd,
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
                     SELECT * FROM VCN_AdjSalePriActive WHERE FNRhdID = 1
                  )SP ON PDT.FTPdtCode = SP.FTPdtCode
                  LEFT JOIN TCNMPdtGrp PGP ON PDT.FTPgpCode = PGP.FTPgpCode ) P
                  WHERE P.RowID >=1 AND P.RowID <=10 ";

                  $oQuery = $this->db->query($tSQL);
                  $aResult = array(
                      'raItems'  => $oQuery->result_array(),
                      'rtCode'   => '1',
                      'rtDesc'   => 'success'
                  );

                  return $aResult;

  }

}
