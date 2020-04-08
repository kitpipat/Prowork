<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mSupplier extends CI_Model {
	
	public function FSaMSUPGetData($paData){
		$aRowLen   		= FCNaHCallLenData($paData['nRow'],$paData['nPage']);
		$tTextSearch 	= trim($paData['tSearchAll']);
		$tSQL  = "SELECT c.* FROM(";
		$tSQL .= " SELECT  ROW_NUMBER() OVER(ORDER BY FTSplCode ASC) AS rtRowID,* FROM (";
		$tSQL .= " SELECT 
					SPL.FTSplCode,
					SPL.FTSplName,
					SPL.FTSplAddress,
					SPL.FTSplContact,
					SPL.FTSplTel,
					SPL.FTSplFax,
					SPL.FTSplEmail,
					SPL.FTSplPathImg,
					SPL.FTSplStaActive,
					SPL.FDLastUpdOn,
					SPL.FTLastUpdBy,
					SPL.FDCreateOn,
					SPL.FTCreateBy
 					FROM TCNMSpl SPL";
		$tSQL .= " WHERE 1=1 ";

		if($tTextSearch != '' || $tTextSearch != null){
			$tSQL .= " AND ( SPL.FTSplName LIKE '%$tTextSearch%' ";
			$tSQL .= " OR SPL.FTSplAddress LIKE '%$tTextSearch%' ";
			$tSQL .= " OR SPL.FTSplContact LIKE '%$tTextSearch%' ";
			$tSQL .= " OR SPL.FTSplTel LIKE '%$tTextSearch%' ";
			$tSQL .= " OR SPL.FTSplEmail LIKE '%$tTextSearch%' )";
		}

		$tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
			$oFoundRow 	= $this->FSaMSUPGetData_PageAll($paData);
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
	public function FSaMSUPGetData_PageAll($paData){
		try{
			$tTextSearch = trim($paData['tSearchAll']);
			$tSQL 		= "SELECT COUNT (SPL.FTSplCode) AS counts FROM TCNMSpl SPL ";
			$tSQL 		.= " WHERE 1=1 ";
			if($tTextSearch != '' || $tTextSearch != null){
				$tSQL .= " AND ( SPL.FTSplName LIKE '%$tTextSearch%' ";
				$tSQL .= " OR SPL.FTSplAddress LIKE '%$tTextSearch%' ";
				$tSQL .= " OR SPL.FTSplContact LIKE '%$tTextSearch%' ";
				$tSQL .= " OR SPL.FTSplTel LIKE '%$tTextSearch%' ";
				$tSQL .= " OR SPL.FTSplEmail LIKE '%$tTextSearch%' )";
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

	//หาผู้จำหน่ายล่าสุด
	public function FSaMSUPGetLastSuppliercode(){
		$tSQL = "SELECT TOP 1 FTSplCode FROM TCNMSpl ORDER BY FTSplCode * 1  DESC ";
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

	//เพิ่มผู้จำหน่าย
	public function FSxMSUPInsert($aResult){
		try{
			$this->db->insert('TCNMSpl', $aResult);
		}catch(Exception $Error){
			echo $Error;
		}
	}

	//ลบผู้จำหน่าย
	public function FSaMSUPDelete($ptCode){
		try{
			$this->db->where_in('FTSplCode', $ptCode);
            $this->db->delete('TCNMSpl');
		}catch(Exception $Error){
            echo $Error;
        }
	}

	//หาผู้จำหน่ายจาก ไอดี
	public function FSaMUSRGetDataSupplierBYID($ptCode){
		$tSQL = " SELECT SUP.* FROM TCNMSpl SUP";
		$tSQL .= " WHERE SUP.FTSplCode = '$ptCode' ";
		$oQuery = $this->db->query($tSQL);
		return $oQuery->result_array();
	}

	//แก้ไขข้อมูลผู้จำหน่าย
	public function FSxMSUPUpdate($ptSet,$ptWhere){
		try{
			$this->db->where('FTSplCode', $ptWhere['FTSplCode']);
			$this->db->update('TCNMSpl', $ptSet);
		}catch(Exception $Error){
			echo $Error;
		}
	}
}
