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
			'tSearchAll'    => $this->input->post('tSearchAll')
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
		$aLastCode 	= $this->mProduct->FSaMPDTGetLastPDTcode();
		if($aLastCode['rtCode'] == 800){
			$tFormatCode = 'P000001';
		}else{
			$nLastCode 		= $aLastCode['raItems'][0]['FTCstCode'];
			$aCode			= explode('P',$nLastCode);
			$nNumber		= $aCode[1] + 1;
			$nCountNumber	= count($nNumber);
			if($nCountNumber == 1){
				$tFormat 		= '00000';
			}else if($nCountNumber == 2){
				$tFormat 		= '0000';
			}else if($nCountNumber == 3){
				$tFormat 		= '000';
			}else if($nCountNumber == 1){
				$tFormat 		= '00';
			}else{
				$tFormat 		= '0';
			}

			$tFormatCode = 'P' . str_pad($nNumber,strlen($tFormat)+1,$tFormat,STR_PAD_LEFT);
		}

		$aInsertPDTePDT = array(
			'FTPdtCode'			=> $tFormatCode,
			'FTBchCode'			=> '',
			'FTPdtName'			=> $this->input->post('ptCode'),
			'FTPdtNameOth'		=> $this->input->post('ptCode'),
			'FTPdtDesc'			=> $this->input->post('ptCode'),
			'FTPunCode'			=> $this->input->post('ptCode'),
			'FTPgpCode'			=> $this->input->post('ptCode'),
			'FTPtyCode'			=> $this->input->post('ptCode'),
			'FTPbnCode'			=> $this->input->post('ptCode'),
			'FTPzeCode'			=> $this->input->post('ptCode'),
			'FTPClrCode'		=> $this->input->post('ptCode'),
			'FTSplCode'			=> $this->input->post('ptCode'),
			'FTMolCode'			=> $this->input->post('ptCode'),
			'FCPdtCostStd'		=> $this->input->post('ptCode'),
			'FTPdtCostDis'		=> $this->input->post('ptCode'),
			'FCPdtSalPrice'		=> $this->input->post('ptCode'),
			'FTPdtImage'		=> $this->input->post('ptCode'),
			'FTPdtStatus'		=> $this->input->post('ptCode'),
			'FDCreateOn'		=> date('Y-m-d H:i:s'),
			'FTCreateBy'		=> $this->session->userdata('tSesUsercode')
		);
		$this->mProduct->FSxMPDTInsert($aInsertPDTePDT);
		echo 'pass_insert';
	}

	//ลบ
	public function FSxCPDTEventDelete(){
		$tCode = $this->input->post('FTPdtCode');
		$this->mProduct->FSaMPDTDelete($tCode);
	}

	//อีเว้นท์แก้ไข
	public function FSxCPDTEventEdit(){
		try{
			$aSetUpdate = array(
				'FTBchCode'			=> '',
				'FTPdtName'			=> $this->input->post('ptCode'),
				'FTPdtNameOth'		=> $this->input->post('ptCode'),
				'FTPdtDesc'			=> $this->input->post('ptCode'),
				'FTPunCode'			=> $this->input->post('ptCode'),
				'FTPgpCode'			=> $this->input->post('ptCode'),
				'FTPtyCode'			=> $this->input->post('ptCode'),
				'FTPbnCode'			=> $this->input->post('ptCode'),
				'FTPzeCode'			=> $this->input->post('ptCode'),
				'FTPClrCode'		=> $this->input->post('ptCode'),
				'FTSplCode'			=> $this->input->post('ptCode'),
				'FTMolCode'			=> $this->input->post('ptCode'),
				'FCPdtCostStd'		=> $this->input->post('ptCode'),
				'FTPdtCostDis'		=> $this->input->post('ptCode'),
				'FCPdtSalPrice'		=> $this->input->post('ptCode'),
				'FTPdtImage'		=> $this->input->post('ptCode'),
				'FTPdtStatus'		=> $this->input->post('ptCode'),
				'FTUpdateBy'		=> $this->session->userdata('tSesUsercode'),
				'FDUpdateOn'		=> date('Y-m-d H:i:s')
			);
			$aWhereUpdate = array(
				'FTPdtCode'			=> $this->input->post('xxxx')
			);
			$this->mProduct->FSxMPDTUpdate($aSetUpdate,$aWhereUpdate);
			echo 'pass_update';
		}catch(Exception $Error){
            echo $Error;
        }
	}


}
