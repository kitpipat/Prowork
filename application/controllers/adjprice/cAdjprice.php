<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cAdjprice extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('adjprice/mAdjprice');
		date_default_timezone_set('Asia/Bangkok');
	}

	public function index(){
		$this->load->view('adjprice/wAdjpriceMain');
	}

	//โหลดข้อมูล เอกสารใบปรับราคา
	public function FSwCAJPLoadDatatable(){
		$nPage = $this->input->post('nPage');
		$aCondition = array(
			'nPage'         => $nPage,
			'nRow'          => 10,
			'tSearchAll'    => $this->input->post('tSearchAll')
		);

		$aList = $this->mAdjprice->FSaMAJPGetData($aCondition);
		$aPackData = array(
			'aList'				=> $aList,
			'nPage'				=> $nPage
		);
		$this->load->view('adjprice/wAdjpriceDatatable',$aPackData);
	}

	//โหลดหน้าจอเพื่มข้อมูล + แก้ไขข้อมูล
	public function FSwCAJPCallPageInsertorEdit(){
		$tTypePage = $this->input->post('tTypepage');

		//ลบข้อมูลใน Tmp ก่อน
		$this->mAdjprice->FSxMAJPDeleteTmpAfterInsDT('');

		if($tTypePage == 'insert'){
			$aResult	= '';
		}else if($tTypePage == 'edit'){
			$tCode 		= $this->input->post('tCode');
			$aResult 	= $this->mAdjprice->FSaMAJPGetDataBYID($tCode);

			//Move DT To Tmp
			$this->mAdjprice->FSaMAJPMoveDTToTmp($tCode);
		}

		$aPackData = array(
			'tTypePage' 		=> $tTypePage,
			'aResult'			=> $aResult,
			'aPriGrp'			=> $this->mAdjprice->FSaMAJPGetPriceGroup(),
		);
		$this->load->view('adjprice/wAdjpriceAdd',$aPackData);
	}

	//โหลดข้อมูลในตาราง Tmp
	public function FSxCAJPLoadTableDTTmp(){
		$tTypePage 				= $this->input->post('tTypepage');
		$tCode 					= $this->input->post('tCode');
		$nPage 					= $this->input->post('nPage');
		$tControlWhenAprOrCan 	= $this->input->post('tControlWhenAprOrCan');
		$aCondition = array(
			'nPage'         => $nPage,
			'nRow'          => 20,
			'tSearchTmp'    => $this->input->post('tSearchTmp')
		);

		$aListTmp 	= $this->mAdjprice->FSaMAJPGetDataInTmp($aCondition);
		$aPackData 	= array(
			'aListTmp'				=> $aListTmp,
			'nPage'					=> $nPage,
			'tControlWhenAprOrCan' 	=> $tControlWhenAprOrCan
		);
		$this->load->view('adjprice/wAdjpriceDatatableTmp',$aPackData);
	}

	//โหลดข้อมูลสินค้า (Master)
	public function FSvCAJPLoadPDT(){
		$tTypepage 		= $this->input->post('tTypepage');
		$tCode			= $this->input->post('tCode');
		$nPage			= $this->input->post('nPage');
		$tSearchPDT		= $this->input->post('tSearchPDT');

		$aCondition = array(
			'nPage'         => $nPage,
			'nRow'          => 10,
			'tSearchPDT'    => $this->input->post('tSearchPDT')
		);

		$aListPDT 	= $this->mAdjprice->FSaMAJPGetPDTToTmp($aCondition);
		$aPackData 	= array(
			'aListPDT'			=> $aListPDT,
			'nPage'				=> $nPage
		);
		$this->load->view('adjprice/wAdjpriceDatatableBrowsePDT',$aPackData);
	}

	//เพิ่มข้อมูลลงในตาราง Tmp
	public function FSvCAJPInsPDTToTmp(){
		$tTypepage 		= $this->input->post('tTypepage');
		$tCode			= $this->input->post('tCode');
		$aData			= $this->input->post('aData');
		if($aData !== null){
			$aResult = explode(",",$aData);
			for($i=0; $i<count($aResult); $i++){
				$aIns = array(
					'FTXphDocNo'	=> $tCode,
					'FTPdtCode'		=> $aResult[$i],
					'FCXpdAddPri'	=> '0.00',	
					'FDXphDateAtv'	=> date('Y-m-d H:i:s'),
					'FTWorkerID'	=> $this->session->userdata('tSesUsercode')
				);

				$this->mAdjprice->FSaMAJPInsertPDTToTmp($aIns);
			}
		}
		
	}

	//ลบข้อมูลในตาราง Tmp
	public function FSvCAJPDeletePDTInTmp(){
		$tPDTCode 	= $this->input->post('tPdtCode');
		$tCode 		= $this->input->post('tCode');
		$tWorkerID 	= $this->session->userdata('tSesUsercode');
		$aDelete 	= array(
			'FTXphDocNo' 	=> $tCode,
			'FTPdtCode'		=> $tPDTCode,
			'FTWorkerID'	=> $tWorkerID
		);
		$this->mAdjprice->FSaMAJPDeletePDTInTmp($aDelete);
	}

	//แก้ไขจำนวนในตาราง Tmp
	public function FSvCAJPUpdateInlinePDTInTmp(){
		$tPDTCode 		= $this->input->post('tPdtCode');
		$tCode 			= $this->input->post('tCode');
		$tValueUpdate	= $this->input->post('tValueUpdate'); 
		$tWorkerID 		= $this->session->userdata('tSesUsercode');
		$aSet 		= array(
			'FCXpdAddPri'	=> $tValueUpdate
		);
		$aWhere 	= array(
			'FTXphDocNo' 	=> $tCode,
			'FTPdtCode'		=> $tPDTCode,
			'FTWorkerID'	=> $tWorkerID
		);
		$this->mAdjprice->FSaMAJPUpdatePDTInTmp($aSet,$aWhere);
	}

	//เอาไฟล์เข้า Tmp
	public function FSxCAJPCallpageUplodeFile(){
		$aPackData 	= $this->input->post('aPackdata');
		$tCode 		= $this->input->post('tCode');

		if(isset($aPackData['AdjustmentPrice'])){
			// echo 'Correct';
		}else{
			echo 'Fail';
			exit;
		}

		$nPackData 	= count($aPackData['AdjustmentPrice']);
		$aResult   	= $aPackData['AdjustmentPrice'];
		for($i=1; $i<$nPackData; $i++){

			if(isset($aResult[$i][0])){
				$aCheck = array(
					'FTXphDocNo'	=> $tCode,
					'FTWorkerID'	=> $this->session->userdata('tSesUsercode'),
					'FTPdtCode' 	=> (isset($aResult[$i][0])) ? $aResult[$i][0] : ''
				);
				$aCheckDuplicate = $this->mAdjprice->FSaMAJPCheckDataDuplicate($aCheck);
				if($aCheckDuplicate['rtCode'] == 1){
					//Duplicate;
				}else{

					if((isset($aResult[$i][1]))){
						if($aResult[$i][1] > 100){
							$nAddPri = 100;
						}else{
							$nAddPri = $aResult[$i][1];
							if(preg_replace('/[^ก-ฮA-Za-z]/u','',$nAddPri)){
								$nAddPri = 0.00;
							}else{
								$nAddPri = $aResult[$i][1];
							}
						}
					}else{
						$nAddPri = 0.00;
					}

					$aIns = array(
						'FTPdtCode' 	=> (isset($aResult[$i][0])) ? $aResult[$i][0] : '',
						'FTXphDocNo'	=> $tCode,
						'FCXpdAddPri' 	=> $nAddPri,
						'FDXphDateAtv'	=> date('Y-m-d H:i:s'),
						'FTWorkerID'	=> $this->session->userdata('tSesUsercode')
					);

					if($aIns['FTPdtCode'] != '' || $aIns['FTPdtCode'] != null){
						$this->mAdjprice->FSaMAJPImportExcelInsert($aIns);
					}
				}
			}
		}
	}

	//อีเว้นท์เพิ่มข้อมูล
	public function FSwCAJPEventInsert(){
		$aLastCode 	= $this->mAdjprice->FSaMAJPGetLastDocumentAdjCode();
		if($aLastCode['rtCode'] == 800){
			$tFormatCode = 'AJP00001';
		}else{
			$nLastCode 		= $aLastCode['raItems'][0]['FTXphDocNo'];
			$aExplode		= explode("AJP",$nLastCode);
			$nNumber		= $aExplode[1] + 1;
			$nCountNumber	= count($nNumber);
			if($nCountNumber == 1){
				$tFormat 		= '0000';
			}else if($nCountNumber == 2){
				$tFormat 		= '000';
			}else if($nCountNumber == 3){
				$tFormat 		= '00';
			}else{
				$tFormat 		= '0';
			}

			$tFormatCode = 'AJP'.str_pad($nNumber,strlen($tFormat)+1,$tFormat,STR_PAD_LEFT);
		}

		$aInsertHD = array(
			'FTXphDocNo'	=> $tFormatCode,
			'FDXphDocDate'	=> date('Y-m-d H:i:s'),
			'FTXphDocTime'	=> date('H:i:s'),
			'FTBchCode'		=> $this->session->userdata('tSesBCHCode'),
			'FTPriGrpID'	=> $this->input->post('oetAJPPriGrp'),
			'FTXphStaDoc'	=> 1,
			'FTXphStaApv'	=> null,
			'FTXphRmk'		=> $this->input->post('oetAJPReason'),
			'FTCreateBy' 	=> $this->session->userdata('tSesUsercode'),
			'FDCreateOn'	=> date('Y-m-d H:i:s'),
		);

		//เพิ่มข้อมูลลง HD
		$this->mAdjprice->FSxMAJPInsertHD($aInsertHD);

		//เพิ่มข้อมูลลง DT
		$this->mAdjprice->FSxMAJPInsertDT($tFormatCode);

		//ลบข้อมูลใน Tmp หลังจาก เพิ่มลงใน DT แล้ว
		$this->mAdjprice->FSxMAJPDeleteTmpAfterInsDT('');

		$aReturn = array(
			'tStatus' 			=> 'pass_insert',
			'tDocuementnumber'	=> $tFormatCode
		);
		echo json_encode($aReturn);
	}

	//อีเว้นท์แก้ไข
	public function FSxCAJPEventEdit(){
		try{
			$tFormatCode = $this->input->post('ohdDocumentNumber');
			$aSetUpdate  = array(
				'FTPriGrpID'	=> $this->input->post('oetAJPPriGrp'),
				'FTXphRmk'		=> $this->input->post('oetAJPReason'),
				'FDUpdateOn'	=> date('Y-m-d H:i:s'),
				'FTUpdateBy'	=> $this->session->userdata('tSesUsercode')
			);

			$aWhereUpdate = array(
				'FTXphDocNo'	=> $tFormatCode
			);
			$this->mAdjprice->FSxMGRPUpdate($aSetUpdate,$aWhereUpdate);
			
			//ลบข้อมูลใน DT
			$this->mAdjprice->FSxMAJPDeleteDT($tFormatCode);

			//เพิ่มข้อมูลลง DT
			$this->mAdjprice->FSxMAJPInsertDT($tFormatCode);

			//ลบข้อมูลใน Tmp หลังจาก เพิ่มลงใน DT แล้ว
			$this->mAdjprice->FSxMAJPDeleteTmpAfterInsDT($tFormatCode);

			$aReturn = array(
				'tStatus' 			=> 'pass_update',
				'tDocuementnumber'	=> $tFormatCode
			);
			echo json_encode($aReturn);
		}catch(Exception $Error){
            echo $Error;
        }
	}

	//ลบเอกสาร
	public function FSxCAJPEventDelete(){
		$tCode = $this->input->post('ptCode');
		$this->mAdjprice->FSaMAJPDelete($tCode);
	}

	//ยกเลิกเอกสาร
	public function FSxCAJPCancleDocument(){
		$tCode = $this->input->post('tCode');
		$this->mAdjprice->FSaMAJPCancleDocument($tCode);
	}

	//อนุมัติเอกสาร
	public function FSxCAJPAproveDocument(){
		$tCode = $this->input->post('tCode');
		$this->mAdjprice->FSaMAJPAproveDocument($tCode);
	}

}
