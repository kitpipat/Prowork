<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mInformation extends CI_Model {

	function FSaMINFGetData(){
		$tUsercode = $this->session->userdata('tSesUsercode');
		$tSQL = " SELECT 
					USR.FTUsrImgPath,
					USR.FTUsrCode,
					USR.FTBchCode,
					USR.FTUsrFName,
					USR.FTUsrLName,
					USR.FTUsrDep,
					USR.FTUsrEmail,
					USR.FTUsrTel,
					USR.FNRhdID,
					USR.FNStaUse,
					USR.FTPriGrpID,
					RHD.FTRhdName,
					PRIG.FTPriGrpName,
					USR.FNUsrGrp,
					USR.FTUsrRmk,
					BCH.FTBchName FROM TCNMUsr USR";
		$tSQL .= " LEFT JOIN TCNMBranch BCH ON USR.FTBchCode = BCH.FTBchCode";
		$tSQL .= " LEFT JOIN TCNMRoleHD RHD ON RHD.FNRhdID = USR.FNRhdID";
		$tSQL .= " LEFT JOIN TCNMPriGrp PRIG ON PRIG.FTPriGrpID = USR.FTPriGrpID";
		$tSQL .= " WHERE 1=1 ";
		$tSQL .= " AND USR.FTUsrCode = '$tUsercode' ";
		$oQuery = $this->db->query($tSQL);
		return $oQuery->result_array();
	}

	//หาเอกสาร ที่ตัวเอกสร้างขึ้น
	public function FSaMPILGetData($paData){
		$tUsercode 		= $this->session->userdata('tSesUsercode');
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

		$tSQL .= " AND HD.FTCreateBy = '$tUsercode ' ";

		if($tTextSearch != '' || $tTextSearch != null){
			$tSQL .= " AND ( HD.FTXqhDocNo LIKE '%$tTextSearch%' )";
		}

		//รองรับการมองเห็นตามสาขา
		// if($this->session->userdata('tSesUserLevel') == 'BCH'){
		// 	$tBCHCode = $this->session->userdata('tSesBCHCode');
		// 	$tSQL .= " AND HD.FTBchCode = '$tBCHCode' ";
		// }

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
			$tUsercode 	 = $this->session->userdata('tSesUsercode');
			$tTextSearch = trim($paData['tSearchAll']);
			$tSQL 		 = "SELECT COUNT (HD.FTXqhDocNo) AS counts FROM TARTSqHD HD ";
			$tSQL 		.= " WHERE 1=1 ";

			$tSQL .= " AND HD.FTCreateBy = '$tUsercode ' ";

			if($tTextSearch != '' || $tTextSearch != null){
				$tSQL .= " AND ( HD.FTXqhDocNo LIKE '%$tTextSearch%' )";
			}

			//รองรับการมองเห็นตามสาขา
			// if($this->session->userdata('tSesUserLevel') == 'BCH'){
			// 	$tBCHCode = $this->session->userdata('tSesBCHCode');
			// 	$tSQL .= " AND HD.FTBchCode = '$tBCHCode' ";
			// }

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

	//หาจำนวนเอกสารแต่ละประเภท
	public function FSaMINFGetCountQutation($ptType){
		try{
			$tSQL = "SELECT COUNT (HD.FTXqhDocNo) AS counts FROM TARTSqHD HD ";

			switch ($ptType) {
				case 1:  //เอกสารที่อนุมัติแล้ว
						$tSQL .= " WHERE HD.FTXqhStaApv = 1 ";
					break;
				case 2:  //เอกสารทั้งหมด
						$tSQL .= " WHERE 1=1 ";
					break;
				case 3:  //เอกสารที่ยกเลิก
						$tSQL .= " WHERE HD.FTXqhStaDoc = 2 ";
					break;
				default:
			}

			//รองรับการมองเห็นตามสาขา
			if($this->session->userdata('tSesUserLevel') == 'BCH'){
				$tBCHCode = $this->session->userdata('tSesBCHCode');
				$tSQL .= " AND HD.FTBchCode = '$tBCHCode' ";
			}
			$oQuery = $this->db->query($tSQL);
			if ($oQuery->num_rows() > 0) {
				$oResult = $oQuery->result();
				$nCount  = $oResult[0]->counts;
			}else{
				$nCount  = 0;
			}
			return $nCount;
		}catch(Exception $Error){
			echo $Error;
		}
	}

	//หาจำนวนสินค้าทั้งหมด
	public function FSaMINFGetCountProduct(){
		try{
			$tSQL 	= "SELECT COUNT (PDT.FTPdtCode) AS counts FROM TCNMPdt PDT ";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
				$oResult = $oQuery->result();
				$nCount  = $oResult[0]->counts;
            }else{
                $nCount  = 0;
			}
			return $nCount;
        }catch(Exception $Error){
            echo $Error;
        }
	}

}
