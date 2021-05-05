<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cProduct extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('product/product/mProduct');
	}

	public function index(){
		$aFilter = array(
			'aFilter_Brand'         => $this->mProduct->FSaMPDTGetData_Filter('TCNMPdtBrand'),
			'aFilter_Color'         => $this->mProduct->FSaMPDTGetData_Filter('TCNMPdtColor'),
			'aFilter_Group'         => $this->mProduct->FSaMPDTGetData_Filter('TCNMPdtGrp'),
			'aFilter_Modal'         => $this->mProduct->FSaMPDTGetData_Filter('TCNMPdtModal'),
			'aFilter_Size'         	=> $this->mProduct->FSaMPDTGetData_Filter('TCNMPdtSize'),
			'aFilter_Type'         	=> $this->mProduct->FSaMPDTGetData_Filter('TCNMPdtType'),
			'aFilter_Unit'         	=> $this->mProduct->FSaMPDTGetData_Filter('TCNMPdtUnit'),
			'aFilter_Spl'         	=> $this->mProduct->FSaMPDTGetData_Filter('TCNMSpl')
		);
		$this->load->view('product/product/wProductMain',$aFilter);
	}

	//โหลดข้อมูลสินค้า
	public function FSwCPDTLoadDatatable(){
		$nPage = $this->input->post('nPage');
		$aCondition = array(
			'nPage'         => $nPage,
			'nRow'          => 10,
			'tSearchAll'    => $this->input->post('tSearchAll'),
			'aFilterAdv'	=> $this->input->post('aFilterAdv')
		);

		$aList = $this->mProduct->FSaMPDTGetData($aCondition);
		$aPackData = array(
			'aList'					=> $aList,
			'nPage'					=> $nPage
		);
		$this->load->view('product/product/wProductDatatable',$aPackData);
	}

	//โหลดหน้าจอเพื่มสินค้า + แก้ไขสินค้า
	public function FSwCPDTCallPageInsertorEdit(){
		$tTypePage = $this->input->post('tTypepage');
		if($tTypePage == 'insert'){
			$aResult		= '';
			$nDiscountCost 	= '0';
			$nAddPri 		= 'x';
			$nCostAFDis 	= '0';
			$nPDTSetPrice 	= '0';
		}else if($tTypePage == 'edit'){
			$tCode 		= $this->input->post('tCode');
			$aResult 	= $this->mProduct->FSaMPDTGetDataBYID($tCode);
			$aPackData = array(
				'PDTCode' 		=> $tCode,
				'PriceGroup' 	=> $this->session->userdata('tSesPriceGroup')
			);

			//หาส่วนลดต้นทุนเอาไปโชว์หน้าเว็บ
			$aAddPri 		= $this->mProduct->FSaMPDTFindProductCostPrice($aPackData);
			if($aAddPri['rtCode'] == 800){
				$nDiscountCost = '0';
			}else{
				$nDiscountCost = $aAddPri['tResult'][0]['FTXpdDisCost'];
			}

			//ขายบวกเพิ่มจากต้นทุน (%)
			if($aAddPri['rtCode'] == 800){
				$nCostAFDis 	= '0';
				$nPDTSetPrice 	= '0';
			}else{
				$nCostAFDis 	= $aAddPri['tResult'][0]['FCPdtCostAFDis'];
				$nPDTSetPrice 	= $aAddPri['tResult'][0]['FCPdtSetPrice'];
			}

			//ขายบวกเพิ่มจากต้นทุน (%)
			$aAddPri = $this->mProduct->FSaMPDTFindAddPri($tCode);
			if($aAddPri['rtCode'] == 800){
				$nAddPri = 'x';
			}else{
				$nAddPri = $aAddPri['tResult'][0]['FCXpdAddPri'];
			}
		}

		$aPackData = array(
			'aFilter_Brand'     => $this->mProduct->FSaMPDTGetData_Filter('TCNMPdtBrand'),
			'aFilter_Color'     => $this->mProduct->FSaMPDTGetData_Filter('TCNMPdtColor'),
			'aFilter_Group'     => $this->mProduct->FSaMPDTGetData_Filter('TCNMPdtGrp'),
			'aFilter_Modal'     => $this->mProduct->FSaMPDTGetData_Filter('TCNMPdtModal'),
			'aFilter_Size'      => $this->mProduct->FSaMPDTGetData_Filter('TCNMPdtSize'),
			'aFilter_Type'      => $this->mProduct->FSaMPDTGetData_Filter('TCNMPdtType'),
			'aFilter_Unit'      => $this->mProduct->FSaMPDTGetData_Filter('TCNMPdtUnit'),
			'aFilter_Spl'       => $this->mProduct->FSaMPDTGetData_Filter('TCNMSpl'),
			'tTypePage' 		=> $tTypePage,
			'aResult'			=> $aResult,
			'nDiscountCost'		=> $nDiscountCost,
			'nAddPri'			=> $nAddPri,
			'nCostAFDis'		=> $nCostAFDis,
			'nPDTSetPrice'		=> $nPDTSetPrice,
		);
		$this->load->view('product/product/wProductAdd',$aPackData);
	}

	//อีเว้นท์เพิ่มข้อมูล
	public function FSwCPDTEventInsert(){
		$aCheckDuplicate 	= $this->mProduct->FSaMPDTCheckCodeDuplicate($this->input->post('oetPDTCode'),'');
		if($aCheckDuplicate['rtCode'] == 1){
			echo 'Duplicate';
		}else{
			$aInsertPDT = array(
				'FTPdtCode'			=> $this->input->post('oetPDTCode'),
				'FTBchCode'			=> '-',
				'FTPdtName'			=> $this->input->post('oetPDTName'),
				'FTPdtNameOth'		=> $this->input->post('oetPDTNameOther'),
				'FTPdtDesc'			=> $this->input->post('oetPDTDetail'),
				'FTPunCode'			=> $this->input->post('oetPDTPunCode'),
				'FTPgpCode'			=> $this->input->post('oetPDTGroup'),
				'FTPtyCode'			=> $this->input->post('oetPDTType'),
				'FTPbnCode'			=> $this->input->post('oetPDTBrand'),
				'FTPzeCode'			=> $this->input->post('oetPDTSize'),
				'FTPClrCode'		=> $this->input->post('oetPDTColor'),
				'FTSplCode'			=> $this->input->post('oetPDTSPL'),
				'FTMolCode'			=> $this->input->post('oetPDTModal'),
				'FCPdtCostStd'		=> $this->input->post('oetPDTCost'),
				'FTPdtCostDis'		=> ($this->input->post('oetPDTCostPercent') == '' ) ? 0 : $this->input->post('oetPDTCostPercent'),
				'FCPdtSalPrice'		=> 0,
				'FTPdtImage'		=> $this->input->post('oetImgInsertorEditproducts'),
				'FTPdtReason'		=> $this->input->post('oetPDTReason'),
				'FTPdtStatus'		=> ($this->input->post('ocmPDTStaUse') == 'on') ? 1 : 0,
				'FTPdtBestsell'		=> ($this->input->post('ocmPDTStaBestsell') == 'on') ? 1 : 0,
				'FTPdtStaEditName'	=> ($this->input->post('ocmPDTStaEditname') == 'on') ? 1 : 0,
				'FDCreateOn'		=> date('Y-m-d H:i:s'),
				'FTCreateBy'		=> $this->session->userdata('tSesUsercode'),
				'FTUpdateBy'		=> $this->session->userdata('tSesUsercode'),
				'FDUpdateOn'		=> date('Y-m-d H:i:s')
			);
			$this->mProduct->FSxMPDTInsert($aInsertPDT);

			//Call Helper เพื่อให้เกิด cost ที่เเท้จริง
			$paData = array(
				"tPdtCode"		=> $this->input->post('oetPDTCode'),
				"dDateActive"	=> date('Y-m-d H:i:s'),
				"tDocno"		=> ''
			);
			FCNaHPDCAdjPdtCost($paData);

			echo 'pass_insert';
		}
	}

	//ลบ
	public function FSxCPDTEventDelete(){
		$tCode = $this->input->post('ptCode');
		$this->mProduct->FSaMPDTDelete($tCode);
	}

	//อีเว้นท์แก้ไข
	public function FSxCPDTEventEdit(){
		try{
			$aCheckDuplicate 	= $this->mProduct->FSaMPDTCheckCodeDuplicate($this->input->post('oetPDTCode'),$this->input->post('ohdProductCode'));
			if($aCheckDuplicate['rtCode'] == 1){
				echo 'Duplicate';
			}else{
				$aSetUpdate = array(
					'FTBchCode'			=> '', 
					'FTPdtName'			=> $this->input->post('oetPDTName'),
					'FTPdtNameOth'		=> $this->input->post('oetPDTNameOther'),
					'FTPdtDesc'			=> $this->input->post('oetPDTDetail'),
					'FTPunCode'			=> $this->input->post('oetPDTPunCode'),
					'FTPgpCode'			=> $this->input->post('oetPDTGroup'),
					'FTPtyCode'			=> $this->input->post('oetPDTType'),
					'FTPbnCode'			=> $this->input->post('oetPDTBrand'),
					'FTPzeCode'			=> $this->input->post('oetPDTSize'),
					'FTPClrCode'		=> $this->input->post('oetPDTColor'),
					'FTSplCode'			=> $this->input->post('oetPDTSPL'),
					'FTMolCode'			=> $this->input->post('oetPDTModal'),
					'FCPdtCostStd'		=> $this->input->post('oetPDTCost'),
					'FTPdtCostDis'		=> ($this->input->post('oetPDTCostPercent') == '' ) ? 0 : $this->input->post('oetPDTCostPercent'),
					'FTPdtImage'		=> $this->input->post('oetImgInsertorEditproducts'),
					'FTPdtReason'		=> $this->input->post('oetPDTReason'),
					'FTPdtStatus'		=> ($this->input->post('ocmPDTStaUse') == 'on') ? 1 : 0,
					'FTPdtBestsell'		=> ($this->input->post('ocmPDTStaBestsell') == 'on') ? 1 : 0,
					'FTPdtStaEditName'	=> ($this->input->post('ocmPDTStaEditname') == 'on') ? 1 : 0,
					'FTUpdateBy'		=> $this->session->userdata('tSesUsercode'),
					'FDUpdateOn'		=> date('Y-m-d H:i:s')
				);
				$aWhereUpdate = array(
					'FTPdtCode'			=> $this->input->post('ohdProductCode')
				);
				$this->mProduct->FSxMPDTUpdate($aSetUpdate,$aWhereUpdate);

				//Call Helper เพื่อให้เกิด cost ที่เเท้จริง
				$paData = array(
					"tPdtCode"		=> $this->input->post('ohdProductCode'),
					"dDateActive"	=> date('Y-m-d H:i:s'),
					"tDocno"		=> '',
					'tCostDis'		=> ($this->input->post('oetPDTCostPercent') == '' ) ? 0 : $this->input->post('oetPDTCostPercent')
				);
				FCNaHPDCAdjPdtCost($paData);

				$paDataUpdate = array(
					"tPdtCode"	=> $this->input->post('ohdProductCode'),
					"nCostStd"	=> $this->input->post('oetPDTCost')
				);
				FSSetPdtCostStdChang($paDataUpdate);

				echo 'pass_update';
			}
		}catch(Exception $Error){
            echo $Error;
        }
	}

	//*************************************************************************************** */

	//ไปหน้าของการอัพโหลดรูปภาพ Tmp (การนำเข้ารูปภาพ)
	public function FSxCPDTCallpageUplodeImage(){
		$aList 		= $this->mProduct->FSxMPDTImportImgPDTSelect();
		$aPackData 	= array('aList' => $aList);
		$this->load->view('product/product/Import/wDatatableImg',$aPackData);
	}

	//ลบข้อมูลรูปภาพใน Tmp (การนำเข้ารูปภาพ)
	public function FSxCPDTEventDeleteImgInTmp(){
		//ลบข้อมูลในตาราง Tmp
		$this->mProduct->FSxMPDTImportImgPDTDelete();

		//ลบข้อมูลในโฟลเดอร์ Tmp
		array_map('unlink', array_filter((array) glob("./application/assets/Tmp/TmpImg_user".$this->session->userdata('tSesUsercode')."/*")));
	}

	//ยินยันการนำเข้ารูปภาพ Tmp (การนำเข้ารูปภาพ)
	public function FSxCPDTEventAproveImgInTmp(){
		$aData 		= $this->input->post('aData');
		$nCountData = count($aData);
		if($nCountData != 0){
			for($i=0; $i<$nCountData; $i++){
				$tFileName 		= $aData[$i]['tPathImg'];
				$aExplode		= explode('TmpImg_user'.$this->session->userdata('tSesUsercode').'/',$tFileName);
	
				//ย้ายไฟล์
				$tPathFileFrom	= './application/assets/Tmp/TmpImg_user'.$this->session->userdata('tSesUsercode').'/'.$aExplode[1];
				$tPathFileTo	= './application/assets/images/products/'.$aExplode[1];
				rename($tPathFileFrom,$tPathFileTo);
	
				//Update ฐานข้อมูล
				$aWhere = array(
					'FTPdtCode'			=> $aData[$i]['nPDTCode'],
				);
	
				$aSet = array(
					'FTPdtImage' 		=> $aExplode[1],
					'FTUpdateBy'		=> $this->session->userdata('tSesUsercode'),
					'FDUpdateOn'		=> date('Y-m-d H:i:s')
				);
				$this->mProduct->FSxMPDTImportImgPDTUpdate($aSet,$aWhere);
			}
		}

		//ลบข้อมูลในฐานข้อมูล และ รูปภาพใน Tmp
		$this->FSxCPDTEventDeleteImgInTmp();
	}

	//*************************************************************************************** */

	//นำข้อมูลใน Excel เข้า (Excel)
	public function FSxCPDTCallpageUplodeFile(){
		$aPackData = $this->input->post('aPackdata');

		if(isset($aPackData['Product'])){
			// echo 'Correct';
		}else{
			echo 'Fail';
			exit;
		}

		$nPackData = count($aPackData['Product']);
		$aResult   = $aPackData['Product'];

		//ลบข้อมูลก่อน
		$aDelete = array(
			'FTWorkerID' => $this->session->userdata('tSesLogID')
		);
		$this->mProduct->FSxMPDTImportExcelDelete($aDelete);

		for($i=1; $i<$nPackData; $i++){

			//Insert ข้อมูล
			if($aResult[$i][0] != '' || $aResult[$i][0] != null){
				//รหัสสินค้าไม่เป็นค่าว่าง
				$aCheckDuplicate = $this->mProduct->FSxMPDTCheckPDTInTmp($aResult[$i][0]);
				if($aCheckDuplicate['rtCode'] == 1){
					//ข้อมูลซ้ำ
				}else{
					$aPdtInfo = array(
						"nStdCost" 		=> (isset($aResult[$i][5])) ? $aResult[$i][5] : '0',
						"tStepDisCost"	=> (isset($aResult[$i][6])) ? $aResult[$i][6] : '0'
					);
					$nCost = FCNnHCOSCalCost($aPdtInfo);
	
					//สินค้าขายดี
					if(isset($aResult[$i][12]) && $aResult[$i][12] == 1){
						$tBestSell = 1;
					}else{
						$tBestSell = 0;
					}

					if(isset($aResult[$i][0])){
						$aIns = array(
							'FTPdtCode' 	=> (isset($aResult[$i][0])) ? $aResult[$i][0] : '',
							'FTPdtName' 	=> (isset($aResult[$i][1])) ? $aResult[$i][1] : '',
							'FTPgpCode' 	=> (isset($aResult[$i][2])) ? $aResult[$i][2] : '',
							'FTPtyCode' 	=> (isset($aResult[$i][3])) ? $aResult[$i][3] : '',
							'FTSplCode' 	=> (isset($aResult[$i][4])) ? $aResult[$i][4] : '',
							'FCPdtCostStd' 	=> (isset($aResult[$i][5])) ? $aResult[$i][5] : '',
							'FTPdtCostDis' 	=> (isset($aResult[$i][6])) ? $aResult[$i][6] : '',
							'FTPunCode'		=> (isset($aResult[$i][7])) ? $aResult[$i][7] : '',
							'FTPbnCode'		=> (isset($aResult[$i][8])) ? $aResult[$i][8] : '',
							'FTPClrCode'	=> (isset($aResult[$i][9])) ? $aResult[$i][9] : '',
							'FTMolCode'		=> (isset($aResult[$i][10])) ? $aResult[$i][10] : '',
							'FTPzeCode'		=> (isset($aResult[$i][11])) ? $aResult[$i][11] : '',
							'FTPdtBestsell'	=> $tBestSell,
							'FTWorkerID'	=> $this->session->userdata('tSesLogID'),
							'FCCostAfDis'	=> $nCost
						);
					}
	
					//Insert ข้อมูล
					if($aIns['FTPdtCode'] != '' || $aIns['FTPdtCode'] != null){
						$this->mProduct->FSxMPDTImportExcelInsert($aIns);
					}
				}
			}else{
				//รหัสสินค้าเป้นค่าว่าง
			}
		}

		//Get ข้อมูล
		$aList 		= $this->mProduct->FSxMPDTImportExcelSelect();
		$aPackData 	= array('aList' => $aList);
		$this->load->view('product/product/Import/wDatatableData',$aPackData);
	}

	//ยินยันการนำข้อมูลใน Excel เข้า (Excel)
	public function FSxCPDTEventAproveDataInTmp(){
		$aDataFail 		= $this->input->post('aPDTFailExcel');
		$nCountData 	= count($aDataFail);
		$tNotInItem		= '';
		if($nCountData != 0){
			for($i=0; $i<$nCountData; $i++){
				$tNotInItem .= "'".$aDataFail[$i]['nPDTCode']."',";
				if($i == ($nCountData - 1)){
					$tNotInItem = substr($tNotInItem,0,-1);
				}
			}
		}

		//ย้ายข้อมูล
		$aIns = array(
			'FTWorkerID' =>  $this->session->userdata('tSesLogID')
		);
		$this->mProduct->FSxMPDTImportExcelMoveTmpToHD($aIns,$tNotInItem);

		//ลบข้อมูลในฐานข้อมูล Temp
		$this->mProduct->FSxMPDTImportExcelDeleteTmp();
	}

	//เลือก option 
	public function FSwCPDTHTMLAttribute(){
		$nPage				= $this->input->post('nPage');
		$tName				= $this->input->post('tName');
		$tSearchAttribute	= $this->input->post('tSearchAttribute');

		$aCondition = array(
			'tName'				=> strtolower($tName),
			'nPage'         	=> $nPage,
			'nRow'          	=> 10,
			'tSearch'   		=> $tSearchAttribute
		);

		$aListItem 	= $this->mProduct->FSaMPDTAttrGetItem($aCondition);
		$aPackData 	= array(
			'tName'				=> strtolower($tName),
			'aListItem'			=> $aListItem,
			'nPage'				=> $nPage
		);

		$this->load->view('product/product/attribute/wAttribute',$aPackData);
	}

	//ลบข้อมูลใน Temp ตอนนำเข้าสินค้า
	public function FSxCPDTEventDeleteDataInTmp(){
		$tPDTCode 		= $this->input->post('tPDTCode');
		$aDeleteItem 	= array(
			'FTPdtCode' =>  $tPDTCode
		);
		$this->mProduct->FSxMPDTDeleteDataInTemp($aDeleteItem);
	}

	//ค้นหากลุ่มสินค้า จากการเลือกยี่ห้อ
	public function FSxCPDTEventSearchFromBrand(){
		$aData = $this->input->post('data');
		if(empty($aData)){
			$aRetrunBrand 	= $this->mProduct->FSaMPDTGetData_Filter_GroupOnly('');
		}else{
			$tBrandCode = '';
			for($i=0; $i<count($aData); $i++){
				$tBrandCode .= "'" . $aData[$i]['tValue'] ."'" . ',';
			}

			$tBrandCode 	= substr($tBrandCode,0,-1);
			$aRetrunBrand 	= $this->mProduct->FSaMPDTGetData_Filter_GroupOnly($tBrandCode);
		}

		echo json_encode($aRetrunBrand);
	}
}
