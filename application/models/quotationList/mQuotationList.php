<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mQuotationList extends CI_Model{

	public function FSaMPILGetData($paData){
		$aRowLen   		= FCNaHCallLenData($paData['nRow'],$paData['nPage']);
		$tTextSearch 	= trim($paData['tSearchAll']);
		$tSQL  = "SELECT c.* FROM(";
		$tSQL .= " SELECT  ROW_NUMBER() OVER(ORDER BY FTXqhDocNo DESC) AS rtRowID,* FROM (";
		$tSQL .= " SELECT 
						HD.FTBchCode,
						HD.FTXqhDocNo,
						HD.FDXqhDocDate,
						HD.FTXqhCshOrCrd,
						HD.FNXqhCredit,
						HD.FTXqhVATInOrEx,
						HD.FNXqhSmpDay,
						HD.FDXqhEftTo,
						HD.FDDeliveryDate,
						HD.FTXqhStaExpress,
						HD.FTXqhStaDoc,
						HD.FTXqhStaActive,
						HD.FTXqhStaDeli,
						HD.FTXqhPrjName,
						HD.FTXqhPrjCodeRef,
						HD.FCXqhB4Dis,
						HD.FCXqhDis,
						HD.FTXqhDisTxt,
						HD.FCXqhAFDis,
						HD.FCXqhVatRate,
						HD.FCXqhAmtVat,
						HD.FCXqhVatable,
						HD.FCXqhGrand,
						HD.FCXqhRnd,
						HD.FTXqhGndText,
						HD.FTXqhRmk,
						HD.FTUsrDep,
						HD.FTApprovedBy,
						HD.FDApproveDate,
						HD.FTCreateBy,
						HD.FDCreateOn,
						HD.FTUpdateBy,
						HD.FDUpdateOn,
						HD.FTXqhStaApv,
						USR.FTUsrFName 
					 FROM TARTSqHD HD
					 LEFT JOIN TCNMUsr USR ON HD.FTApprovedBy = USR.FTUsrCode ";
		$tSQL .= " WHERE 1=1 ";

		if($tTextSearch != '' || $tTextSearch != null){
			$tSQL .= " AND ( HD.FTXqhDocNo LIKE '%$tTextSearch%' )";
		}

		$tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
			$oFoundRow 	= $this->FSaMPILGetData_PageAll($paData);
			$nFoundRow 	= $oFoundRow[0]->counts;
			$nPageAll 	= ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult 	= array(
				'raItems'  		=> $oQuery->result_array(),
				'rnAllRow'      => $nFoundRow,
				'rnCurrentPage' => $paData['nPage'],
				'rnAllPage'     => $nPageAll,
                'rtCode'   		=> '1',
                'rtDesc'   		=> 'success',
            );
        }else{
            $aResult = array(
				'rnAllRow' 		=> 0,
				'rnCurrentPage' => $paData['nPage'],
				"rnAllPage"		=> 0,
                'rtCode' 		=> '800',
                'rtDesc' 		=> 'data not found',
            );
        }
        return $aResult;
	}

	//หาจำนวนทั้งหมด
	public function FSaMPILGetData_PageAll($paData){
		try{
			$tTextSearch = trim($paData['tSearchAll']);
			$tSQL 		= "SELECT COUNT (HD.FTXqhDocNo) AS counts FROM TARTSqHD HD ";
			$tSQL 		.= " WHERE 1=1 ";
			if($tTextSearch != '' || $tTextSearch != null){
				$tSQL .= " AND ( HD.FTXqhDocNo LIKE '%$tTextSearch%' )";
			}

            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                return $oQuery->result();
            }else{
                return false;
            }
        }catch(Exception $Error){
            echo $Error;
        }
	}

	//ลบข้อมูลใน Tmp 
	public function FSaMPILDeleteTmpAll($ptWorkerID){

		$tSQLHD = "DELETE FROM TARTSqHDTmp WHERE FTWorkerID = '$ptWorkerID' ";
		$this->db->query($tSQLHD);

		$tSQLDT = "DELETE FROM TARTSqDTTmp WHERE FTWorkerID = '$ptWorkerID' ";
		$this->db->query($tSQLDT);

		$tSQLCustomer = "DELETE FROM TARTSqHDCstTmp WHERE FTWorkerID = '$ptWorkerID' ";
		$this->db->query($tSQLCustomer);
	}

	//ย้ายข้อมูล จาก HD -> Tmp
	public function FSaMPILMoveHDToTmp($ptDocNo,$ptWorkerID){
		$tSQL = "INSERT INTO TARTSqHDTmp 
					SELECT  
						FTBchCode,
						FTXqhDocNo,
						FDXqhDocDate,
						FTXqhCshOrCrd,
						FNXqhCredit,
						FTXqhVATInOrEx,
						FNXqhSmpDay,
						FDXqhEftTo,
						FDDeliveryDate,
						FTXqhStaExpress,
						FTXqhStaDoc,
						FTXqhStaActive,
						FTXqhStaDeli,
						FTXqhPrjName,
						FTXqhPrjCodeRef,
						FCXqhB4Dis,
						FCXqhDis,
						FTXqhDisTxt,
						FCXqhAFDis,
						FCXqhVatRate,
						FCXqhAmtVat,
						FCXqhVatable,
						FCXqhGrand,
						FCXqhRnd,
						FTXqhGndText,
						FTXqhRmk,
						FTUsrDep,
						FTXqhStaApv,
						FTApprovedBy,
						FDApproveDate,
						FTCreateBy,
						FDCreateOn,
						FTUpdateBy,
						FDUpdateOn,
						$ptWorkerID AS FTWorkerID
					FROM TARTSqHD
					WHERE FTXqhDocNo = '".$ptDocNo."' ";
		$this->db->query($tSQL);
	}

	//ย้ายข้อมูล จาก DT -> Tmp
	public function FSaMPILMoveDTToTmp($ptDocNo,$ptWorkerID){
		$tSQL = "  INSERT INTO TARTSqDTTmp
						SELECT
							FTXqhDocNo,
							FNXqdSeq,
							FTPdtCode,
							FTPdtName,
							FTPunCode,
							FTPunName,
							FTXqdCost,
							FCXqdUnitPrice,
							FCXqdQty,
							FTSplCode,
							FCXqdDis,
							FTXqdDisTxt,
							FCXqdFootAvg,
							null AS FDTmpTnsDate,
							FTCreateBy,
							FDCreateOn,
							$ptWorkerID AS FTWorkerID
						FROM TARTSqDT
						WHERE FTXqhDocNo = '".$ptDocNo."' ";
		$this->db->query($tSQL);
	}

	//ย้ายข้อมูล จาก HD Customer -> Tmp
	public function FSaMPILMoveHDCusToTmp($ptDocNo,$ptWorkerID){
		$tSQL = "INSERT INTO TARTSqHDCstTmp
					SELECT 
						FTXqhDocNo,
						FTXqcCstCode,
						FTXqcCstName,
						FTXqcAddress,
						FTXqhTaxNo,
						FTXqhContact,
						FTXqhEmail,
						FTXqhTel,
						FTXqhFax,
						FTCreateBy,
						FDCreateOn,
						FTUpdateBy,
						FDUpdateOn,
						$ptWorkerID AS FTWorkerID
					FROM TARTSqHDCst
					WHERE FTXqhDocNo = '".$ptDocNo."' ";
		$this->db->query($tSQL);
	}

	//ลบข้อมูลเอกสารทั้งหมด
	public function FSaMPILDeleteDocumentAll($ptDocNo){
		$tSQLHD = "DELETE FROM TARTSqHD WHERE FTXqhDocNo = '$ptDocNo' ";
		$this->db->query($tSQLHD);

		$tSQLDT = "DELETE FROM TARTSqDT WHERE FTXqhDocNo = '$ptDocNo' ";
		$this->db->query($tSQLDT);

		$tSQLCustomer = "DELETE FROM TARTSqHDCst WHERE FTXqhDocNo = '$ptDocNo' ";
		$this->db->query($tSQLCustomer);
	}
}
