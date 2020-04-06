<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mPermission extends CI_Model {

	public function FSaMPERGetData($paData){
		$aRowLen   		= FCNaHCallLenData($paData['nRow'],$paData['nPage']);
		$tTextSearch 	= trim($paData['tSearchAll']);
		$tSQL  = "SELECT c.* FROM(";
		$tSQL .= " SELECT  ROW_NUMBER() OVER(ORDER BY FNRhdID*1 ASC) AS rtRowID,* FROM (";
		$tSQL .= " SELECT 
					ROL.FNRhdID,
					ROL.FTRhdName,
					ROL.FTRhdRmk,
					ROL.FTCreateBy,
					ROL.FDCreateOn,
					ROL.FDUpdateOn,
					ROL.FTUpdateBy
					FROM TCNMRoleHD ROL";
		$tSQL .= " WHERE 1=1 ";

		if($tTextSearch != '' || $tTextSearch != null){
			$tSQL .= " AND ( ROL.FTRhdName LIKE '%$tTextSearch%' ";
			$tSQL .= " OR ROL.FTRhdRmk LIKE '%$tTextSearch%' )";
		}

		$tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
			$oFoundRow 	= $this->FSaMPERGetData_PageAll($paData);
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
	public function FSaMPERGetData_PageAll($paData){
		try{
			$tTextSearch = trim($paData['tSearchAll']);
			$tSQL 		= "SELECT COUNT (ROL.FNRhdID) AS counts FROM TCNMRoleHD ROL ";
			$tSQL 		.= " WHERE 1=1 ";
			if($tTextSearch != '' || $tTextSearch != null){
				$tSQL .= " AND ( ROL.FTRhdName LIKE '%$tTextSearch%' ";
				$tSQL .= " OR ROL.FTRhdRmk LIKE '%$tTextSearch%' )";
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

	//หาเมนูทั้งหมด
	public function FSaMPERGetMenuAll(){
		$tSQL = "SELECT * FROM TSysMenu MEN WHERE MEN.FTMenStaUse = 1";
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

	//หากลุ่มสิทธิ์ล่าสุด
	public function FSaMPERGetLastRolecode(){
		$tSQL = "SELECT TOP 1 FNRhdID FROM TCNMRoleHD ORDER BY FNRhdID * 1  DESC ";
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

	//เพิ่มข้อมูล HD
	public function FSxMPERInsertHD($aResult){
		try{
			$this->db->insert('TCNMRoleHD', $aResult);
		}catch(Exception $Error){
			echo $Error;
		}
	}

	//ลบข้อมูล DT
	public function FSxMPERDeleteDT($pnCode){
		try{
			$this->db->where_in('FNRhdID', $pnCode);
            $this->db->delete('TCNMRoleDT');
		}catch(Exception $Error){
            echo $Error;
        }
	}

	//เพิ่มข้อมูล DT
	public function FSxMPERInsertDT($aResult){
		try{
			$this->db->insert('TCNMRoleDT', $aResult);
		}catch(Exception $Error){
			echo $Error;
		}
	}

	//ลบข้อมูล
	public function FSaMPERDelete($ptCode){
		try{
			$this->db->where_in('FNRhdID', $ptCode);
			$this->db->delete('TCNMRoleHD');
			
			$this->db->where_in('FNRhdID', $ptCode);
            $this->db->delete('TCNMRoleDT');
		}catch(Exception $Error){
            echo $Error;
        }
	}

	//หาข้อมูลตาม ไอดี
	public function FSaMPERGetDataPermissionBYID($ptCode){
		$tSQL = " SELECT 
					RHD.FNRhdID,
					RHD.FTRhdName,
					RHD.FTRhdRmk, 
					RDT.FNMenID,
					RDT.FTRdtAlwRead,
					RDT.FTRdtAlwCreate,
					RDT.FTRdtAlwDel,
					RDT.FTRdtAlwEdit,
					RDT.FTRdtAlwCancel,
					RDT.FTRdtAlwApv,
					RDT.FTRdtAlwPrint
					FROM TCNMRoleHD RHD";
		$tSQL .= " LEFT JOIN TCNMRoleDT RDT ON RHD.FNRhdID = RDT.FNRhdID ";
		$tSQL .= " WHERE RHD.FNRhdID = '$ptCode' ";
		$oQuery = $this->db->query($tSQL);
		return $oQuery->result_array();
	}

	//อัพเดทข้อมูล
	public function FSxMPERUpdateHD($ptSet,$ptWhere){
		try{
			$this->db->where('FNRhdID', $ptWhere['FNRhdID']);
			$this->db->update('TCNMRoleHD', $ptSet);
		}catch(Exception $Error){
			echo $Error;
		}
	}
	
}
