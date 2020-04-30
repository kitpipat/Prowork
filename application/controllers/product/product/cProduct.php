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
			$aResult	= '';
		}else if($tTypePage == 'edit'){
			$tCode 		= $this->input->post('tCode');
			$aResult 	= $this->mProduct->FSaMPDTGetDataBYID($tCode);
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
			'aResult'			=> $aResult
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
				'FCPdtSalPrice'		=> ($this->input->post('oetPDTPriceSellPercent') == '' ) ? 0 : $this->input->post('oetPDTPriceSellPercent'),
				'FTPdtImage'		=> $this->input->post('oetImgInsertorEditproducts'),
				'FTPdtReason'		=> $this->input->post('oetPDTReason'),
				'FTPdtStatus'		=> ($this->input->post('ocmPDTStaUse') == 'on') ? 1 : 0,
				'FDCreateOn'		=> date('Y-m-d H:i:s'),
				'FTCreateBy'		=> $this->session->userdata('tSesUsercode'),
				'FTUpdateBy'		=> $this->session->userdata('tSesUsercode'),
				'FDUpdateOn'		=> date('Y-m-d H:i:s')
			);
			$this->mProduct->FSxMPDTInsert($aInsertPDT);

			//Call Helper เพื่อให้เกิด cost ที่เเท้จริง
			$paData = array(
				"tPdtCode"		=> $this->input->post('oetPDTCode'),
				"dDateActive"	=> '',
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
					'FCPdtSalPrice'		=> ($this->input->post('oetPDTPriceSellPercent') == '' ) ? 0 : $this->input->post('oetPDTPriceSellPercent'),
					'FTPdtImage'		=> $this->input->post('oetImgInsertorEditproducts'),
					'FTPdtReason'		=> $this->input->post('oetPDTReason'),
					'FTPdtStatus'		=> ($this->input->post('ocmPDTStaUse') == 'on') ? 1 : 0,
					'FTUpdateBy'		=> $this->session->userdata('tSesUsercode'),
					'FDUpdateOn'		=> date('Y-m-d H:i:s')
				);
				$aWhereUpdate = array(
					'FTPdtCode'			=> $this->input->post('ohdProductCode')
				);
				$this->mProduct->FSxMPDTUpdate($aSetUpdate,$aWhereUpdate);

				//Call Helper เพื่อให้เกิด cost ที่เเท้จริง
				// $paData = array(
				// 	"tPdtCode"		=> $this->input->post('ohdProductCode'),
				// 	"dDateActive"	=> '',
				// 	"tDocno"		=> ''
				// );
				// FCNaHPDCAdjPdtCost($paData);

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
			'FTWorkerID' => $this->session->userdata('tSesUsercode')
		);
		$this->mProduct->FSxMPDTImportExcelDelete($aDelete);

		for($i=1; $i<$nPackData; $i++){

			if(isset($aResult[$i][0])){
				$aIns = array(
					'FTPdtCode' 	=> (isset($aResult[$i][0])) ? $aResult[$i][0] : '',
					'FTPdtName' 	=> (isset($aResult[$i][1])) ? $aResult[$i][1] : '',
					'FTPgpCode' 	=> (isset($aResult[$i][2])) ? $aResult[$i][2] : '',
					'FTPtyCode' 	=> (isset($aResult[$i][3])) ? $aResult[$i][3] : '',
					'FTSplCode' 	=> (isset($aResult[$i][4])) ? $aResult[$i][4] : '',
					'FCPdtCostStd' 	=> (isset($aResult[$i][5])) ? $aResult[$i][5] : '',
					'FTPdtCostDis' 	=> (isset($aResult[$i][6])) ? $aResult[$i][6] : '',
					'FTWorkerID'	=> $this->session->userdata('tSesUsercode')
				);
			}

			//Insert ข้อมูล
			if($aIns['FTPdtCode'] != '' || $aIns['FTPdtCode'] != null){
				$this->mProduct->FSxMPDTImportExcelInsert($aIns);
			}
		}

		//Get ข้อมูล
		$aList 		= $this->mProduct->FSxMPDTImportExcelSelect();
		$aPackData 	= array('aList' => $aList);
		$this->load->view('product/product/Import/wDatatableData',$aPackData);
	}

	//ยินยันการนำข้อมูลใน Excel เข้า (Excel)
	public function FSxCPDTEventAproveDataInTmp(){
		$aData 		= $this->input->post('aData');
		$nCountData = count($aData);
		if($nCountData != 0){
			$this->mProduct->FSxMPDTImportExcelMoveTmpToHD();
			for($i=0; $i<$nCountData; $i++){

				//Insert ฐานข้อมูล
				// $aIns = array(
				// 	'FTPdtCode'			=> $aData[$i]['nPDTCode'],
				// 	'FTWorkerID'		=> $this->session->userdata('tSesUsercode')
				// );
				// $this->mProduct->FSxMPDTImportExcelMoveTmpToHD();

				//Call Helper เพื่อให้เกิด cost ที่เเท้จริง
				$paData = array(
					"tPdtCode"		=> $aData[$i]['nPDTCode'],
					"dDateActive"	=> '',
					"tDocno"		=> ''
				);
				FCNaHPDCAdjPdtCost($paData);
			}
		}

		//ลบข้อมูลในฐานข้อมูล
		$this->mProduct->FSxMPDTImportExcelDeleteTmp();
	}
}
