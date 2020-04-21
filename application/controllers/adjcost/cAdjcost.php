<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cAdjcost extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('adjcost/mAdjcost');
		date_default_timezone_set('Asia/Bangkok');
	}

	public function index(){
		$this->load->view('adjcost/wAdjcostMain');
	}

	//โหลดข้อมูล เอกสารใบปรับต้นทุน
	public function FSwCAJCLoadDatatable(){
		$nPage = $this->input->post('nPage');
		$aCondition = array(
			'nPage'         => $nPage,
			'nRow'          => 10,
			'tSearchAll'    => $this->input->post('tSearchAll')
		);

		$aList = $this->mAdjcost->FSaMAJCGetData($aCondition);
		$aPackData = array(
			'aList'				=> $aList,
			'nPage'				=> $nPage
		);
		$this->load->view('adjcost/wAdjcostDatatable',$aPackData);
	}

	//โหลดหน้าจอเพื่มข้อมูล + แก้ไขข้อมูล
	public function FSwCAJCCallPageInsertorEdit(){
		$tTypePage = $this->input->post('tTypepage');

		//ลบข้อมูลใน Tmp ก่อน
		$this->mAdjcost->FSxMAJCDeleteTmpAfterInsDT('');

		if($tTypePage == 'insert'){
			$aResult	= '';
		}else if($tTypePage == 'edit'){
			$tCode 		= $this->input->post('tCode');
			$aResult 	= $this->mAdjcost->FSaMAJCGetDataBYID($tCode);

			//Move DT To Tmp
			$this->mAdjcost->FSaMAJCMoveDTToTmp($tCode);
		}

		$aPackData = array(
			'tTypePage' 		=> $tTypePage,
			'aResult'			=> $aResult
		);
		$this->load->view('adjcost/wAdjcostAdd',$aPackData);
	}

	//โหลดข้อมูลในตาราง Tmp
	public function FSxCAJCLoadTableDTTmp(){
		$tTypePage 				= $this->input->post('tTypepage');
		$tCode 					= $this->input->post('tCode');
		$nPage 					= $this->input->post('nPage');
		$tControlWhenAprOrCan 	= $this->input->post('tControlWhenAprOrCan');
		$aCondition = array(
			'nPage'         => $nPage,
			'nRow'          => 20,
			'tSearchTmp'    => $this->input->post('tSearchTmp')
		);

		$aListTmp 	= $this->mAdjcost->FSaMAJCGetDataInTmp($aCondition);
		$aPackData 	= array(
			'aListTmp'				=> $aListTmp,
			'nPage'					=> $nPage,
			'tControlWhenAprOrCan' 	=> $tControlWhenAprOrCan
		);
		$this->load->view('adjcost/wAdjcostDatatableTmp',$aPackData);
	}

	//โหลดข้อมูลสินค้า (Master)
	public function FSvCAJCLoadPDT(){
		$tTypepage 		= $this->input->post('tTypepage');
		$tCode			= $this->input->post('tCode');
		$nPage			= $this->input->post('nPage');
		$tSearchPDT		= $this->input->post('tSearchPDT');

		$aCondition = array(
			'nPage'         => $nPage,
			'nRow'          => 10,
			'tSearchPDT'    => $this->input->post('tSearchPDT')
		);

		$aListPDT 	= $this->mAdjcost->FSaMAJCGetPDTToTmp($aCondition);
		$aPackData 	= array(
			'aListPDT'			=> $aListPDT,
			'nPage'				=> $nPage
		);
		$this->load->view('adjcost/wAdjcostDatatableBrowsePDT',$aPackData);
	}

	//เพิ่มข้อมูลลงในตาราง Tmp
	public function FSvCAJCInsPDTToTmp(){
		$tTypepage 		= $this->input->post('tTypepage');
		$tCode			= $this->input->post('tCode');
		$aData			= $this->input->post('aData');
		if($aData !== null){
			$aResult = explode(",",$aData);
			$nSeq = 1;
			for($i=0; $i<count($aResult); $i++){
				$aIns = array(
					'FTBchCode'		=> '',
					'FNXpdSeq'		=> $nSeq,
					'FTXphDocNo'	=> $tCode,
					'FTPdtCode'		=> $aResult[$i],
					'FTXpdSplCode'	=> '',
					'FCXpdCost'		=> '0.00',
					'FTXpdDisCost'	=> '0.00',
					'FDCreateOn'	=> date('Y-m-d H:i:s'),
					'FTCreateBy'	=> $this->session->userdata('tSesUsercode'),
					'FTWorkerID'	=> $this->session->userdata('tSesUsercode')
				);

				$this->mAdjcost->FSaMAJCInsertPDTToTmp($aIns);
			}
		}
		
	}

	//ลบข้อมูลในตาราง Tmp
	public function FSvCAJCDeletePDTInTmp(){
		$tPDTCode 	= $this->input->post('tPdtCode');
		$tCode 		= $this->input->post('tCode');
		$tWorkerID 	= $this->session->userdata('tSesUsercode');
		$aDelete 	= array(
			'FTXphDocNo' 	=> $tCode,
			'FTPdtCode'		=> $tPDTCode,
			'FTWorkerID'	=> $tWorkerID
		);
		$this->mAdjcost->FSaMAJCDeletePDTInTmp($aDelete);
	}

	//แก้ไขจำนวนในตาราง Tmp
	public function FSvCAJCUpdateInlinePDTInTmp(){
		$tPDTCode 		= $this->input->post('tPdtCode');
		$tCode 			= $this->input->post('tCode');
		$tValueUpdate	= $this->input->post('tValueUpdate'); 
		$tWorkerID 		= $this->session->userdata('tSesUsercode');
		$aSet 		= array(
			'FCXpdCost'		=> $tValueUpdate,
			'FTXpdDisCost' 	=> 'wait'
		);
		$aWhere 	= array(
			'FTBchCode'		=> $this->session->userdata('tSesBCHCode'),
			'FTXphDocNo' 	=> $tCode,
			'FTPdtCode'		=> $tPDTCode,
			'FTWorkerID'	=> $tWorkerID
		);
		$this->mAdjcost->FSaMAJCUpdatePDTInTmp($aSet,$aWhere);
	}

	//เอาไฟล์เข้า Tmp
	public function FSxCAJCCallpageUplodeFile(){
		$aPackData 	= $this->input->post('aPackdata');
		$tCode 		= $this->input->post('tCode');

		if(isset($aPackData['Adjustment'])){
			// echo 'Correct';
		}else{
			echo 'Fail';
			exit;
		}

		$nPackData 	= count($aPackData['Adjustment']);
		$aResult   	= $aPackData['Adjustment'];
		for($i=1; $i<$nPackData; $i++){

			if(isset($aResult[$i][0])){
				$aCheck = array(
					'FTXphDocNo'	=> $tCode,
					'FTWorkerID'	=> $this->session->userdata('tSesUsercode'),
					'FTPdtCode' 	=> (isset($aResult[$i][0])) ? $aResult[$i][0] : '',
					'FCXpdCost'		=> 'wait',
					'FTXpdDisCost'	=> 'wait',
					'FTXpdSplCode'	=> 'wait'
				);
				$aCheckDuplicate = $this->mAdjcost->FSaMAJCCheckDataDuplicate($aCheck);
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
						$this->mAdjcost->FSaMAJCImportExcelInsert($aIns);
					}
				}
			}
		}
	}

	//อีเว้นท์เพิ่มข้อมูล
	public function FSwCAJCEventInsert(){
		$aLastCode 	= $this->mAdjcost->FSaMAJCGetLastDocumentAdjCode();
		if($aLastCode['rtCode'] == 800){
			$tFormatCode = 'AJC00001';
		}else{
			$nLastCode 		= $aLastCode['raItems'][0]['FTXphDocNo'];
			$aExplode		= explode("AJC",$nLastCode);
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

			$tFormatCode = 'AJC'.str_pad($nNumber,strlen($tFormat)+1,$tFormat,STR_PAD_LEFT);
		}

		$aInsertHD = array(
			'FTBchCode'		=> $this->session->userdata('tSesBCHCode'),
			'FTXphDocNo'	=> $tFormatCode,
			'FDXphDocDate'	=> date('Y-m-d H:i:s'),
			'FTXphDocTime'	=> date('H:i:s'),
			'FDXphDStart'	=> 'wait',
			'FTXphStaDoc'	=> 1,
			'FTXphStaApv'	=> null,
			'FTUsrCode'		=> $this->session->userdata('tSesUsercode'),
			'FTXphRmk'		=> $this->input->post('oetAJCReason'),
			'FDCreateOn'	=> date('Y-m-d H:i:s'),
			'FTCreateBy'	=> $this->session->userdata('tSesUsercode'),
		);

		//เพิ่มข้อมูลลง HD
		$this->mAdjcost->FSxMAJCInsertHD($aInsertHD);

		//เพิ่มข้อมูลลง DT
		$this->mAdjcost->FSxMAJCInsertDT($tFormatCode);

		//ลบข้อมูลใน Tmp หลังจาก เพิ่มลงใน DT แล้ว
		$this->mAdjcost->FSxMAJCDeleteTmpAfterInsDT('');

		$aReturn = array(
			'tStatus' 			=> 'pass_insert',
			'tDocuementnumber'	=> $tFormatCode
		);
		echo json_encode($aReturn);
	}

	//อีเว้นท์แก้ไข
	public function FSxCAJCEventEdit(){
		try{
			$tFormatCode = $this->input->post('ohdDocumentNumber');
			$aSetUpdate  = array(
				'FTPriGrpID'	=> $this->input->post('oetAJCPriGrp'),
				'FTXphRmk'		=> $this->input->post('oetAJCReason'),
				'FDUpdateOn'	=> date('Y-m-d H:i:s'),
				'FTUpdateBy'	=> $this->session->userdata('tSesUsercode')
			);

			$aWhereUpdate = array(
				'FTXphDocNo'	=> $tFormatCode
			);
			$this->mAdjcost->FSxMGRPUpdate($aSetUpdate,$aWhereUpdate);
			
			//ลบข้อมูลใน DT
			$this->mAdjcost->FSxMAJCDeleteDT($tFormatCode);

			//เพิ่มข้อมูลลง DT
			$this->mAdjcost->FSxMAJCInsertDT($tFormatCode);

			//ลบข้อมูลใน Tmp หลังจาก เพิ่มลงใน DT แล้ว
			$this->mAdjcost->FSxMAJCDeleteTmpAfterInsDT($tFormatCode);

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
	public function FSxCAJCEventDelete(){
		$tCode = $this->input->post('ptCode');
		$this->mAdjcost->FSaMAJCDelete($tCode);
	}

	//ยกเลิกเอกสาร
	public function FSxCAJCCancleDocument(){
		$tCode = $this->input->post('tCode');
		$this->mAdjcost->FSaMAJCCancleDocument($tCode);
	}

	//อนุมัติเอกสาร
	public function FSxCAJCAproveDocument(){
		$tCode = $this->input->post('tCode');
		$this->mAdjcost->FSaMAJCAproveDocument($tCode);
	}

}
