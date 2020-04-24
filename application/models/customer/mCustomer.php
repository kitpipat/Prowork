<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mCustomer extends CI_Model {
	
	public function FSaMCUSGetData($paData){
		$aRowLen   		= FCNaHCallLenData($paData['nRow'],$paData['nPage']);
		$tTextSearch 	= trim($paData['tSearchAll']);
		$tSQL  = "SELECT c.* FROM(";
		$tSQL .= " SELECT  ROW_NUMBER() OVER(ORDER BY FTCstCode DESC) AS rtRowID,* FROM (";
		$tSQL .= " SELECT 
					DISTINCT
						CUS.FTCstCode,
						CUS.FTCstName,
						CUS.FTCstContactName,
						CUS.FTCstCardID,
						CUS.FTCstTaxNo,
						CUS.FTCstSex,
						CUS.FDCstDob,
						CUS.FTCstAddress,
						CUS.FTCstTel,
						CUS.FTCstFax,
						CUS.FTCstEmail,
						CUS.FNCstPostCode,
						CUS.FTCstWebSite,
						CUS.FTCstReason,
						CUS.FTCstPathImg,
						CUS.FTCstStaActive,
						BCH.FTBchName
					FROM TCNMCst CUS 
					LEFT JOIN TCNMBranch BCH ON CUS.FTBchCode = BCH.FTBchCode ";
		$tSQL .= " WHERE 1=1 ";

		if($tTextSearch != '' || $tTextSearch != null){
			$tSQL .= " AND ( CUS.FTCstName LIKE '%$tTextSearch%' ";
			$tSQL .= " OR CUS.FTCstCode LIKE '%$tTextSearch%' ";
			$tSQL .= " OR CUS.FTCstContactName LIKE '%$tTextSearch%' ";
			$tSQL .= " OR CUS.FTCstCardID LIKE '%$tTextSearch%' ";
			$tSQL .= " OR CUS.FTCstTaxNo LIKE '%$tTextSearch%' ";
			$tSQL .= " OR CUS.FDCstDob LIKE '%$tTextSearch%' ";
			$tSQL .= " OR CUS.FTCstAddress LIKE '%$tTextSearch%' ";
			$tSQL .= " OR CUS.FTCstTel LIKE '%$tTextSearch%' ";
			$tSQL .= " OR CUS.FTCstWebSite LIKE '%$tTextSearch%' )";
		}

		//รองรับการมองเห็นตามสาขา
		if($this->session->userdata('tSesUserLevel') == 'BCH'){
			$tBCHCode = $this->session->userdata('tSesBCHCode');
			$tSQL .= " AND CUS.FTBchCode = '$tBCHCode' ";
		}

		$tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
			$oFoundRow 	= $this->FSaMCUSGetData_PageAll($paData);
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
	public function FSaMCUSGetData_PageAll($paData){
		try{
			$tTextSearch = trim($paData['tSearchAll']);
			$tSQL 		= "SELECT COUNT (CUS.FTCstCode) AS counts FROM TCNMCst CUS ";
			$tSQL 		.= " WHERE 1=1 ";
			if($tTextSearch != '' || $tTextSearch != null){
				$tSQL .= " AND ( CUS.FTCstName LIKE '%$tTextSearch%' ";
				$tSQL .= " OR CUS.FTCstCode LIKE '%$tTextSearch%' ";
				$tSQL .= " OR CUS.FTCstContactName LIKE '%$tTextSearch%' ";
				$tSQL .= " OR CUS.FTCstCardID LIKE '%$tTextSearch%' ";
				$tSQL .= " OR CUS.FTCstTaxNo LIKE '%$tTextSearch%' ";
				$tSQL .= " OR CUS.FDCstDob LIKE '%$tTextSearch%' ";
				$tSQL .= " OR CUS.FTCstAddress LIKE '%$tTextSearch%' ";
				$tSQL .= " OR CUS.FTCstTel LIKE '%$tTextSearch%' ";
				$tSQL .= " OR CUS.FTCstWebSite LIKE '%$tTextSearch%' )";
			}

			//รองรับการมองเห็นตามสาขา
			if($this->session->userdata('tSesUserLevel') == 'BCH'){
				$tBCHCode = $this->session->userdata('tSesBCHCode');
				$tSQL .= " AND CUS.FTBchCode = '$tBCHCode' ";
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
	public function FSaMCUSGetLastCustomercode(){
		$tSQL = "SELECT TOP 1 FTCstCode FROM TCNMCst ORDER BY FTCstCode DESC ";
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
	public function FSxMCUSInsert($aResult){
		try{
			$this->db->insert('TCNMCst', $aResult);
		}catch(Exception $Error){
			echo $Error;
		}
	}

	//ลบ
	public function FSaMCUSDelete($ptCode){
		try{
			$this->db->where_in('FTCstCode', $ptCode);
            $this->db->delete('TCNMCst');
		}catch(Exception $Error){
            echo $Error;
        }
	}

	//หาข้อมูลจาก ไอดี
	public function FSaMCUSGetDataCustomerBYID($ptCode){
		$tSQL = " SELECT * FROM TCNMCst CUS";
		$tSQL .= " WHERE CUS.FTCstCode = '$ptCode' ";
		$oQuery = $this->db->query($tSQL);
		return $oQuery->result_array();
	}

	//แก้ไขข้อมูล
	public function FSxMCUSUpdate($ptSet,$ptWhere){
		try{
			$this->db->where('FTCstCode', $ptWhere['FTCstCode']);
			$this->db->update('TCNMCst', $ptSet);
		}catch(Exception $Error){
			echo $Error;
		}
	}

}
