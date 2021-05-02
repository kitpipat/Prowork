<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cUser extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('user/user/mUser');
	}

	public function index(){
		$this->load->view('user/user/wUserMain');
	}

	//โหลดข้อมูลผู้ใช้
	public function FSwCUSRLoadDatatable(){
		$nPage = $this->input->post('nPage');
		$aCondition = array(
			'nPage'         => $nPage,
			'nRow'          => 10,
			'tSearchAll'    => $this->input->post('tSearchAll')
		);

		$aUserList = $this->mUser->FSaMUSRGetData($aCondition);
		$aPackData = array(
			'aUserList'	=> $aUserList,
			'nPage'		=> $nPage
		);
		$this->load->view('user/user/wUserDatatable',$aPackData);
	}

	//โหลดหน้าจอเพื่มผู้ใช้ + แก้ไขผู้ใช้
	public function FSwCUSRCallPageInsertorEdit(){
		$tTypePage = $this->input->post('tTypepage');
		if($tTypePage == 'insert'){
			$aResult	= '';
		}else if($tTypePage == 'edit'){
			$tCode 		= $this->input->post('tCode');
			$aResult 	= $this->mUser->FSaMUSRGetDataUserBYID($tCode);
		}

		$aPackData = array(
			'tTypePage' 		=> $tTypePage,
			'aBCHList'			=> $this->mUser->FSaMUSRGetBranch(),
			'aPermissionList'	=> $this->mUser->FSaMUSRGetPermission(),
			'aPriGrp'			=> $this->mUser->FSaMUSRGetPriceGroup(),
			'aResult'			=> $aResult
		);
		$this->load->view('user/user/wUserAdd',$aPackData);
	}

	//อีเว้นท์เพิ่มข้อมูล
	public function FSwCUSREventInsert(){

		$aCheckUserLogin 	= $this->mUser->FSaMUSRCheckUserLogin($this->input->post('oetUserLogin'),'');
		if($aCheckUserLogin['rtCode'] == 1){
			echo 'Duplicate';
		}else{
			$aLastUserCode 	= $this->mUser->FSaMUSRGetLastUsercode();
			if($aLastUserCode['rtCode'] == 800){
				$nUserCode = 1;
			}else{
				$nUserCode = $aLastUserCode['raItems'][0]['FTUsrCode'];
				$nUserCode = $nUserCode + 1;
			}

			$aInsertUser = array(
				'FTUsrCode'			=> $nUserCode,
				'FTBchCode'			=> ($this->input->post('oetUserBCH') == 0) ? null : $this->input->post('oetUserBCH'),
				'FTUsrFName'		=> $this->input->post('oetUserFirstname'),
				'FTUsrLName'		=> $this->input->post('oetUserLastname'),
				'FTUsrDep'			=> $this->input->post('oetUserDepartment'),
				'FTUsrEmail'		=> $this->input->post('oetUserEmail'),
				'FTUsrTel'			=> $this->input->post('oetUserTelphone'),
				'FTUsrLogin'		=> $this->input->post('oetUserLogin'),
				'FTUsrPwd'			=> $this->input->post('oetUserPassword'),
				'FTUsrImgPath'		=> $this->input->post('oetImgInsertorEditUser'),
				'FTUsrRmk'			=> $this->input->post('oetUserReason'),
				'FNRhdID'			=> $this->input->post('oetUserPermission'),
				'FTPriGrpID'		=> $this->input->post('oetUserPriGrp'),
				'FNUsrGrp'			=> $this->input->post('oetUserGrp'),
				'FNStaUse'			=> ($this->input->post('ocmUserStaUse') == 'on') ? 1 : 0,
				'FNStaSysAdmin'		=> 0,
				'FTCreateBy'		=> $this->session->userdata('tSesUsercode'),
				'FDCreateOn'		=> date('Y-m-d H:i:s'),
				'FTUsrPathSignature'=> $this->input->post('hiddenvalue_signature'),
			);
			$this->mUser->FSxMUSRInsert($aInsertUser);
			echo 'pass_insert';
		}
	}

	//ลบผู้ใช้
	public function FSxCUSREventDelete(){
		$tCode = $this->input->post('ptCode');
		$this->mUser->FSaMUSRDelete($tCode);
	}

	//อีเว้นท์แก้ไข
	public function FSxCUSREventEdit(){
		try{

			$aCheckUserLogin 	= $this->mUser->FSaMUSRCheckUserLogin($this->input->post('oetUserLogin'),$this->input->post('ohdUserCode'));
			if($aCheckUserLogin['rtCode'] == 1){
				echo 'Duplicate';
			}else{
				$aSetUpdate = array(
					'FTBchCode'			=> ($this->input->post('oetUserBCH') == 0) ? null : $this->input->post('oetUserBCH'),
					'FTUsrFName'		=> $this->input->post('oetUserFirstname'),
					'FTUsrLName'		=> $this->input->post('oetUserLastname'),
					'FTUsrDep'			=> $this->input->post('oetUserDepartment'),
					'FTUsrEmail'		=> $this->input->post('oetUserEmail'),
					'FTUsrTel'			=> $this->input->post('oetUserTelphone'),
					'FTUsrLogin'		=> $this->input->post('oetUserLogin'),
					'FTUsrPwd'			=> $this->input->post('oetUserPassword'),
					'FTUsrImgPath'		=> $this->input->post('oetImgInsertorEditUser'),
					'FTUsrRmk'			=> $this->input->post('oetUserReason'),
					'FNRhdID'			=> $this->input->post('oetUserPermission'),
					'FTPriGrpID'		=> $this->input->post('oetUserPriGrp'),
					'FNUsrGrp'			=> $this->input->post('oetUserGrp'),
					'FNStaUse'			=> ($this->input->post('ocmUserStaUse') == 'on') ? 1 : 0,
					'FNStaSysAdmin'		=> 0,
					'FTUpdateBy'		=> $this->session->userdata('tSesUsercode'),
					'FDUpdateOn'		=> date('Y-m-d H:i:s'),
					'FTUsrPathSignature'=> $this->input->post('hiddenvalue_signature'),
				);
				$aWhereUpdate = array(
					'FTUsrCode'		 	=> $this->input->post('ohdUserCode')
				);
				$this->mUser->FSxMUSUpdate($aSetUpdate,$aWhereUpdate);
				echo 'pass_update';
			}
		}catch(Exception $Error){
            echo $Error;
        }
	}

	//upload image
	public function FSvCAdminUploadimage(){
		$tPath = $this->input->post('path');

		if($_FILES['file']['name']!=''){
			if(!is_dir('./application/assets/'.$tPath)){
				mkdir('./application/assets/'.$tPath);
			}
			$tCaracteres = 'ABCDEFGHIJKLMOPQRSTUVXWYZ0123456789';
			$tQuantidadeCaracteres = strlen($tCaracteres);
			$tHash=NULL;
			for($x=1;$x<=10;$x++){
				$tPosicao = rand(0,$tQuantidadeCaracteres);
				$tHash .= substr($tCaracteres,$tPosicao,1);
			}
			$tFilename = 'ImgSignature'.$tHash.date('Ymd');
			$aConfig = array(
				'file_name'     => $tFilename,
				'allowed_types' => '*',
				'upload_path'   => './application/assets/'.$tPath,
				'max_size'      => '1000000',
				'max_width'     => '1024000',
				'max_height'    => '768000',
			);
			$this->load->library('upload');
			$this->upload->initialize($aConfig);
			if(!$this->upload->do_upload('file')){
				$aData = array('error' => $this->upload->display_errors());
			}else{
				$aData = array('upload_data' => $this->upload->data());
				if(!empty($aData['upload_data']['file_name'])){
					$aImageData = $aData['upload_data'];
					$tStaResize = $this->FStCMPImgResize($aImageData);
					if($tStaResize=="done"){
						$tPath     = $aImageData['full_path'];
						$tType     = pathinfo($tPath,PATHINFO_EXTENSION);
						$tDataimg  = file_get_contents($tPath);
						$tbase64 = 'data:image/' . $tType . ';base64,' . base64_encode($tDataimg);
						$raImageData = array(
							'tImgBase64'   => $tbase64,
							'tImgName'     => $aImageData['file_name'],
							'tImgType'     => $aImageData['image_type'],
							'tImgFullPath' => $aImageData['full_path']
						);
					}
				}
				echo json_encode($raImageData);
			}
		}
	}

	//resize
	public function FStCMPImgResize($paImgUL=null){
		$this->load->library('image_lib');
		$config['image_library'] 	= 'gd2';
		$config['source_image'] 	= $paImgUL['full_path'];
		$config['create_thumb'] 	= FALSE;
		$config['maintain_ratio'] 	= TRUE;
		$config['width'] 			= 600;
		$config['height'] 			= 600;
		$this->image_lib->initialize($config);
		if (!$this->image_lib->resize()){
			return $this->image_lib->display_errors();
		} else{
			return "done";
		}
	}

	//cropper
	public function FSvCAdminCropperimage(){
		$tImgBase64 = $this->input->post('tBase64');
		$tImgName = $this->input->post('tImgName');
		$tImgType = $this->input->post('tImgtype');
		$tImgPath = $this->input->post('tImgPath');
		list($tImgType, $tImgBase64) = explode(';', $tImgBase64);
		list(, $tImgBase64)      = explode(',', $tImgBase64);
		$oData = base64_decode($tImgBase64);
		if(!file_put_contents($tImgPath,$oData)){
			echo "Err";
		}else{
			$rtImg   = array(
				'rtBaseurl' => base_url(),
				//'rtPatch'   => 'application/assets/system/tempimage/'.$this->session->tSesUsername.'/',
				'rtImgName' => $tImgName
			);
		}
		echo json_encode($rtImg);
	}
	
	//เอาไว้ทดสอบ จำนวน record ในการแสดงผลของ PDT ว่าแสดงถูกต้องไหม
	public function FSxGenrecordfordemopdt(){
		$t = $this->input->post('oetQtyReport');
		for($i=0; $i<$t; $i++){
			$this->mUser->Genrecordfordemopdt($i);
		}
	}


}
