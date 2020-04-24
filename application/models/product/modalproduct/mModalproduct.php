<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mModalproduct extends CI_Model {
	
	public function FSaMMOPGetData($paData){
		$aRowLen   		= FCNaHCallLenData($paData['nRow'],$paData['nPage']);
		$tTextSearch 	= trim($paData['tSearchAll']);
		$tSQL  = "SELECT c.* FROM(";
		$tSQL .= " SELECT  ROW_NUMBER() OVER(ORDER BY FTMolCode DESC) AS rtRowID,* FROM (";
		$tSQL .= " SELECT 
					DISTINCT
						MOP.FTMolCode , 
						MOP.FTMolName ,
						PDT.FTMolCode AS 'PDT_use'
					FROM TCNMPdtModal MOP 
					LEFT JOIN TCNMPdt PDT ON PDT.FTMolCode = MOP.FTMolCode ";
		$tSQL .= " WHERE 1=1 ";

		if($tTextSearch != '' || $tTextSearch != null){
			$tSQL .= " AND ( MOP.FTMolCode LIKE '%$tTextSearch%' ";
			$tSQL .= " OR MOP.FTMolName  LIKE '%$tTextSearch%' )";
		}

		$tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
			$oFoundRow 	= $this->FSaMMOPGetData_PageAll($paData);
			$nFoundRow 	= $oFoundRow[0]->counts;
			$nPageAll 	= ceil($nFoundRow/$paData['nRow']); 
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
	public function FSaMMOPGetData_PageAll($paData){
		try{
			$tTextSearch = trim($paData['tSearchAll']);
			$tSQL 		= "SELECT COUNT (MOP.FTMolCode) AS counts FROM TCNMPdtModal MOP ";
			$tSQL 		.= " WHERE 1=1 ";
			if($tTextSearch != '' || $tTextSearch != null){
				$tSQL .= " AND ( MOP.FTMolCode LIKE '%$tTextSearch%' ";
				$tSQL .= " OR MOP.FTMolName  LIKE '%$tTextSearch%' )";
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

	//หาข้อมูลล่าสุด
	public function FSaMMOPGetLastModalPDTcode(){
		$tSQL = "SELECT TOP 1 FTMolCode FROM TCNMPdtModal ORDER BY FTMolCode DESC ";
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

	//เพิ่ม
	public function FSxMMOPInsert($aResult){
		try{
			$this->db->insert('TCNMPdtModal', $aResult);
		}catch(Exception $Error){
			echo $Error;
		}
	}

	//ลบ
	public function FSaMMOPDelete($ptCode){
		try{
			$this->db->where_in('FTMolCode', $ptCode);
            $this->db->delete('TCNMPdtModal');
		}catch(Exception $Error){
            echo $Error;
        }
	}

	//หาข้อมูลจาก ไอดี
	public function FSaMMOPGetDataModalProductBYID($ptCode){
		$tSQL = " SELECT * FROM TCNMPdtModal MOP";
		$tSQL .= " WHERE MOP.FTMolCode = '$ptCode' ";
		$oQuery = $this->db->query($tSQL);
		return $oQuery->result_array();
	}

	//แก้ไขข้อมูล
	public function FSxMMOPUpdate($ptSet,$ptWhere){
		try{
			$this->db->where('FTMolCode', $ptWhere['FTMolCode']);
			$this->db->update('TCNMPdtModal', $ptSet);
		}catch(Exception $Error){
			echo $Error;
		}
	}

}
