<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cGroupproduct extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('product/groupproduct/mGroupproduct');
		$this->load->model('product/product/mProduct');
	}

	public function index(){
		$this->load->view('product/groupproduct/wGroupproductMain');
	}

	//โหลดข้อมูลกลุ่มสินค้า
	public function FSwCGRPLoadDatatable(){
		$nPage = $this->input->post('nPage');
		$aCondition = array(
			'nPage'         => $nPage,
			'nRow'          => 10,
			'tSearchAll'    => $this->input->post('tSearchAll')
		);

		$aGroupList = $this->mGroupproduct->FSaMGRPGetData($aCondition);
		$aPackData = array(
			'aGroupList'		=> $aGroupList,
			'nPage'				=> $nPage
		);
		$this->load->view('product/groupproduct/wGroupproductDatatable',$aPackData);
	}

	//โหลดหน้าจอเพื่มกลุ่มสินค้า + แก้ไขกลุ่มสินค้า
	public function FSwCGRPCallPageInsertorEdit(){
		$tTypePage = $this->input->post('tTypepage');
		if($tTypePage == 'insert'){
			$aResult	= '';
		}else if($tTypePage == 'edit'){
			$tCode 		= $this->input->post('tCode');
			$aResult 	= $this->mGroupproduct->FSaMGRPGetDataGroupProductBYID($tCode);
		}

		$aPackData = array(
			'tTypePage' 		=> $tTypePage,
			'aResult'			=> $aResult
		);
		$this->load->view('product/groupproduct/wGroupproductAdd',$aPackData);
	}

	//อีเว้นท์เพิ่มข้อมูล
	public function FSwCGRPEventInsert(){
		//เช็ครหัสซ้ำก่อน
		$tFormatCode 		= $this->input->post('oetCodeGRPName');
		$aStatusCheckCode 	= $this->mProduct->FSaMPDTCheckCode('FTPgpCode','TCNMPdtGrp',$tFormatCode);
		if($aStatusCheckCode['rtCode'] == 800){
			$aInsertGroupPDT = array(
				'FTPgpCode'			=> $tFormatCode,
				'FTPgpName'			=> $this->input->post('oetGRPName'),
				'FTPbnCode'			=> $this->input->post('oetPDTBrandInGroup'),
				'FDCreateOn'		=> date('Y-m-d H:i:s'),
				'FTCreateBy'		=> $this->session->userdata('tSesUsercode')
			);
			$this->mGroupproduct->FSxMGRPInsert($aInsertGroupPDT);
			echo 'pass_insert';
		}else{
			echo 'duplicate';
		}
	}

	//ลบกลุ่มสินค้า
	public function FSxCGRPEventDelete(){
		$tCode = $this->input->post('ptCode');
		$this->mGroupproduct->FSaMGRPDelete($tCode);
	}

	//อีเว้นท์แก้ไข
	public function FSxCGRPEventEdit(){
		try{
			$aSetUpdate = array(
				'FTPgpName'			=> $this->input->post('oetGRPName'),
				'FTUpdateBy'		=> $this->session->userdata('tSesUsercode'),
				'FTPbnCode'			=> $this->input->post('oetPDTBrandInGroup'),
				'FDUpdateOn'		=> date('Y-m-d H:i:s')
			);
			$aWhereUpdate = array(
				'FTPgpCode'			=> $this->input->post('ohdGroupProductCode')
			);
			$this->mGroupproduct->FSxMGRPUpdate($aSetUpdate,$aWhereUpdate);
			echo 'pass_update';
		}catch(Exception $Error){
            echo $Error;
        }
	}

	//โหลดหน้าจอยี่ห้อในกลุ่ม
	public function FSxCGRPLoadBrandInGroup(){
		$tGroupCode = $this->input->post('tGroupCode');
		$aBrandList = $this->mGroupproduct->FSaMGRPGetDataBrandInGroup($tGroupCode);
		$aPackData = array(
			'aBrandList'		=> $aBrandList
		);
		$this->load->view('product/groupproduct/BrandInGroup/wBrandInGroupDatatable',$aPackData);
	}

	//เลือกยี่ห้อ 
	public function FSwCPDTHTMLAttributeBrandInGroup(){
		$nPage				= $this->input->post('nPage');
		$tName				= $this->input->post('tName');
		$tSearchAttribute	= $this->input->post('tSearchAttribute');
		$tGroupCode			= $this->input->post('tGroupCode');

		$aCondition = array(
			'tName'				=> strtolower($tName),
			'nPage'         	=> $nPage,
			'nRow'          	=> 10,
			'tSearch'   		=> $tSearchAttribute,
			'tGroupCode'		=> $tGroupCode,
		);

		$aListItem 	= $this->mGroupproduct->FSaMPDTAttrGetItemBrandInGroup($aCondition);
		$aPackData 	= array(
			'tName'				=> strtolower($tName),
			'aListItem'			=> $aListItem,
			'nPage'				=> $nPage
		);

		$this->load->view('product/product/attribute/wAttribute',$aPackData);
	}

	//เพิ่มข้อมูล หน้าจอยี่ในกลุ่ม
	public function FSxCGRPInsertBrandInGroup(){
		$tvaluecode = $this->input->post('tvaluecode');
		$tGroupCode = $this->input->post('tGroupCode');
		$tTypePage	= $this->input->post('tTypePage');
		$nCodePK 	= $this->input->post('nCodePK');	

		if($tTypePage == 'add'){
			$aInsert 		= array(
				'FTPgpCode'			=> $tGroupCode,
				'FTPbnCode'			=> $tvaluecode
			);
			$this->mGroupproduct->FSxMGRPInsertBrandInGroup($aInsert);
		}else if($tTypePage == 'edit'){
			$aSetUpdate 	= array(
				'FTPbnCode'			=> $tvaluecode
			);
			$aWhereUpdate 	= array(
				'FTTrnCode'			=> $nCodePK,
				'FTPgpCode'			=> $tGroupCode,
			);
			$this->mGroupproduct->FSxMGRPUpdateBrandInGroup($aSetUpdate,$aWhereUpdate);
		}
	}

	//ลบกลุ่มสินค้า
	public function FSxCGRPEventDeleteBrandInGroup(){
		$tCode = $this->input->post('ptCode');
		$this->mGroupproduct->FSaMGRPDeleteBrandInGroup($tCode);
	}

}
