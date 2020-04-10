<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mSizeproduct extends CI_Model {
	
	public function FSaMSIZGetData($paData){
		$aRowLen   		= FCNaHCallLenData($paData['nRow'],$paData['nPage']);
		$tTextSearch 	= trim($paData['tSearchAll']);
		$tSQL  = "SELECT c.* FROM(";
		$tSQL .= " SELECT  ROW_NUMBER() OVER(ORDER BY FTPzeCode ASC) AS rtRowID,* FROM (";
		$tSQL .= " SELECT 
					DISTINCT
						SIZ.FTPzeCode , 
						SIZ.FTPzeName ,
						PDT.FTPzeCode AS 'PDT_use'
					FROM TCNMPdtSize SIZ 
					LEFT JOIN TCNMPdt PDT ON PDT.FTPzeCode = SIZ.FTPzeCode ";
		$tSQL .= " WHERE 1=1 ";

		if($tTextSearch != '' || $tTextSearch != null){
			$tSQL .= " AND ( SIZ.FTPzeCode LIKE '%$tTextSearch%' ";
			$tSQL .= " OR SIZ.FTPzeName LIKE '%$tTextSearch%' )";
		}

		$tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
			$oFoundRow 	= $this->FSaMSIZGetData_PageAll($paData);
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
	public function FSaMSIZGetData_PageAll($paData){
		try{
			$tTextSearch = trim($paData['tSearchAll']);
			$tSQL 		= "SELECT COUNT (SIZ.FTPzeCode) AS counts FROM TCNMPdtSize SIZ ";
			$tSQL 		.= " WHERE 1=1 ";
			if($tTextSearch != '' || $tTextSearch != null){
				$tSQL .= " AND ( SIZ.FTPzeCode LIKE '%$tTextSearch%' ";
				$tSQL .= " OR SIZ.FTPzeName LIKE '%$tTextSearch%' )";
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
	public function FSaMSIZGetLastSizePDTcode(){
		$tSQL = "SELECT TOP 1 FTPzeCode FROM TCNMPdtSize ORDER BY FTPzeCode DESC ";
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
	public function FSxMSIZInsert($aResult){
		try{
			$this->db->insert('TCNMPdtSize', $aResult);
		}catch(Exception $Error){
			echo $Error;
		}
	}

	//ลบ
	public function FSaMSIZDelete($ptCode){
		try{
			$this->db->where_in('FTPzeCode', $ptCode);
            $this->db->delete('TCNMPdtSize');
		}catch(Exception $Error){
            echo $Error;
        }
	}

	//หาข้อมูลจาก ไอดี
	public function FSaMSIZGetDataSizeProductBYID($ptCode){
		$tSQL = " SELECT * FROM TCNMPdtSize SIZ";
		$tSQL .= " WHERE SIZ.FTPzeCode = '$ptCode' ";
		$oQuery = $this->db->query($tSQL);
		return $oQuery->result_array();
	}

	//แก้ไขข้อมูล
	public function FSxMSIZUpdate($ptSet,$ptWhere){
		try{
			$this->db->where('FTPzeCode', $ptWhere['FTPzeCode']);
			$this->db->update('TCNMPdtSize', $ptSet);
		}catch(Exception $Error){
			echo $Error;
		}
	}

}
