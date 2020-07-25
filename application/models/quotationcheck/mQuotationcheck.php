<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mQuotationcheck extends CI_Model{

	public function FSaMCPIGetData($paData){
		$aRowLen   		= FCNaHCallLenData($paData['nRow'],$paData['nPage']);
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
						HD.FTXqhStaApv,
						HD.FTApprovedBy,
						HD.FDApproveDate,
						HD.FTCreateBy,
						HD.FDCreateOn,
						HD.FTUpdateBy,
						HD.FDUpdateOn,
						USRBUYER.FTUsrFName AS namebuy,
						USRCONSIG.FTUsrFName AS namecon,
						DT.FTPdtName,
						DT.FTPdtCode,
						DT.FNXqdSeq,
						DT.FCXqdUnitPrice,
						DT.FCXqdQty,
						DT.FDXqdPucDate,
						DT.FDXqdDliDate,
						DT.FTXqdBuyer,
						DT.FDXqdPikDate,
						DT.FTXqdRefInv,
						DT.FTXqdConsignee,
						DT.FTXqdRefBuyer,
						UNIT.FTPunName
					 FROM TARTSqHD HD
					 LEFT JOIN TARTSqDT DT ON HD.FTXqhDocNo = DT.FTXqhDocNo
					 LEFT JOIN TCNMUsr USRBUYER ON DT.FTXqdBuyer = USRBUYER.FTUsrCode
					 LEFT JOIN TCNMUsr USRCONSIG ON DT.FTXqdConsignee = USRCONSIG.FTUsrCode
					 LEFT JOIN TCNMPdtUnit UNIT ON UNIT.FTPunCode = DT.FTPunCode ";
		$tSQL .= " WHERE 1=1 ";

		//ค้นหาสาขา
		if(trim($paData['BCH']) != ''){
			$tBCH = $paData['BCH'];
			$tSQL .= " AND ( HD.FTBchCode = '$tBCH' )";
		}

		//ค้นหาเลขที่เอกสาร
		if(trim($paData['DocumentNumber']) != ''){
			$tDocumentNumber = $paData['DocumentNumber'];
			$tSQL .= " AND ( HD.FTXqhDocNo LIKE '%$tDocumentNumber%' )";
		}

		//ค้นหาสถานะเอกสาร
		// if(trim($paData['tStaDoc']) != ''){
		// 	$tStaDoc = $paData['tStaDoc'];
		// 	if($tStaDoc == 0){
		// 		$tSQL .= " AND ( ISNULL(HD.FTXqhStaApv,'') = '' )";
		// 	}else{
		// 		$tSQL .= " AND ( HD.FTXqhStaApv = '1' )";
		// 	}
		// }
		$tSQL .= " AND ( HD.FTXqhStaApv = '1' )";

		//ค้นหาสถานะจัดซื้อ
		if(trim($paData['tStaSale']) != ''){
			$tStaSale = $paData['tStaSale'];
			if($tStaSale == 1){
				$tSQL .= " AND ( ISNULL(DT.FDXqdPucDate,'') <> '' )";
			}else if($tStaSale == 0){
				$tSQL .= " AND ( ISNULL(DT.FDXqdPucDate,'') = '' )";
			}
		}

		//ค้นหาสถานะจัดส่ง
		if(trim($paData['tStaExpress']) != ''){
			$tStaExpress = $paData['tStaExpress'];
			if($tStaExpress == 1){
				$tSQL .= " AND ( ISNULL(DT.FDXqdDliDate,'') <> '' )";
			}else if($tStaExpress == 0){
				$tSQL .= " AND ( ISNULL(DT.FDXqdDliDate,'') = '' )";
			}
		}

		$tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
			$oFoundRow 	= $this->FSaMCPIGetData_PageAll($paData);
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
	public function FSaMCPIGetData_PageAll($paData){
		try{
			$tSQL 		= "SELECT COUNT (HD.FTXqhDocNo) AS counts FROM TARTSqHD HD ";
			$tSQL 		.= " LEFT JOIN TARTSqDT DT ON HD.FTXqhDocNo = DT.FTXqhDocNo ";
			$tSQL 		.= " LEFT JOIN TCNMUsr USR ON DT.FTXqdBuyer = USR.FTUsrCode ";
			$tSQL 		.= " LEFT JOIN TCNMPdtUnit UNIT ON UNIT.FTPunCode = DT.FTPunCode ";
			$tSQL 		.= " WHERE 1=1 ";

			//ค้นหาสาขา
			if(trim($paData['BCH']) != ''){
				$tBCH = $paData['BCH'];
				$tSQL .= " AND ( HD.FTBchCode = '$tBCH' )";
			}

			//ค้นหาเลขที่เอกสาร
			if(trim($paData['DocumentNumber']) != ''){
				$tDocumentNumber = $paData['DocumentNumber'];
				$tSQL .= " AND ( HD.FTXqhDocNo LIKE '%$tDocumentNumber%' )";
			}

			//ค้นหาสถานะเอกสาร
			// if(trim($paData['tStaDoc']) != ''){
			// 	$tStaDoc = $paData['tStaDoc'];
			// 	if($tStaDoc == 0){
			// 		$tSQL .= " AND ( ISNULL(HD.FTXqhStaApv,'') = '' )";
			// 	}else{
			// 		$tSQL .= " AND ( HD.FTXqhStaApv = '$tStaDoc' )";
			// 	}
			// }
			$tSQL .= " AND ( HD.FTXqhStaApv = '1' )";

			//ค้นหาสถานะจัดซื้อ
			if(trim($paData['tStaSale']) != ''){
				$tStaSale = $paData['tStaSale'];
				if($tStaSale == 1){
					$tSQL .= " AND ( ISNULL(DT.FDXqdPucDate,'') <> '' )";
				}else if($tStaSale == 0){
					$tSQL .= " AND ( ISNULL(DT.FDXqdPucDate,'') = '' )";
				}
			}

			//ค้นหาสถานะจัดส่ง
			if(trim($paData['tStaExpress']) != ''){
				$tStaExpress = $paData['tStaExpress'];
				if($tStaExpress == 1){
					$tSQL .= " AND ( ISNULL(DT.FDXqdDliDate,'') <> '' )";
				}else if($tStaExpress == 0){
					$tSQL .= " AND ( ISNULL(DT.FDXqdDliDate,'') = '' )";
				}
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

	//ข้อมูลสาขาทั้งหมด
	public function FSaMUSRGetBranch(){
		$tSQL = "SELECT * FROM TCNMBranch BCH";
		$tSQL .= " INNER JOIN TCNMCompany CMP ON BCH.FTCmpCode = CMP.FTCmpCode ";
		$oQuery = $this->db->query($tSQL);
		if($oQuery->num_rows() > 0){
			$aResult = array(
				'raItems'  => $oQuery->result_array(),
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

	//อัพเดทข้อมูล
	public function FSaMQTCUpdate($ptSet,$ptWhere){
		try{
			$this->db->where('FTXqhDocNo', $ptWhere['FTXqhDocNo']);
			$this->db->where('FNXqdSeq', $ptWhere['FNXqdSeq']);
			$this->db->where('FTPdtCode', $ptWhere['FTPdtCode']);
			$this->db->update('TARTSqDT', $ptSet);

			if($ptWhere['tType'] == 'REFCON'){ //ผู้รับ
				if($ptWhere['tValue'] == '' || $ptWhere['tValue'] == null){
					$this->db->set('FTXqdConsignee', '');
				}else{
					$this->db->set('FTXqdConsignee', $this->session->userdata('tSesUsercode'));
				}

				$this->db->where('FTXqhDocNo', $ptWhere['FTXqhDocNo']);
				$this->db->where('FNXqdSeq', $ptWhere['FNXqdSeq']);
				$this->db->where('FTPdtCode', $ptWhere['FTPdtCode']);
				$this->db->update('TARTSqDT');
			}else if($ptWhere['tType'] == 'REFBUY'){ //ผู้สั้งซื้อ
				if($ptWhere['tValue'] == '' || $ptWhere['tValue'] == null){
					$this->db->set('FTXqdBuyer', '');
				}else{
					$this->db->set('FTXqdBuyer', $this->session->userdata('tSesUsercode'));
				}
				
				$this->db->where('FTXqhDocNo', $ptWhere['FTXqhDocNo']);
				$this->db->where('FNXqdSeq', $ptWhere['FNXqdSeq']);
				$this->db->where('FTPdtCode', $ptWhere['FTPdtCode']);
				$this->db->update('TARTSqDT');
			}

		}catch(Exception $Error){
			echo $Error;
		}
	}
}
