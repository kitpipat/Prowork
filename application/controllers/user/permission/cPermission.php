<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cPermission extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('user/permission/mPermission');
	}

	public function index(){
		$this->load->view('user/permission/wPermissionMain');
	}

	//โหลดข้อมูลกลุ่มสิทธิ์
	public function FSwCPERLoadDatatable(){
		$nPage = $this->input->post('nPage');
		$aCondition = array(
			'nPage'         => $nPage,
			'nRow'          => 10,
			'tSearchAll'    => $this->input->post('tSearchAll')
		);

		$aPermissionList = $this->mPermission->FSaMPERGetData($aCondition);
		$aPackData = array(
			'aPermissionList'	=> $aPermissionList,
			'nPage'				=> $nPage
		);
		$this->load->view('user/permission/wPermissionDatatable',$aPackData);
	}

	//โหลดหน้าจอเพื่มผู้ใช้ + แก้ไขผู้ใช้
	public function FSwCPERCallPageInsertorEdit(){
		$tTypePage = $this->input->post('tTypepage');
		if($tTypePage == 'insert'){
			$aResult	= '';
		}else if($tTypePage == 'edit'){
			$tCode 		= $this->input->post('tCode');
			$aResult 	= $this->mPermission->FSaMPERGetDataPermissionBYID($tCode);;
		}

		$aPackData = array(
			'tTypePage' 		=> $tTypePage,
			'aResult'			=> $aResult,
			'aMenuAll'			=> $this->mPermission->FSaMPERGetMenuAll(),
		);
		$this->load->view('user/permission/wPermissionAdd',$aPackData);
	}

	//เพิ่มกลุ่มสิทธิ์
	public function FSwCPEREventInsert(){
		$nRoleID 		= $this->input->post('nRoleID');
		$tRoleName 		= $this->input->post('tRoleName');
		$tRoleReason 	= $this->input->post('tRoleReason');
		$aMenu 			= $this->input->post('aMenu');

		$aLastRoleCode 	= $this->mPermission->FSaMPERGetLastRolecode();
		if($aLastRoleCode['rtCode'] == 800){
			$nRoleCode = 1;
		}else{
			$nRoleCode = $aLastRoleCode['raItems'][0]['FNRhdID'];
			$nRoleCode = $nRoleCode + 1;
		}

		//Insert Role HD
		$aInsHD = array(
			'FNRhdID'		=> $nRoleCode,
			'FTRhdName'		=> $tRoleName,
			'FTRhdRmk'		=> $tRoleReason,
			'FTCreateBy'	=> $this->session->userdata('tSesUsercode'),
			'FDCreateOn'	=> date('Y-m-d H:i:s')
		);
		$this->mPermission->FSxMPERInsertHD($aInsHD);
		
		//Insert Role DT
		$this->mPermission->FSxMPERDeleteDT($nRoleCode);
		for($i=0; $i<count($aMenu); $i++){
			$aInsDT = array(
				'FNRhdID'			=> $nRoleCode,
				'FNMenID'			=> $aMenu[$i]['menu'],
				'FTRdtAlwRead'		=> $aMenu[$i]['read'],
				'FTRdtAlwCreate'	=> $aMenu[$i]['create'],
				'FTRdtAlwDel'		=> $aMenu[$i]['delete'],
				'FTRdtAlwEdit'		=> $aMenu[$i]['edit'],
				'FTRdtAlwCancel'	=> $aMenu[$i]['cancle'],
				'FTRdtAlwApv'		=> $aMenu[$i]['approve'],
				'FTRdtAlwPrint'		=> $aMenu[$i]['print'],
				'FTCreateBy'		=> $this->session->userdata('tSesUsercode'),
				'FDCreateOn'		=> date('Y-m-d H:i:s')		
			);	
			$this->mPermission->FSxMPERInsertDT($aInsDT);
		}

		echo 'pass_insert';
	}

	//แก้ไขกลุ่มสิทธิ์
	public function FSxCPEREventEdit(){
		$nRoleID 		= $this->input->post('nRoleID');
		$tRoleName 		= $this->input->post('tRoleName');
		$tRoleReason 	= $this->input->post('tRoleReason');
		$aMenu 			= $this->input->post('aMenu');

		//Update Role HD
		$aUpdateWhereHD = array(
			'FNRhdID'		=> $nRoleID
		);

		$aUpdateSetHD = array(
			'FTRhdName'		=> $tRoleName,
			'FTRhdRmk'		=> $tRoleReason,
			'FTUpdateBy'	=> $this->session->userdata('tSesUsercode'),
			'FDUpdateOn'	=> date('Y-m-d H:i:s')
		);
		$tt = $this->mPermission->FSxMPERUpdateHD($aUpdateSetHD,$aUpdateWhereHD);
		
		//Insert Role DT
		$this->mPermission->FSxMPERDeleteDT($nRoleID);
		for($i=0; $i<count($aMenu); $i++){
			$aInsDT = array(
				'FNRhdID'			=> $nRoleID,
				'FNMenID'			=> $aMenu[$i]['menu'],
				'FTRdtAlwRead'		=> $aMenu[$i]['read'],
				'FTRdtAlwCreate'	=> $aMenu[$i]['create'],
				'FTRdtAlwDel'		=> $aMenu[$i]['delete'],
				'FTRdtAlwEdit'		=> $aMenu[$i]['edit'],
				'FTRdtAlwCancel'	=> $aMenu[$i]['cancle'],
				'FTRdtAlwApv'		=> $aMenu[$i]['approve'],
				'FTRdtAlwPrint'		=> $aMenu[$i]['print'],
				'FTCreateBy'		=> $this->session->userdata('tSesUsercode'),
				'FDCreateOn'		=> date('Y-m-d H:i:s')		
			);	
			$this->mPermission->FSxMPERInsertDT($aInsDT);
		}

		echo 'pass_update';
	}

	//ลบข้อมูล
	public function FSxCPEREventDelete(){
		$tCode = $this->input->post('ptCode');
		$this->mPermission->FSaMPERDelete($tCode);
	}

}
